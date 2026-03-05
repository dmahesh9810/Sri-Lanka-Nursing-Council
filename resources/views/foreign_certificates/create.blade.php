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
                    <h5 class="mb-0"><i class="bi bi-search"></i> Find Nurse for Foreign Certificate</h5>
                </div>
                <div class="card-body p-4 bg-white">
                    <form action="{{ route('foreign-certificates.create') }}" method="GET">
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
            <!-- Step 2: Display Profile Preview and Application Form -->
            
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h4 class="mb-0"><i class="bi bi-file-earmark-plus"></i> Application Form</h4>
                <a href="{{ route('foreign-certificates.create') }}" class="btn btn-sm btn-outline-secondary">Search Different NIC</a>
            </div>

            <!-- Profile Preview Card -->
            <div class="card border-info shadow-sm mb-4">
                <div class="card-body bg-info bg-opacity-10">
                    <div class="d-flex justify-content-between align-items-center border-bottom border-info pb-2 mb-3">
                        <h6 class="card-title text-info mb-0"><i class="bi bi-person-check-fill"></i> Selected Nurse Profile</h6>
                        @if($nurse->permanentRegistration)
                            <span class="badge bg-success">Perm Reg: {{ $nurse->permanentRegistration->perm_registration_no }}</span>
                        @endif
                    </div>
                    <div class="row">
                        <div class="col-md-4 mb-2">
                            <strong>Name:</strong> {{ $nurse->name }}
                        </div>
                        <div class="col-md-4 mb-2">
                            <strong>NIC:</strong> <span class="badge bg-secondary">{{ $nurse->nic }}</span>
                        </div>
                        <div class="col-md-4 mb-2">
                            <strong>Phone:</strong> {{ $nurse->phone ?: 'N/A' }}
                        </div>
                    </div>
                </div>
            </div>

            <!-- Application Form -->
            <div class="card shadow-sm border-0">
                <div class="card-body p-4 bg-white">
                    <form action="{{ route('foreign-certificates.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="nurse_id" value="{{ $nurse->id }}">

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="certificate_type" class="form-label fw-bold">Certificate Type <span class="text-danger">*</span></label>
                                <select class="form-select @error('certificate_type') is-invalid @enderror" id="certificate_type" name="certificate_type" required>
                                    <option value="" disabled {{ old('certificate_type') ? '' : 'selected' }}>Select a type...</option>
                                    <option value="Verification" {{ old('certificate_type') == 'Verification' ? 'selected' : '' }}>Verification</option>
                                    <option value="Good Standing" {{ old('certificate_type') == 'Good Standing' ? 'selected' : '' }}>Good Standing</option>
                                    <option value="Confirmation" {{ old('certificate_type') == 'Confirmation' ? 'selected' : '' }}>Confirmation</option>
                                    <option value="Additional Verification" {{ old('certificate_type') == 'Additional Verification' ? 'selected' : '' }}>Additional Verification</option>
                                </select>
                                @error('certificate_type') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="country" class="form-label fw-bold">Country <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('country') is-invalid @enderror" id="country" name="country" value="{{ old('country') }}" placeholder="e.g. United Kingdom, Australia" required>
                                @error('country') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-6">
                                <label for="apply_date" class="form-label fw-bold">Apply Date <span class="text-danger">*</span></label>
                                <input type="date" class="form-control @error('apply_date') is-invalid @enderror" id="apply_date" name="apply_date" value="{{ old('apply_date', date('Y-m-d')) }}" required>
                                @error('apply_date') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="issue_date" class="form-label fw-bold">Issue Date</label>
                                <input type="date" class="form-control @error('issue_date') is-invalid @enderror" id="issue_date" name="issue_date" value="{{ old('issue_date') }}">
                                @error('issue_date') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        <div class="row mb-4 bg-light p-3 rounded-3 mx-0">
                            <div class="col-md-6">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" role="switch" id="certificate_sealed" name="certificate_sealed" value="1" {{ old('certificate_sealed') ? 'checked' : '' }}>
                                    <label class="form-check-label fw-bold" for="certificate_sealed">Certificate Sealed</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" role="switch" id="certificate_printed" name="certificate_printed" value="1" {{ old('certificate_printed') ? 'checked' : '' }}>
                                    <label class="form-check-label fw-bold" for="certificate_printed">Certificate Printed</label>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('foreign-certificates.index') }}" class="btn btn-secondary">Cancel</a>
                            <button type="submit" class="btn btn-primary">Save Application</button>
                        </div>
                    </form>
                </div>
            </div>
        @endif
    </div>
</div>
@endsection
