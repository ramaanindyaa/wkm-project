@extends('layout.app')
@section('title', $event->nama)
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
            <p class="font-bold text-[32px] leading-[48px] capitalize text-white">{{ $event->nama }}</p>
            <div class="flex items-center gap-2 text-white">
                <a href="{{ route('front.index') }}" class="font-medium">Homepage</a>
                <span>></span>
                <a href="{{ route('event.index') }}" class="font-medium">Events</a>
                <span>></span>
                <span class="font-medium">{{ $event->nama }}</span>
            </div>
        </div>

        <!-- Event Details Content -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Main Content -->
            <div class="lg:col-span-2 flex flex-col gap-8">
                <!-- Event Image -->
                <div class="flex w-full h-[400px] rounded-2xl overflow-hidden">
                    @if($event->thumbnail)
                        <img src="{{ Storage::url($event->thumbnail) }}" class="w-full h-full object-cover" alt="{{ $event->nama }}">
                    @else
                        <div class="w-full h-full bg-gradient-to-br from-aktiv-blue to-aktiv-orange flex items-center justify-center">
                            <span class="text-white text-6xl font-bold">{{ substr($event->nama, 0, 1) }}</span>
                        </div>
                    @endif
                </div>

                <!-- Event Description -->
                <div class="flex flex-col gap-6 rounded-3xl p-8 bg-white">
                    <h2 class="font-Neue-Plak-bold text-2xl leading-[33px]">About This Event</h2>
                    <div class="prose prose-lg max-w-none">
                        {!! nl2br(e($event->deskripsi ?? 'Event description will be available soon.')) !!}
                    </div>
                </div>

                <!-- Event Benefits -->
                @if($event->benefits && $event->benefits->count() > 0)
                <div class="flex flex-col gap-6 rounded-3xl p-8 bg-white">
                    <h2 class="font-Neue-Plak-bold text-2xl leading-[33px]">What You'll Get</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        @foreach($event->benefits as $benefit)
                        <div class="flex items-center gap-3">
                            <div class="w-6 h-6 rounded-full bg-aktiv-green flex items-center justify-center">
                                <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                </svg>
                            </div>
                            <p class="font-medium">{{ $benefit->name }}</p>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif

                <!-- Location Details -->
                @if($event->lokasi)
                <div class="flex flex-col gap-6 rounded-3xl p-8 bg-white">
                    <h2 class="font-Neue-Plak-bold text-2xl leading-[33px]">Location Details</h2>
                    <div class="flex flex-col gap-4">
                        @if($event->venue_thumbnail)
                        <div class="flex w-full h-[200px] rounded-xl overflow-hidden">
                            <img src="{{ Storage::url($event->venue_thumbnail) }}" class="w-full h-full object-cover" alt="venue">
                        </div>
                        @endif
                        <div class="flex flex-col gap-3">
                            <p class="font-medium text-aktiv-grey">{{ $event->lokasi }}</p>
                            <a href="http://maps.google.com/?q={{ urlencode($event->lokasi) }}" class="font-semibold text-aktiv-orange hover:text-aktiv-orange/80 transition-colors">View in Google Maps</a>
                        </div>
                    </div>
                </div>
                @endif
            </div>

            <!-- Sidebar - Registration Card -->
            <div class="lg:col-span-1">
                <div class="sticky top-8 flex flex-col gap-6 rounded-3xl p-8 bg-white shadow-lg">
                    <!-- Event Basic Info -->
                    <div class="flex flex-col gap-4">
                        <h3 class="font-Neue-Plak-bold text-xl">Event Information</h3>
                        
                        <!-- Date -->
                        <div class="flex items-center gap-3">
                            <img src="{{asset('assets/images/icons/calendar.svg')}}" class="w-5 h-5 flex shrink-0" alt="icon">
                            <div class="flex flex-col">
                                <p class="font-medium text-aktiv-grey text-sm">Date</p>
                                <p class="font-semibold">{{ $event->tanggal->format('d F Y') }}</p>
                            </div>
                        </div>

                        <!-- Time -->
                        @if($event->time_at)
                        <div class="flex items-center gap-3">
                            <img src="{{asset('assets/images/icons/clock.svg')}}" class="w-5 h-5 flex shrink-0" alt="icon">
                            <div class="flex flex-col">
                                <p class="font-medium text-aktiv-grey text-sm">Time</p>
                                <p class="font-semibold">{{ $event->time_at->format('H:i') }} WIB</p>
                            </div>
                        </div>
                        @endif

                        <!-- Location -->
                        <div class="flex items-center gap-3">
                            <img src="{{asset('assets/images/icons/location.svg')}}" class="w-5 h-5 flex shrink-0" alt="icon">
                            <div class="flex flex-col">
                                <p class="font-medium text-aktiv-grey text-sm">Location</p>
                                <p class="font-semibold">{{ $event->lokasi }}</p>
                            </div>
                        </div>

                        <!-- Participants Count -->
                        <div class="flex items-center gap-3">
                            <img src="{{asset('assets/images/icons/profile-2user.svg')}}" class="w-5 h-5 flex shrink-0" alt="icon">
                            <div class="flex flex-col">
                                <p class="font-medium text-aktiv-grey text-sm">Registered</p>
                                <p class="font-semibold">{{ $event->total_participants }} participants</p>
                            </div>
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

                    <!-- Registration Status -->
                    @if($event->is_open && !$event->has_started)
                        <!-- Registration Button -->
                        <a href="{{ route('event.register', $event->id) }}" class="w-full rounded-xl h-14 px-6 text-center bg-aktiv-orange font-semibold text-lg leading-[27px] text-white hover:bg-aktiv-orange/90 transition-colors flex items-center justify-center gap-2">
                            <span>Register Now</span>
                            <img src="{{asset('assets/images/icons/arrow-right.svg')}}" class="w-5 h-5" alt="icon">
                        </a>
                        
                        <!-- Additional Info -->
                        <div class="text-center">
                            <p class="text-sm text-aktiv-grey">Registration is open</p>
                        </div>
                    @elseif($event->has_started)
                        <!-- Event Started -->
                        <div class="w-full rounded-xl h-14 px-6 text-center bg-aktiv-grey font-semibold text-lg leading-[27px] text-white flex items-center justify-center">
                            Event Has Started
                        </div>
                        <div class="text-center">
                            <p class="text-sm text-aktiv-grey">Registration is closed</p>
                        </div>
                    @else
                        <!-- Registration Closed -->
                        <div class="w-full rounded-xl h-14 px-6 text-center bg-aktiv-grey font-semibold text-lg leading-[27px] text-white flex items-center justify-center">
                            Registration Closed
                        </div>
                        <div class="text-center">
                            <p class="text-sm text-aktiv-grey">Event registration is currently closed</p>
                        </div>
                    @endif

                    <!-- Check Registration Link -->
                    <div class="text-center pt-4 border-t border-[#E6E7EB]">
                        <p class="text-sm text-aktiv-grey mb-2">Already registered?</p>
                        <a href="{{ route('event.check_registration') }}" class="font-semibold text-aktiv-blue hover:text-aktiv-blue/80 transition-colors">
                            Check Registration Status
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection