@extends('layout.app')
@section('title')
Events List - PT Wahana Kendali Mutu
@endsection
@section('content')
<div class="h-[112px]">
    <x-nav />
</div>

<div id="background" class="relative w-full">
    <div class="absolute w-full h-[300px] bg-[linear-gradient(0deg,#4EB6F5_0%,#5B8CE9_100%)] -z-10"></div>
</div>

<section id="EventsHeader" class="w-full max-w-[1280px] mx-auto px-[52px] mt-16 mb-[100px]">
    <div class="flex flex-col gap-16">
        <!-- Header Section -->
        <div class="flex flex-col items-center gap-1">
            <p class="font-bold text-[32px] leading-[48px] capitalize text-white">Available Events</p>
            <div class="flex items-center gap-2 text-white">
                <a href="{{ route('front.index') }}" class="font-medium">Homepage</a>
                <span>></span>
                <a class="last:font-semibold">Events</a>
            </div>
        </div>

        <!-- Search Section -->
        <div class="flex flex-col gap-8 bg-white rounded-2xl p-8">
            <!-- Search Bar -->
            <form method="GET" action="{{ route('event.index') }}" class="search-form">
                <div class="flex items-center gap-4">
                    <div class="flex items-center flex-1 rounded-xl p-4 bg-[#FBFBFB] overflow-hidden">
                        <img src="{{asset('assets/images/icons/search-normal.svg')}}" class="w-6 h-6 flex shrink-0" alt="search">
                        <input type="text" name="search" value="{{ request()->get('search') }}" class="appearance-none bg-transparent w-full outline-none text-lg leading-[27px] font-medium ml-2 search-input" placeholder="Search for events...">
                    </div>
                    <button type="submit" class="flex items-center justify-center h-16 px-8 rounded-xl bg-aktiv-blue text-white font-semibold">
                        Search
                    </button>
                </div>
            </form>
        </div>

        <!-- Debug Info (Local Environment Only) -->
        @if(app()->environment('local') && session('debug_search'))
        <div class="bg-yellow-100 p-4 rounded-lg mb-4">
            <p class="font-semibold">Debug Info:</p>
            <p>Search term: "{{ session('debug_search') }}"</p>
            <p>Results: {{ $events->total() }}</p>
        </div>
        @endif

        <!-- Events Counter and View Toggle -->
        <div class="flex items-center justify-between">
            <h2 class="font-Neue-Plak-bold text-2xl leading-[33.6px]">Found {{ $events->count() }} Events</h2>
            
            <div class="flex items-center gap-2">
                <button class="p-2 rounded-lg bg-aktiv-blue" id="gridViewBtn">
                    <img src="{{asset('assets/images/icons/grid.svg')}}" class="w-6 h-6" alt="grid view">
                </button>
                <button class="p-2 rounded-lg" id="listViewBtn">
                    <img src="{{asset('assets/images/icons/list.svg')}}" class="w-6 h-6" alt="list view">
                </button>
            </div>
        </div>

        <!-- Events Grid -->
        <div class="grid grid-cols-3 gap-6" id="eventsContainer">
            @forelse ($events as $event)
            <a href="{{ route('event.show', $event->id) }}" class="flex flex-col rounded-2xl overflow-hidden bg-white hover:shadow-lg transition-all duration-300">
                <!-- Event Thumbnail -->
                <div class="relative flex w-full h-[240px] overflow-hidden bg-[#D9D9D9]">
                    <img src="{{ Storage::url($event->thumbnail) }}" class="w-full h-full object-cover" alt="{{ $event->nama }}">
                    
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
                    @else
                    <div class="absolute top-3 left-3 flex items-center rounded-full py-3 px-5 gap-1 bg-aktiv-red text-white z-10">
                        <img src="{{asset('assets/images/icons/sand-timer.svg')}}" class="w-6 h-6" alt="icon">
                        <span class="font-semibold">CLOSED</span>
                    </div>
                    @endif
                </div>
                
                <!-- Event Details -->
                <div class="flex flex-col gap-4 p-6">
                    <div class="flex flex-col gap-3">
                        <!-- Date and Time -->
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-1">
                                <img src="{{asset('assets/images/icons/calendar-2.svg')}}" class="w-4 h-4 flex shrink-0" alt="icon">
                                <span class="font-medium text-sm text-aktiv-grey">
                                    {{ \Carbon\Carbon::parse($event->tanggal)->translatedFormat('d F Y') }}
                                </span>
                            </div>
                            <div class="flex items-center gap-1">
                                <img src="{{asset('assets/images/icons/timer.svg')}}" class="w-4 h-4 flex shrink-0" alt="icon">
                                <span class="font-medium text-sm text-aktiv-grey">
                                    {{ $event->time_at ? \Carbon\Carbon::parse($event->time_at)->format('H:i A') : '00:00' }}
                                </span>
                            </div>
                        </div>
                        
                        <!-- Event Name -->
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
            <!-- Empty State -->
            <div class="col-span-3 flex flex-col items-center justify-center py-16">
                <img src="{{asset('assets/images/icons/Kick off date.png')}}" class="w-24 h-24 mb-6" alt="No events">
                <p class="font-semibold text-xl text-aktiv-grey text-center">No events available at the moment</p>
                <p class="text-aktiv-grey text-center mt-2">Please check back later for upcoming events</p>
            </div>
            @endforelse
        </div>

        <!-- Pagination -->
        @if($events->count() > 0 && $events instanceof \Illuminate\Pagination\LengthAwarePaginator)
        <div class="flex justify-center mt-8">
            {{ $events->links() }}
        </div>
        @endif
    </div>
</section>
@endsection

@push('after-scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Search functionality
        const searchForm = document.querySelector('.search-form');
        const searchInput = document.querySelector('.search-input');
        
        if (searchForm) {
            searchForm.addEventListener('submit', function(e) {
                if (searchInput.value.trim() === '') {
                    e.preventDefault();
                }
            });
        }
        
        // View toggle functionality
        const gridViewBtn = document.getElementById('gridViewBtn');
        const listViewBtn = document.getElementById('listViewBtn');
        const eventsContainer = document.getElementById('eventsContainer');
        
        if (gridViewBtn && listViewBtn && eventsContainer) {
            // Grid view handler
            gridViewBtn.addEventListener('click', function() {
                eventsContainer.classList.remove('grid-cols-1');
                eventsContainer.classList.add('grid-cols-3');
                gridViewBtn.classList.add('bg-aktiv-blue');
                listViewBtn.classList.remove('bg-aktiv-blue');
                
                resetCardLayout();
            });
            
            // List view handler
            listViewBtn.addEventListener('click', function() {
                eventsContainer.classList.remove('grid-cols-3');
                eventsContainer.classList.add('grid-cols-1');
                listViewBtn.classList.add('bg-aktiv-blue');
                gridViewBtn.classList.remove('bg-aktiv-blue');
                
                applyListViewLayout();
            });
            
            // Helper functions
            function applyListViewLayout() {
                const eventCards = document.querySelectorAll('#eventsContainer > a');
                eventCards.forEach(card => {
                    card.classList.add('flex-row');
                    const thumbnail = card.querySelector('.relative');
                    if (thumbnail) thumbnail.classList.add('w-1/3');
                    const details = card.querySelector('.flex-col.gap-4');
                    if (details) details.classList.add('w-2/3');
                });
            }
            
            function resetCardLayout() {
                const eventCards = document.querySelectorAll('#eventsContainer > a');
                eventCards.forEach(card => {
                    card.classList.remove('flex-row');
                    const thumbnail = card.querySelector('.relative');
                    if (thumbnail) thumbnail.classList.remove('w-1/3');
                    const details = card.querySelector('.flex-col.gap-4');
                    if (details) details.classList.remove('w-2/3');
                });
            }
        }
    });
</script>
@endpush