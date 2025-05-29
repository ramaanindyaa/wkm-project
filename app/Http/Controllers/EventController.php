<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Participant;
use App\Models\TeamMember;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

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
}