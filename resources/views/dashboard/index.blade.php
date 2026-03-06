@extends('layouts.app')

@section('content')

{{-- Page Header --}}
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="mb-0"><i class="bi bi-speedometer2 text-primary me-2"></i>Admin Dashboard</h2>
        <p class="text-muted mb-0 mt-1">Sri Lanka Nursing Council &mdash; System Overview</p>
    </div>
    <span class="text-muted small"><i class="bi bi-clock me-1"></i>{{ now()->format('d M Y, H:i A') }}</span>
</div>

{{-- Stats Grid --}}
<div class="row g-4 mb-4">

    {{-- Total Nurses --}}
    <div class="col-sm-6 col-xl-4">
        <div class="card border-0 shadow-sm h-100" style="border-left: 4px solid #0d6efd !important;">
            <div class="card-body d-flex align-items-center gap-3 p-4">
                <div class="rounded-circle d-flex align-items-center justify-content-center flex-shrink-0"
                     style="width:56px;height:56px;background:rgba(13,110,253,.12);">
                    <i class="bi bi-people-fill fs-4 text-primary"></i>
                </div>
                <div>
                    <div class="text-muted small text-uppercase fw-semibold letter-spacing-1">Total Nurses</div>
                    <div class="display-6 fw-bold text-primary">{{ number_format($stats['total_nurses']) }}</div>
                </div>
            </div>
            <div class="card-footer bg-white border-top py-2 px-4">
                <a href="{{ route('nurses.index') }}" class="text-decoration-none small text-primary fw-semibold">
                    <i class="bi bi-arrow-right-circle me-1"></i>View Nurses
                </a>
            </div>
        </div>
    </div>

    {{-- Temporary Registrations --}}
    <div class="col-sm-6 col-xl-4">
        <div class="card border-0 shadow-sm h-100" style="border-left: 4px solid #0dcaf0 !important;">
            <div class="card-body d-flex align-items-center gap-3 p-4">
                <div class="rounded-circle d-flex align-items-center justify-content-center flex-shrink-0"
                     style="width:56px;height:56px;background:rgba(13,202,240,.12);">
                    <i class="bi bi-hourglass-split fs-4 text-info"></i>
                </div>
                <div>
                    <div class="text-muted small text-uppercase fw-semibold">Temp. Registrations</div>
                    <div class="display-6 fw-bold text-info">{{ number_format($stats['total_temporary']) }}</div>
                </div>
            </div>
            <div class="card-footer bg-white border-top py-2 px-4">
                <a href="{{ route('temporary-registrations.index') }}" class="text-decoration-none small text-info fw-semibold">
                    <i class="bi bi-arrow-right-circle me-1"></i>View Registrations
                </a>
            </div>
        </div>
    </div>

    {{-- Permanent Registrations --}}
    <div class="col-sm-6 col-xl-4">
        <div class="card border-0 shadow-sm h-100" style="border-left: 4px solid #198754 !important;">
            <div class="card-body d-flex align-items-center gap-3 p-4">
                <div class="rounded-circle d-flex align-items-center justify-content-center flex-shrink-0"
                     style="width:56px;height:56px;background:rgba(25,135,84,.12);">
                    <i class="bi bi-patch-check-fill fs-4 text-success"></i>
                </div>
                <div>
                    <div class="text-muted small text-uppercase fw-semibold">Perm. Registrations</div>
                    <div class="display-6 fw-bold text-success">{{ number_format($stats['total_permanent']) }}</div>
                </div>
            </div>
            <div class="card-footer bg-white border-top py-2 px-4">
                <a href="{{ route('permanent-registrations.index') }}" class="text-decoration-none small text-success fw-semibold">
                    <i class="bi bi-arrow-right-circle me-1"></i>View Registrations
                </a>
            </div>
        </div>
    </div>

    {{-- Additional Qualifications --}}
    <div class="col-sm-6 col-xl-4">
        <div class="card border-0 shadow-sm h-100" style="border-left: 4px solid #6f42c1 !important;">
            <div class="card-body d-flex align-items-center gap-3 p-4">
                <div class="rounded-circle d-flex align-items-center justify-content-center flex-shrink-0"
                     style="width:56px;height:56px;background:rgba(111,66,193,.12);">
                    <i class="bi bi-award-fill fs-4" style="color:#6f42c1;"></i>
                </div>
                <div>
                    <div class="text-muted small text-uppercase fw-semibold">Add. Qualifications</div>
                    <div class="display-6 fw-bold" style="color:#6f42c1;">{{ number_format($stats['total_qualifications']) }}</div>
                </div>
            </div>
            <div class="card-footer bg-white border-top py-2 px-4">
                <a href="{{ route('additional-qualifications.index') }}" class="text-decoration-none small fw-semibold" style="color:#6f42c1;">
                    <i class="bi bi-arrow-right-circle me-1"></i>View Qualifications
                </a>
            </div>
        </div>
    </div>

    {{-- Foreign Certificate Requests --}}
    <div class="col-sm-6 col-xl-4">
        <div class="card border-0 shadow-sm h-100" style="border-left: 4px solid #fd7e14 !important;">
            <div class="card-body d-flex align-items-center gap-3 p-4">
                <div class="rounded-circle d-flex align-items-center justify-content-center flex-shrink-0"
                     style="width:56px;height:56px;background:rgba(253,126,20,.12);">
                    <i class="bi bi-globe-americas fs-4" style="color:#fd7e14;"></i>
                </div>
                <div>
                    <div class="text-muted small text-uppercase fw-semibold">Foreign Cert. Requests</div>
                    <div class="display-6 fw-bold" style="color:#fd7e14;">{{ number_format($stats['total_foreign_certificates']) }}</div>
                </div>
            </div>
            <div class="card-footer bg-white border-top py-2 px-4">
                <a href="{{ route('foreign-certificates.index') }}" class="text-decoration-none small fw-semibold" style="color:#fd7e14;">
                    <i class="bi bi-arrow-right-circle me-1"></i>View Certificates
                </a>
            </div>
        </div>
    </div>

    {{-- Certificates Printed --}}
    <div class="col-sm-6 col-xl-4">
        <div class="card border-0 shadow-sm h-100" style="border-left: 4px solid #20c997 !important;">
            <div class="card-body d-flex align-items-center gap-3 p-4">
                <div class="rounded-circle d-flex align-items-center justify-content-center flex-shrink-0"
                     style="width:56px;height:56px;background:rgba(32,201,151,.12);">
                    <i class="bi bi-printer-fill fs-4" style="color:#20c997;"></i>
                </div>
                <div>
                    <div class="text-muted small text-uppercase fw-semibold">Certificates Printed</div>
                    <div class="display-6 fw-bold" style="color:#20c997;">{{ number_format($stats['total_printed']) }}</div>
                </div>
            </div>
            <div class="card-footer bg-white border-top py-2 px-4">
                @php
                    $printPercent = $stats['total_foreign_certificates'] > 0
                        ? round(($stats['total_printed'] / $stats['total_foreign_certificates']) * 100)
                        : 0;
                @endphp
                <span class="small text-muted">
                    <i class="bi bi-bar-chart-line me-1" style="color:#20c997;"></i>
                    {{ $printPercent }}% of foreign cert requests printed
                </span>
            </div>
        </div>
    </div>

</div>

{{-- Quick Navigation --}}
<div class="card border-0 shadow-sm">
    <div class="card-header bg-white border-bottom py-3">
        <h6 class="mb-0 fw-bold text-secondary"><i class="bi bi-lightning-charge text-warning me-2"></i>Quick Navigation</h6>
    </div>
    <div class="card-body">
        <div class="d-flex flex-wrap gap-2">
            <a href="{{ route('nurses.create') }}" class="btn btn-outline-primary btn-sm">
                <i class="bi bi-plus-circle me-1"></i>New Nurse
            </a>
            <a href="{{ route('temporary-registrations.create') }}" class="btn btn-outline-info btn-sm">
                <i class="bi bi-plus-circle me-1"></i>New Temp. Registration
            </a>
            <a href="{{ route('permanent-registrations.create') }}" class="btn btn-outline-success btn-sm">
                <i class="bi bi-plus-circle me-1"></i>New Perm. Registration
            </a>
            <a href="{{ route('additional-qualifications.create') }}" class="btn btn-outline-secondary btn-sm">
                <i class="bi bi-plus-circle me-1"></i>New Qualification
            </a>
            <a href="{{ route('foreign-certificates.create') }}" class="btn btn-outline-warning btn-sm">
                <i class="bi bi-plus-circle me-1"></i>New Certificate Request
            </a>
        </div>
    </div>
</div>

@endsection
