@extends('layout.app')
@section('title')
Document Upload Success
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
            <p class="font-bold text-[32px] leading-[48px] capitalize text-white">Document Upload Success</p>
            <div class="flex items-center gap-2 text-white">
                <a href="{{ route('front.index') }}" class="font-medium">Homepage</a>
                <span>></span>
                <a href="{{ route('event.check_registration') }}" class="font-medium">Check Registration</a>
                <span>></span>
                <a href="{{ route('event.check_registration_details') }}?registration_trx_id={{ $transaction->registration_trx_id }}" class="font-medium">{{ $transaction->registration_trx_id }}</a>
                <span>></span>
                <span class="last:font-semibold">Success</span>
            </div>
        </div>

        <!-- Main Content -->
        <main class="flex justify-center">
            <div class="flex flex-col w-[856px] rounded-3xl p-8 gap-8 bg-white">
                
                <!-- Success Icon and Title Section -->
                <div class="flex flex-col gap-6">
                    <img src="{{asset('assets/images/icons/shield-tick.svg')}}" class="w-[72px] h-[72px] flex shrink-0 mx-auto" alt="success icon">
                    <div class="flex flex-col gap-2 text-center">
                        <h1 class="font-bold text-[32px] leading-[48px]">Documents Uploaded Successfully! 🙌🏻</h1>
                        <p class="font-medium text-aktiv-grey">All your competition documents have been submitted and will be reviewed by our judges.</p>
                    </div>
                </div>
                
                <!-- Document Details -->
                <div class="flex flex-col gap-6 rounded-3xl p-8 bg-[#F0FDF4] border border-[#16A34A]">
                    <h2 class="font-semibold text-lg text-[#16A34A]">Documents Upload Summary</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="flex items-center justify-between p-3 rounded-lg bg-white border border-[#E6E7EB]">
                            <div class="flex items-center gap-3">
                                <img src="{{asset('assets/images/icons/document.svg')}}" class="w-6 h-6 flex shrink-0" alt="document">
                                <p class="font-medium text-aktiv-grey">Paper Document</p>
                            </div>
                            <a href="{{ $transaction->google_drive_makalah }}" target="_blank" class="font-semibold text-aktiv-blue hover:text-aktiv-blue/80">View</a>
                        </div>
                        <div class="flex items-center justify-between p-3 rounded-lg bg-white border border-[#E6E7EB]">
                            <div class="flex items-center gap-3">
                                <img src="{{asset('assets/images/icons/document.svg')}}" class="w-6 h-6 flex shrink-0" alt="document">
                                <p class="font-medium text-aktiv-grey">Attachment</p>
                            </div>
                            <a href="{{ $transaction->google_drive_lampiran }}" target="_blank" class="font-semibold text-aktiv-blue hover:text-aktiv-blue/80">View</a>
                        </div>
                        <div class="flex items-center justify-between p-3 rounded-lg bg-white border border-[#E6E7EB]">
                            <div class="flex items-center gap-3">
                                <img src="{{asset('assets/images/icons/video.svg')}}" class="w-6 h-6 flex shrink-0" alt="video">
                                <p class="font-medium text-aktiv-grey">Before Video</p>
                            </div>
                            <a href="{{ $transaction->google_drive_video_sebelum }}" target="_blank" class="font-semibold text-aktiv-blue hover:text-aktiv-blue/80">Watch</a>
                        </div>
                        <div class="flex items-center justify-between p-3 rounded-lg bg-white border border-[#E6E7EB]">
                            <div class="flex items-center gap-3">
                                <img src="{{asset('assets/images/icons/video.svg')}}" class="w-6 h-6 flex shrink-0" alt="video">
                                <p class="font-medium text-aktiv-grey">After Video</p>
                            </div>
                            <a href="{{ $transaction->google_drive_video_sesudah }}" target="_blank" class="font-semibold text-aktiv-blue hover:text-aktiv-blue/80">Watch</a>
                        </div>
                    </div>
                </div>
                
                <!-- What's Next Information -->
                <div class="flex flex-col gap-4 p-6 rounded-xl bg-[#F0F9FF] border border-[#0EA5E9]">
                    <div class="flex items-center gap-3">
                        <img src="{{asset('assets/images/icons/info.svg')}}" class="w-6 h-6 text-[#0EA5E9]" alt="info">
                        <h3 class="font-semibold text-lg leading-[27px] text-[#0EA5E9]">What's Next?</h3>
                    </div>
                    <p class="font-medium text-[#0369A1] ml-9">
                        Your documents will be reviewed by our judges. You can always check your registration status using your Transaction ID: <strong>{{ $transaction->registration_trx_id }}</strong>
                    </p>
                </div>

                <!-- Action Buttons -->
                <div class="flex flex-col gap-4">
                    <!-- Primary Actions Row -->
                    <div class="flex gap-4">
                        <a href="{{ route('event.check_registration_details') }}?registration_trx_id={{ $transaction->registration_trx_id }}" class="flex-1 flex items-center justify-center gap-2 rounded-full py-4 px-8 bg-aktiv-orange hover:bg-aktiv-orange/90 transition-all duration-300">
                            <img src="{{asset('assets/images/icons/receipt.svg')}}" class="w-8 h-8 flex shrink-0" alt="icon">
                            <span class="font-semibold text-lg leading-[27px] text-white">View Registration Details</span>
                        </a>
                    </div>

                    <!-- Secondary Actions Row -->
                    <div class="flex gap-4">
                        <a href="{{ route('event.check_registration') }}" class="flex-1 flex items-center justify-center gap-2 rounded-full py-4 px-8 border border-aktiv-grey text-aktiv-grey hover:bg-aktiv-grey/10 transition-all duration-300">
                            <img src="{{asset('assets/images/icons/arrow-left.svg')}}" class="w-6 h-6 flex shrink-0" alt="icon">
                            <span class="font-semibold text-lg leading-[27px]">Check Another Registration</span>
                        </a>
                        <a href="{{ route('front.index') }}" class="flex-1 flex items-center justify-center gap-2 rounded-full py-4 px-8 border border-aktiv-grey text-aktiv-grey hover:bg-aktiv-grey/10 transition-all duration-300">
                            <img src="{{asset('assets/images/icons/home.svg')}}" class="w-6 h-6 flex shrink-0" alt="icon">
                            <span class="font-semibold text-lg leading-[27px]">Back to Homepage</span>
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
        // Add animation for success icon
        const successIcon = document.querySelector('img[alt="success icon"]');
        if (successIcon) {
            successIcon.style.animation = 'bounce 1s ease-in-out';
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
    @keyframes bounce {
        0%, 100% {
            transform: translateY(0);
        }
        50% {
            transform: translateY(-20px);
        }
    }
</style>
@endpush