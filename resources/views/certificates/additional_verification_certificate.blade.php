<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Additional Verification Certificate</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        @page {
            size: A4 portrait;
            margin: 20mm;
        }
        body { font-family: "Times New Roman", Times, serif; font-size: 13pt; color: #1a1a2e; background: #fff; margin:0; padding:0; }
        .page { width: 100%; position: relative; }
        .border-outer { border: 4px double #7b3300; padding: 10mm; min-height: 230mm; position: relative; }
        .border-inner { border: 1px solid #7b3300; padding: 8mm; min-height: 210mm; }
        .org-header { text-align: center; margin-bottom: 18pt; border-bottom: 2px solid #7b3300; padding-bottom: 12pt; }
        .org-emblem { font-size: 30pt; color: #7b3300; }
        .org-name   { font-size: 14pt; font-weight: bold; color: #7b3300; letter-spacing: 1px; text-transform: uppercase; }
        .org-sub    { font-size: 9pt;  color: #555; margin-top: 2pt; }
        .cert-title-block { text-align: center; margin-bottom: 14pt; }
        .cert-type-label  { font-size: 10pt; text-transform: uppercase; letter-spacing: 3px; color: #555; }
        .cert-title       { font-size: 20pt; font-weight: bold; color: #7b3300; text-transform: uppercase; letter-spacing: 2px; margin: 4pt 0; }
        .cert-underline   { width: 80mm; border-bottom: 2px solid #7b3300; margin: 4pt auto 0 auto; }
        .cert-meta { display: table; width: 100%; margin-bottom: 16pt; font-size: 9.5pt; }
        .cert-meta-left  { display: table-cell; text-align: left;  color: #555; }
        .cert-meta-right { display: table-cell; text-align: right; color: #555; }
        .intro-text { text-align: center; font-size: 11pt; margin-bottom: 14pt; color: #333; font-style: italic; }
        .details-table { width: 100%; border-collapse: collapse; margin-bottom: 16pt; }
        .details-table td { padding: 6pt 4pt; vertical-align: top; font-size: 11.5pt; }
        .details-table .lbl { width: 42%; color: #555; padding-left: 8pt; }
        .details-table .sep { width: 4%; text-align: center; }
        .details-table .val { width: 54%; font-weight: bold; color: #1a1a2e; }
        .details-table tr { border-bottom: 1px dotted #ccc; }
        .cert-body { text-align: justify; font-size: 11pt; line-height: 1.7; margin-bottom: 18pt; color: #222; }
        .signature-section { display: table; width: 100%; margin-top: 24pt; }
        .sig-block { display: table-cell; width: 33%; text-align: center; vertical-align: bottom; padding: 0 8pt; }
        .sig-line  { border-top: 1px solid #333; margin-bottom: 4pt; margin-top: 30pt; }
        .sig-name  { font-size: 10pt; font-weight: bold; }
        .sig-title { font-size: 9pt;  color: #555; font-style: italic; }
        .seal-area { text-align: center; margin-top: 10pt; font-size: 9pt; color: #888; border: 2px dashed #ccc; padding: 12pt; width: 52mm; margin-left: auto; margin-right: auto; }
        .footer { text-align: center; font-size: 8pt; color: #888; border-top: 1px solid #ccc; padding-top: 6pt; margin-top: 14pt; }
    </style>
</head>
<body>
<div class="page">
<div class="border-outer">
<div class="border-inner">

    <div class="org-header">
        <div class="org-emblem">&#9670;</div>
        <div class="org-name">Sri Lanka Nursing Council</div>
        <div class="org-sub">Ministry of Health &bull; Established under the Nurses Ordinance No. 33 of 1953</div>
    </div>

    <div class="cert-title-block">
        <div class="cert-type-label">Official Document</div>
        <div class="cert-title">Additional Verification Certificate</div>
        <div class="cert-underline"></div>
    </div>

    <div class="cert-meta">
        <div class="cert-meta-left">
            <strong>Certificate No:</strong> {{ $cert->certificate_number }}
        </div>
        <div class="cert-meta-right">
            <strong>Issue Date:</strong> {{ \Carbon\Carbon::parse($cert->issue_date)->format('d F Y') }}
        </div>
    </div>

    <div class="intro-text">
        This additional verification certificate is issued at the request of the authority in the
        destination country in order to supplement the primary registration documentation of the
        following registered nurse.
    </div>

    <table class="details-table">
        <tr>
            <td class="lbl">Full Name</td>
            <td class="sep">:</td>
            <td class="val">{{ strtoupper($cert->nurse->name) }}</td>
        </tr>
        <tr>
            <td class="lbl">National Identity Card No.</td>
            <td class="sep">:</td>
            <td class="val">{{ $cert->nurse->nic }}</td>
        </tr>
        <tr>
            <td class="lbl">Permanent Registration No.</td>
            <td class="sep">:</td>
            <td class="val">{{ optional($cert->nurse->permanentRegistration)->perm_registration_no ?? 'N/A' }}</td>
        </tr>
        <tr>
            <td class="lbl">Certificate Type</td>
            <td class="sep">:</td>
            <td class="val">{{ $cert->certificate_type }}</td>
        </tr>
        <tr>
            <td class="lbl">Destination Country</td>
            <td class="sep">:</td>
            <td class="val">{{ $cert->country }}</td>
        </tr>
        <tr>
            <td class="lbl">Date of Application</td>
            <td class="sep">:</td>
            <td class="val">{{ \Carbon\Carbon::parse($cert->apply_date)->format('d F Y') }}</td>
        </tr>
    </table>

    <div class="cert-body">
        This Additional Verification Certificate is issued by the Sri Lanka Nursing Council as a
        supplementary document in addition to the primary nursing registration certificate, upon
        request by the relevant authority in the destination country. The Council confirms that all
        particulars contained herein have been cross-checked and verified against official records.
        This document is valid solely for the purpose stated and for the destination country mentioned above.
    </div>

    <div class="signature-section">
        <div class="sig-block">
            <div class="sig-line"></div>
            <div class="sig-name">Registrar</div>
            <div class="sig-title">Sri Lanka Nursing Council</div>
        </div>
        <div class="sig-block">
            <div class="seal-area">Official Seal<br>Sri Lanka Nursing Council</div>
        </div>
        <div class="sig-block">
            <div class="sig-line"></div>
            <div class="sig-name">Director General of Health</div>
            <div class="sig-title">Ministry of Health, Sri Lanka</div>
        </div>
    </div>

    <div class="footer">
        Sri Lanka Nursing Council &bull; No. 555, Elvitigala Mawatha, Narahenpita, Colombo 05 &bull; Tel: +94 11 2368150
        &bull; Certificate No: {{ $cert->certificate_number }}
    </div>

</div></div></div>
</body>
</html>
