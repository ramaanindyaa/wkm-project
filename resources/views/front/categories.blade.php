@extends('layout.app')
@section('title')
All Categories
@endsection
@section('content')

<div class="h-[112px]">
    <x-nav />
</div>
<section id="Categories" class="w-full max-w-[1280px] mx-auto px-[52px] mt-[52px] mb-[100px]">
    <div class="flex flex-col gap-9">
        <div class="flex flex-col items-center gap-1">
            <h1 class="font-Neue-Plak-bold text-[32px] leading-[44.54px] capitalize">
                All Categories
            </h1>
            <div class="flex items-center gap-2 ">
                <a href="{{ route('front.index') }}" class="font-medium text-aktiv-grey">Homepage</a>
                <span>></span>
                <a class="font-medium text-aktiv-grey last:font-semibold last:text-aktiv-black">All Categories</a>
            </div>
        </div>
        <div class="grid grid-cols-4 gap-6">
            @forelse ($categories as $itemCategory)
            <a href="{{ route('front.category', $itemCategory->slug) }}" class="card">
                <div class="flex items-center h-full rounded-3xl p-5 pr-1 gap-3 bg-white">
                    <img src="{{asset(Storage::url($itemCategory->icon))}}" class="w-[56px] h-[56px] flex shrink-0" alt="icon">
                    <div class="flex flex-col gap-[2px] overflow-hidden">
                        <h3 class="font-semibold text-lg leading-[27px] break-words">
                            {{ $itemCategory->name }}
                        </h3>
                        <p class="font-medium text-aktiv-grey">
                            {{ $itemCategory->tagline }}
                        </p>
                    </div>
                </div>
            </a>
            @empty
                <p class="col-span-4 text-center py-10">Belum ada kategori</p>
            @endforelse
        </div>
    </div>
</section>
<footer class="w-full p-[52px] bg-white">
    <div class="flex flex-col w-full max-w-[1176px] mx-auto gap-8">
        <div class="flex flex-col items-center gap-4">
            <img src="{{asset('assets/images/logos/Logo-blue.svg')}}" class="h-10" alt="logo">
            <p class="font-medium text-aktiv-grey">Ipsum is a company engaged in offline education.</p>
        </div>
        <hr class="border-[#E6E7EB]">
        <div class="grid grid-cols-3 items-center">
            <p class="flex font-medium text-aktiv-grey">© 2024 Wahana Kendali Mutu Copyright</p>
            <ul class="flex items-center justify-center gap-6">
                <li class="font-medium text-aktiv-grey text-nowrap hover:font-semibold hover:text-aktiv-orange transition-all duration-300">
                    <a href="#">Workshop</a>
                </li>
                <li class="font-medium text-aktiv-grey text-nowrap hover:font-semibold hover:text-aktiv-orange transition-all duration-300">
                    <a href="#">Community</a>
                </li>
                <li class="font-medium text-aktiv-grey text-nowrap hover:font-semibold hover:text-aktiv-orange transition-all duration-300">
                    <a href="#">Testimony</a>
                </li>
                <li class="font-medium text-aktiv-grey text-nowrap hover:font-semibold hover:text-aktiv-orange transition-all duration-300">
                    <a href="#">About Us</a>
                </li>
            </ul>
            <ul class="flex items-center justify-end gap-6">
                <li class="font-medium text-aktiv-grey text-nowrap hover:font-semibold hover:text-aktiv-orange transition-all duration-300">
                    <a href="#">Instagram</a>
                </li>
                <li class="font-medium text-aktiv-grey text-nowrap hover:font-semibold hover:text-aktiv-orange transition-all duration-300">
                    <a href="#">Twitter</a>
                </li>
            </ul>
        </div>
    </div>
</footer>
@endsection