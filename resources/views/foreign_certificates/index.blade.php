@extends('layouts.app')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2><i class="bi bi-globe-americas text-primary"></i> Foreign Certificates</h2>
        <a href="{{ route('foreign-certificates.create') }}" class="btn btn-primary shadow-sm">
            <i class="bi bi-plus-circle"></i> New Application
        </a>
    </div>

    <div class="card shadow-sm border-0 mb-4">
        <div class="card-body bg-white rounded-3">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <form action="{{ route('foreign-certificates.index') }}" method="GET" class="d-flex w-50">
                    <div class="input-group">
                        <input type="text" name="search" class="form-control" placeholder="Search by NIC, Type, or Country..." value="{{ request('search') }}">
                        @if(request('type')) <input type="hidden" name="type" value="{{ request('type') }}"> @endif
                        @if(request('country')) <input type="hidden" name="country" value="{{ request('country') }}"> @endif
                        <button class="btn btn-outline-secondary" type="submit"><i class="bi bi-search"></i> Search</button>
                    </div>
                </form>
                <div>
                    <button class="btn btn-outline-secondary" type="button" data-bs-toggle="collapse" data-bs-target="#filterCollapse" aria-expanded="false" aria-controls="filterCollapse">
                        <i class="bi bi-funnel"></i> Filters
                    </button>
                    @if(request('search') || request('type') || request('country'))
                        <a href="{{ route('foreign-certificates.index') }}" class="btn btn-outline-danger ms-2"><i class="bi bi-x-lg"></i> Clear All</a>
                    @endif
                </div>
            </div>

            <div class="collapse {{ request('type') || request('country') ? 'show' : '' }}" id="filterCollapse">
                <form action="{{ route('foreign-certificates.index') }}" method="GET" class="row g-3 py-3 border-top mt-1">
                    @if(request('search')) <input type="hidden" name="search" value="{{ request('search') }}"> @endif
                    
                    <div class="col-md-5">
                        <label for="type" class="form-label text-muted small">Certificate Type</label>
                        <select name="type" id="type" class="form-select form-select-sm">
                            <option value="">All Types</option>
                            <option value="Verification" {{ request('type') == 'Verification' ? 'selected' : '' }}>Verification</option>
                            <option value="Good Standing" {{ request('type') == 'Good Standing' ? 'selected' : '' }}>Good Standing</option>
                            <option value="Confirmation" {{ request('type') == 'Confirmation' ? 'selected' : '' }}>Confirmation</option>
                            <option value="Additional Verification" {{ request('type') == 'Additional Verification' ? 'selected' : '' }}>Additional Verification</option>
                        </select>
                    </div>
                    <div class="col-md-5">
                        <label for="country" class="form-label text-muted small">Country (keyword)</label>
                        <input type="text" name="country" id="country" class="form-control form-control-sm" placeholder="e.g. Australia" value="{{ request('country') }}">
                    </div>
                    <div class="col-md-2 d-flex align-items-end">
                        <button type="submit" class="btn btn-sm btn-primary w-100">Apply Filters</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover table-bordered mb-0 align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Nurse Name</th>
                            <th>NIC</th>
                            <th>Certificate Type</th>
                            <th>Country</th>
                            <th>Apply Date</th>
                            <th>Issue Date</th>
                            <th class="text-center">Sealed</th>
                            <th class="text-center">Printed</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($certificates as $cert)
                            <tr>
                                <td><a href="{{ route('nurses.show', $cert->nurse) }}" class="text-decoration-none fw-bold">{{ $cert->nurse->name }}</a></td>
                                <td><span class="badge bg-secondary">{{ $cert->nurse->nic }}</span></td>
                                <td><span class="badge bg-info text-dark">{{ $cert->certificate_type }}</span></td>
                                <td>{{ $cert->country }}</td>
                                <td>{{ \Carbon\Carbon::parse($cert->apply_date)->format('d M Y') }}</td>
                                <td>{{ $cert->issue_date ? \Carbon\Carbon::parse($cert->issue_date)->format('d M Y') : 'Pending' }}</td>
                                <td class="text-center">
                                    @if($cert->certificate_sealed)
                                        <span class="badge bg-success">Sealed</span>
                                    @else
                                        <span class="badge bg-warning text-dark">Pending</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    @if($cert->certificate_printed)
                                        <span class="badge bg-success">Printed</span>
                                    @else
                                        <span class="badge bg-warning text-dark">Pending</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <div class="btn-group btn-group-sm" role="group">
                                        <a href="{{ route('foreign-certificates.show', $cert) }}" class="btn btn-outline-info" title="View"><i class="bi bi-eye"></i></a>
                                        <a href="{{ route('foreign-certificates.edit', $cert) }}" class="btn btn-outline-primary" title="Edit"><i class="bi bi-pencil"></i></a>
                                        <a href="{{ route('certificates.print', $cert->id) }}" class="btn btn-outline-secondary" title="Preview Certificate" target="_blank"><i class="bi bi-file-earmark-pdf"></i> Preview</a>
                                        <a href="{{ route('certificates.print', ['id' => $cert->id, 'action' => 'download']) }}" class="btn btn-outline-success" title="Download Certificate"><i class="bi bi-download"></i> Download</a>
                                        <form action="{{ route('foreign-certificates.destroy', $cert) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this certificate record?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-outline-danger" title="Delete"><i class="bi bi-trash"></i></button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="text-center py-4 text-muted">
                                    <i class="bi bi-info-circle fs-4 d-block mb-2"></i>
                                    No foreign certificate applications found. @if(request('search')) Try clearing your search. @else Add a new application to get started. @endif
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if($certificates->hasPages())
            <div class="card-footer bg-white border-top border-light">
                {{ $certificates->links() }}
            </div>
        @endif
    </div>
@endsection
