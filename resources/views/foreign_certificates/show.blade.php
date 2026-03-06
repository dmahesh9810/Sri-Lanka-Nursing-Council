@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-10">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2><i class="bi bi-file-earmark-medical text-primary"></i> Application Details</h2>
            <div>
                <a href="{{ route('foreign-certificates.index') }}" class="btn btn-outline-secondary me-2"><i class="bi bi-arrow-left"></i> Back to List</a>
                <a href="{{ route('foreign-certificates.edit', $foreignCertificate) }}" class="btn btn-primary"><i class="bi bi-pencil"></i> Edit Details</a>
            </div>
        </div>

        @if($foreignCertificate->certificate_sealed && $foreignCertificate->issue_date)
        <div class="alert alert-success border-0 shadow-sm d-flex align-items-center justify-content-between mb-4" role="alert">
            <div>
                <i class="bi bi-patch-check-fill text-success me-2 fs-5"></i>
                <strong>Certificate is Ready to Print</strong> &mdash; Sealed and officially issued.
                @if($foreignCertificate->printed_at)
                    <span class="text-muted ms-2 small">Last printed: {{ $foreignCertificate->printed_at->format('d M Y, H:i A') }}</span>
                @endif
            </div>
            <div>
                <a href="{{ route('certificates.print', $foreignCertificate->id) }}" class="btn btn-success me-2" target="_blank">
                    <i class="bi bi-printer-fill"></i> Preview Certificate
                </a>
                <a href="{{ route('certificates.print', $foreignCertificate->id) . '?action=download' }}" class="btn btn-outline-success" target="_blank">
                    <i class="bi bi-download"></i> Download PDF
                </a>
            </div>
        </div>
        @else
        <div class="alert alert-warning border-0 shadow-sm mb-4" role="alert">
            <i class="bi bi-exclamation-triangle-fill me-2"></i>
            <strong>Certificate not printable:</strong> Certificate must be sealed and issued before printing.
        </div>
        @endif

        <div class="row">
            <div class="col-md-6 mb-4 mb-md-0">
                <!-- Certificate Info -->
                <div class="card shadow-sm border-0 h-100">
                    <div class="card-header bg-white border-bottom py-3">
                        <h5 class="mb-0 text-primary"><i class="bi bi-globe"></i> Foreign Certificate Info</h5>
                    </div>
                    <div class="card-body p-4">
                        <div class="row mb-3">
                            <div class="col-sm-5 text-muted">Certificate Type</div>
                            <div class="col-sm-7 fw-bold"><span class="badge bg-info text-dark">{{ $foreignCertificate->certificate_type }}</span></div>
                        </div>
                        <hr class="text-muted opacity-25">
                        <div class="row mb-3">
                            <div class="col-sm-5 text-muted">Country</div>
                            <div class="col-sm-7 fw-bold">{{ $foreignCertificate->country }}</div>
                        </div>
                        <hr class="text-muted opacity-25">
                        <div class="row mb-3">
                            <div class="col-sm-5 text-muted">Apply Date</div>
                            <div class="col-sm-7 fw-bold">{{ \Carbon\Carbon::parse($foreignCertificate->apply_date)->format('d M Y') }}</div>
                        </div>
                        <hr class="text-muted opacity-25">
                        <div class="row mb-3">
                            <div class="col-sm-5 text-muted">Issue Date</div>
                            <div class="col-sm-7 fw-bold">
                                @if($foreignCertificate->issue_date)
                                    <span class="text-success">{{ \Carbon\Carbon::parse($foreignCertificate->issue_date)->format('d M Y') }}</span>
                                @else
                                    <span class="text-warning fst-italic">Pending</span>
                                @endif
                            </div>
                        </div>
                        <hr class="text-muted opacity-25">
                        <div class="row mb-3">
                            <div class="col-sm-5 text-muted">Certificate Sealed</div>
                            <div class="col-sm-7">
                                @if($foreignCertificate->certificate_sealed)
                                    <span class="badge bg-success"><i class="bi bi-check-circle"></i> Yes</span>
                                @else
                                    <span class="badge bg-danger"><i class="bi bi-x-circle"></i> No</span>
                                @endif
                            </div>
                        </div>
                        <hr class="text-muted opacity-25">
                        <div class="row mb-3">
                            <div class="col-sm-5 text-muted">Certificate Printed</div>
                            <div class="col-sm-7">
                                @if($foreignCertificate->certificate_printed)
                                    <span class="badge bg-success"><i class="bi bi-check-circle"></i> Yes</span>
                                @else
                                    <span class="badge bg-danger"><i class="bi bi-x-circle"></i> No</span>
                                @endif
                            </div>
                        </div>
                        <hr class="text-muted opacity-25">
                        <div class="row mb-3">
                            <div class="col-sm-5 text-muted">Record Created</div>
                            <div class="col-sm-7">{{ $foreignCertificate->created_at->format('d M Y H:i A') }}</div>
                        </div>
                        <hr class="text-muted opacity-25">
                        <div class="row mb-3">
                            <div class="col-sm-5 text-muted">Last Updated</div>
                            <div class="col-sm-7">{{ $foreignCertificate->updated_at->format('d M Y H:i A') }}</div>
                        </div>
                        @if($foreignCertificate->certificate_number)
                        <hr class="text-muted opacity-25">
                        <div class="row mb-3">
                            <div class="col-sm-5 text-muted">Certificate Number</div>
                            <div class="col-sm-7"><code class="text-success">{{ $foreignCertificate->certificate_number }}</code></div>
                        </div>
                        @endif
                        @if($foreignCertificate->printed_at)
                        <hr class="text-muted opacity-25">
                        <div class="row">
                            <div class="col-sm-5 text-muted">Printed At</div>
                            <div class="col-sm-7">{{ $foreignCertificate->printed_at->format('d M Y H:i A') }}</div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <!-- Nurse Profile -->
                <div class="card shadow-sm border-0 h-100">
                    <div class="card-header bg-white border-bottom py-3 d-flex justify-content-between align-items-center">
                        <h5 class="mb-0 text-info"><i class="bi bi-person-badge"></i> Applicant Profile</h5>
                        <a href="{{ route('nurses.show', $foreignCertificate->nurse) }}" class="btn btn-sm btn-outline-info">View Full Profile</a>
                    </div>
                    <div class="card-body p-4 bg-info bg-opacity-10">
                        <div class="row mb-3">
                            <div class="col-sm-4 text-muted">Name</div>
                            <div class="col-sm-8 fw-bold">{{ $foreignCertificate->nurse->name }}</div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-sm-4 text-muted">NIC</div>
                            <div class="col-sm-8"><span class="badge bg-secondary">{{ $foreignCertificate->nurse->nic }}</span></div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-sm-4 text-muted">Phone</div>
                            <div class="col-sm-8">{{ $foreignCertificate->nurse->phone ?: 'N/A' }}</div>
                        </div>
                        <hr class="border-info">
                        <div class="row mb-2">
                            <div class="col-sm-4 text-muted">Perm Reg No.</div>
                            <div class="col-sm-8"><span class="badge bg-success">{{ $foreignCertificate->nurse->permanentRegistration ? $foreignCertificate->nurse->permanentRegistration->perm_registration_no : 'Missing' }}</span></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection
