@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-10">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2><i class="bi bi-person-badge text-primary"></i> Nurse Profile</h2>
            <div>
                <a href="{{ route('nurses.index') }}" class="btn btn-outline-secondary me-2"><i class="bi bi-arrow-left"></i> Back to List</a>
                <a href="{{ route('nurses.edit', $nurse) }}" class="btn btn-primary"><i class="bi bi-pencil"></i> Edit Profile</a>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-header bg-white border-bottom pt-3 pb-0">
                        <ul class="nav nav-tabs border-bottom-0" id="profileTabs" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active fw-bold text-primary" id="personal-tab" data-bs-toggle="tab" data-bs-target="#personal" type="button" role="tab" aria-controls="personal" aria-selected="true"><i class="bi bi-person me-1"></i>Personal</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link fw-bold text-info" id="temp-reg-tab" data-bs-toggle="tab" data-bs-target="#temp-reg" type="button" role="tab" aria-controls="temp-reg" aria-selected="false"><i class="bi bi-file-earmark-medical me-1"></i>Temp. Reg.</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link fw-bold text-success" id="perm-reg-tab" data-bs-toggle="tab" data-bs-target="#perm-reg" type="button" role="tab" aria-controls="perm-reg" aria-selected="false"><i class="bi bi-award me-1"></i>Perm. Reg.</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link fw-bold text-secondary" id="qual-tab" data-bs-toggle="tab" data-bs-target="#qual" type="button" role="tab" aria-controls="qual" aria-selected="false"><i class="bi bi-mortarboard me-1"></i>Qualifications</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link fw-bold text-warning" id="foreign-tab" data-bs-toggle="tab" data-bs-target="#foreign" type="button" role="tab" aria-controls="foreign" aria-selected="false"><i class="bi bi-globe me-1"></i>Foreign Certs</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link fw-bold text-dark" id="qr-tab" data-bs-toggle="tab" data-bs-target="#qr" type="button" role="tab" aria-controls="qr" aria-selected="false"><i class="bi bi-qr-code me-1"></i>QR Code</button>
                            </li>
                        </ul>
                    </div>
                    
                    <div class="card-body p-4">
                        <div class="tab-content" id="profileTabsContent">
                            
                            {{-- Tab 1: Personal Details --}}
                            <div class="tab-pane fade show active" id="personal" role="tabpanel" aria-labelledby="personal-tab">
                                <h5 class="mb-4 text-primary">{{ $nurse->name }}</h5>
                                <div class="row g-3">
                                    <div class="col-md-6 border-bottom pb-2">
                                        <div class="text-muted small">NIC</div>
                                        <div class="fw-bold"><span class="badge bg-secondary">{{ $nurse->nic }}</span></div>
                                    </div>
                                    <div class="col-md-6 border-bottom pb-2">
                                        <div class="text-muted small">Gender</div>
                                        <div>{{ ucfirst($nurse->gender) ?: 'N/A' }}</div>
                                    </div>
                                    <div class="col-md-6 border-bottom pb-2">
                                        <div class="text-muted small">Date of Birth</div>
                                        <div>{{ $nurse->date_of_birth ? \Carbon\Carbon::parse($nurse->date_of_birth)->format('d M Y') : 'N/A' }}</div>
                                    </div>
                                    <div class="col-md-6 border-bottom pb-2">
                                        <div class="text-muted small">Phone</div>
                                        <div>{{ $nurse->phone ?: 'N/A' }}</div>
                                    </div>
                                    <div class="col-md-12 border-bottom pb-2">
                                        <div class="text-muted small">Address</div>
                                        <div>{{ $nurse->address ?: 'N/A' }}</div>
                                    </div>
                                    <div class="col-md-6 border-bottom pb-2">
                                        <div class="text-muted small">School / University</div>
                                        <div>{{ $nurse->school_or_university ?: 'N/A' }}</div>
                                    </div>
                                    <div class="col-md-6 border-bottom pb-2">
                                        <div class="text-muted small">Batch</div>
                                        <div>{{ $nurse->batch ?: 'N/A' }}</div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="text-muted small">Record Created</div>
                                        <div>{{ $nurse->created_at->format('d M Y H:i A') }}</div>
                                    </div>
                                </div>
                            </div>

                            {{-- Tab 2: Temporary Registration --}}
                            <div class="tab-pane fade" id="temp-reg" role="tabpanel" aria-labelledby="temp-reg-tab">
                                @if($nurse->temporaryRegistration)
                                    <div class="row g-3">
                                        <div class="col-md-6 border-bottom pb-2">
                                            <div class="text-muted small">Registration Number</div>
                                            <div class="fw-bold"><span class="badge bg-info text-dark">{{ $nurse->temporaryRegistration->registration_no }}</span></div>
                                        </div>
                                        <div class="col-md-6 border-bottom pb-2">
                                            <div class="text-muted small">Registration Date</div>
                                            <div>{{ \Carbon\Carbon::parse($nurse->temporaryRegistration->registration_date)->format('d M Y') }}</div>
                                        </div>
                                        <div class="col-md-12 border-bottom pb-2">
                                            <div class="text-muted small">Present Workplace</div>
                                            <div>{{ $nurse->temporaryRegistration->present_workplace ?: 'N/A' }}</div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="text-muted small">Grade</div>
                                            <div>{{ $nurse->temporaryRegistration->grade ?: 'N/A' }}</div>
                                        </div>
                                        <div class="col-md-6 text-end">
                                            <a href="{{ route('temporary-registrations.show', $nurse->temporaryRegistration) }}" class="btn btn-sm btn-outline-info">View Full Detail</a>
                                        </div>
                                    </div>
                                @else
                                    <div class="text-center py-5 text-muted">
                                        <i class="bi bi-file-earmark-x fs-1 d-block mb-3"></i>
                                        No temporary registration found for this nurse.
                                    </div>
                                @endif
                            </div>

                            {{-- Tab 3: Permanent Registration --}}
                            <div class="tab-pane fade" id="perm-reg" role="tabpanel" aria-labelledby="perm-reg-tab">
                                @if($nurse->permanentRegistration)
                                    <div class="row g-3">
                                        <div class="col-md-6 border-bottom pb-2">
                                            <div class="text-muted small">Permanent Reg. Number</div>
                                            <div class="fw-bold"><span class="badge bg-success">{{ $nurse->permanentRegistration->perm_registration_no }}</span></div>
                                        </div>
                                        <div class="col-md-6 border-bottom pb-2">
                                            <div class="text-muted small">Registration Date</div>
                                            <div>{{ \Carbon\Carbon::parse($nurse->permanentRegistration->perm_registration_date)->format('d M Y') }}</div>
                                        </div>
                                        <div class="col-md-12 border-bottom pb-2">
                                            <div class="text-muted small">Present Workplace</div>
                                            <div>{{ $nurse->permanentRegistration->present_workplace ?: 'N/A' }}</div>
                                        </div>
                                        <div class="col-md-6 border-bottom pb-2">
                                            <div class="text-muted small">Grade</div>
                                            <div>{{ $nurse->permanentRegistration->grade ?: 'N/A' }}</div>
                                        </div>
                                        <div class="col-md-6 border-bottom pb-2">
                                            <div class="text-muted small">Foreign Training</div>
                                            <div>{{ $nurse->permanentRegistration->foreign_training_details ?: 'None' }}</div>
                                        </div>
                                        <div class="col-md-12">
                                            <a href="{{ route('permanent-registrations.show', $nurse->permanentRegistration) }}" class="btn btn-sm btn-outline-success">View Full Detail</a>
                                        </div>
                                    </div>
                                @else
                                    <div class="text-center py-5 text-muted">
                                        <i class="bi bi-file-earmark-x fs-1 d-block mb-3"></i>
                                        No permanent registration found for this nurse.
                                    </div>
                                @endif
                            </div>

                            {{-- Tab 4: Additional Qualifications --}}
                            <div class="tab-pane fade" id="qual" role="tabpanel" aria-labelledby="qual-tab">
                                @if($nurse->additionalQualifications && $nurse->additionalQualifications->count() > 0)
                                    <div class="table-responsive">
                                        <table class="table table-sm table-bordered">
                                            <thead class="table-light">
                                                <tr>
                                                    <th>Type</th>
                                                    <th>Number</th>
                                                    <th>Date</th>
                                                    <th>Status</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($nurse->additionalQualifications as $qual)
                                                    <tr>
                                                        <td>{{ $qual->qualification_type }}</td>
                                                        <td>{{ $qual->qualification_number }}</td>
                                                        <td>{{ \Carbon\Carbon::parse($qual->qualification_date)->format('d M Y') }}</td>
                                                        <td>
                                                            @if($qual->certificate_printed)
                                                                <span class="badge bg-success">Printed</span>
                                                            @else
                                                                <span class="badge bg-warning text-dark">Pending</span>
                                                            @endif
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                @else
                                    <div class="text-center py-5 text-muted">
                                        <i class="bi bi-mortarboard fs-1 d-block mb-3"></i>
                                        No additional qualifications recorded.
                                    </div>
                                @endif
                            </div>

                            {{-- Tab 5: Foreign Certificates --}}
                            <div class="tab-pane fade" id="foreign" role="tabpanel" aria-labelledby="foreign-tab">
                                @if($nurse->foreignCertificates && $nurse->foreignCertificates->count() > 0)
                                    <div class="table-responsive">
                                        <table class="table table-sm table-bordered">
                                            <thead class="table-light">
                                                <tr>
                                                    <th>Type</th>
                                                    <th>Country</th>
                                                    <th>Date</th>
                                                    <th>Status</th> 
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($nurse->foreignCertificates as $cert)
                                                    <tr>
                                                        <td>{{ $cert->certificate_type }}</td>
                                                        <td>{{ $cert->country }}</td>
                                                        <td>{{ $cert->issue_date ? \Carbon\Carbon::parse($cert->issue_date)->format('d M Y') : 'N/A' }}</td>
                                                        <td>
                                                            @if($cert->certificate_printed)
                                                                <span class="badge bg-success">Printed</span>
                                                            @else
                                                                <span class="badge bg-warning text-dark">Pending</span>
                                                            @endif
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                @else
                                    <div class="text-center py-5 text-muted">
                                        <i class="bi bi-globe fs-1 d-block mb-3"></i>
                                        No foreign certificates requested.
                                    </div>
                                @endif
                            </div>

                            {{-- Tab 6: QR Code --}}
                            <div class="tab-pane fade" id="qr" role="tabpanel" aria-labelledby="qr-tab">
                                <div class="text-center py-4">
                                    @php
                                        $qrData = "Nurse Not Eligible For ID (No Permanent Reg)";
                                        if ($nurse->permanentRegistration) {
                                            $data = [
                                                "SLNC Number" => $nurse->permanentRegistration->perm_registration_no ?? 'N/A',
                                                "SLNC Date" => $nurse->permanentRegistration->perm_registration_date ?? 'N/A',
                                                "Name" => $nurse->name,
                                                "Address" => $nurse->address ?? 'N/A',
                                                "NIC" => $nurse->nic
                                            ];
                                            $qrData = implode("\n", array_map(function ($k, $v) { return "$k: $v"; }, array_keys($data), $data));
                                        }
                                    @endphp

                                    @if($nurse->permanentRegistration)
                                        <div class="mb-3 d-inline-block bg-white p-3 border rounded shadow-sm">
                                            {!! \SimpleSoftwareIO\QrCode\Facades\QrCode::size(250)->generate($qrData) !!}
                                        </div>
                                        <h6 class="text-dark mt-2">ID Card QR Code</h6>
                                        <p class="text-muted small mb-0">Scan to verify SLNC Permanent Registration Details.</p>
                                    @else
                                        <div class="p-5 text-muted border border-dashed rounded bg-light d-inline-block w-50 mx-auto">
                                            <i class="bi bi-x-circle fs-1 text-danger d-block mb-2"></i>
                                            Permanent Registration Required for ID Card QR.
                                        </div>
                                    @endif
                                </div>
                            </div>
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
