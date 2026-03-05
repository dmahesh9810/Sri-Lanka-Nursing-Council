@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-10">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2><i class="bi bi-file-earmark-text text-primary"></i> Permanent Registration Details</h2>
            <div>
                <a href="{{ route('permanent-registrations.index') }}" class="btn btn-outline-secondary me-2"><i class="bi bi-arrow-left"></i> Back to List</a>
                <a href="{{ route('permanent-registrations.edit', $permanentRegistration) }}" class="btn btn-success"><i class="bi bi-pencil"></i> Edit Details</a>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 mb-4 mb-md-0">
                <!-- Registration Info -->
                <div class="card shadow-sm border-0 h-100">
                    <div class="card-header bg-white border-bottom py-3">
                        <h5 class="mb-0 text-success"><i class="bi bi-award"></i> Registration Overview</h5>
                    </div>
                    <div class="card-body p-4">
                        <div class="row mb-3">
                            <div class="col-sm-5 text-muted">Permanent Reg No.</div>
                            <div class="col-sm-7 fw-bold"><span class="badge bg-success fs-6">{{ $permanentRegistration->perm_registration_no }}</span></div>
                        </div>
                        <hr class="text-muted opacity-25">
                        <div class="row mb-3">
                            <div class="col-sm-5 text-muted">Registration Date</div>
                            <div class="col-sm-7 fw-bold">{{ \Carbon\Carbon::parse($permanentRegistration->perm_registration_date)->format('d M Y') }}</div>
                        </div>
                        <hr class="text-muted opacity-25">
                        <div class="row mb-3">
                            <div class="col-sm-5 text-muted">Appointment Date</div>
                            <div class="col-sm-7">{{ $permanentRegistration->appointment_date ? \Carbon\Carbon::parse($permanentRegistration->appointment_date)->format('d M Y') : 'N/A' }}</div>
                        </div>
                        <hr class="text-muted opacity-25">
                        <div class="row mb-3">
                            <div class="col-sm-5 text-muted">Grade</div>
                            <div class="col-sm-7">{{ $permanentRegistration->grade ?: 'N/A' }}</div>
                        </div>
                        <hr class="text-muted opacity-25">
                        <div class="row mb-3">
                            <div class="col-sm-5 text-muted">Present Workplace</div>
                            <div class="col-sm-7">{{ $permanentRegistration->present_workplace ?: 'N/A' }}</div>
                        </div>
                        <hr class="text-muted opacity-25">
                        <div class="row mb-3">
                            <div class="col-sm-5 text-muted">SLMC No.</div>
                            <div class="col-sm-7">{{ $permanentRegistration->slmc_no ?: 'N/A' }}</div>
                        </div>
                        <hr class="text-muted opacity-25">
                        <div class="row mb-3">
                            <div class="col-sm-5 text-muted">SLMC Date</div>
                            <div class="col-sm-7">{{ $permanentRegistration->slmc_date ? \Carbon\Carbon::parse($permanentRegistration->slmc_date)->format('d M Y') : 'N/A' }}</div>
                        </div>
                        <hr class="text-muted opacity-25">
                        <div class="row mb-3">
                            <div class="col-sm-5 text-muted">Record Created</div>
                            <div class="col-sm-7">{{ $permanentRegistration->created_at->format('d M Y H:i A') }}</div>
                        </div>
                        <hr class="text-muted opacity-25">
                        <div class="row">
                            <div class="col-sm-5 text-muted">Last Updated</div>
                            <div class="col-sm-7">{{ $permanentRegistration->updated_at->format('d M Y H:i A') }}</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <!-- Nurse Profile -->
                <div class="card shadow-sm border-0 h-100">
                    <div class="card-header bg-white border-bottom py-3 d-flex justify-content-between align-items-center">
                        <h5 class="mb-0 text-info"><i class="bi bi-person-badge"></i> Associated Nurse</h5>
                        <a href="{{ route('nurses.show', $permanentRegistration->nurse) }}" class="btn btn-sm btn-outline-info">View Full Profile</a>
                    </div>
                    <div class="card-body p-4 bg-info bg-opacity-10">
                        <div class="row mb-3">
                            <div class="col-sm-4 text-muted">Name</div>
                            <div class="col-sm-8 fw-bold">{{ $permanentRegistration->nurse->name }}</div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-sm-4 text-muted">NIC</div>
                            <div class="col-sm-8"><span class="badge bg-secondary">{{ $permanentRegistration->nurse->nic }}</span></div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-sm-4 text-muted">Phone</div>
                            <div class="col-sm-8">{{ $permanentRegistration->nurse->phone ?: 'N/A' }}</div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-sm-4 text-muted">Batch</div>
                            <div class="col-sm-8">{{ $permanentRegistration->nurse->batch ?: 'N/A' }}</div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-sm-4 text-muted">School</div>
                            <div class="col-sm-8 text-truncate" title="{{ $permanentRegistration->nurse->school_or_university }}">{{ $permanentRegistration->nurse->school_or_university ?: 'N/A' }}</div>
                        </div>
                        <hr class="border-info">
                        <div class="row">
                            <div class="col-sm-4 text-muted">Temp Reg No.</div>
                            <div class="col-sm-8"><span class="badge bg-primary">{{ $permanentRegistration->nurse->temporaryRegistration ? $permanentRegistration->nurse->temporaryRegistration->temp_registration_no : 'Missing' }}</span></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection
