@extends('layout.app')
@section('title', 'Payment - ' . $event->nama)
@section('content')

<div class="h-[112px]">
    <x-nav />
</div>

<div id="background" class="relative w-full">
    <div class="absolute w-full h-[300px] bg-[linear-gradient(0deg,#4EB6F5_0%,#5B8CE9_100%)] -z-10"></div>
</div>

<section id="Content" class="w-full max-w-[1280px] mx-auto px-[52px] mt-16 mb-[100px]">
    <div class="flex flex-col gap-16">
        <!-- Header Section -->
        <div class="flex flex-col items-center gap-1">
            <p class="font-bold text-[32px] leading-[48px] capitalize text-white">Complete Payment</p>
            <div class="flex items-center gap-2 text-white">
                <a href="{{ route('front.index') }}" class="font-medium">Homepage</a>
                <span>></span>
                <a href="{{ route('event.index') }}" class="font-medium">Events</a>
                <span>></span>
                <a href="{{ route('event.show', $event->id) }}" class="font-medium">{{ $event->nama }}</a>
                <span>></span>
                <span class="font-medium">Payment</span>
            </div>
        </div>

        <!-- Payment Form -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Main Payment Form -->
            <div class="lg:col-span-2">
                <form action="{{ route('event.payment.store') }}" method="POST" enctype="multipart/form-data" class="flex flex-col gap-8">
                    @csrf
                    <input type="hidden" name="event_id" value="{{ $event->id }}">

                    <!-- Registration Summary -->
                    <div class="flex flex-col gap-6 rounded-3xl p-8 bg-white">
                        <h2 class="font-Neue-Plak-bold text-2xl leading-[33px]">Registration Summary</h2>
                        
                        <!-- Main Registrant -->
                        <div class="flex flex-col gap-4">
                            <h3 class="font-semibold text-lg text-aktiv-grey">Main Registrant</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div class="flex flex-col gap-1">
                                    <p class="font-medium text-aktiv-grey">Full Name</p>
                                    <p class="font-semibold text-lg">{{ $registrationData['name'] ?? 'N/A' }}</p>
                                </div>
                                <div class="flex flex-col gap-1">
                                    <p class="font-medium text-aktiv-grey">Email</p>
                                    <p class="font-semibold text-lg">{{ $registrationData['email'] ?? 'N/A' }}</p>
                                </div>
                                <div class="flex flex-col gap-1">
                                    <p class="font-medium text-aktiv-grey">Phone</p>
                                    <p class="font-semibold text-lg">{{ $registrationData['phone'] ?? 'N/A' }}</p>
                                </div>
                                @if(!empty($registrationData['company']))
                                <div class="flex flex-col gap-1">
                                    <p class="font-medium text-aktiv-grey">Company</p>
                                    <p class="font-semibold text-lg">{{ $registrationData['company'] }}</p>
                                </div>
                                @endif
                            </div>
                        </div>

                        <!-- Team Members (if team registration) -->
                        @if($registrationData['jenis_pendaftaran'] === 'tim' && !empty($registrationData['team_members']))
                        <div class="flex flex-col gap-4">
                            <h3 class="font-semibold text-lg text-aktiv-grey">Team Members ({{ count($registrationData['team_members']) }} members)</h3>
                            <div class="grid grid-cols-1 gap-3">
                                @foreach($registrationData['team_members'] as $index => $member)
                                <div class="flex items-center gap-3 p-4 rounded-lg bg-[#FBFBFB] border border-[#E6E7EB]">
                                    <div class="flex w-8 h-8 shrink-0 rounded-full bg-aktiv-blue items-center justify-center">
                                        @if(isset($member['is_ketua']) && $member['is_ketua'])
                                        <img src="{{asset('assets/images/icons/medal-star.svg')}}" class="w-4 h-4 text-white" alt="leader">
                                        @else
                                        <img src="{{asset('assets/images/icons/profile-circle.svg')}}" class="w-4 h-4 text-white" alt="member">
                                        @endif
                                    </div>
                                    <div class="flex flex-col flex-1">
                                        <p class="font-semibold text-lg leading-[27px]">
                                            {{ $member['nama'] }}
                                            @if(isset($member['is_ketua']) && $member['is_ketua'])
                                            <span class="text-aktiv-orange font-medium text-lg">(Leader)</span>
                                            @endif
                                        </p>
                                        <div class="flex items-center gap-4">
                                            <p class="font-medium text-aktiv-grey">{{ $member['email'] }}</p>
                                            <span class="text-aktiv-grey">•</span>
                                            <p class="font-medium text-aktiv-grey">{{ $member['kontak'] }}</p>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                        @endif

                        <!-- Registration Details -->
                        <div class="flex flex-col gap-4 p-6 rounded-xl bg-[#F8FAFC] border border-[#E6E7EB]">
                            <div class="flex items-center justify-between">
                                <p class="font-medium text-aktiv-grey">Event Name</p>
                                <p class="font-semibold text-lg leading-[27px] text-right">
                                    {{ $event->nama }}
                                </p>
                            </div>
                            <div class="flex items-center justify-between">
                                <p class="font-medium text-aktiv-grey">Registration Category</p>
                                <p class="font-semibold text-lg leading-[27px] text-right capitalize">
                                    {{ $registrationData['kategori_pendaftaran'] ?? 'Observer' }}
                                </p>
                            </div>
                            <div class="flex items-center justify-between">
                                <p class="font-medium text-aktiv-grey">Registration Method</p>
                                <p class="font-semibold text-lg leading-[27px] text-right capitalize">
                                    {{ $registrationData['jenis_pendaftaran'] ?? 'Individual' }}
                                </p>
                            </div>
                            
                            @php
                                // Calculate total participants
                                $totalParticipants = 1; // Main registrant
                                if ($registrationData['jenis_pendaftaran'] === 'tim' && !empty($registrationData['team_members'])) {
                                    $totalParticipants = count($registrationData['team_members']);
                                }
                                
                                // Calculate prices
                                $pricePerPerson = $event->price;
                                $subtotal = $pricePerPerson * $totalParticipants;
                                $ppn = $subtotal * 0.11;
                                $totalAmount = $subtotal + $ppn;
                            @endphp
                            
                            <!-- Show participant count for team registration -->
                            @if($registrationData['jenis_pendaftaran'] === 'tim')
                            <div class="flex items-center justify-between">
                                <p class="font-medium text-aktiv-grey">Number of Participants</p>
                                <p class="font-semibold text-lg leading-[27px] text-right">
                                    {{ $totalParticipants }} {{ $totalParticipants > 1 ? 'people' : 'person' }}
                                </p>
                            </div>
                            @endif
                            
                            <div class="flex items-center justify-between">
                                <p class="font-medium text-aktiv-grey">
                                    Registration Fee 
                                    @if($registrationData['jenis_pendaftaran'] === 'tim')
                                        ({{ $totalParticipants }} × Rp{{ number_format($pricePerPerson, 0, ',', '.') }})
                                    @endif
                                </p>
                                <p class="font-semibold text-lg leading-[27px] text-right">
                                    Rp{{ number_format($subtotal, 0, ',', '.') }}
                                </p>
                            </div>
                            <div class="flex items-center justify-between">
                                <p class="font-medium text-aktiv-grey">PPN 11%</p>
                                <p class="font-semibold text-lg leading-[27px] text-right">
                                    Rp{{ number_format($ppn, 0, ',', '.') }}
                                </p>
                            </div>
                            <hr class="border-[#E6E7EB]">
                            <div class="flex items-center justify-between">
                                <p class="font-semibold text-xl text-aktiv-grey">Total Amount</p>
                                <p class="font-bold text-2xl leading-[36px] text-right text-aktiv-red"> 
                                    Rp{{ number_format($totalAmount, 0, ',', '.') }}
                                </p>
                            </div>
                            
                            <!-- Price breakdown info for team -->
                            @if($registrationData['jenis_pendaftaran'] === 'tim')
                            <div class="mt-4 p-3 rounded-lg bg-blue-50 border border-blue-200">
                                <div class="flex items-center gap-2 mb-2">
                                    <img src="{{asset('assets/images/icons/info.svg')}}" class="w-4 h-4 text-blue-600" alt="info">
                                    <span class="text-sm font-medium text-blue-800">Team Registration Pricing</span>
                                </div>
                                <p class="text-sm text-blue-700">
                                    Each team member pays Rp{{ number_format($pricePerPerson, 0, ',', '.') }}. 
                                    Total for {{ $totalParticipants }} members: Rp{{ number_format($subtotal, 0, ',', '.') }} + PPN 11%
                                </p>
                            </div>
                            @endif
                        </div>
                    </div>

                    <!-- Bank Account Section -->
                    <div class="flex flex-col gap-6 rounded-3xl p-8 bg-white">
                        <h2 class="font-Neue-Plak-bold text-2xl leading-[33px]">Your Bank Account</h2>
                        <div class="flex flex-col gap-6">
                            <label class="flex flex-col gap-4">
                                <p class="font-medium text-aktiv-grey">Select Bank Type</p>
                                <div class="group input-wrapper flex items-center rounded-xl p-4 gap-2 bg-[#FBFBFB] overflow-hidden">
                                    {{-- <img src="{{asset('assets/images/icons/bank.svg')}}" class="w-6 h-6 flex shrink-0 group-focus-within:hidden group-has-[:valid]:hidden" alt="icon"> --}}
                                    <img src="{{asset('assets/images/icons/bank-black.svg')}}" class="w-6 h-6 shrink-0 hidden group-focus-within:flex group-has-[:valid]:flex" alt="icon">
                                    <select name="customer_bank_name" class="appearance-none bg-transparent w-full outline-none text-lg leading-[27px] font-semibold placeholder:font-medium placeholder:text-aktiv-grey" required>
                                        <option value="" disabled {{ old('customer_bank_name') ? '' : 'selected' }}>Choose your bank</option>
                                        <option value="BCA" {{ old('customer_bank_name') == 'BCA' ? 'selected' : '' }}>Bank Central Asia (BCA)</option>
                                        <option value="BNI" {{ old('customer_bank_name') == 'BNI' ? 'selected' : '' }}>Bank Negara Indonesia (BNI)</option>
                                        <option value="BRI" {{ old('customer_bank_name') == 'BRI' ? 'selected' : '' }}>Bank Rakyat Indonesia (BRI)</option>
                                        <option value="Mandiri" {{ old('customer_bank_name') == 'Mandiri' ? 'selected' : '' }}>Bank Mandiri</option>
                                        <option value="Other" {{ old('customer_bank_name') == 'Other' ? 'selected' : '' }}>Other Bank</option>
                                    </select>
                                </div>
                                @error('customer_bank_name')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                                @enderror
                            </label>

                            <label class="flex flex-col gap-4">
                                <p class="font-medium text-aktiv-grey">Account Holder Name</p>
                                <div class="group input-wrapper flex items-center rounded-xl p-4 gap-2 bg-[#FBFBFB] overflow-hidden">
                                    {{-- <img src="{{asset('assets/images/icons/profile-circle.svg')}}" class="w-6 h-6 flex shrink-0 group-focus-within:hidden group-has-[:valid]:hidden" alt="icon"> --}}
                                    <img src="{{asset('assets/images/icons/profile-circle-black.svg')}}" class="w-6 h-6 shrink-0 hidden group-focus-within:flex group-has-[:valid]:flex" alt="icon">
                                    <input type="text" name="customer_bank_account" value="{{ old('customer_bank_account') }}" class="appearance-none bg-transparent w-full outline-none text-lg leading-[27px] font-semibold placeholder:font-medium placeholder:text-aktiv-grey" placeholder="Full name as per bank account" required>
                                </div>
                                @error('customer_bank_account')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                                @enderror
                            </label>

                            <label class="flex flex-col gap-4">
                                <p class="font-medium text-aktiv-grey">Account Number</p>
                                <div class="group input-wrapper flex items-center rounded-xl p-4 gap-2 bg-[#FBFBFB] overflow-hidden">
                                    {{-- <img src="{{asset('assets/images/icons/card.svg')}}" class="w-6 h-6 flex shrink-0 group-focus-within:hidden group-has-[:valid]:hidden" alt="icon"> --}}
                                    <img src="{{asset('assets/images/icons/card-black.svg')}}" class="w-6 h-6 shrink-0 hidden group-focus-within:flex group-has-[:valid]:flex" alt="icon">
                                    <input type="text" name="customer_bank_number" value="{{ old('customer_bank_number') }}" class="appearance-none bg-transparent w-full outline-none text-lg leading-[27px] font-semibold placeholder:font-medium placeholder:text-aktiv-grey" placeholder="Bank account number" required>
                                </div>
                                @error('customer_bank_number')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                                @enderror
                            </label>
                        </div>
                    </div>

                    <!-- Company Bank Accounts -->
                    <div class="flex flex-col gap-6 rounded-3xl p-8 bg-white">
                        <h2 class="font-Neue-Plak-bold text-2xl leading-[33px]">Transfer to Company Account</h2>
                        <p class="font-medium text-aktiv-grey">Please transfer the exact amount to one of our company accounts below:</p>
                        
                        <div class="flex flex-col gap-6 rounded-xl border border-[#E6E7EB] p-6">
                            <div class="flex flex-col gap-6">
                                <!-- BCA Bank -->
                                <div class="flex items-center justify-between gap-8">
                                    <div class="flex w-[78px] h-[53px] shrink-0 overflow-hidden">
                                        <img src="{{asset('assets/images/logos/bca.svg')}}" class="object-contain" alt="bank logo">
                                    </div>
                                    <div class="flex flex-col gap-[2px] w-full">
                                        <p class="font-medium text-aktiv-grey">BCA Wahana Kendali Mutu</p>
                                        <p class="font-semibold text-lg leading-[27px]">1935 0009 1200</p>
                                    </div>
                                    <button type="button" class="align-middle font-semibold text-lg leading-[27px] text-aktiv-orange copy-btn" data-account="1935 0009 1200">Copy</button>
                                </div>
                                
                                <!-- BNI Bank -->
                                <div class="flex items-center justify-between gap-8">
                                    <div class="flex w-[78px] h-[53px] shrink-0 overflow-hidden">
                                        <img src="{{asset('assets/images/logos/bni.svg')}}" class="object-contain" alt="bank logo">
                                    </div>
                                    <div class="flex flex-col gap-[2px] w-full">
                                        <p class="font-medium text-aktiv-grey">BNI Wahana Kendali Mutu</p>
                                        <p class="font-semibold text-lg leading-[27px]">1200 1935 0009</p>
                                    </div>
                                    <button type="button" class="align-middle font-semibold text-lg leading-[27px] text-aktiv-orange copy-btn" data-account="1200 1935 0009">Copy</button>
                                </div>

                                <!-- BRI Bank -->
                                <div class="flex items-center justify-between gap-8">
                                    <div class="flex w-[78px] h-[53px] shrink-0 overflow-hidden">
                                        <img src="{{asset('assets/images/logos/bri.svg')}}" class="object-contain" alt="bank logo">
                                    </div>
                                    <div class="flex flex-col gap-[2px] w-full">
                                        <p class="font-medium text-aktiv-grey">BRI Wahana Kendali Mutu</p>
                                        <p class="font-semibold text-lg leading-[27px]">0009 1200 1935</p>
                                    </div>
                                    <button type="button" class="align-middle font-semibold text-lg leading-[27px] text-aktiv-orange copy-btn" data-account="0009 1200 1935">Copy</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Upload Proof Section -->
                    <div class="flex flex-col gap-6 rounded-3xl p-8 bg-white">
                        <h2 class="font-Neue-Plak-bold text-2xl leading-[33px]">Upload Payment Proof</h2>
                        <label class="flex flex-col gap-4">
                            <p class="font-medium text-aktiv-grey">Payment Receipt/Screenshot *</p>
                            <div class="group input-wrapper flex items-center rounded-xl p-4 gap-2 bg-[#FBFBFB] overflow-hidden">
                                <img src="{{asset('assets/images/icons/document-upload.svg')}}" class="w-6 h-6 flex shrink-0 group-focus-within:hidden group-has-[:valid]:hidden" alt="icon">
                                <img src="{{asset('assets/images/icons/document-upload-black.svg')}}" class="w-6 h-6 shrink-0 hidden group-focus-within:flex group-has-[:valid]:flex" alt="icon">
                                <input type="file" name="payment_proof" accept="image/*,.pdf" class="appearance-none bg-transparent w-full outline-none text-lg leading-[27px] font-semibold placeholder:font-medium placeholder:text-aktiv-grey" required>
                            </div>
                            <p class="text-sm text-aktiv-grey">Accepted formats: JPG, PNG, PDF (Max: 5MB)</p>
                            @error('payment_proof')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </label>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" class="w-full rounded-xl h-16 px-6 text-center bg-aktiv-orange font-semibold text-lg leading-[27px] text-white hover:bg-aktiv-orange/90 transition-colors">Submit Payment</button>
                </form>
            </div>

            <!-- Enhanced Event Details Sidebar -->
            <div class="lg:col-span-1">
                <div class="sticky top-8 flex flex-col gap-6 rounded-3xl p-8 bg-white shadow-lg hover:shadow-xl transition-all duration-500">
                    <!-- Header with Icon -->
                    <div class="flex items-center gap-3">
                        <div class="flex w-12 h-12 rounded-full bg-gradient-to-br from-aktiv-blue to-aktiv-blue/80 items-center justify-center shadow-md">
                            <img src="{{asset('assets/images/icons/receipt-text.svg')}}" class="w-6 h-6 text-white" alt="event">
                        </div>
                        <h3 class="font-Neue-Plak-bold text-xl">Event Details</h3>
                    </div>
                    
                    <!-- Event Image with Enhanced Styling -->
                    <div class="flex w-full h-[200px] rounded-xl overflow-hidden relative group shadow-md hover:shadow-lg transition-all duration-500">
                        @if($event->thumbnail)
                            <img src="{{ Storage::url($event->thumbnail) }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" alt="{{ $event->nama }}">
                        @else
                            <div class="w-full h-full bg-gradient-to-br from-aktiv-blue to-aktiv-orange flex items-center justify-center group-hover:scale-105 transition-transform duration-500">
                                <span class="text-white text-4xl font-bold">{{ substr($event->nama, 0, 1) }}</span>
                            </div>
                        @endif
                        
                        <!-- Overlay on hover -->
                        <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-end">
                            <div class="p-4 w-full">
                                <p class="text-white font-semibold text-lg">{{ $event->nama }}</p>
                                <p class="text-white/80 text-sm">View Event Details</p>
                            </div>
                        </div>
                        
                        <!-- Enhanced Status Badge -->
                        @if($event->is_open)
                            @if($event->has_started)
                            <div class="absolute top-3 left-3 flex items-center rounded-full py-2 px-4 gap-2 bg-gradient-to-r from-aktiv-orange to-orange-600 text-white shadow-lg hover:shadow-xl transform hover:scale-105 transition-all duration-300 z-10 animate-pulse-slow status-badge">
                                <div class="relative">
                                    <img src="{{asset('assets/images/icons/timer-start.svg')}}" class="w-4 h-4 animate-spin-slow" alt="icon">
                                    <div class="absolute -top-1 -right-1 w-2 h-2 bg-yellow-400 rounded-full animate-ping"></div>
                                </div>
                                <span class="font-bold text-sm tracking-wide drop-shadow-sm">STARTED</span>
                                <div class="w-2 h-2 bg-white/70 rounded-full animate-pulse"></div>
                            </div>
                            @else
                            <div class="absolute top-3 left-3 flex items-center rounded-full py-2 px-4 gap-2 bg-gradient-to-r from-aktiv-green to-emerald-600 text-white shadow-lg hover:shadow-xl transform hover:scale-105 transition-all duration-300 z-10 animate-bounce-gentle status-badge">
                                <div class="relative">
                                    <img src="{{asset('assets/images/icons/medal-star.svg')}}" class="w-4 h-4 animate-bounce-gentle" alt="icon">
                                    <div class="absolute -top-1 -right-1 w-2 h-2 bg-yellow-400 rounded-full animate-ping"></div>
                                </div>
                                <span class="font-bold text-sm tracking-wide drop-shadow-sm">OPEN</span>
                                <div class="flex gap-1 status-dots">
                                    <div class="w-1.5 h-1.5 bg-white/80 rounded-full animate-pulse delay-100 status-dot"></div>
                                    <div class="w-1.5 h-1.5 bg-white/80 rounded-full animate-pulse delay-200 status-dot"></div>
                                    <div class="w-1.5 h-1.5 bg-white/80 rounded-full animate-pulse delay-300 status-dot"></div>
                                </div>
                            </div>
                            @endif
                        @else
                            <div class="absolute top-3 left-3 flex items-center rounded-full py-2 px-4 gap-2 bg-gradient-to-r from-aktiv-red to-red-600 text-white shadow-lg hover:shadow-xl transform hover:scale-105 transition-all duration-300 z-10 animate-fade-in-out status-badge">
                                <div class="relative">
                                    <img src="{{asset('assets/images/icons/sand-timer.svg')}}" class="w-4 h-4 opacity-90" alt="icon">
                                    <div class="absolute inset-0 bg-red-500/20 rounded-full animate-ping"></div>
                                </div>
                                <span class="font-bold text-sm tracking-wide drop-shadow-sm">CLOSED</span>
                                <div class="w-2 h-2 bg-white/50 rounded-full animate-pulse-slow"></div>
                            </div>
                        @endif
                    </div>

                    <!-- Event Info with Enhanced Cards -->
                    <div class="flex flex-col gap-4">
                        <h4 class="font-semibold text-lg text-aktiv-black">{{ $event->nama }}</h4>
                        
                        <!-- Date Card -->
                        <div class="flex items-center gap-3 p-3 rounded-lg hover:bg-[#FBFBFB] transition-all duration-300 border border-transparent hover:border-aktiv-blue/20">
                            <div class="w-10 h-10 flex items-center justify-center rounded-full bg-gradient-to-br from-aktiv-blue/10 to-aktiv-blue/20 shadow-sm">
                                <img src="{{asset('assets/images/icons/calendar.svg')}}" class="w-5 h-5 text-aktiv-blue" alt="icon">
                            </div>
                            <div class="flex flex-col flex-1">
                                <span class="text-xs font-medium text-aktiv-grey uppercase tracking-wide">Event Date</span>
                                <span class="font-semibold text-aktiv-black">{{ $event->tanggal->format('d F Y') }}</span>
                            </div>
                        </div>

                        <!-- Time Card -->
                        @if($event->time_at)
                        <div class="flex items-center gap-3 p-3 rounded-lg hover:bg-[#FBFBFB] transition-all duration-300 border border-transparent hover:border-aktiv-blue/20">
                            <div class="w-10 h-10 flex items-center justify-center rounded-full bg-gradient-to-br from-aktiv-orange/10 to-aktiv-orange/20 shadow-sm">
                                <img src="{{asset('assets/images/icons/clock.svg')}}" class="w-5 h-5 text-aktiv-orange" alt="icon">
                            </div>
                            <div class="flex flex-col flex-1">
                                <span class="text-xs font-medium text-aktiv-grey uppercase tracking-wide">Event Time</span>
                                <span class="font-semibold text-aktiv-black">{{ $event->time_at->format('H:i') }} WIB</span>
                            </div>
                        </div>
                        @endif

                        <!-- Location Card -->
                        <div class="flex items-center gap-3 p-3 rounded-lg hover:bg-[#FBFBFB] transition-all duration-300 border border-transparent hover:border-aktiv-blue/20">
                            <div class="w-10 h-10 flex items-center justify-center rounded-full bg-gradient-to-br from-aktiv-green/10 to-aktiv-green/20 shadow-sm">
                                <img src="{{asset('assets/images/icons/location.svg')}}" class="w-5 h-5 text-aktiv-green" alt="icon">
                            </div>
                            <div class="flex flex-col flex-1">
                                <span class="text-xs font-medium text-aktiv-grey uppercase tracking-wide">Location</span>
                                <span class="font-semibold text-aktiv-black line-clamp-2">{{ $event->lokasi }}</span>
                            </div>
                        </div>

                        <!-- Registration Count Card -->
                        <div class="flex items-center gap-3 p-3 rounded-lg bg-gradient-to-r from-aktiv-blue/5 to-aktiv-blue/10 border border-aktiv-blue/20">
                            <div class="w-10 h-10 flex items-center justify-center rounded-full bg-aktiv-blue shadow-sm">
                                <img src="{{asset('assets/images/icons/profile-2user.svg')}}" class="w-5 h-5 text-white" alt="icon">
                            </div>
                            <div class="flex flex-col flex-1">
                                <span class="text-xs font-medium text-aktiv-blue uppercase tracking-wide">Registered</span>
                                <span class="font-bold text-aktiv-blue">{{ $event->total_participants ?? 0 }} participants</span>
                            </div>
                            <div class="animate-ping w-2 h-2 rounded-full bg-aktiv-blue opacity-75"></div>
                        </div>
                    </div>

                    <!-- Divider with Design -->
                    <div class="relative">
                        <div class="absolute inset-0 flex items-center">
                            <div class="w-full border-t border-dashed border-[#E6E7EB]"></div>
                        </div>
                        <div class="relative flex justify-center">
                            <span class="bg-white px-3 text-sm font-medium text-aktiv-grey">Payment Information</span>
                        </div>
                    </div>

                    <!-- Enhanced Payment Reminder -->
                    <div class="flex flex-col gap-4 p-5 rounded-xl bg-gradient-to-br from-amber-50 to-orange-50 border border-amber-200 shadow-sm">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 flex items-center justify-center rounded-full bg-amber-100 shadow-sm">
                                <img src="{{asset('assets/images/icons/warning.svg')}}" class="w-5 h-5 text-amber-600" alt="warning">
                            </div>
                            <h4 class="font-semibold text-amber-800">Payment Guidelines</h4>
                        </div>
                        
                        <div class="grid grid-cols-1 gap-3">
                            <div class="flex items-center gap-3 p-3 rounded-lg bg-white/70 border border-amber-200/50">
                                <div class="w-6 h-6 flex items-center justify-center rounded-full bg-amber-500 shadow-sm">
                                    <span class="text-white text-xs font-bold">1</span>
                                </div>
                                <p class="text-sm text-amber-800 font-medium">Transfer exact amount including PPN</p>
                            </div>
                            
                            <div class="flex items-center gap-3 p-3 rounded-lg bg-white/70 border border-amber-200/50">
                                <div class="w-6 h-6 flex items-center justify-center rounded-full bg-amber-500 shadow-sm">
                                    <span class="text-white text-xs font-bold">2</span>
                                </div>
                                <p class="text-sm text-amber-800 font-medium">Upload clear payment receipt</p>
                            </div>
                            
                            <div class="flex items-center gap-3 p-3 rounded-lg bg-white/70 border border-amber-200/50">
                                <div class="w-6 h-6 flex items-center justify-center rounded-full bg-amber-500 shadow-sm">
                                    <span class="text-white text-xs font-bold">3</span>
                                </div>
                                <p class="text-sm text-amber-800 font-medium">Verification within 1x24 hours</p>
                            </div>
                            
                            <div class="flex items-center gap-3 p-3 rounded-lg bg-white/70 border border-amber-200/50">
                                <div class="w-6 h-6 flex items-center justify-center rounded-full bg-amber-500 shadow-sm">
                                    <span class="text-white text-xs font-bold">4</span>
                                </div>
                                <p class="text-sm text-amber-800 font-medium">Keep transaction ID for reference</p>
                            </div>
                        </div>
                    </div>

                    <!-- Quick Actions -->
                    <div class="flex flex-col gap-3">
                        <div class="flex items-center gap-3 p-4 rounded-xl bg-gradient-to-r from-aktiv-green/5 to-aktiv-green/10 border border-aktiv-green/20 hover:from-aktiv-green/10 hover:to-aktiv-green/15 transition-all duration-300 cursor-pointer">
                            <div class="w-8 h-8 flex items-center justify-center rounded-full bg-aktiv-green shadow-sm">
                                <img src="{{asset('assets/images/icons/shield-tick.svg')}}" class="w-4 h-4 text-white" alt="secure">
                            </div>
                            <div class="flex flex-col flex-1">
                                <span class="font-semibold text-aktiv-green">Secure Payment</span>
                                <span class="text-xs text-aktiv-green/80">256-bit SSL encrypted</span>
                            </div>
                        </div>
                        
                        <div class="flex items-center gap-3 p-4 rounded-xl bg-gradient-to-r from-aktiv-blue/5 to-aktiv-blue/10 border border-aktiv-blue/20 hover:from-aktiv-blue/10 hover:to-aktiv-blue/15 transition-all duration-300 cursor-pointer">
                            <div class="w-8 h-8 flex items-center justify-center rounded-full bg-aktiv-blue shadow-sm">
                                <img src="{{asset('assets/images/icons/call.svg')}}" class="w-4 h-4 text-white" alt="support">
                            </div>
                            <div class="flex flex-col flex-1">
                                <span class="font-semibold text-aktiv-blue">24/7 Support</span>
                                <span class="text-xs text-aktiv-blue/80">Need help? Contact us</span>
                            </div>
                        </div>
                    </div>

                    <!-- Price Summary Card -->
                    <div class="flex flex-col gap-4 p-5 rounded-xl bg-gradient-to-br from-aktiv-red/5 to-aktiv-red/10 border border-aktiv-red/20 shadow-sm">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 flex items-center justify-center rounded-full bg-aktiv-red shadow-sm">
                                    <img src="{{asset('assets/images/icons/money-recive.svg')}}" class="w-4 h-4 text-white" alt="price">
                                </div>
                                <span class="font-semibold text-aktiv-grey">Total Amount</span>
                            </div>
                            <span class="font-bold text-2xl text-aktiv-red">
                                Rp{{ number_format($totalAmount, 0, ',', '.') }}
                            </span>
                        </div>
                        
                        <div class="flex items-center gap-2 text-aktiv-red/80">
                            <img src="{{asset('assets/images/icons/info.svg')}}" class="w-4 h-4" alt="info">
                            <span class="text-sm font-medium">Including PPN 11%</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection

@push('after-scripts')
<script>
    // Copy account number functionality
    document.addEventListener('DOMContentLoaded', function() {
        const copyButtons = document.querySelectorAll('.copy-btn');
        
        copyButtons.forEach(button => {
            button.addEventListener('click', function() {
                const accountNumber = this.getAttribute('data-account');
                
                navigator.clipboard.writeText(accountNumber).then(() => {
                    // Show copy confirmation
                    const originalText = this.textContent;
                    this.textContent = 'Copied!';
                    this.style.color = '#059669';
                    
                    setTimeout(() => {
                        this.textContent = originalText;
                        this.style.color = '';
                    }, 2000);
                }).catch(() => {
                    // Fallback for older browsers
                    const textArea = document.createElement('textarea');
                    textArea.value = accountNumber;
                    document.body.appendChild(textArea);
                    textArea.select();
                    document.execCommand('copy');
                    document.body.removeChild(textArea);
                    
                    // Show copy confirmation
                    const originalText = this.textContent;
                    this.textContent = 'Copied!';
                    this.style.color = '#059669';
                    
                    setTimeout(() => {
                        this.textContent = originalText;
                        this.style.color = '';
                    }, 2000);
                });
            });
        });
    });
</script>
@endpush