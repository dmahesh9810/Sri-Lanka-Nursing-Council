@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto py-12 px-4 sm:px-6 lg:px-8 tracking-tight text-gray-900">
    
    @if(session('error'))
        <div class="mb-8 bg-red-50 border-l-4 border-red-500 p-6 rounded-2xl shadow-lg animate-in fade-in slide-in-from-top-4 duration-500">
            <div class="flex items-center gap-4">
                <div class="bg-red-500/10 p-2 rounded-xl">
                    <i class="bi bi-exclamation-triangle-fill text-red-600 text-xl"></i>
                </div>
                <div>
                    <h4 class="text-sm font-black text-red-900 uppercase tracking-tighter">System Alert</h4>
                    <p class="text-red-700 font-bold italic text-[11px] leading-tight">{{ session('error') }}</p>
                </div>
            </div>
        </div>
    @endif

    @if(!isset($nurse))
        <!-- Step 1: Search Nurse by NIC -->
        <div class="bg-white rounded-[2.5rem] shadow-2xl border border-gray-100 overflow-hidden">
            <div class="bg-blue-600 px-10 py-8 relative overflow-hidden text-white">
                <div class="absolute -top-24 -right-24 w-64 h-64 bg-white opacity-10 rounded-full blur-3xl"></div>
                <div class="relative z-10">
                    <h2 class="text-3xl font-black flex items-center tracking-tighter uppercase">
                        <i class="bi bi-search mr-4 text-blue-200"></i> Identity Verification
                    </h2>
                    <p class="text-blue-100 font-bold italic text-xs mt-1 uppercase tracking-widest opacity-80">Locate practitioner identity for global certification</p>
                </div>
            </div>

            <div class="p-10">
                <form action="{{ route('foreign-certificates.create') }}" method="GET" class="space-y-6">
                    <div class="space-y-2 group">
                        <label for="nic" class="block text-[10px] font-black text-gray-400 uppercase tracking-widest group-focus-within:text-blue-600 transition-colors italic">Canonical NIC Identifier <span class="text-red-500">*</span></label>
                        <div class="relative flex items-center">
                            <div class="absolute left-5 text-gray-400 group-focus-within:text-blue-600 transition-colors">
                                <i class="bi bi-person-badge text-xl"></i>
                            </div>
                            <input type="text" name="nic" id="nic" value="{{ request('nic') }}" required
                                class="w-full pl-14 pr-5 py-5 bg-gray-50 border-2 border-gray-100 focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 rounded-[1.5rem] font-black text-gray-900 transition-all outline-none shadow-inner text-lg tracking-widest"
                                placeholder="e.g. 199XXXXXXXXX">
                            <button type="submit" class="absolute right-3 px-8 py-3 bg-blue-600 text-white font-black text-[10px] uppercase tracking-widest rounded-2xl hover:bg-blue-700 transition-all shadow-lg hover:shadow-blue-200 whitespace-nowrap">
                                Execute Search
                            </button>
                        </div>
                        <p class="text-[10px] font-bold text-gray-400 italic">Universal practitioner lookup against council archives required.</p>
                    </div>
                </form>
                
                <div class="mt-8 p-6 bg-blue-50/50 rounded-2xl border border-blue-100/50 flex items-start gap-4">
                    <i class="bi bi-info-circle-fill text-blue-600 mt-1"></i>
                    <p class="text-[10px] font-bold text-blue-800 leading-relaxed uppercase tracking-tight italic">
                        Policy Alert: Foreign certificates can only be issued to practitioners with a confirmed Permanent Registration protocol.
                    </p>
                </div>
            </div>
        </div>
    @else
        <!-- Step 2: Display Profile Preview and Application Form -->
        
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-10 gap-6">
            <div>
                <h2 class="text-3xl font-black text-gray-900 flex items-center tracking-tighter uppercase leading-none">
                    <i class="bi bi-file-earmark-plus text-blue-600 mr-4"></i> Global Issuance
                </h2>
                <p class="text-gray-500 font-bold italic text-xs mt-1 uppercase tracking-widest opacity-80">Authorizing international clinical credentials</p>
            </div>
            <a href="{{ route('foreign-certificates.create') }}" class="px-5 py-3 border-2 border-gray-100 text-[10px] font-black uppercase tracking-widest rounded-2xl text-gray-400 hover:text-gray-900 hover:border-gray-900 transition-all flex items-center gap-2">
                <i class="bi bi-arrow-repeat"></i> Identity Refresh
            </a>
        </div>

        <!-- Profile Context Card -->
        <div class="bg-blue-600 rounded-[3rem] shadow-2xl p-10 mb-12 relative overflow-hidden group text-white">
            <div class="absolute -top-32 -right-32 w-80 h-80 bg-white/10 rounded-full blur-3xl group-hover:scale-110 transition-transform duration-700"></div>
            <div class="relative z-10 flex flex-col md:flex-row gap-10 items-center">
                <div class="w-24 h-24 bg-white/10 backdrop-blur-md rounded-[2.5rem] border border-white/20 flex items-center justify-center text-white shrink-0 shadow-inner">
                    <i class="bi bi-passport text-5xl opacity-90"></i>
                </div>
                <div class="flex-grow space-y-4 text-center md:text-left w-full">
                    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                        <div>
                            <h4 class="text-3xl font-black uppercase tracking-tighter leading-tight">{{ $nurse->name }}</h4>
                            <div class="flex items-center justify-center md:justify-start gap-4 mt-2">
                                <span class="text-[10px] font-black text-blue-200 uppercase tracking-widest bg-white/10 px-3 py-1 rounded-xl border border-white/10 flex items-center gap-2">
                                    <i class="bi bi-fingerprint"></i> Universal NIC
                                </span>
                                <span class="text-xl font-black tracking-[0.2em]">{{ $nurse->nic }}</span>
                            </div>
                        </div>
                        @if($nurse->permanentRegistration)
                            <div class="bg-white/10 backdrop-blur-md px-6 py-4 rounded-3xl border border-white/10 flex flex-col items-center md:items-end">
                                <span class="text-[9px] font-black text-blue-200 uppercase tracking-widest mb-1 italic">Active Permanent</span>
                                <span class="text-lg font-black tracking-widest">{{ $nurse->permanentRegistration->perm_registration_no }}</span>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Issuance Form -->
        <div class="bg-white rounded-[3rem] shadow-2xl border border-gray-100 overflow-hidden">
            <div class="bg-white px-10 py-8 border-b border-gray-50 flex items-center justify-between">
                <h5 class="text-sm font-black text-gray-900 uppercase tracking-widest flex items-center gap-3 italic">
                    <i class="bi bi-globe text-blue-600 animate-pulse"></i> International Governance
                </h5>
                <span class="text-[10px] font-black text-gray-300 uppercase italic">Ledger Authorization: ACTIVE</span>
            </div>
            <div class="p-10">
                <form action="{{ route('foreign-certificates.store') }}" method="POST" class="space-y-12">
                    @csrf
                    <input type="hidden" name="nurse_id" value="{{ $nurse->id }}">

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
                        <div class="space-y-3 group">
                            <label for="certificate_type" class="block text-[10px] font-black text-gray-400 uppercase tracking-widest group-focus-within:text-blue-600 transition-colors">Authorization Domain <span class="text-red-500 font-black">*</span></label>
                            <select name="certificate_type" id="certificate_type" required
                                class="w-full px-6 py-5 bg-gray-50 border-2 {{ $errors->has('certificate_type') ? 'border-red-400 focus:ring-red-500 bg-red-50' : 'border-gray-100 focus:border-blue-500 focus:ring-blue-500' }} rounded-[1.5rem] font-black text-gray-900 transition-all outline-none focus:ring-4 focus:ring-blue-500/10 shadow-inner appearance-none cursor-pointer">
                                <option value="" disabled {{ old('certificate_type') ? '' : 'selected' }}>Select Protocol...</option>
                                <option value="Verification" {{ old('certificate_type') == 'Verification' ? 'selected' : '' }}>Verification</option>
                                <option value="Good Standing" {{ old('certificate_type') == 'Good Standing' ? 'selected' : '' }}>Good Standing</option>
                                <option value="Confirmation" {{ old('certificate_type') == 'Confirmation' ? 'selected' : '' }}>Confirmation</option>
                                <option value="Additional Verification" {{ old('certificate_type') == 'Additional Verification' ? 'selected' : '' }}>Additional Verification</option>
                            </select>
                            @error('certificate_type') <p class="mt-2 text-[10px] font-black text-red-600 uppercase italic tracking-widest">{{ $message }}</p> @enderror
                        </div>
                        <div class="space-y-3 group">
                            <label for="country" class="block text-[10px] font-black text-gray-400 uppercase tracking-widest group-focus-within:text-blue-600 transition-colors">Target Jurisdiction <span class="text-red-500 font-black">*</span></label>
                            <input type="text" name="country" id="country" value="{{ old('country') }}" required
                                class="w-full px-6 py-5 bg-gray-50 border-2 {{ $errors->has('country') ? 'border-red-400 focus:ring-red-500 bg-red-50' : 'border-gray-100 focus:border-blue-500 focus:ring-blue-500' }} rounded-[1.5rem] font-bold text-gray-900 transition-all outline-none shadow-inner"
                                placeholder="e.g. United Kingdom, Australia">
                            @error('country') <p class="mt-2 text-[10px] font-black text-red-600 uppercase italic tracking-widest">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-10 pt-10 border-t border-gray-50">
                        <div class="space-y-3 group">
                            <label for="apply_date" class="block text-[10px] font-black text-gray-400 uppercase tracking-widest group-focus-within:text-blue-600 transition-colors">Submission Date <span class="text-red-500 font-black">*</span></label>
                            <input type="date" name="apply_date" id="apply_date" value="{{ old('apply_date', date('Y-m-d')) }}" required
                                class="w-full px-6 py-5 bg-gray-50 border-2 {{ $errors->has('apply_date') ? 'border-red-400 focus:ring-red-500 bg-red-50' : 'border-gray-100 focus:border-blue-500 focus:ring-blue-500' }} rounded-[1.25rem] font-bold text-gray-900 transition-all outline-none shadow-inner">
                            @error('apply_date') <p class="mt-2 text-[10px] font-black text-red-600 uppercase italic tracking-widest">{{ $message }}</p> @enderror
                        </div>
                        <div class="space-y-3 group">
                            <label for="issue_date" class="block text-[10px] font-black text-gray-400 uppercase tracking-widest group-focus-within:text-blue-600 transition-colors">Issuance Date (Optional)</label>
                            <input type="date" name="issue_date" id="issue_date" value="{{ old('issue_date') }}"
                                class="w-full px-6 py-5 bg-gray-50 border-2 border-gray-100 focus:border-blue-500 rounded-[1.25rem] font-bold text-gray-900 transition-all outline-none shadow-inner">
                        </div>
                    </div>

                    <div class="bg-gray-50/50 p-10 rounded-[2.5rem] border-2 border-gray-100/50 grid grid-cols-1 md:grid-cols-2 gap-10">
                        <div class="flex items-center justify-between bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                            <div>
                                <h6 class="text-[10px] font-black text-gray-900 uppercase tracking-widest">Seal Protocol</h6>
                                <p class="text-[9px] font-bold text-gray-400 uppercase italic">Official Council Seal</p>
                            </div>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" name="certificate_sealed" value="1" {{ old('certificate_sealed') ? 'checked' : '' }} class="sr-only peer">
                                <div class="w-14 h-7 bg-gray-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-6 after:w-6 after:transition-all peer-checked:bg-blue-600"></div>
                            </label>
                        </div>
                        <div class="flex items-center justify-between bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                            <div>
                                <h6 class="text-[10px] font-black text-gray-900 uppercase tracking-widest">Issuance Protocol</h6>
                                <p class="text-[9px] font-bold text-gray-400 uppercase italic">Physical Certificate Print</p>
                            </div>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" name="certificate_printed" value="1" {{ old('certificate_printed') ? 'checked' : '' }} class="sr-only peer">
                                <div class="w-14 h-7 bg-gray-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-6 after:w-6 after:transition-all peer-checked:bg-blue-600"></div>
                            </label>
                        </div>
                    </div>

                    <div class="flex items-center justify-between pt-12 mt-12 border-t-2 border-gray-100">
                        <a href="{{ route('foreign-certificates.index') }}" class="text-[10px] font-black text-gray-400 uppercase tracking-[0.4em] hover:text-gray-900 transition-all border-b border-transparent hover:border-gray-900 pb-1 italic">Abort Issuance</a>
                        <button type="submit" 
                            class="px-12 py-6 bg-blue-600 text-white font-black text-xs uppercase tracking-[0.4em] rounded-[1.5rem] shadow-[0_20px_50px_rgba(37,99,235,0.3)] hover:bg-blue-700 hover:scale-[1.02] active:scale-[0.98] transition-all flex items-center gap-4">
                            Authorize Protocol <i class="bi bi-shield-check-fill text-sm"></i>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif
</div>
@endsection
