<?php

namespace App\Http\Controllers;

use App\Models\PermanentRegistration;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class PermanentCertificateController extends Controller
{
    /**
     * Display a listing of nurses eligible for permanent certificate printing.
     */
    public function index(Request $request)
    {
        $query = PermanentRegistration::with('nurse');

        if ($request->filled('nic')) {
            $nic = $request->input('nic');
            $query->whereHas('nurse', function ($q) use ($nic) {
                $q->where('nic', 'like', '%' . $nic . '%');
            });
        }

        $registrations = $query->latest()->paginate(10)->withQueryString();

        return view('permanent_certificates.index', compact('registrations'));
    }

    /**
     * Update the printed/posted status.
     */
    public function updateStatus(Request $request, int $id)
    {
        $registration = PermanentRegistration::findOrFail($id);

        $validated = $request->validate([
            'certificate_printed' => 'boolean',
            'certificate_posted' => 'boolean',
        ]);

        $registration->certificate_printed = $request->boolean('certificate_printed');
        $registration->certificate_posted = $request->boolean('certificate_posted');
        $registration->save();

        return back()->with('success', 'Certificate status updated successfully.');
    }

    /**
     * Generate the permanent registration certificate PDF.
     */
    public function printPdf(int $id)
    {
        $registration = PermanentRegistration::with('nurse')->findOrFail($id);

        // Mark as printed automatically upon generation
        $registration->certificate_printed = true;
        // You might want to track printed_at timestamp, but standard req just says boolean. Let's stick to boolean.
        $registration->save();

        $pdf = Pdf::loadView('permanent_certificates.pdf', compact('registration'))
            ->setPaper('a4', 'portrait');

        $filename = 'SLNC-PERM-CERT-' . date('Y') . '-' . str_pad($registration->id, 4, '0', STR_PAD_LEFT) . '.pdf';

        return $pdf->stream($filename);
    }
}
