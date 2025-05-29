<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Event;
use App\Models\Workshop;
use App\Services\FrontService;
use Illuminate\Http\Request;

class FrontController extends Controller
{
    protected $frontService;

    public function __construct(FrontService $frontService)
    {
        $this->frontService = $frontService;
    }

    public function index()
    {
        // Get categories
        $categories = Category::where('is_active', true)->get();
        
        // Get new workshops
        $newWorkshops = Workshop::with(['instructor', 'category'])
                        ->where('is_open', true)
                        ->orderBy('created_at', 'desc')
                        ->take(6)
                        ->get();
        
        // UBAH QUERY EVENT - Hapus filter tanggal
        $events = Event::where('is_active', true)
                 ->orderBy('tanggal', 'asc')
                 ->take(6)
                 ->get();
        
        // Tambahkan debug untuk cek jumlah events
        // dd($events); // Uncomment untuk debug
        
        return view('front.index', [
            'categories' => $categories,
            'newWorkshops' => $newWorkshops,
            'events' => $events
        ]);
    }

    public function details(Workshop $workshop)
    {
        return view('front.details', compact('workshop'));
    }

    public function category(Category $category)
    {
        // Eager load the workshops related to this category
        $category->load(['workshops' => function($query) {
            $query->where('is_open', true)
                  ->orderBy('created_at', 'desc');
        }, 'workshops.instructor']);
        
        return view('front.category', compact('category'));
    }

    public function eventsList()
    {
        $events = Event::where('is_active', true)
                 ->orderBy('tanggal', 'asc')
                 ->paginate(9);
                 
        // Change the view from 'front.events' to 'event.index'
        return view('event.index', [
            'events' => $events
        ]);
    }

    public function categoryFilter($type)
    {
        if ($type === 'events') {
            $items = Event::where('is_active', true)
                  ->orderBy('tanggal', 'asc')
                  ->paginate(9);
                  
            return view('front.events', [
                'events' => $items,
                'type' => 'Events'
            ]);
        } else {
            $items = Workshop::with(['instructor', 'category'])
                   ->where('is_open', true)
                   ->orderBy('created_at', 'desc')
                   ->paginate(9);
                   
            return view('front.category', [
                'workshops' => $items,
                'type' => 'Workshops'
            ]);
        }
    }

    public function allCategories()
    {
        // DARI: 
        // $categories = Category::where('status_aktif', true)->get();
        
        // MENJADI:
        $categories = Category::where('is_active', true)->get();
        
        return view('front.categories', [
            'categories' => $categories
        ]);
    }
}
