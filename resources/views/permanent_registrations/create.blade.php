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
            <div class="bg-emerald-600 px-10 py-8 relative overflow-hidden text-white">
                <div class="absolute -top-24 -right-24 w-64 h-64 bg-white opacity-10 rounded-full blur-3xl"></div>
                <div class="relative z-10">
                    <h2 class="text-3xl font-black flex items-center tracking-tighter uppercase">
                        <i class="bi bi-search mr-4 text-emerald-200"></i> Identity Verification
                    </h2>
                    <p class="text-emerald-100 font-bold italic text-xs mt-1 uppercase tracking-widest opacity-80">Locate practitioner identity before issuing permanent certification</p>
                </div>
            </div>

            <div class="p-10">
                <form action="{{ route('permanent-registrations.create') }}" method="GET" class="space-y-6">
                    <div class="space-y-2 group">
                        <label for="nic" class="block text-[10px] font-black text-gray-400 uppercase tracking-widest group-focus-within:text-emerald-600 transition-colors italic">Canonical NIC Identifier <span class="text-red-500">*</span></label>
                        <div class="relative flex items-center">
                            <div class="absolute left-5 text-gray-400 group-focus-within:text-emerald-600 transition-colors">
                                <i class="bi bi-person-badge text-xl"></i>
                            </div>
                            <input type="text" name="nic" id="nic" value="{{ request('nic') }}" required
                                class="w-full pl-14 pr-5 py-5 bg-gray-50 border-2 border-gray-100 focus:border-emerald-500 focus:ring-4 focus:ring-emerald-500/10 rounded-[1.5rem] font-black text-gray-900 transition-all outline-none shadow-inner text-lg tracking-widest"
                                placeholder="e.g. 199XXXXXXXXX">
                            <button type="submit" class="absolute right-3 px-8 py-3 bg-emerald-600 text-white font-black text-[10px] uppercase tracking-widest rounded-2xl hover:bg-emerald-700 transition-all shadow-lg hover:shadow-emerald-200 whitespace-nowrap">
                                Execute Search
                            </button>
                        </div>
                        <p class="text-[10px] font-bold text-gray-400 italic">Universal practitioner lookup against council archives required.</p>
                    </div>
                </form>
                
                <div class="mt-12 pt-8 border-t-2 border-dashed border-gray-100 text-center">
                    <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-6">Identity Not In Archives?</p>
                    <button type="button" id="openModalBtn"
                        class="inline-flex items-center px-10 py-5 border-2 border-emerald-500 bg-emerald-50/50 text-emerald-700 font-black text-xs uppercase tracking-[0.2em] rounded-3xl hover:bg-emerald-500 hover:text-white transition-all group">
                        <i class="bi bi-person-plus-fill mr-3 transition-transform group-hover:scale-125"></i> Initialize New Profile
                    </button>
                </div>
            </div>
        </div>

        <!-- Add Nurse Modal (Tailwind Implementation) -->
        <div id="addNurseModal" class="hidden fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <div id="modalOverlay" class="fixed inset-0 bg-gray-900/60 backdrop-blur-sm transition-opacity animate-in fade-in duration-300"></div>
                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
                
                <div class="inline-block align-bottom bg-white rounded-[3rem] text-left overflow-hidden shadow-[0_35px_60px_-15px_rgba(0,0,0,0.3)] transform transition-all sm:my-8 sm:align-middle sm:max-w-4xl sm:w-full animate-in zoom-in-95 duration-300 border border-gray-100">
                    <div class="bg-emerald-600 px-10 py-8 relative overflow-hidden">
                        <div class="absolute -top-12 -right-12 w-32 h-32 bg-white/10 rounded-full blur-2xl"></div>
                        <div class="relative z-10 flex justify-between items-center text-white">
                            <div>
                                <h3 class="text-2xl font-black uppercase tracking-tighter" id="modal-title">
                                    <i class="bi bi-person-plus-fill mr-3"></i> Unified Enrollment
                                </h3>
                                <p class="text-emerald-100 font-bold italic text-[10px] uppercase tracking-widest mt-1 opacity-80">Full canonical registration & permanent issuance</p>
                            </div>
                            <button id="closeModalBtn" class="text-white hover:text-emerald-200 transition-colors">
                                <i class="bi bi-x-circle text-2xl"></i>
                            </button>
                        </div>
                    </div>
                    
                    <form action="{{ route('permanent-registrations.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="is_new_nurse" value="1">
                        <div class="p-10 bg-white overflow-y-auto max-h-[70vh] space-y-12 custom-scrollbar">
                            <!-- Section 1: Personal -->
                            <div class="space-y-8">
                                <h6 class="text-[10px] font-black text-emerald-600 uppercase tracking-[0.2em] mb-6 border-b border-emerald-50 pb-2 italic">Practitioner Identity Vault</h6>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                                    <div class="space-y-2 group">
                                        <label for="new_name" class="block text-[10px] font-black text-gray-400 uppercase tracking-widest">Canonical Full Name <span class="text-red-500">*</span></label>
                                        <input type="text" name="new_name" id="new_name" value="{{ old('new_name') }}" required
                                            class="w-full px-5 py-4 bg-gray-50 border-2 border-gray-100 focus:border-emerald-500 rounded-2xl font-bold text-gray-900 transition-all outline-none">
                                    </div>
                                    <div class="space-y-2 group">
                                        <label for="new_nic" class="block text-[10px] font-black text-gray-400 uppercase tracking-widest">NIC Primary Key <span class="text-red-500">*</span></label>
                                        <input type="text" name="new_nic" id="new_nic" value="{{ old('new_nic') }}" required
                                            class="w-full px-5 py-4 bg-gray-50 border-2 border-gray-100 focus:border-emerald-500 rounded-2xl font-bold text-gray-900 transition-all outline-none">
                                    </div>
                                </div>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                                    <div class="space-y-2 group">
                                        <label for="new_phone" class="block text-[10px] font-black text-gray-400 uppercase tracking-widest">Contact Protocol</label>
                                        <input type="text" name="new_phone" id="new_phone" value="{{ old('new_phone') }}"
                                            class="w-full px-5 py-4 bg-gray-50 border-2 border-gray-100 focus:border-emerald-500 rounded-2xl font-bold text-gray-900 transition-all outline-none">
                                    </div>
                                    <div class="space-y-2 group">
                                        <label for="new_gender" class="block text-[10px] font-black text-gray-400 uppercase tracking-widest">Biological Gender</label>
                                        <select name="new_gender" id="new_gender"
                                            class="w-full px-5 py-4 bg-gray-50 border-2 border-gray-100 focus:border-emerald-500 rounded-2xl font-bold text-gray-900 transition-all outline-none appearance-none cursor-pointer">
                                            <option value="">Select Protocol</option>
                                            <option value="Female" @selected(old('new_gender') == 'Female')>Female</option>
                                            <option value="Male" @selected(old('new_gender') == 'Male')>Male</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <!-- Section 2: Permanent Registration -->
                            <div class="space-y-8">
                                <h6 class="text-[10px] font-black text-emerald-600 uppercase tracking-[0.2em] mb-6 border-b border-emerald-50 pb-2 italic">Ledger Authorization Parameters</h6>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                                    <div class="space-y-2 group">
                                        <label for="perm_registration_no_modal" class="block text-[10px] font-black text-gray-400 uppercase tracking-widest">Permanent Serial <span class="text-red-500">*</span></label>
                                        <input type="text" name="perm_registration_no" id="perm_registration_no_modal" value="{{ old('perm_registration_no') }}" required
                                            class="w-full px-5 py-4 bg-gray-50 border-2 border-gray-100 focus:border-emerald-500 rounded-2xl font-black text-gray-900 transition-all outline-none">
                                    </div>
                                    <div class="space-y-2 group">
                                        <label for="perm_registration_date_modal" class="block text-[10px] font-black text-gray-400 uppercase tracking-widest">Issuance Date <span class="text-red-500">*</span></label>
                                        <input type="date" name="perm_registration_date" id="perm_registration_date_modal" value="{{ old('perm_registration_date', date('Y-m-d')) }}" required
                                            class="w-full px-5 py-4 bg-gray-50 border-2 border-gray-100 focus:border-emerald-500 rounded-2xl font-bold text-gray-900 transition-all outline-none">
                                    </div>
                                </div>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                                    <div class="space-y-2 group">
                                        <label for="appointment_date_modal" class="block text-[10px] font-black text-gray-400 uppercase tracking-widest">Appointment Date</label>
                                        <input type="date" name="appointment_date" id="appointment_date_modal" value="{{ old('appointment_date') }}"
                                            class="w-full px-5 py-4 bg-gray-50 border-2 border-gray-100 focus:border-emerald-500 rounded-2xl font-bold text-gray-900 transition-all outline-none">
                                    </div>
                                    <div class="space-y-2 group">
                                        <label for="grade_modal" class="block text-[10px] font-black text-gray-400 uppercase tracking-widest">Seniority Grade</label>
                                        <input type="text" name="grade" id="grade_modal" value="{{ old('grade') }}"
                                            class="w-full px-5 py-4 bg-gray-50 border-2 border-gray-100 focus:border-emerald-500 rounded-2xl font-bold text-gray-900 transition-all outline-none">
                                    </div>
                                </div>
                                <div class="space-y-2 group">
                                    <label for="present_workplace_modal" class="block text-[10px] font-black text-gray-400 uppercase tracking-widest">Authorized Workplace</label>
                                    <input type="text" name="present_workplace" id="present_workplace_modal" value="{{ old('present_workplace') }}"
                                        class="w-full px-5 py-4 bg-gray-50 border-2 border-gray-100 focus:border-emerald-500 rounded-2xl font-bold text-gray-900 transition-all outline-none">
                                </div>
                                <div class="space-y-2 group">
                                    <label for="address_modal" class="block text-[10px] font-black text-gray-400 uppercase tracking-widest">Official Address</label>
                                    <textarea name="address" id="address_modal" rows="2"
                                        class="w-full px-5 py-4 bg-gray-50 border-2 border-gray-100 focus:border-emerald-500 rounded-2xl font-bold text-gray-900 transition-all outline-none resize-none">{{ old('address') }}</textarea>
                                </div>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                                    <div class="space-y-2 group">
                                        <label for="batch_modal" class="block text-[10px] font-black text-gray-400 uppercase tracking-widest">Academy Batch</label>
                                        <input type="text" name="batch" id="batch_modal" value="{{ old('batch') }}"
                                            class="w-full px-5 py-4 bg-gray-50 border-2 border-gray-100 focus:border-emerald-500 rounded-2xl font-bold text-gray-900 transition-all outline-none">
                                    </div>
                                    <div class="space-y-2 group">
                                        <label for="school_university_modal" class="block text-[10px] font-black text-gray-400 uppercase tracking-widest">Primary Institution</label>
                                        <input type="text" name="school_university" id="school_university_modal" value="{{ old('school_university') }}"
                                            class="w-full px-5 py-4 bg-gray-50 border-2 border-gray-100 focus:border-emerald-500 rounded-2xl font-bold text-gray-900 transition-all outline-none">
                                    </div>
                                </div>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                                    <div class="space-y-2 group">
                                        <label for="birth_date_modal" class="block text-[10px] font-black text-gray-400 uppercase tracking-widest">Birth Date</label>
                                        <input type="date" name="birth_date" id="birth_date_modal" value="{{ old('birth_date') }}"
                                            class="w-full px-5 py-4 bg-gray-50 border-2 border-gray-100 focus:border-emerald-500 rounded-2xl font-bold text-gray-900 transition-all outline-none">
                                    </div>
                                    <div class="space-y-2 group">
                                        <label for="qualification_modal" class="block text-[10px] font-black text-gray-400 uppercase tracking-widest">Credential Degree</label>
                                        <select name="qualification" id="qualification_modal"
                                            class="w-full px-5 py-4 bg-gray-50 border-2 border-gray-100 focus:border-emerald-500 rounded-2xl font-black text-gray-900 transition-all outline-none appearance-none cursor-pointer">
                                            <option value="">Select Degree</option>
                                            <option value="Diploma" @selected(old('qualification') == 'Diploma')>Diploma</option>
                                            <option value="General Nursing" @selected(old('qualification') == 'General Nursing')>General Nursing</option>
                                            <option value="BSc Nursing" @selected(old('qualification') == 'BSc Nursing')>BSc Nursing</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                                    <div class="space-y-2 group">
                                        <label for="slmc_no_modal" class="block text-[10px] font-black text-gray-400 uppercase tracking-widest">SLMC Identification</label>
                                        <input type="text" name="slmc_no" id="slmc_no_modal" value="{{ old('slmc_no') }}"
                                            class="w-full px-5 py-4 bg-gray-50 border-2 border-gray-100 focus:border-emerald-500 rounded-2xl font-bold text-gray-900 transition-all outline-none">
                                    </div>
                                    <div class="space-y-2 group">
                                        <label for="slmc_date_modal" class="block text-[10px] font-black text-gray-400 uppercase tracking-widest">SLMC Auth Date</label>
                                        <input type="date" name="slmc_date" id="slmc_date_modal" value="{{ old('slmc_date') }}"
                                            class="w-full px-5 py-4 bg-gray-50 border-2 border-gray-100 focus:border-emerald-500 rounded-2xl font-bold text-gray-900 transition-all outline-none">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="px-10 py-8 bg-gray-50/50 border-t border-gray-50 flex items-center justify-between">
                            <button type="button" id="cancelModalBtn" class="text-[10px] font-black text-gray-400 uppercase tracking-widest hover:text-gray-900 transition-all italic">Abort Unified Entry</button>
                            <button type="submit" class="px-8 py-4 bg-emerald-600 text-white font-black text-[10px] uppercase tracking-widest rounded-2xl hover:bg-emerald-700 transition-all shadow-xl shadow-emerald-100 flex items-center gap-2">
                                Authorize Protocol <i class="bi bi-shield-check text-sm"></i>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const modal = document.getElementById('addNurseModal');
                const openBtn = document.getElementById('openModalBtn');
                const closeBtn = document.getElementById('closeModalBtn');
                const cancelBtn = document.getElementById('cancelModalBtn');
                const overlay = document.getElementById('modalOverlay');

                const showModal = () => {
                    modal.classList.remove('hidden');
                    document.body.style.overflow = 'hidden';
                };

                const hideModal = () => {
                    modal.classList.add('hidden');
                    document.body.style.overflow = 'auto';
                };

                openBtn?.addEventListener('click', showModal);
                closeBtn?.addEventListener('click', hideModal);
                cancelBtn?.addEventListener('click', hideModal);
                overlay?.addEventListener('click', hideModal);
            });
        </script>

    @else
        <!-- Step 2: Display Profile Preview and Registration Form -->
        
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-10 gap-6">
            <div>
                <h2 class="text-3xl font-black text-gray-900 flex items-center tracking-tighter uppercase leading-none">
                    <i class="bi bi-file-earmark-plus text-emerald-600 mr-4"></i> Permanent Issuance
                </h2>
                <p class="text-gray-500 font-bold italic text-xs mt-1 uppercase tracking-widest opacity-80">Authorizing lifetime practitioner credentials</p>
            </div>
            <a href="{{ route('permanent-registrations.create') }}" class="px-5 py-3 border-2 border-gray-100 text-[10px] font-black uppercase tracking-widest rounded-2xl text-gray-400 hover:text-gray-900 hover:border-gray-900 transition-all flex items-center gap-2">
                <i class="bi bi-arrow-repeat"></i> Registry Refresh
            </a>
        </div>

        <!-- Profile Context Card -->
        <div class="bg-emerald-600 rounded-[3rem] shadow-2xl p-10 mb-12 relative overflow-hidden group text-white">
            <div class="absolute -top-32 -right-32 w-80 h-80 bg-white/10 rounded-full blur-3xl group-hover:scale-110 transition-transform duration-700"></div>
            <div class="relative z-10 flex flex-col md:flex-row gap-10 items-center">
                <div class="w-24 h-24 bg-white/10 backdrop-blur-md rounded-[2.5rem] border border-white/20 flex items-center justify-center text-white shrink-0 shadow-inner">
                    <i class="bi bi-person-check-fill text-5xl opacity-90"></i>
                </div>
                <div class="flex-grow space-y-4 text-center md:text-left w-full">
                    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                        <div>
                            <h4 class="text-3xl font-black uppercase tracking-tighter leading-tight">{{ $nurse->name }}</h4>
                            <div class="flex items-center justify-center md:justify-start gap-4 mt-2">
                                <span class="text-[10px] font-black text-emerald-200 uppercase tracking-widest bg-white/10 px-3 py-1 rounded-xl border border-white/10 flex items-center gap-2">
                                    <i class="bi bi-fingerprint"></i> Universal NIC
                                </span>
                                <span class="text-xl font-black tracking-[0.2em]">{{ $nurse->nic }}</span>
                            </div>
                        </div>
                        @if($nurse->temporaryRegistration)
                            <div class="bg-white/10 backdrop-blur-md px-6 py-4 rounded-3xl border border-white/10 flex flex-col items-center md:items-end">
                                <span class="text-[9px] font-black text-emerald-200 uppercase tracking-widest mb-1 italic">Prelim Protocol</span>
                                <span class="text-lg font-black tracking-widest">{{ $nurse->temporaryRegistration->temp_registration_no }}</span>
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
                    <i class="bi bi-gear-fill text-emerald-600 animate-spin-slow"></i> Issuance Governance
                </h5>
                <span class="text-[10px] font-black text-gray-300 uppercase italic">Ledger Authorization: ACTIVE</span>
            </div>
            <div class="p-10">
                <form action="{{ route('permanent-registrations.store') }}" method="POST" class="space-y-12">
                    @csrf
                    <input type="hidden" name="nurse_id" value="{{ $nurse->id }}">

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
                        <div class="space-y-3 group">
                            <label for="perm_registration_no" class="block text-[10px] font-black text-gray-400 uppercase tracking-widest group-focus-within:text-emerald-600 transition-colors">Permanent Registry Serial <span class="text-red-500 font-black">*</span></label>
                            <input type="text" name="perm_registration_no" id="perm_registration_no" value="{{ old('perm_registration_no') }}" required
                                class="w-full px-6 py-5 bg-gray-50 border-2 {{ $errors->has('perm_registration_no') ? 'border-red-400 focus:ring-red-500 bg-red-50' : 'border-gray-100 focus:border-emerald-500 focus:ring-emerald-500' }} rounded-[1.5rem] font-black text-gray-900 transition-all outline-none focus:ring-4 focus:ring-emerald-500/10 shadow-inner"
                                placeholder="Enter canonical serial...">
                            @error('perm_registration_no') <p class="mt-2 text-[10px] font-black text-red-600 uppercase italic tracking-widest">{{ $message }}</p> @enderror
                        </div>
                        <div class="space-y-3 group">
                            <label for="perm_registration_date" class="block text-[10px] font-black text-gray-400 uppercase tracking-widest group-focus-within:text-emerald-600 transition-colors">Authorization Date <span class="text-red-500 font-black">*</span></label>
                            <input type="date" name="perm_registration_date" id="perm_registration_date" value="{{ old('perm_registration_date', date('Y-m-d')) }}" required
                                class="w-full px-6 py-5 bg-gray-50 border-2 {{ $errors->has('perm_registration_date') ? 'border-red-400 focus:ring-red-500 bg-red-50' : 'border-gray-100 focus:border-emerald-500 focus:ring-emerald-500' }} rounded-[1.5rem] font-bold text-gray-900 transition-all outline-none shadow-inner">
                            @error('perm_registration_date') <p class="mt-2 text-[10px] font-black text-red-600 uppercase italic tracking-widest">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-10 border-t border-gray-50 pt-10">
                        <div class="space-y-3 group">
                            <label for="appointment_date" class="block text-[10px] font-black text-gray-400 uppercase tracking-widest group-focus-within:text-emerald-600 transition-colors">Civil Appointment Date</label>
                            <input type="date" name="appointment_date" id="appointment_date" value="{{ old('appointment_date') }}"
                                class="w-full px-6 py-5 bg-gray-50 border-2 border-gray-100 focus:border-emerald-500 rounded-[1.25rem] font-bold text-gray-900 transition-all outline-none shadow-inner">
                        </div>
                        <div class="space-y-3 group">
                            <label for="grade" class="block text-[10px] font-black text-gray-400 uppercase tracking-widest group-focus-within:text-emerald-600 transition-colors">Seniority Grade Level</label>
                            <input type="text" name="grade" id="grade" value="{{ old('grade') }}"
                                class="w-full px-6 py-5 bg-gray-50 border-2 border-gray-100 focus:border-emerald-500 rounded-[1.25rem] font-bold text-gray-900 transition-all outline-none shadow-inner"
                                placeholder="e.g. Grade II">
                        </div>
                    </div>

                    <div class="space-y-3 group">
                        <label for="present_workplace" class="block text-[10px] font-black text-gray-400 uppercase tracking-widest group-focus-within:text-emerald-600 transition-colors">Authorized Clinical Workplace</label>
                        <input type="text" name="present_workplace" id="present_workplace" value="{{ old('present_workplace') }}"
                            class="w-full px-6 py-5 bg-gray-50 border-2 border-gray-100 focus:border-emerald-500 rounded-[1.25rem] font-bold text-gray-900 transition-all outline-none shadow-inner"
                            placeholder="Primary operational jurisdiction...">
                    </div>

                    <div class="space-y-3 group">
                        <label for="address" class="block text-[10px] font-black text-gray-400 uppercase tracking-widest group-focus-within:text-emerald-600 transition-colors">Canonical Resident Address</label>
                        <textarea name="address" id="address" rows="2"
                            class="w-full px-6 py-5 bg-gray-50 border-2 border-gray-100 focus:border-emerald-500 rounded-[1.25rem] font-bold text-gray-900 transition-all outline-none shadow-inner resize-none"
                            placeholder="Current residing records accurately reflecting practitioner whereabouts...">{{ old('address') }}</textarea>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-10 pt-10 border-t border-gray-50">
                        <div class="space-y-3 group">
                            <label for="batch" class="block text-[10px] font-black text-gray-400 uppercase tracking-widest group-focus-within:text-emerald-600 transition-colors">Academic Cycle (Batch)</label>
                            <input type="text" name="batch" id="batch" value="{{ old('batch') }}"
                                class="w-full px-6 py-5 bg-gray-50 border-2 border-gray-100 focus:border-emerald-500 rounded-[1.25rem] font-bold text-gray-900 transition-all outline-none shadow-inner">
                        </div>
                        <div class="space-y-3 group">
                            <label for="school_university" class="block text-[10px] font-black text-gray-400 uppercase tracking-widest group-focus-within:text-emerald-600 transition-colors">Primary Educational Institution</label>
                            <input type="text" name="school_university" id="school_university" value="{{ old('school_university') }}"
                                class="w-full px-6 py-5 bg-gray-50 border-2 border-gray-100 focus:border-emerald-500 rounded-[1.25rem] font-bold text-gray-900 transition-all outline-none shadow-inner">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-10 pt-10 border-t border-gray-50">
                        <div class="space-y-3 group">
                            <label for="birth_date" class="block text-[10px] font-black text-gray-400 uppercase tracking-widest group-focus-within:text-emerald-600 transition-colors">Canonical Birth Date</label>
                            <input type="date" name="birth_date" id="birth_date" value="{{ old('birth_date') }}"
                                class="w-full px-6 py-5 bg-gray-50 border-2 border-gray-100 focus:border-emerald-500 rounded-[1.25rem] font-bold text-gray-900 transition-all outline-none shadow-inner">
                        </div>
                        <div class="space-y-3 group">
                            <label for="qualification" class="block text-[10px] font-black text-gray-400 uppercase tracking-widest group-focus-within:text-emerald-600 transition-colors">Certification Degree</label>
                            <select name="qualification" id="qualification"
                                class="w-full px-6 py-5 bg-gray-50 border-2 border-gray-100 focus:border-emerald-500 rounded-[1.25rem] font-black text-gray-900 transition-all outline-none appearance-none cursor-pointer">
                                <option value="">Select Protocol</option>
                                <option value="Diploma" @selected(old('qualification') == 'Diploma')>Diploma</option>
                                <option value="General Nursing" @selected(old('qualification') == 'General Nursing')>General Nursing</option>
                                <option value="BSc Nursing" @selected(old('qualification') == 'BSc Nursing')>BSc Nursing</option>
                            </select>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-10 pt-10 border-t border-gray-50">
                        <div class="space-y-3 group">
                            <label for="slmc_no" class="block text-[10px] font-black text-gray-400 uppercase tracking-widest group-focus-within:text-emerald-600 transition-colors">SLMC Serial Identification</label>
                            <input type="text" name="slmc_no" id="slmc_no" value="{{ old('slmc_no') }}"
                                class="w-full px-6 py-5 bg-gray-50 border-2 border-gray-100 focus:border-emerald-500 rounded-[1.25rem] font-bold text-gray-900 transition-all outline-none shadow-inner">
                        </div>
                        <div class="space-y-3 group">
                            <label for="slmc_date" class="block text-[10px] font-black text-gray-400 uppercase tracking-widest group-focus-within:text-emerald-600 transition-colors">SLMC Issuance Date</label>
                            <input type="date" name="slmc_date" id="slmc_date" value="{{ old('slmc_date') }}"
                                class="w-full px-6 py-5 bg-gray-50 border-2 border-gray-100 focus:border-emerald-500 rounded-[1.25rem] font-bold text-gray-900 transition-all outline-none shadow-inner">
                        </div>
                    </div>

                    <div class="flex items-center justify-between pt-12 mt-12 border-t-2 border-gray-100">
                        <a href="{{ route('permanent-registrations.index') }}" class="text-[10px] font-black text-gray-400 uppercase tracking-[0.4em] hover:text-gray-900 transition-all border-b border-transparent hover:border-gray-900 pb-1 italic">Abort Issuance</a>
                        <button type="submit" 
                            class="px-12 py-6 bg-emerald-600 text-white font-black text-xs uppercase tracking-[0.4em] rounded-[1.5rem] shadow-[0_20px_50px_rgba(16,185,129,0.3)] hover:bg-emerald-700 hover:scale-[1.02] active:scale-[0.98] transition-all flex items-center gap-4">
                            Authorize Protocol <i class="bi bi-shield-check-fill text-sm"></i>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif
</div>

<style>
    @keyframes spin-slow {
        from { transform: rotate(0deg); }
        to { transform: rotate(360deg); }
    }
    .animate-spin-slow { animation: spin-slow 12s linear infinite; }
    .custom-scrollbar::-webkit-scrollbar { width: 5px; }
    .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
    .custom-scrollbar::-webkit-scrollbar-thumb { background: #e2e8f0; border-radius: 10px; }
    .custom-scrollbar::-webkit-scrollbar-thumb:hover { background: #cbd5e1; }
</style>
@endsection
