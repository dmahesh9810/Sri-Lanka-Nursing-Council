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
    <div class="col-sm-6 col-xl-3">
        <div class="card border-0 shadow-sm h-100" style="border-left: 4px solid #20c997 !important;">
            <div class="card-body d-flex align-items-center gap-3 p-4">
                <div class="rounded-circle d-flex align-items-center justify-content-center flex-shrink-0"
                     style="width:56px;height:56px;background:rgba(32,201,151,.12);">
                    <i class="bi bi-printer-fill fs-4" style="color:#20c997;"></i>
                </div>
                <div>
                    <div class="text-muted small text-uppercase fw-semibold">Foreign Certs Printed</div>
                    <div class="display-6 fw-bold" style="color:#20c997;">{{ number_format($stats['total_printed']) }}</div>
                </div>
            </div>
        </div>
    </div>

    {{-- Perm Certificates Printed --}}
    <div class="col-sm-6 col-xl-3">
        <div class="card border-0 shadow-sm h-100" style="border-left: 4px solid #e83e8c !important;">
            <div class="card-body d-flex align-items-center gap-3 p-4">
                <div class="rounded-circle d-flex align-items-center justify-content-center flex-shrink-0"
                     style="width:56px;height:56px;background:rgba(232,62,140,.12);">
                    <i class="bi bi-file-earmark-person-fill fs-4" style="color:#e83e8c;"></i>
                </div>
                <div>
                    <div class="text-muted small text-uppercase fw-semibold">Perm Certs Printed</div>
                    <div class="display-6 fw-bold" style="color:#e83e8c;">{{ number_format($stats['total_perm_certificates_printed']) }}</div>
                </div>
            </div>
            <div class="card-footer bg-white border-top py-2 px-4">
                <a href="{{ route('permanent-certificates.index') }}" class="text-decoration-none small fw-semibold" style="color:#e83e8c;">
                    <i class="bi bi-arrow-right-circle me-1"></i>Issue & Print
                </a>
            </div>
        </div>
    </div>

    {{-- Total Reports Generated --}}
    <div class="col-sm-6 col-xl-3">
        <div class="card border-0 shadow-sm h-100" style="border-left: 4px solid #ef4444 !important;">
            <div class="card-body d-flex align-items-center gap-3 p-4">
                <div class="rounded-circle d-flex align-items-center justify-content-center flex-shrink-0"
                     style="width:56px;height:56px;background:rgba(239,68,68,.12);">
                    <i class="bi bi-file-earmark-pdf-fill fs-4" style="color:#ef4444;"></i>
                </div>
                <div>
                    <div class="text-muted small text-uppercase fw-semibold">Reports Generated</div>
                    <div class="display-6 fw-bold" style="color:#ef4444;">{{ number_format($stats['total_reports_generated']) }}</div>
                </div>
            </div>
            <div class="card-footer bg-white border-top py-2 px-4">
                <a href="{{ route('reports.index') }}" class="text-decoration-none small fw-semibold" style="color:#ef4444;">
                    <i class="bi bi-arrow-right-circle me-1"></i>Generate Report
                </a>
            </div>
        </div>
    </div>

</div>

{{-- Charts Section --}}
<div class="row g-4 mb-4">
    {{-- Chart 1: Monthly Temp Registrations --}}
    <div class="col-xl-6">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-header bg-white border-bottom py-3">
                <h6 class="mb-0 fw-bold text-secondary"><i class="bi bi-bar-chart-fill text-info me-2"></i>Monthly Temp. Registrations (12 Months)</h6>
            </div>
            <div class="card-body">
                <canvas id="tempChart" height="250"></canvas>
            </div>
        </div>
    </div>

    {{-- Chart 2: Monthly Perm Registrations --}}
    <div class="col-xl-6">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-header bg-white border-bottom py-3">
                <h6 class="mb-0 fw-bold text-secondary"><i class="bi bi-graph-up-arrow text-success me-2"></i>Monthly Perm. Registrations (12 Months)</h6>
            </div>
            <div class="card-body">
                <canvas id="permChart" height="250"></canvas>
            </div>
        </div>
    </div>

    {{-- Chart 3: Foreign Certs by Country --}}
    <div class="col-xl-6">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-header bg-white border-bottom py-3">
                <h6 class="mb-0 fw-bold text-secondary"><i class="bi bi-pie-chart-fill text-warning me-2"></i>Foreign Certificates by Country</h6>
            </div>
            <div class="card-body d-flex justify-content-center">
                <div style="height: 300px; width: 100%;">
                    <canvas id="countryChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    {{-- Chart 4: Certs Printed vs Pending --}}
    <div class="col-xl-6">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-header bg-white border-bottom py-3">
                <h6 class="mb-0 fw-bold text-secondary"><i class="bi bi-printer-fill text-primary me-2"></i>Foreign Certs Print Status</h6>
            </div>
            <div class="card-body d-flex justify-content-center">
                <div style="height: 300px; width: 100%;">
                    <canvas id="certStatusChart"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Recent Activity --}}
<div class="row mb-4">
    <div class="col-12">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white border-bottom py-3">
                <h6 class="mb-0 fw-bold text-secondary"><i class="bi bi-clock-history text-primary me-2"></i>Recent Activity</h6>
            </div>
            <div class="card-body p-0">
                <ul class="list-group list-group-flush">
                    @forelse($recentActivities as $activity)
                        <li class="list-group-item px-4 py-3">
                            <div class="d-flex w-100 justify-content-between align-items-center">
                                <div>
                                    <h6 class="mb-1 fw-bold text-dark">{{ $activity->action }}</h6>
                                    <p class="mb-0 text-muted small">{{ $activity->description }}</p>
                                    @if($activity->user)
                                        <div class="small text-primary mt-1"><i class="bi bi-person-circle me-1"></i>{{ $activity->user->name }}</div>
                                    @endif
                                </div>
                                <small class="text-muted"><i class="bi bi-clock me-1"></i>{{ $activity->created_at->diffForHumans() }}</small>
                            </div>
                        </li>
                    @empty
                        <li class="list-group-item px-4 py-4 text-center text-muted">
                            <i class="bi bi-inbox fs-4 d-block mb-2"></i>
                            No recent activity found.
                        </li>
                    @endforelse
                </ul>
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

{{-- Chart.js Scripts --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Shared styling
    Chart.defaults.font.family = '-apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif';
    Chart.defaults.color = '#6c757d';

    // Chart 1: Temp Registrations (Bar)
    var ctxTemp = document.getElementById('tempChart').getContext('2d');
    new Chart(ctxTemp, {
        type: 'bar',
        data: {
            labels: {!! json_encode($charts['temp_labels'] ?? []) !!},
            datasets: [{
                label: 'Temp Registrations',
                data: {!! json_encode($charts['temp_data'] ?? []) !!},
                backgroundColor: 'rgba(13, 202, 240, 0.7)',
                borderColor: '#0dcaf0',
                borderWidth: 1,
                borderRadius: 4
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: { y: { beginAtZero: true, ticks: { stepSize: 1 } } },
            plugins: { legend: { display: false } }
        }
    });

    // Chart 2: Perm Registrations (Line)
    var ctxPerm = document.getElementById('permChart').getContext('2d');
    new Chart(ctxPerm, {
        type: 'line',
        data: {
            labels: {!! json_encode($charts['perm_labels'] ?? []) !!},
            datasets: [{
                label: 'Perm Registrations',
                data: {!! json_encode($charts['perm_data'] ?? []) !!},
                backgroundColor: 'rgba(25, 135, 84, 0.2)',
                borderColor: '#198754',
                borderWidth: 2,
                tension: 0.3,
                fill: true,
                pointBackgroundColor: '#198754'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: { y: { beginAtZero: true, ticks: { stepSize: 1 } } },
            plugins: { legend: { display: false } }
        }
    });

    // Chart 3: Foreign Certs by Country (Doughnut)
    var ctxCountry = document.getElementById('countryChart').getContext('2d');
    new Chart(ctxCountry, {
        type: 'doughnut',
        data: {
            labels: {!! json_encode($charts['country_labels'] ?? []) !!},
            datasets: [{
                data: {!! json_encode($charts['country_data'] ?? []) !!},
                backgroundColor: [
                    '#0d6efd', '#6610f2', '#6f42c1', '#d63384', '#dc3545',
                    '#fd7e14', '#ffc107', '#198754', '#20c997', '#0dcaf0'
                ],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { position: 'right' }
            }
        }
    });

    // Chart 4: Certs Status (Pie)
    var ctxStatus = document.getElementById('certStatusChart').getContext('2d');
    new Chart(ctxStatus, {
        type: 'pie',
        data: {
            labels: {!! json_encode($charts['cert_status_labels'] ?? []) !!},
            datasets: [{
                data: {!! json_encode($charts['cert_status_data'] ?? []) !!},
                backgroundColor: ['#20c997', '#6c757d'],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { position: 'bottom' }
            }
        }
    });
});
</script>

@endsection
