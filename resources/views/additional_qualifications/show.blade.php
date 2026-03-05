@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-10">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2><i class="bi bi-award text-primary"></i> Qualification Details</h2>
            <div>
                <a href="{{ route('additional-qualifications.index') }}" class="btn btn-outline-secondary me-2"><i class="bi bi-arrow-left"></i> Back to List</a>
                <a href="{{ route('additional-qualifications.edit', $additionalQualification) }}" class="btn btn-primary"><i class="bi bi-pencil"></i> Edit Details</a>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 mb-4 mb-md-0">
                <!-- Qualification Info -->
                <div class="card shadow-sm border-0 h-100">
                    <div class="card-header bg-white border-bottom py-3">
                        <h5 class="mb-0 text-primary"><i class="bi bi-mortarboard"></i> Additional Qualification</h5>
                    </div>
                    <div class="card-body p-4">
                        <div class="row mb-3">
                            <div class="col-sm-5 text-muted">Qualification Type</div>
                            <div class="col-sm-7 fw-bold">{{ $additionalQualification->qualification_type }}</div>
                        </div>
                        <hr class="text-muted opacity-25">
                        <div class="row mb-3">
                            <div class="col-sm-5 text-muted">Qualification No.</div>
                            <div class="col-sm-7 fw-bold"><span class="badge bg-primary fs-6">{{ $additionalQualification->qualification_number }}</span></div>
                        </div>
                        <hr class="text-muted opacity-25">
                        <div class="row mb-3">
                            <div class="col-sm-5 text-muted">Qualification Date</div>
                            <div class="col-sm-7 fw-bold">{{ \Carbon\Carbon::parse($additionalQualification->qualification_date)->format('d M Y') }}</div>
                        </div>
                        <hr class="text-muted opacity-25">
                        <div class="row mb-3">
                            <div class="col-sm-5 text-muted">Certificate Printed</div>
                            <div class="col-sm-7">
                                @if($additionalQualification->certificate_printed)
                                    <span class="badge bg-success"><i class="bi bi-check-circle"></i> Yes</span>
                                @else
                                    <span class="badge bg-danger"><i class="bi bi-x-circle"></i> No</span>
                                @endif
                            </div>
                        </div>
                        <hr class="text-muted opacity-25">
                        <div class="row mb-3">
                            <div class="col-sm-5 text-muted">Certificate Posted</div>
                            <div class="col-sm-7">
                                @if($additionalQualification->certificate_posted)
                                    <span class="badge bg-success"><i class="bi bi-check-circle"></i> Yes</span>
                                @else
                                    <span class="badge bg-danger"><i class="bi bi-x-circle"></i> No</span>
                                @endif
                            </div>
                        </div>
                        <hr class="text-muted opacity-25">
                        <div class="row mb-3">
                            <div class="col-sm-5 text-muted">Record Created</div>
                            <div class="col-sm-7">{{ $additionalQualification->created_at->format('d M Y H:i A') }}</div>
                        </div>
                        <hr class="text-muted opacity-25">
                        <div class="row">
                            <div class="col-sm-5 text-muted">Last Updated</div>
                            <div class="col-sm-7">{{ $additionalQualification->updated_at->format('d M Y H:i A') }}</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <!-- Nurse Profile -->
                <div class="card shadow-sm border-0 h-100">
                    <div class="card-header bg-white border-bottom py-3 d-flex justify-content-between align-items-center">
                        <h5 class="mb-0 text-info"><i class="bi bi-person-badge"></i> Associated Nurse</h5>
                        <a href="{{ route('nurses.show', $additionalQualification->nurse) }}" class="btn btn-sm btn-outline-info">View Full Profile</a>
                    </div>
                    <div class="card-body p-4 bg-info bg-opacity-10">
                        <div class="row mb-3">
                            <div class="col-sm-4 text-muted">Name</div>
                            <div class="col-sm-8 fw-bold">{{ $additionalQualification->nurse->name }}</div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-sm-4 text-muted">NIC</div>
                            <div class="col-sm-8"><span class="badge bg-secondary">{{ $additionalQualification->nurse->nic }}</span></div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-sm-4 text-muted">Phone</div>
                            <div class="col-sm-8">{{ $additionalQualification->nurse->phone ?: 'N/A' }}</div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-sm-4 text-muted">Batch</div>
                            <div class="col-sm-8">{{ $additionalQualification->nurse->batch ?: 'N/A' }}</div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-sm-4 text-muted">School</div>
                            <div class="col-sm-8 text-truncate" title="{{ $additionalQualification->nurse->school_or_university }}">{{ $additionalQualification->nurse->school_or_university ?: 'N/A' }}</div>
                        </div>
                        <hr class="border-info">
                        <div class="row mb-2">
                            <div class="col-sm-4 text-muted">Perm Reg No.</div>
                            <div class="col-sm-8"><span class="badge bg-success">{{ $additionalQualification->nurse->permanentRegistration ? $additionalQualification->nurse->permanentRegistration->perm_registration_no : 'Missing' }}</span></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection
