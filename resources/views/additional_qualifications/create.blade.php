@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-10">

        @if(session('error'))
            <div class="alert alert-danger shadow-sm mb-4">
                <i class="bi bi-exclamation-triangle-fill"></i> {{ session('error') }}
            </div>
        @endif

        @if(!isset($nurse))
            <!-- Step 1: Search Nurse by NIC -->
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-primary text-white py-3">
                    <h5 class="mb-0"><i class="bi bi-search"></i> Find Nurse to Add Qualification</h5>
                </div>
                <div class="card-body p-4 bg-white">
                    <form action="{{ route('additional-qualifications.create') }}" method="GET">
                        <div class="mb-3">
                            <label for="nic" class="form-label fw-bold">Enter Nurse NIC <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-person-badge"></i></span>
                                <input type="text" class="form-control" id="nic" name="nic" value="{{ request('nic') }}" placeholder="e.g. 199012345678" required>
                                <button type="submit" class="btn btn-primary">Search Nurse</button>
                            </div>
                            <div class="form-text mt-2">The nurse must already exist and possess an active permanent registration.</div>
                        </div>
                    </form>
                </div>
            </div>
        @else
            <!-- Step 2: Display Profile Preview and Registration Form -->
            
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h4 class="mb-0"><i class="bi bi-plus-circle"></i> Add Qualification Form</h4>
                <a href="{{ route('additional-qualifications.create') }}" class="btn btn-sm btn-outline-secondary">Search Different NIC</a>
            </div>

            <!-- Profile Preview Card -->
            <div class="card border-info shadow-sm mb-4">
                <div class="card-body bg-info bg-opacity-10">
                    <div class="d-flex justify-content-between align-items-center border-bottom border-info pb-2 mb-3">
                        <h6 class="card-title text-info mb-0"><i class="bi bi-person-check-fill"></i> Selected Nurse Profile</h6>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-2">
                            <strong>Name:</strong> {{ $nurse->name }}
                        </div>
                        <div class="col-md-6 mb-2">
                            <strong>NIC:</strong> <span class="badge bg-secondary">{{ $nurse->nic }}</span>
                        </div>
                        <div class="col-md-6 mb-2">
                            <strong>Phone:</strong> {{ $nurse->phone ?: 'N/A' }}
                        </div>
                        <div class="col-md-6 mb-2">
                            <strong>Batch:</strong> {{ $nurse->batch ?: 'N/A' }}
                        </div>
                        <div class="col-12 text-muted small mt-2">
                            <em><i class="bi bi-building"></i> {{ $nurse->school_or_university ?: 'No School/University Listed' }}</em>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Application Form -->
            <div class="card shadow-sm border-0">
                <div class="card-body p-4 bg-white">
                    <form action="{{ route('additional-qualifications.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="nurse_id" value="{{ $nurse->id }}">

                        <div class="row mb-3">
                            <div class="col-md-12">
                                <label for="qualification_type" class="form-label fw-bold">Qualification Type <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('qualification_type') is-invalid @enderror" id="qualification_type" name="qualification_type" value="{{ old('qualification_type') }}" placeholder="e.g. Midwifery, ICU Training" required>
                                @error('qualification_type') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-6">
                                <label for="qualification_number" class="form-label fw-bold">Qualification Number <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('qualification_number') is-invalid @enderror" id="qualification_number" name="qualification_number" value="{{ old('qualification_number') }}" required>
                                @error('qualification_number') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="qualification_date" class="form-label fw-bold">Qualification Date <span class="text-danger">*</span></label>
                                <input type="date" class="form-control @error('qualification_date') is-invalid @enderror" id="qualification_date" name="qualification_date" value="{{ old('qualification_date', date('Y-m-d')) }}" required>
                                @error('qualification_date') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        <div class="row mb-4 bg-light p-3 rounded-3 mx-0">
                            <div class="col-md-6">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" role="switch" id="certificate_printed" name="certificate_printed" value="1" {{ old('certificate_printed') ? 'checked' : '' }}>
                                    <label class="form-check-label fw-bold" for="certificate_printed">Certificate Printed</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" role="switch" id="certificate_posted" name="certificate_posted" value="1" {{ old('certificate_posted') ? 'checked' : '' }}>
                                    <label class="form-check-label fw-bold" for="certificate_posted">Certificate Posted</label>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('additional-qualifications.index') }}" class="btn btn-secondary">Cancel</a>
                            <button type="submit" class="btn btn-primary">Save Qualification</button>
                        </div>
                    </form>
                </div>
            </div>
        @endif
    </div>
</div>
@endsection
