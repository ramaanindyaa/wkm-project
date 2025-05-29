@extends('layout.app')
@section('title')
Payment Success
@endsection
@section('content')

<div class="flex flex-col items-center w-full min-h-screen">
    <div class="flex flex-col max-w-[856px] rounded-3xl p-8 gap-8 bg-white my-auto">
        <!-- Success Icon and Title Section -->
        <div class="flex flex-col gap-6">
            <img src="{{asset('assets/images/icons/shield-tick.svg')}}" class="w-[72px] h-[72px] flex shrink-0 mx-auto" alt="success icon">
            <h1 class="font-bold text-[32px] leading-[48px] text-center">Payment Submitted Successfully! 🙌🏻</h1>
        </div>
        
        <!-- Event Information and Action Section -->
        <div class="flex flex-col gap-6">
            <!-- Event Details Card -->
            <div class="flex justify-between w-full rounded-full border border-[#E6E7EB] p-3 pl-8">
                <div class="flex items-center gap-2">
                    <img src="{{asset('assets/images/icons/ticket-star.svg')}}" class="w-8 h-8 flex shrink-0" alt="icon">
                    <p class="font-medium text-lg leading-[27px] text-aktiv-grey">Event:</p>
                    <p class="font-bold text-lg leading-[27px]">
                        {{ $participant->event->nama }}
                    </p>
                </div>
                <a href="{{ route('event.index') }}" class="flex items-center shrink-0 gap-2 rounded-full py-4 px-8 bg-aktiv-orange hover:bg-aktiv-orange/90 transition-all duration-300">
                    <img src="{{asset('assets/images/icons/calendar-2.svg')}}" class="w-8 h-8 flex shrink-0" alt="icon">
                    <span class="font-semibold text-lg leading-[27px] text-white text-nowrap">Browse Events</span>
                </a>
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
                        <p class="font-medium text-aktiv-grey">Registration Type</p>
                        <p class="font-semibold text-lg leading-[27px] capitalize">
                            {{ $participant->jenis_pendaftaran === 'tim' ? 'Team Registration' : 'Individual Registration' }}
                        </p>
                    </div>
                    <div class="flex flex-col gap-1">
                        <p class="font-medium text-aktiv-grey">Registration Category</p>
                        <p class="font-semibold text-lg leading-[27px] capitalize">{{ $participant->kategori_pendaftaran }}</p>
                    </div>
                </div>
                
                <!-- Team Members (if applicable) -->
                @if($participant->jenis_pendaftaran === 'tim' && $participant->teamMembers->count() > 0)
                <div class="flex flex-col gap-3 mt-4 pt-4 border-t border-[#E6E7EB]">
                    <p class="font-medium text-aktiv-grey">Team Members ({{ $participant->teamMembers->count() }})</p>
                    <div class="grid grid-cols-1 gap-2">
                        @foreach($participant->teamMembers as $member)
                        <div class="flex items-center gap-3 p-3 rounded-lg bg-white border border-[#E6E7EB]">
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
                                <p class="font-medium text-aktiv-grey">{{ $member->email }}</p>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif
            </div>
            
            <!-- Status Information -->
            <div class="flex flex-col gap-4 p-6 rounded-xl bg-[#FDF6E4] border border-[#E6E7EB]">
                <div class="flex items-center gap-3">
                    <img src="{{asset('assets/images/icons/timer.svg')}}" class="w-8 h-8 flex shrink-0" alt="pending icon">
                    <div class="flex flex-col gap-1">
                        <p class="font-semibold text-lg leading-[27px] text-[#B4A476]">Payment Status: Pending Verification</p>
                        <p class="font-medium text-[#B4A476]">Your payment is being reviewed and will be verified within 24 hours.</p>
                    </div>
                </div>
            </div>
            
            <!-- Next Steps Information -->
            <div class="flex flex-col gap-4 p-6 rounded-xl bg-[#DFEFFF] border border-[#E6E7EB]">
                <h3 class="font-semibold text-lg leading-[27px] text-aktiv-blue">What's Next?</h3>
                <div class="flex flex-col gap-3">
                    <div class="flex items-start gap-3">
                        <div class="flex w-6 h-6 shrink-0 rounded-full bg-aktiv-blue items-center justify-center mt-1">
                            <span class="font-bold text-white text-sm">1</span>
                        </div>
                        <div class="flex flex-col gap-1">
                            <p class="font-semibold text-lg leading-[27px] text-aktiv-blue">Email Confirmation</p>
                            <p class="font-medium text-aktiv-blue">You will receive a confirmation email once your payment is verified.</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-3">
                        <div class="flex w-6 h-6 shrink-0 rounded-full bg-aktiv-blue items-center justify-center mt-1">
                            <span class="font-bold text-white text-sm">2</span>
                        </div>
                        <div class="flex flex-col gap-1">
                            <p class="font-semibold text-lg leading-[27px] text-aktiv-blue">Event Details</p>
                            <p class="font-medium text-aktiv-blue">Further event details and instructions will be sent to your email.</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-3">
                        <div class="flex w-6 h-6 shrink-0 rounded-full bg-aktiv-blue items-center justify-center mt-1">
                            <span class="font-bold text-white text-sm">3</span>
                        </div>
                        <div class="flex flex-col gap-1">
                            <p class="font-semibold text-lg leading-[27px] text-aktiv-blue">
                                @if($participant->kategori_pendaftaran === 'kompetisi')
                                Document Submission
                                @else
                                Event Participation
                                @endif
                            </p>
                            <p class="font-medium text-aktiv-blue">
                                @if($participant->kategori_pendaftaran === 'kompetisi')
                                You'll receive access to submit your competition documents after payment approval.
                                @else
                                Prepare for the event and join us on the scheduled date.
                                @endif
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Important Notice -->
            <div class="flex items-start p-4 gap-3 rounded-xl bg-[#FEE3E3] border border-aktiv-red">
                <img src="{{asset('assets/images/icons/warning-2.svg')}}" class="w-6 h-6 flex shrink-0 mt-1" alt="warning">
                <div class="flex flex-col gap-1">
                    <p class="font-semibold text-lg leading-[27px] text-aktiv-red">Important Notice</p>
                    <p class="font-medium text-aktiv-red">
                        Please keep this information for your records. 
                        If you don't receive a confirmation email within 24 hours, please contact our support team.
                    </p>
                </div>
            </div>
            
            <!-- Contact Information -->
            <div class="flex flex-col gap-4 p-6 rounded-xl bg-[#F0F9FF] border border-[#E6E7EB]">
                <h3 class="font-semibold text-lg leading-[27px] text-aktiv-blue">Need Help?</h3>
                <div class="flex flex-col gap-3">
                    <div class="flex items-center gap-3">
                        <img src="{{asset('assets/images/icons/sms.svg')}}" class="w-6 h-6 flex shrink-0" alt="email">
                        <div class="flex flex-col">
                            <p class="font-medium text-aktiv-blue">Email Support</p>
                            <p class="font-semibold text-lg leading-[27px] text-aktiv-blue">support@wahanakendalimutu.com</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-3">
                        <img src="{{asset('assets/images/icons/call.svg')}}" class="w-6 h-6 flex shrink-0" alt="phone">
                        <div class="flex flex-col">
                            <p class="font-medium text-aktiv-blue">Phone Support</p>
                            <p class="font-semibold text-lg leading-[27px] text-aktiv-blue">+62 21 1234-5678</p>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Description -->
            <p class="font-medium leading-[25.6px] text-center text-aktiv-grey">
                Your event registration has been submitted successfully. We will verify your payment and send a confirmation email to 
                <strong>{{ $participant->email }}</strong> once the process is complete.
            </p>
        </div>
    </div>
    
    <!-- Navigation Links -->
    <div class="flex gap-4 mb-[52px] mt-4">
        <a href="{{ route('event.index') }}" class="flex items-center gap-2 font-semibold text-lg leading-[27px] px-6 py-3 bg-aktiv-blue text-white rounded-xl hover:bg-aktiv-blue/90 transition-all duration-300">
            <img src="{{asset('assets/images/icons/search-normal.svg')}}" class="w-5 h-5" alt="search">
            Browse More Events
        </a>
        <a href="{{ route('front.index') }}" class="flex items-center gap-2 font-semibold text-lg leading-[27px] px-6 py-3 border border-aktiv-blue text-aktiv-blue rounded-xl hover:bg-aktiv-blue/10 transition-all duration-300">
            <img src="{{asset('assets/images/icons/home.svg')}}" class="w-5 h-5" alt="home">
            Back to Homepage
        </a>
    </div>
</div>

@endsection

@push('after-scripts')
<script>
    // Add some interactive feedback
    document.addEventListener('DOMContentLoaded', function() {
        // Add a subtle animation to the success icon
        const successIcon = document.querySelector('img[alt="success icon"]');
        if (successIcon) {
            successIcon.style.animation = 'bounce 2s infinite';
        }
        
        // Add hover effects to cards
        const cards = document.querySelectorAll('.rounded-xl.border');
        cards.forEach(card => {
            card.addEventListener('mouseenter', function() {
                this.style.transform = 'translateY(-2px)';
                this.style.boxShadow = '0 4px 12px rgba(0, 0, 0, 0.1)';
                this.style.transition = 'all 0.3s ease';
            });
            
            card.addEventListener('mouseleave', function() {
                this.style.transform = 'translateY(0)';
                this.style.boxShadow = 'none';
            });
        });
        
        // Add click animations to buttons
        const buttons = document.querySelectorAll('a[href]');
        buttons.forEach(button => {
            button.addEventListener('click', function(e) {
                // Create ripple effect
                const ripple = document.createElement('span');
                const rect = this.getBoundingClientRect();
                const size = Math.max(rect.width, rect.height);
                const x = e.clientX - rect.left - size / 2;
                const y = e.clientY - rect.top - size / 2;
                
                ripple.style.width = ripple.style.height = size + 'px';
                ripple.style.left = x + 'px';
                ripple.style.top = y + 'px';
                ripple.classList.add('ripple');
                
                this.appendChild(ripple);
                
                setTimeout(() => {
                    ripple.remove();
                }, 600);
            });
        });
        
        // Smooth scroll animation for page load
        window.scrollTo({ top: 0, behavior: 'smooth' });
        
        // Add entrance animation
        const mainCard = document.querySelector('.max-w-\\[856px\\]');
        if (mainCard) {
            mainCard.style.opacity = '0';
            mainCard.style.transform = 'translateY(20px)';
            mainCard.style.transition = 'all 0.8s ease-out';
            
            setTimeout(() => {
                mainCard.style.opacity = '1';
                mainCard.style.transform = 'translateY(0)';
            }, 100);
        }
    });
</script>

<style>
    @keyframes bounce {
        0%, 20%, 50%, 80%, 100% {
            transform: translateY(0);
        }
        40% {
            transform: translateY(-10px);
        }
        60% {
            transform: translateY(-5px);
        }
    }
    
    /* Custom hover effects */
    .hover-card-effect {
        transition: all 0.3s ease;
    }
    
    .hover-card-effect:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }
    
    /* Gradient text effect */
    .gradient-text {
        background: linear-gradient(45deg, #0268FB, #FC9B4C);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }
    
    /* Ripple effect for buttons */
    .ripple {
        position: absolute;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.4);
        pointer-events: none;
        transform: scale(0);
        animation: ripple-animation 0.6s linear;
    }
    
    @keyframes ripple-animation {
        to {
            transform: scale(2);
            opacity: 0;
        }
    }
    
    /* Custom scrollbar */
    ::-webkit-scrollbar {
        width: 8px;
    }
    
    ::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 4px;
    }
    
    ::-webkit-scrollbar-thumb {
        background: #4EB6F5;
        border-radius: 4px;
    }
    
    ::-webkit-scrollbar-thumb:hover {
        background: #5B8CE9;
    }
    
    /* Entrance animation for cards */
    .animate-fade-in {
        animation: fadeInUp 0.6s ease-out forwards;
    }
    
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    /* Hover animation for navigation links */
    a[href]:hover {
        transform: translateY(-1px);
    }
    
    /* Focus states for accessibility */
    a[href]:focus,
    button:focus {
        outline: 2px solid #4EB6F5;
        outline-offset: 2px;
    }
</style>
@endpush