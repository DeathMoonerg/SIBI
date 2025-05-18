<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class StudentsController extends Controller
{
    /**
     * Display a listing of students.
     */
    public function index(Request $request)
    {
        $query = User::where('role', 'student');
        
        // Apply search filter if provided
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                  ->orWhere('grade', 'like', '%' . $search . '%')
                  ->orWhere('program', 'like', '%' . $search . '%')
                  ->orWhereHas('parent', function($q) use ($search) {
                      $q->where('name', 'like', '%' . $search . '%')
                        ->orWhere('email', 'like', '%' . $search . '%');
                  })
                  ->orWhereHas('teacher', function($q) use ($search) {
                      $q->where('name', 'like', '%' . $search . '%');
                  });
            });
        }
        
        // Apply class/grade filter if provided
        if ($request->has('grade') && !empty($request->grade)) {
            $query->where('grade', $request->grade);
        }
        
        // Apply status filter if provided (simplified - only checking if active)
        if ($request->has('status') && !empty($request->status)) {
            // In this example, all users are active by default
            // You may need to adjust this based on your actual status implementation
        }
        
        // Eager load relationships to avoid N+1 query issues
        $students = $query->with(['parent', 'teacher'])
                          ->latest()
                          ->paginate(10);
        
        return view('students.index', compact('students'));
    }

    /**
     * Show the form for creating a new student.
     */
    public function create()
    {
        $parents = User::where('role', 'parent')->get();
        $teachers = User::where('role', 'teacher')->get();
        $programs = [
            'CaLisTung' => 'CaLisTung',
            'Matematika' => 'Matematika',
            'Bahasa Inggris' => 'Bahasa Inggris',
            'Hijaiyah' => 'Hijaiyah',
            'Mata Pelajaran SD' => 'Mata Pelajaran SD',
            'IPA SD' => 'IPA SD',
            'Bahasa Indonesia SD' => 'Bahasa Indonesia SD'
        ];
        return view('students.create', compact('parents', 'teachers', 'programs'));
    }

    /**
     * Store a newly created student in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'grade' => 'required|string',
            'parent_id' => 'required|exists:users,id',
            'teacher_id' => 'required|exists:users,id',
            'address' => 'required|string',
            'program' => 'required|string|max:255',
        ]);

        try {
            // Get parent info for generating student credentials
            $parent = User::findOrFail($validated['parent_id']);
            
            // Generate a unique student email based on parent's email and student name
            $studentName = strtolower(str_replace(' ', '', $validated['name']));
            $parentEmail = $parent->email;
            $emailParts = explode('@', $parentEmail);
            $studentEmail = $studentName . '.' . $emailParts[0] . '@student.bimbelalfarizqi.com';
            
            // Generate a hashed password
            $password = Hash::make(Str::random(10));
            
            // Create student
            $student = User::create([
                'name' => $validated['name'],
                'email' => $studentEmail,
                'password' => $password,
                'role' => 'student',
                'parent_id' => $validated['parent_id'],
                'teacher_id' => $validated['teacher_id'],
                'grade' => $validated['grade'],
                'address' => $validated['address'],
                'program' => $validated['program'],
            ]);

            Log::info('Student created successfully', [
                'student_id' => $student->id,
                'name' => $student->name,
                'email' => $student->email,
                'program' => $student->program
            ]);

            return redirect()->route('students.index')
                ->with('success', "Siswa berhasil ditambahkan! Gunakan akun orang tua untuk akses.");

        } catch (\Exception $e) {
            Log::error('Error creating student', [
                'error' => $e->getMessage(),
                'validated_data' => $validated
            ]);

            return back()
                ->withInput()
                ->withErrors(['error' => 'Terjadi kesalahan saat menambahkan siswa. ' . $e->getMessage()]);
        }
    }

    /**
     * Display the specified student.
     */
    public function show(User $student)
    {
        if ($student->role !== 'student') {
            return redirect()->route('students.index')
                ->with('error', 'Data yang diminta bukan data siswa.');
        }

        return view('students.show', compact('student'));
    }

    /**
     * Show the form for editing the specified student.
     */
    public function edit(User $student)
    {
        if ($student->role !== 'student') {
            return redirect()->route('students.index')
                ->with('error', 'Data yang diminta bukan data siswa.');
        }

        $parents = User::where('role', 'parent')->get();
        $teachers = User::where('role', 'teacher')->get();
        $programs = [
            'CaLisTung' => 'CaLisTung',
            'Matematika' => 'Matematika',
            'Bahasa Inggris' => 'Bahasa Inggris',
            'Hijaiyah' => 'Hijaiyah',
            'Mata Pelajaran SD' => 'Mata Pelajaran SD',
            'IPA SD' => 'IPA SD',
            'Bahasa Indonesia SD' => 'Bahasa Indonesia SD'
        ];

        return view('students.edit', compact('student', 'parents', 'teachers', 'programs'));
    }

    /**
     * Update the specified student in storage.
     */
    public function update(Request $request, User $student)
    {
        if ($student->role !== 'student') {
            return redirect()->route('students.index')
                ->with('error', 'Data yang diminta bukan data siswa.');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'grade' => 'required|string',
            'parent_id' => 'required|exists:users,id',
            'teacher_id' => 'required|exists:users,id',
            'address' => 'required|string',
            'program' => 'required|string|max:255',
        ]);

        try {
            $student->update($validated);

            Log::info('Student updated successfully', [
                'student_id' => $student->id,
                'name' => $student->name,
                'program' => $student->program
            ]);

            return redirect()->route('students.index')
                ->with('success', 'Data siswa berhasil diperbarui!');

        } catch (\Exception $e) {
            Log::error('Error updating student', [
                'error' => $e->getMessage(),
                'student_id' => $student->id,
                'validated_data' => $validated
            ]);

            return back()
                ->withInput()
                ->withErrors(['error' => 'Terjadi kesalahan saat memperbarui data siswa. ' . $e->getMessage()]);
        }
    }

    /**
     * Remove the specified student from storage.
     */
    public function destroy(User $student)
    {
        if ($student->role !== 'student') {
            return redirect()->route('students.index')
                ->with('error', 'Data yang diminta bukan data siswa.');
        }

        try {
            $student->delete();
            return redirect()->route('students.index')
                ->with('success', 'Data siswa berhasil dihapus!');
        } catch (\Exception $e) {
            return redirect()->route('students.index')
                ->with('error', 'Terjadi kesalahan saat menghapus data siswa.');
        }
    }
} 
 
 