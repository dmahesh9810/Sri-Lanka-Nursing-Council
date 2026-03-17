@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto py-12 px-4 sm:px-6 lg:px-8 tracking-tight text-gray-900">
    <div class="bg-white rounded-[3rem] shadow-2xl border border-gray-100 overflow-hidden">
        <div class="bg-blue-600 px-10 py-10 relative overflow-hidden text-white">
            <div class="absolute -top-24 -right-24 w-80 h-80 bg-white opacity-10 rounded-full blur-3xl"></div>
            <div class="absolute -bottom-24 -left-24 w-80 h-80 bg-blue-400 opacity-20 rounded-full blur-3xl"></div>
            
            <div class="relative z-10 flex flex-col items-center text-center">
                <div class="w-20 h-20 bg-white/10 backdrop-blur-md rounded-[2rem] border border-white/20 flex items-center justify-center text-white mb-6 shadow-xl">
                    <i class="bi bi-file-earmark-bar-graph text-4xl"></i>
                </div>
                <h2 class="text-4xl font-black tracking-tighter uppercase leading-none mb-2">Registry Intelligence</h2>
                <p class="text-blue-100 font-bold italic text-xs uppercase tracking-[0.4em] opacity-80">Sri Lanka Nursing Council Official Analytics Portal</p>
            </div>
        </div>
        
        <div class="p-12 bg-white">
            <div class="mb-12 text-center">
                <h3 class="text-[10px] font-black text-gray-400 uppercase tracking-[0.6em] italic">Report Generation Engine</h3>
            </div>

            <form action="{{ route('reports.generate') }}" method="POST" target="_blank" class="space-y-12">
                @csrf
                
                <div class="space-y-3 group">
                    <label for="module" class="block text-[10px] font-black text-gray-400 uppercase tracking-widest group-focus-within:text-blue-600 transition-colors italic">Dataset Source Domain</label>
                    <div class="relative flex items-center">
                        <select id="module" name="module" required
                            class="w-full pl-6 pr-12 py-5 bg-gray-50 border-2 border-gray-100 rounded-[1.5rem] font-black text-gray-900 focus:outline-none focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 transition-all text-lg appearance-none cursor-pointer shadow-inner">
                            <option value="">-- Choose Module Reference --</option>
                            <option value="temporary">Temporary Registrations Archive</option>
                            <option value="permanent">Permanent Registrations Master</option>
                            <option value="qualifications">Additional Qualifications Ledger</option>
                            <option value="foreign">Foreign Distribution Certificates</option>
                        </select>
                        <i class="bi bi-chevron-down absolute right-6 text-gray-400 pointer-events-none"></i>
                    </div>
                </div>

                <div class="space-y-4">
                    <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest italic">Temporal Granularity</label>
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
                        <label class="relative cursor-pointer group flex">
                            <input type="radio" name="period" value="daily" checked class="peer sr-only">
                            <div class="w-full flex items-center justify-between p-6 bg-gray-50 border-2 border-gray-100 rounded-3xl peer-checked:border-blue-600 peer-checked:bg-blue-50/50 peer-checked:ring-4 peer-checked:ring-blue-500/5 transition-all group-hover:bg-gray-100">
                                <span class="text-[10px] font-black uppercase tracking-widest text-gray-700 peer-checked:text-blue-600">Daily Delta</span>
                                <i class="bi bi-calendar-event text-gray-300 peer-checked:text-blue-600 text-xl"></i>
                            </div>
                        </label>
                        <label class="relative cursor-pointer group flex">
                            <input type="radio" name="period" value="monthly" class="peer sr-only">
                            <div class="w-full flex items-center justify-between p-6 bg-gray-50 border-2 border-gray-100 rounded-3xl peer-checked:border-blue-600 peer-checked:bg-blue-50/50 peer-checked:ring-4 peer-checked:ring-blue-500/5 transition-all group-hover:bg-gray-100">
                                <span class="text-[10px] font-black uppercase tracking-widest text-gray-700 peer-checked:text-blue-600">Monthly Cycle</span>
                                <i class="bi bi-calendar-range text-gray-300 peer-checked:text-blue-600 text-xl"></i>
                            </div>
                        </label>
                        <label class="relative cursor-pointer group flex">
                            <input type="radio" name="period" value="yearly" class="peer sr-only">
                            <div class="w-full flex items-center justify-between p-6 bg-gray-50 border-2 border-gray-100 rounded-3xl peer-checked:border-blue-600 peer-checked:bg-blue-50/50 peer-checked:ring-4 peer-checked:ring-blue-500/5 transition-all group-hover:bg-gray-100">
                                <span class="text-[10px] font-black uppercase tracking-widest text-gray-700 peer-checked:text-blue-600">Annual Audit</span>
                                <i class="bi bi-calendar-check text-gray-300 peer-checked:text-blue-600 text-xl"></i>
                            </div>
                        </label>
                    </div>
                </div>

                <div class="space-y-3 group">
                    <label for="report_date" class="block text-[10px] font-black text-gray-400 uppercase tracking-widest group-focus-within:text-blue-600 transition-colors italic">Reference Epoch (Date)</label>
                    <div class="relative flex items-center">
                        <input type="date" id="report_date" name="report_date" value="{{ date('Y-m-d') }}" required
                            class="block w-full px-6 py-5 bg-gray-50 border-2 border-gray-100 rounded-[1.5rem] font-bold text-gray-900 focus:outline-none focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 transition-all shadow-inner">
                    </div>
                    <div class="p-5 bg-amber-50 rounded-2xl border border-amber-100 flex items-start gap-4 mt-4">
                        <i class="bi bi-info-circle-fill text-amber-500 mt-1"></i>
                        <p class="text-[9px] font-black text-amber-800 uppercase leading-relaxed tracking-tight italic">
                            System Note: For Monthly or Annual iterations, the engine will extract data for the entire cycle containing the specified epoch.
                        </p>
                    </div>
                </div>

                <div class="pt-8 flex flex-col items-center">
                    <button type="submit" 
                        class="w-full flex justify-center items-center gap-6 py-8 px-12 border border-transparent rounded-[2rem] shadow-[0_20px_50px_rgba(37,99,235,0.3)] text-xs font-black uppercase tracking-[0.5em] text-white bg-blue-600 hover:bg-blue-700 hover:scale-[1.02] active:scale-[0.98] transition-all duration-300 focus:outline-none focus:ring-4 focus:ring-blue-500/20">
                        <i class="bi bi-file-earmark-pdf-fill text-2xl"></i> BUILD PDF PROTOCOL
                    </button>
                    <p class="mt-6 text-[9px] font-black text-gray-300 uppercase tracking-widest italic opacity-60">Verified Cryptographic PDF Signature will be applied</p>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- High-Fidelity Loading Overlay -->
<div id="loadingOverlay" class="hidden fixed inset-0 bg-white/95 backdrop-blur-2xl z-50 flex flex-col items-center justify-center transition-all duration-500">
    <div class="relative w-32 h-32 mb-12">
        <div class="absolute inset-0 border-[12px] border-gray-100 rounded-[2.5rem]"></div>
        <div class="absolute inset-0 border-[12px] border-blue-600 rounded-[2.5rem] border-t-transparent animate-spin shadow-2xl"></div>
        <div class="absolute inset-0 flex items-center justify-center text-blue-600 animate-pulse">
            <i class="bi bi-cpu text-4xl"></i>
        </div>
    </div>
    <div class="text-4xl font-black text-gray-900 mb-4 tracking-tighter uppercase">Compiling Registry</div>
    <div class="flex items-center gap-3">
        <div class="flex gap-1">
            <div class="w-1.5 h-1.5 bg-blue-600 rounded-full animate-bounce" style="animation-delay: 0.1s"></div>
            <div class="w-1.5 h-1.5 bg-blue-600 rounded-full animate-bounce" style="animation-delay: 0.2s"></div>
            <div class="w-1.5 h-1.5 bg-blue-600 rounded-full animate-bounce" style="animation-delay: 0.3s"></div>
        </div>
        <div class="text-[10px] font-black text-gray-400 uppercase tracking-[0.4em] italic">Synthesizing Database Records</div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.querySelector('form');
        const overlay = document.getElementById('loadingOverlay');

        if (form) {
            form.addEventListener('submit', function() {
                overlay.classList.remove('hidden');
                overlay.classList.add('flex');
                
                // Orchestrate removal after reasonable synthesis time
                setTimeout(() => {
                    overlay.classList.add('opacity-0');
                    setTimeout(() => {
                        overlay.classList.add('hidden');
                        overlay.classList.remove('flex', 'opacity-0');
                    }, 500);
                }, 4500);
            });
        }
    });
</script>
@endsection
