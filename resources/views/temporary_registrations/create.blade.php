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
                    
                    <hr class="my-4">
                    <div class="text-center">
                        <p class="text-muted mb-2">Can't find the nurse?</p>
                        <button type="button" class="btn btn-outline-success" data-bs-toggle="modal" data-bs-target="#addNurseModal">
                            <i class="bi bi-person-plus"></i> Add New Nurse
                        </button>
                    </div>
                </div>
            </div>

            <!-- Add Nurse Modal -->
            <div class="modal fade" id="addNurseModal" tabindex="-1" aria-labelledby="addNurseModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header bg-success text-white">
                            <h5 class="modal-title" id="addNurseModalLabel"><i class="bi bi-person-plus-fill"></i> Register New Nurse</h5>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form action="{{ route('temporary-registrations.store') }}" method="POST">
                            @csrf
                            <input type="hidden" name="is_new_nurse" value="1">
                            <div class="modal-body p-4">
                                <h6 class="border-bottom pb-2 mb-3 text-success">Personal Information</h6>
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label for="new_name" class="form-label fw-bold">Full Name <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="new_name" name="new_name" value="{{ old('new_name') }}" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="new_nic" class="form-label fw-bold">NIC <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="new_nic" name="new_nic" value="{{ old('new_nic') }}" required>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label for="new_phone" class="form-label fw-bold">Phone</label>
                                        <input type="text" class="form-control" id="new_phone" name="new_phone" value="{{ old('new_phone') }}">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="new_gender" class="form-label fw-bold">Gender</label>
                                        <select class="form-select" id="new_gender" name="new_gender">
                                            <option value="">Select Gender</option>
                                            <option value="Female" @selected(old('new_gender') == 'Female')>Female</option>
                                            <option value="Male" @selected(old('new_gender') == 'Male')>Male</option>
                                        </select>
                                    </div>
                                </div>
                                
                                <h6 class="border-bottom pb-2 mb-3 text-success mt-4">Temporary Registration Details</h6>
                                <div class="row mb-3">
                                    <div class="col-md-12">
                                        <label for="address_modal" class="form-label fw-bold">Address</label>
                                        <textarea class="form-control" id="address_modal" name="address" rows="2">{{ old('address') }}</textarea>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label for="batch_modal" class="form-label fw-bold">Batch</label>
                                        <input type="text" class="form-control" id="batch_modal" name="batch" value="{{ old('batch') }}">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="school_university_modal" class="form-label fw-bold">School or University</label>
                                        <input type="text" class="form-control" id="school_university_modal" name="school_university" value="{{ old('school_university') }}">
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label for="birth_date_modal" class="form-label fw-bold">Birth Date</label>
                                        <input type="date" class="form-control" id="birth_date_modal" name="birth_date" value="{{ old('birth_date') }}">
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer bg-light">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                <button type="submit" class="btn btn-success">Register Nurse & Issue Temp. Reg.</button>
                            </div>
                        </form>
                    </div>
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

                        <div class="row mb-3">
                            <div class="col-md-12">
                                <label for="address" class="form-label fw-bold">Address</label>
                                <textarea class="form-control @error('address') is-invalid @enderror" id="address" name="address" rows="2">{{ old('address') }}</textarea>
                                @error('address') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="batch" class="form-label fw-bold">Batch</label>
                                <input type="text" class="form-control @error('batch') is-invalid @enderror" id="batch" name="batch" value="{{ old('batch') }}">
                                @error('batch') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="school_university" class="form-label fw-bold">School or University</label>
                                <input type="text" class="form-control @error('school_university') is-invalid @enderror" id="school_university" name="school_university" value="{{ old('school_university') }}">
                                @error('school_university') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="birth_date" class="form-label fw-bold">Birth Date</label>
                                <input type="date" class="form-control @error('birth_date') is-invalid @enderror" id="birth_date" name="birth_date" value="{{ old('birth_date') }}">
                                @error('birth_date') <div class="invalid-feedback">{{ $message }}</div> @enderror
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
