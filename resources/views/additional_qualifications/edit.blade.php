@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-10">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-primary text-white py-3 d-flex justify-content-between align-items-center">
                <h4 class="mb-0"><i class="bi bi-pencil-square"></i> Edit Qualification</h4>
                <span class="badge bg-light text-primary fs-6">{{ $additionalQualification->qualification_number }}</span>
            </div>
            
            <div class="card-body bg-light border-bottom">
                <div class="row align-items-center">
                    <div class="col-sm-2 text-muted fw-bold text-end">Nurse</div>
                    <div class="col-sm-10">
                        <strong>{{ $additionalQualification->nurse->name }}</strong> 
                        <span class="badge bg-secondary ms-2">{{ $additionalQualification->nurse->nic }}</span>
                    </div>
                </div>
            </div>

            <div class="card-body p-4 bg-white">
                <form action="{{ route('additional-qualifications.update', $additionalQualification) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <input type="hidden" name="nurse_id" value="{{ $additionalQualification->nurse_id }}">

                    <div class="row mb-3">
                        <div class="col-md-12">
                            <label for="qualification_type" class="form-label fw-bold">Qualification Type <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('qualification_type') is-invalid @enderror" id="qualification_type" name="qualification_type" value="{{ old('qualification_type', $additionalQualification->qualification_type) }}" required>
                            @error('qualification_type') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-6">
                            <label for="qualification_number" class="form-label fw-bold">Qualification Number <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('qualification_number') is-invalid @enderror" id="qualification_number" name="qualification_number" value="{{ old('qualification_number', $additionalQualification->qualification_number) }}" required>
                            @error('qualification_number') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="qualification_date" class="form-label fw-bold">Qualification Date <span class="text-danger">*</span></label>
                            <input type="date" class="form-control @error('qualification_date') is-invalid @enderror" id="qualification_date" name="qualification_date" value="{{ old('qualification_date', $additionalQualification->qualification_date) }}" required>
                            @error('qualification_date') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    <div class="row mb-4 bg-light p-3 rounded-3 mx-0">
                        <div class="col-md-6">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" role="switch" id="certificate_printed" name="certificate_printed" value="1" {{ old('certificate_printed', $additionalQualification->certificate_printed) ? 'checked' : '' }}>
                                <label class="form-check-label fw-bold" for="certificate_printed">Certificate Printed</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" role="switch" id="certificate_posted" name="certificate_posted" value="1" {{ old('certificate_posted', $additionalQualification->certificate_posted) ? 'checked' : '' }}>
                                <label class="form-check-label fw-bold" for="certificate_posted">Certificate Posted</label>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-end gap-2">
                        <a href="{{ route('additional-qualifications.index') }}" class="btn btn-secondary">Cancel</a>
                        <button type="submit" class="btn btn-primary">Update Qualification</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
