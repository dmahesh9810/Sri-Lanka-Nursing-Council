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
            <form action="{{ route('foreign-certificates.index') }}" method="GET" class="d-flex w-50">
                <div class="input-group">
                    <input type="text" name="search" class="form-control" placeholder="Search by NIC, Type, or Country..." value="{{ request('search') }}">
                    <button class="btn btn-outline-secondary" type="submit"><i class="bi bi-search"></i> Search</button>
                    @if(request('search'))
                        <a href="{{ route('foreign-certificates.index') }}" class="btn btn-outline-danger"><i class="bi bi-x-lg"></i> Clear</a>
                    @endif
                </div>
            </form>
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
                                        <span class="badge bg-success"><i class="bi bi-check-circle"></i> Yes</span>
                                    @else
                                        <span class="badge bg-danger"><i class="bi bi-x-circle"></i> No</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    @if($cert->certificate_printed)
                                        <span class="badge bg-success"><i class="bi bi-check-circle"></i> Yes</span>
                                    @else
                                        <span class="badge bg-danger"><i class="bi bi-x-circle"></i> No</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <div class="btn-group btn-group-sm" role="group">
                                        <a href="{{ route('foreign-certificates.show', $cert) }}" class="btn btn-outline-info" title="View"><i class="bi bi-eye"></i></a>
                                        <a href="{{ route('foreign-certificates.edit', $cert) }}" class="btn btn-outline-primary" title="Edit"><i class="bi bi-pencil"></i></a>
                                        @if($cert->certificate_sealed && $cert->issue_date)
                                            <a href="{{ route('certificates.print', $cert->id) }}" class="btn btn-outline-success" title="Preview Certificate" target="_blank"><i class="bi bi-printer"></i></a>
                                            <a href="{{ route('certificates.print', $cert->id) . '?action=download' }}" class="btn btn-outline-secondary" title="Download Certificate" target="_blank"><i class="bi bi-download"></i></a>
                                        @endif
                                        <form action="{{ route('foreign-certificates.destroy', $cert) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this foreign certificate application?');">
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
