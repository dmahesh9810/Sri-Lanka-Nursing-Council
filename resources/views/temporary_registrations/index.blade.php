@extends('layouts.app')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2><i class="bi bi-card-checklist text-primary"></i> Temporary Registrations</h2>
        <a href="{{ route('temporary-registrations.create') }}" class="btn btn-primary shadow-sm">
            <i class="bi bi-plus-circle"></i> New Registration
        </a>
    </div>

    <div class="card shadow-sm border-0 mb-4">
        <div class="card-body bg-white rounded-3">
            <form action="{{ route('temporary-registrations.index') }}" method="GET" class="d-flex w-50">
                <div class="input-group">
                    <input type="text" name="search" class="form-control" placeholder="Search by Nurse NIC or Temp Reg No..." value="{{ request('search') }}">
                    <button class="btn btn-outline-secondary" type="submit"><i class="bi bi-search"></i> Search</button>
                    @if(request('search'))
                        <a href="{{ route('temporary-registrations.index') }}" class="btn btn-outline-danger"><i class="bi bi-x-lg"></i> Clear</a>
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
                            <th>Temporary Reg No.</th>
                            <th>Registration Date</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($registrations as $reg)
                            <tr>
                                <td><a href="{{ route('nurses.show', $reg->nurse) }}" class="text-decoration-none fw-bold">{{ $reg->nurse->name }}</a></td>
                                <td><span class="badge bg-secondary">{{ $reg->nurse->nic }}</span></td>
                                <td><span class="badge bg-primary">{{ $reg->temp_registration_no }}</span></td>
                                <td>{{ \Carbon\Carbon::parse($reg->temp_registration_date)->format('d M Y') }}</td>
                                <td class="text-center">
                                    <div class="btn-group btn-group-sm" role="group">
                                        <a href="{{ route('temporary-registrations.show', $reg) }}" class="btn btn-outline-info" title="View"><i class="bi bi-eye"></i></a>
                                        <a href="{{ route('temporary-registrations.edit', $reg) }}" class="btn btn-outline-primary" title="Edit"><i class="bi bi-pencil"></i></a>
                                        <form action="{{ route('temporary-registrations.destroy', $reg) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this temporary registration?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-outline-danger" title="Delete"><i class="bi bi-trash"></i></button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-4 text-muted">
                                    <i class="bi bi-info-circle fs-4 d-block mb-2"></i>
                                    No temporary registrations found. @if(request('search')) Try clearing your search. @else Add a new registration to get started. @endif
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if($registrations->hasPages())
            <div class="card-footer bg-white border-top border-light">
                {{ $registrations->links() }}
            </div>
        @endif
    </div>
@endsection
