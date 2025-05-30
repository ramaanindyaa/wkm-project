<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\EventRegistrationTransaction;
use App\Models\EventTeamMember;
use App\Models\Participant;
use App\Models\TeamMember;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str; // Add this missing import

class EventController extends Controller
{
    /**
     * Display a listing of active events
     */
    public function index()
    {
        $events = Event::where('is_active', true)
            ->orderBy('tanggal', 'asc')
            ->paginate(9);
            
        return view('event.index', compact('events'));
    }

    /**
     * Show the form for registering to an event
     */
    public function showRegister(Event $event)
    {
        // Check if event is active and registration is open
        if (!$event->is_active) {
            return redirect()->route('event.show', $event->id)
                ->withErrors(['error' => 'Event is not active for registration.']);
        }

        if ($event->has_started) {
            return redirect()->route('event.show', $event->id)
                ->withErrors(['error' => 'Registration is closed. Event has already started.']);
        }

        if (!$event->is_open) {
            return redirect()->route('event.show', $event->id)
                ->withErrors(['error' => 'Registration is currently closed for this event.']);
        }

        return view('event.register', compact('event'));
    }

    /**
     * Store event registration data to session and redirect to payment
     */
    public function store(Request $request)
    {
        // Base validation rules
        $validationRules = [
            'event_id' => 'required|exists:events,id',
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'company' => 'nullable|string|max:255',
            'kategori_pendaftaran' => 'required|in:observer,kompetisi,undangan',
            'jenis_pendaftaran' => 'required|in:individu,tim',
        ];

        // Additional validation for team registration
        if ($request->jenis_pendaftaran === 'tim') {
            $validationRules['team_members'] = 'required|array|min:3';
            $validationRules['team_members.*.nama'] = 'required|string|max:255';
            $validationRules['team_members.*.email'] = 'required|email|max:255';
            $validationRules['team_members.*.kontak'] = 'required|string|max:100';
            $validationRules['team_members.*.is_ketua'] = 'nullable|boolean';
        }

        // Custom validation messages
        $messages = [
            'event_id.required' => 'Event is required.',
            'event_id.exists' => 'Selected event does not exist.',
            'name.required' => 'Full name is required.',
            'email.required' => 'Email address is required.',
            'email.email' => 'Please enter a valid email address.',
            'phone.required' => 'Phone number is required.',
            'kategori_pendaftaran.required' => 'Registration category is required.',
            'jenis_pendaftaran.required' => 'Registration type is required.',
            'team_members.required' => 'Team members are required for team registration.',
            'team_members.min' => 'Team must have at least 3 members.',
            'team_members.*.nama.required' => 'Team member name is required.',
            'team_members.*.email.required' => 'Team member email is required.',
            'team_members.*.email.email' => 'Team member email must be valid.',
            'team_members.*.kontak.required' => 'Team member phone number is required.',
        ];

        $validated = $request->validate($validationRules, $messages);
        
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
                ->with('success', 'Registration data saved. Please proceed with payment.');
                
        } catch (\Exception $e) {
            Log::error('Event registration failed: ' . $e->getMessage());
            Log::error('Request data: ' . json_encode($request->all()));
            
            return redirect()->back()
                ->withInput()
                ->withErrors(['error' => 'Registration failed. Please try again.']);
        }
    }

    /**
     * Show event payment form
     */
    public function showPayment(Event $event)
    {
        // Check if registration data exists in session
        $registrationData = session('event_registration_data');
        
        if (!$registrationData) {
            return redirect()->route('event.register', $event->id)
                ->withErrors(['error' => 'Registration data not found. Please complete registration first.']);
        }
        
        // Validate that the event ID matches
        if ($registrationData['event_id'] != $event->id) {
            return redirect()->route('event.register', $event->id)
                ->withErrors(['error' => 'Registration data mismatch. Please register again.']);
        }
        
        // Check if event is still active and registration is open
        if (!$event->is_active || $event->has_started || !$event->is_open) {
            session()->forget('event_registration_data');
            return redirect()->route('event.show', $event->id)
                ->withErrors(['error' => 'Event registration is no longer available.']);
        }
        
        return view('event.payment', compact('event', 'registrationData'));
    }

    /**
     * Store event payment information and create transaction
     */
    public function storePayment(Request $request)
    {
        // Get registration data from session
        $registrationData = session('event_registration_data');
        
        if (!$registrationData) {
            return redirect()->route('event.index')
                ->withErrors(['error' => 'Registration session expired. Please register again.']);
        }
        
        // Validate payment form data
        $validated = $request->validate([
            'event_id' => 'required|exists:events,id',
            'customer_bank_name' => 'required|string|max:255',
            'customer_bank_account' => 'required|string|max:255',
            'customer_bank_number' => 'required|string|max:255',
            'payment_proof' => 'required|file|mimes:jpg,jpeg,png,pdf|max:5120', // Max 5MB
        ], [
            'event_id.required' => 'Event is required.',
            'event_id.exists' => 'Selected event does not exist.',
            'customer_bank_name.required' => 'Bank name is required.',
            'customer_bank_account.required' => 'Account holder name is required.',
            'customer_bank_number.required' => 'Account number is required.',
            'payment_proof.required' => 'Payment proof is required.',
            'payment_proof.file' => 'Payment proof must be a file.',
            'payment_proof.mimes' => 'Payment proof must be JPG, JPEG, PNG, or PDF.',
            'payment_proof.max' => 'Payment proof must not exceed 5MB.',
        ]);
        
        try {
            DB::beginTransaction();
            
            // Get event for price calculation
            $event = Event::findOrFail($validated['event_id']);
            
            // Calculate total participants and amount
            $totalParticipants = 1; // Main registrant
            if ($registrationData['jenis_pendaftaran'] === 'tim' && isset($registrationData['team_members'])) {
                $totalParticipants = count($registrationData['team_members']);
            }
            
            // Calculate total amount: (price per person × participants) + PPN 11%
            $subtotal = $event->price * $totalParticipants;
            $totalAmount = $subtotal * 1.11;
            
            // Upload payment proof
            $proofPath = $request->file('payment_proof')->store('event-payments', 'public');
            
            // Create transaction record using model's auto-generated transaction ID
            $transactionData = [
                // Personal information from registration
                'name' => $registrationData['name'],
                'email' => $registrationData['email'],
                'phone' => $registrationData['phone'],
                'company' => $registrationData['company'] ?? null,
                
                // Event registration details
                'event_id' => $validated['event_id'],
                'kategori_pendaftaran' => $registrationData['kategori_pendaftaran'],
                'jenis_pendaftaran' => $registrationData['jenis_pendaftaran'],
                'payment_status' => 'pending',
                'total_amount' => $totalAmount,
                
                // Payment information
                'customer_bank_name' => $validated['customer_bank_name'],
                'customer_bank_account' => $validated['customer_bank_account'],
                'customer_bank_number' => $validated['customer_bank_number'],
                'payment_proof' => $proofPath,
                
                // Competition documents (will be filled later if approved)
                'google_drive_makalah' => null,
                'google_drive_lampiran' => null,
                'google_drive_video_sebelum' => null,
                'google_drive_video_sesudah' => null,
            ];
            
            $transaction = EventRegistrationTransaction::create($transactionData);
            
            // If team registration, save team members
            if ($registrationData['jenis_pendaftaran'] === 'tim' && isset($registrationData['team_members'])) {
                $hasLeader = false;
                
                foreach ($registrationData['team_members'] as $member) {
                    $isKetua = isset($member['is_ketua']) && $member['is_ketua'];
                    if ($isKetua) {
                        $hasLeader = true;
                    }
                    
                    EventTeamMember::create([
                        'registration_transaction_id' => $transaction->id,
                        'nama' => $member['nama'],
                        'email' => $member['email'],
                        'kontak' => $member['kontak'],
                        'is_ketua' => $isKetua,
                    ]);
                }
                
                // If no leader was specified, set the first member as leader
                if (!$hasLeader) {
                    $firstMember = EventTeamMember::where('registration_transaction_id', $transaction->id)->first();
                    if ($firstMember) {
                        $firstMember->update(['is_ketua' => true]);
                    }
                }
            }
            
            DB::commit();
            
            // Clear registration data from session
            session()->forget('event_registration_data');
            
            // Log successful payment submission
            Log::info('Event payment submitted successfully', [
                'transaction_id' => $transaction->registration_trx_id,
                'event_id' => $event->id,
                'user_ip' => request()->ip(),
                'registration_type' => $registrationData['jenis_pendaftaran'],
                'category' => $registrationData['kategori_pendaftaran'],
                'total_participants' => $totalParticipants,
                'subtotal' => $subtotal,
                'total_amount' => $totalAmount
            ]);
            
            return redirect()->route('event.payment.success', $transaction->id)
                ->with('success', 'Payment submitted successfully. Please wait for verification.');
                
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Event payment submission failed: ' . $e->getMessage());
            Log::error('Registration data: ' . json_encode($registrationData ?? []));
            Log::error('Request data: ' . json_encode($request->all()));
            
            return redirect()->back()
                ->withInput()
                ->withErrors(['error' => 'Payment submission failed. Please try again.']);
        }
    }

    /**
     * Show payment success page
     */
    public function paymentSuccess(EventRegistrationTransaction $transaction)
    {
        // Load relationships for better performance
        $transaction->load(['event', 'teamMembers']);
        
        // Log successful payment page access
        Log::info('Payment success page accessed', [
            'transaction_id' => $transaction->registration_trx_id,
            'event_id' => $transaction->event_id,
            'user_ip' => request()->ip()
        ]);
        
        return view('event.payment-success', ['participant' => $transaction]);
    }

    /**
     * Show event detail page
     */
    public function show(Event $event)
    {
        return view('event.show', compact('event'));
    }

    /**
     * Display list of all active events (for listing page)
     */
    public function listEvents()
    {
        $events = Event::where('is_active', true)
            ->orderBy('tanggal', 'asc')
            ->get();
            
        return view('event.list', ['events' => $events]);
    }

    /**
     * Show check registration form
     */
    public function checkRegistration()
    {
        return view('event.check_registration');
    }

    /**
     * Check registration details by transaction ID
     */
    public function checkRegistrationDetails(Request $request)
    {
        // Check if it's a GET or POST request
        if ($request->isMethod('post')) {
            // Process form submission
            $validated = $request->validate([
                'registration_trx_id' => 'required|exists:event_registration_transactions,registration_trx_id',
            ]);
            
            // Fetch transaction
            $transaction = EventRegistrationTransaction::where('registration_trx_id', $validated['registration_trx_id'])->firstOrFail();
        } else {
            // Direct GET access - either redirect or handle appropriately
            return redirect()->route('event.check_registration');
        }
        
        // Rest of your code to display details
        return view('event.check_registration_details', compact('transaction'));
    }

    /**
     * Update competition documents for approved registrations
     */
    public function updateDocuments(Request $request, EventRegistrationTransaction $transaction)
    {
        // Validate that transaction exists and belongs to competition category
        if ($transaction->kategori_pendaftaran !== 'kompetisi') {
            return redirect()->back()
                ->withErrors(['error' => 'Document upload is only available for competition category registrations.']);
        }

        // Validate that payment is approved
        if ($transaction->payment_status !== 'approved') {
            return redirect()->back()
                ->withErrors(['error' => 'Document upload is only available for approved registrations. Your payment status: ' . $transaction->payment_status_label]);
        }

        // Validate the uploaded document links
        $validated = $request->validate([
            'google_drive_makalah' => 'required|url|max:500',
            'google_drive_lampiran' => 'required|url|max:500',
            'google_drive_video_sebelum' => 'required|url|max:500',
            'google_drive_video_sesudah' => 'required|url|max:500',
        ], [
            'google_drive_makalah.required' => 'Paper document Google Drive link is required.',
            'google_drive_makalah.url' => 'Paper document must be a valid Google Drive URL.',
            'google_drive_lampiran.required' => 'Attachment document Google Drive link is required.',
            'google_drive_lampiran.url' => 'Attachment document must be a valid Google Drive URL.',
            'google_drive_video_sebelum.required' => 'Before video Google Drive link is required.',
            'google_drive_video_sebelum.url' => 'Before video must be a valid Google Drive URL.',
            'google_drive_video_sesudah.required' => 'After video Google Drive link is required.',
            'google_drive_video_sesudah.url' => 'After video must be a valid Google Drive URL.',
        ]);

        try {
            // Update ALL document fields
            $transaction->update([
                'google_drive_makalah' => $validated['google_drive_makalah'],
                'google_drive_lampiran' => $validated['google_drive_lampiran'],
                'google_drive_video_sebelum' => $validated['google_drive_video_sebelum'],
                'google_drive_video_sesudah' => $validated['google_drive_video_sesudah'],
            ]);

            // Log successful document upload
            Log::info('Competition documents updated successfully', [
                'transaction_id' => $transaction->registration_trx_id,
                'documents' => array_keys($validated)
            ]);

            // Redirect to success page instead of going back
            return redirect()->route('event.documents.success', $transaction->id);
        } catch (\Exception $e) {
            Log::error('Error updating competition documents: ' . $e->getMessage());
            Log::error('Transaction ID: ' . $transaction->registration_trx_id);
            Log::error('Request data: ' . json_encode($request->all()));
            
            return redirect()->back()
                ->withInput()
                ->withErrors(['error' => 'Failed to upload documents. Please try again or contact support if the problem persists.']);
        }
    }
    
    /**
     * Show document upload success page
     */
    public function documentUploadSuccess(EventRegistrationTransaction $transaction)
    {
        // Check if transaction belongs to the right category
        if ($transaction->kategori_pendaftaran !== 'kompetisi') {
            return redirect()->route('event.check_registration');
        }
        
        // Load relationships for better performance
        $transaction->load(['event', 'teamMembers']);
        
        return view('event.document-upload-success', compact('transaction'));
    }
}