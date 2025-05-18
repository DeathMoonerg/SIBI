<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Contact;
use App\Models\SchoolClass;
use App\Models\Teacher;
use App\Models\Testimonial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PageController extends Controller
{
    public function home()
    {
        try {
            $popularClasses = SchoolClass::where('is_popular', true)
                ->orderBy('sort_order')
                ->take(3)
                ->get();

            $popularTeachers = Teacher::where('is_popular', true)
                ->orderBy('sort_order')
                ->take(3)
                ->get();

            // Ambil ulasan yang disetujui dari database
            $reviews = \App\Models\Review::with('user')
                ->where('is_approved', true)
                ->latest()
                ->take(3)
                ->get();
            
        } catch (\Exception $e) {
            // Handle database error with empty collections
            $popularClasses = collect();
            $popularTeachers = collect();
            $reviews = collect();
            
            // Log error for debugging
            \Illuminate\Support\Facades\Log::error('Database error: ' . $e->getMessage());
        }

        return view('home', compact('popularClasses', 'popularTeachers', 'reviews'));
    }

    public function about()
    {
        $popularTeachers = Teacher::where('is_popular', true)
            ->orderBy('sort_order')
            ->take(3)
            ->get();
            
        return view('about', compact('popularTeachers'));
    }

    public function classes()
    {
        $classes = SchoolClass::with('teacher')
            ->orderBy('sort_order')
            ->get();
            
        return view('classes', compact('classes'));
    }

    public function facility()
    {
        return view('facility');
    }

    public function team()
    {
        $teachers = Teacher::orderBy('sort_order')->get();
        
        return view('team', compact('teachers'));
    }

    public function callToAction()
    {
        $popularTeachers = Teacher::where('is_popular', true)
            ->orderBy('sort_order')
            ->take(3)
            ->get();
            
        return view('call-to-action', compact('popularTeachers'));
    }

    public function appointment()
    {
        $classes = SchoolClass::orderBy('name')->get();
        
        return view('appointment', compact('classes'));
    }

    public function testimonial()
    {
        // Ambil ulasan yang sudah disetujui dari tabel reviews
        $reviews = \App\Models\Review::with('user')
            ->where('is_approved', true)
            ->latest()
            ->get();
            
        return view('testimonial', compact('reviews'));
    }

    public function contact()
    {
        return view('contact');
    }

    public function notFound()
    {
        return view('404');
    }
    
    public function storeAppointment(Request $request)
    {
        $validated = $request->validate([
            'guardian_name' => 'required|string|max:255',
            'guardian_email' => 'required|email|max:255',
            'child_name' => 'required|string|max:255',
            'child_age' => 'required|string|max:50',
            'message' => 'nullable|string',
            'school_class_id' => 'nullable|exists:school_classes,id',
        ]);
        
        Appointment::create($validated);
        
        return redirect()->back()->with('success', 'Your appointment has been scheduled successfully. We will contact you soon.');
    }
    
    public function storeContact(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'subject' => 'nullable|string|max:255',
            'message' => 'required|string',
        ]);
        
        Contact::create($validated);
        
        return redirect()->back()->with('success', 'Your message has been sent successfully. We will contact you soon.');
    }
} 