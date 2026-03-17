@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto py-8 px-4 sm:px-6 lg:px-8 tracking-tight">
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-10 gap-6">
        <div>
            <h2 class="text-3xl font-black text-gray-900 flex items-center tracking-tighter uppercase whitespace-nowrap">
                <i class="bi bi-globe-americas text-blue-600 mr-4"></i> Foreign Credentials
            </h2>
            <p class="text-gray-500 font-bold italic text-xs mt-1 uppercase tracking-widest opacity-80">Global Practitioner Registry - International Authorization</p>
        </div>
        <div class="flex gap-3 w-full md:w-auto">
            <a href="{{ route('foreign-certificates.index') }}" class="flex-1 md:flex-initial inline-flex items-center justify-center px-5 py-3 border border-gray-200 text-[10px] font-black uppercase tracking-widest rounded-2xl text-gray-700 bg-white hover:bg-gray-50 transition-all shadow-sm">
                <i class="bi bi-arrow-left mr-2"></i> Registry List
            </a>
            <a href="{{ route('foreign-certificates.edit', $foreignCertificate) }}" class="flex-1 md:flex-initial inline-flex items-center justify-center px-5 py-3 border border-transparent text-[10px] font-black uppercase tracking-widest rounded-2xl text-white bg-blue-600 hover:bg-blue-700 transition-all shadow-xl shadow-blue-100">
                <i class="bi bi-pencil mr-2"></i> Edit Record
            </a>
        </div>
    </div>

    @if($foreignCertificate->certificate_sealed && $foreignCertificate->issue_date)
        <div class="mb-10 bg-emerald-600 rounded-[2.5rem] shadow-2xl shadow-emerald-100 p-8 relative overflow-hidden group">
            <div class="absolute -top-12 -right-12 w-48 h-48 bg-white/10 rounded-full blur-3xl group-hover:scale-110 transition-transform duration-700"></div>
            <div class="relative z-10 flex flex-col lg:flex-row items-center justify-between gap-8">
                <div class="flex items-center gap-6">
                    <div class="w-16 h-16 bg-white/20 backdrop-blur-md rounded-2xl border border-white/30 flex items-center justify-center text-white shadow-inner">
                        <i class="bi bi-patch-check-fill text-3xl"></i>
                    </div>
                    <div class="text-white">
                        <h4 class="text-lg font-black uppercase tracking-tighter leading-none">Authorization Finalized</h4>
                        <p class="text-emerald-100 font-bold italic text-[11px] uppercase tracking-widest mt-2 opacity-90">Protocol sealed and officially issued for international distribution.</p>
                        @if($foreignCertificate->printed_at)
                            <p class="text-[9px] font-black text-emerald-200 uppercase tracking-widest mt-1">Last Print Executed: {{ $foreignCertificate->printed_at->format('d M Y, H:i A') }}</p>
                        @endif
                    </div>
                </div>
                <div class="flex gap-4 w-full lg:w-auto">
                    <a href="{{ route('certificates.print', $foreignCertificate->id) }}" target="_blank" class="flex-1 lg:flex-initial px-8 py-4 bg-white text-emerald-700 font-black text-[10px] uppercase tracking-widest rounded-2xl hover:bg-emerald-50 transition-all shadow-lg flex items-center justify-center gap-2">
                        <i class="bi bi-printer-fill text-sm"></i> Preview Protocol
                    </a>
                    <a href="{{ route('certificates.print', $foreignCertificate->id) . '?action=download' }}" target="_blank" class="flex-1 lg:flex-initial px-8 py-4 bg-emerald-700 text-white font-black text-[10px] uppercase tracking-widest rounded-2xl border border-white/20 hover:bg-emerald-800 transition-all shadow-lg flex items-center justify-center gap-2">
                        <i class="bi bi-download text-sm"></i> Download PDF
                    </a>
                </div>
            </div>
        </div>
    @else
        <div class="mb-10 bg-amber-500 rounded-[2.5rem] shadow-2xl shadow-amber-100 p-8 relative overflow-hidden group">
            <div class="absolute -top-12 -right-12 w-48 h-48 bg-white/10 rounded-full blur-3xl group-hover:scale-110 transition-transform duration-700"></div>
            <div class="relative z-10 flex items-center gap-6 text-white">
                <div class="w-16 h-16 bg-white/20 backdrop-blur-md rounded-2xl border border-white/30 flex items-center justify-center text-white shadow-inner shrink-0">
                    <i class="bi bi-exclamation-triangle-fill text-3xl"></i>
                </div>
                <div>
                    <h4 class="text-lg font-black uppercase tracking-tighter leading-none">Issuance Suspended</h4>
                    <p class="text-amber-50 font-bold italic text-[11px] uppercase tracking-widest mt-2 opacity-90">The protocol requires official sealing and an authorized issuance date before archival printing is permitted.</p>
                </div>
            </div>
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-10">
        <!-- Certificate Details Card -->
        <div class="bg-white rounded-[2.5rem] shadow-2xl shadow-gray-100 border border-gray-100 overflow-hidden flex flex-col h-full">
            <div class="px-8 py-6 border-b border-gray-50 bg-gray-50/30 flex items-center justify-between">
                <h5 class="text-sm font-black text-blue-900 uppercase tracking-widest flex items-center gap-2 italic">
                    <i class="bi bi-file-earmark-medical text-blue-600"></i> International Schema
                </h5>
                <span class="text-[10px] font-black text-gray-400 italic font-mono uppercase">Record #FC{{ str_pad($foreignCertificate->id, 5, '0', STR_PAD_LEFT) }}</span>
            </div>
            
            <div class="p-8 space-y-8 flex-grow">
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-8">
                    <div class="group">
                        <div class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2 group-hover:text-blue-500 transition-colors italic">Authorization Type</div>
                        <span class="inline-flex px-4 py-1.5 rounded-xl bg-blue-50 border border-blue-100 text-blue-700 text-[10px] font-black uppercase tracking-tight shadow-sm">{{ $foreignCertificate->certificate_type }}</span>
                    </div>
                    <div class="group">
                        <div class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2 group-hover:text-blue-500 transition-colors italic">Jurisdiction (Country)</div>
                        <div class="text-lg font-black text-gray-900 tracking-tight">{{ $foreignCertificate->country }}</div>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-8 border-t border-gray-50 pt-8">
                    <div class="group">
                        <div class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1 group-hover:text-blue-500 transition-colors italic">Application Submission</div>
                        <div class="text-base font-bold text-gray-800">{{ \Carbon\Carbon::parse($foreignCertificate->apply_date)->format('d M Y') }}</div>
                    </div>
                    <div class="group">
                        <div class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1 group-hover:text-blue-500 transition-colors italic rotate-12 origin-left inline-block">Authorized Issue Date</div>
                        <div class="text-base font-bold {{ $foreignCertificate->issue_date ? 'text-emerald-600' : 'text-amber-500 italic' }}">
                            {{ $foreignCertificate->issue_date ? \Carbon\Carbon::parse($foreignCertificate->issue_date)->format('d M Y') : 'Pending Authorization' }}
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-8 border-t border-gray-50 pt-8">
                    <div class="group">
                        <div class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-3 group-hover:text-blue-500 transition-colors italic">Seal Authorization</div>
                        @if($foreignCertificate->certificate_sealed)
                            <span class="inline-flex items-center px-4 py-2 rounded-2xl bg-emerald-50 text-emerald-700 text-[10px] font-black uppercase tracking-widest border border-emerald-100 shadow-sm">
                                <i class="bi bi-shield-check-fill mr-2"></i> SEALED
                            </span>
                        @else
                            <span class="inline-flex items-center px-4 py-2 rounded-2xl bg-red-50 text-red-700 text-[10px] font-black uppercase tracking-widest border border-red-100 shadow-sm animate-pulse">
                                <i class="bi bi-shield-x mr-2"></i> UNSEALED
                            </span>
                        @endif
                    </div>
                    <div class="group">
                        <div class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-3 group-hover:text-blue-500 transition-colors italic">Print Verification</div>
                        @if($foreignCertificate->certificate_printed)
                            <span class="inline-flex items-center px-4 py-2 rounded-2xl bg-emerald-50 text-emerald-700 text-[10px] font-black uppercase tracking-widest border border-emerald-100 shadow-sm">
                                <i class="bi bi-printer-fill mr-2"></i> EXECUTED
                            </span>
                        @else
                            <span class="inline-flex items-center px-4 py-2 rounded-2xl bg-gray-50 text-gray-400 text-[10px] font-black uppercase tracking-widest border border-gray-100">
                                <i class="bi bi-clock-history mr-2"></i> PENDING
                            </span>
                        @endif
                    </div>
                </div>

                @if($foreignCertificate->certificate_number)
                <div class="group border-t border-gray-50 pt-8">
                    <div class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2 group-hover:text-blue-500 transition-colors italic">Universal Certificate Serial</div>
                    <div class="p-4 bg-gray-900 rounded-2xl border border-gray-800 shadow-inner">
                        <code class="text-emerald-400 font-mono text-lg font-black tracking-widest">{{ $foreignCertificate->certificate_number }}</code>
                    </div>
                </div>
                @endif
            </div>
            
            <div class="px-8 py-5 bg-gray-50/30 border-t border-gray-50 flex justify-between items-center text-[10px] font-bold text-gray-400 uppercase tracking-widest italic">
                <span>System Logged: {{ $foreignCertificate->created_at->format('d M Y') }}</span>
                <span>Context: GLOBAL_V1</span>
            </div>
        </div>

        <!-- Applicant Profile Card -->
        <div class="bg-white rounded-[2.5rem] shadow-2xl shadow-indigo-100 border border-indigo-50 overflow-hidden flex flex-col h-full ring-4 ring-indigo-50/50">
            <div class="px-8 py-6 border-b border-indigo-50 bg-indigo-50/10 flex items-center justify-between">
                <h5 class="text-sm font-black text-indigo-900 uppercase tracking-widest flex items-center gap-2">
                    <i class="bi bi-person-badge text-indigo-600"></i> Clinical Persona
                </h5>
                <a href="{{ route('nurses.show', $foreignCertificate->nurse) }}" class="text-[10px] font-black text-indigo-600 uppercase tracking-widest hover:underline decoration-2 underline-offset-4 transition-all">
                    Unified Identity <i class="bi bi-arrow-right ml-1"></i>
                </a>
            </div>
            
            <div class="p-10 space-y-10 flex-grow bg-gradient-to-br from-white to-indigo-50/20">
                <div class="flex items-start gap-6">
                    <div class="w-16 h-16 bg-indigo-600 rounded-3xl flex items-center justify-center text-white shadow-lg shadow-indigo-200">
                        <i class="bi bi-passport text-3xl"></i>
                    </div>
                    <div>
                        <h4 class="text-2xl font-black text-gray-900 tracking-tighter uppercase leading-tight">{{ $foreignCertificate->nurse->name }}</h4>
                        <div class="flex items-center gap-3 mt-2">
                            <span class="text-[10px] font-black text-indigo-600 uppercase bg-indigo-100 px-3 py-1 rounded-xl tracking-tighter shadow-sm border border-indigo-200">National NIC</span>
                            <span class="text-sm font-black text-gray-800 tracking-widest">{{ $foreignCertificate->nurse->nic }}</span>
                        </div>
                    </div>
                </div>

                <div class="space-y-6 pt-8 border-t border-indigo-100">
                    <div class="group">
                        <div class="text-[10px] font-black text-indigo-400 uppercase tracking-widest mb-1 italic">Contact Terminal</div>
                        <div class="text-base text-gray-900 font-bold font-mono">{{ $foreignCertificate->nurse->phone ?: 'N/A' }}</div>
                    </div>
                    
                    <div class="group pt-6 border-t border-indigo-50/50">
                        <div class="text-[10px] font-black text-indigo-400 uppercase tracking-widest mb-3 italic">Active SLNC Authorization</div>
                        @if($foreignCertificate->nurse->permanentRegistration)
                            <div class="flex items-center gap-4 bg-emerald-600/5 p-5 rounded-3xl border border-emerald-100 shadow-inner">
                                <div class="w-12 h-12 bg-emerald-600 rounded-2xl flex items-center justify-center text-white shrink-0">
                                    <i class="bi bi-shield-fill-check text-2xl"></i>
                                </div>
                                <div>
                                    <div class="text-sm font-black text-emerald-900 tracking-tight">{{ $foreignCertificate->nurse->permanentRegistration->perm_registration_no }}</div>
                                    <div class="text-[9px] font-bold text-emerald-500 uppercase tracking-widest italic leading-none mt-1">Authorized on {{ \Carbon\Carbon::parse($foreignCertificate->nurse->permanentRegistration->perm_registration_date)->format('d M Y') }}</div>
                                </div>
                            </div>
                        @else
                            <div class="flex items-center gap-4 bg-amber-50 p-5 rounded-3xl border border-amber-100 shadow-inner">
                                <div class="w-12 h-12 bg-amber-500 rounded-2xl flex items-center justify-center text-white shrink-0">
                                    <i class="bi bi-exclamation-triangle-fill text-2xl"></i>
                                </div>
                                <span class="text-[10px] font-black text-amber-700 uppercase tracking-widest italic leading-tight">Permanent status not found in SLNC archives. Primary authorization required for international certificates.</span>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <div class="p-8 mt-auto">
                <div class="bg-indigo-600/5 p-5 rounded-3xl border border-indigo-100/50 flex flex-col gap-2">
                    <div class="flex items-center gap-2">
                        <i class="bi bi-info-circle-fill text-indigo-600"></i>
                        <span class="text-[9px] font-black text-indigo-900 uppercase tracking-widest">Compliance Directive</span>
                    </div>
                    <p class="text-[9px] font-bold text-indigo-700/70 leading-relaxed uppercase tracking-tight italic">
                        This digital record is officially synchronized with the Department of Foreign Relations. Any unauthorized duplication or tampering is a violation of international practitioner protocols.
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
