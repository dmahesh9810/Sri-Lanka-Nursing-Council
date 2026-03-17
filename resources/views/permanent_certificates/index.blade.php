@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto py-8">
    <div class="flex justify-between items-center mb-8">
        <h2 class="text-3xl font-extrabold text-gray-900 flex items-center">
            <i class="bi bi-printer text-blue-600 mr-4"></i> Permanent Certificate Printing
        </h2>
    </div>

    <!-- Search Card -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 mb-8 overflow-hidden">
        <div class="p-6 bg-gray-50/50">
            <form action="{{ route('permanent-certificates.index') }}" method="GET" class="flex flex-col md:flex-row items-end gap-4">
                <div class="flex-1 w-full">
                    <label for="nic" class="block text-sm font-bold text-gray-700 mb-2">Search Nurse by NIC</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400">
                            <i class="bi bi-search"></i>
                        </span>
                        <input type="text" class="block w-full border-gray-200 rounded-xl pl-10 pr-4 py-2.5 focus:ring-blue-500 focus:border-blue-500 sm:text-sm border transition-all" id="nic" name="nic" value="{{ request('nic') }}" placeholder="Enter NIC...">
                    </div>
                </div>
                <div class="w-full md:w-32">
                    <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-2.5 px-4 rounded-xl shadow-sm transition-all duration-200">
                        Search
                    </button>
                </div>
                @if(request('nic'))
                <div class="w-full md:w-32">
                    <a href="{{ route('permanent-certificates.index') }}" class="w-full bg-white border-gray-200 border text-gray-600 hover:bg-gray-50 font-bold py-2.5 px-4 rounded-xl shadow-sm transition-all duration-200 text-center block">
                        Clear
                    </a>
                </div>
                @endif
            </form>
        </div>
    </div>

    <!-- Results Table -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead class="bg-gray-50 border-b border-gray-200">
                    <tr>
                        <th class="px-6 py-4 text-xs font-black text-gray-500 uppercase tracking-widest">Permanent Reg. No</th>
                        <th class="px-6 py-4 text-xs font-black text-gray-500 uppercase tracking-widest">Nurse Name</th>
                        <th class="px-6 py-4 text-xs font-black text-gray-500 uppercase tracking-widest">NIC</th>
                        <th class="px-6 py-4 text-xs font-black text-gray-500 uppercase tracking-widest text-center">Printed Status</th>
                        <th class="px-6 py-4 text-xs font-black text-gray-500 uppercase tracking-widest text-center">Posted Status</th>
                        <th class="px-6 py-4 text-xs font-black text-gray-500 uppercase tracking-widest text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 italic font-medium">
                    @forelse($registrations as $reg)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4 shrink-0">
                                <span class="inline-flex items-center px-3 py-1 bg-blue-100 text-blue-700 text-xs font-black rounded-lg uppercase tracking-tighter">{{ $reg->perm_registration_no }}</span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm font-bold text-gray-900 not-italic">{{ $reg->nurse->name ?? 'N/A' }}</div>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-600">{{ $reg->nurse->nic ?? 'N/A' }}</td>
                            
                            <td class="px-6 py-4">
                                <form action="{{ route('permanent-certificates.status', $reg->id) }}" method="POST" class="flex flex-col items-center gap-2">
                                    @csrf
                                    @if($reg->certificate_printed)
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-black bg-emerald-100 text-emerald-700 uppercase tracking-tighter shadow-sm">Printed</span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-black bg-orange-100 text-orange-700 uppercase tracking-tighter shadow-sm">Pending</span>
                                    @endif
                                    <label class="relative inline-flex items-center cursor-pointer">
                                        <input type="checkbox" name="certificate_printed" value="1" {{ $reg->certificate_printed ? 'checked' : '' }} onChange="this.form.submit()" class="sr-only peer">
                                        <div class="w-9 h-5 bg-gray-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-blue-600"></div>
                                    </label>
                                </form>
                            </td>

                            <td class="px-6 py-4 text-center">
                                <form action="{{ route('permanent-certificates.status', $reg->id) }}" method="POST" class="flex flex-col items-center gap-2">
                                    @csrf
                                    @if($reg->certificate_posted)
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-black bg-blue-100 text-blue-700 uppercase tracking-tighter shadow-sm">Posted</span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-black bg-gray-100 text-gray-500 uppercase tracking-tighter shadow-sm">Not Posted</span>
                                    @endif
                                    <label class="relative inline-flex items-center cursor-pointer">
                                        <input type="checkbox" name="certificate_posted" value="1" {{ $reg->certificate_posted ? 'checked' : '' }} onChange="this.form.submit()" class="sr-only peer">
                                        <div class="w-9 h-5 bg-gray-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-blue-600"></div>
                                    </label>
                                </form>
                            </td>

                            <td class="px-6 py-4 text-right">
                                <a href="{{ route('permanent-certificates.print', $reg->id) }}" target="_blank" class="print-cert-btn inline-flex items-center px-3 py-1.5 border border-emerald-600 text-emerald-600 hover:bg-emerald-600 hover:text-white transition-all text-xs font-black rounded-lg uppercase tracking-tight gap-1 not-italic">
                                    <i class="bi bi-file-earmark-pdf"></i> PRINT CERT
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center text-gray-400">
                                <i class="bi bi-inbox text-4xl block mb-4 text-gray-200"></i>
                                <span class="text-sm font-medium">No permanent registrations found in queue.</span>
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
</div>

<!-- Loading Overlay -->
<div id="loadingOverlay" class="hidden fixed inset-0 bg-white/95 backdrop-blur-md z-50 flex flex-col items-center justify-center transition-all duration-300">
    <div class="relative w-24 h-24 mb-8">
        <div class="absolute inset-0 border-8 border-gray-100 rounded-full"></div>
        <div class="absolute inset-0 border-8 border-emerald-600 rounded-full border-t-transparent animate-spin shadow-inner"></div>
    </div>
    <div class="text-2xl font-black text-gray-900 mb-3 tracking-tight">Preparing Certificate PDF</div>
    <div class="text-gray-500 font-medium italic">Rasterizing council layout...</div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const printLinks = document.querySelectorAll('.print-cert-btn');
        const overlay = document.getElementById('loadingOverlay');

        printLinks.forEach(link => {
            link.addEventListener('click', function() {
                overlay.classList.remove('hidden');
                // Hide overlay after 3 seconds since it opens in new tab
                setTimeout(() => {
                    overlay.classList.add('hidden');
                }, 3000);
            });
        });
    });
</script>
@endsection
