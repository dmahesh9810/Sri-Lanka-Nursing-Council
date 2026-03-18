@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-primary text-white py-3">
                <h5 class="mb-0"><i class="bi bi-file-earmark-bar-graph"></i> Generate Reports</h5>
            </div>
            <div class="card-body p-4">

                @if(count($allowedModules) === 0)
                    {{-- Edge-case safety: should never happen for authenticated users,
                         but prevents a blank form if a role has no modules assigned. --}}
                    <div class="alert alert-warning">
                        <i class="bi bi-exclamation-triangle-fill me-2"></i>
                        You do not have permission to generate any reports. Please contact your administrator.
                    </div>
                @else
                    <form action="{{ route('reports.generate') }}" method="POST" target="_blank">
                        @csrf
                        <div class="mb-4">
                            <label for="module" class="form-label fw-bold">Select Module</label>
                            <select class="form-select" id="module" name="module" required>
                                <option value="">-- Choose Module --</option>
                                {{-- Only render options the current user is authorised to generate --}}
                                @foreach($allowedModules as $slug => $label)
                                    <option value="{{ $slug }}">{{ $label }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold">Report Period</label>
                            <div class="d-flex gap-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="period" id="period_daily" value="daily" checked>
                                    <label class="form-check-label" for="period_daily">Daily</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="period" id="period_monthly" value="monthly">
                                    <label class="form-check-label" for="period_monthly">Monthly</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="period" id="period_yearly" value="yearly">
                                    <label class="form-check-label" for="period_yearly">Yearly</label>
                                </div>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="report_date" class="form-label fw-bold">Select Date Reference</label>
                            <input type="date" class="form-control" id="report_date" name="report_date" value="{{ date('Y-m-d') }}" required>
                            <div class="form-text mt-1 text-muted">For monthly/yearly reports, any date within the target month/year works.</div>
                        </div>

                        <button type="submit" class="btn btn-primary w-100 py-2">
                            <i class="bi bi-file-earmark-pdf"></i> Generate PDF Report
                        </button>
                    </form>
                @endif

            </div>
        </div>
    </div>
</div>

<!-- Loading Overlay -->
<div id="loadingOverlay" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(255, 255, 255, 0.8); z-index: 9999; justify-content: center; align-items: center; flex-direction: column;">
    <div class="spinner-border text-primary" role="status" style="width: 3rem; height: 3rem;">
        <span class="visually-hidden">Loading...</span>
    </div>
    <div class="mt-3 fw-bold text-primary fs-5">Generating report... please wait.</div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.querySelector('form');
        const overlay = document.getElementById('loadingOverlay');

        if (form) {
            form.addEventListener('submit', function() {
                overlay.style.display = 'flex';
                // Hide overlay after 5 seconds since the form opens in a new tab
                setTimeout(() => {
                    overlay.style.display = 'none';
                }, 5000);
            });
        }
    });
</script>
@endsection
