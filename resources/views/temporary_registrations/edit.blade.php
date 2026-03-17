@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto py-12 px-4 sm:px-6 lg:px-8 tracking-tight">
    <div class="bg-white rounded-[2.5rem] shadow-2xl border border-gray-100 overflow-hidden text-gray-900">
        <div class="bg-blue-600 px-10 py-8 relative overflow-hidden text-white">
            <div class="absolute -top-24 -right-24 w-64 h-64 bg-white opacity-10 rounded-full blur-3xl"></div>
            <div class="absolute -bottom-24 -left-24 w-64 h-64 bg-blue-400 opacity-20 rounded-full blur-3xl"></div>
            
            <div class="relative z-10 flex flex-col sm:flex-row items-center justify-between gap-6">
                <div>
                    <h2 class="text-3xl font-black flex items-center tracking-tighter uppercase">
                        <i class="bi bi-pencil-square mr-4 text-blue-200"></i> Adjust Registration
                    </h2>
                    <p class="text-blue-100 font-bold italic text-xs mt-1 uppercase tracking-widest opacity-80">Refining temporary practitioner credentials</p>
                </div>
                <div class="bg-white/10 backdrop-blur-md rounded-2xl px-5 py-3 border border-white/20 flex items-center gap-4">
                    <span class="text-[10px] font-black text-white uppercase tracking-widest">Protocol Serial:</span>
                    <span class="text-sm font-black text-white bg-blue-500/50 px-3 py-1 rounded-xl border border-blue-300/30 shadow-inner tracking-widest">{{ $temporaryRegistration->temp_registration_no }}</span>
                </div>
            </div>
        </div>
        
        <div class="bg-gray-50 border-b border-gray-100 px-10 py-6 flex items-center justify-between">
            <div class="flex items-center gap-4">
                <div class="w-10 h-10 bg-indigo-100 rounded-xl flex items-center justify-center text-indigo-600">
                    <i class="bi bi-person-check-fill text-xl"></i>
                </div>
                <div>
                    <h4 class="text-sm font-black text-gray-900 uppercase tracking-tighter">{{ $temporaryRegistration->nurse->name }}</h4>
                    <span class="text-[10px] font-black text-gray-400 uppercase tracking-widest italic">NIC ARCHIVE: {{ $temporaryRegistration->nurse->nic }}</span>
                </div>
            </div>
            <span class="text-[10px] font-black text-gray-300 uppercase italic">CONTEXT LOCKED</span>
        </div>

        <div class="p-10 bg-white">
            <form action="{{ route('temporary-registrations.update', $temporaryRegistration) }}" method="POST" class="space-y-10">
                @csrf
                @method('PUT')
                
                <input type="hidden" name="nurse_id" value="{{ $temporaryRegistration->nurse_id }}">

                <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
                    <div class="space-y-3 group">
                        <label for="temp_registration_no" class="block text-[10px] font-black text-gray-400 uppercase tracking-widest group-focus-within:text-blue-600 transition-colors">Temporary Registration Serial <span class="text-red-500 font-black">*</span></label>
                        <input type="text" name="temp_registration_no" id="temp_registration_no" value="{{ old('temp_registration_no', $temporaryRegistration->temp_registration_no) }}" required
                            class="w-full px-6 py-5 bg-gray-50 border-2 {{ $errors->has('temp_registration_no') ? 'border-red-400 focus:ring-red-500 bg-red-50' : 'border-gray-100 focus:border-blue-500 focus:ring-blue-500' }} rounded-[1.5rem] font-black text-gray-900 transition-all outline-none focus:ring-4 focus:ring-opacity-20 shadow-inner"
                            placeholder="Canonical serial identifier...">
                        @error('temp_registration_no') <p class="mt-2 text-[10px] font-black text-red-600 uppercase italic tracking-widest">{{ $message }}</p> @enderror
                    </div>
                    <div class="space-y-3 group">
                        <label for="temp_registration_date" class="block text-[10px] font-black text-gray-400 uppercase tracking-widest group-focus-within:text-blue-600 transition-colors">Authorization Date <span class="text-red-500 font-black">*</span></label>
                        <input type="date" name="temp_registration_date" id="temp_registration_date" value="{{ old('temp_registration_date', $temporaryRegistration->temp_registration_date) }}" required
                            class="w-full px-6 py-5 bg-gray-50 border-2 {{ $errors->has('temp_registration_date') ? 'border-red-400 focus:ring-red-500 bg-red-50' : 'border-gray-100 focus:border-blue-500 focus:ring-blue-500' }} rounded-[1.5rem] font-bold text-gray-900 transition-all outline-none focus:ring-4 focus:ring-opacity-20 shadow-inner">
                        @error('temp_registration_date') <p class="mt-2 text-[10px] font-black text-red-600 uppercase italic tracking-widest">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div class="space-y-3 group">
                    <label for="address" class="block text-[10px] font-black text-gray-400 uppercase tracking-widest group-focus-within:text-blue-600 transition-colors">Assigned Clinical Address</label>
                    <textarea name="address" id="address" rows="3"
                        class="w-full px-6 py-5 bg-gray-50 border-2 {{ $errors->has('address') ? 'border-red-400 focus:ring-red-500 bg-red-50' : 'border-gray-100 focus:border-blue-500 focus:ring-blue-500' }} rounded-[1.5rem] font-bold text-gray-900 transition-all outline-none focus:ring-4 focus:ring-opacity-20 shadow-inner resize-none"
                        placeholder="Update practitioner location records...">{{ old('address', $temporaryRegistration->address) }}</textarea>
                    @error('address') <p class="mt-2 text-[10px] font-black text-red-600 uppercase italic tracking-widest">{{ $message }}</p> @enderror
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
                    <div class="space-y-3 group">
                        <label for="batch" class="block text-[10px] font-black text-gray-400 uppercase tracking-widest group-focus-within:text-blue-600 transition-colors">Academy Batch</label>
                        <input type="text" name="batch" id="batch" value="{{ old('batch', $temporaryRegistration->batch) }}"
                            class="w-full px-6 py-5 bg-gray-50 border-2 {{ $errors->has('batch') ? 'border-red-400 focus:ring-red-500 bg-red-50' : 'border-gray-100 focus:border-blue-500 focus:ring-blue-500' }} rounded-[1.25rem] font-bold text-gray-900 transition-all outline-none focus:ring-4 focus:ring-opacity-20 shadow-inner">
                        @error('batch') <p class="mt-2 text-[10px] font-black text-red-600 uppercase italic tracking-widest">{{ $message }}</p> @enderror
                    </div>
                    <div class="space-y-3 group">
                        <label for="school_university" class="block text-[10px] font-black text-gray-400 uppercase tracking-widest group-focus-within:text-blue-600 transition-colors">Scientific Institution</label>
                        <input type="text" name="school_university" id="school_university" value="{{ old('school_university', $temporaryRegistration->school_university) }}"
                            class="w-full px-6 py-5 bg-gray-50 border-2 {{ $errors->has('school_university') ? 'border-red-400 focus:ring-red-500 bg-red-50' : 'border-gray-100 focus:border-blue-500 focus:ring-blue-500' }} rounded-[1.25rem] font-bold text-gray-900 transition-all outline-none focus:ring-4 focus:ring-opacity-20 shadow-inner">
                        @error('school_university') <p class="mt-2 text-[10px] font-black text-red-600 uppercase italic tracking-widest">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
                    <div class="space-y-3 group">
                        <label for="birth_date" class="block text-[10px] font-black text-gray-400 uppercase tracking-widest group-focus-within:text-blue-600 transition-colors">Canonical Birth Date</label>
                        <input type="date" name="birth_date" id="birth_date" value="{{ old('birth_date', $temporaryRegistration->birth_date) }}"
                            class="w-full px-6 py-5 bg-gray-50 border-2 {{ $errors->has('birth_date') ? 'border-red-400 focus:ring-red-500 bg-red-50' : 'border-gray-100 focus:border-blue-500 focus:ring-blue-500' }} rounded-[1.25rem] font-bold text-gray-900 transition-all outline-none focus:ring-4 focus:ring-opacity-20 shadow-inner">
                        @error('birth_date') <p class="mt-2 text-[10px] font-black text-red-600 uppercase italic tracking-widest">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div class="flex items-center justify-between pt-12 mt-12 border-t-2 border-gray-50">
                    <a href="{{ route('temporary-registrations.index') }}" class="text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] hover:text-gray-900 transition-all border-b border-transparent hover:border-gray-900 pb-1 italic">Abort Modification</a>
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
