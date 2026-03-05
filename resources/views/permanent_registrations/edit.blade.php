@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-10">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-success text-white py-3 d-flex justify-content-between align-items-center">
                <h4 class="mb-0"><i class="bi bi-pencil-square"></i> Edit Permanent Registration</h4>
                <span class="badge bg-light text-success fs-6">{{ $permanentRegistration->perm_registration_no }}</span>
            </div>
            
            <div class="card-body bg-light border-bottom">
                <div class="row align-items-center">
                    <div class="col-sm-2 text-muted fw-bold text-end">Nurse</div>
                    <div class="col-sm-10">
                        <strong>{{ $permanentRegistration->nurse->name }}</strong> 
                        <span class="badge bg-secondary ms-2">{{ $permanentRegistration->nurse->nic }}</span>
                    </div>
                </div>
            </div>

            <div class="card-body p-4 bg-white">
                <form action="{{ route('permanent-registrations.update', $permanentRegistration) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <input type="hidden" name="nurse_id" value="{{ $permanentRegistration->nurse_id }}">

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="perm_registration_no" class="form-label fw-bold">Permanent Registration No. <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('perm_registration_no') is-invalid @enderror" id="perm_registration_no" name="perm_registration_no" value="{{ old('perm_registration_no', $permanentRegistration->perm_registration_no) }}" required>
                            @error('perm_registration_no') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="perm_registration_date" class="form-label fw-bold">Registration Date <span class="text-danger">*</span></label>
                            <input type="date" class="form-control @error('perm_registration_date') is-invalid @enderror" id="perm_registration_date" name="perm_registration_date" value="{{ old('perm_registration_date', $permanentRegistration->perm_registration_date) }}" required>
                            @error('perm_registration_date') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="appointment_date" class="form-label fw-bold">Appointment Date</label>
                            <input type="date" class="form-control @error('appointment_date') is-invalid @enderror" id="appointment_date" name="appointment_date" value="{{ old('appointment_date', $permanentRegistration->appointment_date) }}">
                            @error('appointment_date') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="grade" class="form-label fw-bold">Grade</label>
                            <input type="text" class="form-control @error('grade') is-invalid @enderror" id="grade" name="grade" value="{{ old('grade', $permanentRegistration->grade) }}">
                            @error('grade') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-12">
                            <label for="present_workplace" class="form-label fw-bold">Present Workplace</label>
                            <input type="text" class="form-control @error('present_workplace') is-invalid @enderror" id="present_workplace" name="present_workplace" value="{{ old('present_workplace', $permanentRegistration->present_workplace) }}">
                            @error('present_workplace') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-6">
                            <label for="slmc_no" class="form-label fw-bold">SLMC No.</label>
                            <input type="text" class="form-control @error('slmc_no') is-invalid @enderror" id="slmc_no" name="slmc_no" value="{{ old('slmc_no', $permanentRegistration->slmc_no) }}">
                            @error('slmc_no') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="slmc_date" class="form-label fw-bold">SLMC Date</label>
                            <input type="date" class="form-control @error('slmc_date') is-invalid @enderror" id="slmc_date" name="slmc_date" value="{{ old('slmc_date', $permanentRegistration->slmc_date) }}">
                            @error('slmc_date') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    <div class="d-flex justify-content-end gap-2">
                        <a href="{{ route('permanent-registrations.index') }}" class="btn btn-secondary">Cancel</a>
                        <button type="submit" class="btn btn-success">Update Registration</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
