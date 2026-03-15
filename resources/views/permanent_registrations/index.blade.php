@extends('layouts.app')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2><i class="bi bi-award-fill text-primary"></i> Permanent Registrations</h2>
        <a href="{{ route('permanent-registrations.create') }}" class="btn btn-primary shadow-sm">
            <i class="bi bi-plus-circle"></i> New Registration
        </a>
    </div>

    <div class="card shadow-sm border-0 mb-4">
        <div class="card-body bg-white rounded-3">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <form action="{{ route('permanent-registrations.index') }}" method="GET" class="d-flex w-50">
                    <div class="input-group">
                        <input type="text" name="search" class="form-control" placeholder="Search by Nurse NIC or Perm Reg No..." value="{{ request('search') }}">
                        @if(request('year')) <input type="hidden" name="year" value="{{ request('year') }}"> @endif
                        @if(request('grade')) <input type="hidden" name="grade" value="{{ request('grade') }}"> @endif
                        @if(request('workplace')) <input type="hidden" name="workplace" value="{{ request('workplace') }}"> @endif
                        <button class="btn btn-outline-secondary" type="submit"><i class="bi bi-search"></i> Search</button>
                    </div>
                </form>
                <div>
                    <button class="btn btn-outline-secondary" type="button" data-bs-toggle="collapse" data-bs-target="#filterCollapse" aria-expanded="false" aria-controls="filterCollapse">
                        <i class="bi bi-funnel"></i> Filters
                    </button>
                    @if(request('search') || request('year') || request('grade') || request('workplace'))
                        <a href="{{ route('permanent-registrations.index') }}" class="btn btn-outline-danger ms-2"><i class="bi bi-x-lg"></i> Clear All</a>
                    @endif
                </div>
            </div>

            <div class="collapse {{ request('year') || request('grade') || request('workplace') ? 'show' : '' }}" id="filterCollapse">
                <form action="{{ route('permanent-registrations.index') }}" method="GET" class="row g-3 py-3 border-top mt-1">
                    @if(request('search')) <input type="hidden" name="search" value="{{ request('search') }}"> @endif
                    <div class="col-md-3">
                        <label for="year" class="form-label text-muted small">Registration Year</label>
                        <select name="year" id="year" class="form-select form-select-sm">
                            <option value="">All Years</option>
                            @for($i = date('Y'); $i >= 2000; $i--)
                                <option value="{{ $i }}" {{ request('year') == $i ? 'selected' : '' }}>{{ $i }}</option>
                            @endfor
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label for="grade" class="form-label text-muted small">Grade</label>
                        <select name="grade" id="grade" class="form-select form-select-sm">
                            <option value="">All Grades</option>
                            <option value="Special Grade" {{ request('grade') == 'Special Grade' ? 'selected' : '' }}>Special Grade</option>
                            <option value="Grade I" {{ request('grade') == 'Grade I' ? 'selected' : '' }}>Grade I</option>
                            <option value="Grade II" {{ request('grade') == 'Grade II' ? 'selected' : '' }}>Grade II</option>
                            <option value="Grade III" {{ request('grade') == 'Grade III' ? 'selected' : '' }}>Grade III</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label for="workplace" class="form-label text-muted small">Workplace (keyword)</label>
                        <input type="text" name="workplace" id="workplace" class="form-control form-control-sm" placeholder="e.g. Colombo South" value="{{ request('workplace') }}">
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
                            <th>Permanent Reg No.</th>
                            <th>Registration Date</th>
                            <th>Grade</th>
                            <th>Workplace</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($registrations as $reg)
                            <tr>
                                <td><a href="{{ route('nurses.show', $reg->nurse) }}" class="text-decoration-none fw-bold">{{ $reg->nurse->name }}</a></td>
                                <td><span class="badge bg-secondary">{{ $reg->nurse->nic }}</span></td>
                                <td><span class="badge bg-success">{{ $reg->perm_registration_no }}</span></td>
                                <td>{{ \Carbon\Carbon::parse($reg->perm_registration_date)->format('d M Y') }}</td>
                                <td>{{ $reg->grade ?: '-' }}</td>
                                <td>{{ $reg->present_workplace ?: '-' }}</td>
                                <td class="text-center">
                                    <div class="btn-group btn-group-sm" role="group">
                                        <a href="{{ route('permanent-registrations.show', $reg) }}" class="btn btn-outline-info" title="View"><i class="bi bi-eye"></i></a>
                                        <a href="{{ route('permanent-registrations.edit', $reg) }}" class="btn btn-outline-primary" title="Edit"><i class="bi bi-pencil"></i></a>
                                        <form action="{{ route('permanent-registrations.destroy', $reg) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this permanent registration?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-outline-danger" title="Delete"><i class="bi bi-trash"></i></button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-4 text-muted">
                                    <i class="bi bi-info-circle fs-4 d-block mb-2"></i>
                                    No permanent registrations found. @if(request('search')) Try clearing your search. @else Add a new registration to get started. @endif
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
