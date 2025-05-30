@extends('layout.app')
@section('title', $event->nama)
@section('content')

<div class="h-[112px]">
    <x-nav />
</div>

<div id="background" class="relative w-full">
    <div class="absolute w-full h-[300px] bg-[linear-gradient(0deg,#4EB6F5_0%,#5B8CE9_100%)] -z-10"></div>
</div>

<section id="Category" class="w-full max-w-[1280px] mx-auto px-[52px] mt-16 mb-[100px]">
    <div class="flex flex-col gap-16">
        <!-- Header Section -->
        <div class="flex flex-col items-center gap-1">
            <p class="font-bold text-[32px] leading-[48px] capitalize text-white">Event Details</p>
            <div class="flex items-center gap-2 text-white">
                <a href="{{ route('front.index') }}" class="last:font-semibold">Homepage</a>
                <span>></span>
                <a href="{{ route('event.index') }}" class="last:font-semibold">Events</a>
                <span>></span>
                <a class="last:font-semibold">{{ $event->nama }}</a>
            </div>
        </div>

        <!-- Main Content -->
        <main class="flex gap-8">
            <!-- Left Content Section -->
            <section id="Details" class="flex flex-col w-[724px] rounded-2xl gap-8 p-8 bg-white">
                <!-- Event Thumbnail -->
                <div id="Thumbnail" class="relative flex w-full h-[369px] rounded-2xl overflow-hidden bg-[#D9D9D9]">
                    @if($event->thumbnail)
                        <img src="{{ Storage::url($event->thumbnail) }}" class="w-full h-full object-cover" alt="{{ $event->nama }}">
                    @else
                        <div class="w-full h-full bg-gradient-to-br from-aktiv-blue to-aktiv-orange flex items-center justify-center">
                            <span class="text-white text-6xl font-bold">{{ substr($event->nama, 0, 1) }}</span>
                        </div>
                    @endif
                    
                    <!-- Status Badge -->
                    @if($event->is_open)
                        @if($event->has_started)
                        <div class="absolute top-3 left-3 flex items-center rounded-full py-3 px-5 gap-1 bg-aktiv-orange text-white z-10">
                            <img src="{{asset('assets/images/icons/timer-start.svg')}}" class="w-6 h-6" alt="icon">
                            <span class="font-semibold">STARTED</span>
                        </div>
                        @else
                        <div class="absolute top-3 left-3 flex items-center rounded-full py-3 px-5 gap-1 bg-aktiv-green text-white z-10">
                            <img src="{{asset('assets/images/icons/medal-star.svg')}}" class="w-6 h-6" alt="icon">
                            <span class="font-semibold">OPEN</span>
                        </div>
                        @endif
                    @else
                        @if($event->has_started)
                        <div class="absolute top-3 left-3 flex items-center rounded-full py-3 px-5 gap-1 bg-aktiv-orange text-white z-10">
                            <img src="{{asset('assets/images/icons/timer-start.svg')}}" class="w-6 h-6" alt="icon">
                            <span class="font-semibold">STARTED</span>
                        </div>
                        @else
                        <div class="absolute top-3 left-3 flex items-center rounded-full py-3 px-5 gap-1 bg-aktiv-red text-white z-10">
                            <img src="{{asset('assets/images/icons/sand-timer.svg')}}" class="w-6 h-6" alt="icon">
                            <span class="font-semibold">CLOSED</span>
                        </div>
                        @endif
                    @endif
                </div>

                <!-- Event Header -->
                <section id="Header" class="flex flex-col gap-6">
                    <div id="Rating" class="flex items-center gap-4">
                        <div class="flex items-center rounded-md border border-aktiv-green py-2 px-3 gap-[5px] bg-aktiv-green/[9%]">
                            <img src="{{asset('assets/images/icons/format-circle.svg')}}" class="w-6 h-6 flex shrink-0" alt="icon">
                            <p class="font-medium text-aktiv-green capitalize">Event</p>
                        </div>
                        <div class="flex items-center gap-1">
                            <div class="flex items-center">
                                <img src="{{asset('assets/images/icons/Star 1.svg')}}" class="p-[4px] w-6 h-6" alt="star">
                                <img src="{{asset('assets/images/icons/Star 1.svg')}}" class="p-[4px] w-6 h-6" alt="star">
                                <img src="{{asset('assets/images/icons/Star 1.svg')}}" class="p-[4px] w-6 h-6" alt="star">
                                <img src="{{asset('assets/images/icons/Star 1.svg')}}" class="p-[4px] w-6 h-6" alt="star">
                                <img src="{{asset('assets/images/icons/Star 1.svg')}}" class="p-[4px] w-6 h-6" alt="star">
                            </div>
                            <p class="font-semibold text-lg leading-[27px]">4.8 <span class="font-medium text-aktiv-grey">({{ $event->total_participants }} Registered)</span></p>
                        </div>
                    </div>
                    
                    <div id="Title" class="flex flex-col gap-3">
                        <h1 class="font-Neue-Plak-bold text-2xl leading-[33.6px] capitalize">
                            {{ $event->nama }}
                        </h1>
                        <div class="grid grid-cols-2 gap-6">
                            <!-- Event Date -->
                            <div class="flex items-center justify-between rounded-2xl border border-[#E6E7EB] p-5 gap-4 bg-white">
                                <div class="flex flex-col gap-2">
                                    <p class="font-medium text-aktiv-grey">Event Date</p>
                                    <p class="font-semibold text-lg leading-[27px]">{{ $event->tanggal->format('d F Y') }}</p>
                                </div>
                                <img src="{{asset('assets/images/icons/calendar.svg')}}" class="w-16 h-16 flex shrink-0" alt="icon">
                            </div>
                            
                            <!-- Event Time -->
                            <div class="flex items-center justify-between rounded-2xl border border-[#E6E7EB] p-5 gap-4 bg-white">
                                <div class="flex flex-col gap-2">
                                    <p class="font-medium text-aktiv-grey">Event Time</p>
                                    <p class="font-semibold text-lg leading-[27px]">
                                        @if($event->time_at)
                                            {{ $event->time_at->format('H:i') }} WIB
                                        @else
                                            TBA
                                        @endif
                                    </p>
                                </div>
                                <img src="{{asset('assets/images/icons/clock.svg')}}" class="w-16 h-16 flex shrink-0" alt="icon">
                            </div>
                        </div>
                    </div>
                </section>

                <!-- Event Description -->
                <div id="Descriptions" class="flex flex-col gap-4">
                    <h2 class="font-Neue-Plak-bold text-xl leading-[27.5px]">About This Event</h2>
                    <p class="group relative font-medium leading-[28.8px] text-aktiv-grey">
                        <span class="line-clamp-4 group-has-[:checked]:line-clamp-none">
                            {{ $event->deskripsi ?? 'Event description will be available soon.' }}
                        </span>
                        <label class="group absolute bottom-0 right-0 z-10 bg-white has-[:checked]:relative">
                            <input type="checkbox" class="peer hidden">
                            <span class="pr-52 before:content-['..._'] after:font-semibold after:text-aktiv-blue after:content-['Read_More...'] group-has-[:checked]:pr-0 group-has-[:checked]:after:content-['See_Less'] group-has-[:checked]:before:content-['']"></span>
                        </label>
                    </p>
                </div>

                <!-- Event Benefits -->
                @if($event->benefits && $event->benefits->count() > 0)
                <div id="Benefits" class="flex flex-col gap-4">
                    <h2 class="font-Neue-Plak-bold text-xl leading-[27.5px]">What You'll Get</h2>
                    <div class="grid grid-cols-1 gap-4">
                        @foreach($event->benefits as $benefit)
                        <div class="flex items-center gap-2">
                            <img src="{{asset('assets/images/icons/tick-circle.svg')}}" class="w-6 h-6 flex shrink-0" alt="icon">
                            <p class="font-semibold text-lg leading-[27px]">{{ $benefit->name }}</p>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif

                <!-- Location Details -->
                @if($event->lokasi)
                <div id="Location" class="flex flex-col gap-4">
                    <h2 class="font-Neue-Plak-bold text-xl leading-[27.5px]">Location Details</h2>
                    <div class="relative flex w-full h-[360px] rounded-2xl overflow-hidden bg-[#D9D9D9]">
                        @if($event->venue_thumbnail)
                        <div class="absolute left-5 top-1/2 transform -translate-y-1/2 flex flex-col w-[260px] h-fit max-h-[320px] gap-4 rounded-2xl p-5 bg-white">
                            <div class="flex w-full h-[124px] rounded-xl overflow-hidden">
                                <img src="{{ Storage::url($event->venue_thumbnail) }}" class="w-full h-full object-cover" alt="venue">
                            </div>
                            <div class="flex flex-col gap-3 justify-between">
                                <p class="font-medium leading-[25.6px] text-aktiv-grey line-clamp-4">
                                    {{ $event->lokasi }}
                                </p>
                                <a href="http://maps.google.com/?q={{ urlencode($event->lokasi) }}" class="font-semibold text-aktiv-orange">View in Google Maps</a>
                            </div>
                        </div>
                        <img src="{{ Storage::url($event->bg_map) }}" class="w-full h-full object-cover" alt="venue">
                        @else
                        <div class="absolute left-5 top-1/2 transform -translate-y-1/2 flex flex-col w-[260px] h-fit max-h-[320px] gap-4 rounded-2xl p-5 bg-white">
                            <div class="flex w-full h-[124px] rounded-xl overflow-hidden bg-gradient-to-br from-aktiv-blue/20 to-aktiv-orange/20 items-center justify-center">
                                <img src="{{asset('assets/images/icons/location.svg')}}" class="w-12 h-12 text-aktiv-blue" alt="location">
                            </div>
                            <div class="flex flex-col gap-3 justify-between">
                                <p class="font-medium leading-[25.6px] text-aktiv-grey line-clamp-4">
                                    {{ $event->lokasi }}
                                </p>
                                <a href="http://maps.google.com/?q={{ urlencode($event->lokasi) }}" class="font-semibold text-aktiv-orange">View in Google Maps</a>
                            </div>
                        </div>
                        <div class="w-full h-full bg-gradient-to-br from-aktiv-blue/10 to-aktiv-orange/10 flex items-center justify-center">
                            <img src="{{asset('assets/images/icons/location.svg')}}" class="w-24 h-24 text-aktiv-blue opacity-50" alt="location">
                        </div>
                        @endif
                    </div>
                </div>
                @endif
            </section>

            <!-- Right Sidebar -->
            <section id="Sidebar" class="flex flex-col w-[420px] gap-8">
                <!-- Event Information Card -->
                <div class="flex flex-col rounded-3xl p-8 gap-4 bg-white">
                    <h2 class="font-Neue-Plak-bold text-xl leading-[27.5px]">Event Information</h2>
                    
                    <!-- Event Details Grid -->
                    <div class="flex flex-col gap-4">
                        <!-- Date -->
                        <div class="flex items-center gap-3">
                            <img src="{{asset('assets/images/icons/calendar.svg')}}" class="w-8 h-8 flex shrink-0" alt="icon">
                            <div class="flex flex-col flex-1">
                                <p class="font-medium text-aktiv-grey text-sm">Date</p>
                                <p class="font-semibold text-lg leading-[27px]">{{ $event->tanggal->format('d F Y') }}</p>
                            </div>
                        </div>

                        <!-- Time -->
                        @if($event->time_at)
                        <div class="flex items-center gap-3">
                            <img src="{{asset('assets/images/icons/clock.svg')}}" class="w-8 h-8 flex shrink-0" alt="icon">
                            <div class="flex flex-col flex-1">
                                <p class="font-medium text-aktiv-grey text-sm">Time</p>
                                <p class="font-semibold text-lg leading-[27px]">{{ $event->time_at->format('H:i') }} WIB</p>
                            </div>
                        </div>
                        @endif

                        <!-- Location -->
                        <div class="flex items-center gap-3">
                            <img src="{{asset('assets/images/icons/location.svg')}}" class="w-8 h-8 flex shrink-0" alt="icon">
                            <div class="flex flex-col flex-1">
                                <p class="font-medium text-aktiv-grey text-sm">Location</p>
                                <p class="font-semibold text-lg leading-[27px] line-clamp-2">{{ $event->lokasi }}</p>
                            </div>
                        </div>

                        <!-- Participants -->
                        <div class="flex items-center gap-3">
                            <img src="{{asset('assets/images/icons/profile-2user.svg')}}" class="w-8 h-8 flex shrink-0" alt="icon">
                            <div class="flex flex-col flex-1">
                                <p class="font-medium text-aktiv-grey text-sm">Registered</p>
                                <p class="font-semibold text-lg leading-[27px]">{{ $event->total_participants }} participants</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Registration Card -->
                <div class="flex flex-col rounded-3xl pt-8 gap-6 bg-white">
                    <!-- Price Section -->
                    <div class="flex flex-col mx-8 gap-4">
                        <h2 class="font-Neue-Plak-bold text-xl leading-[27.5px]">Registration Fee</h2>
                        <div class="flex items-center gap-[6px]">
                            <p class="font-bold text-[32px] leading-[48px] text-aktiv-red">
                                Rp{{ number_format($event->price ?? 0, 0, ',', '.') }}
                            </p>
                            <p class="font-semibold text-aktiv-grey">/person</p>
                        </div>
                        <p class="text-sm text-aktiv-grey">*Including PPN 11%</p>
                    </div>

                    <!-- Registration Stats -->
                    <div class="flex items-center justify-between mx-8 rounded-2xl border border-r-2 border-b-2 border-[#E6E7EB] py-4 px-6 gap-2">
                        <div class="flex flex-col gap-1">
                            <p class="font-medium text-aktiv-grey">Total Registered:</p>
                            <p class="font-semibold text-lg leading-[27px]">{{ $event->total_participants }} People Joined</p>
                        </div>
                        <img src="{{asset('assets/images/icons/profile-2user.svg')}}" class="w-[56px] h-[56px]" alt="icon">
                    </div>

                    <!-- Event Benefits Summary -->
                    @if($event->benefits && $event->benefits->count() > 0)
                    <div class="flex flex-col mx-8 gap-4">
                        <h2 class="font-Neue-Plak-bold text-xl leading-[27.5px]">What You'll Get</h2>
                        @foreach($event->benefits->take(3) as $benefit)
                            <div class="flex items-center gap-2">
                                <img src="{{asset('assets/images/icons/tick-circle.svg')}}" class="w-6 h-6 flex shrink-0" alt="icon">
                                <p class="font-semibold text-lg leading-[27px]">{{ $benefit->name }}</p>
                            </div>
                        @endforeach
                        @if($event->benefits->count() > 3)
                            <p class="font-medium text-aktiv-grey text-sm">+{{ $event->benefits->count() - 3 }} more benefits</p>
                        @endif
                    </div>
                    @endif

                    <!-- Registration Button -->
                    <div class="flex flex-col">
                        @if($event->is_open && !$event->has_started)
                            <a href="{{ route('event.register', $event->id) }}" class="flex items-center justify-center mx-8 h-16 rounded-xl px-6 gap-[10px] bg-aktiv-orange font-semibold text-lg leading-[27px] text-white mb-8 hover:bg-aktiv-orange/90 transition-colors">
                                <span>Register Now</span>
                                <img src="{{asset('assets/images/icons/arrow-right.svg')}}" class="w-6 h-6" alt="icon">
                            </a>
                        @elseif($event->has_started)
                            <div class="flex items-center justify-center mx-8 h-16 rounded-xl px-6 gap-[10px] bg-[#E6E7EB] font-semibold text-lg leading-[27px] text-aktiv-grey mb-8">
                                Event Has Started
                            </div>
                            <div class="p-4 bg-aktiv-grey">
                                <p class="font-semibold text-lg leading-[27px] text-center text-white">Event registration is closed as the event has already started.</p>
                            </div>
                        @else
                            <div class="flex items-center justify-center mx-8 h-16 rounded-xl px-6 gap-[10px] bg-[#E6E7EB] font-semibold text-lg leading-[27px] text-aktiv-grey mb-8">
                                Registration Closed
                            </div>
                            <div class="p-4 bg-aktiv-red">
                                <p class="font-semibold text-lg leading-[27px] text-center text-white">Oops! Sorry, registration for this event is now closed 🙌🏻</p>
                            </div>
                        @endif
                        
                        <!-- Check Registration Link -->
                        @if($event->is_open || $event->has_started)
                        <div class="text-center mt-4 mx-8">
                            <p class="text-sm text-aktiv-grey mb-2">Already registered?</p>
                            <a href="{{ route('event.check_registration') }}" class="font-semibold text-aktiv-blue hover:text-aktiv-blue/80 transition-colors">
                                Check Registration Status
                            </a>
                        </div>
                        @endif
                    </div>
                </div>
            </section>
        </main>
    </div>
</section>

@endsection