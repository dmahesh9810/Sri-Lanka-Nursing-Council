@extends('layouts.app')

@section('content')

{{-- Page Header --}}
<div class="flex flex-col md:flex-row md:items-center justify-between mb-8 gap-4">
    <div>
        <h2 class="text-3xl font-extrabold text-gray-900 flex items-center">
            <i class="bi bi-speedometer2 text-blue-600 mr-3"></i> Admin Dashboard
        </h2>
        <p class="text-gray-500 mt-1 font-medium italic">Sri Lanka Nursing Council &middot; System Intelligence Hub</p>
    </div>
    <div class="bg-white px-4 py-2 rounded-lg shadow-sm border border-gray-100 flex items-center text-sm font-semibold text-gray-600">
        <i class="bi bi-clock text-blue-500 mr-2"></i> {{ now()->format('D, d M Y | H:i A') }}
    </div>
</div>

{{-- Stats Grid --}}
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6 mb-8">

    {{-- Total Nurses --}}
    @if(auth()->user()->hasRole('Admin'))
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 hover:shadow-md transition-shadow overflow-hidden group">
        <div class="p-6 flex items-center gap-4">
            <div class="w-16 h-16 rounded-2xl bg-blue-50 flex items-center justify-center text-blue-600 border border-blue-100 group-hover:scale-110 transition-transform">
                <i class="bi bi-people-fill text-2xl"></i>
            </div>
            <div>
                <p class="text-xs font-bold text-gray-400 uppercase tracking-widest">Total Nurses</p>
                <h3 class="text-3xl font-black text-gray-900">{{ number_format($stats['total_nurses']) }}</h3>
            </div>
        </div>
        <div class="px-6 py-3 bg-gray-50 border-t border-gray-50">
            <a href="{{ route('nurses.index') }}" class="text-sm font-bold text-blue-600 hover:text-blue-800 flex items-center">
                Explore Register <i class="bi bi-arrow-right ml-1"></i>
            </a>
        </div>
    </div>
    @endif

    {{-- Temporary Registrations --}}
    @if(auth()->user()->hasRole('Admin', 'User1', 'User2'))
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 hover:shadow-md transition-shadow overflow-hidden group">
        <div class="p-6 flex items-center gap-4">
            <div class="w-16 h-16 rounded-2xl bg-cyan-50 flex items-center justify-center text-cyan-600 border border-cyan-100 group-hover:scale-110 transition-transform">
                <i class="bi bi-hourglass-split text-2xl"></i>
            </div>
            <div>
                <p class="text-xs font-bold text-gray-400 uppercase tracking-widest text-nowrap">Temp. Registrations</p>
                <h3 class="text-3xl font-black text-gray-900">{{ number_format($stats['total_temporary']) }}</h3>
            </div>
        </div>
        <div class="px-6 py-3 bg-gray-50 border-t border-gray-50">
            <a href="{{ route('temporary-registrations.index') }}" class="text-sm font-bold text-cyan-600 hover:text-cyan-800 flex items-center">
                Manage Temp <i class="bi bi-arrow-right ml-1"></i>
            </a>
        </div>
    </div>
    @endif

    {{-- Permanent Registrations --}}
    @if(auth()->user()->hasRole('Admin', 'User2', 'User3', 'User4', 'User5'))
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 hover:shadow-md transition-shadow overflow-hidden group">
        <div class="p-6 flex items-center gap-4">
            <div class="w-16 h-16 rounded-2xl bg-emerald-50 flex items-center justify-center text-emerald-600 border border-emerald-100 group-hover:scale-110 transition-transform">
                <i class="bi bi-patch-check-fill text-2xl"></i>
            </div>
            <div>
                <p class="text-xs font-bold text-gray-400 uppercase tracking-widest text-nowrap">Perm. Registrations</p>
                <h3 class="text-3xl font-black text-gray-900">{{ number_format($stats['total_permanent']) }}</h3>
            </div>
        </div>
        <div class="px-6 py-3 bg-gray-50 border-t border-gray-50">
            <a href="{{ route('permanent-registrations.index') }}" class="text-sm font-bold text-emerald-600 hover:text-emerald-800 flex items-center">
                Manage Perm <i class="bi bi-arrow-right ml-1"></i>
            </a>
        </div>
    </div>
    @endif

    {{-- Additional Qualifications --}}
    @if(auth()->user()->hasRole('Admin', 'User4'))
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 hover:shadow-md transition-shadow overflow-hidden group">
        <div class="p-6 flex items-center gap-4">
            <div class="w-16 h-16 rounded-2xl bg-purple-50 flex items-center justify-center text-purple-600 border border-purple-100 group-hover:scale-110 transition-transform">
                <i class="bi bi-award-fill text-2xl"></i>
            </div>
            <div>
                <p class="text-xs font-bold text-gray-400 uppercase tracking-widest text-nowrap">Qualifications</p>
                <h3 class="text-3xl font-black text-gray-900">{{ number_format($stats['total_qualifications']) }}</h3>
            </div>
        </div>
        <div class="px-6 py-3 bg-gray-50 border-t border-gray-50">
            <a href="{{ route('additional-qualifications.index') }}" class="text-sm font-bold text-purple-600 hover:text-purple-800 flex items-center">
                Review Assets <i class="bi bi-arrow-right ml-1"></i>
            </a>
        </div>
    </div>
    @endif

    {{-- Foreign Certificate Requests --}}
    @if(auth()->user()->hasRole('Admin', 'User5'))
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 hover:shadow-md transition-shadow overflow-hidden group">
        <div class="p-6 flex items-center gap-4">
            <div class="w-16 h-16 rounded-2xl bg-orange-50 flex items-center justify-center text-orange-600 border border-orange-100 group-hover:scale-110 transition-transform">
                <i class="bi bi-globe-americas text-2xl"></i>
            </div>
            <div>
                <p class="text-xs font-bold text-gray-400 uppercase tracking-widest text-nowrap">Foreign Certs</p>
                <h3 class="text-3xl font-black text-gray-900">{{ number_format($stats['total_foreign_certificates']) }}</h3>
            </div>
        </div>
        <div class="px-6 py-3 bg-gray-50 border-t border-gray-50">
            <a href="{{ route('foreign-certificates.index') }}" class="text-sm font-bold text-orange-600 hover:text-orange-800 flex items-center">
                Global Gateway <i class="bi bi-arrow-right ml-1"></i>
            </a>
        </div>
    </div>
    @endif

    {{-- Certificates Printed (Foreign) --}}
    @if(auth()->user()->hasRole('Admin', 'User5'))
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 hover:shadow-md transition-shadow overflow-hidden group">
        <div class="p-6 flex items-center gap-4">
            <div class="w-16 h-16 rounded-2xl bg-teal-50 flex items-center justify-center text-teal-600 border border-teal-100 group-hover:scale-110 transition-transform">
                <i class="bi bi-printer-fill text-2xl"></i>
            </div>
            <div>
                <p class="text-xs font-bold text-gray-400 uppercase tracking-widest text-nowrap">Certs Printed</p>
                <h3 class="text-3xl font-black text-gray-900">{{ number_format($stats['total_printed']) }}</h3>
            </div>
        </div>
        <div class="px-6 py-3 bg-gray-50 border-t border-gray-50">
             <span class="text-xs text-gray-500 italic">Total verified printouts</span>
        </div>
    </div>
    @endif

    {{-- Perm Certificates Printed --}}
    @if(auth()->user()->hasRole('Admin', 'User3'))
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 hover:shadow-md transition-shadow overflow-hidden group">
        <div class="p-6 flex items-center gap-4">
            <div class="w-16 h-16 rounded-2xl bg-pink-50 flex items-center justify-center text-pink-600 border border-pink-100 group-hover:scale-110 transition-transform">
                <i class="bi bi-file-earmark-person-fill text-2xl"></i>
            </div>
            <div>
                <p class="text-xs font-bold text-gray-400 uppercase tracking-widest text-nowrap">Perm Certs Issued</p>
                <h3 class="text-3xl font-black text-gray-900">{{ number_format($stats['total_perm_certificates_printed']) }}</h3>
            </div>
        </div>
        <div class="px-6 py-3 bg-gray-50 border-t border-gray-50">
            <a href="{{ route('permanent-certificates.index') }}" class="text-sm font-bold text-pink-600 hover:text-pink-800 flex items-center">
                Issue Queue <i class="bi bi-arrow-right ml-1"></i>
            </a>
        </div>
    </div>
    @endif

    {{-- Total Reports Generated --}}
    @if(auth()->user()->hasRole('Admin', 'User1', 'User2', 'User3', 'User4', 'User5'))
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 hover:shadow-md transition-shadow overflow-hidden group">
        <div class="p-6 flex items-center gap-4">
            <div class="w-16 h-16 rounded-2xl bg-rose-50 flex items-center justify-center text-rose-600 border border-rose-100 group-hover:scale-110 transition-transform">
                <i class="bi bi-file-earmark-pdf-fill text-2xl"></i>
            </div>
            <div>
                <p class="text-xs font-bold text-gray-400 uppercase tracking-widest text-nowrap">Reports Built</p>
                <h3 class="text-3xl font-black text-gray-900">{{ number_format($stats['total_reports_generated']) }}</h3>
            </div>
        </div>
        <div class="px-6 py-3 bg-gray-50 border-t border-gray-50">
            <a href="{{ route('reports.index') }}" class="text-sm font-bold text-rose-600 hover:text-rose-800 flex items-center">
                Data Studio <i class="bi bi-arrow-right ml-1"></i>
            </a>
        </div>
    </div>
    @endif

</div>

{{-- Charts Section --}}
<div class="grid grid-cols-1 xl:grid-cols-2 gap-8 mb-8">
    {{-- Chart 1: Monthly Temp Registrations --}}
    @if(auth()->user()->hasRole('Admin', 'User1', 'User2'))
    <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
        <div class="flex items-center justify-between mb-6">
            <h6 class="text-sm font-bold text-gray-700 uppercase tracking-wider flex items-center">
                <i class="bi bi-bar-chart-fill text-cyan-500 mr-2"></i> Monthly Temp. Registrations
            </h6>
            <span class="text-xs text-gray-400 font-medium italic">Past 12 Months</span>
        </div>
        <div class="h-[300px]">
            <canvas id="tempChart"></canvas>
        </div>
    </div>
    @endif

    {{-- Chart 2: Monthly Perm Registrations --}}
    @if(auth()->user()->hasRole('Admin', 'User2', 'User3', 'User4', 'User5'))
    <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
        <div class="flex items-center justify-between mb-6">
            <h6 class="text-sm font-bold text-gray-700 uppercase tracking-wider flex items-center">
                <i class="bi bi-graph-up-arrow text-emerald-500 mr-2"></i> Monthly Perm. Registrations
            </h6>
            <span class="text-xs text-gray-400 font-medium italic">Growth Trend</span>
        </div>
        <div class="h-[300px]">
            <canvas id="permChart"></canvas>
        </div>
    </div>
    @endif

    {{-- Chart 3: Foreign Certs by Country --}}
    @if(auth()->user()->hasRole('Admin', 'User5'))
    <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
        <div class="flex items-center justify-between mb-6">
            <h6 class="text-sm font-bold text-gray-700 uppercase tracking-wider flex items-center">
                <i class="bi bi-pie-chart-fill text-orange-500 mr-2"></i> Global Distribution
            </h6>
            <span class="text-xs text-gray-400 font-medium italic">By Country</span>
        </div>
        <div class="h-[350px] flex items-center justify-center">
            <canvas id="countryChart"></canvas>
        </div>
    </div>
    @endif

    {{-- Chart 4: Certs Printed vs Pending --}}
    @if(auth()->user()->hasRole('Admin', 'User5'))
    <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
        <div class="flex items-center justify-between mb-6">
            <h6 class="text-sm font-bold text-gray-700 uppercase tracking-wider flex items-center">
                <i class="bi bi-printer-fill text-blue-500 mr-2"></i> Operational Status
            </h6>
            <span class="text-xs text-gray-400 font-medium italic">Issue Progress</span>
        </div>
        <div class="h-[350px] flex items-center justify-center">
            <canvas id="certStatusChart"></canvas>
        </div>
    </div>
    @endif
</div>

{{-- Recent Activity --}}
<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    <div class="lg:col-span-2">
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-50 bg-gray-50/50 flex items-center justify-between">
                <h6 class="text-sm font-bold text-gray-700 uppercase tracking-wider flex items-center">
                    <i class="bi bi-clock-history text-blue-500 mr-2"></i> Audit Log
                </h6>
                <span class="px-3 py-1 bg-blue-100 text-blue-700 text-[10px] font-black uppercase rounded-full tracking-tighter">Live Activity</span>
            </div>
            <div class="divide-y divide-gray-50">
                @forelse($recentActivities as $activity)
                    <div class="px-6 py-5 hover:bg-gray-50 transition-colors flex items-start gap-4">
                        <div class="mt-1 w-10 h-10 rounded-xl bg-gray-100 flex items-center justify-center text-gray-500 border border-gray-200 shrink-0">
                             <i class="bi {{ str_contains(strtolower($activity->action), 'create') ? 'bi-plus-circle-fill text-emerald-500' : 'bi-lightning-fill text-blue-500' }}"></i>
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="flex items-center justify-between mb-1">
                                <h6 class="text-sm font-bold text-gray-900 truncate">{{ $activity->action }}</h6>
                                <span class="text-[11px] font-semibold text-gray-400 whitespace-nowrap"><i class="bi bi-clock mr-1"></i>{{ $activity->created_at->diffForHumans() }}</span>
                            </div>
                            <p class="text-xs text-gray-500 line-clamp-2 italic font-medium">"{{ $activity->description }}"</p>
                            @if($activity->user)
                                <div class="mt-3 flex items-center gap-2">
                                    <div class="w-5 h-5 rounded-full bg-blue-600 flex items-center justify-center text-[10px] text-white font-bold">
                                        {{ substr($activity->user->name, 0, 1) }}
                                    </div>
                                    <span class="text-[11px] font-bold text-blue-600 capitalize">{{ $activity->user->name }}</span>
                                </div>
                            @endif
                        </div>
                    </div>
                @empty
                    <div class="px-6 py-12 text-center text-gray-400">
                        <i class="bi bi-inbox text-4xl block mb-4 text-gray-200"></i>
                        <span class="text-sm font-medium">Digital silence. No recent records found.</span>
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    {{-- Quick Navigation --}}
    @if(auth()->user()->hasRole('Admin', 'User1', 'User2', 'User3', 'User4', 'User5'))
    <div class="space-y-8">
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-50 bg-gray-50/50">
                <h6 class="text-sm font-bold text-gray-700 uppercase tracking-wider flex items-center">
                    <i class="bi bi-lightning-charge text-orange-500 mr-2"></i> Fast Action Bar
                </h6>
            </div>
            <div class="p-6 space-y-3">
                @if(auth()->user()->hasRole('Admin'))
                <a href="{{ route('nurses.create') }}" class="flex items-center justify-between p-3 rounded-xl border border-blue-100 bg-blue-50/30 text-blue-700 hover:bg-blue-50 transition-all font-bold text-xs">
                    <span>New Nurse Profile</span>
                    <i class="bi bi-plus-circle-fill"></i>
                </a>
                @endif
                
                @if(auth()->user()->hasRole('Admin', 'User1', 'User2'))
                <a href="{{ route('temporary-registrations.create') }}" class="flex items-center justify-between p-3 rounded-xl border border-cyan-100 bg-cyan-50/30 text-cyan-700 hover:bg-cyan-50 transition-all font-bold text-xs">
                    <span>Temp Registration</span>
                    <i class="bi bi-plus-circle-fill"></i>
                </a>
                @endif
                
                @if(auth()->user()->hasRole('Admin', 'User2', 'User3', 'User4', 'User5'))
                <a href="{{ route('permanent-registrations.create') }}" class="flex items-center justify-between p-3 rounded-xl border border-emerald-100 bg-emerald-50/30 text-emerald-700 hover:bg-emerald-50 transition-all font-bold text-xs">
                    <span>Perm Registration</span>
                    <i class="bi bi-plus-circle-fill"></i>
                </a>
                @endif
                
                @if(auth()->user()->hasRole('Admin', 'User4'))
                <a href="{{ route('additional-qualifications.create') }}" class="flex items-center justify-between p-3 rounded-xl border border-purple-100 bg-purple-50/30 text-purple-700 hover:bg-purple-50 transition-all font-bold text-xs">
                    <span>New Qualification</span>
                    <i class="bi bi-plus-circle-fill"></i>
                </a>
                @endif
                
                @if(auth()->user()->hasRole('Admin', 'User5'))
                <a href="{{ route('foreign-certificates.create') }}" class="flex items-center justify-between p-3 rounded-xl border border-orange-100 bg-orange-50/30 text-orange-700 hover:bg-orange-50 transition-all font-bold text-xs">
                    <span>Global Request</span>
                    <i class="bi bi-plus-circle-fill"></i>
                </a>
                @endif
            </div>
        </div>
    </div>
    @endif
</div>

{{-- Chart.js Scripts --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Shared styling
    Chart.defaults.font.family = 'Inter, -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif';
    Chart.defaults.font.size = 11;
    Chart.defaults.color = '#94a3b8';

    // Chart 1: Temp Registrations (Bar)
    var ctxTemp = document.getElementById('tempChart').getContext('2d');
    new Chart(ctxTemp, {
        type: 'bar',
        data: {
            labels: {!! json_encode($charts['temp_labels'] ?? []) !!},
            datasets: [{
                label: 'Temp Registrations',
                data: {!! json_encode($charts['temp_data'] ?? []) !!},
                backgroundColor: '#06b6d4',
                hoverBackgroundColor: '#0891b2',
                borderRadius: 8,
                maxBarThickness: 30
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: { 
                y: { 
                    beginAtZero: true, 
                    grid: { color: '#f1f5f9' },
                    ticks: { stepSize: 1, color: '#64748b' } 
                },
                x: { grid: { display: false }, ticks: { color: '#64748b' } }
            },
            plugins: { legend: { display: false } }
        }
    });

    // Chart 2: Perm Registrations (Line)
    var ctxPerm = document.getElementById('permChart').getContext('2d');
    var gradientPerm = ctxPerm.createLinearGradient(0, 0, 0, 300);
    gradientPerm.addColorStop(0, 'rgba(16, 185, 129, 0.2)');
    gradientPerm.addColorStop(1, 'rgba(16, 185, 129, 0)');

    new Chart(ctxPerm, {
        type: 'line',
        data: {
            labels: {!! json_encode($charts['perm_labels'] ?? []) !!},
            datasets: [{
                label: 'Perm Registrations',
                data: {!! json_encode($charts['perm_data'] ?? []) !!},
                backgroundColor: gradientPerm,
                borderColor: '#10b981',
                borderWidth: 3,
                tension: 0.4,
                fill: true,
                pointBackgroundColor: '#fff',
                pointBorderColor: '#10b981',
                pointBorderWidth: 2,
                pointRadius: 4,
                pointHoverRadius: 6
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: { 
                y: { 
                    beginAtZero: true, 
                    grid: { color: '#f1f5f9' },
                    ticks: { stepSize: 1, color: '#64748b' } 
                },
                x: { grid: { display: false }, ticks: { color: '#64748b' } }
            },
            plugins: { legend: { display: false } }
        }
    });

    // Chart 3: Foreign Certs by Country (Doughnut)
    var ctxCountry = document.getElementById('countryChart').getContext('2d');
    new Chart(ctxCountry, {
        type: 'doughnut',
        data: {
            labels: {!! json_encode($charts['country_labels'] ?? []) !!},
            datasets: [{
                data: {!! json_encode($charts['country_data'] ?? []) !!},
                backgroundColor: [
                    '#3b82f6', '#8b5cf6', '#a855f7', '#ec4899', '#ef4444',
                    '#f97316', '#eab308', '#10b981', '#14b8a6', '#06b6d4'
                ],
                borderWidth: 0,
                cutout: '75%'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { 
                    position: 'bottom',
                    labels: { boxWidth: 12, padding: 20, usePointStyle: true }
                }
            }
        }
    });

    // Chart 4: Certs Status (Pie)
    var ctxStatus = document.getElementById('certStatusChart').getContext('2d');
    new Chart(ctxStatus, {
        type: 'pie',
        data: {
            labels: {!! json_encode($charts['cert_status_labels'] ?? []) !!},
            datasets: [{
                data: {!! json_encode($charts['cert_status_data'] ?? []) !!},
                backgroundColor: ['#14b8a6', '#94a3b8'],
                borderWidth: 0
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { 
                    position: 'bottom',
                    labels: { boxWidth: 12, padding: 20, usePointStyle: true }
                }
            }
        }
    });
});
</script>

@endsection
