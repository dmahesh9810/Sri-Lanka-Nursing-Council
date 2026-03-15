<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>{{ $title }}</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        .header { text-align: center; margin-bottom: 20px; }
        .header h1 { margin: 0; font-size: 20px; }
        .header h2 { margin: 5px 0 0 0; font-size: 16px; color: #555; }
        table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; font-weight: bold; }
        .footer { position: fixed; bottom: 0; width: 100%; text-align: right; font-size: 10px; color: #777; }
        .summary { margin-top: 20px; font-weight: bold; }
    </style>
</head>
<body>

    <div class="header">
        <h1>Sri Lanka Nursing Council</h1>
        <h2>{{ $title }}</h2>
        <p>Generated on: {{ date('Y-m-d H:i:s') }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Nurse Name</th>
                <th>NIC</th>
                @if($module === 'temporary')
                    <th>Registration No</th>
                    <th>Date</th>
                @elseif($module === 'permanent')
                    <th>Permanent Reg. No</th>
                    <th>Date</th>
                    <th>SLMC No</th>
                @elseif($module === 'qualifications')
                    <th>Qualification</th>
                    <th>Date</th>
                @elseif($module === 'foreign')
                    <th>Cert Type</th>
                    <th>Country</th>
                    <th>Apply Date</th>
                @endif
            </tr>
        </thead>
        <tbody>
            @foreach($records as $index => $record)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $record->nurse->name ?? 'N/A' }}</td>
                    <td>{{ $record->nurse->nic ?? 'N/A' }}</td>
                    
                    @if($module === 'temporary')
                        <td>{{ $record->temp_registration_no }}</td>
                        <td>{{ $record->temp_registration_date }}</td>
                    @elseif($module === 'permanent')
                        <td>{{ $record->perm_registration_no }}</td>
                        <td>{{ $record->perm_registration_date }}</td>
                        <td>{{ $record->slmc_no ?: '-' }}</td>
                    @elseif($module === 'qualifications')
                        <td>{{ $record->qualification_type }}</td>
                        <td>{{ $record->qualification_date }}</td>
                    @elseif($module === 'foreign')
                        <td>{{ $record->certificate_type }}</td>
                        <td>{{ $record->country }}</td>
                        <td>{{ $record->apply_date }}</td>
                    @endif
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="summary">
        Total Records Found: {{ count($records) }}
    </div>

</body>
</html>
