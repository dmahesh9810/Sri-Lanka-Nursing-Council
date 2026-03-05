@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-10">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2><i class="bi bi-person-badge text-primary"></i> Nurse Profile</h2>
            <div>
                <a href="{{ route('nurses.index') }}" class="btn btn-outline-secondary me-2"><i class="bi bi-arrow-left"></i> Back to List</a>
                <a href="{{ route('nurses.edit', $nurse) }}" class="btn btn-primary"><i class="bi bi-pencil"></i> Edit Profile</a>
            </div>
        </div>

        <div class="card shadow-sm border-0 mb-4">
            <div class="card-header bg-white border-bottom py-3">
                <h5 class="mb-0 text-primary">{{ $nurse->name }}</h5>
            </div>
            <div class="card-body p-4">
                <div class="row mb-3">
                    <div class="col-sm-3 text-muted">NIC</div>
                    <div class="col-sm-9 fw-bold"><span class="badge bg-secondary">{{ $nurse->nic }}</span></div>
                </div>
                <hr class="text-muted opacity-25">
                <div class="row mb-3">
                    <div class="col-sm-3 text-muted">Address</div>
                    <div class="col-sm-9">{{ $nurse->address ?: 'N/A' }}</div>
                </div>
                <hr class="text-muted opacity-25">
                <div class="row mb-3">
                    <div class="col-sm-3 text-muted">Phone</div>
                    <div class="col-sm-9">{{ $nurse->phone ?: 'N/A' }}</div>
                </div>
                <hr class="text-muted opacity-25">
                <div class="row mb-3">
                    <div class="col-sm-3 text-muted">Gender</div>
                    <div class="col-sm-9">{{ ucfirst($nurse->gender) ?: 'N/A' }}</div>
                </div>
                <hr class="text-muted opacity-25">
                <div class="row mb-3">
                    <div class="col-sm-3 text-muted">Date of Birth</div>
                    <div class="col-sm-9">{{ $nurse->date_of_birth ? \Carbon\Carbon::parse($nurse->date_of_birth)->format('d M Y') : 'N/A' }}</div>
                </div>
                <hr class="text-muted opacity-25">
                <div class="row mb-3">
                    <div class="col-sm-3 text-muted">School / University</div>
                    <div class="col-sm-9">{{ $nurse->school_or_university ?: 'N/A' }}</div>
                </div>
                <hr class="text-muted opacity-25">
                <div class="row mb-3">
                    <div class="col-sm-3 text-muted">Batch</div>
                    <div class="col-sm-9">{{ $nurse->batch ?: 'N/A' }}</div>
                </div>
                <hr class="text-muted opacity-25">
                <div class="row">
                    <div class="col-sm-3 text-muted">Record Created</div>
                    <div class="col-sm-9">{{ $nurse->created_at->format('d M Y H:i A') }}</div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
