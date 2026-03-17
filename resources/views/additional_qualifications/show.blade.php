@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto py-8 px-4 sm:px-6 lg:px-8 tracking-tight">
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-10 gap-6">
        <div>
            <h2 class="text-3xl font-black text-gray-900 flex items-center tracking-tighter uppercase whitespace-nowrap">
                <i class="bi bi-award text-blue-600 mr-4"></i> Qualification Archive
            </h2>
            <p class="text-gray-500 font-bold italic text-xs mt-1 uppercase tracking-widest opacity-80">Extended Practitioner Credentials - Verified Records</p>
        </div>
        <div class="flex gap-3 w-full md:w-auto">
            <a href="{{ route('additional-qualifications.index') }}" class="flex-1 md:flex-initial inline-flex items-center justify-center px-5 py-3 border border-gray-200 text-[10px] font-black uppercase tracking-widest rounded-2xl text-gray-700 bg-white hover:bg-gray-50 transition-all shadow-sm">
                <i class="bi bi-arrow-left mr-2"></i> Registry List
            </a>
            <a href="{{ route('additional-qualifications.edit', $additionalQualification) }}" class="flex-1 md:flex-initial inline-flex items-center justify-center px-5 py-3 border border-transparent text-[10px] font-black uppercase tracking-widest rounded-2xl text-white bg-blue-600 hover:bg-blue-700 transition-all shadow-xl shadow-blue-100">
                <i class="bi bi-pencil mr-2"></i> Edit Protocol
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-10">
        <!-- Qualification Info -->
        <div class="bg-white rounded-[2.5rem] shadow-2xl shadow-gray-100 border border-gray-100 overflow-hidden flex flex-col h-full">
            <div class="px-8 py-6 border-b border-gray-50 bg-gray-50/30 flex items-center justify-between">
                <h5 class="text-sm font-black text-blue-900 uppercase tracking-widest flex items-center gap-2 italic">
                    <i class="bi bi-mortarboard text-blue-600"></i> Academic Extension
                </h5>
                <span class="text-[10px] font-black text-gray-400 italic">VERIFIED BY SLNC</span>
            </div>
            
            <div class="p-8 space-y-8 flex-grow">
                <div class="group">
                    <div class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2 group-hover:text-blue-500 transition-colors italic">Credential Specification</div>
                    <div class="text-xl font-black text-gray-900 leading-tight">
                        {{ $additionalQualification->qualification_type }}
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-8 border-t border-gray-50 pt-8">
                    <div class="group">
                        <div class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2 group-hover:text-blue-500 transition-colors italic">Protocol Number</div>
                        <div class="text-lg font-black text-blue-600 bg-blue-50 inline-block px-4 py-1 rounded-xl border border-blue-100 tracking-widest shadow-inner">
                            {{ $additionalQualification->qualification_number }}
                        </div>
                    </div>
                    <div class="group">
                        <div class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2 group-hover:text-blue-500 transition-colors italic">Authorization Date</div>
                        <div class="text-lg font-bold text-gray-800">{{ \Carbon\Carbon::parse($additionalQualification->qualification_date)->format('d M Y') }}</div>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-8 border-t border-gray-50 pt-8">
                    <div class="group">
                        <div class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-3 group-hover:text-blue-500 transition-colors italic">Issuance Status (Print)</div>
                        @if($additionalQualification->certificate_printed)
                            <span class="inline-flex items-center px-4 py-2 rounded-2xl bg-emerald-50 text-emerald-700 text-[10px] font-black uppercase tracking-widest border border-emerald-100">
                                <i class="bi bi-check-circle-fill mr-2"></i> Executed
                            </span>
                        @else
                            <span class="inline-flex items-center px-4 py-2 rounded-2xl bg-red-50 text-red-700 text-[10px] font-black uppercase tracking-widest border border-red-100">
                                <i class="bi bi-clock-history mr-2"></i> Pending
                            </span>
                        @endif
                    </div>
                    <div class="group">
                        <div class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-3 group-hover:text-blue-500 transition-colors italic">Distribution Status (Postal)</div>
                        @if($additionalQualification->certificate_posted)
                            <span class="inline-flex items-center px-4 py-2 rounded-2xl bg-emerald-50 text-emerald-700 text-[10px] font-black uppercase tracking-widest border border-emerald-100">
                                <i class="bi bi-mailbox2 mr-2"></i> Dispatched
                            </span>
                        @else
                            <span class="inline-flex items-center px-4 py-2 rounded-2xl bg-gray-50 text-gray-400 text-[10px] font-black uppercase tracking-widest border border-gray-100">
                                <i class="bi bi-dash-circle mr-2"></i> Not Dispatched
                            </span>
                        @endif
                    </div>
                </div>
            </div>
            
            <div class="px-8 py-5 bg-gray-50/30 border-t border-gray-50 flex justify-between items-center text-[10px] font-bold text-gray-400 uppercase tracking-widest italic">
                <span>Created: {{ $additionalQualification->created_at->format('d M Y') }}</span>
                <span>UUID: #AQ{{ str_pad($additionalQualification->id, 4, '0', STR_PAD_LEFT) }}</span>
            </div>
        </div>

        <!-- Practitioner Context Card -->
        <div class="bg-white rounded-[2.5rem] shadow-2xl shadow-indigo-100 border border-indigo-50 overflow-hidden flex flex-col h-full ring-4 ring-indigo-50/50">
            <div class="px-8 py-6 border-b border-indigo-50 bg-indigo-50/10 flex items-center justify-between">
                <h5 class="text-sm font-black text-indigo-900 uppercase tracking-widest flex items-center gap-2">
                    <i class="bi bi-person-badge text-indigo-600"></i> Identity Context
                </h5>
                <a href="{{ route('nurses.show', $additionalQualification->nurse) }}" class="text-[10px] font-black text-indigo-600 uppercase tracking-widest hover:underline decoration-2 underline-offset-4 transition-all">
                    View Full Profile <i class="bi bi-arrow-right ml-1"></i>
                </a>
            </div>
            
            <div class="p-10 space-y-10 flex-grow bg-gradient-to-br from-white to-indigo-50/20">
                <div class="flex items-start gap-6">
                    <div class="w-16 h-16 bg-indigo-600 rounded-3xl flex items-center justify-center text-white shadow-lg shadow-indigo-200">
                        <i class="bi bi-fingerprint text-3xl"></i>
                    </div>
                    <div>
                        <h4 class="text-2xl font-black text-gray-900 tracking-tighter uppercase leading-tight">{{ $additionalQualification->nurse->name }}</h4>
                        <div class="flex items-center gap-3 mt-2">
                            <span class="text-[10px] font-black text-indigo-600 uppercase bg-indigo-100 px-3 py-1 rounded-xl tracking-tighter">Canonical NIC</span>
                            <span class="text-sm font-black text-gray-800 tracking-widest">{{ $additionalQualification->nurse->nic }}</span>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-8 border-t border-indigo-100 pt-8">
                    <div class="group">
                        <div class="text-[10px] font-black text-indigo-400 uppercase tracking-widest mb-1 italic">Contact Terminal</div>
                        <div class="text-base text-gray-900 font-bold font-mono">{{ $additionalQualification->nurse->phone ?: 'N/A' }}</div>
                    </div>
                    <div class="group">
                        <div class="text-[10px] font-black text-indigo-400 uppercase tracking-widest mb-1 italic">Authorized Batch</div>
                        <div class="text-base text-gray-900 font-bold italic">{{ $additionalQualification->nurse->batch ?: 'N/A' }}</div>
                    </div>
                </div>
                
                <div class="group">
                    <div class="text-[10px] font-black text-indigo-400 uppercase tracking-widest mb-1 italic">Scientific Institution</div>
                    <div class="text-base text-gray-900 font-bold leading-relaxed">{{ $additionalQualification->nurse->school_or_university ?: 'N/A' }}</div>
                </div>

                <div class="group pt-6 border-t border-indigo-50/50">
                    <div class="text-[10px] font-black text-indigo-400 uppercase tracking-widest mb-3 italic">Active Permanent Authorization</div>
                    @if($additionalQualification->nurse->permanentRegistration)
                        <div class="flex items-center gap-4 bg-emerald-600/5 p-4 rounded-2xl border border-emerald-100">
                            <i class="bi bi-shield-lock text-emerald-600 text-xl"></i>
                            <div>
                                <div class="text-xs font-black text-emerald-900 tracking-tight">{{ $additionalQualification->nurse->permanentRegistration->perm_registration_no }}</div>
                                <div class="text-[9px] font-bold text-emerald-400 uppercase tracking-widest italic leading-none">Registered on {{ \Carbon\Carbon::parse($additionalQualification->nurse->permanentRegistration->perm_registration_date)->format('d M Y') }}</div>
                            </div>
                        </div>
                    @else
                        <div class="flex items-center gap-4 bg-amber-50 p-4 rounded-2xl border border-amber-100">
                            <i class="bi bi-exclamation-triangle text-amber-500 text-xl"></i>
                            <span class="text-[10px] font-black text-amber-700 uppercase tracking-widest italic">Permanent Status Missing</span>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
