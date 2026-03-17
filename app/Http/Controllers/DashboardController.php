<?php

namespace App\Http\Controllers;

use App\Models\AdditionalQualification;
use App\Models\ForeignCertificate;
use App\Models\Nurse;
use App\Models\PermanentRegistration;
use App\Models\TemporaryRegistration;
use App\Models\ReportLog;
use App\Models\ActivityLog;

class DashboardController extends Controller
{
    public function index()
    {
        \Illuminate\Support\Facades\Log::info('Dashboard Access Attempt:', [
            'user' => auth()->user()->email,
            'role' => auth()->user()->role
        ]);
        $stats = [
            'total_nurses' => Nurse::count(),
            'total_temporary' => TemporaryRegistration::count(),
            'total_permanent' => PermanentRegistration::count(),
            'total_qualifications' => AdditionalQualification::count(),
            'total_foreign_certificates' => ForeignCertificate::count(),
            'total_printed' => ForeignCertificate::whereNotNull('printed_at')->count(),
            'total_perm_certificates_printed' => PermanentRegistration::where('certificate_printed', true)->count(),
            'total_reports_generated' => ReportLog::count(),
        ];

        $driver = \Illuminate\Support\Facades\DB::connection()->getDriverName();
        if ($driver === 'sqlite') {
            $monthSelect = "strftime('%m', created_at) as month";
            $monthNameSelect = "strftime('%m', created_at) as month_name"; // SQLite has no MONTHNAME, just returning month number as proxy string or you could map it
            $groupBy = "strftime('%m', created_at)";
        } else {
            $monthSelect = "MONTH(created_at) as month";
            $monthNameSelect = "MONTHNAME(created_at) as month_name";
            $groupBy = "MONTH(created_at), MONTHNAME(created_at)";
        }

        // Chart 1: Monthly Temporary Registrations (Last 12 Months)
        $monthlyTempData = TemporaryRegistration::selectRaw("$monthSelect, $monthNameSelect, count(*) as count")
            ->where('created_at', '>=', now()->subMonths(12))
            ->groupByRaw($groupBy)
            ->orderByRaw('MIN(created_at)')
            ->get();

        $charts['temp_labels'] = $monthlyTempData->pluck('month_name');
        $charts['temp_data'] = $monthlyTempData->pluck('count');

        // Chart 2: Monthly Permanent Registrations (Last 12 Months)
        $monthlyPermData = PermanentRegistration::selectRaw("$monthSelect, $monthNameSelect, count(*) as count")
            ->where('created_at', '>=', now()->subMonths(12))
            ->groupByRaw($groupBy)
            ->orderByRaw('MIN(created_at)')
            ->get();

        $charts['perm_labels'] = $monthlyPermData->pluck('month_name');
        $charts['perm_data'] = $monthlyPermData->pluck('count');

        // Chart 3: Foreign Certificates by Country
        $countryData = ForeignCertificate::selectRaw('country, count(*) as count')
            ->groupBy('country')
            ->orderByDesc('count')
            ->limit(10)
            ->get();

        $charts['country_labels'] = $countryData->pluck('country');
        $charts['country_data'] = $countryData->pluck('count');

        // Chart 4: Certificates Printed vs Pending (Foreign)
        $printedCount = $stats['total_printed'];
        $pendingCount = $stats['total_foreign_certificates'] - $printedCount;
        
        $charts['cert_status_labels'] = collect(['Printed', 'Pending']);
        $charts['cert_status_data'] = collect([$printedCount, $pendingCount]);

        // Recent Activity
        $recentActivities = ActivityLog::with('user')->latest()->limit(10)->get();

        return view('dashboard.index', compact('stats', 'charts', 'recentActivities'));
    }
}
