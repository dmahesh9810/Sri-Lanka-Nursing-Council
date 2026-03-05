@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">

        @if(session('error'))
            <div class="alert alert-danger shadow-sm mb-4">
                <i class="bi bi-exclamation-triangle-fill"></i> {{ session('error') }}
            </div>
        @endif

        @if(!isset($nurse))
            <!-- Step 1: Search Nurse by NIC -->
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-primary text-white py-3">
                    <h5 class="mb-0"><i class="bi bi-search"></i> Find Nurse for Temporary Registration</h5>
                </div>
                <div class="card-body p-4 bg-white">
                    <form action="{{ route('temporary-registrations.create') }}" method="GET">
                        <div class="mb-3">
                            <label for="nic" class="form-label fw-bold">Enter Nurse NIC <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-person-badge"></i></span>
                                <input type="text" class="form-control" id="nic" name="nic" value="{{ request('nic') }}" placeholder="e.g. 199012345678" required>
                                <button type="submit" class="btn btn-primary">Search Nurse</button>
                            </div>
                            <div class="form-text mt-2">You must locate the nurse profile first before issuing a temporary registration.</div>
                        </div>
                    </form>
                </div>
            </div>
        @else
            <!-- Step 2: Display Profile Preview and Registration Form -->
            
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h4 class="mb-0"><i class="bi bi-file-earmark-plus"></i> Issue Temporary Registration</h4>
                <a href="{{ route('temporary-registrations.create') }}" class="btn btn-sm btn-outline-secondary">Search Different NIC</a>
            </div>

            <!-- Profile Preview Card -->
            <div class="card border-info shadow-sm mb-4">
                <div class="card-body bg-info bg-opacity-10">
                    <h6 class="card-title text-info border-bottom border-info pb-2 mb-3"><i class="bi bi-person-check-fill"></i> Selected Nurse Profile</h6>
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
                    <form action="{{ route('temporary-registrations.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="nurse_id" value="{{ $nurse->id }}">

                        <div class="row mb-4">
                            <div class="col-md-6">
                                <label for="temp_registration_no" class="form-label fw-bold">Temporary Registration No. <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('temp_registration_no') is-invalid @enderror" id="temp_registration_no" name="temp_registration_no" value="{{ old('temp_registration_no') }}" required>
                                @error('temp_registration_no') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="temp_registration_date" class="form-label fw-bold">Registration Date <span class="text-danger">*</span></label>
                                <input type="date" class="form-control @error('temp_registration_date') is-invalid @enderror" id="temp_registration_date" name="temp_registration_date" value="{{ old('temp_registration_date', date('Y-m-d')) }}" required>
                                @error('temp_registration_date') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('temporary-registrations.index') }}" class="btn btn-secondary">Cancel</a>
                            <button type="submit" class="btn btn-primary">Save Registration</button>
                        </div>
                    </form>
                </div>
            </div>
        @endif
    </div>
</div>
@endsection
