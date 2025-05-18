<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use App\Models\User;
use App\Models\Testimonial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    /**
     * Check if the current user is an admin.
     *
     * @return bool
     */
    private function isAdmin()
    {
        return Auth::check() && Auth::user()->role === 'admin';
    }

    public function dashboard()
    {
        if (!$this->isAdmin()) {
            return redirect()->route('home')->with('error', 'Anda tidak memiliki akses ke halaman tersebut.');
        }

        $totalTeachers = User::where('role', 'teacher')->count();
        $totalStudents = User::where('role', 'student')->count();
        $totalParents = User::where('role', 'parent')->count();
        $unreadContacts = Contact::where('is_read', false)->count();
        $recentTestimonials = Testimonial::latest()->take(5)->get();

        return view('admin.dashboard', compact(
            'totalTeachers',
            'totalStudents',
            'totalParents',
            'unreadContacts',
            'recentTestimonials'
        ));
    }

    public function contacts()
    {
        if (!$this->isAdmin()) {
            return redirect()->route('home')->with('error', 'Anda tidak memiliki akses ke halaman tersebut.');
        }

        $contacts = Contact::latest()->paginate(10);
        return view('admin.contacts', compact('contacts'));
    }

    public function teachers()
    {
        if (!$this->isAdmin()) {
            return redirect()->route('home')->with('error', 'Anda tidak memiliki akses ke halaman tersebut.');
        }

        $teachers = User::where('role', 'teacher')
            ->withCount('students')
            ->latest()
            ->paginate(10);
        return view('admin.teachers', compact('teachers'));
    }

    public function students()
    {
        if (!$this->isAdmin()) {
            return redirect()->route('home')->with('error', 'Anda tidak memiliki akses ke halaman tersebut.');
        }

        $students = User::where('role', 'student')
            ->with(['teacher', 'parent'])
            ->latest()
            ->paginate(10);
        return view('admin.students', compact('students'));
    }

    public function testimonials()
    {
        if (!$this->isAdmin()) {
            return redirect()->route('home')->with('error', 'Anda tidak memiliki akses ke halaman tersebut.');
        }

        $testimonials = Testimonial::with('user')
            ->latest()
            ->paginate(10);
        return view('admin.testimonials', compact('testimonials'));
    }

    public function markContactAsRead(Contact $contact)
    {
        if (!$this->isAdmin()) {
            return redirect()->route('home')->with('error', 'Anda tidak memiliki akses ke halaman tersebut.');
        }

        $contact->update(['is_read' => true]);
        return redirect()->back()->with('success', 'Contact marked as read.');
    }
} 