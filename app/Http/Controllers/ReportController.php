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
            'module'      => 'required|string',
            'period'      => 'required|in:daily,monthly,yearly',
            'report_date' => 'required|date',
        ]);

        $module = $validated['module'];
        $period = $validated['period'];
        $date   = Carbon::parse($validated['report_date']);

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

        // Step 4 – apply period filter
        if ($period === 'daily') {
            $query->whereDate($dateColumn, $date->format('Y-m-d'));
            $title .= ' - ' . $date->format('F d, Y');
        } elseif ($period === 'monthly') {
            $query->whereYear($dateColumn, $date->year)
                  ->whereMonth($dateColumn, $date->month);
            $title .= ' - ' . $date->format('F Y');
        } elseif ($period === 'yearly') {
            $query->whereYear($dateColumn, $date->year);
            $title .= ' - ' . $date->format('Y');
        }

        $records = $query->get();

        // Step 5 – generate PDF
        $pdf = Pdf::loadView('reports.pdf', compact('records', 'title', 'module'))
            ->setPaper('a4', 'landscape');

        // Step 6 – audit log (includes user_id for traceability)
        ReportLog::create([
            'user_id' => $user->id,
            'module'  => $module,
            'period'  => $period,
        ]);

        return $pdf->stream('report_' . $module . '_' . $period . '_' . $date->format('Ymd') . '.pdf');
    }
}
