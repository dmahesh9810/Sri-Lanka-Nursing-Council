@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto py-12 px-4 sm:px-6 lg:px-8 tracking-tight text-gray-900">
    <div class="bg-white rounded-[2.5rem] shadow-2xl border border-gray-100 overflow-hidden">
        <div class="bg-blue-600 px-10 py-8 relative overflow-hidden text-white">
            <div class="absolute -top-24 -right-24 w-64 h-64 bg-white opacity-10 rounded-full blur-3xl"></div>
            <div class="absolute -bottom-24 -left-24 w-64 h-64 bg-blue-400 opacity-20 rounded-full blur-3xl"></div>
            
            <div class="relative z-10 flex flex-col sm:flex-row items-center justify-between gap-6">
                <div>
                    <h2 class="text-3xl font-black flex items-center tracking-tighter uppercase whitespace-nowrap">
                        <i class="bi bi-pencil-square mr-4 text-blue-200"></i> Modify Protocol
                    </h2>
                    <p class="text-blue-100 font-bold italic text-xs mt-1 uppercase tracking-widest opacity-80">Refining academic qualification parameters</p>
                </div>
                <div class="bg-white/10 backdrop-blur-md rounded-2xl px-5 py-3 border border-white/20 flex items-center gap-4">
                    <span class="text-[10px] font-black uppercase tracking-widest text-blue-100">Credential Serial:</span>
                    <span class="text-sm font-black bg-blue-500/50 px-3 py-1 rounded-xl border border-blue-300/30 shadow-inner tracking-widest">{{ $additionalQualification->qualification_number }}</span>
                </div>
            </div>

            <div class="card-body p-4 bg-white">
                <form action="{{ route('additional-qualifications.update', $additionalQualification) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <input type="hidden" name="nurse_id" value="{{ $additionalQualification->nurse_id }}">

                    <div class="row mb-3">
                        <div class="col-md-12">
                            <label for="qualification_type" class="form-label fw-bold">Qualification Type <span class="text-danger">*</span></label>
                            <select class="form-select @error('qualification_type') is-invalid @enderror" id="qualification_type" name="qualification_type" required>
                                <option value="">Select Qualification Type</option>
                                @foreach(['A-Diploma in Teaching & Supervision', 'B-Diploma in Ward Management & Supervision', 'C-Diploma in Public Health', 'D-Intensive Care Nursing', 'E-Operation Theatre Nursing', 'F-Pediatric Nursing', 'G-Emergency Nursing', 'H-Orthopedic Nursing', 'I-Counseling in Nursing', 'J-Stoma Care Nursing', 'K-Renal Nursing', 'L-Psychiatric Nursing', 'M-Gerontological Nursing', 'N-Diabetes Educator Nurse', 'O-Palliative Care Nursing', 'P-Cardio Thoracic Nursing', 'Q-Vascular Nursing', 'R-Midwifery'] as $qualType)
                                    <option value="{{ $qualType }}" @selected(old('qualification_type', $additionalQualification->qualification_type) == $qualType)>{{ $qualType }}</option>
                                @endforeach
                            </select>
                            @error('qualification_type') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-6">
                            <label for="qualification_number" class="form-label fw-bold">Qualification Number <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('qualification_number') is-invalid @enderror" id="qualification_number" name="qualification_number" value="{{ old('qualification_number', $additionalQualification->qualification_number) }}" required>
                            @error('qualification_number') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="qualification_date" class="form-label fw-bold">Qualification Date <span class="text-danger">*</span></label>
                            <input type="date" class="form-control @error('qualification_date') is-invalid @enderror" id="qualification_date" name="qualification_date" value="{{ old('qualification_date', $additionalQualification->qualification_date) }}" required>
                            @error('qualification_date') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    <div class="row mb-4 bg-light p-3 rounded-3 mx-0">
                        <div class="col-md-6">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" role="switch" id="certificate_printed" name="certificate_printed" value="1" {{ old('certificate_printed', $additionalQualification->certificate_printed) ? 'checked' : '' }}>
                                <label class="form-check-label fw-bold" for="certificate_printed">Certificate Printed</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" role="switch" id="certificate_posted" name="certificate_posted" value="1" {{ old('certificate_posted', $additionalQualification->certificate_posted) ? 'checked' : '' }}>
                                <label class="form-check-label fw-bold" for="certificate_posted">Certificate Posted</label>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-end gap-2">
                        <a href="{{ route('additional-qualifications.index') }}" class="btn btn-secondary">Cancel</a>
                        <button type="submit" class="btn btn-primary">Update Qualification</button>
                    </div>
                </form>
            </div>
            <span class="text-[10px] font-black text-gray-300 uppercase italic">IDENTITY LOCKED</span>
        </div>

        <div class="p-10 bg-white">
            <form action="{{ route('additional-qualifications.update', $additionalQualification) }}" method="POST" class="space-y-10">
                @csrf
                @method('PUT')
                
                <input type="hidden" name="nurse_id" value="{{ $additionalQualification->nurse_id }}">

                <div class="space-y-3 group">
                    <label for="qualification_type" class="block text-[10px] font-black text-gray-400 uppercase tracking-widest group-focus-within:text-blue-600 transition-colors">Credential Specification <span class="text-red-500 font-black">*</span></label>
                    <input type="text" name="qualification_type" id="qualification_type" value="{{ old('qualification_type', $additionalQualification->qualification_type) }}" required
                        class="w-full px-6 py-5 bg-gray-50 border-2 {{ $errors->has('qualification_type') ? 'border-red-400 focus:ring-red-500 bg-red-50' : 'border-gray-100 focus:border-blue-500 focus:ring-blue-500' }} rounded-[1.5rem] font-black text-gray-900 transition-all outline-none focus:ring-4 focus:ring-blue-500/10 shadow-inner text-lg"
                        placeholder="e.g. Midwifery, ICU Training, Special Care Oncology">
                    @error('qualification_type') <p class="mt-2 text-[10px] font-black text-red-600 uppercase italic tracking-widest">{{ $message }}</p> @enderror
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
                    <div class="space-y-3 group">
                        <label for="qualification_number" class="block text-[10px] font-black text-gray-400 uppercase tracking-widest group-focus-within:text-blue-600 transition-colors">Credential Protocol No. <span class="text-red-500 font-black">*</span></label>
                        <input type="text" name="qualification_number" id="qualification_number" value="{{ old('qualification_number', $additionalQualification->qualification_number) }}" required
                            class="w-full px-6 py-5 bg-gray-50 border-2 {{ $errors->has('qualification_number') ? 'border-red-400 focus:ring-red-500 bg-red-50' : 'border-gray-100 focus:border-blue-500 focus:ring-blue-500' }} rounded-[1.25rem] font-black text-gray-900 transition-all outline-none shadow-inner"
                            placeholder="Canonical serial number...">
                        @error('qualification_number') <p class="mt-2 text-[10px] font-black text-red-600 uppercase italic tracking-widest">{{ $message }}</p> @enderror
                    </div>
                    <div class="space-y-3 group">
                        <label for="qualification_date" class="block text-[10px] font-black text-gray-400 uppercase tracking-widest group-focus-within:text-blue-600 transition-colors">Issuance Authorization Date <span class="text-red-500 font-black">*</span></label>
                        <input type="date" name="qualification_date" id="qualification_date" value="{{ old('qualification_date', $additionalQualification->qualification_date) }}" required
                            class="w-full px-6 py-5 bg-gray-50 border-2 {{ $errors->has('qualification_date') ? 'border-red-400 focus:ring-red-500 bg-red-50' : 'border-gray-100 focus:border-blue-500 focus:ring-blue-500' }} rounded-[1.25rem] font-bold text-gray-900 transition-all outline-none shadow-inner">
                        @error('qualification_date') <p class="mt-2 text-[10px] font-black text-red-600 uppercase italic tracking-widest">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div class="bg-gray-50/50 p-10 rounded-[2.5rem] border-2 border-gray-100/50 grid grid-cols-1 md:grid-cols-2 gap-10">
                    <div class="flex items-center justify-between bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                        <div>
                            <h6 class="text-[10px] font-black text-gray-900 uppercase tracking-widest">Issuance Protocol</h6>
                            <p class="text-[9px] font-bold text-gray-400 uppercase italic">Certificate Physical Print</p>
                        </div>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" name="certificate_printed" value="1" {{ old('certificate_printed', $additionalQualification->certificate_printed) ? 'checked' : '' }} class="sr-only peer">
                            <div class="w-14 h-7 bg-gray-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-6 after:w-6 after:transition-all peer-checked:bg-blue-600"></div>
                        </label>
                    </div>
                    <div class="flex items-center justify-between bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                        <div>
                            <h6 class="text-[10px] font-black text-gray-900 uppercase tracking-widest">Distribution Protocol</h6>
                            <p class="text-[9px] font-bold text-gray-400 uppercase italic">Postal Logic Dispatched</p>
                        </div>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" name="certificate_posted" value="1" {{ old('certificate_posted', $additionalQualification->certificate_posted) ? 'checked' : '' }} class="sr-only peer">
                            <div class="w-14 h-7 bg-gray-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-6 after:w-6 after:transition-all peer-checked:bg-blue-600"></div>
                        </label>
                    </div>
                </div>

                <div class="flex items-center justify-between pt-12 mt-12 border-t-2 border-gray-50">
                    <a href="{{ route('additional-qualifications.index') }}" class="text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] hover:text-gray-900 transition-all border-b border-transparent hover:border-gray-900 pb-1 italic">Abort Modification</a>
                    <button type="submit" 
                        class="px-12 py-6 bg-blue-600 text-white font-black text-xs uppercase tracking-[0.3em] rounded-[1.5rem] shadow-2xl shadow-blue-200 hover:bg-blue-700 hover:scale-[1.02] active:scale-[0.98] transition-all flex items-center gap-4">
                        Update Protocol <i class="bi bi-arrow-repeat text-sm"></i>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
