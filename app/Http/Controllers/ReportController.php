<?php

namespace App\Http\Controllers;

use App\Models\TemporaryRegistration;
use App\Models\PermanentRegistration;
use App\Models\AdditionalQualification;
use App\Models\ForeignCertificate;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

class ReportController extends Controller
{
    /**
     * Show report selection index.
     */
    public function index()
    {
        return view('reports.index');
    }

    /**
     * Generate the requested report.
     */
    public function generate(Request $request)
    {
        $validated = $request->validate([
            'module' => 'required|in:temporary,permanent,qualifications,foreign',
            'period' => 'required|in:daily,monthly,yearly',
            'report_date' => 'required|date',
        ]);

        $module = $validated['module'];
        $period = $validated['period'];
        $date = Carbon::parse($validated['report_date']);

        $data = [];
        $title = '';

        switch ($module) {
            case 'temporary':
                $query = TemporaryRegistration::with('nurse');
                $dateColumn = 'temp_registration_date';
                $title = 'Temporary Registrations Report';
                break;
            case 'permanent':
                $query = PermanentRegistration::with('nurse');
                $dateColumn = 'perm_registration_date';
                $title = 'Permanent Registrations Report';
                break;
            case 'qualifications':
                $query = AdditionalQualification::with('nurse');
                $dateColumn = 'qualification_date';
                $title = 'Additional Qualifications Report';
                break;
            case 'foreign':
                $query = ForeignCertificate::with('nurse');
                $dateColumn = 'apply_date';
                $title = 'Foreign Certificates Report';
                break;
        }

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

        $pdf = Pdf::loadView('reports.pdf', compact('records', 'title', 'module'))
            ->setPaper('a4', 'landscape');

        \App\Models\ReportLog::create([
            'module' => $module,
            'period' => $period,
        ]);

        return $pdf->stream('report_' . $module . '_' . $period . '_' . $date->format('Ymd') . '.pdf');
    }
}
