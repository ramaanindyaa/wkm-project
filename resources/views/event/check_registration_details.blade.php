@extends('layout.app')
@section('title')
Registration Details - {{ $transaction->registration_trx_id }}
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
            <p class="font-bold text-[32px] leading-[48px] capitalize text-white">Registration Details</p>
            <div class="flex items-center gap-2 text-white">
                <a href="{{ route('front.index') }}" class="font-medium">Homepage</a>
                <span>></span>
                <a href="{{ route('event.check_registration') }}" class="font-medium">Check Registration</a>
                <span>></span>
                <a class="last:font-semibold">{{ $transaction->registration_trx_id }}</a>
            </div>
        </div>

        <!-- Main Content -->
        <main class="flex justify-center">
            <div class="flex flex-col w-[856px] rounded-3xl p-8 gap-8 bg-white">
                
                <!-- Header Section with Transaction ID -->
                <div class="flex flex-col gap-6 text-center">
                    <img src="{{asset('assets/images/icons/ticket-star.svg')}}" class="w-[72px] h-[72px] flex shrink-0 mx-auto" alt="ticket icon">
                    <div class="flex flex-col gap-2">
                        <h1 class="font-bold text-[32px] leading-[48px]">Registration Found! 🎯</h1>
                        <p class="font-semibold text-xl leading-[30px] text-aktiv-blue">{{ $transaction->registration_trx_id }}</p>
                    </div>
                </div>

                <!-- Payment Status Card -->
                <div class="flex flex-col gap-4 p-6 rounded-xl border border-[#E6E7EB] 
                    @if($transaction->payment_status === 'pending') bg-[#FDF6E4] @elseif($transaction->payment_status === 'approved') bg-[#E6F7F0] @else bg-[#FEE3E3] @endif">
                    <div class="flex items-center gap-3">
                        @if($transaction->payment_status === 'pending')
                        <img src="{{asset('assets/images/icons/timer.svg')}}" class="w-8 h-8 flex shrink-0" alt="pending">
                        <div class="flex flex-col gap-1">
                            <p class="font-semibold text-lg leading-[27px] text-[#B4A476]">Payment Status: Pending Verification</p>
                            <p class="font-medium text-[#B4A476]">Your payment is being reviewed and will be verified within 24 hours.</p>
                        </div>
                        @elseif($transaction->payment_status === 'approved')
                        <img src="{{asset('assets/images/icons/shield-tick.svg')}}" class="w-8 h-8 flex shrink-0" alt="approved">
                        <div class="flex flex-col gap-1">
                            <p class="font-semibold text-lg leading-[27px] text-[#059669]">Payment Status: Approved ✅</p>
                            <p class="font-medium text-[#059669]">Your registration has been confirmed. Welcome to the event!</p>
                        </div>
                        @else
                        <img src="{{asset('assets/images/icons/warning-2.svg')}}" class="w-8 h-8 flex shrink-0" alt="rejected">
                        <div class="flex flex-col gap-1">
                            <p class="font-semibold text-lg leading-[27px] text-aktiv-red">Payment Status: Rejected ❌</p>
                            <p class="font-medium text-aktiv-red">Unfortunately, your payment could not be verified. Please contact support.</p>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Event Information Card -->
                <div class="flex flex-col gap-4 p-6 rounded-xl border border-[#E6E7EB] bg-[#FBFBFB]">
                    <h3 class="font-semibold text-lg leading-[27px] text-aktiv-black">Event Information</h3>
                    <div class="grid grid-cols-2 gap-4">
                        <div class="flex flex-col gap-1">
                            <p class="font-medium text-aktiv-grey">Event Name</p>
                            <p class="font-semibold text-lg leading-[27px]">{{ $transaction->event->nama }}</p>
                        </div>
                        <div class="flex flex-col gap-1">
                            <p class="font-medium text-aktiv-grey">Event Date</p>
                            <p class="font-semibold text-lg leading-[27px]">{{ $transaction->event->tanggal->format('d F Y') }}</p>
                        </div>
                        <div class="flex flex-col gap-1">
                            <p class="font-medium text-aktiv-grey">Location</p>
                            <p class="font-semibold text-lg leading-[27px]">{{ $transaction->event->lokasi }}</p>
                        </div>
                        <div class="flex flex-col gap-1">
                            <p class="font-medium text-aktiv-grey">Event Time</p>
                            <p class="font-semibold text-lg leading-[27px]">
                                {{ $transaction->event->time_at ? $transaction->event->time_at->format('H:i') : 'TBA' }}
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Registration Details Card -->
                <div class="flex flex-col gap-4 p-6 rounded-xl border border-[#E6E7EB] bg-[#FBFBFB]">
                    <h3 class="font-semibold text-lg leading-[27px] text-aktiv-black">Registration Details</h3>
                    <div class="grid grid-cols-2 gap-4">
                        <div class="flex flex-col gap-1">
                            <p class="font-medium text-aktiv-grey">Participant Name</p>
                            <p class="font-semibold text-lg leading-[27px]">{{ $transaction->name }}</p>
                        </div>
                        <div class="flex flex-col gap-1">
                            <p class="font-medium text-aktiv-grey">Email Address</p>
                            <p class="font-semibold text-lg leading-[27px]">{{ $transaction->email }}</p>
                        </div>
                        <div class="flex flex-col gap-1">
                            <p class="font-medium text-aktiv-grey">Phone Number</p>
                            <p class="font-semibold text-lg leading-[27px]">{{ $transaction->phone }}</p>
                        </div>
                        @if($transaction->company)
                        <div class="flex flex-col gap-1">
                            <p class="font-medium text-aktiv-grey">Company</p>
                            <p class="font-semibold text-lg leading-[27px]">{{ $transaction->company }}</p>
                        </div>
                        @endif
                        <div class="flex flex-col gap-1">
                            <p class="font-medium text-aktiv-grey">Registration Category</p>
                            <p class="font-semibold text-lg leading-[27px] capitalize">{{ $transaction->kategori_pendaftaran_label }}</p>
                        </div>
                        <div class="flex flex-col gap-1">
                            <p class="font-medium text-aktiv-grey">Registration Type</p>
                            <p class="font-semibold text-lg leading-[27px]">{{ $transaction->jenis_pendaftaran_label }}</p>
                        </div>
                    </div>
                </div>

                <!-- Team Members (if applicable) -->
                @if($transaction->isTeamRegistration() && $transaction->teamMembers->count() > 0)
                <div class="flex flex-col gap-4 p-6 rounded-xl border border-[#E6E7EB] bg-[#F0F9FF]">
                    <h3 class="font-semibold text-lg leading-[27px] text-aktiv-blue">Team Members ({{ $transaction->teamMembers->count() }})</h3>
                    <div class="grid grid-cols-1 gap-3">
                        @foreach($transaction->teamMembers as $member)
                        <div class="flex items-center gap-3 p-4 rounded-lg bg-white border border-[#E6E7EB]">
                            <div class="flex w-8 h-8 shrink-0 rounded-full bg-aktiv-blue items-center justify-center">
                                @if($member->is_ketua)
                                <img src="{{asset('assets/images/icons/medal-star.svg')}}" class="w-4 h-4 text-white" alt="leader">
                                @else
                                <img src="{{asset('assets/images/icons/profile-circle.svg')}}" class="w-4 h-4 text-white" alt="member">
                                @endif
                            </div>
                            <div class="flex flex-col flex-1">
                                <p class="font-semibold text-lg leading-[27px]">
                                    {{ $member->nama }}
                                    @if($member->is_ketua)
                                    <span class="text-aktiv-orange font-medium text-lg">(Leader)</span>
                                    @endif
                                </p>
                                <div class="flex items-center gap-4">
                                    <p class="font-medium text-aktiv-grey">{{ $member->email }}</p>
                                    <span class="text-aktiv-grey">•</span>
                                    <p class="font-medium text-aktiv-grey">{{ $member->kontak }}</p>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif

                <!-- Competition Documents Section (only for approved competition registrations) -->
                @if($transaction->isCompetition() && $transaction->payment_status === 'approved')
                <div class="flex flex-col gap-4 p-6 rounded-xl border border-[#E6E7EB] bg-[#F0F9FF]">
                    <h3 class="font-semibold text-lg leading-[27px] text-aktiv-blue">Competition Documents</h3>
                    
                    @if($transaction->documents_complete)
                    <!-- Documents Complete -->
                    <div class="flex items-center gap-3 p-4 rounded-lg bg-[#E6F7F0] border border-[#10B981]">
                        <img src="{{asset('assets/images/icons/shield-tick.svg')}}" class="w-6 h-6 flex shrink-0" alt="complete">
                        <p class="font-semibold text-lg leading-[27px] text-[#059669]">All documents have been submitted ✅</p>
                    </div>
                    
                    <!-- Document Links Display -->
                    <div class="grid grid-cols-1 gap-3">
                        <div class="flex items-center justify-between p-3 rounded-lg bg-white border border-[#E6E7EB]">
                            <div class="flex items-center gap-3">
                                <img src="{{asset('assets/images/icons/document.svg')}}" class="w-6 h-6 flex shrink-0" alt="document">
                                <p class="font-medium text-aktiv-grey">Paper Document</p>
                            </div>
                            <a href="{{ $transaction->google_drive_makalah }}" target="_blank" class="font-semibold text-aktiv-blue hover:text-aktiv-blue/80">View Document</a>
                        </div>
                        <div class="flex items-center justify-between p-3 rounded-lg bg-white border border-[#E6E7EB]">
                            <div class="flex items-center gap-3">
                                <img src="{{asset('assets/images/icons/document.svg')}}" class="w-6 h-6 flex shrink-0" alt="document">
                                <p class="font-medium text-aktiv-grey">Attachment Document</p>
                            </div>
                            <a href="{{ $transaction->google_drive_lampiran }}" target="_blank" class="font-semibold text-aktiv-blue hover:text-aktiv-blue/80">View Document</a>
                        </div>
                        <div class="flex items-center justify-between p-3 rounded-lg bg-white border border-[#E6E7EB]">
                            <div class="flex items-center gap-3">
                                <img src="{{asset('assets/images/icons/video.svg')}}" class="w-6 h-6 flex shrink-0" alt="video">
                                <p class="font-medium text-aktiv-grey">Before Video</p>
                            </div>
                            <a href="{{ $transaction->google_drive_video_sebelum }}" target="_blank" class="font-semibold text-aktiv-blue hover:text-aktiv-blue/80">Watch Video</a>
                        </div>
                        <div class="flex items-center justify-between p-3 rounded-lg bg-white border border-[#E6E7EB]">
                            <div class="flex items-center gap-3">
                                <img src="{{asset('assets/images/icons/video.svg')}}" class="w-6 h-6 flex shrink-0" alt="video">
                                <p class="font-medium text-aktiv-grey">After Video</p>
                            </div>
                            <a href="{{ $transaction->google_drive_video_sesudah }}" target="_blank" class="font-semibold text-aktiv-blue hover:text-aktiv-blue/80">Watch Video</a>
                        </div>
                    </div>
                    @else
                    <!-- Documents Upload Form -->
                    <div class="flex items-center gap-3 p-4 rounded-lg bg-[#FDF6E4] border border-[#F59E0B]">
                        <img src="{{asset('assets/images/icons/warning-2.svg')}}" class="w-6 h-6 flex shrink-0" alt="warning">
                        <p class="font-semibold text-lg leading-[27px] text-[#B4A476]">Competition documents need to be uploaded</p>
                    </div>
                    
                    <!-- Document Upload Form -->
                    <form action="{{ route('event.documents.update', $transaction->id) }}" method="POST" class="flex flex-col gap-4">
                        @csrf
                        
                        <!-- Error Messages -->
                        @if ($errors->any())
                        <div class="flex flex-col gap-2 p-4 bg-[#FEE3E3] rounded-xl">
                            <div class="flex items-center gap-2">
                                <img src="{{asset('assets/images/icons/warning-2.svg')}}" class="w-5 h-5" alt="error">
                                <p class="font-semibold text-aktiv-red">Please fix the following errors:</p>
                            </div>
                            <ul class="list-disc pl-7">
                                @foreach ($errors->all() as $error)
                                    <li class="text-aktiv-red">{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                        @endif
                        
                        <!-- Document Input Fields -->
                        <div class="grid grid-cols-1 gap-4">
                            <!-- Makalah Link -->
                            <label class="flex flex-col gap-4">
                                <p class="font-medium text-aktiv-grey">Paper Google Drive Link *</p>
                                <div class="group input-wrapper flex items-center rounded-xl p-4 gap-2 bg-[#FBFBFB] overflow-hidden">
                                    <img src="{{asset('assets/images/icons/document.svg')}}" class="w-6 h-6 flex shrink-0 group-focus-within:hidden group-has-[:valid]:hidden" alt="icon">
                                    <img src="{{asset('assets/images/icons/document.svg')}}" class="w-6 h-6 shrink-0 hidden group-focus-within:flex group-has-[:valid]:flex opacity-80" alt="icon">
                                    <input type="url" name="google_drive_makalah" value="{{ old('google_drive_makalah', $transaction->google_drive_makalah) }}" class="appearance-none bg-transparent w-full outline-none text-lg leading-[27px] font-semibold placeholder:font-medium placeholder:text-aktiv-grey" placeholder="https://drive.google.com/..." required>
                                </div>
                            </label>
                            
                            <!-- Lampiran Link -->
                            <label class="flex flex-col gap-4">
                                <p class="font-medium text-aktiv-grey">Attachment Google Drive Link *</p>
                                <div class="group input-wrapper flex items-center rounded-xl p-4 gap-2 bg-[#FBFBFB] overflow-hidden">
                                    <img src="{{asset('assets/images/icons/document.svg')}}" class="w-6 h-6 flex shrink-0 group-focus-within:hidden group-has-[:valid]:hidden" alt="icon">
                                    <img src="{{asset('assets/images/icons/document.svg')}}" class="w-6 h-6 shrink-0 hidden group-focus-within:flex group-has-[:valid]:flex opacity-80" alt="icon">
                                    <input type="url" name="google_drive_lampiran" value="{{ old('google_drive_lampiran', $transaction->google_drive_lampiran) }}" class="appearance-none bg-transparent w-full outline-none text-lg leading-[27px] font-semibold placeholder:font-medium placeholder:text-aktiv-grey" placeholder="https://drive.google.com/..." required>
                                </div>
                            </label>
                            
                            <!-- Video Sebelum Link -->
                            <label class="flex flex-col gap-4">
                                <p class="font-medium text-aktiv-grey">Before Video Google Drive Link *</p>
                                <div class="group input-wrapper flex items-center rounded-xl p-4 gap-2 bg-[#FBFBFB] overflow-hidden">
                                    <img src="{{asset('assets/images/icons/video.svg')}}" class="w-6 h-6 flex shrink-0 group-focus-within:hidden group-has-[:valid]:hidden" alt="icon">
                                    <img src="{{asset('assets/images/icons/video.svg')}}" class="w-6 h-6 shrink-0 hidden group-focus-within:flex group-has-[:valid]:flex opacity-80" alt="icon">
                                    <input type="url" name="google_drive_video_sebelum" value="{{ old('google_drive_video_sebelum', $transaction->google_drive_video_sebelum) }}" class="appearance-none bg-transparent w-full outline-none text-lg leading-[27px] font-semibold placeholder:font-medium placeholder:text-aktiv-grey" placeholder="https://drive.google.com/..." required>
                                </div>
                            </label>
                            
                            <!-- Video Sesudah Link -->
                            <label class="flex flex-col gap-4">
                                <p class="font-medium text-aktiv-grey">After Video Google Drive Link *</p>
                                <div class="group input-wrapper flex items-center rounded-xl p-4 gap-2 bg-[#FBFBFB] overflow-hidden">
                                    <img src="{{asset('assets/images/icons/video.svg')}}" class="w-6 h-6 flex shrink-0 group-focus-within:hidden group-has-[:valid]:hidden" alt="icon">
                                    <img src="{{asset('assets/images/icons/video.svg')}}" class="w-6 h-6 shrink-0 hidden group-focus-within:flex group-has-[:valid]:flex opacity-80" alt="icon">
                                    <input type="url" name="google_drive_video_sesudah" value="{{ old('google_drive_video_sesudah', $transaction->google_drive_video_sesudah) }}" class="appearance-none bg-transparent w-full outline-none text-lg leading-[27px] font-semibold placeholder:font-medium placeholder:text-aktiv-grey" placeholder="https://drive.google.com/..." required>
                                </div>
                            </label>
                        </div>
                        
                        <!-- Submit Button -->
                        <button type="submit" class="w-full rounded-xl h-16 px-6 text-center bg-aktiv-blue font-semibold text-lg leading-[27px] text-white hover:bg-aktiv-blue/90 transition-colors">
                            Upload Documents
                        </button>
                    </form>
                    @endif
                </div>
                @endif

                <!-- Payment Information Card -->
                <div class="flex flex-col gap-4 p-6 rounded-xl border border-[#E6E7EB] bg-[#FBFBFB]">
                    <h3 class="font-semibold text-lg leading-[27px] text-aktiv-black">Payment Information</h3>
                    <div class="grid grid-cols-2 gap-4">
                        <div class="flex flex-col gap-1">
                            <p class="font-medium text-aktiv-grey">Bank Name</p>
                            <p class="font-semibold text-lg leading-[27px]">{{ $transaction->customer_bank_name }}</p>
                        </div>
                        <div class="flex flex-col gap-1">
                            <p class="font-medium text-aktiv-grey">Account Holder</p>
                            <p class="font-semibold text-lg leading-[27px]">{{ $transaction->customer_bank_account }}</p>
                        </div>
                        <div class="flex flex-col gap-1">
                            <p class="font-medium text-aktiv-grey">Account Number</p>
                            <p class="font-semibold text-lg leading-[27px]">{{ $transaction->customer_bank_number }}</p>
                        </div>
                        <div class="flex flex-col gap-1">
                            <p class="font-medium text-aktiv-grey">Total Amount</p>
                            <p class="font-semibold text-lg leading-[27px] text-aktiv-red">Rp{{ number_format($transaction->total_amount, 0, ',', '.') }}</p>
                        </div>
                    </div>
                    
                    @if($transaction->payment_proof)
                    <div class="flex items-center justify-between p-3 rounded-lg bg-white border border-[#E6E7EB] mt-2">
                        <div class="flex items-center gap-3">
                            <img src="{{asset('assets/images/icons/verify.svg')}}" class="w-6 h-6 flex shrink-0" alt="proof">
                            <p class="font-medium text-aktiv-grey">Payment Proof</p>
                        </div>
                        <a href="{{ Storage::url($transaction->payment_proof) }}" target="_blank" class="font-semibold text-aktiv-blue hover:text-aktiv-blue/80">View Proof</a>
                    </div>
                    @endif
                </div>

                <!-- Registration Date -->
                <div class="flex items-center justify-center p-4 rounded-xl bg-[#F0F9FF] border border-[#E6E7EB]">
                    <p class="font-medium text-aktiv-blue">
                        Registration submitted on {{ $transaction->created_at->format('d F Y, H:i') }}
                    </p>
                </div>

                <!-- Action Buttons -->
                <div class="flex gap-4">
                    <a href="{{ route('event.check_registration') }}" class="flex-1 flex items-center justify-center gap-2 font-semibold text-lg leading-[27px] px-6 py-3 border border-aktiv-blue text-aktiv-blue rounded-xl hover:bg-aktiv-blue/10 transition-all duration-300">
                        <img src="{{asset('assets/images/icons/search-normal.svg')}}" class="w-5 h-5" alt="search">
                        Check Another Registration
                    </a>
                    <a href="{{ route('event.index') }}" class="flex-1 flex items-center justify-center gap-2 font-semibold text-lg leading-[27px] px-6 py-3 bg-aktiv-blue text-white rounded-xl hover:bg-aktiv-blue/90 transition-all duration-300">
                        <img src="{{asset('assets/images/icons/calendar-2.svg')}}" class="w-5 h-5" alt="events">
                        Browse More Events
                    </a>
                </div>
            </div>
        </main>
    </div>
</section>

@endsection

@push('after-scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Success message display
        @if(session('success'))
        // Create success notification
        const notification = document.createElement('div');
        notification.className = 'fixed top-4 right-4 z-50 p-4 bg-[#E6F7F0] border border-[#10B981] rounded-xl shadow-lg max-w-sm';
        notification.innerHTML = `
            <div class="flex items-center gap-3">
                <img src="{{asset('assets/images/icons/shield-tick.svg')}}" class="w-6 h-6 flex shrink-0" alt="success">
                <p class="font-semibold text-[#059669]">{{ session('success') }}</p>
            </div>
        `;
        
        document.body.appendChild(notification);
        
        // Auto remove after 5 seconds
        setTimeout(() => {
            notification.style.animation = 'fadeOut 0.5s ease-out forwards';
            setTimeout(() => notification.remove(), 500);
        }, 5000);
        @endif
        
        // Add copy functionality for transaction ID
        const transactionId = document.querySelector('p.text-aktiv-blue');
        if (transactionId) {
            transactionId.style.cursor = 'pointer';
            transactionId.title = 'Click to copy Transaction ID';
            
            transactionId.addEventListener('click', function() {
                navigator.clipboard.writeText(this.textContent).then(() => {
                    // Show copy confirmation
                    const originalText = this.textContent;
                    this.textContent = 'Copied! ✓';
                    setTimeout(() => {
                        this.textContent = originalText;
                    }, 2000);
                });
            });
        }
        
        // Smooth scroll for form sections
        const documentUploadForm = document.querySelector('form[action*="documents/update"]');
        if (documentUploadForm) {
            documentUploadForm.addEventListener('submit', function() {
                // Show loading state
                const submitButton = this.querySelector('button[type="submit"]');
                if (submitButton) {
                    submitButton.disabled = true;
                    submitButton.innerHTML = '<img src="{{asset("assets/images/icons/timer.svg")}}" class="w-6 h-6 animate-spin mx-auto" alt="loading"> Uploading...';
                }
            });
        }
        
        // Add hover effects to document links
        const documentLinks = document.querySelectorAll('a[href*="drive.google.com"]');
        documentLinks.forEach(link => {
            link.addEventListener('mouseenter', function() {
                this.style.transform = 'translateX(5px)';
                this.style.transition = 'all 0.3s ease';
            });
            
            link.addEventListener('mouseleave', function() {
                this.style.transform = 'translateX(0)';
            });
        });
    });
</script>

<style>
    @keyframes fadeOut {
        from {
            opacity: 1;
            transform: translateX(0);
        }
        to {
            opacity: 0;
            transform: translateX(100%);
        }
    }
    
    /* Add pulse animation for pending status */
    .pulse-animation {
        animation: pulse 2s infinite;
    }
    
    @keyframes pulse {
        0%, 100% {
            opacity: 1;
        }
        50% {
            opacity: 0.7;
        }
    }
    
    /* Add subtle hover effect for cards */
    .card-hover:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        transition: all 0.3s ease;
    }
</style>
@endpush