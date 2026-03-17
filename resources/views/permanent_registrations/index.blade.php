@extends('layouts.app')

@section('content')
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold text-gray-800 flex items-center">
            <i class="bi bi-award-fill text-blue-600 mr-3"></i> Permanent Registrations
        </h2>
        <a href="{{ route('permanent-registrations.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg shadow transition duration-200 flex items-center">
            <i class="bi bi-plus-circle mr-2"></i> New Registration
        </a>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 mb-6 overflow-hidden">
        <div class="p-6">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                <form action="{{ route('permanent-registrations.index') }}" method="GET" class="flex w-full md:w-1/2">
                    <div class="flex-1 relative">
                        <input type="text" name="search" class="w-full border-gray-200 rounded-l-lg py-2 pl-4 pr-10 focus:ring-blue-500 focus:border-blue-500 transition-all sm:text-sm border" placeholder="Search by Nurse NIC or Perm Reg No..." value="{{ request('search') }}">
                        @if(request('year')) <input type="hidden" name="year" value="{{ request('year') }}"> @endif
                        @if(request('grade')) <input type="hidden" name="grade" value="{{ request('grade') }}"> @endif
                        @if(request('workplace')) <input type="hidden" name="workplace" value="{{ request('workplace') }}"> @endif
                        <button class="absolute inset-y-0 right-0 px-3 flex items-center text-gray-400 hover:text-blue-600 transition-colors" type="submit">
                            <i class="bi bi-search"></i>
                        </button>
                    </div>
                    @if(request('search') || request('year') || request('grade') || request('workplace'))
                        <a href="{{ route('permanent-registrations.index') }}" class="bg-red-50 text-red-600 border border-red-200 border-l-0 px-4 py-2 text-sm flex items-center hover:bg-red-100 transition-colors font-medium rounded-r-lg">
                            <i class="bi bi-x-lg mr-1"></i> Clear all
                        </a>
                    @endif
                </form>
                <div>
                    <button class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500" type="button" onclick="document.getElementById('filterCollapse').classList.toggle('hidden')">
                        <i class="bi bi-funnel mr-2"></i> Filters
                    </button>
                </div>
            </div>

            <div class="{{ request('year') || request('grade') || request('workplace') ? '' : 'hidden' }} mt-4 pt-4 border-t border-gray-100" id="filterCollapse">
                <form action="{{ route('permanent-registrations.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    @if(request('search')) <input type="hidden" name="search" value="{{ request('search') }}"> @endif
                    <div>
                        <label for="year" class="block text-xs font-medium text-gray-500 uppercase mb-1">Registration Year</label>
                        <select name="year" id="year" class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm border py-1.5">
                            <option value="">All Years</option>
                            @for($i = date('Y'); $i >= 2000; $i--)
                                <option value="{{ $i }}" {{ request('year') == $i ? 'selected' : '' }}>{{ $i }}</option>
                            @endfor
                        </select>
                    </div>
                    <div>
                        <label for="grade" class="block text-xs font-medium text-gray-500 uppercase mb-1">Grade</label>
                        <select name="grade" id="grade" class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm border py-1.5">
                            <option value="">All Grades</option>
                            <option value="Special Grade" {{ request('grade') == 'Special Grade' ? 'selected' : '' }}>Special Grade</option>
                            <option value="Grade I" {{ request('grade') == 'Grade I' ? 'selected' : '' }}>Grade I</option>
                            <option value="Grade II" {{ request('grade') == 'Grade II' ? 'selected' : '' }}>Grade II</option>
                            <option value="Grade III" {{ request('grade') == 'Grade III' ? 'selected' : '' }}>Grade III</option>
                        </select>
                    </div>
                    <div>
                        <label for="workplace" class="block text-xs font-medium text-gray-500 uppercase mb-1">Workplace (keyword)</label>
                        <input type="text" name="workplace" id="workplace" class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm border py-1.5 px-3" placeholder="e.g. Colombo South" value="{{ request('workplace') }}">
                    </div>
                    <div class="flex items-end">
                        <button type="submit" class="w-full bg-gray-800 hover:bg-gray-900 text-white px-4 py-2 rounded-md text-sm font-medium transition-colors">Apply Filters</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead class="bg-gray-50 border-b border-gray-200">
                    <tr>
                        <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Nurse Name</th>
                        <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">NIC</th>
                        <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Perm. Reg No.</th>
                        <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Reg. Date</th>
                        <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Batch</th>
                        <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Grade</th>
                        <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider text-center">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($registrations as $reg)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4">
                                <a href="{{ route('nurses.show', $reg->nurse) }}" class="text-blue-600 hover:text-blue-800 font-semibold transition-colors">{{ $reg->nurse->name }}</a>
                            </td>
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">{{ $reg->nurse->nic }}</span>
                            </td>
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-medium bg-green-50 text-green-700 border border-green-100">{{ $reg->perm_registration_no }}</span>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-600">
                                {{ \Carbon\Carbon::parse($reg->perm_registration_date)->format('d M Y') }}
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-600">{{ $reg->batch ?: '-' }}</td>
                            <td class="px-6 py-4 text-sm text-gray-600">{{ $reg->grade ?: '-' }}</td>
                            <td class="px-6 py-4 text-center">
                                <div class="flex justify-center items-center gap-2">
                                    <a href="{{ route('permanent-registrations.show', $reg) }}" class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg transition-colors" title="View">
                                        <i class="bi bi-eye w-5 h-5 flex justify-center items-center"></i>
                                    </a>
                                    <a href="{{ route('permanent-registrations.edit', $reg) }}" class="p-2 text-indigo-600 hover:bg-indigo-50 rounded-lg transition-colors" title="Edit">
                                        <i class="bi bi-pencil w-5 h-5 flex justify-center items-center"></i>
                                    </a>
                                    <form action="{{ route('permanent-registrations.destroy', $reg) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-2 text-red-600 hover:bg-red-50 rounded-lg transition-colors" title="Delete">
                                            <i class="bi bi-trash w-5 h-5 flex justify-center items-center"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-12 text-center text-gray-500">
                                <i class="bi bi-info-circle text-4xl block mb-4 text-gray-300"></i>
                                <span class="text-lg">No permanent registrations found.</span>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($registrations->hasPages())
            <div class="px-6 py-4 bg-gray-50 border-t border-gray-100">
                {{ $registrations->links() }}
            </div>
        @endif
    </div>
@endsection
