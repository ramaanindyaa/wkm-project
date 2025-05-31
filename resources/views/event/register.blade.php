@extends('layout.app')
@section('title', 'Register for ' . $event->nama)
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
            <p class="font-bold text-[32px] leading-[48px] capitalize text-white">Register for Event</p>
            <div class="flex items-center gap-2 text-white">
                <a href="{{ route('front.index') }}" class="font-medium hover:text-aktiv-orange transition-colors">Homepage</a>
                <span>></span>
                <a href="{{ route('event.index') }}" class="font-medium hover:text-aktiv-orange transition-colors">Events</a>
                <span>></span>
                <a href="{{ route('event.show', $event->id) }}" class="font-medium hover:text-aktiv-orange transition-colors">{{ $event->nama }}</a>
                <span>></span>
                <span class="font-medium">Register</span>
            </div>
        </div>

        <!-- Registration Form -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Main Form -->
            <div class="lg:col-span-2">
                <form action="{{ route('event.register.store') }}" method="POST" class="flex flex-col gap-8">
                    @csrf
                    <input type="hidden" name="event_id" value="{{ $event->id }}">

                    <!-- Event Information Summary -->
                    <div class="flex flex-col gap-6 rounded-3xl p-8 bg-white shadow-sm hover:shadow-md transition-all duration-300">
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 rounded-full flex items-center justify-center shrink-0 bg-aktiv-blue overflow-hidden">
                                <img src="{{asset('assets/images/icons/calendar.svg')}}" class="w-6 h-6 text-white" alt="icon">
                            </div>
                            <h2 class="font-Neue-Plak-bold text-2xl leading-[33px]">Event Information</h2>
                        </div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="flex flex-col gap-2 p-4 rounded-xl bg-[#FBFBFB] border border-[#E6E7EB] hover:border-aktiv-blue/20 transition-all duration-300">
                                <p class="font-medium text-aktiv-grey">Event Name</p>
                                <p class="font-semibold text-lg">{{ $event->nama }}</p>
                            </div>
                            <div class="flex flex-col gap-2 p-4 rounded-xl bg-[#FBFBFB] border border-[#E6E7EB] hover:border-aktiv-blue/20 transition-all duration-300">
                                <p class="font-medium text-aktiv-grey">Date</p>
                                <p class="font-semibold text-lg">{{ $event->tanggal->format('d F Y') }}</p>
                            </div>
                            @if($event->time_at)
                            <div class="flex flex-col gap-2 p-4 rounded-xl bg-[#FBFBFB] border border-[#E6E7EB] hover:border-aktiv-blue/20 transition-all duration-300">
                                <p class="font-medium text-aktiv-grey">Time</p>
                                <p class="font-semibold text-lg">{{ $event->time_at->format('H:i') }} WIB</p>
                            </div>
                            @endif
                            <div class="flex flex-col gap-2 p-4 rounded-xl bg-[#FBFBFB] border border-[#E6E7EB] hover:border-aktiv-blue/20 transition-all duration-300">
                                <p class="font-medium text-aktiv-grey">Location</p>
                                <p class="font-semibold text-lg">{{ $event->lokasi }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Personal Information -->
                    <div class="flex flex-col gap-6 rounded-3xl p-8 bg-white shadow-sm hover:shadow-md transition-all duration-300">
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 rounded-full flex items-center justify-center shrink-0 bg-aktiv-orange overflow-hidden">
                                <img src="{{asset('assets/images/icons/profile-circle.svg')}}" class="w-6 h-6 text-white" alt="icon">
                            </div>
                            <h2 class="font-Neue-Plak-bold text-2xl leading-[33px]">Personal Information</h2>
                        </div>
                        
                        <div class="w-full border-l-[5px] border-aktiv-blue py-4 px-3 bg-[linear-gradient(270deg,rgba(2,104,251,0)_0%,rgba(2,104,251,0.09)_100%)] rounded-r-lg">
                            <p class="font-semibold text-aktiv-blue">Please enter your data correctly. Registration confirmation will be sent to your email.</p>
                        </div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Full Name -->
                            <label class="flex flex-col gap-4 input-field-container relative">
                                <p class="font-medium text-aktiv-grey">Full Name *</p>
                                <div class="group input-wrapper flex items-center rounded-xl p-4 gap-2 bg-[#FBFBFB] border border-transparent hover:border-aktiv-blue/20 focus-within:border-aktiv-blue/40 overflow-hidden transition-all duration-300">
                                    <img src="{{asset('assets/images/icons/profile-circle.svg')}}" class="w-6 h-6 flex shrink-0 group-focus-within:hidden group-has-[:valid]:hidden" alt="icon">
                                    <img src="{{asset('assets/images/icons/profile-circle-black.svg')}}" class="w-6 h-6 shrink-0 hidden group-focus-within:flex group-has-[:valid]:flex" alt="icon">
                                    <input type="text" name="name" value="{{ old('name') }}" class="appearance-none bg-transparent w-full outline-none text-lg leading-[27px] font-semibold placeholder:font-medium placeholder:text-aktiv-grey" placeholder="Write your complete name" required>
                                </div>
                                @error('name')
                                <span class="text-red-500 text-sm absolute -bottom-6 left-0">{{ $message }}</span>
                                @enderror
                            </label>

                            <!-- Email -->
                            <label class="flex flex-col gap-4 input-field-container relative">
                                <p class="font-medium text-aktiv-grey">Email Address *</p>
                                <div class="group input-wrapper flex items-center rounded-xl p-4 gap-2 bg-[#FBFBFB] border border-transparent hover:border-aktiv-blue/20 focus-within:border-aktiv-blue/40 overflow-hidden transition-all duration-300">
                                    <img src="{{asset('assets/images/icons/sms.svg')}}" class="w-6 h-6 flex shrink-0 group-focus-within:hidden group-has-[:valid]:hidden" alt="icon">
                                    <img src="{{asset('assets/images/icons/sms-black.svg')}}" class="w-6 h-6 shrink-0 hidden group-focus-within:flex group-has-[:valid]:flex" alt="icon">
                                    <input type="email" name="email" value="{{ old('email') }}" class="appearance-none bg-transparent w-full outline-none text-lg leading-[27px] font-semibold placeholder:font-medium placeholder:text-aktiv-grey" placeholder="Write your email address" required>
                                </div>
                                @error('email')
                                <span class="text-red-500 text-sm absolute -bottom-6 left-0">{{ $message }}</span>
                                @enderror
                            </label>

                            <!-- Phone -->
                            <label class="flex flex-col gap-4 input-field-container relative">
                                <p class="font-medium text-aktiv-grey">Phone Number *</p>
                                <div class="group input-wrapper flex items-center rounded-xl p-4 gap-2 bg-[#FBFBFB] border border-transparent hover:border-aktiv-blue/20 focus-within:border-aktiv-blue/40 overflow-hidden transition-all duration-300">
                                    <img src="{{asset('assets/images/icons/call.svg')}}" class="w-6 h-6 flex shrink-0 group-focus-within:hidden group-has-[:valid]:hidden" alt="icon">
                                    <img src="{{asset('assets/images/icons/call-black.svg')}}" class="w-6 h-6 shrink-0 hidden group-focus-within:flex group-has-[:valid]:flex" alt="icon">
                                    <input type="tel" name="phone" value="{{ old('phone') }}" class="appearance-none bg-transparent w-full outline-none text-lg leading-[27px] font-semibold placeholder:font-medium placeholder:text-aktiv-grey" placeholder="Write your phone number" required>
                                </div>
                                @error('phone')
                                <span class="text-red-500 text-sm absolute -bottom-6 left-0">{{ $message }}</span>
                                @enderror
                            </label>

                            <!-- Company (Optional) -->
                            <label class="flex flex-col gap-4 input-field-container relative">
                                <p class="font-medium text-aktiv-grey">Company</p>
                                <div class="group input-wrapper flex items-center rounded-xl p-4 gap-2 bg-[#FBFBFB] border border-transparent hover:border-aktiv-blue/20 focus-within:border-aktiv-blue/40 overflow-hidden transition-all duration-300">
                                    <img src="{{asset('assets/images/icons/office-building.png')}}" class="w-6 h-6 flex shrink-0 group-focus-within:hidden group-has-[:valid]:hidden" alt="icon">
                                    <img src="{{asset('assets/images/icons/office-building.png')}}" class="w-6 h-6 shrink-0 hidden group-focus-within:flex group-has-[:valid]:flex opacity-80" alt="icon">
                                    <input type="text" name="company" value="{{ old('company') }}" class="appearance-none bg-transparent w-full outline-none text-lg leading-[27px] font-semibold placeholder:font-medium placeholder:text-aktiv-grey" placeholder="Company name (optional)">
                                </div>
                                @error('company')
                                <span class="text-red-500 text-sm absolute -bottom-6 left-0">{{ $message }}</span>
                                @enderror
                            </label>
                        </div>
                    </div>

                    <!-- Registration Options -->
                    <div class="flex flex-col gap-6 rounded-3xl p-8 bg-white shadow-sm hover:shadow-md transition-all duration-300">
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 rounded-full flex items-center justify-center shrink-0 bg-aktiv-green overflow-hidden">
                                <img src="{{asset('assets/images/icons/category.svg')}}" class="w-6 h-6 text-white" alt="icon">
                            </div>
                            <h2 class="font-Neue-Plak-bold text-2xl leading-[33px]">Registration Options</h2>
                        </div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Registration Category -->
                            <label class="flex flex-col gap-4 input-field-container relative">
                                <p class="font-medium text-aktiv-grey">Registration Category *</p>
                                <div class="group input-wrapper flex items-center rounded-xl p-4 gap-2 bg-[#FBFBFB] border border-transparent hover:border-aktiv-blue/20 focus-within:border-aktiv-blue/40 overflow-hidden transition-all duration-300">
                                    <img src="{{asset('assets/images/icons/category.svg')}}" class="w-6 h-6 flex shrink-0 group-focus-within:hidden group-has-[:valid]:hidden" alt="icon">
                                    <img src="{{asset('assets/images/icons/category-black.svg')}}" class="w-6 h-6 shrink-0 hidden group-focus-within:flex group-has-[:valid]:flex" alt="icon">
                                    <select name="kategori_pendaftaran" id="kategoriPendaftaran" class="appearance-none bg-transparent w-full outline-none text-lg leading-[27px] font-semibold placeholder:font-medium placeholder:text-aktiv-grey select-with-custom-arrow" required>
                                        <option value="" disabled {{ old('kategori_pendaftaran') ? '' : 'selected' }}>Choose registration category</option>
                                        <option value="observer" {{ old('kategori_pendaftaran') == 'observer' ? 'selected' : '' }}>Observer</option>
                                        <option value="kompetisi" {{ old('kategori_pendaftaran') == 'kompetisi' ? 'selected' : '' }}>Competition</option>
                                        <option value="undangan" {{ old('kategori_pendaftaran') == 'undangan' ? 'selected' : '' }}>Invitation</option>
                                    </select>
                                </div>
                                @error('kategori_pendaftaran')
                                <span class="text-red-500 text-sm absolute -bottom-6 left-0">{{ $message }}</span>
                                @enderror
                            </label>

                            <!-- Registration Type -->
                            <div class="flex flex-col gap-4">
                                <p class="font-medium text-aktiv-grey">Registration Type *</p>
                                <div class="flex gap-4">
                                    <label class="flex items-center gap-2 py-3 px-5 border border-[#E6E7EB] rounded-xl hover:border-aktiv-orange hover:bg-aktiv-orange/5 transition-all duration-300 cursor-pointer radio-container">
                                        <div class="radio-input-wrap relative w-6 h-6">
                                            <input type="radio" name="jenis_pendaftaran" value="individu" {{ old('jenis_pendaftaran', 'individu') == 'individu' ? 'checked' : '' }} class="custom-radio opacity-0 absolute inset-0 w-full h-full cursor-pointer z-10" id="registrationIndividu" onchange="toggleTeamMembers()">
                                            <div class="radio-custom"></div>
                                        </div>
                                        <span class="font-semibold">Individual</span>
                                    </label>
                                    <label class="flex items-center gap-2 py-3 px-5 border border-[#E6E7EB] rounded-xl hover:border-aktiv-orange hover:bg-aktiv-orange/5 transition-all duration-300 cursor-pointer radio-container">
                                        <div class="radio-input-wrap relative w-6 h-6">
                                            <input type="radio" name="jenis_pendaftaran" value="tim" {{ old('jenis_pendaftaran') == 'tim' ? 'checked' : '' }} class="custom-radio opacity-0 absolute inset-0 w-full h-full cursor-pointer z-10" id="registrationTim" onchange="toggleTeamMembers()">
                                            <div class="radio-custom"></div>
                                        </div>
                                        <span class="font-semibold">Team</span>
                                    </label>
                                </div>
                                @error('jenis_pendaftaran')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Team Members Section - Hidden by default -->
                    <div id="teamMembersSection" class="flex flex-col gap-6 rounded-3xl p-8 bg-white shadow-sm hover:shadow-md transition-all duration-300" style="display: none;">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-4">
                                <div class="w-12 h-12 rounded-full flex items-center justify-center shrink-0 bg-aktiv-orange overflow-hidden">
                                    <img src="{{asset('assets/images/icons/profile-2user.svg')}}" class="w-6 h-6 text-white" alt="icon">
                                </div>
                                <h2 class="font-Neue-Plak-bold text-2xl leading-[33px]">Team Members</h2>
                            </div>
                            <div class="flex items-center gap-2">
                                <button type="button" id="addMemberBtn" class="flex items-center gap-2 px-4 py-2 bg-aktiv-blue text-white rounded-lg hover:bg-aktiv-blue/90 transition-colors shadow-sm hover:shadow-md transition-all duration-300">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                    </svg>
                                    Add Member
                                </button>
                                <span class="text-sm text-aktiv-grey">Min. 3 members</span>
                            </div>
                        </div>
                        
                        <div class="alert-info p-4 rounded-lg bg-blue-50 border border-blue-200">
                            <div class="flex items-center gap-3">
                                <img src="{{asset('assets/images/icons/info.svg')}}" class="w-6 h-6 flex shrink-0 text-blue-600" alt="info">
                                <p class="font-medium text-blue-800">Please ensure you designate one team member as the team leader.</p>
                            </div>
                        </div>
                        
                        <div id="teamMembersContainer" class="flex flex-col gap-4">
                            <!-- Team members will be added here dynamically -->
                        </div>
                        
                        @error('team_members')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" class="w-full rounded-xl h-16 px-6 text-center bg-aktiv-orange font-semibold text-lg leading-[27px] text-white hover:bg-aktiv-orange/90 transition-colors shadow-sm hover:shadow-md transition-all duration-300">Continue to Payment</button>
                </form>
            </div>

            <!-- Sidebar - Event Summary -->
            <div class="lg:col-span-1">
                <div class="sticky top-8 flex flex-col gap-6 rounded-3xl p-8 bg-white shadow-lg hover:shadow-xl transition-all duration-300">
                    <div class="flex items-center gap-3">
                        <div class="flex w-12 h-12 rounded-full bg-aktiv-blue items-center justify-center">
                            <img src="{{asset('assets/images/icons/receipt-text.svg')}}" class="w-6 h-6 text-white" alt="summary">
                        </div>
                        <h3 class="font-Neue-Plak-bold text-xl">Registration Summary</h3>
                    </div>
                    
                    <!-- Event Image -->
                    <div class="flex w-full h-[200px] rounded-xl overflow-hidden relative group">
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
                                <p class="text-white font-semibold">{{ $event->nama }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Event Details -->
                    <div class="flex flex-col gap-4">
                        <h4 class="font-semibold text-lg text-aktiv-black">{{ $event->nama }}</h4>
                        
                        <div class="flex items-center gap-3 p-2 rounded-lg hover:bg-[#FBFBFB] transition-all duration-300">
                            <div class="w-8 h-8 flex items-center justify-center rounded-full bg-aktiv-blue/10">
                                <img src="{{asset('assets/images/icons/calendar.svg')}}" class="w-4 h-4 text-aktiv-blue" alt="icon">
                            </div>
                            <span class="font-medium text-aktiv-grey">{{ $event->tanggal->format('d F Y') }}</span>
                        </div>

                        @if($event->time_at)
                        <div class="flex items-center gap-3 p-2 rounded-lg hover:bg-[#FBFBFB] transition-all duration-300">
                            <div class="w-8 h-8 flex items-center justify-center rounded-full bg-aktiv-blue/10">
                                <img src="{{asset('assets/images/icons/clock.svg')}}" class="w-4 h-4 text-aktiv-blue" alt="icon">
                            </div>
                            <span class="font-medium text-aktiv-grey">{{ $event->time_at->format('H:i') }} WIB</span>
                        </div>
                        @endif

                        <div class="flex items-center gap-3 p-2 rounded-lg hover:bg-[#FBFBFB] transition-all duration-300">
                            <div class="w-8 h-8 flex items-center justify-center rounded-full bg-aktiv-blue/10">
                                <img src="{{asset('assets/images/icons/location.svg')}}" class="w-4 h-4 text-aktiv-blue" alt="icon">
                            </div>
                            <span class="font-medium text-aktiv-grey">{{ $event->lokasi }}</span>
                        </div>
                    </div>

                    <!-- Divider -->
                    <div class="border-t border-dashed border-[#E6E7EB] my-2"></div>

                    <!-- Price -->
                    <div class="flex flex-col gap-3">
                        <div class="flex items-center justify-between">
                            <span class="font-medium text-aktiv-grey">Registration Fee</span>
                            <span class="font-bold text-2xl text-aktiv-red">Rp{{ number_format($event->price ?? 0, 0, ',', '.') }}</span>
                        </div>
                        <p class="text-sm text-aktiv-grey">per person (including PPN 11%)</p>
                        
                        <div class="flex items-center gap-2 mt-2 bg-[#F0F9FF] rounded-lg p-3 border border-[#7DD3FC]">
                            <img src="{{asset('assets/images/icons/info.svg')}}" class="w-5 h-5 text-blue-500" alt="info">
                            <p class="text-sm text-blue-800">Team registrations are calculated per person.</p>
                        </div>
                    </div>

                    <!-- Terms -->
                    <div class="text-sm text-aktiv-grey mt-2">
                        <p class="mb-2 font-semibold">By registering, you agree to:</p>
                        <ul class="space-y-2">
                            <li class="flex items-center gap-2">
                                <div class="w-5 h-5 rounded-full flex items-center justify-center bg-aktiv-green/10">
                                    <div class="w-2 h-2 rounded-full bg-aktiv-green"></div>
                                </div>
                                <span>Event terms and conditions</span>
                            </li>
                            <li class="flex items-center gap-2">
                                <div class="w-5 h-5 rounded-full flex items-center justify-center bg-aktiv-green/10">
                                    <div class="w-2 h-2 rounded-full bg-aktiv-green"></div>
                                </div>
                                <span>Data privacy policy</span>
                            </li>
                            <li class="flex items-center gap-2">
                                <div class="w-5 h-5 rounded-full flex items-center justify-center bg-aktiv-green/10">
                                    <div class="w-2 h-2 rounded-full bg-aktiv-green"></div>
                                </div>
                                <span>Refund and cancellation policy</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection

@push('after-scripts')
<script>
    let memberCount = 0;
    
    // Toggle team members section based on registration type
    function toggleTeamMembers() {
        const teamMembersSection = document.getElementById('teamMembersSection');
        const registrationTim = document.getElementById('registrationTim');
        
        if (registrationTim.checked) {
            // Show with animation
            teamMembersSection.style.display = 'flex';
            teamMembersSection.classList.add('animate-fade-in');
            setTimeout(() => teamMembersSection.classList.remove('animate-fade-in'), 500);
            
            // Add default 3 members if none exist
            if (memberCount === 0) {
                for (let i = 0; i < 3; i++) {
                    addTeamMember();
                }
            }
        } else {
            // Hide with animation
            teamMembersSection.classList.add('animate-fade-out');
            setTimeout(() => {
                teamMembersSection.style.display = 'none';
                teamMembersSection.classList.remove('animate-fade-out');
                // Clear all team members
                clearAllMembers();
            }, 300);
        }
    }
    
    // Add team member form
    function addTeamMember() {
        const container = document.getElementById('teamMembersContainer');
        const memberDiv = document.createElement('div');
        memberDiv.className = 'team-member-item flex flex-col gap-4 p-6 border border-[#E6E7EB] rounded-xl hover:border-aktiv-blue/20 hover:shadow-sm transition-all duration-300 animate-slide-in';
        memberDiv.setAttribute('data-member-index', memberCount);
        
        memberDiv.innerHTML = `
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded-full bg-aktiv-blue/10 flex items-center justify-center">
                        <span class="font-semibold text-aktiv-blue member-number">${memberCount + 1}</span>
                    </div>
                    <h3 class="font-semibold text-lg">Member ${memberCount + 1}</h3>
                </div>
                <div class="flex items-center gap-3">
                    <!-- Enhanced Team Leader Checkbox - LARGER SIZE -->
                    <label class="flex items-center gap-3 py-2 px-3 rounded-lg hover:bg-aktiv-orange/5 transition-colors duration-200 cursor-pointer">
                        <div class="radio-input-wrap relative w-6 h-6">
                            <input type="checkbox" name="team_members[${memberCount}][is_ketua]" value="1" class="leader-checkbox custom-checkbox opacity-0 absolute inset-0 w-full h-full cursor-pointer z-10" onchange="handleLeaderChange(this)">
                            <div class="checkbox-custom leader-custom-checkbox"></div>
                        </div>
                        <span class="font-medium text-aktiv-grey">Team Leader</span>
                    </label>
                    ${memberCount >= 3 ? `
                    <button type="button" class="remove-member-btn flex items-center justify-center w-8 h-8 bg-red-500 text-white rounded-full hover:bg-red-600 transition-colors shadow-sm" onclick="removeMember(this)">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                    ` : ''}
                </div>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <!-- Name -->
                <label class="flex flex-col gap-2 relative">
                    <p class="font-medium text-aktiv-grey text-sm">Full Name *</p>
                    <div class="group input-wrapper flex items-center rounded-lg p-3 gap-2 bg-[#FBFBFB] border border-transparent hover:border-aktiv-blue/20 focus-within:border-aktiv-blue/40 overflow-hidden transition-all duration-300">
                        <img src="{{asset('assets/images/icons/profile-circle.svg')}}" class="w-5 h-5 flex shrink-0" alt="icon">
                        <input type="text" name="team_members[${memberCount}][nama]" class="appearance-none bg-transparent w-full outline-none text-base font-medium placeholder:text-aktiv-grey" placeholder="Full name" required>
                    </div>
                </label>
                
                <!-- Email -->
                <label class="flex flex-col gap-2 relative">
                    <p class="font-medium text-aktiv-grey text-sm">Email Address *</p>
                    <div class="group input-wrapper flex items-center rounded-lg p-3 gap-2 bg-[#FBFBFB] border border-transparent hover:border-aktiv-blue/20 focus-within:border-aktiv-blue/40 overflow-hidden transition-all duration-300">
                        <img src="{{asset('assets/images/icons/sms.svg')}}" class="w-5 h-5 flex shrink-0" alt="icon">
                        <input type="email" name="team_members[${memberCount}][email]" class="appearance-none bg-transparent w-full outline-none text-base font-medium placeholder:text-aktiv-grey" placeholder="Email address" required>
                    </div>
                </label>
                
                <!-- Phone -->
                <label class="flex flex-col gap-2 relative">
                    <p class="font-medium text-aktiv-grey text-sm">Phone Number *</p>
                    <div class="group input-wrapper flex items-center rounded-lg p-3 gap-2 bg-[#FBFBFB] border border-transparent hover:border-aktiv-blue/20 focus-within:border-aktiv-blue/40 overflow-hidden transition-all duration-300">
                        <img src="{{asset('assets/images/icons/call.svg')}}" class="w-5 h-5 flex shrink-0" alt="icon">
                        <input type="tel" name="team_members[${memberCount}][kontak]" class="appearance-none bg-transparent w-full outline-none text-base font-medium placeholder:text-aktiv-grey" placeholder="Phone number" required>
                    </div>
                </label>
            </div>
        `;
        
        container.appendChild(memberDiv);
        
        // Add animation removal after animation completes
        setTimeout(() => {
            memberDiv.classList.remove('animate-slide-in');
        }, 500);
        
        memberCount++;
        
        // Set first member as leader by default if no leader exists
        const allLeaderCheckboxes = document.querySelectorAll('.leader-checkbox');
        const hasLeader = Array.from(allLeaderCheckboxes).some(cb => cb.checked);
        if (!hasLeader && allLeaderCheckboxes.length > 0) {
            allLeaderCheckboxes[0].checked = true;
            updateLeaderStyles(allLeaderCheckboxes[0]);
        }
        
        updateMemberNumbers();
    }
    
    // Remove member
    function removeMember(button) {
        const memberItem = button.closest('.team-member-item');
        const wasLeader = memberItem.querySelector('.leader-checkbox').checked;
        
        // Add removal animation
        memberItem.classList.add('animate-slide-out');
        
        setTimeout(() => {
            memberItem.remove();
            memberCount--;
            
            // If removed member was leader, make first remaining member the leader
            if (wasLeader) {
                const remainingLeaderCheckboxes = document.querySelectorAll('.leader-checkbox');
                if (remainingLeaderCheckboxes.length > 0) {
                    remainingLeaderCheckboxes[0].checked = true;
                    updateLeaderStyles(remainingLeaderCheckboxes[0]);
                }
            }
            
            updateMemberNumbers();
            reindexMembers();
        }, 300);
    }
    
    // Handle leader change (only one leader allowed)
    function handleLeaderChange(checkbox) {
        if (checkbox.checked) {
            // Uncheck all other leader checkboxes
            const allLeaderCheckboxes = document.querySelectorAll('.leader-checkbox');
            allLeaderCheckboxes.forEach(cb => {
                if (cb !== checkbox) {
                    cb.checked = false;
                    updateLeaderStyles(cb);
                }
            });
            updateLeaderStyles(checkbox);
        } else {
            // Ensure at least one leader is selected
            const allLeaderCheckboxes = document.querySelectorAll('.leader-checkbox');
            const hasLeader = Array.from(allLeaderCheckboxes).some(cb => cb !== checkbox && cb.checked);
            
            if (!hasLeader) {
                checkbox.checked = true;
                updateLeaderStyles(checkbox);
                return;
            }
            
            updateLeaderStyles(checkbox);
        }
    }
    
    // Update leader checkbox styles
    function updateLeaderStyles(checkbox) {
        const memberItem = checkbox.closest('.team-member-item');
        if (checkbox.checked) {
            memberItem.classList.add('border-aktiv-orange', 'bg-aktiv-orange/5');
            // Update badge color to orange
            const badge = memberItem.querySelector('.w-8.h-8.rounded-full');
            if (badge) {
                badge.classList.remove('bg-aktiv-blue/10');
                badge.classList.add('bg-aktiv-orange/20');
            }
            // Update number color to orange
            const number = memberItem.querySelector('.member-number');
            if (number) {
                number.classList.remove('text-aktiv-blue');
                number.classList.add('text-aktiv-orange');
            }
        } else {
            memberItem.classList.remove('border-aktiv-orange', 'bg-aktiv-orange/5');
            // Reset badge color
            const badge = memberItem.querySelector('.w-8.h-8.rounded-full');
            if (badge) {
                badge.classList.add('bg-aktiv-blue/10');
                badge.classList.remove('bg-aktiv-orange/20');
            }
            // Reset number color
            const number = memberItem.querySelector('.member-number');
            if (number) {
                number.classList.add('text-aktiv-blue');
                number.classList.remove('text-aktiv-orange');
            }
        }
    }
    
    // Update member numbers in titles
    function updateMemberNumbers() {
        const memberItems = document.querySelectorAll('.team-member-item');
        memberItems.forEach((item, index) => {
            const title = item.querySelector('h3');
            title.textContent = `Member ${index + 1}`;
            
            const numberSpan = item.querySelector('.member-number');
            if (numberSpan) {
                numberSpan.textContent = index + 1;
            }
        });
    }
    
    // Reindex member form names after removal
    function reindexMembers() {
        const memberItems = document.querySelectorAll('.team-member-item');
        memberItems.forEach((item, index) => {
            item.setAttribute('data-member-index', index);
            
            // Update input names
            const inputs = item.querySelectorAll('input[name*="team_members"]');
            inputs.forEach(input => {
                const name = input.getAttribute('name');
                const newName = name.replace(/team_members\[\d+\]/, `team_members[${index}]`);
                input.setAttribute('name', newName);
            });
        });
        
        memberCount = memberItems.length;
    }
    
    // Clear all team members
    function clearAllMembers() {
        const container = document.getElementById('teamMembersContainer');
        container.innerHTML = '';
        memberCount = 0;
    }
    
    // Add member button event
    document.addEventListener('DOMContentLoaded', function() {
        const addMemberBtn = document.getElementById('addMemberBtn');
        if (addMemberBtn) {
            addMemberBtn.addEventListener('click', function() {
                addMemberBtn.classList.add('btn-pulse');
                setTimeout(() => addMemberBtn.classList.remove('btn-pulse'), 300);
                addTeamMember();
            });
        }
        
        // Initialize custom select arrows
        const selects = document.querySelectorAll('.select-with-custom-arrow');
        selects.forEach(select => {
            const wrapper = select.parentNode;
            wrapper.classList.add('relative');
            
            const arrowDown = document.createElement('div');
            arrowDown.className = 'absolute right-4 top-1/2 transform -translate-y-1/2 pointer-events-none';
            arrowDown.innerHTML = `
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-aktiv-grey" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                </svg>
            `;
            wrapper.appendChild(arrowDown);
            
            select.addEventListener('change', function() {
                if (this.value) {
                    this.classList.add('text-aktiv-black');
                } else {
                    this.classList.remove('text-aktiv-black');
                }
            });
        });
        
        toggleTeamMembers();
    });
</script>
@endpush

@push('after-styles')
<style>
/* Custom Radio Button Styling */
.radio-container {
    position: relative;
}

.radio-input-wrap {
    position: relative;
    display: inline-flex;
    align-items: center;
    justify-content: center;
}

.radio-custom {
    position: absolute;
    top: 0;
    left: 0;
    height: 100%;
    width: 100%;
    background-color: white;
    border: 2px solid #E6E7EB;
    border-radius: 50%;
    transition: all 0.2s ease;
}

.custom-radio:checked ~ .radio-custom {
    border-color: #FC9B4C;
    border-width: 6px;
}

/* Updated Custom Checkbox Styling */
.checkbox-custom {
    position: absolute;
    top: 0;
    left: 0;
    height: 100%;
    width: 100%;
    background-color: white;
    border: 2px solid #E6E7EB;
    border-radius: 6px; /* Slightly larger radius for better look */
    transition: all 0.2s ease;
}

.leader-checkbox:checked ~ .leader-custom-checkbox {
    background-color: #FC9B4C;
    border-color: #FC9B4C;
    display: flex;
    align-items: center;
    justify-content: center;
}

.leader-checkbox:checked ~ .leader-custom-checkbox:after {
    content: '';
    display: block;
    width: 38%; /* Slightly larger checkmark */
    height: 70%;
    border: solid white;
    border-width: 0 2.5px 2.5px 0; /* Thicker checkmark line */
    transform: rotate(45deg);
    margin-top: -2px;
}

/* Pulsing effect for the checkbox on hover */
.radio-input-wrap:hover .checkbox-custom {
    box-shadow: 0 0 0 2px rgba(252, 155, 76, 0.2);
}

/* Animation for checkbox when checked */
@keyframes checkmark-pop {
    0% { transform: scale(0.8); opacity: 0.5; }
    50% { transform: scale(1.1); }
    100% { transform: scale(1); opacity: 1; }
}

.leader-checkbox:checked ~ .leader-custom-checkbox {
    animation: checkmark-pop 0.3s ease-out forwards;
}

/* Input Field Container */
.input-field-container {
    min-height: 90px;
}

/* Animations */
@keyframes fadeIn {
    from { opacity: 0; transform: translateY(10px); }
    to { opacity: 1; transform: translateY(0); }
}

@keyframes fadeOut {
    from { opacity: 1; transform: translateY(0); }
    to { opacity: 0; transform: translateY(10px); }
}

@keyframes slideIn {
    from { opacity: 0; transform: translateX(-10px); }
    to { opacity: 1; transform: translateX(0); }
}

@keyframes slideOut {
    from { opacity: 1; transform: translateX(0); }
    to { opacity: 0; transform: translateX(-10px); }
}

@keyframes pulse {
    0% { transform: scale(1); }
    50% { transform: scale(1.05); }
    100% { transform: scale(1); }
}

.animate-fade-in {
    animation: fadeIn 0.4s ease forwards;
}

.animate-fade-out {
    animation: fadeOut 0.3s ease forwards;
}

.animate-slide-in {
    animation: slideIn 0.4s ease forwards;
}

.animate-slide-out {
    animation: slideOut 0.3s ease forwards;
}

.btn-pulse {
    animation: pulse 0.3s ease;
}

/* Custom Select Styling */
.select-with-custom-arrow {
    appearance: none;
    background: transparent;
    background-image: none;
    padding-right: 2rem;
}

/* Shadow Improvements */
.shadow-sm {
    box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);
}

.shadow-md {
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
}

.hover\:shadow-md:hover {
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
}

.hover\:shadow-lg:hover {
    box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
}
</style>
@endpush