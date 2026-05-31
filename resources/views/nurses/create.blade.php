@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-primary text-white py-3">
                <h4 class="mb-0"><i class="bi bi-person-plus"></i> Add New Nurse</h4>
            </div>
            <div class="card-body p-4 bg-white">
                <form action="{{ route('nurses.store') }}" method="POST">
                    @csrf
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="name" class="form-label fw-bold">Full Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" required>
                            @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="nic" class="form-label fw-bold">NIC <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('nic') is-invalid @enderror" id="nic" name="nic" value="{{ old('nic') }}" required>
                            @error('nic') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="address" class="form-label fw-bold">Address</label>
                        <textarea class="form-control @error('address') is-invalid @enderror" id="address" name="address" rows="2">{{ old('address') }}</textarea>
                        @error('address') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label for="phone" class="form-label fw-bold">Phone</label>
                            <input type="text" class="form-control @error('phone') is-invalid @enderror" id="phone" name="phone" value="{{ old('phone') }}">
                            @error('phone') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-4">
                            <label for="gender" class="form-label fw-bold">Gender</label>
                            <select class="form-select @error('gender') is-invalid @enderror" id="gender" name="gender">
                                <option value="">Select Gender</option>
                                <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>Male</option>
                                <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>Female</option>
                                <option value="other" {{ old('gender') == 'other' ? 'selected' : '' }}>Other</option>
                            </select>
                            @error('gender') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-4">
                            <label for="date_of_birth" class="form-label fw-bold">Date of Birth</label>
                            <input type="date" class="form-control @error('date_of_birth') is-invalid @enderror" id="date_of_birth" name="date_of_birth" value="{{ old('date_of_birth') }}">
                            @error('date_of_birth') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-6">
                            <label for="school_or_university" class="form-label fw-bold">School / University</label>
                            <select class="form-select select2 @error('school_or_university') is-invalid @enderror" id="school_or_university" name="school_or_university">
                                <option value="">Select School or University</option>
                                @foreach(['Sri Jayewardenapura NTS','Kandana NTS','Kalutara NTS','Kandy NTS','Ampara NTS','Galle NTS','Matara NTS','Anuradhapura NTS','Jaffna NTS','Vavuniya NTS','Colombo NTS','Rathnapura NTS','Mulleriyawa NTS','Kurunegala NTS','Badulla NTS','NIHS - Kalutara (Public Health Training Institute) NTS','Hambantota NTS','Anuradhapura (Military) NTS','Batticaloa NTS','Peradeniya University','Sri Jeyawardenapura University','Eastern University','Jaffna University','Ruhuna University','Colombo University','KDU University'] as $school)
                                    <option value="{{ $school }}" @selected(old('school_or_university') == $school)>{{ $school }}</option>
                                @endforeach
                            </select>
                            @error('school_or_university') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="batch" class="form-label fw-bold">Batch</label>
                            <input type="text" class="form-control @error('batch') is-invalid @enderror" id="batch" name="batch" value="{{ old('batch') }}">
                            @error('batch') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    <div class="d-flex justify-content-end gap-2">
                        <a href="{{ route('nurses.index') }}" class="btn btn-secondary">Cancel</a>
                        <button type="submit" class="btn btn-primary">Save Nurse</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
