@extends('layout.app')
@section('title')
Pendaftaran Event
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
            <p class="font-bold text-[32px] leading-[48px] capitalize text-white">Pendaftaran Event</p>
            <p class="text-white">Silakan isi form pendaftaran dengan lengkap dan benar</p>
        </div>

        <!-- Main Form Section -->
        <main class="flex gap-8">
            <!-- Sidebar/Event Info Section -->
            <section id="Sidebar" class="flex flex-col w-[420px] h-fit rounded-3xl p-8 bg-white">
                <div class="flex flex-col gap-4">
                    <h2 class="font-Neue-Plak-bold text-xl leading-[27.5px]">Event Information</h2>
                    
                    <!-- Informasi event bisa ditampilkan di sini -->
                    <div class="flex flex-col gap-4">
                        <p class="w-full border-l-[5px] border-aktiv-green py-4 px-3 bg-aktiv-green/[9%] font-semibold text-aktiv-green">
                            Pastikan data yang dimasukkan sudah benar sebelum mengirimkan formulir.
                        </p>
                    </div>
                </div>
            </section>

            <!-- Registration Form -->
            <form id="registrationForm" method="POST" action="{{ route('event.register.store') }}" class="flex flex-col w-[724px] gap-8">
                @csrf
                
                <!-- Form Sections -->
                <div class="flex flex-col rounded-3xl p-8 gap-8 bg-white">
                    <!-- Security Message -->
                    <div class="flex items-center p-8 gap-4 bg-[#D4EAE8]">
                        <img src="{{asset('assets/images/icons/shield-tick.svg')}}" class="w-[62px] h-[62px] flex shrink-0" alt="icon">
                        <div class="flex flex-col gap-[2px]">
                            <p class="font-semibold text-lg leading-[27px]">Data Aman</p>
                            <p class="font-medium text-aktiv-grey">Data Anda akan disimpan dengan aman dan dilindungi.</p>
                        </div>
                    </div>

                    <!-- Error Messages Display -->
                    @if ($errors->any())
                    <div class="flex flex-col gap-2 p-4 bg-[#FEE3E3] rounded-xl">
                        <p class="font-semibold text-aktiv-red">Terdapat kesalahan pada pengisian form:</p>
                        <ul class="list-disc pl-5">
                            @foreach ($errors->all() as $error)
                                <li class="text-aktiv-red">{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif

                    <!-- Success Message Display -->
                    @if (session('success'))
                    <div class="flex flex-col gap-2 p-4 bg-[#D4EAE8] rounded-xl">
                        <p class="font-semibold text-aktiv-green">{{ session('success') }}</p>
                    </div>
                    @endif

                    <!-- Registration Type Section -->
                    <div class="flex flex-col gap-4">
                        <h2 class="font-Neue-Plak-bold text-xl leading-[27.5px]">Informasi Pendaftaran</h2>
                        
                        <!-- Event Selection (hidden field to store event_id) -->
                        <input type="hidden" name="event_id" value="{{ $event->id ?? request()->get('event_id', '') }}">

                        <!-- Kategori Pendaftaran Dropdown -->
                        <div class="flex flex-col gap-4">
                            <label class="flex flex-col gap-4">
                                <p class="font-medium text-aktiv-grey">Kategori Pendaftaran</p>
                                <div class="group input-wrapper flex items-center rounded-xl p-4 gap-2 bg-[#FBFBFB] overflow-hidden">
                                    <select name="kategori_pendaftaran" id="kategoriPendaftaran" class="appearance-none bg-transparent w-full outline-none text-lg leading-[27px] font-semibold" required>
                                        <option value="" disabled selected>Pilih kategori pendaftaran</option>
                                        <option value="observer">Observer</option>
                                        <option value="kompetisi">Kompetisi</option>
                                        <option value="undangan">Undangan</option>
                                    </select>
                                </div>
                            </label>
                        </div>

                        <!-- Jenis Pendaftaran Radio Buttons -->
                        <div class="flex flex-col gap-4">
                            <p class="font-medium text-aktiv-grey">Jenis Pendaftaran</p>
                            <div class="flex gap-4">
                                <label class="flex items-center gap-2 p-3 border rounded-xl">
                                    <input type="radio" name="jenis_pendaftaran" value="individu" checked class="h-6 w-6">
                                    <span class="font-semibold">Individu</span>
                                </label>
                                <label class="flex items-center gap-2 p-3 border rounded-xl">
                                    <input type="radio" name="jenis_pendaftaran" value="tim" class="h-6 w-6">
                                    <span class="font-semibold">Tim</span>
                                </label>
                            </div>
                        </div>

                        <!-- Status Pembayaran (Hidden - Default pending) -->
                        <input type="hidden" name="payment_status" value="pending">
                    </div>

                    <!-- Team Members Section - Only visible when Tim is selected -->
                    <div id="teamMembersSection" class="flex flex-col gap-4" style="display: none;">
                        <h2 class="font-Neue-Plak-bold text-xl leading-[27.5px]">Informasi Anggota Tim</h2>
                        <p class="font-medium text-aktiv-grey">Minimal 3 anggota dengan 1 ketua tim</p>
                        
                        <!-- Container for team members, will be populated dynamically -->
                        <div id="teamMembersContainer" class="flex flex-col gap-6">
                            <!-- Dynamic team members will be inserted here -->
                        </div>
                        
                        <!-- Button to add more team members -->
                        <button type="button" id="addMemberBtn" class="flex items-center justify-center w-full p-4 rounded-xl border border-[#E6E7EB] gap-2">
                            <img src="{{asset('assets/images/icons/add.svg')}}" alt="Add Member">
                            <span class="font-semibold">Tambah Anggota</span>
                        </button>
                        
                        <!-- Error message for team validation -->
                        <div id="teamValidationError" class="hidden font-medium text-aktiv-red"></div>
                    </div>

                    <!-- Google Drive Links - Only visible for kompetisi + approved -->
                    <div id="googleDriveSection" class="flex flex-col gap-4" style="display: none;">
                        <h2 class="font-Neue-Plak-bold text-xl leading-[27.5px]">Upload Dokumen</h2>
                        <p class="font-medium text-aktiv-grey">Silakan masukkan link Google Drive untuk dokumen-dokumen berikut:</p>
                        
                        <!-- Makalah Link -->
                        <label class="flex flex-col gap-4">
                            <p class="font-medium text-aktiv-grey">Link Google Drive Makalah</p>
                            <div class="group input-wrapper flex items-center rounded-xl p-4 gap-2 bg-[#FBFBFB] overflow-hidden">
                                <img src="{{asset('assets/images/icons/sms.svg')}}" class="w-6 h-6 flex shrink-0" alt="icon">
                                <input type="url" name="google_drive_makalah" class="appearance-none bg-transparent w-full outline-none text-lg leading-[27px] font-semibold" placeholder="https://drive.google.com/...">
                            </div>
                        </label>
                        
                        <!-- Lampiran Link -->
                        <label class="flex flex-col gap-4">
                            <p class="font-medium text-aktiv-grey">Link Google Drive Lampiran</p>
                            <div class="group input-wrapper flex items-center rounded-xl p-4 gap-2 bg-[#FBFBFB] overflow-hidden">
                                <img src="{{asset('assets/images/icons/sms.svg')}}" class="w-6 h-6 flex shrink-0" alt="icon">
                                <input type="url" name="google_drive_lampiran" class="appearance-none bg-transparent w-full outline-none text-lg leading-[27px] font-semibold" placeholder="https://drive.google.com/...">
                            </div>
                        </label>
                        
                        <!-- Video Sebelum Link -->
                        <label class="flex flex-col gap-4">
                            <p class="font-medium text-aktiv-grey">Link Google Drive Video Sebelum</p>
                            <div class="group input-wrapper flex items-center rounded-xl p-4 gap-2 bg-[#FBFBFB] overflow-hidden">
                                <img src="{{asset('assets/images/icons/sms.svg')}}" class="w-6 h-6 flex shrink-0" alt="icon">
                                <input type="url" name="google_drive_video_sebelum" class="appearance-none bg-transparent w-full outline-none text-lg leading-[27px] font-semibold" placeholder="https://drive.google.com/...">
                            </div>
                        </label>
                        
                        <!-- Video Sesudah Link -->
                        <label class="flex flex-col gap-4">
                            <p class="font-medium text-aktiv-grey">Link Google Drive Video Sesudah</p>
                            <div class="group input-wrapper flex items-center rounded-xl p-4 gap-2 bg-[#FBFBFB] overflow-hidden">
                                <img src="{{asset('assets/images/icons/sms.svg')}}" class="w-6 h-6 flex shrink-0" alt="icon">
                                <input type="url" name="google_drive_video_sesudah" class="appearance-none bg-transparent w-full outline-none text-lg leading-[27px] font-semibold" placeholder="https://drive.google.com/...">
                            </div>
                        </label>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" class="w-full rounded-xl h-16 px-6 text-center bg-aktiv-orange font-semibold text-lg leading-[27px] text-white">
                        Daftar Sekarang
                    </button>
                </div>
            </form>
        </main>
    </div>
</section>

@endsection

@push('after-scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Element references
        const jenisPendaftaranRadios = document.querySelectorAll('input[name="jenis_pendaftaran"]');
        const teamMembersSection = document.getElementById('teamMembersSection');
        const teamMembersContainer = document.getElementById('teamMembersContainer');
        const addMemberBtn = document.getElementById('addMemberBtn');
        const teamValidationError = document.getElementById('teamValidationError');
        const kategoriPendaftaran = document.getElementById('kategoriPendaftaran');
        const googleDriveSection = document.getElementById('googleDriveSection');
        
        // Define the base URL for assets using the current URL path to public directory
        const assetBaseUrl = "{{ url('/') }}/";
        
        // Counter for team members
        let memberCount = 0;
        
        // Initialize with default values
        function initialize() {
            // If Tim is selected initially, show team members section
            const selectedJenis = document.querySelector('input[name="jenis_pendaftaran"]:checked').value;
            if (selectedJenis === 'tim') {
                teamMembersSection.style.display = 'flex';
                // Add initial 3 members
                for (let i = 0; i < 3; i++) {
                    addTeamMember();
                }
            }
            
            // Check if we need to show Google Drive section
            toggleGoogleDriveSection();
        }
        
        // Toggle team members section visibility based on jenis pendaftaran selection
        jenisPendaftaranRadios.forEach(radio => {
            radio.addEventListener('change', function() {
                if (this.value === 'tim') {
                    teamMembersSection.style.display = 'flex';
                    // Add initial 3 members if none exist
                    if (teamMembersContainer.children.length === 0) {
                        for (let i = 0; i < 3; i++) {
                            addTeamMember();
                        }
                    }
                } else {
                    teamMembersSection.style.display = 'none';
                }
                validateTeam();
            });
        });
        
        // Listen for kategori pendaftaran changes to toggle Google Drive section
        kategoriPendaftaran.addEventListener('change', toggleGoogleDriveSection);
        
        // Function to toggle Google Drive section visibility
        function toggleGoogleDriveSection() {
            const isKompetisi = kategoriPendaftaran.value === 'kompetisi';
            // In a real app, you'd check if payment_status is 'approved'
            // Since we're using hidden field with default 'pending', we'll use a mock state for this example
            const isApproved = false; // This would be dynamic in a real app
            
            if (isKompetisi && isApproved) {
                googleDriveSection.style.display = 'flex';
                // Make inputs required
                document.querySelectorAll('#googleDriveSection input').forEach(input => {
                    input.setAttribute('required', 'required');
                });
            } else {
                googleDriveSection.style.display = 'none';
                // Remove required attribute
                document.querySelectorAll('#googleDriveSection input').forEach(input => {
                    input.removeAttribute('required');
                });
            }
        }
        
        // Add team member event
        addMemberBtn.addEventListener('click', function() {
            addTeamMember();
            validateTeam();
        });
        
        // Function to add a new team member
        function addTeamMember() {
            memberCount++;
            const memberHtml = `
                <div class="team-member flex flex-col gap-[10px]">
                    <div class="flex flex-col rounded-2xl border border-[#E6E7EB] p-6">
                        <div class="flex items-center justify-between mb-4">
                            <p class="font-semibold text-lg leading-[27px]">Anggota ${memberCount}</p>
                            ${memberCount > 3 ? `
                                <button type="button" class="delete-member w-6 h-6">
                                    <img src="${assetBaseUrl}assets/images/icons/trash.svg" alt="Delete">
                                </button>
                            ` : ''}
                        </div>
                        <div class="flex flex-col gap-6">
                            <!-- Nama Anggota -->
                            <label class="flex flex-col gap-4">
                                <p class="font-medium text-aktiv-grey">Nama Lengkap</p>
                                <div class="group input-wrapper flex items-center rounded-xl p-4 gap-2 bg-[#FBFBFB] overflow-hidden">
                                    <img src="${assetBaseUrl}assets/images/icons/profile-circle.svg" class="w-6 h-6 flex shrink-0" alt="icon">
                                    <input type="text" name="team_members[${memberCount-1}][nama]" class="appearance-none bg-transparent w-full outline-none text-lg leading-[27px] font-semibold" placeholder="Nama lengkap anggota" required>
                                </div>
                            </label>
                            
                            <!-- Email Anggota -->
                            <label class="flex flex-col gap-4">
                                <p class="font-medium text-aktiv-grey">Email</p>
                                <div class="group input-wrapper flex items-center rounded-xl p-4 gap-2 bg-[#FBFBFB] overflow-hidden">
                                    <img src="${assetBaseUrl}assets/images/icons/sms.svg" class="w-6 h-6 flex shrink-0" alt="icon">
                                    <input type="email" name="team_members[${memberCount-1}][email]" class="appearance-none bg-transparent w-full outline-none text-lg leading-[27px] font-semibold" placeholder="Email anggota" required>
                                </div>
                            </label>
                            
                            <!-- Kontak Anggota -->
                            <label class="flex flex-col gap-4">
                                <p class="font-medium text-aktiv-grey">Nomor Kontak</p>
                                <div class="group input-wrapper flex items-center rounded-xl p-4 gap-2 bg-[#FBFBFB] overflow-hidden">
                                    <img src="${assetBaseUrl}assets/images/icons/call.svg" class="w-6 h-6 flex shrink-0" alt="icon">
                                    <input type="tel" name="team_members[${memberCount-1}][kontak]" class="appearance-none bg-transparent w-full outline-none text-lg leading-[27px] font-semibold" placeholder="Nomor kontak anggota" required>
                                </div>
                            </label>
                            
                            <!-- Ketua Tim Checkbox -->
                            <label class="flex items-center gap-2">
                                <input type="checkbox" name="team_members[${memberCount-1}][is_ketua]" class="ketua-checkbox h-6 w-6" value="1">
                                <span class="font-medium">Ketua Tim</span>
                            </label>
                        </div>
                    </div>
                </div>
            `;
            
            teamMembersContainer.insertAdjacentHTML('beforeend', memberHtml);
            
            // Add event listeners to new elements
            const newTeamMember = teamMembersContainer.lastElementChild;
            
            // Add event listener to delete button if present
            const deleteBtn = newTeamMember.querySelector('.delete-member');
            if (deleteBtn) {
                deleteBtn.addEventListener('click', function() {
                    newTeamMember.remove();
                    validateTeam();
                });
            }
            
            // Add event listener to ketua checkbox
            const ketuaCheckbox = newTeamMember.querySelector('.ketua-checkbox');
            ketuaCheckbox.addEventListener('change', function() {
                // If this checkbox is checked, uncheck all others
                if (this.checked) {
                    document.querySelectorAll('.ketua-checkbox').forEach(cb => {
                        if (cb !== this) cb.checked = false;
                    });
                }
                validateTeam();
            });
        }
        
        // Validate team requirement (min 3 members, 1 ketua)
        function validateTeam() {
            const selectedJenis = document.querySelector('input[name="jenis_pendaftaran"]:checked').value;
            
            // Only validate if tim is selected
            if (selectedJenis === 'tim') {
                const teamMembers = teamMembersContainer.querySelectorAll('.team-member');
                const hasEnoughMembers = teamMembers.length >= 3;
                
                // Check if at least one member is ketua
                let hasKetua = false;
                teamMembersContainer.querySelectorAll('.ketua-checkbox').forEach(checkbox => {
                    if (checkbox.checked) hasKetua = true;
                });
                
                // Show validation error if needed
                if (!hasEnoughMembers) {
                    teamValidationError.textContent = 'Tim harus memiliki minimal 3 anggota.';
                    teamValidationError.classList.remove('hidden');
                } else if (!hasKetua) {
                    teamValidationError.textContent = 'Tim harus memiliki satu ketua.';
                    teamValidationError.classList.remove('hidden');
                } else {
                    teamValidationError.classList.add('hidden');
                }
            }
        }
        
        // Form submission validation
        document.getElementById('registrationForm').addEventListener('submit', function(e) {
            const selectedJenis = document.querySelector('input[name="jenis_pendaftaran"]:checked').value;
            
            // Validate team if tim is selected
            if (selectedJenis === 'tim') {
                const teamMembers = teamMembersContainer.querySelectorAll('.team-member');
                const hasEnoughMembers = teamMembers.length >= 3;
                
                // Check if at least one member is ketua
                let hasKetua = false;
                teamMembersContainer.querySelectorAll('.ketua-checkbox').forEach(checkbox => {
                    if (checkbox.checked) hasKetua = true;
                });
                
                // Prevent submission if validation fails
                if (!hasEnoughMembers || !hasKetua) {
                    e.preventDefault();
                    validateTeam(); // Show the error message
                    // Scroll to error
                    teamValidationError.scrollIntoView({ behavior: 'smooth', block: 'center' });
                }
            }
        });
        
        // Initialize the form
        initialize();
    });
</script>
@endpush