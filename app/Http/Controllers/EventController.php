<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Participant;
use App\Models\TeamMember;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class EventController extends Controller
{
    /**
     * Display the registration form for an event
     * 
     * @param Event|null $event Optional event model if specified in the route
     * @return \Illuminate\View\View
     */
    public function registerForm(Event $event = null)
    {
        // Get all active events for dropdown selection if no specific event is provided
        $events = [];
        if (!$event) {
            $events = Event::where('status_aktif', true)->get();
        }
        
        return view('event.register', [
            'event' => $event, 
            'events' => $events
        ]);
    }

    /**
     * Process the event registration form
     * 
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function register(Request $request)
    {
        // Validate common fields
        $validationRules = [
            'event_id' => 'required|exists:events,id',
            'kategori_pendaftaran' => 'required|in:observer,kompetisi,undangan',
            'jenis_pendaftaran' => 'required|in:individu,tim',
            'payment_status' => 'required|in:pending,approved,rejected',
        ];
        
        // Add conditional validation rules for team members if jenis_pendaftaran is 'tim'
        if ($request->jenis_pendaftaran === 'tim') {
            $validationRules['team_members'] = 'required|array|min:3';
            $validationRules['team_members.*.nama'] = 'required|string|max:255';
            $validationRules['team_members.*.email'] = 'required|email|max:255';
            $validationRules['team_members.*.kontak'] = 'required|string|max:100';
        }
        
        // Add conditional validation for Google Drive links if kategori is 'kompetisi' and status is 'approved'
        if ($request->kategori_pendaftaran === 'kompetisi' && $request->payment_status === 'approved') {
            $validationRules['google_drive_makalah'] = 'required|url|max:255';
            $validationRules['google_drive_lampiran'] = 'required|url|max:255';
            $validationRules['google_drive_video_sebelum'] = 'required|url|max:255';
            $validationRules['google_drive_video_sesudah'] = 'required|url|max:255';
        }
        
        $validated = $request->validate($validationRules);
        
        try {
            // Use database transaction to ensure data integrity
            DB::beginTransaction();
            
            // Create the participant record
            $participant = Participant::create([
                'event_id' => $validated['event_id'],
                'kategori_pendaftaran' => $validated['kategori_pendaftaran'],
                'jenis_pendaftaran' => $validated['jenis_pendaftaran'],
                'payment_status' => $validated['payment_status'],
                // Add Google Drive links if they exist in the validated data
                'google_drive_makalah' => $validated['google_drive_makalah'] ?? null,
                'google_drive_lampiran' => $validated['google_drive_lampiran'] ?? null,
                'google_drive_video_sebelum' => $validated['google_drive_video_sebelum'] ?? null,
                'google_drive_video_sesudah' => $validated['google_drive_video_sesudah'] ?? null,
            ]);
            
            // Process team members if this is a team registration
            if ($validated['jenis_pendaftaran'] === 'tim' && isset($validated['team_members'])) {
                // Check if at least one team member is marked as leader
                $hasLeader = false;
                
                foreach ($validated['team_members'] as $member) {
                    $isKetua = isset($member['is_ketua']) && $member['is_ketua'] == 1;
                    
                    if ($isKetua) {
                        $hasLeader = true;
                    }
                    
                    // Create team member record
                    TeamMember::create([
                        'participant_id' => $participant->id,
                        'nama' => $member['nama'],
                        'email' => $member['email'],
                        'kontak' => $member['kontak'],
                        'is_ketua' => $isKetua,
                    ]);
                }
                
                // If no leader was specified, set the first member as leader
                if (!$hasLeader) {
                    $firstMember = TeamMember::where('participant_id', $participant->id)->first();
                    if ($firstMember) {
                        $firstMember->update(['is_ketua' => true]);
                    }
                }
            }
            
            // All operations successful, commit transaction
            DB::commit();
            
            // Get event name for success message
            $eventName = Event::find($validated['event_id'])->nama;
            
            return redirect()->back()->with('success', 'Pendaftaran untuk "' . $eventName . '" berhasil disimpan. Terima kasih!');
            
        } catch (\Exception $e) {
            // Something went wrong, rollback transaction
            DB::rollBack();
            
            // Log the error
            Log::error('Error during registration: ' . $e->getMessage());
            
            return redirect()->back()
                ->withInput()
                ->withErrors(['general' => 'Terjadi kesalahan saat menyimpan data. Silakan coba lagi atau hubungi admin.']);
        }
    }
    
    /**
     * Display list of all active events
     * 
     * @return \Illuminate\View\View
     */
    public function listEvents()
    {
        $events = Event::where('is_active', true) // Ganti status_aktif menjadi is_active
            ->orderBy('tanggal', 'asc')
            ->get();
            
        return view('event.list', ['events' => $events]);
    }
    
    /**
     * Show detail page for a specific event
     * 
     * @param Event $event
     * @return \Illuminate\View\View
     */
    public function showEvent(Event $event)
    {
        return view('event.show', ['event' => $event]);
    }
    
    /**
     * Check registration status by email
     * 
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function checkRegistration(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email|max:255',
        ]);
        
        // Find team members with this email
        $teamMembers = TeamMember::where('email', $validated['email'])->get();
        
        // Get all participant IDs these team members belong to
        $participantIds = $teamMembers->pluck('participant_id')->unique();
        
        // Get all participants
        $participants = Participant::whereIn('id', $participantIds)->with('event')->get();
        
        return view('event.registration-status', [
            'email' => $validated['email'],
            'participants' => $participants,
            'teamMembers' => $teamMembers
        ]);
    }

    /**
     * Display a listing of events with optional search functionality.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        // Start with a base query for active events
        $query = Event::where('is_active', true);
        
        // Apply search filter if a search term is provided
        if ($request->filled('search')) {
            $searchTerm = trim($request->input('search'));
            
            // Log the search term for debugging
            \Log::info('Search term: ' . $searchTerm);
            
            // Use raw SQL for more reliable searching
            $query->where(function($q) use ($searchTerm) {
                $likePattern = '%' . $searchTerm . '%';
                $q->whereRaw('LOWER(nama) LIKE ?', [strtolower($likePattern)])
                  ->orWhereRaw('LOWER(deskripsi) LIKE ?', [strtolower($likePattern)])
                  ->orWhereRaw('LOWER(lokasi) LIKE ?', [strtolower($likePattern)]);
                
                // Log the generated SQL query with bindings
                \Log::info('SQL query: ' . $q->toSql());
                \Log::info('SQL bindings: ', $q->getBindings());
            });
            
            // Add the search term to flash data for debugging in the view
            session()->flash('debug_search', $searchTerm);
        }
        
        // Apply default ordering
        $query->orderBy('tanggal', 'asc');
        
        // Execute the query and get results
        $events = $query->paginate(9)->withQueryString();
        
        // Log the count for debugging
        \Log::info('Results count: ' . $events->total());
        
        // Return the view with the events
        return view('event.index', compact('events'));
    }
    
    /**
     * Show payment form for event registration
     */
    public function showPayment(Event $event)
    {
        // Ambil data registrasi dari session (setelah user mengisi form registrasi)
        $registrationData = session('event_registration_data', []);
        
        if (empty($registrationData)) {
            return redirect()->route('event.register', $event->id)
                ->with('error', 'Please complete the registration form first.');
        }
        
        return view('event.payment', compact('event', 'registrationData'));
    }

    /**
     * Store payment information
     */
    public function storePayment(Request $request)
    {
        $validated = $request->validate([
            'event_id' => 'required|exists:events,id',
            'customer_bank_name' => 'required|string|max:255',
            'customer_bank_account' => 'required|string|max:255',
            'customer_bank_number' => 'required|string|max:255',
            'proof' => 'required|file|mimes:jpeg,png,jpg,pdf|max:2048',
        ]);
        
        try {
            DB::beginTransaction();
            
            // Ambil data registrasi dari session
            $registrationData = session('event_registration_data');
            
            if (!$registrationData) {
                throw new \Exception('Registration data not found.');
            }
            
            // Upload bukti pembayaran
            $proofPath = $request->file('proof')->store('event-payments', 'public');
            
            // Buat participant record dengan menggabungkan data registrasi dan payment
            $participantData = array_merge($registrationData, [
                'payment_status' => 'pending',
                'payment_proof' => $proofPath,
                'customer_bank_name' => $validated['customer_bank_name'],
                'customer_bank_account' => $validated['customer_bank_account'],
                'customer_bank_number' => $validated['customer_bank_number'],
            ]);
            
            $participant = Participant::create($participantData);
            
            // Jika registrasi tim, simpan anggota tim
            if ($registrationData['jenis_pendaftaran'] === 'tim' && isset($registrationData['team_members'])) {
                $hasLeader = false;
                
                foreach ($registrationData['team_members'] as $member) {
                    $isKetua = isset($member['is_ketua']) && $member['is_ketua'];
                    if ($isKetua) {
                        $hasLeader = true;
                    }
                    
                    TeamMember::create([
                        'participant_id' => $participant->id,
                        'nama' => $member['nama'],
                        'email' => $member['email'],
                        'kontak' => $member['kontak'],
                        'is_ketua' => $isKetua,
                    ]);
                }
                
                // Jika tidak ada ketua yang ditentukan, set anggota pertama sebagai ketua
                if (!$hasLeader) {
                    $firstMember = TeamMember::where('participant_id', $participant->id)->first();
                    if ($firstMember) {
                        $firstMember->update(['is_ketua' => true]);
                    }
                }
            }
            
            DB::commit();
            
            // Hapus data registrasi dari session
            session()->forget('event_registration_data');
            
            return redirect()->route('event.payment.success', $participant->id)
                ->with('success', 'Payment submitted successfully. Please wait for verification.');
                
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Event payment submission failed: ' . $e->getMessage());
            
            return redirect()->back()
                ->withInput()
                ->withErrors(['error' => 'Payment submission failed. Please try again.']);
        }
    }

    /**
     * Show payment success page
     */
    public function paymentSuccess(Participant $participant)
    {
        return view('event.payment-success', compact('participant'));
    }

    /**
     * Store event registration data to session and redirect to payment
     */
    public function store(Request $request)
    {
        // Validation rules for all fields
        $validationRules = [
            'event_id' => 'required|exists:events,id',
            
            // Personal Information (REQUIRED)
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'email' => 'required|email|max:255',
            'company' => 'nullable|string|max:255',
            
            // Registration Information
            'kategori_pendaftaran' => 'required|in:observer,kompetisi,undangan',
            'jenis_pendaftaran' => 'required|in:individu,tim',
            'payment_status' => 'required|in:pending,approved,rejected',
        ];

        // Additional validation for team registration
        if ($request->jenis_pendaftaran === 'tim') {
            $validationRules['team_members'] = 'required|array|min:3';
            $validationRules['team_members.*.nama'] = 'required|string|max:255';
            $validationRules['team_members.*.email'] = 'required|email|max:255';
            $validationRules['team_members.*.kontak'] = 'required|string|max:100';
            $validationRules['team_members.*.is_ketua'] = 'nullable|boolean';
        }

        // Additional validation for competition category (only if needed)
        if ($request->kategori_pendaftaran === 'kompetisi') {
            $validationRules['google_drive_makalah'] = 'nullable|url|max:255';
            $validationRules['google_drive_lampiran'] = 'nullable|url|max:255';
            $validationRules['google_drive_video_sebelum'] = 'nullable|url|max:255';
            $validationRules['google_drive_video_sesudah'] = 'nullable|url|max:255';
        }
        
        // Validate the request
        $validated = $request->validate($validationRules, [
            // Custom error messages
            'name.required' => 'Full name is required.',
            'phone.required' => 'Phone number is required.',
            'email.required' => 'Email address is required.',
            'email.email' => 'Please enter a valid email address.',
            'kategori_pendaftaran.required' => 'Please select a registration category.',
            'jenis_pendaftaran.required' => 'Please select a registration type.',
            'team_members.required' => 'Team members are required for team registration.',
            'team_members.min' => 'Team must have at least 3 members.',
            'team_members.*.nama.required' => 'Team member name is required.',
            'team_members.*.email.required' => 'Team member email is required.',
            'team_members.*.kontak.required' => 'Team member phone number is required.',
        ]);
        
        try {
            // Validate team leader if team registration
            if ($validated['jenis_pendaftaran'] === 'tim') {
                $hasLeader = false;
                foreach ($validated['team_members'] as $member) {
                    if (isset($member['is_ketua']) && $member['is_ketua']) {
                        $hasLeader = true;
                        break;
                    }
                }
                
                if (!$hasLeader) {
                    return redirect()->back()
                        ->withInput()
                        ->withErrors(['team_members' => 'Team must have at least one leader.']);
                }
            }
            
            // Store validated data to session for payment processing
            session([
                'event_registration_data' => $validated
            ]);
            
            // Get event for redirect
            $event = Event::findOrFail($validated['event_id']);
            
            // Redirect to payment page
            return redirect()->route('event.payment', $event->id)
                ->with('success', 'Registration data saved successfully. Please complete the payment process.');
                
        } catch (\Exception $e) {
            Log::error('Error saving registration data: ' . $e->getMessage());
            Log::error('Request data: ' . json_encode($request->all()));
            
            return redirect()->back()
                ->withInput()
                ->withErrors(['general' => 'An error occurred while saving data. Please try again.']);
        }
    }
    
    /**
     * Show event registration form
     */
    public function showRegister(Event $event)
    {
        // Check if event is available for registration
        if (!$event->is_open) {
            return redirect()->route('event.show', $event->id)
                ->with('error', 'Registration for this event is currently closed.');
        }
        
        return view('event.register', compact('event'));
    }
}