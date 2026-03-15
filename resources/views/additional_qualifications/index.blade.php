@extends('layouts.app')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2><i class="bi bi-mortarboard-fill text-primary"></i> Additional Qualifications</h2>
        <a href="{{ route('additional-qualifications.create') }}" class="btn btn-primary shadow-sm">
            <i class="bi bi-plus-circle"></i> Add Qualification
        </a>
    </div>

    <div class="card shadow-sm border-0 mb-4">
        <div class="card-body bg-white rounded-3">
            <form action="{{ route('additional-qualifications.index') }}" method="GET" class="d-flex w-50">
                <div class="input-group">
                    <input type="text" name="search" class="form-control" placeholder="Search by NIC, Type, or Number..." value="{{ request('search') }}">
                    <button class="btn btn-outline-secondary" type="submit"><i class="bi bi-search"></i> Search</button>
                    @if(request('search'))
                        <a href="{{ route('additional-qualifications.index') }}" class="btn btn-outline-danger"><i class="bi bi-x-lg"></i> Clear</a>
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
                            <th>Qualification Type</th>
                            <th>Number</th>
                            <th>Date</th>
                            <th class="text-center">Printed</th>
                            <th class="text-center">Posted</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($qualifications as $qual)
                            <tr>
                                <td><a href="{{ route('nurses.show', $qual->nurse) }}" class="text-decoration-none fw-bold">{{ $qual->nurse->name }}</a></td>
                                <td><span class="badge bg-secondary">{{ $qual->nurse->nic }}</span></td>
                                <td>{{ $qual->qualification_type }}</td>
                                <td><span class="badge bg-primary">{{ $qual->qualification_number }}</span></td>
                                <td>{{ \Carbon\Carbon::parse($qual->qualification_date)->format('d M Y') }}</td>
                                <td class="text-center">
                                    @if($qual->certificate_printed)
                                        <span class="badge bg-success">Printed</span>
                                    @else
                                        <span class="badge bg-warning text-dark">Pending</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    @if($qual->certificate_posted)
                                        <span class="badge bg-primary">Posted</span>
                                    @else
                                        <span class="badge bg-secondary">Not Posted</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <div class="btn-group btn-group-sm" role="group">
                                        <a href="{{ route('additional-qualifications.show', $qual) }}" class="btn btn-outline-info" title="View"><i class="bi bi-eye"></i></a>
                                        <a href="{{ route('additional-qualifications.edit', $qual) }}" class="btn btn-outline-primary" title="Edit"><i class="bi bi-pencil"></i></a>
                                        <form action="{{ route('additional-qualifications.destroy', $qual) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this qualification?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-outline-danger" title="Delete"><i class="bi bi-trash"></i></button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center py-4 text-muted">
                                    <i class="bi bi-info-circle fs-4 d-block mb-2"></i>
                                    No additional qualifications found. @if(request('search')) Try clearing your search. @else Add a new qualification to get started. @endif
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if($qualifications->hasPages())
            <div class="card-footer bg-white border-top border-light">
                {{ $qualifications->links() }}
            </div>
        @endif
    </div>
@endsection
