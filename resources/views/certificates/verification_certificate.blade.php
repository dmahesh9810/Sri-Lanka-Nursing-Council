<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Certificate of Verification</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: "Times New Roman", Times, serif;
            font-size: 13pt;
            color: #1a1a2e;
            background: #fff;
        }

        .page {
            width: 210mm;
            min-height: 297mm;
            padding: 18mm 18mm 14mm 18mm;
            position: relative;
        }

        /* ── Decorative border ────────────────────────────── */
        .border-outer {
            border: 4px double #003366;
            padding: 12mm 12mm 10mm 12mm;
            min-height: 265mm;
            position: relative;
        }
        .border-inner {
            border: 1px solid #003366;
            padding: 8mm 10mm 8mm 10mm;
            min-height: 249mm;
        }

        /* ── Organisation Header ──────────────────────────── */
        .org-header { text-align: center; margin-bottom: 18pt; border-bottom: 2px solid #003366; padding-bottom: 12pt; }
        .org-emblem { font-size: 30pt; color: #003366; }
        .org-name   { font-size: 14pt; font-weight: bold; color: #003366; letter-spacing: 1px; text-transform: uppercase; }
        .org-sub    { font-size: 9pt;  color: #555; margin-top: 2pt; }

        /* ── Certificate Title ────────────────────────────── */
        .cert-title-block { text-align: center; margin-bottom: 14pt; }
        .cert-type-label  { font-size: 10pt; text-transform: uppercase; letter-spacing: 3px; color: #555; }
        .cert-title       { font-size: 22pt; font-weight: bold; color: #003366; text-transform: uppercase; letter-spacing: 2px; margin: 4pt 0; }
        .cert-underline   { width: 80mm; border-bottom: 2px solid #003366; margin: 4pt auto 0 auto; }

        /* ── Meta (Cert # + Date) ─────────────────────────── */
        .cert-meta {
            display: table;
            width: 100%;
            margin-bottom: 16pt;
            font-size: 9.5pt;
        }
        .cert-meta-left  { display: table-cell; text-align: left;  color: #555; }
        .cert-meta-right { display: table-cell; text-align: right; color: #555; }

        /* ── Introductory text ────────────────────────────── */
        .intro-text {
            text-align: center;
            font-size: 11pt;
            margin-bottom: 14pt;
            color: #333;
            font-style: italic;
        }

        /* ── Details Table ────────────────────────────────── */
        .details-table { width: 100%; border-collapse: collapse; margin-bottom: 16pt; }
        .details-table td { padding: 6pt 4pt; vertical-align: top; font-size: 11.5pt; }
        .details-table .lbl { width: 42%; color: #555; font-weight: normal; padding-left: 8pt; }
        .details-table .sep { width: 4%;  text-align: center; }
        .details-table .val { width: 54%; font-weight: bold; color: #1a1a2e; }
        .details-table tr { border-bottom: 1px dotted #ccc; }

        /* ── Certification text ────────────────────────────── */
        .cert-body {
            text-align: justify;
            font-size: 11pt;
            line-height: 1.7;
            margin-bottom: 18pt;
            color: #222;
        }

        /* ── Signatures ───────────────────────────────────── */
        .signature-section {
            display: table;
            width: 100%;
            margin-top: 24pt;
        }
        .sig-block {
            display: table-cell;
            width: 33%;
            text-align: center;
            vertical-align: bottom;
            padding: 0 8pt;
        }
        .sig-line  { border-top: 1px solid #333; margin-bottom: 4pt; margin-top: 30pt; }
        .sig-name  { font-size: 10pt; font-weight: bold;   }
        .sig-title { font-size: 9pt;  color: #555; font-style: italic; }

        /* ── Official Seal ─────────────────────────────────── */
        .seal-area {
            text-align: center;
            margin-top: 10pt;
            font-size: 9pt;
            color: #888;
            border: 2px dashed #ccc;
            padding: 12pt;
            width: 52mm;
            margin-left: auto;
            margin-right: auto;
        }

        /* ── Footer ─────────────────────────────────────────── */
        .footer {
            text-align: center;
            font-size: 8pt;
            color: #888;
            border-top: 1px solid #ccc;
            padding-top: 6pt;
            margin-top: 14pt;
        }
    </style>
</head>
<body>
<div class="page">
<div class="border-outer">
<div class="border-inner">

    <!-- Organisation Header -->
    <div class="org-header">
        <div class="org-emblem">&#9670;</div>
        <div class="org-name">Sri Lanka Nursing Council</div>
        <div class="org-sub">Ministry of Health &bull; Established under the Nurses Ordinance No. 33 of 1953</div>
    </div>

    <!-- Certificate Title -->
    <div class="cert-title-block">
        <div class="cert-type-label">Official Document</div>
        <div class="cert-title">Certificate of Verification</div>
        <div class="cert-underline"></div>
    </div>

    <!-- Certificate Number & Issue Date -->
    <div class="cert-meta">
        <div class="cert-meta-left">
            <strong>Certificate No:</strong> {{ $cert->certificate_number }}
        </div>
        <div class="cert-meta-right">
            <strong>Issue Date:</strong>
            {{ \Carbon\Carbon::parse($cert->issue_date)->format('d F Y') }}
        </div>
    </div>

    <!-- Introductory Text -->
    <div class="intro-text">
        This is to certify that the following nurse is duly registered with the Sri Lanka Nursing Council
        and all particulars have been duly verified.
    </div>

    <!-- Nurse Details -->
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

    <!-- Certification Body Text -->
    <div class="cert-body">
        This certificate is issued by the Sri Lanka Nursing Council upon official request to verify the nursing
        registration status of the above-named individual. The nurse named herein is registered and in good
        professional standing as per the official records maintained by the Council. This certificate is valid
        for official use in the stated destination country only and should not be used for any other purpose.
    </div>

    <!-- Signatures -->
    <div class="signature-section">
        <div class="sig-block">
            <div class="sig-line"></div>
            <div class="sig-name">Registrar</div>
            <div class="sig-title">Sri Lanka Nursing Council</div>
        </div>
        <div class="sig-block">
            <!-- Official Seal -->
            <div class="seal-area">
                Official Seal<br>Sri Lanka Nursing Council
            </div>
        </div>
        <div class="sig-block">
            <div class="sig-line"></div>
            <div class="sig-name">Director General of Health</div>
            <div class="sig-title">Ministry of Health, Sri Lanka</div>
        </div>
    </div>

    <!-- Footer -->
    <div class="footer">
        Sri Lanka Nursing Council &bull; No. 555, Elvitigala Mawatha, Narahenpita, Colombo 05 &bull; Tel: +94 11 2368150
        &bull; Certificate No: {{ $cert->certificate_number }}
    </div>

</div><!-- /.border-inner -->
</div><!-- /.border-outer -->
</div><!-- /.page -->
</body>
</html>
