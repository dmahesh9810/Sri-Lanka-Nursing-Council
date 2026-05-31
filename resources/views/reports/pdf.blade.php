<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>{{ $title }}</title>
    <style>
        body { font-family: sans-serif; font-size: 9px; }
        .header { text-align: center; margin-bottom: 20px; }
        .header h1 { margin: 0; font-size: 18px; }
        .header h2 { margin: 5px 0 0 0; font-size: 14px; color: #555; }
        table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        th, td { border: 1px solid #ddd; padding: 4px; text-align: left; word-wrap: break-word; }
        th { background-color: #f2f2f2; font-weight: bold; font-size: 9px; }
        .footer { position: fixed; bottom: 0; width: 100%; text-align: right; font-size: 9px; color: #777; }
        .summary { margin-top: 20px; font-weight: bold; font-size: 11px; }
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
                <th>Name</th>
                <th>NIC</th>
                <th>Phone</th>
                <th>Address</th>
                @if($module === 'temporary')
                    <th>Reg No</th>
                    <th>Date</th>
                    <th>DOB</th>
                    <th>Gender</th>
                    <th>School/University</th>
                    <th>Batch</th>
                    <th>Grade</th>
                    <th>Workplace</th>
                @elseif($module === 'permanent')
                    <th>Perm Reg No</th>
                    <th>Date</th>
                    <th>School/University</th>
                    <th>Batch</th>
                    <th>SLMC No</th>
                    <th>SLMC Date</th>
                    <th>Grade</th>
                    <th>Workplace</th>
                @elseif($module === 'qualifications')
                    <th>Qualification</th>
                    <th>Date</th>
                @elseif($module === 'foreign')
                    <th>Cert Type</th>
                    <th>Country</th>
                    <th>Apply Date</th>
                    <th>Sealed</th>
                    <th>Printed</th>
                @endif
            </tr>
        </thead>
        <tbody>
            @foreach($records as $index => $record)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $record->nurse->name ?? 'N/A' }}</td>
                    <td>{{ $record->nurse->nic ?? 'N/A' }}</td>
                    <td>{{ $record->nurse->phone ?? '-' }}</td>
                    <td>{{ $record->nurse->address ?? '-' }}</td>
                    
                    @if($module === 'temporary')
                        <td>{{ $record->temp_registration_no }}</td>
                        <td>{{ $record->temp_registration_date }}</td>
                        <td>{{ $record->nurse->date_of_birth ?? '-' }}</td>
                        <td>{{ $record->nurse->gender ?? '-' }}</td>
                        <td>{{ $record->nurse->school_or_university ?? '-' }}</td>
                        <td>{{ $record->nurse->batch ?? '-' }}</td>
                        <td>{{ $record->grade ?? '-' }}</td>
                        <td>{{ $record->present_workplace ?? '-' }}</td>
                    @elseif($module === 'permanent')
                        <td>{{ $record->perm_registration_no }}</td>
                        <td>{{ $record->perm_registration_date }}</td>
                        <td>{{ $record->nurse->permanentRegistration->school_university ?? $record->nurse->school_or_university ?? '-' }}</td>
                        <td>{{ $record->nurse->permanentRegistration->batch ?? $record->nurse->batch ?? '-' }}</td>
                        <td>{{ $record->slmc_no ?: '-' }}</td>
                        <td>{{ $record->slmc_date ?: '-' }}</td>
                        <td>{{ $record->grade ?? '-' }}</td>
                        <td>{{ $record->present_workplace ?? '-' }}</td>
                    @elseif($module === 'qualifications')
                        <td>{{ $record->qualification_type }}</td>
                        <td>{{ $record->qualification_date }}</td>
                    @elseif($module === 'foreign')
                        <td>{{ $record->certificate_type }}</td>
                        <td>{{ $record->country }}</td>
                        <td>{{ $record->apply_date }}</td>
                        <td>{{ $record->certificate_sealed ? 'Yes' : 'No' }}</td>
                        <td>{{ $record->certificate_printed ? 'Yes' : 'No' }}</td>
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
