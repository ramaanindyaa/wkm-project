@extends('layout.app')
@section('title')
Payment Confirmation {{ $event->nama }}
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
        <!-- Header Breadcrumb -->
        <div class="flex flex-col items-center gap-1">
            <p class="font-bold text-[32px] leading-[48px] capitalize text-white">Event Registration Payment</p>
            <div class="flex items-center gap-2 text-white">
                <a href="{{ route('front.index') }}" class="font-medium">Homepage</a>
                <span>></span>
                <a href="{{ route('event.index') }}" class="font-medium">Events</a>
                <span>></span>
                <a href="{{ route('event.show', $event->id) }}" class="font-medium">Event Details</a>
                <span>></span>
                <a class="last:font-semibold">Payment Confirmation</a>
            </div>
        </div>

        <!-- Main Content -->
        <main class="flex gap-8">
            <!-- Sidebar - Event Details -->
            <section id="Sidebar" class="group flex flex-col w-[420px] h-fit rounded-3xl p-8 bg-white">
                <div class="flex flex-col gap-4">
                    <h2 class="font-Neue-Plak-bold text-xl leading-[27.5px]">Event Details</h2>
                    <div class="thumbnail-container relative h-[240px] rounded-xl bg-[#D9D9D9] overflow-hidden">
                        <img src="{{ Storage::url($event->thumbnail) }}" class="w-full h-full object-cover" alt="thumbnail">
                        
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
                        @endif
                    </div>
                    
                    <!-- Event Card Details -->
                    <div class="card-detail flex flex-col gap-2">
                        <div class="flex items-center gap-3">
                            <div class="flex items-center gap-1">
                                <img src="{{asset('assets/images/icons/calendar-2.svg')}}" class="w-6 h-6 flex shrink-0" alt="icon">
                                <span class="font-medium text-aktiv-grey">
                                    {{ \Carbon\Carbon::parse($event->tanggal)->translatedFormat('d F Y') }}
                                </span>
                            </div>
                            <div class="flex items-center gap-1">
                                <img src="{{asset('assets/images/icons/timer.svg')}}" class="w-6 h-6 flex shrink-0" alt="icon">
                                <span class="font-medium text-aktiv-grey">
                                    {{ $event->time_at ? \Carbon\Carbon::parse($event->time_at)->format('H:i A') : '00:00' }}
                                </span>
                            </div>
                        </div>
                        <h3 class="font-Neue-Plak-bold text-xl">
                            {{ $event->nama }}
                        </h3>
                        <p class="font-medium text-aktiv-grey">
                            {{ $event->lokasi }}
                        </p>
                    </div>
                </div>

                <!-- Collapsible Event Information -->
                <div id="closes-section" class="accordion flex flex-col gap-8 transition-all duration-300 mt-8 group-has-[:checked]:mt-0 group-has-[:checked]:!h-0 overflow-hidden">
                    <!-- Event Organizer -->
                    <div class="flex flex-col gap-4">
                        <h2 class="font-Neue-Plak-bold text-xl leading-[27.5px]">Event Organizer</h2>
                        <div class="flex items-center gap-3 rounded-xl border border-[#E6E7EB] p-4">
                            <div class="flex w-16 h-16 shrink-0 rounded-full overflow-hidden bg-aktiv-blue items-center justify-center">
                                <img src="{{asset('assets/images/icons/medal-star.svg')}}" class="w-10 h-10 text-white" alt="icon">
                            </div>
                            <div class="flex flex-col gap-[2px] flex-1">
                                <p class="font-semibold text-lg leading-[27px]">
                                    PT Wahana Kendali Mutu
                                </p>
                                <p class="font-medium text-aktiv-grey">
                                    Quality Control Training Company
                                </p>
                            </div>
                            <img src="{{asset('assets/images/icons/verify.svg')}}" class="flex w-[62px] h-[62px] shrink-0" alt="icon">
                        </div>
                    </div>

                    <!-- Event Benefits -->
                    <div class="flex flex-col gap-4">
                        <h2 class="font-Neue-Plak-bold text-xl leading-[27.5px]">What You'll Get</h2>
                        <div class="flex flex-col gap-6">
                            @forelse ($event->benefits as $benefit)
                            <div class="flex items-center gap-2">
                                <img src="{{asset('assets/images/icons/tick-circle.svg')}}" class="w-6 h-6 flex shrink-0" alt="icon">
                                <p class="font-semibold text-lg leading-[27px]">{{ $benefit->name }}</p>
                            </div>
                            @empty
                                <p class="font-medium text-aktiv-grey">No benefits information available.</p>
                            @endforelse
                        </div>
                    </div>

                    <!-- Location Details -->
                    <div class="flex flex-col gap-4">
                        <h2 class="font-Neue-Plak-bold text-xl leading-[27.5px]">Location Details</h2>
                        <div class="flex flex-col gap-4 rounded-xl border border-[#E6E7EB] p-5 pb-[21px]">
                            <div class="flex w-full h-[180px] rounded-xl overflow-hidden">
                                <img src="{{ Storage::url($event->venue_thumbnail) }}" class="w-full h-full object-cover" alt="location">
                            </div>
                            <div class="flex flex-col gap-3">
                                <p class="font-medium leading-[25.6px] text-aktiv-grey">
                                    {{ $event->lokasi }}
                                </p>
                                <a href="http://maps.google.com/?q={{ urlencode($event->lokasi) }}" class="font-semibold text-aktiv-orange">View in Google Maps</a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Show/Hide Toggle Button -->
                <label class="group mt-8">
                    <input type="checkbox" class="hidden">
                    <p class="before:content-['Show_Less'] group-has-[:checked]:before:content-['Show_More'] before:font-semibold before:text-lg before:leading-[27px] flex items-center justify-center gap-[6px]">
                        <img src="{{asset('assets/images/icons/arrow-up.svg')}}" class="w-6 h-6 group-has-[:checked]:rotate-180 transition-all duration-300" alt="icon">
                    </p>
                </label>
            </section>

            <!-- Payment Form -->
            <form id="Form" method="POST" enctype="multipart/form-data" action="{{ route('event.payment.store') }}" class="flex flex-col w-[724px] gap-8">
                @csrf
                <input type="hidden" name="event_id" value="{{ $event->id }}">
                
                <!-- Security Message -->
                <div class="flex items-center rounded-3xl p-8 gap-4 bg-white">
                    <img src="{{asset('assets/images/icons/shield-tick.svg')}}" class="w-[62px] h-[62px] flex shrink-0" alt="icon">
                    <div class="flex flex-col gap-[2px]">
                        <p class="font-semibold text-lg leading-[27px]">Safe Security Pro Max+</p>
                        <p class="font-medium text-aktiv-grey">Don't worry, Your data will be kept private and protected.</p>
                    </div>
                </div>
                
                <div class="flex flex-col rounded-3xl p-8 gap-8 bg-white">
                    <!-- Payment Details Section -->
                    <div class="flex flex-col gap-4">
                        <h2 class="font-Neue-Plak-bold text-xl leading-[27.5px]">Registration Details</h2>
                        <div class="flex flex-col rounded-xl border border-[#E6E7EB] p-5 gap-4">
                            <div class="flex items-center justify-between">
                                <p class="font-medium text-aktiv-grey">Registration Type</p>
                                <p class="font-semibold text-lg leading-[27px] text-right capitalize">
                                    {{ $registrationData['kategori_pendaftaran'] ?? 'Observer' }}
                                </p>
                            </div>
                            <div class="flex items-center justify-between">
                                <p class="font-medium text-aktiv-grey">Registration Method</p>
                                <p class="font-semibold text-lg leading-[27px] text-right capitalize">
                                    {{ $registrationData['jenis_pendaftaran'] ?? 'Individual' }}
                                </p>
                            </div>
                            <div class="flex items-center justify-between">
                                <p class="font-medium text-aktiv-grey">Registration Fee</p>
                                <p class="font-semibold text-lg leading-[27px] text-right">
                                    Rp{{ number_format($event->price, 0, ',', '.') }}
                                </p>
                            </div>
                            <div class="flex items-center justify-between">
                                <p class="font-medium text-aktiv-grey">PPN 11%</p>
                                <p class="font-semibold text-lg leading-[27px] text-right">
                                    Rp{{ number_format($event->price * 0.11, 0, ',', '.') }}
                                </p>
                            </div>
                            <hr class="border-[#E6E7EB]">
                            <div class="flex items-center justify-between">
                                <p class="font-medium text-aktiv-grey">Total Price</p>
                                <p class="font-semibold text-lg leading-[27px] text-right text-aktiv-red"> 
                                    Rp{{ number_format($event->price * 1.11, 0, ',', '.') }}
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Bank Account Section -->
                    <div class="flex flex-col gap-4">
                        <h2 class="font-Neue-Plak-bold text-xl leading-[27.5px]">Your Bank Account</h2>
                        <div class="flex flex-col gap-6">
                            <label class="flex flex-col gap-4">
                                <p class="font-medium text-aktiv-grey">Select Bank Type</p>
                                <div class="group input-wrapper flex items-center rounded-xl p-4 gap-2 bg-[#FBFBFB] overflow-hidden">
                                    <img src="{{asset('assets/images/icons/bank.svg')}}" class="w-6 h-6 flex shrink-0 group-focus-within:hidden group-has-[:valid]:hidden" alt="icon">
                                    <img src="{{asset('assets/images/icons/bank-black.svg')}}" class="w-6 h-6 shrink-0 hidden group-focus-within:flex group-has-[:valid]:flex" alt="icon">
                                    <input type="text" name="customer_bank_name" id="bankname" class="appearance-none bg-transparent w-full outline-none text-lg leading-[27px] font-semibold placeholder:font-medium placeholder:text-aktiv-grey" placeholder="What is the name of the bank you use?" required>
                                </div>
                            </label>
                            <label class="flex flex-col gap-4">
                                <p class="font-medium text-aktiv-grey">Full Name</p>
                                <div class="group input-wrapper flex items-center rounded-xl p-4 gap-2 bg-[#FBFBFB] overflow-hidden">
                                    <img src="{{asset('assets/images/icons/profile-circle.svg')}}" class="w-6 h-6 flex shrink-0 group-focus-within:hidden group-has-[:valid]:hidden" alt="icon">
                                    <img src="{{asset('assets/images/icons/profile-circle-black.svg')}}" class="w-6 h-6 shrink-0 hidden group-focus-within:flex group-has-[:valid]:flex" alt="icon">
                                    <input type="text" name="customer_bank_account" id="fullname" class="appearance-none bg-transparent w-full outline-none text-lg leading-[27px] font-semibold placeholder:font-medium placeholder:text-aktiv-grey" placeholder="Under whose name is this bank account?" required>
                                </div>
                            </label>
                            <label class="flex flex-col gap-4">
                                <p class="font-medium text-aktiv-grey">Bank account number</p>
                                <div class="group input-wrapper flex items-center rounded-xl p-4 gap-2 bg-[#FBFBFB] overflow-hidden">
                                    <img src="{{asset('assets/images/icons/card-edit.svg')}}" class="w-6 h-6 flex shrink-0 group-focus-within:hidden group-has-[:valid]:hidden" alt="icon">
                                    <img src="{{asset('assets/images/icons/card-edit-black.svg')}}" class="w-6 h-6 shrink-0 hidden group-focus-within:flex group-has-[:valid]:flex" alt="icon">
                                    <input type="text" name="customer_bank_number" id="banknumber" class="appearance-none bg-transparent w-full outline-none text-lg leading-[27px] font-semibold placeholder:font-medium placeholder:text-aktiv-grey" placeholder="What is the bank account number?" required>
                                </div>
                            </label>
                        </div>
                    </div>

                    <!-- Transfer Details Section -->
                    <div class="flex flex-col gap-4">
                        <h2 class="font-Neue-Plak-bold text-xl leading-[27.5px]">Transfer Details</h2>
                        <div class="flex flex-col rounded-xl border border-[#E6E7EB]">
                            <p class="text-center py-7 px-8 w-full font-semibold text-lg leading-[27px]">Transfer Bank</p>
                            <hr class="border-[#E6E7EB]">
                            <div class="flex flex-col py-5 px-8 gap-8">
                                <!-- BCA Bank -->
                                <div class="flex items-center justify-between gap-8">
                                    <div class="flex w-[78px] h-[53px] shrink-0 overflow-hidden">
                                        <img src="{{asset('assets/images/logos/bca.svg')}}" class="object-contain" alt="bank logo">
                                    </div>
                                    <div class="flex flex-col gap-[2px] w-full">
                                        <p class="font-medium text-aktiv-grey">BCA Wahana Kendali Mutu</p>
                                        <p class="font-semibold text-lg leading-[27px]">1935 0009 1200</p>
                                    </div>
                                    <button type="button" class="align-middle font-semibold text-lg leading-[27px] text-aktiv-orange copy-btn" data-account="1935 0009 1200">Copy</button>
                                </div>
                                
                                <!-- BNI Bank -->
                                <div class="flex items-center justify-between gap-8">
                                    <div class="flex w-[78px] h-[53px] shrink-0 overflow-hidden">
                                        <img src="{{asset('assets/images/logos/bni.svg')}}" class="object-contain" alt="bank logo">
                                    </div>
                                    <div class="flex flex-col gap-[2px] w-full">
                                        <p class="font-medium text-aktiv-grey">BNI Wahana Kendali Mutu</p>
                                        <p class="font-semibold text-lg leading-[27px]">1200 1935 0009</p>
                                    </div>
                                    <button type="button" class="align-middle font-semibold text-lg leading-[27px] text-aktiv-orange copy-btn" data-account="1200 1935 0009">Copy</button>
                                </div>
                                
                                <!-- BRI Bank -->
                                <div class="flex items-center justify-between gap-8">
                                    <div class="flex w-[78px] h-[53px] shrink-0 overflow-hidden">
                                        <img src="{{asset('assets/images/logos/bri.svg')}}" class="object-contain" alt="bank logo">
                                    </div>
                                    <div class="flex flex-col gap-[2px] w-full">
                                        <p class="font-medium text-aktiv-grey">BRI Wahana Kendali Mutu</p>
                                        <p class="font-semibold text-lg leading-[27px]">0009 1200 1935</p>
                                    </div>
                                    <button type="button" class="align-middle font-semibold text-lg leading-[27px] text-aktiv-orange copy-btn" data-account="0009 1200 1935">Copy</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Upload Proof Section -->
                    <div class="flex flex-col gap-4">
                        <h2 class="font-Neue-Plak-bold text-xl leading-[27.5px]">Upload Proof of Payment</h2>
                        <label class="flex flex-col gap-4">
                            <div class="group flex items-center rounded-xl p-4 gap-2 bg-[#FBFBFB] overflow-hidden">
                                <div class="flex items-center w-full gap-2 text-aktiv-grey group-has-[:valid]:text-aktiv-black transition-all duration-300">
                                    <img src="{{asset('assets/images/icons/gallery.svg')}}" class="w-6 h-6 flex shrink-0 group-focus-within:hidden group-has-[:valid]:hidden" alt="icon">
                                    <img src="{{asset('assets/images/icons/gallery-black.svg')}}" class="w-6 h-6 shrink-0 hidden group-focus-within:flex group-has-[:valid]:flex" alt="icon">
                                    <p id="Upload-btn" class="font-medium text-lg leading-[27px] group-has-[:valid]:font-semibold">Upload payment proof</p>   
                                </div>
                                <p class="font-semibold text-lg leading-[27px] text-aktiv-black text-nowrap">Browse file</p>        
                                <input type="file" name="proof" id="Proof" class="peer absolute -z-10 opacity-0 w-[10px]" accept="image/*,.pdf" required>
                            </div>
                            <p class="font-medium text-aktiv-grey text-sm">Accepted formats: JPG, PNG, PDF (Max: 2MB)</p>
                        </label>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" class="w-full rounded-xl h-16 px-6 text-center bg-aktiv-orange font-semibold text-lg leading-[27px] text-white hover:bg-aktiv-orange/90 transition-colors">Complete Registration</button>
                </div>
            </form>
        </main>
    </div>
</section>

@endsection

@push('after-scripts')
<script>
    // Define the base URL for assets using the current URL path to public directory
    const assetBaseUrl = "{{ url('/') }}/";
</script>
<script src="{{ asset('js/accodion.js') }}"></script>
<script src="{{ asset('js/upload-file.js') }}"></script>
<script>
    // Copy bank account number functionality
    document.addEventListener('DOMContentLoaded', function() {
        const copyButtons = document.querySelectorAll('.copy-btn');
        
        copyButtons.forEach(button => {
            button.addEventListener('click', function() {
                const accountNumber = this.getAttribute('data-account');
                
                // Copy to clipboard
                navigator.clipboard.writeText(accountNumber).then(function() {
                    // Show success feedback
                    const originalText = button.textContent;
                    button.textContent = 'Copied!';
                    button.classList.add('text-aktiv-green');
                    
                    setTimeout(() => {
                        button.textContent = originalText;
                        button.classList.remove('text-aktiv-green');
                    }, 2000);
                }).catch(function(err) {
                    console.error('Could not copy text: ', err);
                });
            });
        });
    });
</script>
@endpush

@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif