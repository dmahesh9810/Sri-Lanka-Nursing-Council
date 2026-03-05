<?php

namespace App\Http\Controllers;

use App\Models\AdditionalQualification;
use App\Models\ForeignCertificate;
use App\Models\Nurse;
use App\Models\PermanentRegistration;
use App\Models\TemporaryRegistration;

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
        ];

        return view('dashboard.index', compact('stats'));
    }
}
