@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto py-12 px-4 sm:px-6 lg:px-8 tracking-tight">
    
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
        <div class="bg-white rounded-[2.5rem] shadow-2xl border border-gray-100 overflow-hidden text-gray-900">
            <div class="bg-blue-600 px-10 py-8 relative overflow-hidden text-white">
                <div class="absolute -top-24 -right-24 w-64 h-64 bg-white opacity-10 rounded-full blur-3xl"></div>
                <div class="relative z-10">
                    <h2 class="text-3xl font-black flex items-center tracking-tighter uppercase">
                        <i class="bi bi-search mr-4 text-blue-200"></i> Provisioning Search
                    </h2>
                    <p class="text-blue-100 font-bold italic text-xs mt-1 uppercase tracking-widest opacity-80">Locate practitioner identity before issuing temporary credentials</p>
                </div>
            </div>

            <div class="p-10">
                <form action="{{ route('temporary-registrations.create') }}" method="GET" class="space-y-6">
                    <div class="space-y-2 group">
                        <label for="nic" class="block text-[10px] font-black text-gray-400 uppercase tracking-widest group-focus-within:text-blue-600 transition-colors italic">Canonical NIC Identifier <span class="text-red-500">*</span></label>
                        <div class="relative flex items-center">
                            <div class="absolute left-5 text-gray-400 group-focus-within:text-blue-600 transition-colors">
                                <i class="bi bi-person-badge text-xl"></i>
                            </div>
                            <input type="text" name="nic" id="nic" value="{{ request('nic') }}" required
                                class="w-full pl-14 pr-5 py-5 bg-gray-50 border-2 border-gray-100 focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 rounded-[1.5rem] font-bold text-gray-900 transition-all outline-none shadow-inner text-lg tracking-widest"
                                placeholder="e.g. 199XXXXXXXXX">
                            <button type="submit" class="absolute right-3 px-8 py-3 bg-blue-600 text-white font-black text-[10px] uppercase tracking-widest rounded-2xl hover:bg-blue-700 transition-all shadow-lg hover:shadow-blue-200 whitespace-nowrap">
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
                
                <div class="inline-block align-bottom bg-white rounded-[3rem] text-left overflow-hidden shadow-[0_35px_60px_-15px_rgba(0,0,0,0.3)] transform transition-all sm:my-8 sm:align-middle sm:max-w-3xl sm:w-full animate-in zoom-in-95 duration-300 border border-gray-100">
                    <div class="bg-emerald-600 px-10 py-8 relative overflow-hidden">
                        <div class="absolute -top-12 -right-12 w-32 h-32 bg-white/10 rounded-full blur-2xl"></div>
                        <div class="relative z-10 flex justify-between items-center">
                            <div>
                                <h3 class="text-2xl font-black text-white uppercase tracking-tighter" id="modal-title">
                                    <i class="bi bi-person-plus-fill mr-3"></i> Emergency Registration
                                </h3>
                                <p class="text-emerald-100 font-bold italic text-[10px] uppercase tracking-widest mt-1 opacity-80">Direct Injection To Practitioner Ledger</p>
                            </div>
                            <button id="closeModalBtn" class="text-white hover:text-emerald-200 transition-colors">
                                <i class="bi bi-x-circle text-2xl"></i>
                            </button>
                        </div>
                    </div>
                    
                    <form action="{{ route('temporary-registrations.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="is_new_nurse" value="1">
                        <div class="p-10 bg-white space-y-8">
                            <div>
                                <h6 class="text-[10px] font-black text-emerald-600 uppercase tracking-[0.2em] mb-6 border-b border-emerald-50 pb-2">Core Identity Data</h6>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                                    <div class="space-y-2 group">
                                        <label for="new_name" class="block text-[10px] font-black text-gray-400 uppercase tracking-widest group-focus-within:text-emerald-600 transition-colors">Canonical Full Name <span class="text-red-500">*</span></label>
                                        <input type="text" name="new_name" id="new_name" value="{{ old('new_name') }}" required
                                            class="w-full px-5 py-4 bg-gray-50 border-2 border-gray-100 focus:border-emerald-500 rounded-2xl font-bold text-gray-900 transition-all outline-none">
                                    </div>
                                    <div class="space-y-2 group">
                                        <label for="new_nic" class="block text-[10px] font-black text-gray-400 uppercase tracking-widest group-focus-within:text-emerald-600 transition-colors">NIC Identifier <span class="text-red-500">*</span></label>
                                        <input type="text" name="new_nic" id="new_nic" value="{{ old('new_nic') }}" required
                                            class="w-full px-5 py-4 bg-gray-50 border-2 border-gray-100 focus:border-emerald-500 rounded-2xl font-bold text-gray-900 transition-all outline-none">
                                    </div>
                                </div>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mt-8">
                                    <div class="space-y-2 group">
                                        <label for="new_phone" class="block text-[10px] font-black text-gray-400 uppercase tracking-widest group-focus-within:text-emerald-600 transition-colors">Contact Terminal (Phone)</label>
                                        <input type="text" name="new_phone" id="new_phone" value="{{ old('new_phone') }}"
                                            class="w-full px-5 py-4 bg-gray-50 border-2 border-gray-100 focus:border-emerald-500 rounded-2xl font-bold text-gray-900 transition-all outline-none">
                                    </div>
                                    <div class="space-y-2 group">
                                        <label for="new_gender" class="block text-[10px] font-black text-gray-400 uppercase tracking-widest group-focus-within:text-emerald-600 transition-colors">Gender Protocol</label>
                                        <select name="new_gender" id="new_gender"
                                            class="w-full px-5 py-4 bg-gray-50 border-2 border-gray-100 focus:border-emerald-500 rounded-2xl font-bold text-gray-900 transition-all outline-none appearance-none cursor-pointer">
                                            <option value="">Select Protocol</option>
                                            <option value="Female" @selected(old('new_gender') == 'Female')>Female</option>
                                            <option value="Male" @selected(old('new_gender') == 'Male')>Male</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            
                            <div>
                                <h6 class="text-[10px] font-black text-emerald-600 uppercase tracking-[0.2em] mb-6 border-b border-emerald-50 pb-2">Issuance Parameters</h6>
                                <div class="space-y-2 group">
                                    <label for="address_modal" class="block text-[10px] font-black text-gray-400 uppercase tracking-widest group-focus-within:text-emerald-600 transition-colors">Practice Address</label>
                                    <textarea name="address" id="address_modal" rows="2"
                                        class="w-full px-5 py-4 bg-gray-50 border-2 border-gray-100 focus:border-emerald-500 rounded-2xl font-bold text-gray-900 transition-all outline-none resize-none">{{ old('address') }}</textarea>
                                </div>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mt-8">
                                    <div class="space-y-2 group">
                                        <label for="batch_modal" class="block text-[10px] font-black text-gray-400 uppercase tracking-widest group-focus-within:text-emerald-600 transition-colors">Academy Batch</label>
                                        <input type="text" name="batch" id="batch_modal" value="{{ old('batch') }}"
                                            class="w-full px-5 py-4 bg-gray-50 border-2 border-gray-100 focus:border-emerald-500 rounded-2xl font-bold text-gray-900 transition-all outline-none">
                                    </div>
                                    <div class="space-y-2 group">
                                        <label for="school_university_modal" class="block text-[10px] font-black text-gray-400 uppercase tracking-widest group-focus-within:text-emerald-600 transition-colors">Institution</label>
                                        <input type="text" name="school_university" id="school_university_modal" value="{{ old('school_university') }}"
                                            class="w-full px-5 py-4 bg-gray-50 border-2 border-gray-100 focus:border-emerald-500 rounded-2xl font-bold text-gray-900 transition-all outline-none">
                                    </div>
                                </div>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mt-8">
                                    <div class="space-y-2 group">
                                        <label for="birth_date_modal" class="block text-[10px] font-black text-gray-400 uppercase tracking-widest group-focus-within:text-emerald-600 transition-colors">Canonical Birth Date</label>
                                        <input type="date" name="birth_date" id="birth_date_modal" value="{{ old('birth_date') }}"
                                            class="w-full px-5 py-4 bg-gray-50 border-2 border-gray-100 focus:border-emerald-500 rounded-2xl font-bold text-gray-900 transition-all outline-none">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="px-10 py-8 bg-gray-50/50 border-t border-gray-50 flex items-center justify-between">
                            <button type="button" id="cancelModalBtn" class="text-[10px] font-black text-gray-400 uppercase tracking-widest hover:text-gray-900 transition-all">Abort Input</button>
                            <button type="submit" class="px-8 py-4 bg-emerald-600 text-white font-black text-[10px] uppercase tracking-widest rounded-2xl hover:bg-emerald-700 transition-all shadow-xl shadow-emerald-100 flex items-center gap-2">
                                Commit & Issue Protocol <i class="bi bi-chevron-right text-xs"></i>
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
                <h2 class="text-3xl font-black text-gray-900 flex items-center tracking-tighter uppercase">
                    <i class="bi bi-file-earmark-plus text-blue-600 mr-4"></i> Credential Issuance
                </h2>
                <p class="text-gray-500 font-bold italic text-xs mt-1 uppercase tracking-widest opacity-80">Finalizing temporary practitioner registration protocols</p>
            </div>
            <a href="{{ route('temporary-registrations.create') }}" class="px-5 py-3 border-2 border-gray-100 text-[10px] font-black uppercase tracking-widest rounded-2xl text-gray-400 hover:text-gray-900 hover:border-gray-900 transition-all flex items-center gap-2">
                <i class="bi bi-arrow-repeat"></i> Search Different NIC
            </a>
        </div>

        <!-- Profile Preview Card -->
        <div class="bg-indigo-600 rounded-[3rem] shadow-2xl p-10 mb-12 relative overflow-hidden group">
            <div class="absolute -top-32 -right-32 w-80 h-80 bg-white/10 rounded-full blur-3xl group-hover:scale-110 transition-transform duration-700"></div>
            <div class="relative z-10 flex flex-col md:flex-row gap-10 items-center">
                <div class="w-24 h-24 bg-white/10 backdrop-blur-md rounded-[2.5rem] border border-white/20 flex items-center justify-center text-white shrink-0 shadow-inner">
                    <i class="bi bi-person-check-fill text-5xl opacity-90"></i>
                </div>
                <div class="flex-grow space-y-4 text-center md:text-left w-full">
                    <div>
                        <h4 class="text-3xl font-black text-white uppercase tracking-tighter">{{ $nurse->name }}</h4>
                        <div class="flex items-center justify-center md:justify-start gap-4 mt-2">
                            <span class="text-[10px] font-black text-indigo-200 uppercase tracking-widest bg-white/10 px-3 py-1 rounded-xl border border-white/10">Canonical NIC</span>
                            <span class="text-xl font-black text-white tracking-[0.2em]">{{ $nurse->nic }}</span>
                        </div>
                    </div>
                    <div class="grid grid-cols-2 md:grid-cols-3 gap-6 pt-4 border-t border-white/10 italic text-[11px] font-bold text-indigo-100">
                        <div class="group/info">
                            <span class="block opacity-50 uppercase tracking-widest mb-1 text-[9px]">Communication</span>
                            <span class="text-white not-italic">{{ $nurse->phone ?: 'N/A' }}</span>
                        </div>
                        <div class="group/info">
                            <span class="block opacity-50 uppercase tracking-widest mb-1 text-[9px]">Training Cohort</span>
                            <span class="text-white not-italic">{{ $nurse->batch ?: 'N/A' }}</span>
                        </div>
                        <div class="col-span-2 md:col-span-1 group/info">
                            <span class="block opacity-50 uppercase tracking-widest mb-1 text-[9px]">Institution</span>
                            <span class="text-white not-italic truncate block max-w-xs" title="{{ $nurse->school_or_university }}">{{ $nurse->school_or_university ?: 'N/A' }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Application Form -->
        <div class="bg-white rounded-[3rem] shadow-2xl border border-gray-100 overflow-hidden">
            <div class="bg-white px-10 py-8 border-b border-gray-50 flex items-center justify-between">
                <h5 class="text-sm font-black text-gray-900 uppercase tracking-widest flex items-center gap-3 italic">
                    <i class="bi bi-gear-fill text-blue-600 animate-spin-slow"></i> Issuance Parameters
                </h5>
                <span class="text-[10px] font-black text-gray-300 uppercase italic">Ledger Sync: Active</span>
            </div>
            <div class="p-10">
                <form action="{{ route('temporary-registrations.store') }}" method="POST" class="space-y-10">
                    @csrf
                    <input type="hidden" name="nurse_id" value="{{ $nurse->id }}">

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
                        <div class="space-y-3 group">
                            <label for="temp_registration_no" class="block text-[10px] font-black text-gray-400 uppercase tracking-widest group-focus-within:text-blue-600 transition-colors">Registration Serial <span class="text-red-500 font-black">*</span></label>
                            <input type="text" name="temp_registration_no" id="temp_registration_no" value="{{ old('temp_registration_no') }}" required
                                class="w-full px-6 py-5 bg-gray-50 border-2 {{ $errors->has('temp_registration_no') ? 'border-red-400 focus:ring-red-500 bg-red-50' : 'border-gray-100 focus:border-blue-500 focus:ring-blue-500' }} rounded-[1.5rem] font-black text-gray-900 transition-all outline-none focus:ring-4 focus:ring-opacity-20 shadow-inner group-focus-within:shadow-blue-50"
                                placeholder="Enter canonical serial...">
                            @error('temp_registration_no') <p class="mt-2 text-[10px] font-black text-red-600 uppercase italic tracking-widest">{{ $message }}</p> @enderror
                        </div>
                        <div class="space-y-3 group">
                            <label for="temp_registration_date" class="block text-[10px] font-black text-gray-400 uppercase tracking-widest group-focus-within:text-blue-600 transition-colors">Authorization Date <span class="text-red-500 font-black">*</span></label>
                            <input type="date" name="temp_registration_date" id="temp_registration_date" value="{{ old('temp_registration_date', date('Y-m-d')) }}" required
                                class="w-full px-6 py-5 bg-gray-50 border-2 {{ $errors->has('temp_registration_date') ? 'border-red-400 focus:ring-red-500 bg-red-50' : 'border-gray-100 focus:border-blue-500 focus:ring-blue-500' }} rounded-[1.5rem] font-bold text-gray-900 transition-all outline-none focus:ring-4 focus:ring-opacity-20 shadow-inner group-focus-within:shadow-blue-50">
                            @error('temp_registration_date') <p class="mt-2 text-[10px] font-black text-red-600 uppercase italic tracking-widest">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <div class="space-y-3 group">
                        <label for="address" class="block text-[10px] font-black text-gray-400 uppercase tracking-widest group-focus-within:text-blue-600 transition-colors">Operational Practice Address</label>
                        <textarea name="address" id="address" rows="3"
                            class="w-full px-6 py-5 bg-gray-50 border-2 {{ $errors->has('address') ? 'border-red-400 focus:ring-red-500 bg-red-50' : 'border-gray-100 focus:border-blue-500 focus:ring-blue-500' }} rounded-[1.5rem] font-bold text-gray-900 transition-all outline-none focus:ring-4 focus:ring-opacity-20 shadow-inner resize-none group-focus-within:shadow-blue-50"
                            placeholder="Designated workstation or residential corresponding address...">{{ old('address') }}</textarea>
                        @error('address') <p class="mt-2 text-[10px] font-black text-red-600 uppercase italic tracking-widest">{{ $message }}</p> @enderror
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
                        <div class="space-y-3 group">
                            <label for="batch" class="block text-[10px] font-black text-gray-400 uppercase tracking-widest group-focus-within:text-blue-600 transition-colors">Academy Cohort (Batch)</label>
                            <input type="text" name="batch" id="batch" value="{{ old('batch') }}"
                                class="w-full px-6 py-5 bg-gray-50 border-2 {{ $errors->has('batch') ? 'border-red-400 focus:ring-red-500 bg-red-50' : 'border-gray-100 focus:border-blue-500 focus:ring-blue-500' }} rounded-[1.25rem] font-bold text-gray-900 transition-all outline-none focus:ring-4 focus:ring-opacity-20 shadow-inner group-focus-within:shadow-blue-50">
                            @error('batch') <p class="mt-2 text-[10px] font-black text-red-600 uppercase italic tracking-widest">{{ $message }}</p> @enderror
                        </div>
                        <div class="space-y-3 group">
                            <label for="school_university" class="block text-[10px] font-black text-gray-400 uppercase tracking-widest group-focus-within:text-blue-600 transition-colors">Master Institution</label>
                            <input type="text" name="school_university" id="school_university" value="{{ old('school_university') }}"
                                class="w-full px-6 py-5 bg-gray-50 border-2 {{ $errors->has('school_university') ? 'border-red-400 focus:ring-red-500 bg-red-50' : 'border-gray-100 focus:border-blue-500 focus:ring-blue-500' }} rounded-[1.25rem] font-bold text-gray-900 transition-all outline-none focus:ring-4 focus:ring-opacity-20 shadow-inner group-focus-within:shadow-blue-50">
                            @error('school_university') <p class="mt-2 text-[10px] font-black text-red-600 uppercase italic tracking-widest">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
                        <div class="space-y-3 group">
                            <label for="birth_date" class="block text-[10px] font-black text-gray-400 uppercase tracking-widest group-focus-within:text-blue-600 transition-colors">Canonical Birth Date</label>
                            <input type="date" name="birth_date" id="birth_date" value="{{ old('birth_date') }}"
                                class="w-full px-6 py-5 bg-gray-50 border-2 {{ $errors->has('birth_date') ? 'border-red-400 focus:ring-red-500 bg-red-50' : 'border-gray-100 focus:border-blue-500 focus:ring-blue-500' }} rounded-[1.25rem] font-bold text-gray-900 transition-all outline-none focus:ring-4 focus:ring-opacity-20 shadow-inner group-focus-within:shadow-blue-50">
                            @error('birth_date') <p class="mt-2 text-[10px] font-black text-red-600 uppercase italic tracking-widest">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <div class="flex items-center justify-between pt-12 mt-12 border-t-2 border-gray-50">
                        <a href="{{ route('temporary-registrations.index') }}" class="text-[10px] font-black text-gray-400 uppercase tracking-[0.3em] hover:text-gray-900 transition-all border-b border-white hover:border-gray-900 pb-1 italic">Abort Protocol</a>
                        <button type="submit" 
                            class="px-12 py-6 bg-blue-600 text-white font-black text-xs uppercase tracking-[0.4em] rounded-[1.5rem] shadow-[0_20px_50px_rgba(59,130,246,0.3)] hover:bg-blue-700 hover:scale-[1.02] active:scale-[0.98] transition-all flex items-center gap-4">
                            Authorize Registration <i class="bi bi-shield-lock-fill text-sm"></i>
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
    .animate-spin-slow { animation: spin-slow 8s linear infinite; }
</style>
@endsection
