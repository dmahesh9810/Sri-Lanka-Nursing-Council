@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 gap-4">
        <div>
            <h2 class="text-3xl font-black text-gray-900 flex items-center tracking-tight">
                <i class="bi bi-person-badge text-blue-600 mr-4"></i> Nurse Profile
            </h2>
            <p class="text-gray-500 font-medium mt-1">Official Practitioner Record - Sri Lanka Nursing Council</p>
        </div>
        <div class="flex gap-3 w-full md:w-auto">
            <a href="{{ route('nurses.index') }}" class="flex-1 md:flex-initial inline-flex items-center justify-center px-4 py-2.5 border border-gray-200 text-sm font-bold rounded-xl text-gray-700 bg-white hover:bg-gray-50 transition-all shadow-sm">
                <i class="bi bi-arrow-left mr-2"></i> Back to List
            </a>
            <a href="{{ route('nurses.edit', $nurse) }}" class="flex-1 md:flex-initial inline-flex items-center justify-center px-4 py-2.5 border border-transparent text-sm font-bold rounded-xl text-white bg-blue-600 hover:bg-blue-700 transition-all shadow-md hover:shadow-lg">
                <i class="bi bi-pencil mr-2"></i> Edit Profile
            </a>
        </div>
    </div>

    <div class="bg-white rounded-3xl shadow-xl border border-gray-100 overflow-hidden">
        <div class="border-b border-gray-100 bg-gray-50/50">
            <nav class="flex overflow-x-auto no-scrollbar scroll-smooth" aria-label="Tabs" id="profileTabs">
                <button data-target="personal" class="tab-btn px-6 py-4 text-sm font-black border-b-2 border-blue-600 text-blue-600 whitespace-nowrap transition-all uppercase tracking-widest flex items-center gap-2 bg-white ring-1 ring-gray-100 ring-inset">
                    <i class="bi bi-person icon text-lg"></i> Personal
                </button>
                <button data-target="temp-reg" class="tab-btn px-6 py-4 text-sm font-bold border-b-2 border-transparent text-gray-400 hover:text-gray-600 hover:border-gray-200 whitespace-nowrap transition-all uppercase tracking-widest flex items-center gap-2">
                    <i class="bi bi-file-earmark-medical icon text-lg"></i> Temp. Reg.
                </button>
                <button data-target="perm-reg" class="tab-btn px-6 py-4 text-sm font-bold border-b-2 border-transparent text-gray-400 hover:text-gray-600 hover:border-gray-200 whitespace-nowrap transition-all uppercase tracking-widest flex items-center gap-2">
                    <i class="bi bi-award icon text-lg"></i> Perm. Reg.
                </button>
                <button data-target="qual" class="tab-btn px-6 py-4 text-sm font-bold border-b-2 border-transparent text-gray-400 hover:text-gray-600 hover:border-gray-200 whitespace-nowrap transition-all uppercase tracking-widest flex items-center gap-2">
                    <i class="bi bi-mortarboard icon text-lg"></i> Qualifications
                </button>
                <button data-target="foreign" class="tab-btn px-6 py-4 text-sm font-bold border-b-2 border-transparent text-gray-400 hover:text-gray-600 hover:border-gray-200 whitespace-nowrap transition-all uppercase tracking-widest flex items-center gap-2">
                    <i class="bi bi-globe icon text-lg"></i> Foreign Certs
                </button>
                <button data-target="qr" class="tab-btn px-6 py-4 text-sm font-bold border-b-2 border-transparent text-gray-400 hover:text-gray-600 hover:border-gray-200 whitespace-nowrap transition-all uppercase tracking-widest flex items-center gap-2">
                    <i class="bi bi-qr-code icon text-lg"></i> QR Code
                </button>
            </nav>
        </div>
        
        <div class="p-8">
            <div id="tabContent">
                
                {{-- Tab 1: Personal Details --}}
                <div id="personal" class="tab-pane block animate-in fade-in duration-300">
                    <h3 class="text-2xl font-black text-gray-900 mb-8 border-l-4 border-blue-600 pl-4 uppercase tracking-tighter">{{ $nurse->name }}</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 italic font-medium">
                        <div class="group">
                            <div class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1 group-hover:text-blue-500 transition-colors">NIC Number</div>
                            <div class="text-lg font-black text-gray-900 not-italic bg-gray-50 inline-block px-3 py-1 rounded-xl border border-gray-100">{{ $nurse->nic }}</div>
                        </div>
                        <div class="group">
                            <div class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1 group-hover:text-blue-500 transition-colors">Gender</div>
                            <div class="text-lg text-gray-900">{{ ucfirst($nurse->gender) ?: 'N/A' }}</div>
                        </div>
                        <div class="group">
                            <div class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1 group-hover:text-blue-500 transition-colors">Date of Birth</div>
                            <div class="text-lg text-gray-900">{{ $nurse->date_of_birth ? \Carbon\Carbon::parse($nurse->date_of_birth)->format('d M Y') : 'N/A' }}</div>
                        </div>
                        <div class="group">
                            <div class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1 group-hover:text-blue-500 transition-colors">Contact Phone</div>
                            <div class="text-lg text-gray-900">{{ $nurse->phone ?: 'N/A' }}</div>
                        </div>
                        <div class="group md:col-span-2">
                            <div class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1 group-hover:text-blue-500 transition-colors">Residential Address</div>
                            <div class="text-lg text-gray-900">{{ $nurse->address ?: 'N/A' }}</div>
                        </div>
                        <div class="group">
                            <div class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1 group-hover:text-blue-500 transition-colors">Alumni Institution</div>
                            <div class="text-lg text-gray-900">{{ $nurse->school_or_university ?: 'N/A' }}</div>
                        </div>
                        <div class="group">
                            <div class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1 group-hover:text-blue-500 transition-colors">Batch Year</div>
                            <div class="text-lg text-gray-900">{{ $nurse->batch ?: 'N/A' }}</div>
                        </div>
                    </div>
                </div>

                {{-- Tab 2: Temporary Registration --}}
                <div id="temp-reg" class="tab-pane hidden animate-in fade-in duration-300">
                    @if($nurse->temporaryRegistration)
                        <div class="bg-blue-50/50 rounded-2xl p-6 border border-blue-100 mb-6">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 italic font-medium">
                                <div class="group">
                                    <div class="text-[10px] font-black text-blue-400 uppercase tracking-widest mb-1">Registration Number</div>
                                    <div class="text-xl font-black text-blue-900 not-italic">{{ $nurse->temporaryRegistration->registration_no }}</div>
                                </div>
                                <div class="group">
                                    <div class="text-[10px] font-black text-blue-400 uppercase tracking-widest mb-1">Authenticated Date</div>
                                    <div class="text-lg text-gray-900">{{ \Carbon\Carbon::parse($nurse->temporaryRegistration->registration_date)->format('d M Y') }}</div>
                                </div>
                                <div class="group md:col-span-2">
                                    <div class="text-[10px] font-black text-blue-400 uppercase tracking-widest mb-1">Active Posting / Workplace</div>
                                    <div class="text-lg text-gray-900">{{ $nurse->temporaryRegistration->present_workplace ?: 'N/A' }}</div>
                                </div>
                                <div class="group">
                                    <div class="text-[10px] font-black text-blue-400 uppercase tracking-widest mb-1">Service Grade</div>
                                    <div class="text-lg text-gray-900">{{ $nurse->temporaryRegistration->grade ?: 'N/A' }}</div>
                                </div>
                                <div class="flex items-end justify-end">
                                    <a href="{{ route('temporary-registrations.show', $nurse->temporaryRegistration) }}" class="inline-flex items-center px-4 py-2 bg-white border border-blue-200 text-blue-700 font-black text-[10px] uppercase tracking-widest rounded-xl hover:bg-blue-50 transition-all shadow-sm">
                                        Exploration <i class="bi bi-arrow-right ml-2 text-xs"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="text-center py-16">
                            <div class="bg-gray-50 w-20 h-20 rounded-3xl flex items-center justify-center mx-auto mb-6 border border-gray-100">
                                <i class="bi bi-file-earmark-medical text-3xl text-gray-300"></i>
                            </div>
                            <h4 class="text-xl font-bold text-gray-900 mb-2">Registry Void</h4>
                            <p class="text-gray-500 italic max-w-sm mx-auto">This practitioner does not currently hold an active temporary registration status.</p>
                        </div>
                    @endif
                </div>

                {{-- Tab 3: Permanent Registration --}}
                <div id="perm-reg" class="tab-pane hidden animate-in fade-in duration-300">
                    @if($nurse->permanentRegistration)
                        <div class="bg-emerald-50/50 rounded-3xl p-8 border border-emerald-100 relative overflow-hidden">
                            <div class="absolute -top-10 -right-10 w-40 h-40 bg-emerald-100 rounded-full blur-3xl opacity-50"></div>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-10 italic font-medium relative z-10">
                                <div class="group">
                                    <div class="text-[10px] font-black text-emerald-500 uppercase tracking-widest mb-2">Permanent Registration Identifier</div>
                                    <div class="text-2xl font-black text-emerald-900 not-italic flex items-center gap-3">
                                        <i class="bi bi-award text-emerald-600"></i>
                                        {{ $nurse->permanentRegistration->perm_registration_no }}
                                    </div>
                                </div>
                                <div class="group">
                                    <div class="text-[10px] font-black text-emerald-500 uppercase tracking-widest mb-2">Canonical Registration Date</div>
                                    <div class="text-lg text-gray-900">{{ \Carbon\Carbon::parse($nurse->permanentRegistration->perm_registration_date)->format('d M Y') }}</div>
                                </div>
                                <div class="group md:col-span-2">
                                    <div class="text-[10px] font-black text-emerald-500 uppercase tracking-widest mb-2">Station Assignment</div>
                                    <div class="text-lg text-gray-900 bg-white/50 p-4 rounded-xl border border-emerald-50">{{ $nurse->permanentRegistration->present_workplace ?: 'N/A' }}</div>
                                </div>
                                <div class="group">
                                    <div class="text-[10px] font-black text-emerald-500 uppercase tracking-widest mb-2">Professional Grade</div>
                                    <div class="text-lg text-gray-900">{{ $nurse->permanentRegistration->grade ?: 'N/A' }}</div>
                                </div>
                                <div class="group">
                                    <div class="text-[10px] font-black text-emerald-500 uppercase tracking-widest mb-2">International Accreditation</div>
                                    <div class="text-lg text-gray-900">{{ $nurse->permanentRegistration->foreign_training_details ?: 'None Recorded' }}</div>
                                </div>
                                <div class="md:col-span-2 pt-4 border-t border-emerald-100">
                                    <a href="{{ route('permanent-registrations.show', $nurse->permanentRegistration) }}" class="inline-flex items-center px-6 py-3 bg-emerald-600 border border-transparent text-white font-black text-[10px] uppercase tracking-widest rounded-2xl hover:bg-emerald-700 transition-all shadow-lg hover:shadow-emerald-200">
                                        Full Validation Workspace <i class="bi bi-box-arrow-up-right ml-2"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="text-center py-16">
                            <div class="bg-gray-50 w-20 h-20 rounded-3xl flex items-center justify-center mx-auto mb-6 border border-gray-100">
                                <i class="bi bi-award text-3xl text-gray-300"></i>
                            </div>
                            <h4 class="text-xl font-bold text-gray-900 mb-2">Permanent Registry Void</h4>
                            <p class="text-gray-500 italic max-w-sm mx-auto">Canonical permanent status has not yet been established for this practitioner.</p>
                        </div>
                    @endif
                </div>

                {{-- Tab 4: Additional Qualifications --}}
                <div id="qual" class="tab-pane hidden animate-in fade-in duration-300">
                    @if($nurse->additionalQualifications && $nurse->additionalQualifications->count() > 0)
                        <div class="bg-white rounded-2xl border border-gray-100 overflow-hidden shadow-sm">
                            <table class="w-full text-left border-collapse">
                                <thead class="bg-gray-50 border-b border-gray-100 italic font-black uppercase tracking-widest text-[10px] text-gray-500">
                                    <tr>
                                        <th class="px-6 py-4">Specialization / Type</th>
                                        <th class="px-6 py-4">Serial Number</th>
                                        <th class="px-6 py-4">Verification Date</th>
                                        <th class="px-6 py-4 text-center">Protocol Status</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-50 font-medium italic text-gray-700 text-sm">
                                    @foreach($nurse->additionalQualifications as $qual)
                                        <tr class="hover:bg-gray-50/50 transition-colors">
                                            <td class="px-6 py-4 font-black not-italic text-gray-900 uppercase tracking-tighter">{{ $qual->qualification_type }}</td>
                                            <td class="px-6 py-4 tracking-widest">{{ $qual->qualification_number }}</td>
                                            <td class="px-6 py-4">{{ \Carbon\Carbon::parse($qual->qualification_date)->format('d M Y') }}</td>
                                            <td class="px-6 py-4 text-center">
                                                @if($qual->certificate_printed)
                                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-black bg-emerald-100 text-emerald-700 uppercase tracking-tighter shadow-sm shrink-0 whitespace-nowrap">DOCUMENT RENDERED</span>
                                                @else
                                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-black bg-orange-100 text-orange-700 uppercase tracking-tighter shadow-sm shrink-0 whitespace-nowrap">PENDING QUEUE</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-16">
                            <div class="bg-gray-50 w-20 h-20 rounded-3xl flex items-center justify-center mx-auto mb-6 border border-gray-100">
                                <i class="bi bi-mortarboard text-3xl text-gray-300"></i>
                            </div>
                            <h4 class="text-xl font-bold text-gray-900 mb-2">No Verified Credentials</h4>
                            <p class="text-gray-500 italic max-w-sm mx-auto">No advanced specializations or additional academic credentials have been recorded.</p>
                        </div>
                    @endif
                </div>

                {{-- Tab 5: Foreign Certificates --}}
                <div id="foreign" class="tab-pane hidden animate-in fade-in duration-300">
                    @if($nurse->foreignCertificates && $nurse->foreignCertificates->count() > 0)
                        <div class="bg-white rounded-2xl border border-gray-100 overflow-hidden shadow-sm">
                            <table class="w-full text-left border-collapse">
                                <thead class="bg-gray-50 border-b border-gray-100 italic font-black uppercase tracking-widest text-[10px] text-gray-500">
                                    <tr>
                                        <th class="px-6 py-4">Credential Class</th>
                                        <th class="px-6 py-4">Origin Jurisdiction</th>
                                        <th class="px-6 py-4">Authorization Date</th>
                                        <th class="px-6 py-4 text-center">Security Status</th> 
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-50 font-medium italic text-gray-700 text-sm">
                                    @foreach($nurse->foreignCertificates as $cert)
                                        <tr class="hover:bg-gray-50/50 transition-colors">
                                            <td class="px-6 py-4 font-black not-italic text-gray-900 uppercase tracking-tighter">{{ $cert->certificate_type }}</td>
                                            <td class="px-6 py-4 tracking-widest">{{ $cert->country }}</td>
                                            <td class="px-6 py-4">{{ $cert->issue_date ? \Carbon\Carbon::parse($cert->issue_date)->format('d M Y') : 'N/A' }}</td>
                                            <td class="px-6 py-4 text-center">
                                                @if($cert->certificate_printed)
                                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-black bg-blue-100 text-blue-700 uppercase tracking-tighter shadow-sm shrink-0 whitespace-nowrap">ACCREDITED</span>
                                                @else
                                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-black bg-orange-100 text-orange-700 uppercase tracking-tighter shadow-sm shrink-0 whitespace-nowrap">VERIFICATION PENDING</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-16">
                            <div class="bg-gray-50 w-20 h-20 rounded-3xl flex items-center justify-center mx-auto mb-6 border border-gray-100">
                                <i class="bi bi-globe text-3xl text-gray-300"></i>
                            </div>
                            <h4 class="text-xl font-bold text-gray-900 mb-2">No International Filings</h4>
                            <p class="text-gray-500 italic max-w-sm mx-auto">No records found for international reciprocity or foreign training accreditation.</p>
                        </div>
                    @endif
                </div>

                {{-- Tab 6: QR Code --}}
                <div id="qr" class="tab-pane hidden animate-in fade-in duration-300">
                    <div class="max-w-md mx-auto text-center py-8">
                        @php
                            $qrData = "Nurse Not Eligible For ID (No Permanent Reg)";
                            if ($nurse->permanentRegistration) {
                                $data = [
                                    "SLNC Number" => $nurse->permanentRegistration->perm_registration_no ?? 'N/A',
                                    "SLNC Date" => $nurse->permanentRegistration->perm_registration_date ?? 'N/A',
                                    "Name" => $nurse->name,
                                    "Address" => $nurse->address ?? 'N/A',
                                    "NIC" => $nurse->nic
                                ];
                                $qrData = implode("\n", array_map(function ($k, $v) { return "$k: $v"; }, array_keys($data), $data));
                            }
                        @endphp

                        @if($nurse->permanentRegistration)
                            <div id="printable-token">
                                <div class="bg-white p-8 rounded-3xl border border-gray-200 shadow-2xl inline-block mb-8 relative group">
                                    <div class="absolute inset-0 bg-blue-600/5 rounded-3xl scale-110 blur-2xl group-hover:scale-125 transition-all duration-500 opacity-0 group-hover:opacity-100"></div>
                                    <div class="relative z-10 p-4 border-2 border-gray-50 rounded-2xl bg-white shadow-inner qr-code w-[280px] h-[280px] flex items-center justify-center overflow-hidden">
                                        {!! \SimpleSoftwareIO\QrCode\Facades\QrCode::size(280)->margin(2)->color(30, 64, 175)->generate($qrData) !!}
                                    </div>
                                </div>
                                <h4 class="text-2xl font-black text-gray-900 mb-2 tracking-tighter uppercase">Professional ID Sentinel</h4>
                                <p class="text-gray-500 font-medium italic mb-8">Scan this cryptographic token to verify direct credentials against the council's immutable ledger.</p>
                            </div>
                            <button onclick="window.print()" class="no-print inline-flex items-center px-6 py-3 bg-gray-900 text-white font-black text-xs uppercase tracking-widest rounded-2xl hover:bg-black transition-all shadow-xl">
                                <i class="bi bi-printer-fill mr-2"></i> Print Sentinel Token
                            </button>
                        @else
                            <div class="bg-orange-50/50 p-12 rounded-3xl border-2 border-dashed border-orange-200">
                                <i class="bi bi-shield-lock-fill text-6xl text-orange-300 d-block mb-6"></i>
                                <h4 class="text-xl font-black text-gray-900 mb-3 tracking-tighter uppercase">Cryptographic Lock Active</h4>
                                <p class="text-gray-500 font-medium italic mb-6">The system cannot generate a verification token until permanent registration is canonicalized. Access restricted.</p>
                                <a href="{{ route('permanent-registrations.create', ['nurse_id' => $nurse->id]) }}" class="inline-flex items-center px-6 py-3 bg-orange-600 text-white font-black text-xs uppercase tracking-widest rounded-2xl hover:bg-orange-700 transition-all shadow-lg shadow-orange-100">
                                    Establish Permanent Status
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
                
            </div>
        </div>
    </div>
</div>

<style>
    .no-scrollbar::-webkit-scrollbar { display: none; }
    .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
    
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .animate-in { animation: fadeIn 0.4s cubic-bezier(0.16, 1, 0.3, 1) forwards; }

    @media print {
        /* Hide all extraneous UI */
        nav, .no-print, #profileTabs, header, .max-w-6xl > div:first-child, footer, [role="navigation"] {
            display: none !important;
        }

        /* Reset layout containers */
        body, main, .max-w-7xl, .max-w-6xl, .bg-white.rounded-3xl, #tabContent, #qr {
            margin: 0 !important;
            padding: 0 !important;
            border: none !important;
            box-shadow: none !important;
            max-width: none !important;
            width: 100% !important;
            background: white !important;
            display: block !important;
            min-height: auto !important;
        }

        /* Isolate the QR tab */
        .tab-pane:not(#qr) {
            display: none !important;
        }

        #qr {
            padding-top: 2cm !important;
        }

        #printable-token {
            display: block !important;
            width: 100% !important;
            text-align: center !important;
            margin: 0 !important;
            padding: 0 !important;
        }

        /* Standardize QR container for paper */
        #printable-token .bg-white.p-8.rounded-3xl.border {
            display: block !important;
            margin: 0 auto 2rem !important;
            width: 320px !important;
            height: 320px !important;
            border: 1px solid #e5e7eb !important;
            background: white !important;
            position: relative !important;
            box-shadow: none !important;
            padding: 20px !important;
            border-radius: 20px !important;
        }

        #printable-token .qr-code {
            display: flex !important;
            width: 280px !important;
            height: 280px !important;
            margin: 0 auto !important;
            border: none !important;
            position: relative !important;
            overflow: visible !important;
            visibility: visible !important;
            opacity: 1 !important;
            box-shadow: none !important;
        }

        #printable-token .qr-code svg {
            display: block !important;
            width: 280px !important;
            height: 280px !important;
            visibility: visible !important;
            opacity: 1 !important;
        }

        /* Remove only visual effects, NOT the elements themselves */
        #printable-token .shadow-2xl, 
        #printable-token .shadow-inner, 
        #printable-token .shadow-xl {
            box-shadow: none !important;
        }

        #printable-token .blur-2xl,
        #printable-token .blur-3xl,
        #printable-token .absolute:not(.relative *) {
            display: none !important;
        }

        /* Specifically hide the background glow */
        #printable-token .bg-blue-600\/5 {
            display: none !important;
        }

        /* Preserve branding colors */
        .qr-code svg {
            -webkit-print-color-adjust: exact;
            print-color-adjust: exact;
        }

        @page {
            margin: 0.5cm;
            size: auto;
        }
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const tabBtns = document.querySelectorAll('.tab-btn');
        const tabPanes = document.querySelectorAll('.tab-pane');

        tabBtns.forEach(btn => {
            btn.addEventListener('click', () => {
                const target = btn.getAttribute('data-target');

                // Update Button Styles
                tabBtns.forEach(b => {
                    b.classList.remove('border-blue-600', 'text-blue-600', 'bg-white', 'ring-1', 'ring-gray-100', 'ring-inset');
                    b.classList.add('border-transparent', 'text-gray-400');
                    b.classList.remove('font-black');
                    b.classList.add('font-bold');
                });
                
                btn.classList.add('border-blue-600', 'text-blue-600', 'bg-white', 'ring-1', 'ring-gray-100', 'ring-inset');
                btn.classList.remove('border-transparent', 'text-gray-400');
                btn.classList.remove('font-bold');
                btn.classList.add('font-black');

                // Switch Panes
                tabPanes.forEach(pane => {
                    pane.classList.add('hidden');
                    pane.classList.remove('block');
                });
                
                const activePane = document.getElementById(target);
                activePane.classList.remove('hidden');
                activePane.classList.add('block');
            });
        });
    });
</script>
@endsection
