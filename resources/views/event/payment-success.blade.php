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
                <a href="{{ route('front.index') }}" class="font-medium hover:text-aktiv-orange transition-colors">Homepage</a>
                <span>></span>
                <a href="{{ route('event.index') }}" class="font-medium hover:text-aktiv-orange transition-colors">Events</a>
                <span>></span>
                <span class="font-medium">Payment Success</span>
            </div>
        </div>

        <!-- Main Content -->
        <main class="flex justify-center">
            <div class="flex flex-col max-w-[856px] w-full rounded-3xl p-8 gap-8 bg-white shadow-lg hover:shadow-xl transition-all duration-500">
                
                <!-- Success Hero Section -->
                <div class="flex flex-col items-center gap-6 p-8 rounded-2xl bg-gradient-to-br from-aktiv-green/5 to-aktiv-green/10 border border-aktiv-green/20 relative overflow-hidden">
                    <!-- Decorative elements -->
                    <div class="absolute top-0 right-0 w-32 h-32 bg-aktiv-green/5 rounded-full -translate-y-16 translate-x-16"></div>
                    <div class="absolute bottom-0 left-0 w-24 h-24 bg-aktiv-green/10 rounded-full translate-y-12 -translate-x-12"></div>
                    
                    <div class="relative z-10 flex items-center justify-center w-24 h-24 rounded-full bg-gradient-to-br from-aktiv-green to-aktiv-green/90 shadow-lg animate-bounce-subtle">
                        <img src="{{asset('assets/images/icons/shield-tick.svg')}}" class="w-12 h-12 text-white" alt="success icon">
                    </div>
                    <div class="flex flex-col gap-3 text-center relative z-10">
                        <h1 class="font-bold text-[32px] leading-[48px] text-aktiv-black">Payment Submitted Successfully! 🎉</h1>
                        <p class="font-medium text-aktiv-grey text-lg">Your registration has been submitted and is being verified. You will receive a confirmation email shortly.</p>
                    </div>
                    
                    <!-- Status Badge -->
                    <div class="flex items-center gap-2 px-4 py-2 rounded-full bg-yellow-100 border border-yellow-300 relative z-10">
                        <div class="w-2 h-2 rounded-full bg-yellow-500 animate-ping"></div>
                        <span class="font-semibold text-yellow-800">Pending Verification</span>
                    </div>
                </div>

                <!-- Transaction Quick Info -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <!-- Transaction ID Card -->
                    <div class="flex flex-col gap-3 p-6 rounded-xl bg-gradient-to-br from-aktiv-blue/5 to-aktiv-blue/10 border border-aktiv-blue/20 hover:border-aktiv-blue/30 transition-all duration-300 group">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-full bg-aktiv-blue/20 flex items-center justify-center">
                                    <img src="{{asset('assets/images/icons/receipt-text.svg')}}" class="w-5 h-5 text-aktiv-blue" alt="transaction">
                                </div>
                                <span class="font-medium text-aktiv-grey">Transaction ID</span>
                            </div>
                            <button class="copy-btn text-aktiv-blue text-sm font-medium hover:text-aktiv-blue/80 transition-colors" data-copy="{{ $participant->registration_trx_id }}">
                                Copy
                            </button>
                        </div>
                        <p class="font-bold text-xl text-aktiv-blue cursor-pointer select-all group-hover:text-aktiv-blue/90 transition-colors" id="transactionId">
                            {{ $participant->registration_trx_id }}
                        </p>
                    </div>

                    <!-- Total Amount Card -->
                    <div class="flex flex-col gap-3 p-6 rounded-xl bg-gradient-to-br from-aktiv-red/5 to-aktiv-red/10 border border-aktiv-red/20 hover:border-aktiv-red/30 transition-all duration-300">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-full bg-aktiv-red/20 flex items-center justify-center">
                                <img src="{{asset('assets/images/icons/money-recive.svg')}}" class="w-5 h-5 text-aktiv-red" alt="amount">
                            </div>
                            <span class="font-medium text-aktiv-grey">Total Payment</span>
                        </div>
                        <div class="flex items-baseline gap-2">
                            <p class="font-bold text-xl text-aktiv-red">
                                Rp{{ number_format($participant->total_amount, 0, ',', '.') }}
                            </p>
                            <span class="text-sm text-aktiv-grey">(incl. PPN 11%)</span>
                        </div>
                    </div>
                </div>

                <!-- Event & Registration Details -->
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    <!-- Event Information Card -->
                    <div class="flex flex-col gap-6 p-6 rounded-xl border border-[#E6E7EB] bg-[#FBFBFB] hover:shadow-md transition-all duration-300">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-full bg-gradient-to-br from-aktiv-orange to-aktiv-orange/80 flex items-center justify-center shadow-sm">
                                <img src="{{asset('assets/images/icons/calendar.svg')}}" class="w-5 h-5 text-white" alt="event">
                            </div>
                            <h3 class="font-semibold text-lg text-aktiv-black">Event Information</h3>
                        </div>
                        
                        <div class="flex flex-col gap-4">
                            <div class="flex flex-col gap-1">
                                <p class="font-medium text-aktiv-grey text-sm">Event Name</p>
                                <p class="font-semibold text-lg text-aktiv-black">{{ $participant->event->nama }}</p>
                            </div>
                            
                            <div class="grid grid-cols-2 gap-4">
                                <div class="flex flex-col gap-1">
                                    <p class="font-medium text-aktiv-grey text-sm">Date</p>
                                    <p class="font-semibold text-lg text-aktiv-black">{{ $participant->event->tanggal->format('d M Y') }}</p>
                                </div>
                                <div class="flex flex-col gap-1">
                                    <p class="font-medium text-aktiv-grey text-sm">Time</p>
                                    <p class="font-semibold text-lg text-aktiv-black">
                                        {{ $participant->event->time_at ? $participant->event->time_at->format('H:i') : 'TBA' }} WIB
                                    </p>
                                </div>
                            </div>
                            
                            <div class="flex flex-col gap-1">
                                <p class="font-medium text-aktiv-grey text-sm">Location</p>
                                <p class="font-semibold text-lg text-aktiv-black">{{ $participant->event->lokasi }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Registration Details Card -->
                    <div class="flex flex-col gap-6 p-6 rounded-xl border border-[#E6E7EB] bg-[#FBFBFB] hover:shadow-md transition-all duration-300">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-full bg-gradient-to-br from-aktiv-blue to-aktiv-blue/80 flex items-center justify-center shadow-sm">
                                <img src="{{asset('assets/images/icons/profile-circle.svg')}}" class="w-5 h-5 text-white" alt="participant">
                            </div>
                            <h3 class="font-semibold text-lg text-aktiv-black">Registration Details</h3>
                        </div>
                        
                        <div class="flex flex-col gap-4">
                            <div class="flex flex-col gap-1">
                                <p class="font-medium text-aktiv-grey text-sm">Participant Name</p>
                                <p class="font-semibold text-lg text-aktiv-black">{{ $participant->name }}</p>
                            </div>
                            
                            <div class="grid grid-cols-1 gap-3">
                                <div class="flex flex-col gap-1">
                                    <p class="font-medium text-aktiv-grey text-sm">Email Address</p>
                                    <p class="font-semibold text-aktiv-black">{{ $participant->email }}</p>
                                </div>
                                <div class="flex flex-col gap-1">
                                    <p class="font-medium text-aktiv-grey text-sm">Phone Number</p>
                                    <p class="font-semibold text-aktiv-black">{{ $participant->phone }}</p>
                                </div>
                            </div>
                            
                            <div class="grid grid-cols-2 gap-4">
                                <div class="flex flex-col gap-1">
                                    <p class="font-medium text-aktiv-grey text-sm">Category</p>
                                    <span class="inline-flex items-center px-2 py-1 rounded-md text-xs font-medium bg-aktiv-blue/10 text-aktiv-blue w-fit">
                                        {{ $participant->kategori_pendaftaran_label }}
                                    </span>
                                </div>
                                <div class="flex flex-col gap-1">
                                    <p class="font-medium text-aktiv-grey text-sm">Type</p>
                                    <span class="inline-flex items-center px-2 py-1 rounded-md text-xs font-medium bg-aktiv-green/10 text-aktiv-green w-fit">
                                        {{ $participant->jenis_pendaftaran_label }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Team Members (if applicable) -->
                @if($participant->isTeamRegistration() && $participant->teamMembers->count() > 0)
                <div class="flex flex-col gap-6 p-6 rounded-xl border border-aktiv-blue/20 bg-gradient-to-br from-aktiv-blue/5 to-aktiv-blue/10">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-full bg-aktiv-blue flex items-center justify-center shadow-sm">
                                <img src="{{asset('assets/images/icons/profile-2user.svg')}}" class="w-5 h-5 text-white" alt="team">
                            </div>
                            <h3 class="font-semibold text-lg text-aktiv-blue">Team Members</h3>
                        </div>
                        <span class="px-3 py-1 rounded-full bg-aktiv-blue text-white text-sm font-medium">
                            {{ $participant->teamMembers->count() }} members
                        </span>
                    </div>
                    
                    <div class="grid grid-cols-1 gap-3">
                        @foreach($participant->teamMembers as $member)
                        <div class="flex items-center gap-4 p-4 rounded-lg bg-white border border-aktiv-blue/20 hover:border-aktiv-blue/30 transition-all duration-300">
                            <div class="flex w-10 h-10 shrink-0 rounded-full {{ $member->is_ketua ? 'bg-aktiv-orange' : 'bg-aktiv-blue' }} items-center justify-center shadow-sm">
                                @if($member->is_ketua)
                                <img src="{{asset('assets/images/icons/medal-star.svg')}}" class="w-5 h-5 text-white" alt="leader">
                                @else
                                <img src="{{asset('assets/images/icons/profile-circle.svg')}}" class="w-5 h-5 text-white" alt="member">
                                @endif
                            </div>
                            <div class="flex flex-col flex-1">
                                <div class="flex items-center gap-2">
                                    <p class="font-semibold text-lg text-aktiv-black">{{ $member->nama }}</p>
                                    @if($member->is_ketua)
                                    <span class="px-2 py-1 rounded-md bg-aktiv-orange/10 text-aktiv-orange text-xs font-medium">Team Leader</span>
                                    @endif
                                </div>
                                <div class="flex items-center gap-3 text-sm text-aktiv-grey">
                                    <span>{{ $member->email }}</span>
                                    <span>•</span>
                                    <span>{{ $member->kontak }}</span>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif

                <!-- Important Information -->
                <div class="flex flex-col gap-6 p-6 rounded-xl bg-gradient-to-br from-amber-50 to-orange-50 border border-amber-200">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-full bg-amber-100 flex items-center justify-center shadow-sm">
                            <img src="{{asset('assets/images/icons/warning-2.svg')}}" class="w-5 h-5 text-amber-600" alt="info">
                        </div>
                        <h3 class="font-semibold text-lg text-amber-800">Important Information</h3>
                    </div>
                    
                    <div class="grid grid-cols-1 gap-3">
                        <div class="flex items-start gap-3 p-4 rounded-lg bg-white/70 border border-amber-200/50">
                            <div class="w-6 h-6 rounded-full bg-amber-500 flex items-center justify-center mt-0.5 shadow-sm">
                                <img src="{{asset('assets/images/icons/clock.svg')}}" class="w-3 h-3 text-white" alt="time">
                            </div>
                            <p class="font-medium text-amber-800">Your payment is being verified by our team. This process may take up to 24 hours.</p>
                        </div>
                        
                        <div class="flex items-start gap-3 p-4 rounded-lg bg-white/70 border border-amber-200/50">
                            <div class="w-6 h-6 rounded-full bg-amber-500 flex items-center justify-center mt-0.5 shadow-sm">
                                <img src="{{asset('assets/images/icons/sms.svg')}}" class="w-3 h-3 text-white" alt="email">
                            </div>
                            <p class="font-medium text-amber-800">You will receive an email confirmation once your payment is approved.</p>
                        </div>
                        
                        <div class="flex items-start gap-3 p-4 rounded-lg bg-white/70 border border-amber-200/50">
                            <div class="w-6 h-6 rounded-full bg-amber-500 flex items-center justify-center mt-0.5 shadow-sm">
                                <img src="{{asset('assets/images/icons/shield-tick.svg')}}" class="w-3 h-3 text-white" alt="secure">
                            </div>
                            <p class="font-medium text-amber-800">Keep your Transaction ID safe for future reference: <span class="font-bold text-amber-900">{{ $participant->registration_trx_id }}</span></p>
                        </div>
                        
                        @if($participant->isCompetition())
                        <div class="flex items-start gap-3 p-4 rounded-lg bg-white/70 border border-amber-200/50">
                            <div class="w-6 h-6 rounded-full bg-amber-500 flex items-center justify-center mt-0.5 shadow-sm">
                                <img src="{{asset('assets/images/icons/document-text.svg')}}" class="w-3 h-3 text-white" alt="document">
                            </div>
                            <p class="font-medium text-amber-800">For competition category, you will need to upload documents after payment approval.</p>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Quick Actions Section -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <!-- Check Status Card -->
                    <div class="flex flex-col gap-4 p-6 rounded-xl bg-gradient-to-br from-aktiv-green/5 to-aktiv-green/10 border border-aktiv-green/20 hover:border-aktiv-green/30 transition-all duration-300">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-full bg-aktiv-green flex items-center justify-center shadow-sm">
                                <img src="{{asset('assets/images/icons/search-normal.svg')}}" class="w-5 h-5 text-white" alt="search">
                            </div>
                            <h3 class="font-semibold text-lg text-aktiv-green">Check Registration Status</h3>
                        </div>
                        <p class="font-medium text-aktiv-green/80">
                            Monitor your registration status anytime using your Transaction ID.
                        </p>
                        <a href="{{ route('event.check_registration') }}" class="flex items-center justify-center gap-2 px-4 py-3 bg-aktiv-green text-white rounded-xl hover:bg-aktiv-green/90 transition-all duration-300 shadow-sm hover:shadow-md">
                            <img src="{{asset('assets/images/icons/search-normal.svg')}}" class="w-5 h-5" alt="search">
                            <span class="font-semibold">Check Status Now</span>
                        </a>
                    </div>

                    <!-- Need Help Card -->
                    <div class="flex flex-col gap-4 p-6 rounded-xl bg-gradient-to-br from-aktiv-blue/5 to-aktiv-blue/10 border border-aktiv-blue/20 hover:border-aktiv-blue/30 transition-all duration-300">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-full bg-aktiv-blue flex items-center justify-center shadow-sm">
                                <img src="{{asset('assets/images/icons/message-question.svg')}}" class="w-5 h-5 text-white" alt="help">
                            </div>
                            <h3 class="font-semibold text-lg text-aktiv-blue">Need Assistance?</h3>
                        </div>
                        <p class="font-medium text-aktiv-blue/80">
                            Our support team is ready to help you with any questions.
                        </p>
                        <div class="flex flex-col gap-2">
                            <a href="mailto:support@wahanakendalimutu.com" class="flex items-center gap-2 text-aktiv-blue hover:text-aktiv-blue/80 transition-colors">
                                <img src="{{asset('assets/images/icons/sms.svg')}}" class="w-4 h-4" alt="email">
                                <span class="font-medium text-sm">support@wahanakendalimutu.com</span>
                            </a>
                            <a href="tel:+6221123456789" class="flex items-center gap-2 text-aktiv-blue hover:text-aktiv-blue/80 transition-colors">
                                <img src="{{asset('assets/images/icons/call.svg')}}" class="w-4 h-4" alt="phone">
                                <span class="font-medium text-sm">+62 21 1234-5678</span>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex flex-col gap-4">
                    <!-- Primary Actions -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <a href="{{ route('event.index') }}" class="flex items-center justify-center gap-3 px-6 py-4 bg-aktiv-orange hover:bg-aktiv-orange/90 text-white rounded-xl font-semibold text-lg transition-all duration-300 shadow-sm hover:shadow-md">
                            <img src="{{asset('assets/images/icons/calendar-2.svg')}}" class="w-6 h-6" alt="events">
                            Browse More Events
                        </a>
                        <button id="shareButton" class="flex items-center justify-center gap-3 px-6 py-4 border-2 border-aktiv-blue text-aktiv-blue hover:bg-aktiv-blue hover:text-white rounded-xl font-semibold text-lg transition-all duration-300 shadow-sm hover:shadow-md">
                            <img src="{{asset('assets/images/icons/share.svg')}}" class="w-6 h-6" alt="share">
                            Share Registration
                        </button>
                    </div>

                    <!-- Secondary Actions -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <button id="printButton" class="flex items-center justify-center gap-3 px-6 py-4 border border-aktiv-grey text-aktiv-grey hover:bg-aktiv-grey/10 rounded-xl font-semibold transition-all duration-300">
                            <img src="{{asset('assets/images/icons/printer.svg')}}" class="w-5 h-5" alt="print">
                            Print Details
                        </button>
                        <a href="{{ route('front.index') }}" class="flex items-center justify-center gap-3 px-6 py-4 border border-aktiv-grey text-aktiv-grey hover:bg-aktiv-grey/10 rounded-xl font-semibold transition-all duration-300">
                            <img src="{{asset('assets/images/icons/home.svg')}}" class="w-5 h-5" alt="home">
                            Back to Homepage
                        </a>
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
        // Copy functionality for buttons
        const copyButtons = document.querySelectorAll('.copy-btn');
        copyButtons.forEach(button => {
            button.addEventListener('click', function() {
                const textToCopy = this.getAttribute('data-copy');
                
                navigator.clipboard.writeText(textToCopy).then(() => {
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
                    textArea.value = textToCopy;
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

        // Auto-scroll to top for better UX
        window.scrollTo({ top: 0, behavior: 'smooth' });
        
        // Add entrance animation
        const mainCard = document.querySelector('main > div');
        if (mainCard) {
            mainCard.style.transform = 'translateY(20px)';
            mainCard.style.opacity = '0';
            
            setTimeout(() => {
                mainCard.style.transition = 'all 0.8s cubic-bezier(0.4, 0, 0.2, 1)';
                mainCard.style.transform = 'translateY(0)';
                mainCard.style.opacity = '1';
            }, 100);
        }
    });

    // Enhanced notification function
    function showNotification(message, type = 'info') {
        const notification = document.createElement('div');
        notification.className = `fixed top-6 right-6 z-50 p-4 rounded-xl shadow-lg max-w-sm transform translate-x-full transition-all duration-300 ${
            type === 'success' ? 'bg-white border border-aktiv-green text-aktiv-green' : 
            type === 'error' ? 'bg-white border border-aktiv-red text-aktiv-red' :
            'bg-white border border-aktiv-blue text-aktiv-blue'
        }`;
        
        notification.innerHTML = `
            <div class="flex items-center gap-3">
                <div class="w-6 h-6 rounded-full flex items-center justify-center ${
                    type === 'success' ? 'bg-aktiv-green' : 
                    type === 'error' ? 'bg-aktiv-red' : 'bg-aktiv-blue'
                }">
                    <img src="{{asset('assets/images/icons/shield-tick.svg')}}" class="w-3 h-3 text-white" alt="notification">
                </div>
                <p class="font-semibold">${message}</p>
            </div>
        `;
        
        document.body.appendChild(notification);
        
        // Animate in
        setTimeout(() => {
            notification.style.transform = 'translateX(0)';
        }, 100);
        
        // Auto remove after 4 seconds
        setTimeout(() => {
            notification.style.transform = 'translateX(full)';
            setTimeout(() => notification.remove(), 300);
        }, 4000);
    }
</script>
@endpush

@push('after-styles')
<style>
    /* Custom animations */
    @keyframes bounce-subtle {
        0%, 100% {
            transform: scale(1);
        }
        50% {
            transform: scale(1.05);
        }
    }
    
    .animate-bounce-subtle {
        animation: bounce-subtle 2s ease-in-out infinite;
    }
    
    /* Enhanced hover effects */
    .hover-lift {
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }
    
    .hover-lift:hover {
        transform: translateY(-2px);
    }
    
    /* Improved grid responsive behavior */
    @media (max-width: 768px) {
        .grid-cols-1.md\:grid-cols-2 {
            grid-template-columns: 1fr;
        }
        
        .gap-4 {
            gap: 1rem;
        }
        
        .px-6 {
            padding-left: 1rem;
            padding-right: 1rem;
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
        
        .bg-gradient-to-br {
            background: #f9fafb !important;
        }
        
        .border {
            border: 1px solid #e5e7eb !important;
        }
    }
    
    /* Enhanced shadow utilities */
    .shadow-soft {
        box-shadow: 0 2px 15px rgba(0, 0, 0, 0.08);
    }
    
    .shadow-medium {
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.12);
    }
    
    /* Smooth transitions for all interactive elements */
    .transition-smooth {
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }
</style>
@endpush