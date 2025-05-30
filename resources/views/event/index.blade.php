@extends('layout.app')
@section('title', 'All Events')
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
            <p class="font-bold text-[32px] leading-[48px] capitalize text-white">All Events</p>
            <div class="flex items-center gap-2 text-white">
                <a href="{{ route('front.index') }}" class="font-medium">Homepage</a>
                <span>></span>
                <span class="font-medium">Events</span>
            </div>
        </div>

        <!-- Events Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse ($events as $event)
            <a href="{{ route('event.show', $event->id) }}" class="card">
                <div class="flex flex-col h-full justify-between rounded-3xl p-6 gap-9 bg-white">
                    <div class="flex flex-col gap-[18px]">
                        <!-- Event Image -->
                        <div class="flex w-full h-[200px] rounded-2xl bg-[#D9D9D9] overflow-hidden">
                            @if($event->thumbnail)
                                <img src="{{ Storage::url($event->thumbnail) }}" class="w-full h-full object-cover" alt="{{ $event->nama }}">
                            @else
                                <div class="w-full h-full bg-gradient-to-br from-aktiv-blue to-aktiv-orange flex items-center justify-center">
                                    <span class="text-white text-2xl font-bold">{{ substr($event->nama, 0, 1) }}</span>
                                </div>
                            @endif
                        </div>
                        
                        <!-- Event Date -->
                        <div class="flex items-center gap-[6px]">
                            <img src="{{asset('assets/images/icons/calendar.svg')}}" class="w-6 h-6 flex shrink-0" alt="icon">
                            <p class="font-medium text-aktiv-grey">
                                {{ $event->tanggal->format('d M Y') }}
                                @if($event->time_at)
                                    • {{ $event->time_at->format('H:i') }} WIB
                                @endif
                            </p>
                        </div>
                        
                        <!-- Event Title -->
                        <h3 class="min-h-[56px] font-semibold text-xl line-clamp-2 hover:line-clamp-none">
                            {{ $event->nama }}
                        </h3>
                        
                        <!-- Event Location -->
                        <p class="font-medium text-aktiv-grey">
                            {{ $event->lokasi }}
                        </p>
                    </div>
                    
                    <!-- Price and CTA -->
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-[6px]">
                            <p class="font-semibold text-2xl leading-8 text-aktiv-red">
                                Rp{{ number_format($event->price ?? 0, 0, ',', '.') }}
                            </p>
                            <p class="font-medium text-aktiv-grey">/person</p>
                        </div>
                        <div class="flex items-center justify-center rounded-full w-10 h-10 bg-aktiv-blue/10 hover:bg-aktiv-blue/20 transition-colors">
                            <img src="{{asset('assets/images/icons/arrow-right.svg')}}" class="w-5 h-5 flex shrink-0" alt="icon">
                        </div>
                    </div>
                </div>
            </a>
            @empty
                <div class="col-span-full flex flex-col items-center gap-4 py-16">
                    <img src="{{asset('assets/images/icons/calendar.svg')}}" class="w-16 h-16 opacity-50" alt="no events">
                    <div class="text-center">
                        <h3 class="font-semibold text-xl text-aktiv-grey">No Events Available</h3>
                        <p class="font-medium text-aktiv-grey">Check back later for upcoming events</p>
                    </div>
                </div>
            @endforelse
        </div>

        <!-- Pagination if needed -->
        @if(method_exists($events, 'links'))
            <div class="flex justify-center">
                {{ $events->links() }}
            </div>
        @endif
    </div>
</section>

@endsection