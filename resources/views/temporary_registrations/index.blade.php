@extends('layouts.app')

@section('content')
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold text-gray-800 flex items-center">
            <i class="bi bi-card-checklist text-blue-600 mr-3"></i> Temporary Registrations
        </h2>
        <a href="{{ route('temporary-registrations.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg shadow transition duration-200 flex items-center">
            <i class="bi bi-plus-circle mr-2"></i> New Registration
        </a>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 mb-6 overflow-hidden">
        <div class="p-4">
            <form action="{{ route('temporary-registrations.index') }}" method="GET" class="flex max-w-lg">
                <div class="flex-1 relative">
                    <input type="text" name="search" class="w-full border-gray-200 rounded-l-lg py-2 pl-4 pr-10 focus:ring-blue-500 focus:border-blue-500 transition-all sm:text-sm border" placeholder="Search by Nurse NIC or Temp Reg No..." value="{{ request('search') }}">
                    <button class="absolute inset-y-0 right-0 px-3 flex items-center text-gray-400 hover:text-blue-600 transition-colors" type="submit">
                        <i class="bi bi-search"></i>
                    </button>
                </div>
                @if(request('search'))
                    <a href="{{ route('temporary-registrations.index') }}" class="bg-red-50 text-red-600 border border-red-200 border-l-0 px-4 py-2 text-sm flex items-center hover:bg-red-100 transition-colors font-medium rounded-r-lg">
                        <i class="bi bi-x-lg mr-1"></i> Clear
                    </a>
                @endif
            </form>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead class="bg-gray-50 border-b border-gray-200">
                    <tr>
                        <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Nurse Name</th>
                        <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">NIC</th>
                        <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Temporary Reg No.</th>
                        <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider text-center">Registration Date</th>
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
                                <span class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-medium bg-blue-50 text-blue-700 border border-blue-100">{{ $reg->temp_registration_no }}</span>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-600 text-center">
                                {{ \Carbon\Carbon::parse($reg->temp_registration_date)->format('d M Y') }}
                            </td>
                            <td class="px-6 py-4 text-center">
                                <div class="flex justify-center items-center gap-2">
                                    <a href="{{ route('temporary-registrations.show', $reg) }}" class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg transition-colors" title="View">
                                        <i class="bi bi-eye w-5 h-5 flex justify-center items-center"></i>
                                    </a>
                                    <a href="{{ route('temporary-registrations.edit', $reg) }}" class="p-2 text-indigo-600 hover:bg-indigo-50 rounded-lg transition-colors" title="Edit">
                                        <i class="bi bi-pencil w-5 h-5 flex justify-center items-center"></i>
                                    </a>
                                    <form action="{{ route('temporary-registrations.destroy', $reg) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure?');">
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
                            <td colspan="5" class="px-6 py-12 text-center text-gray-500">
                                <i class="bi bi-info-circle text-4xl block mb-4 text-gray-300"></i>
                                <span class="text-lg">No temporary registrations found.</span>
                                @if(request('search'))
                                    <p class="mt-2">Try clearing your search results.</p>
                                @endif
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($registrations->hasPages())
            <div class="px-6 py-4 bg-gray-50 border-top border-gray-100">
                {{ $registrations->links() }}
            </div>
        @endif
    </div>
@endsection
