<!DOCTYPE html>
<html lang="en" class="h-full bg-gray-50">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Authorized Access - Sri Lanka Nursing Council</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;700;900&display=swap');
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="h-full tracking-tight bg-[radial-gradient(ellipse_at_top_right,_var(--tw-gradient-stops))] from-blue-50 via-gray-50 to-indigo-50">
    <div class="min-h-full flex flex-col justify-center py-12 sm:px-6 lg:px-8 relative overflow-hidden">
        <!-- Abstract Decorations -->
        <div class="absolute top-0 right-0 -mr-20 -mt-20 w-96 h-96 bg-blue-600 opacity-[0.03] rounded-full blur-3xl"></div>
        <div class="absolute bottom-0 left-0 -ml-20 -mb-20 w-96 h-96 bg-indigo-600 opacity-[0.03] rounded-full blur-3xl"></div>

        <div class="sm:mx-auto sm:w-full sm:max-w-md relative z-10 px-4">
            <div class="text-center group">
                <div class="inline-flex items-center justify-center w-24 h-24 bg-blue-600 rounded-[2.5rem] shadow-2xl shadow-blue-200 mb-8 transform group-hover:scale-110 group-hover:rotate-3 transition-all duration-500">
                    <i class="bi bi-hospital text-white text-5xl"></i>
                </div>
                <h2 class="text-4xl font-black text-gray-900 tracking-tighter uppercase leading-none">Nurse Registry</h2>
                <p class="mt-3 text-sm font-black text-blue-600 uppercase tracking-[0.3em] opacity-80 italic">Sri Lanka Nursing Council</p>
            </div>
        </div>

        <div class="mt-12 sm:mx-auto sm:w-full sm:max-w-[480px] relative z-10 px-4">
            <div class="bg-white/70 backdrop-blur-2xl py-12 px-10 shadow-[0_30px_100px_rgba(0,0,0,0.05)] rounded-[3rem] border border-white/50 relative overflow-hidden group">
                <div class="absolute inset-x-0 top-0 h-2 bg-gradient-to-r from-blue-600 via-indigo-600 to-blue-600 opacity-20"></div>
                
                <div class="mb-10 text-center">
                    <h3 class="text-xs font-black text-gray-400 uppercase tracking-[0.5em] italic">Authorized Access Protocol</h3>
                </div>

                @if ($errors->any())
                    <div class="mb-8 bg-red-50 border-l-4 border-red-500 p-5 rounded-2xl animate-in fade-in slide-in-from-top-4 duration-500">
                        <div class="flex items-start gap-4">
                            <i class="bi bi-exclamation-octagon-fill text-red-500 text-xl"></i>
                            <ul class="space-y-1">
                                @foreach ($errors->all() as $error)
                                    <li class="text-[10px] font-black text-red-900 uppercase tracking-tighter">{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                @endif

                <form method="POST" action="{{ route('login') }}" class="space-y-8">
                    @csrf
                    <div class="space-y-3 group/field">
                        <label for="email" class="block text-[10px] font-black text-gray-400 uppercase tracking-widest group-focus-within/field:text-blue-600 transition-colors italic ml-1">Archive Identity (Email)</label>
                        <div class="relative flex items-center">
                            <div class="absolute left-6 text-gray-300 group-focus-within/field:text-blue-600 transition-colors">
                                <i class="bi bi-envelope-at text-xl"></i>
                            </div>
                            <input id="email" name="email" type="email" value="{{ old('email') }}" required autofocus
                                class="block w-full pl-16 pr-6 py-5 bg-gray-50/50 border-2 border-gray-100 rounded-[1.5rem] font-black text-gray-900 placeholder-gray-300 focus:outline-none focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 transition-all text-lg tracking-tight">
                        </div>
                    </div>

                    <div class="space-y-3 group/field">
                        <label for="password" class="block text-[10px] font-black text-gray-400 uppercase tracking-widest group-focus-within/field:text-blue-600 transition-colors italic ml-1">Cryptographic Key (Password)</label>
                        <div class="relative flex items-center">
                            <div class="absolute left-6 text-gray-300 group-focus-within/field:text-blue-600 transition-colors">
                                <i class="bi bi-shield-lock text-xl"></i>
                            </div>
                            <input id="password" name="password" type="password" required
                                class="block w-full pl-16 pr-6 py-5 bg-gray-50/50 border-2 border-gray-100 rounded-[1.5rem] font-black text-gray-900 placeholder-gray-300 focus:outline-none focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 transition-all text-lg tracking-tight">
                        </div>
                    </div>

                    <div class="pt-4">
                        <button type="submit" 
                            class="w-full flex justify-center items-center gap-4 py-6 px-10 border border-transparent rounded-[1.5rem] shadow-[0_20px_50px_rgba(37,99,235,0.2)] text-xs font-black uppercase tracking-[0.4em] text-white bg-blue-600 hover:bg-blue-700 hover:scale-[1.02] active:scale-[0.98] transition-all duration-300 focus:outline-none focus:ring-4 focus:ring-blue-500/20">
                            Execute Authentication <i class="bi bi-arrow-right text-lg"></i>
                        </button>
                    </div>
                </form>

                <div class="mt-12 pt-8 border-t border-gray-50 text-center">
                    <p class="text-[9px] font-black text-gray-300 uppercase tracking-widest leading-loose max-w-[280px] mx-auto opacity-60">
                        This is a secure system archive. All unauthorized access attempts are logged and reported to the council governance.
                    </p>
                </div>
            </div>
            
            <p class="mt-10 text-center text-[10px] font-black text-gray-400 uppercase tracking-[0.3em] italic">
                &copy; {{ date('Y') }} Sri Lanka Nursing Council. v4.0.0-GOLD
            </p>
        </div>
    </div>
</body>
</html>
