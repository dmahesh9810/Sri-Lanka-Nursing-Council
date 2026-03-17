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
                    <p class="text-blue-100 font-bold italic text-xs mt-1 uppercase tracking-widest opacity-80">Refining foreign certificate parameters</p>
                </div>
                <div class="bg-white/10 backdrop-blur-md rounded-2xl px-6 py-3 border border-white/20 flex flex-col items-center">
                    <span class="text-[9px] font-black uppercase tracking-widest text-blue-100 mb-1">Authorization Domain:</span>
                    <span class="text-sm font-black bg-blue-500/50 px-4 py-1 rounded-xl border border-blue-300/30 shadow-inner tracking-widest uppercase">{{ $foreignCertificate->certificate_type }}</span>
                </div>
            </div>
        </div>
        
        <div class="bg-gray-50 border-b border-gray-100 px-10 py-6 flex items-center justify-between">
            <div class="flex items-center gap-4">
                <div class="w-10 h-10 bg-blue-100 rounded-xl flex items-center justify-center text-blue-600">
                    <i class="bi bi-person-check-fill text-xl"></i>
                </div>
                <div>
                    <h4 class="text-sm font-black uppercase tracking-tighter">{{ $foreignCertificate->nurse->name }}</h4>
                    <span class="text-[10px] font-black text-gray-400 uppercase tracking-widest italic font-mono">NIC ARCHIVE: {{ $foreignCertificate->nurse->nic }}</span>
                </div>
            </div>
            <span class="text-[10px] font-black text-gray-300 uppercase italic">IDENTITY LOCKED</span>
        </div>

        <div class="p-10 bg-white">
            <form action="{{ route('foreign-certificates.update', $foreignCertificate) }}" method="POST" class="space-y-10">
                @csrf
                @method('PUT')
                
                <input type="hidden" name="nurse_id" value="{{ $foreignCertificate->nurse_id }}">

                <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
                    <div class="space-y-3 group">
                        <label for="certificate_type" class="block text-[10px] font-black text-gray-400 uppercase tracking-widest group-focus-within:text-blue-600 transition-colors italic">Authorization Domain <span class="text-red-500 font-black">*</span></label>
                        <select name="certificate_type" id="certificate_type" required
                            class="w-full px-6 py-5 bg-gray-50 border-2 {{ $errors->has('certificate_type') ? 'border-red-400 focus:ring-red-500 bg-red-50' : 'border-gray-100 focus:border-blue-500 focus:ring-blue-500' }} rounded-[1.5rem] font-black text-gray-900 transition-all outline-none shadow-inner appearance-none cursor-pointer">
                            <option value="Verification" {{ old('certificate_type', $foreignCertificate->certificate_type) == 'Verification' ? 'selected' : '' }}>Verification</option>
                            <option value="Good Standing" {{ old('certificate_type', $foreignCertificate->certificate_type) == 'Good Standing' ? 'selected' : '' }}>Good Standing</option>
                            <option value="Confirmation" {{ old('certificate_type', $foreignCertificate->certificate_type) == 'Confirmation' ? 'selected' : '' }}>Confirmation</option>
                            <option value="Additional Verification" {{ old('certificate_type', $foreignCertificate->certificate_type) == 'Additional Verification' ? 'selected' : '' }}>Additional Verification</option>
                        </select>
                        @error('certificate_type') <p class="mt-2 text-[10px] font-black text-red-600 uppercase italic tracking-widest">{{ $message }}</p> @enderror
                    </div>
                    <div class="space-y-3 group">
                        <label for="country" class="block text-[10px] font-black text-gray-400 uppercase tracking-widest group-focus-within:text-blue-600 transition-colors italic">Target Jurisdiction <span class="text-red-500 font-black">*</span></label>
                        <input type="text" name="country" id="country" value="{{ old('country', $foreignCertificate->country) }}" required
                            class="w-full px-6 py-5 bg-gray-50 border-2 {{ $errors->has('country') ? 'border-red-400 focus:ring-red-500 bg-red-50' : 'border-gray-100 focus:border-blue-500 focus:ring-blue-500' }} rounded-[1.5rem] font-bold text-gray-900 transition-all outline-none shadow-inner"
                            placeholder="e.g. United Kingdom, Australia">
                        @error('country') <p class="mt-2 text-[10px] font-black text-red-600 uppercase italic tracking-widest">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-10 pt-10 border-t border-gray-50">
                    <div class="space-y-3 group">
                        <label for="apply_date" class="block text-[10px] font-black text-gray-400 uppercase tracking-widest group-focus-within:text-blue-600 transition-colors italic">Submission Date <span class="text-red-500 font-black">*</span></label>
                        <input type="date" name="apply_date" id="apply_date" value="{{ old('apply_date', $foreignCertificate->apply_date) }}" required
                            class="w-full px-6 py-5 bg-gray-50 border-2 {{ $errors->has('apply_date') ? 'border-red-400 focus:ring-red-500 bg-red-50' : 'border-gray-100 focus:border-blue-500 focus:ring-blue-500' }} rounded-[1.25rem] font-bold text-gray-900 transition-all outline-none shadow-inner">
                        @error('apply_date') <p class="mt-2 text-[10px] font-black text-red-600 uppercase italic tracking-widest">{{ $message }}</p> @enderror
                    </div>
                    <div class="space-y-3 group">
                        <label for="issue_date" class="block text-[10px] font-black text-gray-400 uppercase tracking-widest group-focus-within:text-blue-600 transition-colors italic">Issuance Date (Optional)</label>
                        <input type="date" name="issue_date" id="issue_date" value="{{ old('issue_date', $foreignCertificate->issue_date) }}"
                            class="w-full px-6 py-5 bg-gray-50 border-2 border-gray-100 focus:border-blue-500 rounded-[1.25rem] font-bold text-gray-900 transition-all outline-none shadow-inner">
                        @error('issue_date') <p class="mt-2 text-[10px] font-black text-red-600 uppercase italic tracking-widest">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div class="bg-gray-50/50 p-10 rounded-[2.5rem] border-2 border-gray-100/50 grid grid-cols-1 md:grid-cols-2 gap-10">
                    <div class="flex items-center justify-between bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                        <div>
                            <h6 class="text-[10px] font-black text-gray-900 uppercase tracking-widest">Seal Protocol</h6>
                            <p class="text-[9px] font-bold text-gray-400 uppercase italic">Official Council Seal</p>
                        </div>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" name="certificate_sealed" value="1" {{ old('certificate_sealed', $foreignCertificate->certificate_sealed) ? 'checked' : '' }} class="sr-only peer">
                            <div class="w-14 h-7 bg-gray-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-6 after:w-6 after:transition-all peer-checked:bg-blue-600"></div>
                        </label>
                    </div>
                    <div class="flex items-center justify-between bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                        <div>
                            <h6 class="text-[10px] font-black text-gray-900 uppercase tracking-widest">Issuance Protocol</h6>
                            <p class="text-[9px] font-bold text-gray-400 uppercase italic">Physical Certificate Print</p>
                        </div>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" name="certificate_printed" value="1" {{ old('certificate_printed', $foreignCertificate->certificate_printed) ? 'checked' : '' }} class="sr-only peer">
                            <div class="w-14 h-7 bg-gray-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-6 after:w-6 after:transition-all peer-checked:bg-blue-600"></div>
                        </label>
                    </div>
                </div>

                <div class="flex items-center justify-between pt-12 mt-12 border-t-2 border-gray-50">
                    <a href="{{ route('foreign-certificates.index') }}" class="text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] hover:text-gray-900 transition-all border-b border-transparent hover:border-gray-900 pb-1 italic">Abort Modification</a>
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
