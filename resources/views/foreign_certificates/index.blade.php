@extends('layouts.app')

@section('content')
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold text-gray-800 flex items-center">
            <i class="bi bi-globe-americas text-blue-600 mr-3"></i> Foreign Certificates
        </h2>
        <a href="{{ route('foreign-certificates.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg shadow transition duration-200 flex items-center">
            <i class="bi bi-plus-circle mr-2"></i> New Application
        </a>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 mb-6 overflow-hidden">
        <div class="p-6">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                <form action="{{ route('foreign-certificates.index') }}" method="GET" class="flex w-full md:w-1/2">
                    <div class="flex-1 relative">
                        <input type="text" name="search" class="w-full border-gray-200 rounded-l-lg py-2 pl-4 pr-10 focus:ring-blue-500 focus:border-blue-500 transition-all sm:text-sm border" placeholder="Search by NIC, Type, or Country..." value="{{ request('search') }}">
                        @if(request('type')) <input type="hidden" name="type" value="{{ request('type') }}"> @endif
                        @if(request('country')) <input type="hidden" name="country" value="{{ request('country') }}"> @endif
                        <button class="absolute inset-y-0 right-0 px-3 flex items-center text-gray-400 hover:text-blue-600 transition-colors" type="submit">
                            <i class="bi bi-search"></i>
                        </button>
                    </div>
                </form>
                <div class="flex gap-2 w-full md:w-auto">
                    <button class="flex-1 md:flex-none inline-flex items-center justify-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors" type="button" onclick="document.getElementById('filterCollapse').classList.toggle('hidden')">
                        <i class="bi bi-funnel mr-2"></i> Filters
                    </button>
                    @if(request('search') || request('type') || request('country'))
                        <a href="{{ route('foreign-certificates.index') }}" class="inline-flex items-center justify-center px-4 py-2 border border-red-200 text-sm font-medium rounded-md text-red-600 bg-red-50 hover:bg-red-100 transition-colors">
                            <i class="bi bi-x-lg mr-2"></i> Clear All
                        </a>
                    @endif
                </div>
            </div>

            <div class="{{ request('type') || request('country') ? '' : 'hidden' }} mt-4 pt-4 border-t border-gray-100" id="filterCollapse">
                <form action="{{ route('foreign-certificates.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    @if(request('search')) <input type="hidden" name="search" value="{{ request('search') }}"> @endif
                    
                    <div>
                        <label for="type" class="block text-xs font-medium text-gray-500 uppercase mb-1">Certificate Type</label>
                        <select name="type" id="type" class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm border py-1.5 px-3">
                            <option value="">All Types</option>
                            <option value="Verification" {{ request('type') == 'Verification' ? 'selected' : '' }}>Verification</option>
                            <option value="Good Standing" {{ request('type') == 'Good Standing' ? 'selected' : '' }}>Good Standing</option>
                            <option value="Confirmation" {{ request('type') == 'Confirmation' ? 'selected' : '' }}>Confirmation</option>
                            <option value="Additional Verification" {{ request('type') == 'Additional Verification' ? 'selected' : '' }}>Additional Verification</option>
                        </select>
                    </div>
                    <div>
                        <label for="country" class="block text-xs font-medium text-gray-500 uppercase mb-1">Country (keyword)</label>
                        <input type="text" name="country" id="country" class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm border py-1.5 px-3" placeholder="e.g. Australia" value="{{ request('country') }}">
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
                        <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider text-center">Type</th>
                        <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider text-center">Status</th>
                        <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider text-center">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($certificates as $cert)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4">
                                <a href="{{ route('nurses.show', $cert->nurse) }}" class="text-blue-600 hover:text-blue-800 font-semibold transition-colors">{{ $cert->nurse->name }}</a>
                            </td>
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">{{ $cert->nurse->nic }}</span>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-50 text-blue-700">{{ $cert->certificate_type }}</span>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <div class="flex flex-col gap-1 items-center">
                                    @if($cert->certificate_sealed)
                                        <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-green-100 text-green-800">Sealed</span>
                                    @else
                                        <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-yellow-100 text-yellow-800">Seal Pending</span>
                                    @endif
                                    
                                    @if($cert->certificate_printed)
                                        <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-green-100 text-green-800">Printed</span>
                                    @else
                                        <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-yellow-100 text-yellow-800">Print Pending</span>
                                    @endif
                                </div>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <div class="flex justify-center items-center gap-2">
                                    <a href="{{ route('certificates.print', $cert->id) }}" class="p-2 text-gray-600 hover:bg-gray-100 rounded-lg transition-colors" title="Preview PDF" target="_blank">
                                        <i class="bi bi-file-earmark-pdf w-5 h-5 flex justify-center items-center"></i>
                                    </a>
                                    <a href="{{ route('certificates.print', ['id' => $cert->id, 'action' => 'download']) }}" class="p-2 text-green-600 hover:bg-green-50 rounded-lg transition-colors" title="Download PDF">
                                        <i class="bi bi-download w-5 h-5 flex justify-center items-center"></i>
                                    </a>
                                    <div class="w-px h-4 bg-gray-200 mx-1"></div>
                                    <a href="{{ route('foreign-certificates.show', $cert) }}" class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg transition-colors" title="View Details">
                                        <i class="bi bi-eye w-5 h-5 flex justify-center items-center"></i>
                                    </a>
                                    <a href="{{ route('foreign-certificates.edit', $cert) }}" class="p-2 text-indigo-600 hover:bg-indigo-50 rounded-lg transition-colors" title="Edit">
                                        <i class="bi bi-pencil w-5 h-5 flex justify-center items-center"></i>
                                    </a>
                                    <form action="{{ route('foreign-certificates.destroy', $cert) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure?');">
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
                                <span class="text-lg">No foreign certificate applications found.</span>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($certificates->hasPages())
            <div class="px-6 py-4 bg-gray-50 border-t border-gray-100">
                {{ $certificates->links() }}
            </div>
        @endif
    </div>
@endsection
