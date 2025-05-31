<nav class="fixed top-0 flex items-center w-full justify-between p-8 bg-white z-30 shadow-sm">
    <a href="{{route('front.index')}}" class="shrink-0">
        <img src="{{asset('assets/images/logos/Logo.svg')}}" class="h-14" alt="logo">
    </a>
    
    <ul class="flex items-center justify-center gap-8">
        <li>
            <a href="{{route('front.check_booking')}}" class="font-medium text-aktiv-grey hover:font-semibold hover:text-aktiv-orange transition-all duration-300">
                View My Booking
            </a>
        </li>
        <li>
            <a href="{{ route('event.check_registration') }}" class="font-medium text-aktiv-grey hover:font-semibold hover:text-aktiv-orange transition-all duration-300">
                Check Event Registration
            </a>
        </li>
        <li>
            <a href="{{route('front.index')}}#Workshops" class="font-medium text-aktiv-grey hover:font-semibold hover:text-aktiv-orange transition-all duration-300">
                Workshop
            </a>
        </li>
        <li>
            <a href="{{route('front.index')}}#Categories" class="font-medium text-aktiv-grey hover:font-semibold hover:text-aktiv-orange transition-all duration-300">
                Community
            </a>
        </li>
        <li>
            <a href="{{route('front.index')}}#Testimony" class="font-medium text-aktiv-grey hover:font-semibold hover:text-aktiv-orange transition-all duration-300">
                Testimony
            </a>
        </li>
        <li>
            <a href="{{ route('event.index') }}" class="font-medium {{ request()->routeIs('event.index') ? 'text-aktiv-blue font-semibold' : 'text-aktiv-grey' }} hover:font-semibold hover:text-aktiv-orange transition-all duration-300">
                Events
            </a>
        </li>
    </ul>
    
    <a href="https://wa.me/your-phone-number" target="_blank" class="flex items-center rounded-full h-12 px-6 gap-[10px] w-fit shrink-0 bg-aktiv-green hover:bg-aktiv-green/90 transition-all duration-300">
        <span class="font-semibold text-white">Contact CS</span>
        <img src="{{asset('assets/images/icons/whatsapp.svg')}}" class="w-6 h-6" alt="icon">
    </a>
</nav>