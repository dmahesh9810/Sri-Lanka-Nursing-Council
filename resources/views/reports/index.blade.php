@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-primary text-white py-3">
                <h5 class="mb-0"><i class="bi bi-file-earmark-bar-graph"></i> Generate Reports</h5>
            </div>
            <div class="card-body p-4">
                <form action="{{ route('reports.generate') }}" method="POST" target="_blank">
                    @csrf
                    <div class="mb-4">
                        <label for="module" class="form-label fw-bold">Select Module</label>
                        <select class="form-select" id="module" name="module" required>
                            <option value="">-- Choose Module --</option>
                            <option value="temporary">Temporary Registrations</option>
                            <option value="permanent">Permanent Registrations</option>
                            <option value="qualifications">Additional Qualifications</option>
                            <option value="foreign">Foreign Certificates</option>
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

                    <button type="submit" class="btn btn-primary w-100 py-2"><i class="bi bi-file-earmark-pdf"></i> Generate PDF Report</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
