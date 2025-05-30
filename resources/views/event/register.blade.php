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
                <a href="{{ route('front.index') }}" class="font-medium">Homepage</a>
                <span>></span>
                <a href="{{ route('event.index') }}" class="font-medium">Events</a>
                <span>></span>
                <a href="{{ route('event.show', $event->id) }}" class="font-medium">{{ $event->nama }}</a>
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
                    <div class="flex flex-col gap-6 rounded-3xl p-8 bg-white">
                        <h2 class="font-Neue-Plak-bold text-2xl leading-[33px]">Event Information</h2>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="flex flex-col gap-2">
                                <p class="font-medium text-aktiv-grey">Event Name</p>
                                <p class="font-semibold text-lg">{{ $event->nama }}</p>
                            </div>
                            <div class="flex flex-col gap-2">
                                <p class="font-medium text-aktiv-grey">Date</p>
                                <p class="font-semibold text-lg">{{ $event->tanggal->format('d F Y') }}</p>
                            </div>
                            @if($event->time_at)
                            <div class="flex flex-col gap-2">
                                <p class="font-medium text-aktiv-grey">Time</p>
                                <p class="font-semibold text-lg">{{ $event->time_at->format('H:i') }} WIB</p>
                            </div>
                            @endif
                            <div class="flex flex-col gap-2">
                                <p class="font-medium text-aktiv-grey">Location</p>
                                <p class="font-semibold text-lg">{{ $event->lokasi }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Personal Information -->
                    <div class="flex flex-col gap-6 rounded-3xl p-8 bg-white">
                        <h2 class="font-Neue-Plak-bold text-2xl leading-[33px]">Personal Information</h2>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Full Name -->
                            <label class="flex flex-col gap-4">
                                <p class="font-medium text-aktiv-grey">Full Name *</p>
                                <div class="group input-wrapper flex items-center rounded-xl p-4 gap-2 bg-[#FBFBFB] overflow-hidden">
                                    <img src="{{asset('assets/images/icons/profile-circle.svg')}}" class="w-6 h-6 flex shrink-0 group-focus-within:hidden group-has-[:valid]:hidden" alt="icon">
                                    <img src="{{asset('assets/images/icons/profile-circle-black.svg')}}" class="w-6 h-6 shrink-0 hidden group-focus-within:flex group-has-[:valid]:flex" alt="icon">
                                    <input type="text" name="name" value="{{ old('name') }}" class="appearance-none bg-transparent w-full outline-none text-lg leading-[27px] font-semibold placeholder:font-medium placeholder:text-aktiv-grey" placeholder="Write your complete name" required>
                                </div>
                                @error('name')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                                @enderror
                            </label>

                            <!-- Email -->
                            <label class="flex flex-col gap-4">
                                <p class="font-medium text-aktiv-grey">Email Address *</p>
                                <div class="group input-wrapper flex items-center rounded-xl p-4 gap-2 bg-[#FBFBFB] overflow-hidden">
                                    <img src="{{asset('assets/images/icons/sms.svg')}}" class="w-6 h-6 flex shrink-0 group-focus-within:hidden group-has-[:valid]:hidden" alt="icon">
                                    <img src="{{asset('assets/images/icons/sms-black.svg')}}" class="w-6 h-6 shrink-0 hidden group-focus-within:flex group-has-[:valid]:flex" alt="icon">
                                    <input type="email" name="email" value="{{ old('email') }}" class="appearance-none bg-transparent w-full outline-none text-lg leading-[27px] font-semibold placeholder:font-medium placeholder:text-aktiv-grey" placeholder="Write your email address" required>
                                </div>
                                @error('email')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                                @enderror
                            </label>

                            <!-- Phone -->
                            <label class="flex flex-col gap-4">
                                <p class="font-medium text-aktiv-grey">Phone Number *</p>
                                <div class="group input-wrapper flex items-center rounded-xl p-4 gap-2 bg-[#FBFBFB] overflow-hidden">
                                    <img src="{{asset('assets/images/icons/call.svg')}}" class="w-6 h-6 flex shrink-0 group-focus-within:hidden group-has-[:valid]:hidden" alt="icon">
                                    <img src="{{asset('assets/images/icons/call-black.svg')}}" class="w-6 h-6 shrink-0 hidden group-focus-within:flex group-has-[:valid]:flex" alt="icon">
                                    <input type="tel" name="phone" value="{{ old('phone') }}" class="appearance-none bg-transparent w-full outline-none text-lg leading-[27px] font-semibold placeholder:font-medium placeholder:text-aktiv-grey" placeholder="Write your phone number" required>
                                </div>
                                @error('phone')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                                @enderror
                            </label>

                            <!-- Company (Optional) -->
                            <label class="flex flex-col gap-4">
                                <p class="font-medium text-aktiv-grey">Company</p>
                                <div class="group input-wrapper flex items-center rounded-xl p-4 gap-2 bg-[#FBFBFB] overflow-hidden">
                                    <img src="{{asset('assets/images/icons/office-building.png')}}" class="w-6 h-6 flex shrink-0 group-focus-within:hidden group-has-[:valid]:hidden" alt="icon">
                                    <img src="{{asset('assets/images/icons/office-building.png')}}" class="w-6 h-6 shrink-0 hidden group-focus-within:flex group-has-[:valid]:flex" alt="icon">
                                    <input type="text" name="company" value="{{ old('company') }}" class="appearance-none bg-transparent w-full outline-none text-lg leading-[27px] font-semibold placeholder:font-medium placeholder:text-aktiv-grey" placeholder="Company name (optional)">
                                </div>
                                @error('company')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                                @enderror
                            </label>
                        </div>
                    </div>

                    <!-- Registration Options -->
                    <div class="flex flex-col gap-6 rounded-3xl p-8 bg-white">
                        <h2 class="font-Neue-Plak-bold text-2xl leading-[33px]">Registration Options</h2>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Registration Category -->
                            <label class="flex flex-col gap-4">
                                <p class="font-medium text-aktiv-grey">Registration Category *</p>
                                <div class="group input-wrapper flex items-center rounded-xl p-4 gap-2 bg-[#FBFBFB] overflow-hidden">
                                    <img src="{{asset('assets/images/icons/category.svg')}}" class="w-6 h-6 flex shrink-0 group-focus-within:hidden group-has-[:valid]:hidden" alt="icon">
                                    <img src="{{asset('assets/images/icons/category-black.svg')}}" class="w-6 h-6 shrink-0 hidden group-focus-within:flex group-has-[:valid]:flex" alt="icon">
                                    <select name="kategori_pendaftaran" id="kategoriPendaftaran" class="appearance-none bg-transparent w-full outline-none text-lg leading-[27px] font-semibold placeholder:font-medium placeholder:text-aktiv-grey" required>
                                        <option value="" disabled {{ old('kategori_pendaftaran') ? '' : 'selected' }}>Choose registration category</option>
                                        <option value="observer" {{ old('kategori_pendaftaran') == 'observer' ? 'selected' : '' }}>Observer</option>
                                        <option value="kompetisi" {{ old('kategori_pendaftaran') == 'kompetisi' ? 'selected' : '' }}>Competition</option>
                                        <option value="undangan" {{ old('kategori_pendaftaran') == 'undangan' ? 'selected' : '' }}>Invitation</option>
                                    </select>
                                </div>
                                @error('kategori_pendaftaran')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                                @enderror
                            </label>

                            <!-- Registration Type -->
                            <div class="flex flex-col gap-4">
                                <p class="font-medium text-aktiv-grey">Registration Type *</p>
                                <div class="flex gap-4">
                                    <label class="flex items-center gap-2 p-3 border border-[#E6E7EB] rounded-xl hover:border-aktiv-orange transition-colors">
                                        <input type="radio" name="jenis_pendaftaran" value="individu" {{ old('jenis_pendaftaran', 'individu') == 'individu' ? 'checked' : '' }} class="h-6 w-6 text-aktiv-orange" id="registrationIndividu" onchange="toggleTeamMembers()">
                                        <span class="font-semibold">Individual</span>
                                    </label>
                                    <label class="flex items-center gap-2 p-3 border border-[#E6E7EB] rounded-xl hover:border-aktiv-orange transition-colors">
                                        <input type="radio" name="jenis_pendaftaran" value="tim" {{ old('jenis_pendaftaran') == 'tim' ? 'checked' : '' }} class="h-6 w-6 text-aktiv-orange" id="registrationTim" onchange="toggleTeamMembers()">
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
                    <div id="teamMembersSection" class="flex flex-col gap-6 rounded-3xl p-8 bg-white" style="display: none;">
                        <div class="flex items-center justify-between">
                            <h2 class="font-Neue-Plak-bold text-2xl leading-[33px]">Team Members</h2>
                            <div class="flex items-center gap-2">
                                <button type="button" id="addMemberBtn" class="flex items-center gap-2 px-4 py-2 bg-aktiv-blue text-white rounded-lg hover:bg-aktiv-blue/90 transition-colors">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                    </svg>
                                    Add Member
                                </button>
                                <span class="text-sm text-aktiv-grey">Min. 3 members</span>
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
                    <button type="submit" class="w-full rounded-xl h-16 px-6 text-center bg-aktiv-orange font-semibold text-lg leading-[27px] text-white hover:bg-aktiv-orange/90 transition-colors">Continue to Payment</button>
                </form>
            </div>

            <!-- Sidebar - Event Summary -->
            <div class="lg:col-span-1">
                <div class="sticky top-8 flex flex-col gap-6 rounded-3xl p-8 bg-white shadow-lg">
                    <h3 class="font-Neue-Plak-bold text-xl">Registration Summary</h3>
                    
                    <!-- Event Image -->
                    <div class="flex w-full h-[200px] rounded-xl overflow-hidden">
                        @if($event->thumbnail)
                            <img src="{{ Storage::url($event->thumbnail) }}" class="w-full h-full object-cover" alt="{{ $event->nama }}">
                        @else
                            <div class="w-full h-full bg-gradient-to-br from-aktiv-blue to-aktiv-orange flex items-center justify-center">
                                <span class="text-white text-4xl font-bold">{{ substr($event->nama, 0, 1) }}</span>
                            </div>
                        @endif
                    </div>

                    <!-- Event Details -->
                    <div class="flex flex-col gap-4">
                        <h4 class="font-semibold text-lg">{{ $event->nama }}</h4>
                        
                        <div class="flex items-center gap-3">
                            <img src="{{asset('assets/images/icons/calendar.svg')}}" class="w-5 h-5 flex shrink-0" alt="icon">
                            <span class="font-medium text-aktiv-grey">{{ $event->tanggal->format('d F Y') }}</span>
                        </div>

                        @if($event->time_at)
                        <div class="flex items-center gap-3">
                            <img src="{{asset('assets/images/icons/clock.svg')}}" class="w-5 h-5 flex shrink-0" alt="icon">
                            <span class="font-medium text-aktiv-grey">{{ $event->time_at->format('H:i') }} WIB</span>
                        </div>
                        @endif

                        <div class="flex items-center gap-3">
                            <img src="{{asset('assets/images/icons/location.svg')}}" class="w-5 h-5 flex shrink-0" alt="icon">
                            <span class="font-medium text-aktiv-grey">{{ $event->lokasi }}</span>
                        </div>
                    </div>

                    <!-- Divider -->
                    <div class="border-t border-[#E6E7EB]"></div>

                    <!-- Price -->
                    <div class="flex flex-col gap-2">
                        <div class="flex items-center justify-between">
                            <span class="font-medium text-aktiv-grey">Registration Fee</span>
                            <span class="font-semibold text-2xl text-aktiv-red">Rp{{ number_format($event->price ?? 0, 0, ',', '.') }}</span>
                        </div>
                        <p class="text-sm text-aktiv-grey">per person (including PPN 11%)</p>
                    </div>

                    <!-- Terms -->
                    <div class="text-sm text-aktiv-grey">
                        <p class="mb-2">By registering, you agree to:</p>
                        <ul class="list-disc list-inside space-y-1">
                            <li>Event terms and conditions</li>
                            <li>Data privacy policy</li>
                            <li>Refund and cancellation policy</li>
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
            teamMembersSection.style.display = 'block';
            // Add default 3 members if none exist
            if (memberCount === 0) {
                for (let i = 0; i < 3; i++) {
                    addTeamMember();
                }
            }
        } else {
            teamMembersSection.style.display = 'none';
            // Clear all team members
            clearAllMembers();
        }
    }
    
    // Add team member form
    function addTeamMember() {
        const container = document.getElementById('teamMembersContainer');
        const memberDiv = document.createElement('div');
        memberDiv.className = 'team-member-item flex flex-col gap-4 p-6 border border-[#E6E7EB] rounded-xl';
        memberDiv.setAttribute('data-member-index', memberCount);
        
        memberDiv.innerHTML = `
            <div class="flex items-center justify-between">
                <h3 class="font-semibold text-lg">Member ${memberCount + 1}</h3>
                <div class="flex items-center gap-2">
                    <label class="flex items-center gap-2">
                        <input type="checkbox" name="team_members[${memberCount}][is_ketua]" value="1" class="h-4 w-4 text-aktiv-orange leader-checkbox" onchange="handleLeaderChange(this)">
                        <span class="text-sm font-medium text-aktiv-grey">Team Leader</span>
                    </label>
                    ${memberCount >= 3 ? `
                    <button type="button" class="remove-member-btn flex items-center justify-center w-8 h-8 bg-red-500 text-white rounded-full hover:bg-red-600 transition-colors" onclick="removeMember(this)">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                    ` : ''}
                </div>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <!-- Name -->
                <label class="flex flex-col gap-2">
                    <p class="font-medium text-aktiv-grey text-sm">Full Name *</p>
                    <div class="group input-wrapper flex items-center rounded-lg p-3 gap-2 bg-[#FBFBFB] overflow-hidden">
                        <img src="{{asset('assets/images/icons/profile-circle.svg')}}" class="w-5 h-5 flex shrink-0" alt="icon">
                        <input type="text" name="team_members[${memberCount}][nama]" class="appearance-none bg-transparent w-full outline-none text-base font-medium placeholder:text-aktiv-grey" placeholder="Full name" required>
                    </div>
                </label>
                
                <!-- Email -->
                <label class="flex flex-col gap-2">
                    <p class="font-medium text-aktiv-grey text-sm">Email Address *</p>
                    <div class="group input-wrapper flex items-center rounded-lg p-3 gap-2 bg-[#FBFBFB] overflow-hidden">
                        <img src="{{asset('assets/images/icons/sms.svg')}}" class="w-5 h-5 flex shrink-0" alt="icon">
                        <input type="email" name="team_members[${memberCount}][email]" class="appearance-none bg-transparent w-full outline-none text-base font-medium placeholder:text-aktiv-grey" placeholder="Email address" required>
                    </div>
                </label>
                
                <!-- Phone -->
                <label class="flex flex-col gap-2">
                    <p class="font-medium text-aktiv-grey text-sm">Phone Number *</p>
                    <div class="group input-wrapper flex items-center rounded-lg p-3 gap-2 bg-[#FBFBFB] overflow-hidden">
                        <img src="{{asset('assets/images/icons/call.svg')}}" class="w-5 h-5 flex shrink-0" alt="icon">
                        <input type="tel" name="team_members[${memberCount}][kontak]" class="appearance-none bg-transparent w-full outline-none text-base font-medium placeholder:text-aktiv-grey" placeholder="Phone number" required>
                    </div>
                </label>
            </div>
        `;
        
        container.appendChild(memberDiv);
        memberCount++;
        
        // Set first member as leader by default if no leader exists
        const allLeaderCheckboxes = document.querySelectorAll('.leader-checkbox');
        const hasLeader = Array.from(allLeaderCheckboxes).some(cb => cb.checked);
        if (!hasLeader && allLeaderCheckboxes.length > 0) {
            allLeaderCheckboxes[0].checked = true;
        }
        
        updateMemberNumbers();
    }
    
    // Remove team member
    function removeMember(button) {
        const memberItem = button.closest('.team-member-item');
        const wasLeader = memberItem.querySelector('.leader-checkbox').checked;
        
        memberItem.remove();
        memberCount--;
        
        // If removed member was leader, make first remaining member the leader
        if (wasLeader) {
            const remainingLeaderCheckboxes = document.querySelectorAll('.leader-checkbox');
            if (remainingLeaderCheckboxes.length > 0) {
                remainingLeaderCheckboxes[0].checked = true;
            }
        }
        
        updateMemberNumbers();
        reindexMembers();
    }
    
    // Handle leader change (only one leader allowed)
    function handleLeaderChange(checkbox) {
        if (checkbox.checked) {
            // Uncheck all other leader checkboxes
            const allLeaderCheckboxes = document.querySelectorAll('.leader-checkbox');
            allLeaderCheckboxes.forEach(cb => {
                if (cb !== checkbox) {
                    cb.checked = false;
                }
            });
        }
    }
    
    // Update member numbers in titles
    function updateMemberNumbers() {
        const memberItems = document.querySelectorAll('.team-member-item');
        memberItems.forEach((item, index) => {
            const title = item.querySelector('h3');
            title.textContent = `Member ${index + 1}`;
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
    document.getElementById('addMemberBtn').addEventListener('click', addTeamMember);
    
    // Initialize on page load
    document.addEventListener('DOMContentLoaded', function() {
        toggleTeamMembers();
    });
</script>
@endpush