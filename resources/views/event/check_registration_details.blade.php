@extends('layout.app')
@section('title')
Registration Details - {{ $transaction->registration_trx_id }}
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
            <p class="font-bold text-[32px] leading-[48px] capitalize text-white">Registration Details</p>
            <div class="flex items-center gap-2 text-white">
                <a href="{{ route('front.index') }}" class="font-medium">Homepage</a>
                <span>></span>
                <a href="{{ route('event.check_registration') }}" class="font-medium">Check Registration</a>
                <span>></span>
                <a class="last:font-semibold">{{ $transaction->registration_trx_id }}</a>
            </div>
        </div>

        <!-- Main Content -->
        <main class="flex justify-center">
            <div class="flex flex-col w-[856px] rounded-3xl p-8 gap-8 bg-white">
                
                <!-- Header Section with Transaction ID -->
                <div class="flex flex-col gap-6 text-center">
                    <div class="flex flex-col gap-3">
                        <h1 class="font-Neue-Plak-bold text-3xl leading-[33px]">Registration Found!</h1>
                        <p class="font-medium text-aktiv-grey">Here are your registration details and current status</p>
                    </div>
                    
                    <!-- Transaction ID Badge -->
                    <div class="flex justify-center">
                        <div class="flex items-center gap-3 px-6 py-3 rounded-xl bg-[#F8FAFC] border border-[#E6E7EB]">
                            <img src="{{asset('assets/images/icons/receipt.svg')}}" class="w-6 h-6 flex shrink-0" alt="receipt">
                            <div class="flex flex-col">
                                <p class="font-medium text-aktiv-grey text-sm">Transaction ID</p>
                                <p class="font-semibold text-lg leading-[27px]">{{ $transaction->registration_trx_id }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Payment Status Card -->
                <div class="flex flex-col gap-4 p-6 rounded-xl border border-[#E6E7EB] 
                    @if($transaction->payment_status === 'approved') bg-[#F0FDF4] border-[#16A34A] 
                    @elseif($transaction->payment_status === 'rejected') bg-[#FEF2F2] border-[#DC2626]
                    @else bg-[#FEF3C7] border-[#D97706] @endif">
                    
                    <div class="flex items-center gap-3">
                        @if($transaction->payment_status === 'approved')
                            <div class="flex w-8 h-8 shrink-0 rounded-full bg-[#16A34A] items-center justify-center">
                                <img src="{{asset('assets/images/icons/check.svg')}}" class="w-4 h-4 text-white" alt="success">
                            </div>
                            <div class="flex flex-col">
                                <p class="font-semibold text-lg leading-[27px] text-[#16A34A]">Payment Approved</p>
                                <p class="font-medium text-[#15803D]">Your registration has been confirmed and approved.</p>
                            </div>
                        @elseif($transaction->payment_status === 'rejected')
                            <div class="flex w-8 h-8 shrink-0 rounded-full bg-[#DC2626] items-center justify-center">
                                <img src="{{asset('assets/images/icons/close.svg')}}" class="w-4 h-4 text-white" alt="rejected">
                            </div>
                            <div class="flex flex-col">
                                <p class="font-semibold text-lg leading-[27px] text-[#DC2626]">Payment Rejected</p>
                                <p class="font-medium text-[#B91C1C]">Unfortunately, your payment could not be verified. Please contact support.</p>
                            </div>
                        @else
                            <div class="flex w-8 h-8 shrink-0 rounded-full bg-[#D97706] items-center justify-center">
                                <img src="{{asset('assets/images/icons/clock.svg')}}" class="w-4 h-4 text-white" alt="pending">
                            </div>
                            <div class="flex flex-col">
                                <p class="font-semibold text-lg leading-[27px] text-[#D97706]">Payment Pending Verification</p>
                                <p class="font-medium text-[#B45309]">Your payment is being reviewed. You'll be notified once it's verified.</p>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Event Information -->
                <div class="flex flex-col gap-6">
                    <h2 class="font-Neue-Plak-bold text-2xl leading-[33px]">Event Information</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="flex flex-col gap-2">
                            <p class="font-medium text-aktiv-grey">Event Name</p>
                            <p class="font-semibold text-lg leading-[27px]">{{ $transaction->event->nama }}</p>
                        </div>
                        <div class="flex flex-col gap-2">
                            <p class="font-medium text-aktiv-grey">Date</p>
                            <p class="font-semibold text-lg leading-[27px]">{{ $transaction->event->tanggal->format('d F Y') }}</p>
                        </div>
                        @if($transaction->event->time_at)
                        <div class="flex flex-col gap-2">
                            <p class="font-medium text-aktiv-grey">Time</p>
                            <p class="font-semibold text-lg leading-[27px]">{{ $transaction->event->time_at->format('H:i') }} WIB</p>
                        </div>
                        @endif
                        <div class="flex flex-col gap-2">
                            <p class="font-medium text-aktiv-grey">Location</p>
                            <p class="font-semibold text-lg leading-[27px]">{{ $transaction->event->lokasi }}</p>
                        </div>
                    </div>
                </div>

                <!-- Personal Information -->
                <div class="flex flex-col gap-6">
                    <h2 class="font-Neue-Plak-bold text-2xl leading-[33px]">Personal Information</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="flex flex-col gap-2">
                            <p class="font-medium text-aktiv-grey">Full Name</p>
                            <p class="font-semibold text-lg leading-[27px]">{{ $transaction->name }}</p>
                        </div>
                        <div class="flex flex-col gap-2">
                            <p class="font-medium text-aktiv-grey">Email</p>
                            <p class="font-semibold text-lg leading-[27px]">{{ $transaction->email }}</p>
                        </div>
                        <div class="flex flex-col gap-2">
                            <p class="font-medium text-aktiv-grey">Phone</p>
                            <p class="font-semibold text-lg leading-[27px]">{{ $transaction->phone }}</p>
                        </div>
                        @if($transaction->company)
                        <div class="flex flex-col gap-2">
                            <p class="font-medium text-aktiv-grey">Company</p>
                            <p class="font-semibold text-lg leading-[27px]">{{ $transaction->company }}</p>
                        </div>
                        @endif
                        <div class="flex flex-col gap-2">
                            <p class="font-medium text-aktiv-grey">Registration Category</p>
                            <p class="font-semibold text-lg leading-[27px]">{{ $transaction->kategori_pendaftaran_label }}</p>
                        </div>
                        <div class="flex flex-col gap-2">
                            <p class="font-medium text-aktiv-grey">Registration Type</p>
                            <p class="font-semibold text-lg leading-[27px]">{{ $transaction->jenis_pendaftaran_label }}</p>
                        </div>
                    </div>
                </div>

                <!-- Team Members (if team registration) -->
                @if($transaction->jenis_pendaftaran === 'tim' && $transaction->teamMembers->count() > 0)
                <div class="flex flex-col gap-6">
                    <h2 class="font-Neue-Plak-bold text-2xl leading-[33px]">Team Members ({{ $transaction->teamMembers->count() }} members)</h2>
                    <div class="grid grid-cols-1 gap-3">
                        @foreach($transaction->teamMembers as $member)
                        <div class="flex items-center gap-3 p-4 rounded-lg bg-white border border-[#E6E7EB]">
                            <div class="flex w-8 h-8 shrink-0 rounded-full bg-aktiv-blue items-center justify-center">
                                @if($member->is_ketua)
                                <img src="{{asset('assets/images/icons/medal-star.svg')}}" class="w-4 h-4 text-white" alt="leader">
                                @else
                                <img src="{{asset('assets/images/icons/profile-circle.svg')}}" class="w-4 h-4 text-white" alt="member">
                                @endif
                            </div>
                            <div class="flex flex-col flex-1">
                                <p class="font-semibold text-lg leading-[27px]">
                                    {{ $member->nama }}
                                    @if($member->is_ketua)
                                    <span class="text-aktiv-orange font-medium text-lg">(Leader)</span>
                                    @endif
                                </p>
                                <div class="flex items-center gap-4">
                                    <p class="font-medium text-aktiv-grey">{{ $member->email }}</p>
                                    <span class="text-aktiv-grey">•</span>
                                    <p class="font-medium text-aktiv-grey">{{ $member->kontak }}</p>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif

                <!-- Competition Documents Section - Only show for competition category -->
                @if($transaction->kategori_pendaftaran === 'kompetisi')
                <div class="flex flex-col gap-6">
                    <div class="flex items-center justify-between">
                        <h2 class="font-Neue-Plak-bold text-2xl leading-[33px]">Competition Documents</h2>
                        @if($transaction->payment_status === 'approved')
                            @if($transaction->documents_complete)
                                <div class="flex items-center gap-2 px-3 py-1 rounded-full bg-[#F0FDF4] border border-[#16A34A]">
                                    <img src="{{asset('assets/images/icons/check.svg')}}" class="w-4 h-4 text-[#16A34A]" alt="complete">
                                    <span class="text-sm font-medium text-[#16A34A]">Complete</span>
                                </div>
                            @else
                                <div class="flex items-center gap-2 px-3 py-1 rounded-full bg-[#FEF3C7] border border-[#D97706]">
                                    <img src="{{asset('assets/images/icons/warning.svg')}}" class="w-4 h-4 text-[#D97706]" alt="incomplete">
                                    <span class="text-sm font-medium text-[#D97706]">Incomplete</span>
                                </div>
                            @endif
                        @endif
                    </div>
                    
                    <!-- Documents Status Message -->
                    <div class="flex items-center gap-3 p-4 rounded-lg 
                        @if($transaction->payment_status === 'approved')
                            @if($transaction->documents_complete)
                                bg-[#F0FDF4] border border-[#16A34A]
                            @else
                                bg-[#FEF3C7] border border-[#D97706]
                            @endif
                        @else
                            bg-[#F8FAFC] border border-[#E6E7EB]
                        @endif">
                        
                        @if($transaction->payment_status === 'approved')
                            @if($transaction->documents_complete)
                                <img src="{{asset('assets/images/icons/check-circle.svg')}}" class="w-6 h-6 text-[#16A34A]" alt="success">
                            @else
                                <img src="{{asset('assets/images/icons/warning.svg')}}" class="w-6 h-6 text-[#D97706]" alt="warning">
                            @endif
                        @else
                            <img src="{{asset('assets/images/icons/info.svg')}}" class="w-6 h-6 text-aktiv-grey" alt="info">
                        @endif
                        
                        <p class="font-medium text-aktiv-grey">{{ $transaction->documents_status_message }}</p>
                    </div>

                    @if($transaction->can_upload_documents)
                        @if($transaction->documents_complete)
                            <!-- Show uploaded documents -->
                            <div class="flex flex-col gap-4">
                                <h3 class="font-semibold text-lg text-aktiv-grey">Uploaded Documents</h3>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div class="flex items-center justify-between p-3 rounded-lg bg-white border border-[#E6E7EB]">
                                        <div class="flex items-center gap-3">
                                            <img src="{{asset('assets/images/icons/document.svg')}}" class="w-6 h-6 flex shrink-0" alt="document">
                                            <p class="font-medium text-aktiv-grey">Paper Document</p>
                                        </div>
                                        <a href="{{ $transaction->google_drive_makalah }}" target="_blank" class="font-semibold text-aktiv-blue hover:text-aktiv-blue/80">View Document</a>
                                    </div>
                                    <div class="flex items-center justify-between p-3 rounded-lg bg-white border border-[#E6E7EB]">
                                        <div class="flex items-center gap-3">
                                            <img src="{{asset('assets/images/icons/document.svg')}}" class="w-6 h-6 flex shrink-0" alt="document">
                                            <p class="font-medium text-aktiv-grey">Attachment</p>
                                        </div>
                                        <a href="{{ $transaction->google_drive_lampiran }}" target="_blank" class="font-semibold text-aktiv-blue hover:text-aktiv-blue/80">View Document</a>
                                    </div>
                                    <div class="flex items-center justify-between p-3 rounded-lg bg-white border border-[#E6E7EB]">
                                        <div class="flex items-center gap-3">
                                            <img src="{{asset('assets/images/icons/video.svg')}}" class="w-6 h-6 flex shrink-0" alt="video">
                                            <p class="font-medium text-aktiv-grey">Before Video</p>
                                        </div>
                                        <a href="{{ $transaction->google_drive_video_sebelum }}" target="_blank" class="font-semibold text-aktiv-blue hover:text-aktiv-blue/80">Watch Video</a>
                                    </div>
                                    <div class="flex items-center justify-between p-3 rounded-lg bg-white border border-[#E6E7EB]">
                                        <div class="flex items-center gap-3">
                                            <img src="{{asset('assets/images/icons/video.svg')}}" class="w-6 h-6 flex shrink-0" alt="video">
                                            <p class="font-medium text-aktiv-grey">After Video</p>
                                        </div>
                                        <a href="{{ $transaction->google_drive_video_sesudah }}" target="_blank" class="font-semibold text-aktiv-blue hover:text-aktiv-blue/80">Watch Video</a>
                                    </div>
                                </div>
                            </div>
                        @else
                            <!-- Documents Upload Form -->
                            <div class="flex items-center gap-3 p-4 rounded-lg bg-[#FDF6E4] border border-[#F59E0B]">
                                <img src="{{asset('assets/images/icons/warning.svg')}}" class="w-6 h-6 text-[#D97706]" alt="warning">
                                <div class="flex flex-col">
                                    <p class="font-semibold text-[#D97706]">Documents Required</p>
                                    <p class="font-medium text-[#B45309] text-sm">Please upload all competition documents to complete your registration.</p>
                                </div>
                            </div>

                            @if($transaction->missing_documents)
                            <div class="flex flex-col gap-3">
                                <h4 class="font-semibold text-lg text-aktiv-grey">Missing Documents:</h4>
                                <ul class="list-disc list-inside space-y-1 text-aktiv-grey">
                                    @foreach($transaction->missing_documents as $document)
                                    <li>{{ $document }}</li>
                                    @endforeach
                                </ul>
                            </div>
                            @endif

                            <form action="{{ route('event.documents.update', $transaction->id) }}" method="POST" class="flex flex-col gap-6">
                                @csrf
                                
                                <h3 class="font-semibold text-lg text-aktiv-grey">Upload Competition Documents</h3>
                                
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <!-- Makalah Link -->
                                    <label class="flex flex-col gap-4">
                                        <p class="font-medium text-aktiv-grey">Paper Document Google Drive Link *</p>
                                        <div class="group input-wrapper flex items-center rounded-xl p-4 gap-2 bg-[#FBFBFB] overflow-hidden">
                                            <img src="{{asset('assets/images/icons/document.svg')}}" class="w-6 h-6 flex shrink-0 group-focus-within:hidden group-has-[:valid]:hidden" alt="icon">
                                            <img src="{{asset('assets/images/icons/document.svg')}}" class="w-6 h-6 shrink-0 hidden group-focus-within:flex group-has-[:valid]:flex opacity-80" alt="icon">
                                            <input type="url" name="google_drive_makalah" value="{{ old('google_drive_makalah', $transaction->google_drive_makalah) }}" class="appearance-none bg-transparent w-full outline-none text-lg leading-[27px] font-semibold placeholder:font-medium placeholder:text-aktiv-grey" placeholder="https://drive.google.com/..." required>
                                        </div>
                                        @error('google_drive_makalah')
                                        <span class="text-red-500 text-sm">{{ $message }}</span>
                                        @enderror
                                    </label>
                                    
                                    <!-- Lampiran Link -->
                                    <label class="flex flex-col gap-4">
                                        <p class="font-medium text-aktiv-grey">Attachment Google Drive Link *</p>
                                        <div class="group input-wrapper flex items-center rounded-xl p-4 gap-2 bg-[#FBFBFB] overflow-hidden">
                                            <img src="{{asset('assets/images/icons/document.svg')}}" class="w-6 h-6 flex shrink-0 group-focus-within:hidden group-has-[:valid]:hidden" alt="icon">
                                            <img src="{{asset('assets/images/icons/document.svg')}}" class="w-6 h-6 shrink-0 hidden group-focus-within:flex group-has-[:valid]:flex opacity-80" alt="icon">
                                            <input type="url" name="google_drive_lampiran" value="{{ old('google_drive_lampiran', $transaction->google_drive_lampiran) }}" class="appearance-none bg-transparent w-full outline-none text-lg leading-[27px] font-semibold placeholder:font-medium placeholder:text-aktiv-grey" placeholder="https://drive.google.com/..." required>
                                        </div>
                                        @error('google_drive_lampiran')
                                        <span class="text-red-500 text-sm">{{ $message }}</span>
                                        @enderror
                                    </label>
                                    
                                    <!-- Video Sebelum Link -->
                                    <label class="flex flex-col gap-4">
                                        <p class="font-medium text-aktiv-grey">Before Innovation Video Google Drive Link *</p>
                                        <div class="group input-wrapper flex items-center rounded-xl p-4 gap-2 bg-[#FBFBFB] overflow-hidden">
                                            <img src="{{asset('assets/images/icons/video.svg')}}" class="w-6 h-6 flex shrink-0 group-focus-within:hidden group-has-[:valid]:hidden" alt="icon">
                                            <img src="{{asset('assets/images/icons/video.svg')}}" class="w-6 h-6 shrink-0 hidden group-focus-within:flex group-has-[:valid]:flex opacity-80" alt="icon">
                                            <input type="url" name="google_drive_video_sebelum" value="{{ old('google_drive_video_sebelum', $transaction->google_drive_video_sebelum) }}" class="appearance-none bg-transparent w-full outline-none text-lg leading-[27px] font-semibold placeholder:font-medium placeholder:text-aktiv-grey" placeholder="https://drive.google.com/..." required>
                                        </div>
                                        @error('google_drive_video_sebelum')
                                        <span class="text-red-500 text-sm">{{ $message }}</span>
                                        @enderror
                                    </label>
                                    
                                    <!-- Video Sesudah Link -->
                                    <label class="flex flex-col gap-4">
                                        <p class="font-medium text-aktiv-grey">After Innovation Video Google Drive Link *</p>
                                        <div class="group input-wrapper flex items-center rounded-xl p-4 gap-2 bg-[#FBFBFB] overflow-hidden">
                                            <img src="{{asset('assets/images/icons/video.svg')}}" class="w-6 h-6 flex shrink-0 group-focus-within:hidden group-has-[:valid]:hidden" alt="icon">
                                            <img src="{{asset('assets/images/icons/video.svg')}}" class="w-6 h-6 shrink-0 hidden group-focus-within:flex group-has-[:valid]:flex opacity-80" alt="icon">
                                            <input type="url" name="google_drive_video_sesudah" value="{{ old('google_drive_video_sesudah', $transaction->google_drive_video_sesudah) }}" class="appearance-none bg-transparent w-full outline-none text-lg leading-[27px] font-semibold placeholder:font-medium placeholder:text-aktiv-grey" placeholder="https://drive.google.com/..." required>
                                        </div>
                                        @error('google_drive_video_sesudah')
                                        <span class="text-red-500 text-sm">{{ $message }}</span>
                                        @enderror
                                    </label>
                                </div>
                                
                                <!-- Important Notes -->
                                <div class="flex flex-col gap-3 p-4 rounded-lg bg-[#F0F9FF] border border-[#0EA5E9]">
                                    <div class="flex items-center gap-3">
                                        <img src="{{asset('assets/images/icons/info.svg')}}" class="w-6 h-6 text-[#0EA5E9]" alt="info">
                                        <h4 class="font-semibold text-[#0EA5E9]">Important Notes</h4>
                                    </div>
                                    <ul class="text-sm text-[#0369A1] space-y-1 ml-9">
                                        <li>• Make sure all Google Drive links are set to "Anyone with the link can view"</li>
                                        <li>• Video files should clearly show the innovation before and after implementation</li>
                                        <li>• Paper document should be in PDF format</li>
                                        <li>• All documents will be reviewed by our judges</li>
                                    </ul>
                                </div>
                                
                                <!-- Submit Button -->
                                <button type="submit" class="w-full rounded-xl h-14 px-6 text-center bg-aktiv-orange font-semibold text-lg leading-[27px] text-white hover:bg-aktiv-orange/90 transition-colors">
                                    Upload Competition Documents
                                </button>
                            </form>
                        @endif
                    @endif
                </div>
                @endif

                <!-- Payment Information -->
                <div class="flex flex-col gap-6">
                    <h2 class="font-Neue-Plak-bold text-2xl leading-[33px]">Payment Information</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="flex flex-col gap-2">
                            <p class="font-medium text-aktiv-grey">Bank Account</p>
                            <p class="font-semibold text-lg leading-[27px]">{{ $transaction->customer_bank_name }} - {{ $transaction->customer_bank_account }}</p>
                        </div>
                        <div class="flex flex-col gap-2">
                            <p class="font-medium text-aktiv-grey">Account Number</p>
                            <p class="font-semibold text-lg leading-[27px]">{{ $transaction->customer_bank_number }}</p>
                        </div>
                        <div class="flex flex-col gap-2">
                            <p class="font-medium text-aktiv-grey">Total Amount</p>
                            <p class="font-semibold text-lg leading-[27px] text-aktiv-red">Rp{{ number_format($transaction->total_amount, 0, ',', '.') }}</p>
                        </div>
                        <div class="flex flex-col gap-2">
                            <p class="font-medium text-aktiv-grey">Payment Status</p>
                            <div class="flex items-center gap-2">
                                @if($transaction->payment_status === 'approved')
                                    <div class="w-3 h-3 rounded-full bg-[#16A34A]"></div>
                                    <span class="font-semibold text-[#16A34A]">{{ $transaction->payment_status_label }}</span>
                                @elseif($transaction->payment_status === 'rejected')
                                    <div class="w-3 h-3 rounded-full bg-[#DC2626]"></div>
                                    <span class="font-semibold text-[#DC2626]">{{ $transaction->payment_status_label }}</span>
                                @else
                                    <div class="w-3 h-3 rounded-full bg-[#D97706]"></div>
                                    <span class="font-semibold text-[#D97706]">{{ $transaction->payment_status_label }}</span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Back to Check Registration -->
                <div class="flex justify-center pt-4">
                    <a href="{{ route('event.check_registration') }}" class="flex items-center gap-2 font-semibold text-lg leading-[27px] px-6 py-3 bg-aktiv-blue text-white rounded-xl hover:bg-aktiv-blue/90 transition-colors">
                        <img src="{{asset('assets/images/icons/arrow-left.svg')}}" class="w-5 h-5" alt="back">
                        Check Another Registration
                    </a>
                </div>
            </div>
        </main>
    </div>
</section>

@endsection

@push('after-scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Success message display
        @if(session('success'))
        // Create success notification
        const notification = document.createElement('div');
        notification.className = 'fixed top-4 right-4 z-50 p-4 bg-[#E6F7F0] border border-[#10B981] rounded-xl shadow-lg max-w-sm';
        notification.innerHTML = `
            <div class="flex items-center gap-3">
                <img src="{{asset('assets/images/icons/shield-tick.svg')}}" class="w-6 h-6 flex shrink-0" alt="success">
                <p class="font-semibold text-[#059669]">{{ session('success') }}</p>
            </div>
        `;
        
        document.body.appendChild(notification);
        
        // Auto remove after 5 seconds
        setTimeout(() => {
            notification.style.animation = 'fadeOut 0.5s ease-out forwards';
            setTimeout(() => notification.remove(), 500);
        }, 5000);
        @endif
        
        // Add copy functionality for transaction ID
        const transactionId = document.querySelector('p.text-aktiv-blue');
        if (transactionId) {
            transactionId.style.cursor = 'pointer';
            transactionId.title = 'Click to copy Transaction ID';
            
            transactionId.addEventListener('click', function() {
                navigator.clipboard.writeText(this.textContent).then(() => {
                    // Show copy confirmation
                    const originalText = this.textContent;
                    this.textContent = 'Copied! ✓';
                    setTimeout(() => {
                        this.textContent = originalText;
                    }, 2000);
                });
            });
        }
        
        // Smooth scroll for form sections
        const documentUploadForm = document.querySelector('form[action*="documents/update"]');
        if (documentUploadForm) {
            documentUploadForm.addEventListener('submit', function() {
                // Show loading state
                const submitButton = this.querySelector('button[type="submit"]');
                if (submitButton) {
                    submitButton.disabled = true;
                    submitButton.innerHTML = '<img src="{{asset("assets/images/icons/timer.svg")}}" class="w-6 h-6 animate-spin mx-auto" alt="loading"> Uploading...';
                }
            });
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
    @keyframes fadeOut {
        from {
            opacity: 1;
            transform: translateX(0);
        }
        to {
            opacity: 0;
            transform: translateX(100%);
        }
    }
    
    /* Add pulse animation for pending status */
    .pulse-animation {
        animation: pulse 2s infinite;
    }
    
    @keyframes pulse {
        0%, 100% {
            opacity: 1;
        }
        50% {
            opacity: 0.7;
        }
    }
    
    /* Add subtle hover effect for cards */
    .card-hover:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        transition: all 0.3s ease;
    }
</style>
@endpush