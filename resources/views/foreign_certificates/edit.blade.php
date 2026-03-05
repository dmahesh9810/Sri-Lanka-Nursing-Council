@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-10">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-primary text-white py-3 d-flex justify-content-between align-items-center">
                <h4 class="mb-0"><i class="bi bi-pencil-square"></i> Edit Application</h4>
                <span class="badge bg-light text-primary fs-6">{{ $foreignCertificate->certificate_type }}</span>
            </div>
            
            <div class="card-body bg-light border-bottom">
                <div class="row align-items-center">
                    <div class="col-sm-3 text-muted fw-bold text-end">Associated Nurse:</div>
                    <div class="col-sm-9">
                        <strong>{{ $foreignCertificate->nurse->name }}</strong> 
                        <span class="badge bg-secondary ms-2">{{ $foreignCertificate->nurse->nic }}</span>
                    </div>
                </div>
            </div>

            <div class="card-body p-4 bg-white">
                <form action="{{ route('foreign-certificates.update', $foreignCertificate) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <input type="hidden" name="nurse_id" value="{{ $foreignCertificate->nurse_id }}">

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="certificate_type" class="form-label fw-bold">Certificate Type <span class="text-danger">*</span></label>
                            <select class="form-select @error('certificate_type') is-invalid @enderror" id="certificate_type" name="certificate_type" required>
                                <option value="Verification" {{ old('certificate_type', $foreignCertificate->certificate_type) == 'Verification' ? 'selected' : '' }}>Verification</option>
                                <option value="Good Standing" {{ old('certificate_type', $foreignCertificate->certificate_type) == 'Good Standing' ? 'selected' : '' }}>Good Standing</option>
                                <option value="Confirmation" {{ old('certificate_type', $foreignCertificate->certificate_type) == 'Confirmation' ? 'selected' : '' }}>Confirmation</option>
                                <option value="Additional Verification" {{ old('certificate_type', $foreignCertificate->certificate_type) == 'Additional Verification' ? 'selected' : '' }}>Additional Verification</option>
                            </select>
                            @error('certificate_type') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="country" class="form-label fw-bold">Country <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('country') is-invalid @enderror" id="country" name="country" value="{{ old('country', $foreignCertificate->country) }}" required>
                            @error('country') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-6">
                            <label for="apply_date" class="form-label fw-bold">Apply Date <span class="text-danger">*</span></label>
                            <input type="date" class="form-control @error('apply_date') is-invalid @enderror" id="apply_date" name="apply_date" value="{{ old('apply_date', $foreignCertificate->apply_date) }}" required>
                            @error('apply_date') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="issue_date" class="form-label fw-bold">Issue Date</label>
                            <input type="date" class="form-control @error('issue_date') is-invalid @enderror" id="issue_date" name="issue_date" value="{{ old('issue_date', $foreignCertificate->issue_date) }}">
                            @error('issue_date') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    <div class="row mb-4 bg-light p-3 rounded-3 mx-0">
                        <div class="col-md-6">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" role="switch" id="certificate_sealed" name="certificate_sealed" value="1" {{ old('certificate_sealed', $foreignCertificate->certificate_sealed) ? 'checked' : '' }}>
                                <label class="form-check-label fw-bold" for="certificate_sealed">Certificate Sealed</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" role="switch" id="certificate_printed" name="certificate_printed" value="1" {{ old('certificate_printed', $foreignCertificate->certificate_printed) ? 'checked' : '' }}>
                                <label class="form-check-label fw-bold" for="certificate_printed">Certificate Printed</label>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-end gap-2">
                        <a href="{{ route('foreign-certificates.index') }}" class="btn btn-secondary">Cancel</a>
                        <button type="submit" class="btn btn-primary">Update Application</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
