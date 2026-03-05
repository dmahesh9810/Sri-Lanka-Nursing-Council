<?php

namespace App\Http\Controllers;

use App\Models\ForeignCertificate;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class CertificateController extends Controller
{
    /**
     * Generate and stream (or download) an official certificate PDF.
     */
    public function generate(Request $request, int $id)
    {
        // Eager-load nurse and their permanent registration
        $cert = ForeignCertificate::with(['nurse', 'nurse.permanentRegistration'])
            ->findOrFail($id);

        // ── Security Validation ─────────────────────────────────────────────
        if (!$cert->certificate_sealed || is_null($cert->issue_date)) {
            return redirect()
                ->route('foreign-certificates.show', $cert)
                ->with('error', 'Certificate cannot be printed until it is sealed and issued.');
        }

        // ── Unique Certificate Number ────────────────────────────────────────
        if (empty($cert->certificate_number)) {
            $cert->certificate_number = $this->generateCertificateNumber($cert->id);
        }

        // ── Resolve Blade Template ───────────────────────────────────────────
        $template = $this->resolveTemplate($cert->certificate_type);

        // ── Mark as Printed ──────────────────────────────────────────────────
        $cert->certificate_printed = true;
        $cert->printed_at = now();
        $cert->save();

        // ── Generate PDF ─────────────────────────────────────────────────────
        $pdf = Pdf::loadView($template, ['cert' => $cert])
            ->setPaper('a4', 'portrait');

        $filename = 'certificate_' . strtolower(str_replace(' ', '_', $cert->certificate_type))
            . '_' . $cert->id . '.pdf';

        // Support ?action=download for forced download; default is inline preview
        if ($request->query('action') === 'download') {
            return $pdf->download($filename);
        }

        return $pdf->stream($filename);
    }

    // ────────────────────────────────────────────────────────────────────────
    // Helpers
    // ────────────────────────────────────────────────────────────────────────

    /**
     * Generate a unique certificate number: SLNC-CERT-{YEAR}-{XXXX}
     */
    private function generateCertificateNumber(int $id): string
    {
        $year = now()->year;
        $sequence = str_pad($id, 4, '0', STR_PAD_LEFT);

        return "SLNC-CERT-{$year}-{$sequence}";
    }

    /**
     * Map certificate_type enum value → Blade view path.
     */
    private function resolveTemplate(string $certificateType): string
    {
        return match ($certificateType) {
                'Good Standing' => 'certificates.good_standing_certificate',
                'Confirmation' => 'certificates.confirmation_certificate',
                'Additional Verification' => 'certificates.additional_verification_certificate',
                default => 'certificates.verification_certificate', // Verification
            };
    }
}
