@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-primary text-white py-3 d-flex justify-content-between align-items-center">
                <h4 class="mb-0"><i class="bi bi-pencil-square"></i> Edit Temporary Registration</h4>
                <span class="badge bg-light text-primary fs-6">{{ $temporaryRegistration->temp_registration_no }}</span>
            </div>
            
            <div class="card-body bg-light border-bottom">
                <div class="row align-items-center">
                    <div class="col-sm-2 text-muted fw-bold text-end">Nurse</div>
                    <div class="col-sm-10">
                        <strong>{{ $temporaryRegistration->nurse->name }}</strong> 
                        <span class="badge bg-secondary ms-2">{{ $temporaryRegistration->nurse->nic }}</span>
                    </div>
                </div>
            </div>

            <div class="card-body p-4 bg-white">
                <form action="{{ route('temporary-registrations.update', $temporaryRegistration) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <input type="hidden" name="nurse_id" value="{{ $temporaryRegistration->nurse_id }}">

                    <div class="row mb-4">
                        <div class="col-md-6">
                            <label for="temp_registration_no" class="form-label fw-bold">Temporary Registration No. <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('temp_registration_no') is-invalid @enderror" id="temp_registration_no" name="temp_registration_no" value="{{ old('temp_registration_no', $temporaryRegistration->temp_registration_no) }}" required>
                            @error('temp_registration_no') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="temp_registration_date" class="form-label fw-bold">Registration Date <span class="text-danger">*</span></label>
                            <input type="date" class="form-control @error('temp_registration_date') is-invalid @enderror" id="temp_registration_date" name="temp_registration_date" value="{{ old('temp_registration_date', $temporaryRegistration->temp_registration_date) }}" required>
                            @error('temp_registration_date') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    <div class="d-flex justify-content-end gap-2">
                        <a href="{{ route('temporary-registrations.index') }}" class="btn btn-secondary">Cancel</a>
                        <button type="submit" class="btn btn-primary">Update Registration</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
