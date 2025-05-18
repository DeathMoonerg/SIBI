<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class TeachersController extends Controller
{
    /**
     * Display a listing of teachers.
     */
    public function index()
    {
        $teachers = User::where('role', 'teacher')->latest()->paginate(10);
        
        return view('teachers.index', compact('teachers'));
    }

    /**
     * Show the form for creating a new teacher.
     */
    public function create()
    {
        return view('teachers.create');
    }

    /**
     * Store a newly created teacher in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'phone' => 'required|string|max:15',
            'address' => 'required|string',
        ]);

        $teacher = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => 'teacher',
            'phone' => $validated['phone'],
            'address' => $validated['address'],
        ]);

        return redirect()->route('teachers.index')
            ->with('success', 'Guru berhasil ditambahkan!');
    }

    /**
     * Display the specified teacher.
     */
    public function show(User $teacher)
    {
        // Ambil semua siswa yang diajar guru ini
        $students = $teacher->students;
        // Hitung total laporan (progress) dan total pertemuan (attendance) dari semua siswa
        $totalLaporan = \App\Models\Progress::whereIn('student_id', $students->pluck('id'))->count();
        $totalPertemuan = \App\Models\Attendance::whereIn('student_id', $students->pluck('id'))->count();
        return view('teachers.show', compact('teacher', 'totalLaporan', 'totalPertemuan'));
    }

    /**
     * Show the form for editing the specified teacher.
     */
    public function edit(User $teacher)
    {
        return view('teachers.edit', compact('teacher'));
    }

    /**
     * Update the specified teacher in storage.
     */
    public function update(Request $request, User $teacher)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $teacher->id,
            'phone' => 'required|string|max:15',
            'address' => 'required|string',
        ]);

        // Only update password if provided
        if ($request->filled('password')) {
            $request->validate([
                'password' => 'string|min:6|confirmed',
            ]);
            
            $teacher->password = Hash::make($request->password);
        }

        $teacher->name = $validated['name'];
        $teacher->email = $validated['email'];
        $teacher->phone = $validated['phone'];
        $teacher->address = $validated['address'];
        $teacher->save();

        return redirect()->route('teachers.index')
            ->with('success', 'Informasi guru berhasil diperbarui!');
    }

    /**
     * Remove the specified teacher from storage.
     */
    public function destroy(User $teacher)
    {
        $teacher->delete();

        return redirect()->route('teachers.index')
            ->with('success', 'Guru berhasil dihapus!');
    }
} 
 
 