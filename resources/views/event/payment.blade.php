@extends('layout.app')
@section('title', 'Payment - ' . $event->nama)
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
            <p class="font-bold text-[32px] leading-[48px] capitalize text-white">Complete Payment</p>
            <div class="flex items-center gap-2 text-white">
                <a href="{{ route('front.index') }}" class="font-medium">Homepage</a>
                <span>></span>
                <a href="{{ route('event.index') }}" class="font-medium">Events</a>
                <span>></span>
                <a href="{{ route('event.show', $event->id) }}" class="font-medium">{{ $event->nama }}</a>
                <span>></span>
                <span class="font-medium">Payment</span>
            </div>
        </div>

        <!-- Payment Form -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Main Payment Form -->
            <div class="lg:col-span-2">
                <form action="{{ route('event.payment.store') }}" method="POST" enctype="multipart/form-data" class="flex flex-col gap-8">
                    @csrf
                    <input type="hidden" name="event_id" value="{{ $event->id }}">

                    <!-- Registration Summary -->
                    <div class="flex flex-col gap-6 rounded-3xl p-8 bg-white">
                        <h2 class="font-Neue-Plak-bold text-2xl leading-[33px]">Registration Summary</h2>
                        
                        <!-- Main Registrant -->
                        <div class="flex flex-col gap-4">
                            <h3 class="font-semibold text-lg text-aktiv-grey">Main Registrant</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div class="flex flex-col gap-1">
                                    <p class="font-medium text-aktiv-grey">Full Name</p>
                                    <p class="font-semibold text-lg">{{ $registrationData['name'] ?? 'N/A' }}</p>
                                </div>
                                <div class="flex flex-col gap-1">
                                    <p class="font-medium text-aktiv-grey">Email</p>
                                    <p class="font-semibold text-lg">{{ $registrationData['email'] ?? 'N/A' }}</p>
                                </div>
                                <div class="flex flex-col gap-1">
                                    <p class="font-medium text-aktiv-grey">Phone</p>
                                    <p class="font-semibold text-lg">{{ $registrationData['phone'] ?? 'N/A' }}</p>
                                </div>
                                @if(!empty($registrationData['company']))
                                <div class="flex flex-col gap-1">
                                    <p class="font-medium text-aktiv-grey">Company</p>
                                    <p class="font-semibold text-lg">{{ $registrationData['company'] }}</p>
                                </div>
                                @endif
                            </div>
                        </div>

                        <!-- Team Members (if team registration) -->
                        @if($registrationData['jenis_pendaftaran'] === 'tim' && !empty($registrationData['team_members']))
                        <div class="flex flex-col gap-4">
                            <h3 class="font-semibold text-lg text-aktiv-grey">Team Members ({{ count($registrationData['team_members']) }} members)</h3>
                            <div class="grid grid-cols-1 gap-3">
                                @foreach($registrationData['team_members'] as $index => $member)
                                <div class="flex items-center gap-3 p-4 rounded-lg bg-[#FBFBFB] border border-[#E6E7EB]">
                                    <div class="flex w-8 h-8 shrink-0 rounded-full bg-aktiv-blue items-center justify-center">
                                        @if(isset($member['is_ketua']) && $member['is_ketua'])
                                        <img src="{{asset('assets/images/icons/medal-star.svg')}}" class="w-4 h-4 text-white" alt="leader">
                                        @else
                                        <img src="{{asset('assets/images/icons/profile-circle.svg')}}" class="w-4 h-4 text-white" alt="member">
                                        @endif
                                    </div>
                                    <div class="flex flex-col flex-1">
                                        <p class="font-semibold text-lg leading-[27px]">
                                            {{ $member['nama'] }}
                                            @if(isset($member['is_ketua']) && $member['is_ketua'])
                                            <span class="text-aktiv-orange font-medium text-lg">(Leader)</span>
                                            @endif
                                        </p>
                                        <div class="flex items-center gap-4">
                                            <p class="font-medium text-aktiv-grey">{{ $member['email'] }}</p>
                                            <span class="text-aktiv-grey">•</span>
                                            <p class="font-medium text-aktiv-grey">{{ $member['kontak'] }}</p>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                        @endif

                        <!-- Registration Details -->
                        <div class="flex flex-col gap-4 p-6 rounded-xl bg-[#F8FAFC] border border-[#E6E7EB]">
                            <div class="flex items-center justify-between">
                                <p class="font-medium text-aktiv-grey">Event Name</p>
                                <p class="font-semibold text-lg leading-[27px] text-right">
                                    {{ $event->nama }}
                                </p>
                            </div>
                            <div class="flex items-center justify-between">
                                <p class="font-medium text-aktiv-grey">Registration Category</p>
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
                    <div class="flex flex-col gap-6 rounded-3xl p-8 bg-white">
                        <h2 class="font-Neue-Plak-bold text-2xl leading-[33px]">Your Bank Account</h2>
                        <div class="flex flex-col gap-6">
                            <label class="flex flex-col gap-4">
                                <p class="font-medium text-aktiv-grey">Select Bank Type</p>
                                <div class="group input-wrapper flex items-center rounded-xl p-4 gap-2 bg-[#FBFBFB] overflow-hidden">
                                    <img src="{{asset('assets/images/icons/bank.svg')}}" class="w-6 h-6 flex shrink-0 group-focus-within:hidden group-has-[:valid]:hidden" alt="icon">
                                    <img src="{{asset('assets/images/icons/bank-black.svg')}}" class="w-6 h-6 shrink-0 hidden group-focus-within:flex group-has-[:valid]:flex" alt="icon">
                                    <select name="customer_bank_name" class="appearance-none bg-transparent w-full outline-none text-lg leading-[27px] font-semibold placeholder:font-medium placeholder:text-aktiv-grey" required>
                                        <option value="" disabled {{ old('customer_bank_name') ? '' : 'selected' }}>Choose your bank</option>
                                        <option value="BCA" {{ old('customer_bank_name') == 'BCA' ? 'selected' : '' }}>Bank Central Asia (BCA)</option>
                                        <option value="BNI" {{ old('customer_bank_name') == 'BNI' ? 'selected' : '' }}>Bank Negara Indonesia (BNI)</option>
                                        <option value="BRI" {{ old('customer_bank_name') == 'BRI' ? 'selected' : '' }}>Bank Rakyat Indonesia (BRI)</option>
                                        <option value="Mandiri" {{ old('customer_bank_name') == 'Mandiri' ? 'selected' : '' }}>Bank Mandiri</option>
                                        <option value="Other" {{ old('customer_bank_name') == 'Other' ? 'selected' : '' }}>Other Bank</option>
                                    </select>
                                </div>
                                @error('customer_bank_name')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                                @enderror
                            </label>

                            <label class="flex flex-col gap-4">
                                <p class="font-medium text-aktiv-grey">Account Holder Name</p>
                                <div class="group input-wrapper flex items-center rounded-xl p-4 gap-2 bg-[#FBFBFB] overflow-hidden">
                                    <img src="{{asset('assets/images/icons/profile-circle.svg')}}" class="w-6 h-6 flex shrink-0 group-focus-within:hidden group-has-[:valid]:hidden" alt="icon">
                                    <img src="{{asset('assets/images/icons/profile-circle-black.svg')}}" class="w-6 h-6 shrink-0 hidden group-focus-within:flex group-has-[:valid]:flex" alt="icon">
                                    <input type="text" name="customer_bank_account" value="{{ old('customer_bank_account') }}" class="appearance-none bg-transparent w-full outline-none text-lg leading-[27px] font-semibold placeholder:font-medium placeholder:text-aktiv-grey" placeholder="Full name as per bank account" required>
                                </div>
                                @error('customer_bank_account')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                                @enderror
                            </label>

                            <label class="flex flex-col gap-4">
                                <p class="font-medium text-aktiv-grey">Account Number</p>
                                <div class="group input-wrapper flex items-center rounded-xl p-4 gap-2 bg-[#FBFBFB] overflow-hidden">
                                    <img src="{{asset('assets/images/icons/card.svg')}}" class="w-6 h-6 flex shrink-0 group-focus-within:hidden group-has-[:valid]:hidden" alt="icon">
                                    <img src="{{asset('assets/images/icons/card-black.svg')}}" class="w-6 h-6 shrink-0 hidden group-focus-within:flex group-has-[:valid]:flex" alt="icon">
                                    <input type="text" name="customer_bank_number" value="{{ old('customer_bank_number') }}" class="appearance-none bg-transparent w-full outline-none text-lg leading-[27px] font-semibold placeholder:font-medium placeholder:text-aktiv-grey" placeholder="Bank account number" required>
                                </div>
                                @error('customer_bank_number')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                                @enderror
                            </label>
                        </div>
                    </div>

                    <!-- Company Bank Accounts -->
                    <div class="flex flex-col gap-6 rounded-3xl p-8 bg-white">
                        <h2 class="font-Neue-Plak-bold text-2xl leading-[33px]">Transfer to Company Account</h2>
                        <p class="font-medium text-aktiv-grey">Please transfer the exact amount to one of our company accounts below:</p>
                        
                        <div class="flex flex-col gap-6 rounded-xl border border-[#E6E7EB] p-6">
                            <div class="flex flex-col gap-6">
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
                    <div class="flex flex-col gap-6 rounded-3xl p-8 bg-white">
                        <h2 class="font-Neue-Plak-bold text-2xl leading-[33px]">Upload Payment Proof</h2>
                        <label class="flex flex-col gap-4">
                            <p class="font-medium text-aktiv-grey">Payment Receipt/Screenshot *</p>
                            <div class="group input-wrapper flex items-center rounded-xl p-4 gap-2 bg-[#FBFBFB] overflow-hidden">
                                <img src="{{asset('assets/images/icons/document-upload.svg')}}" class="w-6 h-6 flex shrink-0 group-focus-within:hidden group-has-[:valid]:hidden" alt="icon">
                                <img src="{{asset('assets/images/icons/document-upload-black.svg')}}" class="w-6 h-6 shrink-0 hidden group-focus-within:flex group-has-[:valid]:flex" alt="icon">
                                <input type="file" name="payment_proof" accept="image/*,.pdf" class="appearance-none bg-transparent w-full outline-none text-lg leading-[27px] font-semibold placeholder:font-medium placeholder:text-aktiv-grey" required>
                            </div>
                            <p class="text-sm text-aktiv-grey">Accepted formats: JPG, PNG, PDF (Max: 5MB)</p>
                            @error('payment_proof')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </label>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" class="w-full rounded-xl h-16 px-6 text-center bg-aktiv-orange font-semibold text-lg leading-[27px] text-white hover:bg-aktiv-orange/90 transition-colors">Submit Payment</button>
                </form>
            </div>

            <!-- Event Details Sidebar -->
            <div class="lg:col-span-1">
                <div class="sticky top-8 flex flex-col gap-6 rounded-3xl p-8 bg-white shadow-lg">
                    <h3 class="font-Neue-Plak-bold text-xl">Event Details</h3>
                    
                    <!-- Event Image -->
                    <div class="flex w-full h-[200px] rounded-xl overflow-hidden">
                        @if($event->thumbnail)
                            <img src="{{ Storage::url($event->thumbnail) }}" class="w-full h-full object-cover" alt="{{ $event->nama }}">
                        @else
                            <div class="w-full h-full bg-gradient-to-br from-aktiv-blue to-aktiv-orange flex items-center justify-center">
                                <span class="text-white text-4xl font-bold">{{ substr($event->nama, 0, 1) }}</span>
                            </div>
                        @endif
                    </div>

                    <!-- Event Info -->
                    <div class="flex flex-col gap-4">
                        <h4 class="font-semibold text-lg">{{ $event->nama }}</h4>
                        
                        <div class="flex items-center gap-3">
                            <img src="{{asset('assets/images/icons/calendar.svg')}}" class="w-5 h-5 flex shrink-0" alt="icon">
                            <span class="font-medium text-aktiv-grey">{{ $event->tanggal->format('d F Y') }}</span>
                        </div>

                        @if($event->time_at)
                        <div class="flex items-center gap-3">
                            <img src="{{asset('assets/images/icons/clock.svg')}}" class="w-5 h-5 flex shrink-0" alt="icon">
                            <span class="font-medium text-aktiv-grey">{{ $event->time_at->format('H:i') }} WIB</span>
                        </div>
                        @endif

                        <div class="flex items-center gap-3">
                            <img src="{{asset('assets/images/icons/location.svg')}}" class="w-5 h-5 flex shrink-0" alt="icon">
                            <span class="font-medium text-aktiv-grey">{{ $event->lokasi }}</span>
                        </div>
                    </div>

                    <!-- Payment Reminder -->
                    <div class="flex flex-col gap-3 p-4 rounded-xl bg-[#FDF6E4] border border-[#F59E0B]">
                        <div class="flex items-center gap-3">
                            <img src="{{asset('assets/images/icons/warning.svg')}}" class="w-5 h-5 text-amber-600" alt="warning">
                            <h4 class="font-semibold text-amber-800">Payment Reminder</h4>
                        </div>
                        <ul class="text-sm text-amber-700 space-y-1 ml-8">
                            <li>• Transfer exact amount including PPN</li>
                            <li>• Upload clear payment receipt</li>
                            <li>• Payment will be verified within 1x24 hours</li>
                            <li>• Keep your transaction ID for reference</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection

@push('after-scripts')
<script>
    // Copy account number functionality
    document.addEventListener('DOMContentLoaded', function() {
        const copyButtons = document.querySelectorAll('.copy-btn');
        
        copyButtons.forEach(button => {
            button.addEventListener('click', function() {
                const accountNumber = this.getAttribute('data-account');
                
                navigator.clipboard.writeText(accountNumber).then(() => {
                    // Show copy confirmation
                    const originalText = this.textContent;
                    this.textContent = 'Copied!';
                    this.style.color = '#059669';
                    
                    setTimeout(() => {
                        this.textContent = originalText;
                        this.style.color = '';
                    }, 2000);
                }).catch(() => {
                    // Fallback for older browsers
                    const textArea = document.createElement('textarea');
                    textArea.value = accountNumber;
                    document.body.appendChild(textArea);
                    textArea.select();
                    document.execCommand('copy');
                    document.body.removeChild(textArea);
                    
                    // Show copy confirmation
                    const originalText = this.textContent;
                    this.textContent = 'Copied!';
                    this.style.color = '#059669';
                    
                    setTimeout(() => {
                        this.textContent = originalText;
                        this.style.color = '';
                    }, 2000);
                });
            });
        });
    });
</script>
@endpush