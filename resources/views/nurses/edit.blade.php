@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto py-12 px-4 sm:px-6 lg:px-8 tracking-tight">
    <div class="bg-white rounded-[2.5rem] shadow-2xl border border-gray-100 overflow-hidden text-gray-900">
        <div class="bg-indigo-600 px-10 py-8 relative overflow-hidden">
            <div class="absolute -top-24 -right-24 w-64 h-64 bg-white opacity-10 rounded-full blur-3xl"></div>
            <div class="absolute -bottom-24 -left-24 w-64 h-64 bg-indigo-400 opacity-20 rounded-full blur-3xl"></div>
            
            <div class="relative z-10 flex items-center justify-between">
                <div>
                    <h2 class="text-3xl font-black text-white flex items-center tracking-tighter uppercase">
                        <i class="bi bi-pencil-square mr-4 text-indigo-200"></i> Modify Profile
                    </h2>
                    <p class="text-indigo-100 font-bold italic text-xs mt-1 uppercase tracking-widest opacity-80">Nurse Management System - Practitioner Record Update</p>
                </div>
                <div class="bg-white/10 backdrop-blur-md rounded-2xl px-4 py-2 border border-white/20 flex items-center gap-3">
                    <span class="text-[10px] font-black text-white uppercase tracking-widest">Active NIC:</span>
                    <span class="text-sm font-black text-white bg-indigo-500/50 px-3 py-1 rounded-xl border border-indigo-300/30 shadow-inner">{{ $nurse->nic }}</span>
                </div>
            </div>
        </div>

        <div class="p-10 bg-white">
            <form action="{{ route('nurses.update', $nurse) }}" method="POST" class="space-y-8">
                @csrf
                @method('PUT')
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-x-10 gap-y-8">
                    <div class="space-y-2 group">
                        <label for="name" class="block text-[10px] font-black text-gray-400 uppercase tracking-widest group-focus-within:text-indigo-600 transition-colors">Practitioner Full Name <span class="text-red-500 font-black">*</span></label>
                        <div class="relative">
                            <input type="text" name="name" id="name" value="{{ old('name', $nurse->name) }}" required
                                class="w-full px-5 py-4 bg-gray-50 border-2 {{ $errors->has('name') ? 'border-red-400 focus:ring-red-500 bg-red-50' : 'border-gray-100 focus:border-indigo-500 focus:ring-indigo-500' }} rounded-2xl font-bold text-gray-900 transition-all outline-none focus:ring-4 focus:ring-opacity-20 shadow-inner"
                                placeholder="Edit canonical name...">
                            @error('name') <p class="mt-2 text-[10px] font-black text-red-600 uppercase italic tracking-widest">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <div class="space-y-2 group">
                        <label for="nic" class="block text-[10px] font-black text-gray-400 uppercase tracking-widest group-focus-within:text-indigo-600 transition-colors">National Identity Card <span class="text-red-500 font-black">*</span></label>
                        <div class="relative">
                            <input type="text" name="nic" id="nic" value="{{ old('nic', $nurse->nic) }}" required
                                class="w-full px-5 py-4 bg-gray-50 border-2 {{ $errors->has('nic') ? 'border-red-400 focus:ring-red-500 bg-red-50' : 'border-gray-100 focus:border-indigo-500 focus:ring-indigo-500' }} rounded-2xl font-bold text-gray-900 transition-all outline-none focus:ring-4 focus:ring-opacity-20 shadow-inner"
                                placeholder="Identity verification code...">
                            @error('nic') <p class="mt-2 text-[10px] font-black text-red-600 uppercase italic tracking-widest">{{ $message }}</p> @enderror
                        </div>
                    </div>
                </div>

                <div class="space-y-2 group">
                    <label for="address" class="block text-[10px] font-black text-gray-400 uppercase tracking-widest group-focus-within:text-indigo-600 transition-colors">Residential Official Address</label>
                    <textarea name="address" id="address" rows="3"
                        class="w-full px-5 py-4 bg-gray-50 border-2 {{ $errors->has('address') ? 'border-red-400 focus:ring-red-500 bg-red-50' : 'border-gray-100 focus:border-indigo-500 focus:ring-indigo-500' }} rounded-2xl font-bold text-gray-900 transition-all outline-none focus:ring-4 focus:ring-opacity-20 shadow-inner resize-none"
                        placeholder="Current residential records...">{{ old('address', $nurse->address) }}</textarea>
                    @error('address') <p class="mt-2 text-[10px] font-black text-red-600 uppercase italic tracking-widest">{{ $message }}</p> @enderror
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <div class="space-y-2 group">
                        <label for="phone" class="block text-[10px] font-black text-gray-400 uppercase tracking-widest group-focus-within:text-indigo-600 transition-colors">Primary Phone</label>
                        <input type="text" name="phone" id="phone" value="{{ old('phone', $nurse->phone) }}"
                            class="w-full px-5 py-4 bg-gray-50 border-2 {{ $errors->has('phone') ? 'border-red-400 focus:ring-red-500 bg-red-50' : 'border-gray-100 focus:border-indigo-500 focus:ring-indigo-500' }} rounded-2xl font-bold text-gray-900 transition-all outline-none focus:ring-4 focus:ring-opacity-20 shadow-inner"
                            placeholder="+94 ...">
                        @error('phone') <p class="mt-2 text-[10px] font-black text-red-600 uppercase italic tracking-widest">{{ $message }}</p> @enderror
                    </div>

                    <div class="space-y-2 group">
                        <label for="gender" class="block text-[10px] font-black text-gray-400 uppercase tracking-widest group-focus-within:text-indigo-600 transition-colors">Biological Gender</label>
                        <select name="gender" id="gender"
                            class="w-full px-5 py-4 bg-gray-50 border-2 {{ $errors->has('gender') ? 'border-red-400 focus:ring-red-500 bg-red-50' : 'border-gray-100 focus:border-indigo-500 focus:ring-indigo-500' }} rounded-2xl font-bold text-gray-900 transition-all outline-none focus:ring-4 focus:ring-opacity-20 shadow-inner appearance-none cursor-pointer">
                            <option value="">Select Protocol</option>
                            <option value="male" {{ old('gender', $nurse->gender) == 'male' ? 'selected' : '' }}>Male</option>
                            <option value="female" {{ old('gender', $nurse->gender) == 'female' ? 'selected' : '' }}>Female</option>
                            <option value="other" {{ old('gender', $nurse->gender) == 'other' ? 'selected' : '' }}>Other Identification</option>
                        </select>
                        @error('gender') <p class="mt-2 text-[10px] font-black text-red-600 uppercase italic tracking-widest">{{ $message }}</p> @enderror
                    </div>

                    <div class="space-y-2 group">
                        <label for="date_of_birth" class="block text-[10px] font-black text-gray-400 uppercase tracking-widest group-focus-within:text-indigo-600 transition-colors">Date of Birth</label>
                        <input type="date" name="date_of_birth" id="date_of_birth" value="{{ old('date_of_birth', $nurse->date_of_birth) }}"
                            class="w-full px-5 py-4 bg-gray-50 border-2 {{ $errors->has('date_of_birth') ? 'border-red-400 focus:ring-red-500 bg-red-50' : 'border-gray-100 focus:border-indigo-500 focus:ring-indigo-500' }} rounded-2xl font-bold text-gray-900 transition-all outline-none focus:ring-4 focus:ring-opacity-20 shadow-inner">
                        @error('date_of_birth') <p class="mt-2 text-[10px] font-black text-red-600 uppercase italic tracking-widest">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8 pt-4 border-t border-gray-50">
                    <div class="space-y-2 group">
                        <label for="school_or_university" class="block text-[10px] font-black text-gray-400 uppercase tracking-widest group-focus-within:text-indigo-600 transition-colors">Alma Mater / Institution</label>
                        <input type="text" name="school_or_university" id="school_or_university" value="{{ old('school_or_university', $nurse->school_or_university) }}"
                            class="w-full px-5 py-4 bg-gray-50 border-2 {{ $errors->has('school_or_university') ? 'border-red-400 focus:ring-red-500 bg-red-50' : 'border-gray-100 focus:border-indigo-500 focus:ring-indigo-500' }} rounded-2xl font-bold text-gray-900 transition-all outline-none focus:ring-4 focus:ring-opacity-20 shadow-inner"
                            placeholder="Educational Records ...">
                        @error('school_or_university') <p class="mt-2 text-[10px] font-black text-red-600 uppercase italic tracking-widest">{{ $message }}</p> @enderror
                    </div>

                    <div class="space-y-2 group">
                        <label for="batch" class="block text-[10px] font-black text-gray-400 uppercase tracking-widest group-focus-within:text-indigo-600 transition-colors">Training Batch</label>
                        <input type="text" name="batch" id="batch" value="{{ old('batch', $nurse->batch) }}"
                            class="w-full px-5 py-4 bg-gray-50 border-2 {{ $errors->has('batch') ? 'border-red-400 focus:ring-red-500 bg-red-50' : 'border-gray-100 focus:border-indigo-500 focus:ring-indigo-500' }} rounded-2xl font-bold text-gray-900 transition-all outline-none focus:ring-4 focus:ring-opacity-20 shadow-inner"
                            placeholder="Admission Code or Year...">
                        @error('batch') <p class="mt-2 text-[10px] font-black text-red-600 uppercase italic tracking-widest">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div class="flex items-center justify-between pt-10 mt-8 border-t-2 border-gray-50">
                    <a href="{{ route('nurses.index') }}" class="text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] hover:text-gray-900 transition-all border-b border-transparent hover:border-gray-900 pb-1">Cancel Modification</a>
                    <button type="submit" 
                        class="px-10 py-5 bg-indigo-600 text-white font-black text-xs uppercase tracking-[0.3em] rounded-[1.25rem] shadow-2xl shadow-indigo-200 hover:bg-indigo-700 hover:scale-[1.02] active:scale-[0.98] transition-all flex items-center gap-3">
                        Sync Changes <i class="bi bi-arrow-repeat text-xs"></i>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
