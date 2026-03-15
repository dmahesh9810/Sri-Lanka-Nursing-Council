@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-12">
        
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2><i class="bi bi-printer me-2"></i> Permanent Certificate Printing</h2>
        </div>

        <!-- Search Card -->
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-body bg-light">
                <form action="{{ route('permanent-certificates.index') }}" method="GET" class="row align-items-end">
                    <div class="col-md-5">
                        <label for="nic" class="form-label fw-bold">Search Nurse by NIC</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-search"></i></span>
                            <input type="text" class="form-control" id="nic" name="nic" value="{{ request('nic') }}" placeholder="Enter NIC...">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <button type="submit" class="btn btn-primary w-100">Search</button>
                    </div>
                    @if(request('nic'))
                    <div class="col-md-2">
                        <a href="{{ route('permanent-certificates.index') }}" class="btn btn-outline-secondary w-100">Clear</a>
                    </div>
                    @endif
                </form>
            </div>
        </div>

        <!-- Results Table -->
        <div class="card shadow-sm border-0">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0 align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>Permanent Reg. No</th>
                                <th>Nurse Name</th>
                                <th>NIC</th>
                                <th>Printed</th>
                                <th>Posted</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($registrations as $reg)
                                <tr>
                                    <td><span class="badge bg-primary">{{ $reg->perm_registration_no }}</span></td>
                                    <td>
                                        <div class="fw-bold">{{ $reg->nurse->name ?? 'N/A' }}</div>
                                    </td>
                                    <td>{{ $reg->nurse->nic ?? 'N/A' }}</td>
                                    
                                    <form action="{{ route('permanent-certificates.status', $reg->id) }}" method="POST">
                                        @csrf
                                        <td>
                                            <div class="form-check form-switch">
                                                <input class="form-check-input" type="checkbox" role="switch" name="certificate_printed" value="1" {{ $reg->certificate_printed ? 'checked' : '' }} onChange="this.form.submit()">
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-check form-switch">
                                                <input class="form-check-input" type="checkbox" role="switch" name="certificate_posted" value="1" {{ $reg->certificate_posted ? 'checked' : '' }} onChange="this.form.submit()">
                                            </div>
                                        </td>
                                    </form>

                                    <td>
                                        <div class="btn-group">
                                            <a href="{{ route('permanent-certificates.print', $reg->id) }}" target="_blank" class="btn btn-sm btn-outline-success">
                                                <i class="bi bi-file-earmark-pdf"></i> Print PDF
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center py-4 text-muted">
                                        <i class="bi bi-inbox fs-2 d-block mb-2"></i>
                                        No permanent registrations found.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            @if($registrations->hasPages())
                <div class="card-footer bg-white border-0 pt-3">
                    {{ $registrations->links() }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
