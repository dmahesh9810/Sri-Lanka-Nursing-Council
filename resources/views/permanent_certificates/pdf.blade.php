<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Permanent Registration Certificate</title>
    <style>
        body { font-family: "Times New Roman", Times, serif; }
        .certificate-container { border: 10px double #0d6efd; padding: 40px; text-align: center; }
        .header { margin-bottom: 30px; }
        .header h1 { color: #003366; text-transform: uppercase; font-size: 28px; }
        .header h2 { font-size: 22px; color: #555; }
        .content { font-size: 18px; line-height: 1.6; margin-bottom: 40px; }
        .nurse-name { font-size: 24px; font-weight: bold; margin: 20px 0; text-decoration: underline; }
        .footer { margin-top: 50px; display: table; width: 100%; }
        .signature { display: table-cell; width: 50%; text-align: center; font-size: 16px; }
        .signature span { display: block; margin-top: 10px; border-top: 1px solid #000; padding-top: 5px; width: 80%; margin-left: auto; margin-right: auto; }
        .cert-number { text-align: right; font-size: 12px; color: #777; margin-bottom: 10px; }
    </style>
</head>
<body>
    <div class="certificate-container">
        
        <div class="cert-number">
            Cert No: SLNC-PERM-CERT-{{ date('Y') }}-{{ str_pad($registration->id, 4, '0', STR_PAD_LEFT) }}<br>
            Reg No: {{ $registration->perm_registration_no }}<br>
            Date: {{ \Carbon\Carbon::parse($registration->perm_registration_date)->format('F d, Y') }}
        </div>

        <div style="text-align: right; margin-bottom: 20px;">
            @php
                $qrData = "Reg No: {$registration->perm_registration_no}\nName: " . ($registration->nurse->name ?? '') . "\nNIC: " . ($registration->nurse->nic ?? '');
            @endphp
            <img src="data:image/svg+xml;base64,{{ base64_encode(\SimpleSoftwareIO\QrCode\Facades\QrCode::format('svg')->size(100)->generate($qrData)) }}" width="100" height="100">
        </div>

        <div class="header">
            <h1>Sri Lanka Nursing Council</h1>
            <h2>Permanent Registration Certificate</h2>
        </div>

        <div class="content">
            <p>This is to certify that</p>
            <div class="nurse-name">{{ $registration->nurse->name ?? 'N/A' }}</div>
            <p>bearing NIC number <strong>{{ $registration->nurse->nic ?? 'N/A' }}</strong></p>
            <p>has been duly registered under the permanent registry of the Sri Lanka Nursing Council.</p>
            
            <table style="width: 100%; margin-top: 30px; text-align: left; background: #f9f9f9; padding: 15px;">
                <tr>
                    <td style="padding: 5px 0;"><strong>Temporary Reg No:</strong></td>
                    <td>{{ $registration->nurse->temporaryRegistration ? $registration->nurse->temporaryRegistration->temp_registration_no : 'N/A' }}</td>
                </tr>
                <tr>
                    <td style="padding: 5px 0;"><strong>Temporary Reg Date:</strong></td>
                    <td>{{ $registration->nurse->temporaryRegistration ? \Carbon\Carbon::parse($registration->nurse->temporaryRegistration->temp_registration_date)->format('F d, Y') : 'N/A' }}</td>
                </tr>
                <tr>
                    <td style="padding: 5px 0;"><strong>SLMC Date:</strong></td>
                    <td>{{ $registration->slmc_date ? \Carbon\Carbon::parse($registration->slmc_date)->format('F d, Y') : 'N/A' }}</td>
                </tr>
            </table>

        </div>

        <div class="footer">
            <div class="signature">
                <br><br><br>
                <span>Registrar</span>
                <p>Sri Lanka Nursing Council</p>
            </div>
            <div class="signature">
                <br><br><br>
                <span>President</span>
                <p>Sri Lanka Nursing Council</p>
            </div>
        </div>

    </div>
</body>
</html>
