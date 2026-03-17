@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto py-8 px-4 sm:px-6 lg:px-8 tracking-tight">
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-10 gap-6">
        <div>
            <h2 class="text-3xl font-black text-gray-900 flex items-center tracking-tighter">
                <i class="bi bi-file-earmark-medical text-blue-600 mr-4"></i> Registration Details
            </h2>
            <p class="text-gray-500 font-bold italic text-xs mt-1 uppercase tracking-widest opacity-80">Temporary Practitioner Status - SLNC Canonical Registry</p>
        </div>
        <div class="flex gap-3 w-full md:w-auto">
            <a href="{{ route('temporary-registrations.index') }}" class="flex-1 md:flex-initial inline-flex items-center justify-center px-5 py-3 border border-gray-200 text-[10px] font-black uppercase tracking-widest rounded-2xl text-gray-700 bg-white hover:bg-gray-50 transition-all shadow-sm">
                <i class="bi bi-arrow-left mr-2"></i> Registry List
            </a>
            <a href="{{ route('temporary-registrations.edit', $temporaryRegistration) }}" class="flex-1 md:flex-initial inline-flex items-center justify-center px-5 py-3 border border-transparent text-[10px] font-black uppercase tracking-widest rounded-2xl text-white bg-blue-600 hover:bg-blue-700 transition-all shadow-xl shadow-blue-100">
                <i class="bi bi-pencil mr-2"></i> Modify Records
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-10">
        <!-- Registration Info Card -->
        <div class="bg-white rounded-[2.5rem] shadow-2xl shadow-gray-100 border border-gray-100 overflow-hidden flex flex-col h-full">
            <div class="px-8 py-6 border-b border-gray-50 bg-gray-50/30 flex items-center justify-between">
                <h5 class="text-sm font-black text-gray-900 uppercase tracking-widest flex items-center gap-2">
                    <i class="bi bi-bookmark-check text-blue-600"></i> Registration Artifact
                </h5>
                <span class="text-[10px] font-black text-gray-400 italic">OFFICIAL RECORD</span>
            </div>
            <div class="p-8 space-y-6 flex-grow">
                <div class="group">
                    <div class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2 group-hover:text-blue-500 transition-colors">Temporary Registration Number</div>
                    <div class="text-2xl font-black text-gray-900 bg-blue-50 inline-block px-4 py-1.5 rounded-2xl border border-blue-100 shadow-inner">
                        {{ $temporaryRegistration->temp_registration_no }}
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-8">
                    <div class="group">
                        <div class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1 group-hover:text-blue-500 transition-colors">Authorization Date</div>
                        <div class="text-base font-bold text-gray-800 italic">{{ \Carbon\Carbon::parse($temporaryRegistration->temp_registration_date)->format('d M Y') }}</div>
                    </div>
                    <div class="group">
                        <div class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1 group-hover:text-blue-500 transition-colors">Date of Birth</div>
                        <div class="text-base font-bold text-gray-800 italic">{{ $temporaryRegistration->birth_date ? \Carbon\Carbon::parse($temporaryRegistration->birth_date)->format('d M Y') : 'N/A' }}</div>
                    </div>
                </div>

                <div class="group">
                    <div class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1 group-hover:text-blue-500 transition-colors">Primary Practice Location</div>
                    <div class="text-base font-bold text-gray-800 italic leading-relaxed">{{ $temporaryRegistration->address ?: 'N/A' }}</div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-8">
                    <div class="group">
                        <div class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1 group-hover:text-blue-500 transition-colors">Academy / Institution</div>
                        <div class="text-base font-bold text-gray-800 italic">{{ $temporaryRegistration->school_university ?: 'N/A' }}</div>
                    </div>
                    <div class="group">
                        <div class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1 group-hover:text-blue-500 transition-colors">Assigned Batch</div>
                        <div class="text-base font-bold text-gray-800 italic">{{ $temporaryRegistration->batch ?: 'N/A' }}</div>
                    </div>
                </div>
            </div>
            <div class="px-8 py-5 bg-gray-50/30 border-t border-gray-50 flex justify-between items-center text-[10px] font-bold text-gray-400 uppercase tracking-widest italic">
                <span>Sync: {{ $temporaryRegistration->updated_at->format('d M Y') }}</span>
                <span>ID: #TR{{ str_pad($temporaryRegistration->id, 5, '0', STR_PAD_LEFT) }}</span>
            </div>
        </div>

        <!-- Nurse Profile Context Card -->
        <div class="bg-white rounded-[2.5rem] shadow-2xl shadow-indigo-100 border border-indigo-50 overflow-hidden flex flex-col h-full ring-4 ring-indigo-50/50">
            <div class="px-8 py-6 border-b border-indigo-50 bg-indigo-50/10 flex items-center justify-between">
                <h5 class="text-sm font-black text-indigo-900 uppercase tracking-widest flex items-center gap-2">
                    <i class="bi bi-person-badge text-indigo-600"></i> Practitioner Profile
                </h5>
                <a href="{{ route('nurses.show', $temporaryRegistration->nurse) }}" class="text-[10px] font-black text-indigo-600 uppercase tracking-widest hover:underline decoration-2 underline-offset-4 transition-all">
                    Full Profile <i class="bi bi-arrow-right ml-1"></i>
                </a>
            </div>
            <div class="p-10 space-y-8 flex-grow bg-gradient-to-br from-white to-indigo-50/30">
                <div class="flex items-start gap-6">
                    <div class="w-16 h-16 bg-indigo-600 rounded-3xl flex items-center justify-center text-white shadow-lg shadow-indigo-200">
                        <i class="bi bi-person-circle text-3xl"></i>
                    </div>
                    <div>
                        <h4 class="text-2xl font-black text-gray-900 tracking-tighter uppercase">{{ $temporaryRegistration->nurse->name }}</h4>
                        <div class="flex items-center gap-3 mt-2">
                            <span class="text-[10px] font-black text-indigo-600 uppercase bg-indigo-100 px-3 py-1 rounded-xl tracking-tighter">Canonical NIC</span>
                            <span class="text-sm font-black text-gray-800 tracking-widest">{{ $temporaryRegistration->nurse->nic }}</span>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-10 border-t border-indigo-100 pt-8 italic font-medium">
                    <div class="group">
                        <div class="text-[10px] font-black text-indigo-400 uppercase tracking-widest mb-1">Communication Channel</div>
                        <div class="text-base text-gray-900">{{ $temporaryRegistration->nurse->phone ?: 'N/A' }}</div>
                    </div>
                    <div class="group">
                        <div class="text-[10px] font-black text-indigo-400 uppercase tracking-widest mb-1">Training Cohort</div>
                        <div class="text-base text-gray-900">{{ $temporaryRegistration->nurse->batch ?: 'N/A' }}</div>
                    </div>
                    <div class="group sm:col-span-2">
                        <div class="text-[10px] font-black text-indigo-400 uppercase tracking-widest mb-1">Alma Mater</div>
                        <div class="text-base text-gray-900 leading-relaxed">{{ $temporaryRegistration->nurse->school_or_university ?: 'N/A' }}</div>
                    </div>
                </div>
            </div>
            <div class="p-8 mt-auto">
                <div class="bg-indigo-600/5 p-4 rounded-2xl border border-indigo-100/50 flex items-center gap-4">
                    <i class="bi bi-info-circle-fill text-indigo-600 text-xl"></i>
                    <p class="text-[10px] font-bold text-indigo-900 leading-relaxed uppercase tracking-tight">This registration is cryptographically linked to the primary practitioner identity. Any modifications here will affect the canonical registration ledger.</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
