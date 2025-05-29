@extends('layout.app')
@section('title')
Payment Success - {{ $participant->registration_trx_id }}
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
            <p class="font-bold text-[32px] leading-[48px] capitalize text-white">Payment Submitted Successfully</p>
            <div class="flex items-center gap-2 text-white">
                <a href="{{ route('front.index') }}" class="font-medium">Homepage</a>
                <span>></span>
                <a href="{{ route('event.index') }}" class="font-medium">Events</a>
                <span>></span>
                <a class="last:font-semibold">Payment Success</a>
            </div>
        </div>

        <!-- Main Content -->
        <main class="flex justify-center">
            <div class="flex flex-col max-w-[856px] rounded-3xl p-8 gap-8 bg-white my-auto">
                
                <!-- Success Icon and Title Section -->
                <div class="flex flex-col gap-6">
                    <img src="{{asset('assets/images/icons/shield-tick.svg')}}" class="w-[72px] h-[72px] flex shrink-0 mx-auto" alt="success icon">
                    <div class="flex flex-col gap-2 text-center">
                        <h1 class="font-bold text-[32px] leading-[48px]">Payment Submitted Successfully! 🙌🏻</h1>
                        <p class="font-medium text-aktiv-grey">Your registration has been submitted and is being verified. You will receive a confirmation email shortly.</p>
                    </div>
                </div>

                <!-- Transaction Information Card -->
                <div class="flex flex-col gap-4 p-6 rounded-xl border border-[#E6E7EB] bg-[#F0F9FF]">
                    <h3 class="font-semibold text-lg leading-[27px] text-aktiv-blue">Transaction Information</h3>
                    <div class="grid grid-cols-2 gap-4">
                        <div class="flex flex-col gap-1">
                            <p class="font-medium text-aktiv-grey">Transaction ID</p>
                            <p class="font-bold text-lg leading-[27px] text-aktiv-blue cursor-pointer select-all" id="transactionId" title="Click to copy">
                                {{ $participant->registration_trx_id }}
                            </p>
                        </div>
                        <div class="flex flex-col gap-1">
                            <p class="font-medium text-aktiv-grey">Payment Status</p>
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-yellow-100 text-yellow-800 w-fit">
                                Pending Verification
                            </span>
                        </div>
                        <div class="flex flex-col gap-1">
                            <p class="font-medium text-aktiv-grey">Total Amount</p>
                            <p class="font-bold text-lg leading-[27px] text-aktiv-red">
                                Rp{{ number_format($participant->total_amount, 0, ',', '.') }}
                            </p>
                        </div>
                        <div class="flex flex-col gap-1">
                            <p class="font-medium text-aktiv-grey">Registration Date</p>
                            <p class="font-semibold text-lg leading-[27px]">
                                {{ $participant->created_at->format('d F Y, H:i') }}
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Event Information Card -->
                <div class="flex flex-col gap-4 p-6 rounded-xl border border-[#E6E7EB] bg-[#FBFBFB]">
                    <h3 class="font-semibold text-lg leading-[27px] text-aktiv-black">Event Information</h3>
                    <div class="grid grid-cols-2 gap-4">
                        <div class="flex flex-col gap-1">
                            <p class="font-medium text-aktiv-grey">Event Name</p>
                            <p class="font-semibold text-lg leading-[27px]">{{ $participant->event->nama }}</p>
                        </div>
                        <div class="flex flex-col gap-1">
                            <p class="font-medium text-aktiv-grey">Event Date</p>
                            <p class="font-semibold text-lg leading-[27px]">{{ $participant->event->tanggal->format('d F Y') }}</p>
                        </div>
                        <div class="flex flex-col gap-1">
                            <p class="font-medium text-aktiv-grey">Location</p>
                            <p class="font-semibold text-lg leading-[27px]">{{ $participant->event->lokasi }}</p>
                        </div>
                        <div class="flex flex-col gap-1">
                            <p class="font-medium text-aktiv-grey">Event Time</p>
                            <p class="font-semibold text-lg leading-[27px]">
                                {{ $participant->event->time_at ? $participant->event->time_at->format('H:i') : 'TBA' }}
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
                            <p class="font-semibold text-lg leading-[27px]">{{ $participant->name }}</p>
                        </div>
                        <div class="flex flex-col gap-1">
                            <p class="font-medium text-aktiv-grey">Email Address</p>
                            <p class="font-semibold text-lg leading-[27px]">{{ $participant->email }}</p>
                        </div>
                        <div class="flex flex-col gap-1">
                            <p class="font-medium text-aktiv-grey">Phone Number</p>
                            <p class="font-semibold text-lg leading-[27px]">{{ $participant->phone }}</p>
                        </div>
                        @if($participant->company)
                        <div class="flex flex-col gap-1">
                            <p class="font-medium text-aktiv-grey">Company</p>
                            <p class="font-semibold text-lg leading-[27px]">{{ $participant->company }}</p>
                        </div>
                        @endif
                        <div class="flex flex-col gap-1">
                            <p class="font-medium text-aktiv-grey">Registration Category</p>
                            <p class="font-semibold text-lg leading-[27px] capitalize">{{ $participant->kategori_pendaftaran_label }}</p>
                        </div>
                        <div class="flex flex-col gap-1">
                            <p class="font-medium text-aktiv-grey">Registration Type</p>
                            <p class="font-semibold text-lg leading-[27px]">{{ $participant->jenis_pendaftaran_label }}</p>
                        </div>
                    </div>
                </div>

                <!-- Team Members (if applicable) -->
                @if($participant->isTeamRegistration() && $participant->teamMembers->count() > 0)
                <div class="flex flex-col gap-4 p-6 rounded-xl border border-[#E6E7EB] bg-[#F0F9FF]">
                    <h3 class="font-semibold text-lg leading-[27px] text-aktiv-blue">Team Members ({{ $participant->teamMembers->count() }})</h3>
                    <div class="grid grid-cols-1 gap-3">
                        @foreach($participant->teamMembers as $member)
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

                <!-- Important Information Section -->
                <div class="flex flex-col gap-4 p-6 rounded-xl bg-[#FDF6E4] border border-[#F59E0B]">
                    <div class="flex items-center gap-3">
                        <img src="{{asset('assets/images/icons/warning-2.svg')}}" class="w-8 h-8 flex shrink-0" alt="info">
                        <h3 class="font-semibold text-lg leading-[27px] text-[#B4A476]">Important Information</h3>
                    </div>
                    <div class="flex flex-col gap-3 ml-11">
                        <div class="flex items-start gap-2">
                            <div class="w-2 h-2 rounded-full bg-[#B4A476] mt-2 flex-shrink-0"></div>
                            <p class="font-medium text-[#B4A476]">Your payment is being verified by our team. This process may take up to 24 hours.</p>
                        </div>
                        <div class="flex items-start gap-2">
                            <div class="w-2 h-2 rounded-full bg-[#B4A476] mt-2 flex-shrink-0"></div>
                            <p class="font-medium text-[#B4A476]">You will receive an email confirmation once your payment is approved.</p>
                        </div>
                        <div class="flex items-start gap-2">
                            <div class="w-2 h-2 rounded-full bg-[#B4A476] mt-2 flex-shrink-0"></div>
                            <p class="font-medium text-[#B4A476]">Keep your Transaction ID safe for future reference: <span class="font-bold">{{ $participant->registration_trx_id }}</span></p>
                        </div>
                        @if($participant->isCompetition())
                        <div class="flex items-start gap-2">
                            <div class="w-2 h-2 rounded-full bg-[#B4A476] mt-2 flex-shrink-0"></div>
                            <p class="font-medium text-[#B4A476]">For competition category, you will need to upload documents after payment approval.</p>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Check Registration Status Card -->
                <div class="flex flex-col gap-4 p-6 rounded-xl bg-[#E6F7F0] border border-[#10B981]">
                    <div class="flex items-center gap-3">
                        <img src="{{asset('assets/images/icons/search-normal.svg')}}" class="w-8 h-8 flex shrink-0" alt="search">
                        <h3 class="font-semibold text-lg leading-[27px] text-[#059669]">Check Your Registration Status</h3>
                    </div>
                    <p class="font-medium text-[#059669] ml-11">
                        You can check your registration status anytime using your Transaction ID on our check registration page.
                    </p>
                    <div class="flex gap-3 ml-11">
                        <a href="{{ route('event.check_registration') }}" class="flex items-center gap-2 font-semibold text-lg leading-[27px] px-4 py-2 bg-[#059669] text-white rounded-xl hover:bg-[#047857] transition-all duration-300">
                            <img src="{{asset('assets/images/icons/search-normal.svg')}}" class="w-5 h-5" alt="search">
                            Check Registration Status
                        </a>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex flex-col gap-4">
                    <!-- Primary Actions Row -->
                    <div class="flex gap-4">
                        <a href="{{ route('event.index') }}" class="flex-1 flex items-center justify-center gap-2 rounded-full py-4 px-8 bg-aktiv-orange hover:bg-aktiv-orange/90 transition-all duration-300">
                            <img src="{{asset('assets/images/icons/calendar-2.svg')}}" class="w-8 h-8 flex shrink-0" alt="icon">
                            <span class="font-semibold text-lg leading-[27px] text-white">Browse More Events</span>
                        </a>
                        <button id="shareButton" class="flex-1 flex items-center justify-center gap-2 rounded-full py-4 px-8 border border-aktiv-blue text-aktiv-blue hover:bg-aktiv-blue/10 transition-all duration-300">
                            <img src="{{asset('assets/images/icons/share.svg')}}" class="w-8 h-8 flex shrink-0" alt="icon">
                            <span class="font-semibold text-lg leading-[27px]">Share Registration</span>
                        </button>
                    </div>

                    <!-- Secondary Actions Row -->
                    <div class="flex gap-4">
                        <button id="printButton" class="flex-1 flex items-center justify-center gap-2 rounded-full py-4 px-8 border border-aktiv-grey text-aktiv-grey hover:bg-aktiv-grey/10 transition-all duration-300">
                            <img src="{{asset('assets/images/icons/printer.svg')}}" class="w-6 h-6 flex shrink-0" alt="icon">
                            <span class="font-semibold text-lg leading-[27px]">Print Details</span>
                        </button>
                        <a href="{{ route('front.index') }}" class="flex-1 flex items-center justify-center gap-2 rounded-full py-4 px-8 border border-aktiv-grey text-aktiv-grey hover:bg-aktiv-grey/10 transition-all duration-300">
                            <img src="{{asset('assets/images/icons/home.svg')}}" class="w-6 h-6 flex shrink-0" alt="icon">
                            <span class="font-semibold text-lg leading-[27px]">Back to Homepage</span>
                        </a>
                    </div>
                </div>

                <!-- Contact Support Section -->
                <div class="flex flex-col gap-4 p-6 rounded-xl bg-[#F8F9FA] border border-[#E6E7EB]">
                    <h3 class="font-semibold text-lg leading-[27px] text-aktiv-black">Need Help?</h3>
                    <div class="flex flex-col gap-3">
                        <div class="flex items-center gap-3">
                            <img src="{{asset('assets/images/icons/sms.svg')}}" class="w-6 h-6 flex shrink-0" alt="email">
                            <div class="flex flex-col">
                                <p class="font-medium text-aktiv-grey">Email Support</p>
                                <a href="mailto:support@wahanakendalimutu.com" class="font-semibold text-lg leading-[27px] text-aktiv-blue hover:text-aktiv-blue/80">support@wahanakendalimutu.com</a>
                            </div>
                        </div>
                        <div class="flex items-center gap-3">
                            <img src="{{asset('assets/images/icons/call.svg')}}" class="w-6 h-6 flex shrink-0" alt="phone">
                            <div class="flex flex-col">
                                <p class="font-medium text-aktiv-grey">Phone Support</p>
                                <a href="tel:+6221123456789" class="font-semibold text-lg leading-[27px] text-aktiv-blue hover:text-aktiv-blue/80">+62 21 1234-5678</a>
                            </div>
                        </div>
                        <div class="flex items-center gap-3">
                            <img src="{{asset('assets/images/icons/clock.svg')}}" class="w-6 h-6 flex shrink-0" alt="time">
                            <div class="flex flex-col">
                                <p class="font-medium text-aktiv-grey">Support Hours</p>
                                <p class="font-semibold text-lg leading-[27px] text-aktiv-black">Monday - Friday, 09:00 - 17:00 WIB</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</section>

@endsection

@push('after-scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Copy Transaction ID functionality
        const transactionId = document.getElementById('transactionId');
        if (transactionId) {
            transactionId.addEventListener('click', function() {
                navigator.clipboard.writeText(this.textContent.trim()).then(() => {
                    // Show copy confirmation
                    const originalText = this.textContent;
                    this.textContent = 'Copied! ✓';
                    this.style.color = '#059669';
                    
                    setTimeout(() => {
                        this.textContent = originalText;
                        this.style.color = '';
                    }, 2000);
                }).catch(() => {
                    // Fallback for older browsers
                    const textArea = document.createElement('textarea');
                    textArea.value = this.textContent.trim();
                    document.body.appendChild(textArea);
                    textArea.select();
                    document.execCommand('copy');
                    document.body.removeChild(textArea);
                    
                    // Show copy confirmation
                    const originalText = this.textContent;
                    this.textContent = 'Copied! ✓';
                    this.style.color = '#059669';
                    
                    setTimeout(() => {
                        this.textContent = originalText;
                        this.style.color = '';
                    }, 2000);
                });
            });
        }

        // Share functionality
        const shareButton = document.getElementById('shareButton');
        if (shareButton) {
            shareButton.addEventListener('click', function() {
                const shareData = {
                    title: 'Event Registration Successful',
                    text: `I've successfully registered for {{ $participant->event->nama }}! Transaction ID: {{ $participant->registration_trx_id }}`,
                    url: window.location.href
                };

                if (navigator.share) {
                    navigator.share(shareData);
                } else {
                    // Fallback: copy to clipboard
                    const shareText = `${shareData.text}\n${shareData.url}`;
                    navigator.clipboard.writeText(shareText).then(() => {
                        // Show notification
                        showNotification('Share link copied to clipboard!', 'success');
                    });
                }
            });
        }

        // Print functionality
        const printButton = document.getElementById('printButton');
        if (printButton) {
            printButton.addEventListener('click', function() {
                window.print();
            });
        }

        // Success animation on page load
        const successIcon = document.querySelector('img[alt="success icon"]');
        if (successIcon) {
            successIcon.style.animation = 'bounce 1s ease-in-out';
        }

        // Auto-scroll to top for better UX
        window.scrollTo({ top: 0, behavior: 'smooth' });
    });

    // Notification function
    function showNotification(message, type = 'info') {
        const notification = document.createElement('div');
        notification.className = `fixed top-4 right-4 z-50 p-4 rounded-xl shadow-lg max-w-sm transition-all duration-300 ${
            type === 'success' ? 'bg-[#E6F7F0] border border-[#10B981] text-[#059669]' : 
            type === 'error' ? 'bg-[#FEE3E3] border border-[#EF4444] text-[#DC2626]' :
            'bg-[#F0F9FF] border border-[#3B82F6] text-[#1D4ED8]'
        }`;
        
        notification.innerHTML = `
            <div class="flex items-center gap-3">
                <img src="{{asset('assets/images/icons/shield-tick.svg')}}" class="w-6 h-6 flex shrink-0" alt="notification">
                <p class="font-semibold">${message}</p>
            </div>
        `;
        
        document.body.appendChild(notification);
        
        // Animate in
        setTimeout(() => {
            notification.style.transform = 'translateX(0)';
            notification.style.opacity = '1';
        }, 100);
        
        // Auto remove after 3 seconds
        setTimeout(() => {
            notification.style.transform = 'translateX(100%)';
            notification.style.opacity = '0';
            setTimeout(() => notification.remove(), 300);
        }, 3000);
    }
</script>

<style>
    @keyframes bounce {
        0%, 100% {
            transform: scale(1);
        }
        50% {
            transform: scale(1.1);
        }
    }
    
    /* Print styles */
    @media print {
        body * {
            visibility: hidden;
        }
        
        #Content, #Content * {
            visibility: visible;
        }
        
        #Content {
            position: absolute;
            left: 0;
            top: 0;
            width: 100%;
        }
        
        button, .no-print {
            display: none !important;
        }
        
        .bg-gradient-to-r {
            background: #4EB6F5 !important;
        }
    }
    
    /* Responsive adjustments */
    @media (max-width: 768px) {
        .grid-cols-2 {
            grid-template-columns: 1fr;
        }
        
        .flex {
            flex-direction: column;
        }
        
        .gap-4 {
            gap: 1rem;
        }
    }
</style>
@endpush