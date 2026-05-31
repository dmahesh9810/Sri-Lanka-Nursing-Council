<?php

namespace App\Http\Controllers;

use App\Models\TemporaryRegistration;
use App\Models\PermanentRegistration;
use App\Models\AdditionalQualification;
use App\Models\ForeignCertificate;
use App\Models\ReportLog;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

class ReportController extends Controller
{
    /**
     * Module label map used for display purposes.
     */
    private const MODULE_LABELS = [
        'temporary'      => 'Temporary Registrations',
        'permanent'      => 'Permanent Registrations',
        'qualifications' => 'Additional Qualifications',
        'foreign'        => 'Foreign Certificates',
    ];

    /**
     * Show report selection index — only allowed modules are passed to the view.
     */
    public function index()
    {
        $user          = auth()->user();
        $allowedSlugs  = $user->allowedReportModules();

        // Build a label-keyed array: ['temporary' => 'Temporary Registrations', ...]
        $allowedModules = array_intersect_key(self::MODULE_LABELS, array_flip($allowedSlugs));

        return view('reports.index', compact('allowedModules'));
    }

    /**
     * Generate the requested report PDF.
     *
     * Security:  the submitted module is validated against the user's
     * allowedReportModules() list at the controller level — frontend-only
     * restrictions are NOT sufficient and intentionally NOT relied on here.
     */
    public function generate(Request $request)
    {
        // Step 1 – basic format validation
        $validated = $request->validate([
            'module'     => 'required|string',
            'start_date' => 'required|date',
            'end_date'   => 'required|date|after_or_equal:start_date',
            'format'     => 'nullable|in:pdf,excel',
        ]);

        $module    = $validated['module'];
        $startDate = Carbon::parse($validated['start_date'])->startOfDay();
        $endDate   = Carbon::parse($validated['end_date'])->endOfDay();

        // Step 2 – role-level authorization: abort if module not allowed for this user
        $user = auth()->user();
        if (! in_array($module, $user->allowedReportModules(), true)) {
            abort(403, 'You are not authorized to generate this report.');
        }

        // Step 3 – build the query based on the verified module
        [$query, $dateColumn, $title] = match ($module) {
            'temporary'      => [
                TemporaryRegistration::with('nurse'),
                'temp_registration_date',
                'Temporary Registrations Report',
            ],
            'permanent'      => [
                PermanentRegistration::with('nurse'),
                'perm_registration_date',
                'Permanent Registrations Report',
            ],
            'qualifications' => [
                AdditionalQualification::with('nurse'),
                'qualification_date',
                'Additional Qualifications Report',
            ],
            'foreign'        => [
                ForeignCertificate::with('nurse'),
                'apply_date',
                'Foreign Certificates Report',
            ],
            // Any unlisted value (belt-and-suspenders, should never reach here):
            default => abort(403, 'Invalid report module.'),
        };

        // Step 4 – apply date range filter
        $query->whereBetween($dateColumn, [$startDate, $endDate]);
        $title .= ' (' . $startDate->format('Y-m-d') . ' to ' . $endDate->format('Y-m-d') . ')';

        $records = $query->get();

        // Step 5 – generate output
        $format = $validated['format'] ?? 'pdf';

        if ($format === 'excel') {
            $filename = 'report_' . $module . '_' . $startDate->format('Ymd') . '_to_' . $endDate->format('Ymd') . '.csv';

            ReportLog::create([
                'user_id' => $user->id,
                'module'  => $module,
                'period'  => 'custom',
            ]);

            $headers = [
                "Content-type"        => "text/csv",
                "Content-Disposition" => "attachment; filename=$filename",
                "Pragma"              => "no-cache",
                "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
                "Expires"             => "0"
            ];

            $callback = function() use($records, $module) {
                $file = fopen('php://output', 'w');

                if ($module === 'temporary') {
                    fputcsv($file, ['Temp Reg No', 'Date', 'Name', 'NIC', 'Phone', 'Address', 'DOB', 'Gender', 'School/University', 'Batch', 'Grade', 'Workplace']);
                    foreach ($records as $record) {
                        fputcsv($file, [
                            $record->temp_registration_no,
                            $record->temp_registration_date,
                            $record->nurse->name ?? '',
                            $record->nurse->nic ?? '',
                            $record->nurse->phone ?? '',
                            $record->nurse->address ?? '',
                            $record->nurse->date_of_birth ?? '',
                            $record->nurse->gender ?? '',
                            $record->nurse->school_or_university ?? '',
                            $record->nurse->batch ?? '',
                            $record->grade ?? '',
                            $record->present_workplace ?? ''
                        ]);
                    }
                } elseif ($module === 'permanent') {
                    fputcsv($file, ['Perm Reg No', 'Date', 'Name', 'NIC', 'Phone', 'Address', 'DOB', 'Gender', 'School/University', 'Batch', 'SLMC No', 'SLMC Date', 'Grade', 'Workplace']);
                    foreach ($records as $record) {
                        fputcsv($file, [
                            $record->perm_registration_no,
                            $record->perm_registration_date,
                            $record->nurse->name ?? '',
                            $record->nurse->nic ?? '',
                            $record->nurse->phone ?? '',
                            $record->nurse->address ?? '',
                            $record->nurse->date_of_birth ?? '',
                            $record->nurse->gender ?? '',
                            $record->nurse->permanentRegistration->school_university ?? $record->nurse->school_or_university ?? '',
                            $record->nurse->permanentRegistration->batch ?? $record->nurse->batch ?? '',
                            $record->slmc_no ?? '',
                            $record->slmc_date ?? '',
                            $record->grade ?? '',
                            $record->present_workplace ?? ''
                        ]);
                    }
                } elseif ($module === 'qualifications') {
                    fputcsv($file, ['Qualification Type', 'Qualification No', 'Date', 'Name', 'NIC', 'Phone', 'Address']);
                    foreach ($records as $record) {
                        fputcsv($file, [
                            $record->qualification_type,
                            $record->qualification_number,
                            $record->qualification_date,
                            $record->nurse->name ?? '',
                            $record->nurse->nic ?? '',
                            $record->nurse->phone ?? '',
                            $record->nurse->address ?? ''
                        ]);
                    }
                } elseif ($module === 'foreign') {
                    fputcsv($file, ['Certificate Type', 'Country', 'Date', 'Sealed', 'Printed', 'Name', 'NIC', 'Phone', 'Address']);
                    foreach ($records as $record) {
                        fputcsv($file, [
                            $record->certificate_type,
                            $record->country,
                            $record->apply_date,
                            $record->certificate_sealed ? 'Yes' : 'No',
                            $record->certificate_printed ? 'Yes' : 'No',
                            $record->nurse->name ?? '',
                            $record->nurse->nic ?? '',
                            $record->nurse->phone ?? '',
                            $record->nurse->address ?? ''
                        ]);
                    }
                }

                fclose($file);
            };

            return response()->stream($callback, 200, $headers);
        }

        // Generate PDF
        $pdf = Pdf::loadView('reports.pdf', compact('records', 'title', 'module'))
            ->setPaper('a4', 'landscape');

        // Step 6 – audit log (includes user_id for traceability)
        ReportLog::create([
            'user_id' => $user->id,
            'module'  => $module,
            'period'  => 'custom',
        ]);

        return $pdf->stream('report_' . $module . '_' . $startDate->format('Ymd') . '_to_' . $endDate->format('Ymd') . '.pdf');
    }
}
