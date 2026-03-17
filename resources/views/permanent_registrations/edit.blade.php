@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto py-12 px-4 sm:px-6 lg:px-8 tracking-tight text-gray-900">
    <div class="bg-white rounded-[2.5rem] shadow-2xl border border-gray-100 overflow-hidden">
        <div class="bg-emerald-600 px-10 py-8 relative overflow-hidden text-white">
            <div class="absolute -top-24 -right-24 w-64 h-64 bg-white opacity-10 rounded-full blur-3xl"></div>
            <div class="absolute -bottom-24 -left-24 w-64 h-64 bg-emerald-400 opacity-20 rounded-full blur-3xl"></div>
            
            <div class="relative z-10 flex flex-col sm:flex-row items-center justify-between gap-6">
                <div>
                    <h2 class="text-3xl font-black flex items-center tracking-tighter uppercase whitespace-nowrap">
                        <i class="bi bi-pencil-square mr-4 text-emerald-200"></i> Modify Protocol
                    </h2>
                    <p class="text-emerald-100 font-bold italic text-xs mt-1 uppercase tracking-widest opacity-80">Refining permanent practitioner credentials</p>
                </div>
                <div class="bg-white/10 backdrop-blur-md rounded-2xl px-5 py-3 border border-white/20 flex items-center gap-4">
                    <span class="text-[10px] font-black uppercase tracking-widest text-emerald-100">Ledger Serial:</span>
                    <span class="text-sm font-black bg-emerald-500/50 px-3 py-1 rounded-xl border border-emerald-300/30 shadow-inner tracking-widest">{{ $permanentRegistration->perm_registration_no }}</span>
                </div>
            </div>
        </div>
        
        <div class="bg-gray-50 border-b border-gray-100 px-10 py-6 flex items-center justify-between">
            <div class="flex items-center gap-4">
                <div class="w-10 h-10 bg-emerald-100 rounded-xl flex items-center justify-center text-emerald-600">
                    <i class="bi bi-person-check-fill text-xl"></i>
                </div>
                <div>
                    <h4 class="text-sm font-black uppercase tracking-tighter">{{ $permanentRegistration->nurse->name }}</h4>
                    <span class="text-[10px] font-black text-gray-400 uppercase tracking-widest italic">NIC ARCHIVE: {{ $permanentRegistration->nurse->nic }}</span>
                </div>
            </div>
            <span class="text-[10px] font-black text-gray-300 uppercase italic">IDENTITY LOCKED</span>
        </div>

        <div class="p-10 bg-white">
            <form action="{{ route('permanent-registrations.update', $permanentRegistration) }}" method="POST" class="space-y-10">
                @csrf
                @method('PUT')
                
                <input type="hidden" name="nurse_id" value="{{ $permanentRegistration->nurse_id }}">

                <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
                    <div class="space-y-3 group">
                        <label for="perm_registration_no" class="block text-[10px] font-black text-gray-400 uppercase tracking-widest group-focus-within:text-emerald-600 transition-colors">Permanent Registry Serial <span class="text-red-500 font-black">*</span></label>
                        <input type="text" name="perm_registration_no" id="perm_registration_no" value="{{ old('perm_registration_no', $permanentRegistration->perm_registration_no) }}" required
                            class="w-full px-6 py-5 bg-gray-50 border-2 {{ $errors->has('perm_registration_no') ? 'border-red-400 focus:ring-red-500 bg-red-50' : 'border-gray-100 focus:border-emerald-500 focus:ring-emerald-500' }} rounded-[1.5rem] font-black text-gray-900 transition-all outline-none focus:ring-4 focus:ring-emerald-500/10 shadow-inner"
                            placeholder="Canonical serial identifier...">
                        @error('perm_registration_no') <p class="mt-2 text-[10px] font-black text-red-600 uppercase italic tracking-widest">{{ $message }}</p> @enderror
                    </div>
                    <div class="space-y-3 group">
                        <label for="perm_registration_date" class="block text-[10px] font-black text-gray-400 uppercase tracking-widest group-focus-within:text-emerald-600 transition-colors">Authorization Date <span class="text-red-500 font-black">*</span></label>
                        <input type="date" name="perm_registration_date" id="perm_registration_date" value="{{ old('perm_registration_date', $permanentRegistration->perm_registration_date) }}" required
                            class="w-full px-6 py-5 bg-gray-50 border-2 {{ $errors->has('perm_registration_date') ? 'border-red-400 focus:ring-red-500 bg-red-50' : 'border-gray-100 focus:border-emerald-500 focus:ring-emerald-500' }} rounded-[1.5rem] font-bold text-gray-900 transition-all outline-none shadow-inner">
                        @error('perm_registration_date') <p class="mt-2 text-[10px] font-black text-red-600 uppercase italic tracking-widest">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-10 border-t border-gray-50 pt-10">
                    <div class="space-y-3 group">
                        <label for="appointment_date" class="block text-[10px] font-black text-gray-400 uppercase tracking-widest group-focus-within:text-emerald-600 transition-colors">Civil Appointment Date</label>
                        <input type="date" name="appointment_date" id="appointment_date" value="{{ old('appointment_date', $permanentRegistration->appointment_date) }}"
                            class="w-full px-6 py-5 bg-gray-50 border-2 border-gray-100 focus:border-emerald-500 rounded-[1.25rem] font-bold text-gray-900 transition-all outline-none shadow-inner">
                        @error('appointment_date') <p class="mt-2 text-[10px] font-black text-red-600 uppercase italic tracking-widest">{{ $message }}</p> @enderror
                    </div>
                    <div class="space-y-3 group">
                        <label for="grade" class="block text-[10px] font-black text-gray-400 uppercase tracking-widest group-focus-within:text-emerald-600 transition-colors">Seniority Grade Level</label>
                        <input type="text" name="grade" id="grade" value="{{ old('grade', $permanentRegistration->grade) }}"
                            class="w-full px-6 py-5 bg-gray-50 border-2 border-gray-100 focus:border-emerald-500 rounded-[1.25rem] font-bold text-gray-900 transition-all outline-none shadow-inner"
                            placeholder="e.g. Grade II">
                        @error('grade') <p class="mt-2 text-[10px] font-black text-red-600 uppercase italic tracking-widest">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div class="space-y-3 group">
                    <label for="present_workplace" class="block text-[10px] font-black text-gray-400 uppercase tracking-widest group-focus-within:text-emerald-600 transition-colors">Authorized Clinical Workplace</label>
                    <input type="text" name="present_workplace" id="present_workplace" value="{{ old('present_workplace', $permanentRegistration->present_workplace) }}"
                        class="w-full px-6 py-5 bg-gray-50 border-2 border-gray-100 focus:border-emerald-500 rounded-[1.25rem] font-bold text-gray-900 transition-all outline-none shadow-inner"
                        placeholder="Primary operational jurisdiction...">
                    @error('present_workplace') <p class="mt-2 text-[10px] font-black text-red-600 uppercase italic tracking-widest">{{ $message }}</p> @enderror
                </div>

                <div class="space-y-3 group">
                    <label for="address" class="block text-[10px] font-black text-gray-400 uppercase tracking-widest group-focus-within:text-emerald-600 transition-colors">Canonical Resident Address</label>
                    <textarea name="address" id="address" rows="2"
                        class="w-full px-6 py-5 bg-gray-50 border-2 border-gray-100 focus:border-emerald-500 rounded-[1.25rem] font-bold text-gray-900 transition-all outline-none shadow-inner resize-none"
                        placeholder="Current residing records accurately reflecting practitioner whereabouts...">{{ old('address', $permanentRegistration->address) }}</textarea>
                    @error('address') <p class="mt-2 text-[10px] font-black text-red-600 uppercase italic tracking-widest">{{ $message }}</p> @enderror
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-10 pt-10 border-t border-gray-50">
                    <div class="space-y-3 group">
                        <label for="batch" class="block text-[10px] font-black text-gray-400 uppercase tracking-widest group-focus-within:text-emerald-600 transition-colors">Academic Cycle (Batch)</label>
                        <input type="text" name="batch" id="batch" value="{{ old('batch', $permanentRegistration->batch) }}"
                            class="w-full px-6 py-5 bg-gray-50 border-2 border-gray-100 focus:border-emerald-500 rounded-[1.25rem] font-bold text-gray-900 transition-all outline-none shadow-inner">
                        @error('batch') <p class="mt-2 text-[10px] font-black text-red-600 uppercase italic tracking-widest">{{ $message }}</p> @enderror
                    </div>
                    <div class="space-y-3 group">
                        <label for="school_university" class="block text-[10px] font-black text-gray-400 uppercase tracking-widest group-focus-within:text-emerald-600 transition-colors">Primary Educational Institution</label>
                        <input type="text" name="school_university" id="school_university" value="{{ old('school_university', $permanentRegistration->school_university) }}"
                            class="w-full px-6 py-5 bg-gray-50 border-2 border-gray-100 focus:border-emerald-500 rounded-[1.25rem] font-bold text-gray-900 transition-all outline-none shadow-inner">
                        @error('school_university') <p class="mt-2 text-[10px] font-black text-red-600 uppercase italic tracking-widest">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-10 pt-10 border-t border-gray-50">
                    <div class="space-y-3 group">
                        <label for="birth_date" class="block text-[10px] font-black text-gray-400 uppercase tracking-widest group-focus-within:text-emerald-600 transition-colors">Canonical Birth Date</label>
                        <input type="date" name="birth_date" id="birth_date" value="{{ old('birth_date', $permanentRegistration->birth_date) }}"
                            class="w-full px-6 py-5 bg-gray-50 border-2 border-gray-100 focus:border-emerald-500 rounded-[1.25rem] font-bold text-gray-900 transition-all outline-none shadow-inner">
                        @error('birth_date') <p class="mt-2 text-[10px] font-black text-red-600 uppercase italic tracking-widest">{{ $message }}</p> @enderror
                    </div>
                    <div class="space-y-3 group">
                        <label for="qualification" class="block text-[10px] font-black text-gray-400 uppercase tracking-widest group-focus-within:text-emerald-600 transition-colors">Certification Degree</label>
                        <select name="qualification" id="qualification"
                            class="w-full px-6 py-5 bg-gray-50 border-2 border-gray-100 focus:border-emerald-500 rounded-[1.25rem] font-black text-gray-900 transition-all outline-none appearance-none cursor-pointer">
                            <option value="">Select Protocol</option>
                            <option value="Diploma" @selected(old('qualification', $permanentRegistration->qualification) == 'Diploma')>Diploma</option>
                            <option value="General Nursing" @selected(old('qualification', $permanentRegistration->qualification) == 'General Nursing')>General Nursing</option>
                            <option value="BSc Nursing" @selected(old('qualification', $permanentRegistration->qualification) == 'BSc Nursing')>BSc Nursing</option>
                        </select>
                        @error('qualification') <p class="mt-2 text-[10px] font-black text-red-600 uppercase italic tracking-widest">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-10 pt-10 border-t border-gray-50">
                    <div class="space-y-3 group">
                        <label for="slmc_no" class="block text-[10px] font-black text-gray-400 uppercase tracking-widest group-focus-within:text-emerald-600 transition-colors">SLMC Serial Identification</label>
                        <input type="text" name="slmc_no" id="slmc_no" value="{{ old('slmc_no', $permanentRegistration->slmc_no) }}"
                            class="w-full px-6 py-5 bg-gray-50 border-2 border-gray-100 focus:border-emerald-500 rounded-[1.25rem] font-bold text-gray-900 transition-all outline-none shadow-inner">
                        @error('slmc_no') <p class="mt-2 text-[10px] font-black text-red-600 uppercase italic tracking-widest">{{ $message }}</p> @enderror
                    </div>
                    <div class="space-y-3 group">
                        <label for="slmc_date" class="block text-[10px) font-black text-gray-400 uppercase tracking-widest group-focus-within:text-emerald-600 transition-colors">SLMC Issuance Date</label>
                        <input type="date" name="slmc_date" id="slmc_date" value="{{ old('slmc_date', $permanentRegistration->slmc_date) }}"
                            class="w-full px-6 py-5 bg-gray-50 border-2 border-gray-100 focus:border-emerald-500 rounded-[1.25rem] font-bold text-gray-900 transition-all outline-none shadow-inner">
                        @error('slmc_date') <p class="mt-2 text-[10px] font-black text-red-600 uppercase italic tracking-widest">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div class="flex items-center justify-between pt-12 mt-12 border-t-2 border-gray-50">
                    <a href="{{ route('permanent-registrations.index') }}" class="text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] hover:text-gray-900 transition-all border-b border-transparent hover:border-gray-900 pb-1 italic">Abort Modification</a>
                    <button type="submit" 
                        class="px-12 py-6 bg-emerald-600 text-white font-black text-xs uppercase tracking-[0.3em] rounded-[1.5rem] shadow-2xl shadow-emerald-200 hover:bg-emerald-700 hover:scale-[1.02] active:scale-[0.98] transition-all flex items-center gap-4">
                        Update Protocol <i class="bi bi-arrow-repeat text-sm"></i>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
