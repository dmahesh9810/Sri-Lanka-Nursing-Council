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
                <div class="card-header bg-success text-white py-3">
                    <h5 class="mb-0"><i class="bi bi-search"></i> Find Nurse for Permanent Registration</h5>
                </div>
                <div class="card-body p-4 bg-white">
                    <form action="{{ route('permanent-registrations.create') }}" method="GET">
                        <div class="mb-3">
                            <label for="nic" class="form-label fw-bold">Enter Nurse NIC <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-person-badge"></i></span>
                                <input type="text" class="form-control" id="nic" name="nic" value="{{ request('nic') }}" placeholder="e.g. 199012345678" required>
                                <button type="submit" class="btn btn-success">Search Nurse</button>
                            </div>
                            <div class="form-text mt-2">The nurse must already exist and have a temporary registration to proceed.</div>
                        </div>
                    </form>
                </div>
            </div>
        @else
            <!-- Step 2: Display Profile Preview and Registration Form -->
            
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h4 class="mb-0"><i class="bi bi-file-earmark-plus"></i> Issue Permanent Registration</h4>
                <a href="{{ route('permanent-registrations.create') }}" class="btn btn-sm btn-outline-secondary">Search Different NIC</a>
            </div>

            <!-- Profile Preview Card -->
            <div class="card border-info shadow-sm mb-4">
                <div class="card-body bg-info bg-opacity-10">
                    <div class="d-flex justify-content-between align-items-center border-bottom border-info pb-2 mb-3">
                        <h6 class="card-title text-info mb-0"><i class="bi bi-person-check-fill"></i> Selected Nurse Profile</h6>
                        @if($nurse->temporaryRegistration)
                            <span class="badge bg-primary">Temp Reg: {{ $nurse->temporaryRegistration->temp_registration_no }}</span>
                        @endif
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
                    <form action="{{ route('permanent-registrations.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="nurse_id" value="{{ $nurse->id }}">

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="perm_registration_no" class="form-label fw-bold">Permanent Registration No. <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('perm_registration_no') is-invalid @enderror" id="perm_registration_no" name="perm_registration_no" value="{{ old('perm_registration_no') }}" required>
                                @error('perm_registration_no') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="perm_registration_date" class="form-label fw-bold">Registration Date <span class="text-danger">*</span></label>
                                <input type="date" class="form-control @error('perm_registration_date') is-invalid @enderror" id="perm_registration_date" name="perm_registration_date" value="{{ old('perm_registration_date', date('Y-m-d')) }}" required>
                                @error('perm_registration_date') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="appointment_date" class="form-label fw-bold">Appointment Date</label>
                                <input type="date" class="form-control @error('appointment_date') is-invalid @enderror" id="appointment_date" name="appointment_date" value="{{ old('appointment_date') }}">
                                @error('appointment_date') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="grade" class="form-label fw-bold">Grade</label>
                                <input type="text" class="form-control @error('grade') is-invalid @enderror" id="grade" name="grade" value="{{ old('grade') }}">
                                @error('grade') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-12">
                                <label for="present_workplace" class="form-label fw-bold">Present Workplace</label>
                                <input type="text" class="form-control @error('present_workplace') is-invalid @enderror" id="present_workplace" name="present_workplace" value="{{ old('present_workplace') }}">
                                @error('present_workplace') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-6">
                                <label for="slmc_no" class="form-label fw-bold">SLMC No.</label>
                                <input type="text" class="form-control @error('slmc_no') is-invalid @enderror" id="slmc_no" name="slmc_no" value="{{ old('slmc_no') }}">
                                @error('slmc_no') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="slmc_date" class="form-label fw-bold">SLMC Date</label>
                                <input type="date" class="form-control @error('slmc_date') is-invalid @enderror" id="slmc_date" name="slmc_date" value="{{ old('slmc_date') }}">
                                @error('slmc_date') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('permanent-registrations.index') }}" class="btn btn-secondary">Cancel</a>
                            <button type="submit" class="btn btn-success">Save Registration</button>
                        </div>
                    </form>
                </div>
            </div>
        @endif
    </div>
</div>
@endsection
