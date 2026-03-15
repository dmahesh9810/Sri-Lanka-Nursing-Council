<?php

namespace App\Http\Controllers;

use App\Models\AdditionalQualification;
use App\Models\ForeignCertificate;
use App\Models\Nurse;
use App\Models\PermanentRegistration;
use App\Models\TemporaryRegistration;
use App\Models\ReportLog;

class DashboardController extends Controller
{
    public function index()
    {
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

        return view('dashboard.index', compact('stats'));
    }
}
