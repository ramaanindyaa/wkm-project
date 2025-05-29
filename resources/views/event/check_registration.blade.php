@extends('layout.app')
@section('title')
Check Registration
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
            <p class="font-bold text-[32px] leading-[48px] capitalize text-white">Check Event Registration</p>
            <div class="flex items-center gap-2 text-white">
                <a href="{{ route('front.index') }}" class="font-medium">Homepage</a>
                <span>></span>
                <a href="{{ route('event.index') }}" class="font-medium">Events</a>
                <span>></span>
                <a class="last:font-semibold">Check Registration</a>
            </div>
        </div>

        <!-- Main Content -->
        <main class="flex justify-center">
            <div class="flex flex-col w-[620px] rounded-3xl p-8 gap-8 bg-white">
                
                <!-- Header Section -->
                <div class="flex flex-col gap-6 text-center">
                    <img src="{{asset('assets/images/icons/search-normal.svg')}}" class="w-[72px] h-[72px] flex shrink-0 mx-auto" alt="search icon">
                    <h1 class="font-bold text-[32px] leading-[48px]">Check Your Registration</h1>
                    <p class="font-medium text-aktiv-grey">
                        Enter your Registration Transaction ID to check your event registration status and details.
                    </p>
                </div>

                <!-- Error Messages Display -->
                @if ($errors->any())
                <div class="flex flex-col gap-2 p-4 bg-[#FEE3E3] rounded-xl">
                    <div class="flex items-center gap-2">
                        <img src="{{asset('assets/images/icons/warning-2.svg')}}" class="w-5 h-5" alt="error">
                        <p class="font-semibold text-aktiv-red">There are errors:</p>
                    </div>
                    <ul class="list-disc pl-7">
                        @foreach ($errors->all() as $error)
                            <li class="text-aktiv-red">{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                <!-- Check Registration Form -->
                <form method="POST" action="{{ route('event.check_registration_details') }}" class="flex flex-col gap-6">
                    @csrf
                    
                    <!-- Registration Transaction ID Input -->
                    <label class="flex flex-col gap-4">
                        <p class="font-medium text-aktiv-grey">Registration Transaction ID</p>
                        <div class="group input-wrapper flex items-center rounded-xl p-4 gap-2 bg-[#FBFBFB] overflow-hidden">
                            <img src="{{asset('assets/images/icons/ticket-star.svg')}}" class="w-6 h-6 flex shrink-0 group-focus-within:hidden group-has-[:valid]:hidden" alt="icon">
                            <img src="{{asset('assets/images/icons/ticket-star.svg')}}" class="w-6 h-6 shrink-0 hidden group-focus-within:flex group-has-[:valid]:flex opacity-80" alt="icon">
                            <input 
                                type="text" 
                                name="registration_trx_id" 
                                id="registration_trx_id" 
                                value="{{ old('registration_trx_id') }}" 
                                class="appearance-none bg-transparent w-full outline-none text-lg leading-[27px] font-semibold placeholder:font-medium placeholder:text-aktiv-grey" 
                                placeholder="Enter your Registration Transaction ID (e.g., EVT20241201ABCDEF)"
                                required
                            >
                        </div>
                        <p class="text-sm text-aktiv-grey">
                            Your Registration Transaction ID can be found in your payment confirmation email or success page.
                        </p>
                    </label>

                    <!-- Information Section -->
                    <div class="flex flex-col gap-4 p-6 rounded-xl bg-[#DFEFFF] border border-[#E6E7EB]">
                        <div class="flex items-center gap-3">
                            <img src="{{asset('assets/images/icons/shield-tick.svg')}}" class="w-8 h-8 flex shrink-0" alt="info">
                            <h3 class="font-semibold text-lg leading-[27px] text-aktiv-blue">What You Can Check</h3>
                        </div>
                        <div class="flex flex-col gap-3 ml-11">
                            <div class="flex items-center gap-2">
                                <div class="w-2 h-2 rounded-full bg-aktiv-blue"></div>
                                <p class="font-medium text-aktiv-blue">Registration status and payment verification</p>
                            </div>
                            <div class="flex items-center gap-2">
                                <div class="w-2 h-2 rounded-full bg-aktiv-blue"></div>
                                <p class="font-medium text-aktiv-blue">Event details and registration information</p>
                            </div>
                            <div class="flex items-center gap-2">
                                <div class="w-2 h-2 rounded-full bg-aktiv-blue"></div>
                                <p class="font-medium text-aktiv-blue">Team member details (for team registrations)</p>
                            </div>
                            <div class="flex items-center gap-2">
                                <div class="w-2 h-2 rounded-full bg-aktiv-blue"></div>
                                <p class="font-medium text-aktiv-blue">Document upload status (for competition category)</p>
                            </div>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" class="w-full rounded-xl h-16 px-6 text-center bg-aktiv-orange font-semibold text-lg leading-[27px] text-white hover:bg-aktiv-orange/90 transition-colors">
                        Check Registration Status
                    </button>
                </form>

                <!-- Help Section -->
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
            </div>
        </main>
    </div>
</section>

@endsection

@push('after-scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Auto-uppercase and format transaction ID input
        const transactionInput = document.getElementById('registration_trx_id');
        
        if (transactionInput) {
            transactionInput.addEventListener('input', function(e) {
                // Convert to uppercase and remove any non-alphanumeric characters
                let value = e.target.value.toUpperCase().replace(/[^A-Z0-9]/g, '');
                
                // Limit to reasonable length for transaction ID
                if (value.length > 20) {
                    value = value.substring(0, 20);
                }
                
                e.target.value = value;
            });

            // Add paste event handler
            transactionInput.addEventListener('paste', function(e) {
                e.preventDefault();
                const paste = (e.clipboardData || window.clipboardData).getData('text');
                const cleaned = paste.toUpperCase().replace(/[^A-Z0-9]/g, '').substring(0, 20);
                e.target.value = cleaned;
            });
        }

        // Add form submission validation
        const form = document.querySelector('form');
        if (form) {
            form.addEventListener('submit', function(e) {
                const transactionId = transactionInput.value.trim();
                
                if (transactionId.length < 6) {
                    e.preventDefault();
                    alert('Please enter a valid Registration Transaction ID (minimum 6 characters).');
                    transactionInput.focus();
                    return false;
                }
                
                // Show loading state
                const submitButton = form.querySelector('button[type="submit"]');
                if (submitButton) {
                    submitButton.disabled = true;
                    submitButton.innerHTML = '<img src="{{asset("assets/images/icons/timer.svg")}}" class="w-6 h-6 animate-spin mx-auto" alt="loading"> Checking...';
                }
            });
        }
    });
</script>
@endpush