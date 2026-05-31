import os, re

dir_path = 'resources/views/certificates'
files = [f for f in os.listdir(dir_path) if f.endswith('.blade.php')]

header_pattern = re.compile(r'<div class="org-sub">Ministry of Health &bull; Established under the Nurses Ordinance No\. 33 of 1953</div>')
qr_replacement = r'''<div class="cert-meta-right">
            <strong>Issue Date:</strong> {{ \Carbon\Carbon::parse($cert->issue_date)->format('d F Y') }}
            <br><br>
            <img src="data:image/png;base64,{{ base64_encode(SimpleSoftwareIO\QrCode\Facades\QrCode::format('png')->size(70)->generate($cert->certificate_number)) }}" alt="QR Code">
        </div>'''
qr_pattern = re.compile(r'<div class="cert-meta-right">.*?</div>', re.DOTALL)

table_pattern = re.compile(r'<table class="details-table">.*?</table>', re.DOTALL)
new_table = r'''<table class="details-table">
        <tr>
            <td class="lbl">Full Name</td>
            <td class="sep">:</td>
            <td class="val">{{ strtoupper($cert->nurse->name) }}</td>
        </tr>
        <tr>
            <td class="lbl">Permanent Address</td>
            <td class="sep">:</td>
            <td class="val">{{ $cert->nurse->address }}</td>
        </tr>
        <tr>
            <td class="lbl">SLNC Reg No.</td>
            <td class="sep">:</td>
            <td class="val">{{ optional($cert->nurse->permanentRegistration)->perm_registration_no ?? 'N/A' }}</td>
        </tr>
        <tr>
            <td class="lbl">SLNC Reg Date</td>
            <td class="sep">:</td>
            <td class="val">
                @if(optional($cert->nurse->permanentRegistration)->perm_registration_date)
                    {{ \Carbon\Carbon::parse($cert->nurse->permanentRegistration->perm_registration_date)->format('d F Y') }}
                @else
                    N/A
                @endif
            </td>
        </tr>
        @if(optional($cert->nurse->permanentRegistration)->slmc_no)
        <tr>
            <td class="lbl">SLMC No.</td>
            <td class="sep">:</td>
            <td class="val">{{ $cert->nurse->permanentRegistration->slmc_no }}</td>
        </tr>
        @endif
        @if(optional($cert->nurse->permanentRegistration)->slmc_date)
        <tr>
            <td class="lbl">SLMC Date</td>
            <td class="sep">:</td>
            <td class="val">{{ \Carbon\Carbon::parse($cert->nurse->permanentRegistration->slmc_date)->format('d F Y') }}</td>
        </tr>
        @endif
        @if(optional($cert->nurse->temporaryRegistration)->temp_registration_no)
        <tr>
            <td class="lbl">Temp Reg No.</td>
            <td class="sep">:</td>
            <td class="val">{{ $cert->nurse->temporaryRegistration->temp_registration_no }}</td>
        </tr>
        @endif
        @if(optional($cert->nurse->temporaryRegistration)->registration_date)
        <tr>
            <td class="lbl">Temp Reg Date</td>
            <td class="sep">:</td>
            <td class="val">{{ \Carbon\Carbon::parse($cert->nurse->temporaryRegistration->registration_date)->format('d F Y') }}</td>
        </tr>
        @endif
        <tr>
            <td class="lbl">Destination Country</td>
            <td class="sep">:</td>
            <td class="val">{{ $cert->country }}</td>
        </tr>
        <tr>
            <td class="lbl">Qualification Type</td>
            <td class="sep">:</td>
            <td class="val">{{ $cert->nurse->professional_qualification ?? 'N/A' }}</td>
        </tr>
    </table>'''

sig_pattern = re.compile(r'<div class="signature-section">.*?<div class="footer">', re.DOTALL)
new_sig = r'''<div class="signature-section">
        <div class="sig-block" style="width: 50%;">
            <div class="sig-line"></div>
            <div class="sig-name">Registrar</div>
            <div class="sig-title">Sri Lanka Nursing Council</div>
        </div>
        <div class="sig-block" style="width: 50%;">
            <div class="seal-area">Official Seal<br>Sri Lanka Nursing Council</div>
        </div>
    </div>

    <div class="footer">'''

for fname in files:
    path = os.path.join(dir_path, fname)
    with open(path, 'r', encoding='utf-8') as f:
        content = f.read()
    
    content = header_pattern.sub('', content)
    content = qr_pattern.sub(lambda m: qr_replacement, content)
    content = table_pattern.sub(lambda m: new_table, content)
    content = sig_pattern.sub(lambda m: new_sig, content)
    
    with open(path, 'w', encoding='utf-8') as f:
        f.write(content)
    
    print(f'Updated {fname}')
