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

class EventController extends Controller
{
    /**
     * Display a listing of active events
     */
    public function index()
    {
        $events = Event::where('is_active', true)
            ->where('is_open', true)
            ->orderBy('tanggal', 'asc')
            ->get();
            
        return view('event.index', compact('events'));
    }

    /**
     * Show the form for registering to an event
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
     * Show payment form
     */
    public function showPayment(Event $event)
    {
        // Get registration data from session
        $registrationData = session('event_registration_data');
        
        if (!$registrationData) {
            return redirect()->route('event.register', $event->id)
                ->with('error', 'Registration data not found. Please complete the registration form first.');
        }
        
        return view('event.payment', compact('event', 'registrationData'));
    }

    /**
     * Store payment information and create transaction
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
            
            // Get registration data from session
            $registrationData = session('event_registration_data');
            
            if (!$registrationData) {
                throw new \Exception('Registration data not found.');
            }
            
            // Get event to calculate total amount
            $event = Event::findOrFail($validated['event_id']);
            
            // Calculate total amount
            $teamSize = 1; // Default for individual
            if ($registrationData['jenis_pendaftaran'] === 'tim') {
                $teamSize = count($registrationData['team_members'] ?? []);
            }
            
            $subtotal = $event->price * $teamSize;
            $tax = $subtotal * 0.11; // PPN 11%
            $totalAmount = $subtotal + $tax;
            
            // Upload payment proof
            $proofPath = $request->file('proof')->store('event-payments', 'public');
            
            // Create EventRegistrationTransaction record
            $transactionData = [
                // Basic transaction info
                'is_paid' => false,
                
                // Personal information
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
                'google_drive_makalah' => $registrationData['google_drive_makalah'] ?? null,
                'google_drive_lampiran' => $registrationData['google_drive_lampiran'] ?? null,
                'google_drive_video_sebelum' => $registrationData['google_drive_video_sebelum'] ?? null,
                'google_drive_video_sesudah' => $registrationData['google_drive_video_sesudah'] ?? null,
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
        $validated = $request->validate([
            'registration_trx_id' => 'required|string|max:255',
        ], [
            'registration_trx_id.required' => 'Registration Transaction ID is required.',
        ]);

        try {
            // Find transaction by registration_trx_id
            $transaction = EventRegistrationTransaction::with(['event', 'teamMembers'])
                ->where('registration_trx_id', $validated['registration_trx_id'])
                ->first();

            if (!$transaction) {
                return redirect()->back()
                    ->withInput()
                    ->withErrors(['registration_trx_id' => 'Registration Transaction ID not found. Please check your Transaction ID.']);
            }

            return view('event.registration_details', compact('transaction'));

        } catch (\Exception $e) {
            Log::error('Error checking registration details: ' . $e->getMessage());
            
            return redirect()->back()
                ->withInput()
                ->withErrors(['error' => 'An error occurred while checking registration. Please try again.']);
        }
    }

    /**
     * Update competition documents for approved registrations
     */
    public function updateDocuments(Request $request, EventRegistrationTransaction $transaction)
    {
        // Validate that transaction is competition category and approved
        if ($transaction->kategori_pendaftaran !== 'kompetisi' || $transaction->payment_status !== 'approved') {
            return redirect()->back()
                ->withErrors(['error' => 'Document upload is only available for approved competition registrations.']);
        }

        $validated = $request->validate([
            'google_drive_makalah' => 'required|url|max:255',
            'google_drive_lampiran' => 'required|url|max:255',
            'google_drive_video_sebelum' => 'required|url|max:255',
            'google_drive_video_sesudah' => 'required|url|max:255',
        ], [
            'google_drive_makalah.required' => 'Paper Google Drive link is required.',
            'google_drive_makalah.url' => 'Please enter a valid Google Drive URL for paper.',
            'google_drive_lampiran.required' => 'Attachment Google Drive link is required.',
            'google_drive_lampiran.url' => 'Please enter a valid Google Drive URL for attachment.',
            'google_drive_video_sebelum.required' => 'Before video Google Drive link is required.',
            'google_drive_video_sebelum.url' => 'Please enter a valid Google Drive URL for before video.',
            'google_drive_video_sesudah.required' => 'After video Google Drive link is required.',
            'google_drive_video_sesudah.url' => 'Please enter a valid Google Drive URL for after video.',
        ]);

        try {
            $transaction->update([
                'google_drive_makalah' => $validated['google_drive_makalah'],
                'google_drive_lampiran' => $validated['google_drive_lampiran'],
                'google_drive_video_sebelum' => $validated['google_drive_video_sebelum'],
                'google_drive_video_sesudah' => $validated['google_drive_video_sesudah'],
            ]);

            return redirect()->back()
                ->with('success', 'Competition documents updated successfully.');

        } catch (\Exception $e) {
            Log::error('Error updating competition documents: ' . $e->getMessage());
            
            return redirect()->back()
                ->withInput()
                ->withErrors(['error' => 'Failed to update documents. Please try again.']);
        }
    }
}