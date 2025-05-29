@extends('layout.app')
@section('title')
Pendaftaran Event {{ $event->nama ?? 'Event' }}
@endsection
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
            <p class="font-bold text-[32px] leading-[48px] capitalize text-white">Event Registration</p>
            <div class="flex items-center gap-2 text-white">
                <a href="{{ route('front.index') }}" class="font-medium">Homepage</a>
                <span>></span>
                <a href="{{ route('event.index') }}" class="font-medium">Events</a>
                <span>></span>
                @if(isset($event))
                <a href="{{ route('event.show', $event->id) }}" class="font-medium">Event Details</a>
                <span>></span>
                @endif
                <a class="last:font-semibold">Event Registration</a>
            </div>
        </div>

        <!-- Main Form Section -->
        <main class="flex gap-8">
            <!-- Sidebar - Event Info Section -->
            <section id="Sidebar" class="group flex flex-col w-[420px] h-fit rounded-3xl p-8 bg-white">
                <div class="flex flex-col gap-4">
                    <h2 class="font-Neue-Plak-bold text-xl leading-[27.5px]">Event Details</h2>
                    
                    @if(isset($event))
                    <div class="thumbnail-container relative h-[240px] rounded-xl bg-[#D9D9D9] overflow-hidden">
                        <img src="{{ Storage::url($event->thumbnail) }}" class="w-full h-full object-cover" alt="thumbnail">
                        
                        <!-- Status Badge -->
                        @if ($event->is_open)
                            @if ($event->has_started)
                            <div class="absolute top-3 left-3 flex items-center rounded-full py-3 px-5 gap-1 bg-aktiv-orange text-white z-10">
                                <img src="{{asset('assets/images/icons/timer-start.svg')}}" class="w-6 h-6" alt="icon">
                                <span class="font-semibold">ONGOING</span>
                            </div>
                            @else
                            <div class="absolute top-3 left-3 flex items-center rounded-full py-3 px-5 gap-1 bg-aktiv-green text-white z-10">
                                <img src="{{asset('assets/images/icons/medal-star.svg')}}" class="w-6 h-6" alt="icon">
                                <span class="font-semibold">OPEN</span>
                            </div>
                            @endif
                        @endif
                    </div>
                    
                    <!-- Event Card Details -->
                    <div class="card-detail flex flex-col gap-2">
                        <div class="flex items-center gap-3">
                            <div class="flex items-center gap-1">
                                <img src="{{asset('assets/images/icons/calendar-2.svg')}}" class="w-6 h-6 flex shrink-0" alt="icon">
                                <span class="font-medium text-aktiv-grey">
                                    {{ \Carbon\Carbon::parse($event->tanggal)->translatedFormat('d F Y') }}
                                </span>
                            </div>
                            <div class="flex items-center gap-1">
                                <img src="{{asset('assets/images/icons/timer.svg')}}" class="w-6 h-6 flex shrink-0" alt="icon">
                                <span class="font-medium text-aktiv-grey">
                                    {{ $event->time_at ? \Carbon\Carbon::parse($event->time_at)->format('H:i A') : '00:00' }}
                                </span>
                            </div>
                        </div>
                        <h3 class="font-Neue-Plak-bold text-xl">
                            {{ $event->nama }}
                        </h3>
                        <p class="font-medium text-aktiv-grey">
                            {{ $event->lokasi }}
                        </p>
                    </div>
                    @endif
                </div>

                <!-- Collapsible Event Information -->
                <div id="closes-section" class="accordion flex flex-col gap-8 transition-all duration-300 mt-8 group-has-[:checked]:mt-0 group-has-[:checked]:!h-0 overflow-hidden">
                    <!-- Event Organizer -->
                    <div class="flex flex-col gap-4">
                        <h2 class="font-Neue-Plak-bold text-xl leading-[27.5px]">Event Organizer</h2>
                        <div class="flex items-center gap-3 rounded-xl border border-[#E6E7EB] p-4">
                            <div class="flex w-16 h-16 shrink-0 rounded-full overflow-hidden bg-aktiv-blue items-center justify-center">
                                <img src="{{asset('assets/images/icons/medal-star.svg')}}" class="w-10 h-10 text-white" alt="icon">
                            </div>
                            <div class="flex flex-col gap-[2px] flex-1">
                                <p class="font-semibold text-lg leading-[27px]">
                                    PT Wahana Kendali Mutu
                                </p>
                                <p class="font-medium text-aktiv-grey">
                                    Quality Control Training Company
                                </p>
                            </div>
                            <img src="{{asset('assets/images/icons/verify.svg')}}" class="flex w-[62px] h-[62px] shrink-0" alt="icon">
                        </div>
                    </div>

                    <!-- Event Price -->
                    @if(isset($event) && $event->price)
                    <div class="flex flex-col gap-4">
                        <h2 class="font-Neue-Plak-bold text-xl leading-[27.5px]">Registration Fee</h2>
                        <div class="flex items-center gap-[6px]">
                            <p class="font-bold text-[32px] leading-[48px] text-aktiv-red">
                                Rp{{ number_format($event->price, 0, ',', '.') }}
                            </p>
                            <p class="font-semibold text-aktiv-grey">/person</p>
                        </div>
                    </div>
                    @endif

                    <!-- Event Benefits -->
                    @if(isset($event) && $event->benefits && count($event->benefits) > 0)
                    <div class="flex flex-col gap-4">
                        <h2 class="font-Neue-Plak-bold text-xl leading-[27.5px]">What You'll Get</h2>
                        <div class="flex flex-col gap-6">
                            @forelse ($event->benefits as $benefit)
                            <div class="flex items-center gap-2">
                                <img src="{{asset('assets/images/icons/tick-circle.svg')}}" class="w-6 h-6 flex shrink-0" alt="icon">
                                <p class="font-semibold text-lg leading-[27px]">{{ $benefit->name }}</p>
                            </div>
                            @empty
                                <p class="font-medium text-aktiv-grey">No benefits information available.</p>
                            @endforelse
                        </div>
                    </div>
                    @endif

                    <!-- Location Details -->
                    @if(isset($event) && $event->lokasi)
                    <div class="flex flex-col gap-4">
                        <h2 class="font-Neue-Plak-bold text-xl leading-[27.5px]">Location Details</h2>
                        <div class="flex flex-col gap-4 rounded-xl border border-[#E6E7EB] p-5 pb-[21px]">
                            @if($event->venue_thumbnail)
                            <div class="flex w-full h-[180px] rounded-xl overflow-hidden">
                                <img src="{{ Storage::url($event->venue_thumbnail) }}" class="w-full h-full object-cover" alt="location">
                            </div>
                            @endif
                            <div class="flex flex-col gap-3">
                                <p class="font-medium leading-[25.6px] text-aktiv-grey">
                                    {{ $event->lokasi }}
                                </p>
                                <a href="http://maps.google.com/?q={{ urlencode($event->lokasi) }}" class="font-semibold text-aktiv-orange">View in Google Maps</a>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>

                <!-- Show/Hide Toggle Button -->
                <label class="group mt-8">
                    <input type="checkbox" class="hidden">
                    <p class="before:content-['Show_Less'] group-has-[:checked]:before:content-['Show_More'] before:font-semibold before:text-lg before:leading-[27px] flex items-center justify-center gap-[6px]">
                        <img src="{{asset('assets/images/icons/arrow-up.svg')}}" class="w-6 h-6 group-has-[:checked]:rotate-180 transition-all duration-300" alt="icon">
                    </p>
                </label>
            </section>

            <!-- Registration Form -->
            <form id="registrationForm" method="POST" action="{{ route('event.register.store') }}" class="flex flex-col w-[724px] gap-8">
                @csrf
                
                <!-- Debug Information (Remove in production) -->
                @if(config('app.debug'))
                <div class="text-xs text-gray-500 p-2 bg-gray-100 rounded">
                    Debug: Form action = {{ route('event.register.store') }}
                </div>
                @endif
                
                <!-- Security Message -->
                <div class="flex items-center rounded-3xl p-8 gap-4 bg-white">
                    <img src="{{asset('assets/images/icons/shield-tick.svg')}}" class="w-[62px] h-[62px] flex shrink-0" alt="icon">
                    <div class="flex flex-col gap-[2px]">
                        <p class="font-semibold text-lg leading-[27px]">Safe Security Pro Max+</p>
                        <p class="font-medium text-aktiv-grey">Don't worry, Your data will be kept private and protected.</p>
                    </div>
                </div>

                <!-- Personal Information Section -->
                <div class="flex flex-col rounded-3xl p-8 gap-4 bg-white">
                    <h2 class="font-Neue-Plak-bold text-xl leading-[27.5px]">Personal Information</h2>
                    <div class="flex flex-col gap-6">
                        <!-- Warning Message -->
                        <p class="w-full border-l-[5px] border-aktiv-red py-4 px-3 bg-[linear-gradient(270deg,rgba(235,87,87,0)_0%,rgba(235,87,87,0.09)_100%)] font-semibold text-aktiv-red">Please enter data correctly. We will send the confirmation to your email.</p>
                        
                        <!-- Error Messages Display -->
                        @if ($errors->any())
                        <div class="flex flex-col gap-2 p-4 bg-[#FEE3E3] rounded-xl">
                            <p class="font-semibold text-aktiv-red">There are errors in the form:</p>
                            <ul class="list-disc pl-5">
                                @foreach ($errors->all() as $error)
                                    <li class="text-aktiv-red">{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                        @endif

                        <!-- Success Message Display -->
                        @if (session('success'))
                        <div class="flex flex-col gap-2 p-4 bg-[#D4EAE8] rounded-xl">
                            <p class="font-semibold text-aktiv-green">{{ session('success') }}</p>
                        </div>
                        @endif

                        <!-- Event Selection (hidden field to store event_id) -->
                        <input type="hidden" name="event_id" value="{{ $event->id ?? request()->get('event_id', '') }}">

                        <!-- Full Name -->
                        <label class="flex flex-col gap-4">
                            <p class="font-medium text-aktiv-grey">Full Name</p>
                            <div class="group input-wrapper flex items-center rounded-xl p-4 gap-2 bg-[#FBFBFB] overflow-hidden">
                                <img src="{{asset('assets/images/icons/profile-circle.svg')}}" class="w-6 h-6 flex shrink-0 group-focus-within:hidden group-has-[:valid]:hidden" alt="icon">
                                <img src="{{asset('assets/images/icons/profile-circle-black.svg')}}" class="w-6 h-6 shrink-0 hidden group-focus-within:flex group-has-[:valid]:flex" alt="icon">
                                <input type="text" name="name" id="name" value="{{ old('name') }}" class="appearance-none bg-transparent w-full outline-none text-lg leading-[27px] font-semibold placeholder:font-medium placeholder:text-aktiv-grey" placeholder="Write your complete name" required>
                            </div>
                        </label>

                        <!-- Phone Number -->
                        <label class="flex flex-col gap-4">
                            <p class="font-medium text-aktiv-grey">Phone Number</p>
                            <div class="group input-wrapper flex items-center rounded-xl p-4 gap-2 bg-[#FBFBFB] overflow-hidden">
                                <img src="{{asset('assets/images/icons/call.svg')}}" class="w-6 h-6 flex shrink-0 group-focus-within:hidden group-has-[:valid]:hidden" alt="icon">
                                <img src="{{asset('assets/images/icons/call-black.svg')}}" class="w-6 h-6 shrink-0 hidden group-focus-within:flex group-has-[:valid]:flex" alt="icon">
                                <input type="tel" name="phone" id="phone" value="{{ old('phone') }}" class="appearance-none bg-transparent w-full outline-none text-lg leading-[27px] font-semibold placeholder:font-medium placeholder:text-aktiv-grey" placeholder="Give us your phone number" required>
                            </div>
                        </label>

                        <!-- Email Address -->
                        <label class="flex flex-col gap-4">
                            <p class="font-medium text-aktiv-grey">Email Address</p>
                            <div class="group input-wrapper flex items-center rounded-xl p-4 gap-2 bg-[#FBFBFB] overflow-hidden">
                                <img src="{{asset('assets/images/icons/sms.svg')}}" class="w-6 h-6 flex shrink-0 group-focus-within:hidden group-has-[:valid]:hidden" alt="icon">
                                <img src="{{asset('assets/images/icons/sms-black.svg')}}" class="w-6 h-6 shrink-0 hidden group-focus-within:flex group-has-[:valid]:flex" alt="icon">
                                <input type="email" name="email" id="email" value="{{ old('email') }}" class="appearance-none bg-transparent w-full outline-none text-lg leading-[27px] font-semibold placeholder:font-medium placeholder:text-aktiv-grey" placeholder="Write your email address" required>
                            </div>
                        </label>

                        <!-- Company -->
                        <label class="flex flex-col gap-4">
                            <p class="font-medium text-aktiv-grey">Company</p>
                            <div class="group input-wrapper flex items-center rounded-xl p-4 gap-2 bg-[#FBFBFB] overflow-hidden">
                                <img src="{{asset('assets/images/icons/office-building.png')}}" class="w-6 h-6 flex shrink-0 group-focus-within:hidden group-has-[:valid]:hidden" alt="icon">
                                <img src="{{asset('assets/images/icons/office-building.png')}}" class="w-6 h-6 shrink-0 hidden group-focus-within:flex group-has-[:valid]:flex" alt="icon">
                                <input type="text" name="company" id="company" value="{{ old('company') }}" class="appearance-none bg-transparent w-full outline-none text-lg leading-[27px] font-semibold placeholder:font-medium placeholder:text-aktiv-grey" placeholder="Your company name">
                            </div>
                        </label>
                    </div>
                </div>

                <!-- Registration Details Section -->
                <div class="flex flex-col rounded-3xl p-8 gap-8 bg-white">
                    <div class="flex flex-col gap-4">
                        <h2 class="font-Neue-Plak-bold text-xl leading-[27.5px]">Registration Information</h2>
                        <div class="flex flex-col gap-6">
                            <!-- Kategori Pendaftaran Dropdown -->
                            <label class="flex flex-col gap-4">
                                <p class="font-medium text-aktiv-grey">Registration Category</p>
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
                            </label>

                            <!-- Jenis Pendaftaran Radio Buttons -->
                            <div class="flex flex-col gap-4">
                                <p class="font-medium text-aktiv-grey">Registration Type</p>
                                <div class="flex gap-4">
                                    <label class="flex items-center gap-2 p-3 border border-[#E6E7EB] rounded-xl hover:border-aktiv-orange transition-colors">
                                        <input type="radio" name="jenis_pendaftaran" value="individu" {{ old('jenis_pendaftaran', 'individu') == 'individu' ? 'checked' : '' }} class="h-6 w-6 text-aktiv-orange">
                                        <span class="font-semibold">Individual</span>
                                    </label>
                                    <label class="flex items-center gap-2 p-3 border border-[#E6E7EB] rounded-xl hover:border-aktiv-orange transition-colors">
                                        <input type="radio" name="jenis_pendaftaran" value="tim" {{ old('jenis_pendaftaran') == 'tim' ? 'checked' : '' }} class="h-6 w-6 text-aktiv-orange">
                                        <span class="font-semibold">Team</span>
                                    </label>
                                </div>
                            </div>

                            <!-- Status Pembayaran (Hidden - Default pending) -->
                            <input type="hidden" name="payment_status" value="pending">
                        </div>
                    </div>

                    <!-- Team Members Section - Only visible when Tim is selected -->
                    <div id="teamMembersSection" class="flex flex-col gap-4" style="display: {{ old('jenis_pendaftaran') == 'tim' ? 'flex' : 'none' }};">
                        <h2 class="font-Neue-Plak-bold text-xl leading-[27.5px]">Team Members Details</h2>
                        <div class="flex flex-col gap-6">
                            <p class="w-full border-l-[5px] border-aktiv-green py-4 px-3 bg-aktiv-green/[9%] font-semibold text-aktiv-green">
                                Minimum 3 members with 1 team leader required.
                            </p>
                            
                            <!-- Container for team members, will be populated dynamically -->
                            <div id="teamMembersContainer" class="flex flex-col gap-6">
                                <!-- Dynamic team members will be inserted here -->
                            </div>
                            
                            <!-- Button to add more team members -->
                            <button type="button" id="addMemberBtn" class="flex items-center justify-center w-full p-4 rounded-xl border border-[#E6E7EB] gap-2 hover:border-aktiv-orange transition-colors">
                                <img src="{{asset('assets/images/icons/add.svg')}}" alt="Add Member">
                                <span class="font-semibold">Add Team Member</span>
                            </button>
                            
                            <!-- Error message for team validation -->
                            <div id="teamValidationError" class="hidden font-medium text-aktiv-red"></div>
                        </div>
                    </div>

                    <!-- Google Drive Links - Only visible for kompetisi + approved -->
                    <div id="googleDriveSection" class="flex flex-col gap-4" style="display: none;">
                        <h2 class="font-Neue-Plak-bold text-xl leading-[27.5px]">Document Upload</h2>
                        <div class="flex flex-col gap-6">
                            <p class="w-full border-l-[5px] border-aktiv-blue py-4 px-3 bg-[#DFEFFF] font-semibold text-aktiv-blue">
                                Please provide Google Drive links for the following documents:
                            </p>
                            
                            <!-- Makalah Link -->
                            <label class="flex flex-col gap-4">
                                <p class="font-medium text-aktiv-grey">Paper Google Drive Link</p>
                                <div class="group input-wrapper flex items-center rounded-xl p-4 gap-2 bg-[#FBFBFB] overflow-hidden">
                                    <img src="{{asset('assets/images/icons/document.svg')}}" class="w-6 h-6 flex shrink-0 group-focus-within:hidden group-has-[:valid]:hidden" alt="icon">
                                    <img src="{{asset('assets/images/icons/document-black.svg')}}" class="w-6 h-6 shrink-0 hidden group-focus-within:flex group-has-[:valid]:flex" alt="icon">
                                    <input type="url" name="google_drive_makalah" value="{{ old('google_drive_makalah') }}" class="appearance-none bg-transparent w-full outline-none text-lg leading-[27px] font-semibold placeholder:font-medium placeholder:text-aktiv-grey" placeholder="https://drive.google.com/...">
                                </div>
                            </label>
                            
                            <!-- Lampiran Link -->
                            <label class="flex flex-col gap-4">
                                <p class="font-medium text-aktiv-grey">Attachment Google Drive Link</p>
                                <div class="group input-wrapper flex items-center rounded-xl p-4 gap-2 bg-[#FBFBFB] overflow-hidden">
                                    <img src="{{asset('assets/images/icons/document.svg')}}" class="w-6 h-6 flex shrink-0 group-focus-within:hidden group-has-[:valid]:hidden" alt="icon">
                                    <img src="{{asset('assets/images/icons/document-black.svg')}}" class="w-6 h-6 shrink-0 hidden group-focus-within:flex group-has-[:valid]:flex" alt="icon">
                                    <input type="url" name="google_drive_lampiran" value="{{ old('google_drive_lampiran') }}" class="appearance-none bg-transparent w-full outline-none text-lg leading-[27px] font-semibold placeholder:font-medium placeholder:text-aktiv-grey" placeholder="https://drive.google.com/...">
                                </div>
                            </label>
                            
                            <!-- Video Sebelum Link -->
                            <label class="flex flex-col gap-4">
                                <p class="font-medium text-aktiv-grey">Before Video Google Drive Link</p>
                                <div class="group input-wrapper flex items-center rounded-xl p-4 gap-2 bg-[#FBFBFB] overflow-hidden">
                                    <img src="{{asset('assets/images/icons/video.svg')}}" class="w-6 h-6 flex shrink-0 group-focus-within:hidden group-has-[:valid]:hidden" alt="icon">
                                    <img src="{{asset('assets/images/icons/video-black.svg')}}" class="w-6 h-6 shrink-0 hidden group-focus-within:flex group-has-[:valid]:flex" alt="icon">
                                    <input type="url" name="google_drive_video_sebelum" value="{{ old('google_drive_video_sebelum') }}" class="appearance-none bg-transparent w-full outline-none text-lg leading-[27px] font-semibold placeholder:font-medium placeholder:text-aktiv-grey" placeholder="https://drive.google.com/...">
                                </div>
                            </label>
                            
                            <!-- Video Sesudah Link -->
                            <label class="flex flex-col gap-4">
                                <p class="font-medium text-aktiv-grey">After Video Google Drive Link</p>
                                <div class="group input-wrapper flex items-center rounded-xl p-4 gap-2 bg-[#FBFBFB] overflow-hidden">
                                    <img src="{{asset('assets/images/icons/video.svg')}}" class="w-6 h-6 flex shrink-0 group-focus-within:hidden group-has-[:valid]:hidden" alt="icon">
                                    <img src="{{asset('assets/images/icons/video-black.svg')}}" class="w-6 h-6 shrink-0 hidden group-focus-within:flex group-has-[:valid]:flex" alt="icon">
                                    <input type="url" name="google_drive_video_sesudah" value="{{ old('google_drive_video_sesudah') }}" class="appearance-none bg-transparent w-full outline-none text-lg leading-[27px] font-semibold placeholder:font-medium placeholder:text-aktiv-grey" placeholder="https://drive.google.com/...">
                                </div>
                            </label>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" class="w-full rounded-xl h-16 px-6 text-center bg-aktiv-orange font-semibold text-lg leading-[27px] text-white hover:bg-aktiv-orange/90 transition-colors">Continue to Payment</button>
                </div>
            </form>
        </main>
    </div>
</section>

@endsection

@push('after-scripts')
<script>
    // Define the base URL for assets using the current URL path to public directory
    const assetBaseUrl = "{{ url('/') }}/";
</script>
<script src="{{ asset('js/accodion.js') }}"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        console.log('Event registration form loaded');
        
        // Element references
        const jenisPendaftaranRadios = document.querySelectorAll('input[name="jenis_pendaftaran"]');
        const teamMembersSection = document.getElementById('teamMembersSection');
        const teamMembersContainer = document.getElementById('teamMembersContainer');
        const addMemberBtn = document.getElementById('addMemberBtn');
        const teamValidationError = document.getElementById('teamValidationError');
        const kategoriPendaftaran = document.getElementById('kategoriPendaftaran');
        const googleDriveSection = document.getElementById('googleDriveSection');
        
        // Counter for team members
        let memberCount = 0;
        
        // Initialize with default values
        function initialize() {
            console.log('Initializing form...');
            
            // Check current selection
            const selectedJenis = document.querySelector('input[name="jenis_pendaftaran"]:checked')?.value || 'individu';
            console.log('Selected jenis:', selectedJenis);
            
            if (selectedJenis === 'tim') {
                teamMembersSection.style.display = 'flex';
                // Add initial 3 members if container is empty
                if (teamMembersContainer.children.length === 0) {
                    for (let i = 0; i < 3; i++) {
                        addTeamMember();
                    }
                }
            }
            
            // Check if we need to show Google Drive section
            toggleGoogleDriveSection();
        }
        
        // Toggle team members section visibility based on jenis pendaftaran selection
        jenisPendaftaranRadios.forEach(radio => {
            radio.addEventListener('change', function() {
                console.log('Radio changed:', this.value);
                if (this.value === 'tim') {
                    teamMembersSection.style.display = 'flex';
                    // Add initial 3 members if none exist
                    if (teamMembersContainer.children.length === 0) {
                        for (let i = 0; i < 3; i++) {
                            addTeamMember();
                        }
                    }
                } else {
                    teamMembersSection.style.display = 'none';
                }
                validateTeam();
            });
        });
        
        // Listen for kategori pendaftaran changes to toggle Google Drive section
        if (kategoriPendaftaran) {
            kategoriPendaftaran.addEventListener('change', toggleGoogleDriveSection);
        }
        
        // Function to toggle Google Drive section visibility
        function toggleGoogleDriveSection() {
            if (!kategoriPendaftaran || !googleDriveSection) return;
            
            const isKompetisi = kategoriPendaftaran.value === 'kompetisi';
            // For now, don't show Google Drive section during registration
            // It will be available after payment approval
            googleDriveSection.style.display = 'none';
        }
        
        // Add team member event
        if (addMemberBtn) {
            addMemberBtn.addEventListener('click', function() {
                addTeamMember();
                validateTeam();
            });
        }
        
        // Function to add a new team member
        function addTeamMember() {
            memberCount++;
            const memberHtml = `
                <div class="team-member attendant-wrapper flex flex-col gap-[10px]">
                    <div class="group/accordion peer flex flex-col rounded-2xl border border-[#E6E7EB] p-6 has-[.invalid]:text-aktiv-black has-[.invalid]:has-[:checked]:border-aktiv-red has-[.invalid]:border-aktiv-grey has-[.invalid]:has-[:checked]:text-aktiv-red transition-all duration-300">
                        <label class="relative flex items-center justify-between">
                            <p class="font-semibold text-lg leading-[27px]">Team Member ${memberCount}</p>
                            ${memberCount > 3 ? `
                                <button type="button" class="delete-member w-6 h-6 hover:scale-110 transition-transform mr-8">
                                    <img src="${assetBaseUrl}assets/images/icons/trash.svg" alt="Delete">
                                </button>
                            ` : ''}
                            <input type="checkbox" name="accordion" class="hidden">
                            <img src="${assetBaseUrl}assets/images/icons/arrow-square-up.svg" class="absolute right-0 top-1/2 transform -translate-y-1/2 w-6 h-6 transition-all duration-300 opacity-100 group-has-[:checked]/accordion:rotate-180 group-has-[.invalid]/accordion:group-has-[:checked]/accordion:opacity-0" alt="icon">
                            <img src="${assetBaseUrl}assets/images/icons/arrow-square-down-red.svg" class="absolute right-0 top-1/2 transform -translate-y-1/2 w-6 h-6 transition-all duration-300 opacity-0 group-has-[.invalid]/accordion:group-has-[:checked]/accordion:opacity-100" alt="icon">
                        </label>
                        <div class="accordion flex flex-col gap-6 mt-6 transition-all duration-300 group-has-[:checked]/accordion:!h-0 group-has-[:checked]/accordion:mt-0 overflow-y-hidden">
                            <hr class="border-[#E6E7EB]">
                            
                            <!-- Nama Anggota -->
                            <label class="flex flex-col gap-4">
                                <p class="font-medium text-aktiv-grey">Full Name</p>
                                <div class="group input-wrapper flex items-center rounded-xl p-4 gap-2 bg-[#FBFBFB] overflow-hidden">
                                    <img src="${assetBaseUrl}assets/images/icons/profile-circle.svg" class="w-6 h-6 flex shrink-0 group-focus-within:hidden group-has-[:valid]:hidden" alt="icon">
                                    <img src="${assetBaseUrl}assets/images/icons/profile-circle-black.svg" class="w-6 h-6 shrink-0 hidden group-focus-within:flex group-has-[:valid]:flex" alt="icon">
                                    <input type="text" name="team_members[${memberCount-1}][nama]" class="appearance-none bg-transparent w-full outline-none text-lg leading-[27px] font-semibold placeholder:font-medium placeholder:text-aktiv-grey" placeholder="Write complete member name" required>
                                </div>
                            </label>
                            
                            <!-- Email Anggota -->
                            <label class="flex flex-col gap-4">
                                <p class="font-medium text-aktiv-grey">Email Address</p>
                                <div class="group input-wrapper flex items-center rounded-xl p-4 gap-2 bg-[#FBFBFB] overflow-hidden">
                                    <img src="${assetBaseUrl}assets/images/icons/sms.svg" class="w-6 h-6 flex shrink-0 group-focus-within:hidden group-has-[:valid]:hidden" alt="icon">
                                    <img src="${assetBaseUrl}assets/images/icons/sms-black.svg" class="w-6 h-6 shrink-0 hidden group-focus-within:flex group-has-[:valid]:flex" alt="icon">
                                    <input type="email" name="team_members[${memberCount-1}][email]" class="appearance-none bg-transparent w-full outline-none text-lg leading-[27px] font-semibold placeholder:font-medium placeholder:text-aktiv-grey" placeholder="Member email address" required>
                                </div>
                            </label>
                            
                            <!-- Kontak Anggota -->
                            <label class="flex flex-col gap-4">
                                <p class="font-medium text-aktiv-grey">Phone Number</p>
                                <div class="group input-wrapper flex items-center rounded-xl p-4 gap-2 bg-[#FBFBFB] overflow-hidden">
                                    <img src="${assetBaseUrl}assets/images/icons/call.svg" class="w-6 h-6 flex shrink-0 group-focus-within:hidden group-has-[:valid]:hidden" alt="icon">
                                    <img src="${assetBaseUrl}assets/images/icons/call-black.svg" class="w-6 h-6 shrink-0 hidden group-focus-within:flex group-has-[:valid]:flex" alt="icon">
                                    <input type="tel" name="team_members[${memberCount-1}][kontak]" class="appearance-none bg-transparent w-full outline-none text-lg leading-[27px] font-semibold placeholder:font-medium placeholder:text-aktiv-grey" placeholder="Member phone number" required>
                                </div>
                            </label>
                            
                            <!-- Ketua Tim Checkbox -->
                            <label class="flex items-center gap-2 p-3 border border-[#E6E7EB] rounded-xl">
                                <input type="checkbox" name="team_members[${memberCount-1}][is_ketua]" class="ketua-checkbox h-6 w-6 text-aktiv-orange" value="1">
                                <span class="font-semibold">Team Leader</span>
                            </label>
                        </div>
                    </div>
                    <span class="hidden font-medium text-aktiv-red peer-has-[.invalid]:block">Please fill in the team member's data before proceeding.</span>
                </div>
            `;
            
            teamMembersContainer.insertAdjacentHTML('beforeend', memberHtml);
            
            // Add event listeners to new elements
            const newTeamMember = teamMembersContainer.lastElementChild;
            
            // Add event listener to delete button if present
            const deleteBtn = newTeamMember.querySelector('.delete-member');
            if (deleteBtn) {
                deleteBtn.addEventListener('click', function() {
                    newTeamMember.remove();
                    validateTeam();
                });
            }
            
            // Add event listener to ketua checkbox
            const ketuaCheckbox = newTeamMember.querySelector('.ketua-checkbox');
            if (ketuaCheckbox) {
                ketuaCheckbox.addEventListener('change', function() {
                    // If this checkbox is checked, uncheck all others
                    if (this.checked) {
                        document.querySelectorAll('.ketua-checkbox').forEach(cb => {
                            if (cb !== this) cb.checked = false;
                        });
                    }
                    validateTeam();
                });
            }
        }
        
        // Validate team requirement (min 3 members, 1 ketua)
        function validateTeam() {
            const selectedJenis = document.querySelector('input[name="jenis_pendaftaran"]:checked')?.value;
            
            // Only validate if tim is selected
            if (selectedJenis === 'tim' && teamMembersContainer && teamValidationError) {
                const teamMembers = teamMembersContainer.querySelectorAll('.team-member');
                const hasEnoughMembers = teamMembers.length >= 3;
                
                // Check if at least one member is ketua
                let hasKetua = false;
                teamMembersContainer.querySelectorAll('.ketua-checkbox').forEach(checkbox => {
                    if (checkbox.checked) hasKetua = true;
                });
                
                // Show validation error if needed
                if (!hasEnoughMembers) {
                    teamValidationError.textContent = 'Team must have at least 3 members.';
                    teamValidationError.classList.remove('hidden');
                } else if (!hasKetua) {
                    teamValidationError.textContent = 'Team must have one leader.';
                    teamValidationError.classList.remove('hidden');
                } else {
                    teamValidationError.classList.add('hidden');
                }
            }
        }
        
        // Form submission validation
        const form = document.getElementById('registrationForm');
        if (form) {
            form.addEventListener('submit', function(e) {
                console.log('Form submit triggered');
                
                const selectedJenis = document.querySelector('input[name="jenis_pendaftaran"]:checked')?.value;
                console.log('Selected jenis on submit:', selectedJenis);
                
                // Validate team if tim is selected
                if (selectedJenis === 'tim' && teamMembersContainer && teamValidationError) {
                    const teamMembers = teamMembersContainer.querySelectorAll('.team-member');
                    const hasEnoughMembers = teamMembers.length >= 3;
                    
                    // Check if at least one member is ketua
                    let hasKetua = false;
                    teamMembersContainer.querySelectorAll('.ketua-checkbox').forEach(checkbox => {
                        if (checkbox.checked) hasKetua = true;
                    });
                    
                    console.log('Team validation:', { hasEnoughMembers, hasKetua });
                    
                    // Prevent submission if validation fails
                    if (!hasEnoughMembers || !hasKetua) {
                        e.preventDefault();
                        validateTeam(); // Show the error message
                        // Scroll to error
                        teamValidationError.scrollIntoView({ behavior: 'smooth', block: 'center' });
                        return false;
                    }
                }
                
                console.log('Form validation passed, submitting...');
            });
        }
        
        // Initialize the form
        initialize();
    });
</script>
@endpush