@extends('layouts.app')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2><i class="bi bi-people-fill text-primary"></i> Nurses Register</h2>
        <a href="{{ route('nurses.create') }}" class="btn btn-primary shadow-sm">
            <i class="bi bi-plus-circle"></i> Add New Nurse
        </a>
    </div>

    <div class="card shadow-sm border-0 mb-4">
        <div class="card-body bg-white rounded-3">
            <form action="{{ route('nurses.index') }}" method="GET" class="d-flex w-50">
                <div class="input-group">
                    <input type="text" name="search" class="form-control" placeholder="Search by exact or partial NIC..." value="{{ request('search') }}">
                    <button class="btn btn-outline-secondary" type="submit"><i class="bi bi-search"></i> Search</button>
                    @if(request('search'))
                        <a href="{{ route('nurses.index') }}" class="btn btn-outline-danger"><i class="bi bi-x-lg"></i> Clear</a>
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
                            <th>ID</th>
                            <th>Name</th>
                            <th>NIC</th>
                            <th>Phone</th>
                            <th>Gender</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($nurses as $nurse)
                            <tr>
                                <td>{{ $nurse->id }}</td>
                                <td><strong class="text-dark">{{ $nurse->name }}</strong></td>
                                <td><span class="badge bg-secondary">{{ $nurse->nic }}</span></td>
                                <td>{{ $nurse->phone ?: '-' }}</td>
                                <td>{{ ucfirst($nurse->gender) ?: '-' }}</td>
                                <td class="text-center">
                                    <div class="btn-group btn-group-sm" role="group">
                                        <a href="{{ route('nurses.show', $nurse) }}" class="btn btn-outline-info" title="View"><i class="bi bi-eye"></i></a>
                                        <a href="{{ route('nurses.edit', $nurse) }}" class="btn btn-outline-primary" title="Edit"><i class="bi bi-pencil"></i></a>
                                        <form action="{{ route('nurses.destroy', $nurse) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this nurse?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-outline-danger" title="Delete"><i class="bi bi-trash"></i></button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-4 text-muted">
                                    <i class="bi bi-info-circle fs-4 d-block mb-2"></i>
                                    No nurses found. @if(request('search')) Try clearing your search. @else Add a new nurse to get started. @endif
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if($nurses->hasPages())
            <div class="card-footer bg-white border-top border-light">
                {{ $nurses->links() }}
            </div>
        @endif
    </div>
@endsection
