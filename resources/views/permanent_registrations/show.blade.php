@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto py-8 px-4 sm:px-6 lg:px-8 tracking-tight">
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-10 gap-6">
        <div>
            <h2 class="text-3xl font-black text-gray-900 flex items-center tracking-tighter uppercase whitespace-nowrap">
                <i class="bi bi-award-fill text-emerald-600 mr-4"></i> Permanent Status
            </h2>
            <p class="text-gray-500 font-bold italic text-xs mt-1 uppercase tracking-widest opacity-80">Canonical Practitioner Registry - Official Certification</p>
        </div>
        <div class="flex gap-3 w-full md:w-auto">
            <a href="{{ route('permanent-registrations.index') }}" class="flex-1 md:flex-initial inline-flex items-center justify-center px-5 py-3 border border-gray-200 text-[10px] font-black uppercase tracking-widest rounded-2xl text-gray-700 bg-white hover:bg-gray-50 transition-all shadow-sm">
                <i class="bi bi-arrow-left mr-2"></i> Registry List
            </a>
            <a href="{{ route('permanent-registrations.edit', $permanentRegistration) }}" class="flex-1 md:flex-initial inline-flex items-center justify-center px-5 py-3 border border-transparent text-[10px] font-black uppercase tracking-widest rounded-2xl text-white bg-emerald-600 hover:bg-emerald-700 transition-all shadow-xl shadow-emerald-100">
                <i class="bi bi-pencil mr-2"></i> Edit Record
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-10">
        <!-- Registration Details Card -->
        <div class="bg-white rounded-[2.5rem] shadow-2xl shadow-gray-100 border border-gray-100 overflow-hidden flex flex-col h-full">
            <div class="px-8 py-6 border-b border-gray-50 bg-gray-50/30 flex items-center justify-between">
                <h5 class="text-sm font-black text-emerald-900 uppercase tracking-widest flex items-center gap-2 italic">
                    <i class="bi bi-shield-check text-emerald-600"></i> Lifetime Certification
                </h5>
                <span class="text-[10px] font-black text-gray-400 italic">VERIFIED</span>
            </div>
            
            <div class="p-8 space-y-8 flex-grow">
                <div class="group">
                    <div class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2 group-hover:text-emerald-500 transition-colors">Permanent Ledger Serial</div>
                    <div class="text-2xl font-black text-gray-900 bg-emerald-50 inline-block px-4 py-1.5 rounded-2xl border border-emerald-100 shadow-inner tracking-widest">
                        {{ $permanentRegistration->perm_registration_no }}
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-8 border-t border-gray-50 pt-8">
                    <div class="group">
                        <div class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1 group-hover:text-emerald-500 transition-colors italic">Registration Date</div>
                        <div class="text-base font-bold text-gray-800">{{ \Carbon\Carbon::parse($permanentRegistration->perm_registration_date)->format('d M Y') }}</div>
                    </div>
                    <div class="group">
                        <div class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1 group-hover:text-emerald-500 transition-colors italic">Appointment Authorization</div>
                        <div class="text-base font-bold text-gray-800">{{ $permanentRegistration->appointment_date ? \Carbon\Carbon::parse($permanentRegistration->appointment_date)->format('d M Y') : 'N/A' }}</div>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-8 border-t border-gray-50 pt-8">
                    <div class="group">
                        <div class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1 group-hover:text-emerald-500 transition-colors italic">Grade Level</div>
                        <div class="text-base font-bold text-emerald-600 bg-emerald-50 px-3 py-1 rounded-xl border border-emerald-100 inline-block">{{ $permanentRegistration->grade ?: 'N/A' }}</div>
                    </div>
                    <div class="group">
                        <div class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1 group-hover:text-emerald-500 transition-colors italic">Active Workplace</div>
                        <div class="text-base font-bold text-gray-800 truncate" title="{{ $permanentRegistration->present_workplace }}">{{ $permanentRegistration->present_workplace ?: 'N/A' }}</div>
                    </div>
                </div>

                <div class="group border-t border-gray-50 pt-8">
                    <div class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1 group-hover:text-emerald-500 transition-colors italic">Primary Credential Address</div>
                    <div class="text-base font-bold text-gray-800 leading-relaxed">{{ $permanentRegistration->address ?: 'N/A' }}</div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-8 border-t border-gray-50 pt-8">
                    <div class="group">
                        <div class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1 group-hover:text-emerald-500 transition-colors italic">Cohort / Batch</div>
                        <div class="text-base font-bold text-gray-800">{{ $permanentRegistration->batch ?: 'N/A' }}</div>
                    </div>
                    <div class="group">
                        <div class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1 group-hover:text-emerald-500 transition-colors italic">Primary Qualification</div>
                        <span class="inline-flex px-3 py-1 rounded-xl bg-blue-50 border border-blue-100 text-blue-700 text-[10px] font-black uppercase tracking-tight">{{ $permanentRegistration->qualification ?: 'N/A' }}</span>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-8 border-t border-gray-50 pt-8">
                    <div class="group">
                        <div class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1 group-hover:text-emerald-500 transition-colors italic">SLMC Identification</div>
                        <div class="text-base font-bold text-gray-800">{{ $permanentRegistration->slmc_no ?: 'N/A' }}</div>
                    </div>
                    <div class="group">
                        <div class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1 group-hover:text-emerald-500 transition-colors italic">SLMC Authorization Date</div>
                        <div class="text-base font-bold text-gray-800 italic">{{ $permanentRegistration->slmc_date ? \Carbon\Carbon::parse($permanentRegistration->slmc_date)->format('d M Y') : 'N/A' }}</div>
                    </div>
                </div>
            </div>
            
            <div class="px-8 py-5 bg-gray-50/30 border-t border-gray-50 flex justify-between items-center text-[10px] font-bold text-gray-400 uppercase tracking-widest italic">
                <span>Created: {{ $permanentRegistration->created_at->format('d M Y') }}</span>
                <span>ID: #PR{{ str_pad($permanentRegistration->id, 5, '0', STR_PAD_LEFT) }}</span>
            </div>
        </div>

        <!-- Practitioner Persona Card -->
        <div class="bg-white rounded-[2.5rem] shadow-2xl shadow-indigo-100 border border-indigo-50 overflow-hidden flex flex-col h-full ring-4 ring-indigo-50/50">
            <div class="px-8 py-6 border-b border-indigo-50 bg-indigo-50/10 flex items-center justify-between">
                <h5 class="text-sm font-black text-indigo-900 uppercase tracking-widest flex items-center gap-2">
                    <i class="bi bi-person-badge text-indigo-600"></i> Associated Practitioner
                </h5>
                <a href="{{ route('nurses.show', $permanentRegistration->nurse) }}" class="text-[10px] font-black text-indigo-600 uppercase tracking-widest hover:underline decoration-2 underline-offset-4 transition-all whitespace-nowrap">
                    Canonical Identity <i class="bi bi-arrow-right ml-1"></i>
                </a>
            </div>
            
            <div class="p-10 space-y-10 flex-grow bg-gradient-to-br from-white to-indigo-50/30">
                <div class="flex items-start gap-6">
                    <div class="w-16 h-16 bg-indigo-600 rounded-3xl flex items-center justify-center text-white shadow-lg shadow-indigo-200">
                        <i class="bi bi-person-bounding-box text-3xl"></i>
                    </div>
                    <div>
                        <h4 class="text-2xl font-black text-gray-900 tracking-tighter uppercase leading-tight">{{ $permanentRegistration->nurse->name }}</h4>
                        <div class="flex items-center gap-3 mt-2">
                            <span class="text-[10px] font-black text-indigo-600 uppercase bg-indigo-100 px-3 py-1 rounded-xl tracking-tighter">Unified NIC</span>
                            <span class="text-sm font-black text-gray-800 tracking-widest">{{ $permanentRegistration->nurse->nic }}</span>
                        </div>
                    </div>
                </div>

                <div class="space-y-6 pt-8 border-t border-indigo-100">
                    <div class="grid grid-cols-2 gap-10">
                        <div class="group">
                            <div class="text-[10px] font-black text-indigo-400 uppercase tracking-widest mb-1 italic">Contact Terminal</div>
                            <div class="text-base text-gray-900 font-bold font-mono">{{ $permanentRegistration->nurse->phone ?: 'N/A' }}</div>
                        </div>
                        <div class="group">
                            <div class="text-[10px] font-black text-indigo-400 uppercase tracking-widest mb-1 italic">Cohort Cycle</div>
                            <div class="text-base text-gray-900 font-bold italic">{{ $permanentRegistration->nurse->batch ?: 'N/A' }}</div>
                        </div>
                    </div>
                    
                    <div class="group">
                        <div class="text-[10px] font-black text-indigo-400 uppercase tracking-widest mb-1 italic">Primary Institution</div>
                        <div class="text-base text-gray-900 font-bold leading-relaxed">{{ $permanentRegistration->nurse->school_or_university ?: 'N/A' }}</div>
                    </div>

                    <div class="group pt-6 border-t border-indigo-50/50">
                        <div class="text-[10px] font-black text-indigo-400 uppercase tracking-widest mb-3 italic">Preliminary Registration Protocol</div>
                        @if($permanentRegistration->nurse->temporaryRegistration)
                            <div class="flex items-center gap-4 bg-indigo-600/5 p-4 rounded-2xl border border-indigo-100">
                                <i class="bi bi-file-earmark-medical text-indigo-600 text-xl"></i>
                                <div>
                                    <div class="text-xs font-black text-indigo-900 tracking-tight">{{ $permanentRegistration->nurse->temporaryRegistration->temp_registration_no }}</div>
                                    <div class="text-[9px] font-bold text-indigo-400 uppercase tracking-widest italic">Authorized on {{ \Carbon\Carbon::parse($permanentRegistration->nurse->temporaryRegistration->temp_registration_date)->format('d M Y') }}</div>
                                </div>
                            </div>
                        @else
                            <div class="flex items-center gap-4 bg-red-50 p-4 rounded-2xl border border-red-100">
                                <i class="bi bi-exclamation-octagon text-red-500 text-xl"></i>
                                <span class="text-[10px] font-black text-red-700 uppercase tracking-widest italic">Non-Preliminary Issuance</span>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <div class="p-8 mt-auto">
                <div class="bg-indigo-600/5 p-5 rounded-3xl border border-indigo-100/50 flex items-start gap-4">
                    <i class="bi bi-check-circle-fill text-indigo-600 text-xl mt-1"></i>
                    <p class="text-[10px] font-bold text-indigo-900 leading-relaxed uppercase tracking-tight italic">
                        This permanent status record is cryptographically synchronized with the SLNC Master Registry. Any unauthorized modifications to this blockchain-linked record are prohibited undere Article 42 of the Medical Ordinance.
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
