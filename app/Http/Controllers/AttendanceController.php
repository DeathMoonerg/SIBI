<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Attendance;
use App\Models\Progress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use PDF;

class AttendanceController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $today = Carbon::now()->format('Y-m-d');
        
        // Initialize statistics
        $stats = [
            'present' => 0,
            'absent' => 0,
            'late' => 0
        ];
        
        $attendanceRecords = [];
        $chartData = [
            'labels' => [],
            'data' => []
        ];
        
        $stats = [
            'total_students' => 0,
            'total_meetings' => 0,
            'total_reports' => 0
        ];

        if ($user->role === 'teacher') {
            // Get all students assigned to this teacher
            $students = User::where('role', 'student')
                ->where('teacher_id', $user->id)
                ->get();

            // Get attendance records with pagination
            $attendances = Attendance::with(['student', 'teacher'])
                ->where('teacher_id', $user->id)
                ->latest()
                ->paginate(10);

            // Calculate statistics
            $stats['total_students'] = $students->count();
            $stats['total_meetings'] = $attendances->total();
            $stats['total_reports'] = Progress::where('teacher_id', $user->id)->count();
            
            // Get attendance records for chart
            $attendanceRecords = Attendance::where('teacher_id', $user->id)
                ->select('status', DB::raw('count(*) as total'))
                ->groupBy('status')
                ->get();
            
            // Prepare chart data
            foreach ($attendanceRecords as $record) {
                $chartData['labels'][] = ucfirst($record->status);
                $chartData['data'][] = $record->total;
            }
            
            return view('dashboard.attendance.index', compact('attendances', 'students', 'stats', 'chartData'));
        } elseif ($user->role === 'parent') {
            // Get children
            $children = User::where('role', 'student')
                ->where('parent_id', $user->id)
                ->get();
            
            // Get attendance records with pagination
            $attendances = Attendance::with(['student', 'teacher'])
                ->whereIn('student_id', $children->pluck('id'))
                ->latest()
                ->paginate(10);
            
            // Calculate statistics
            $stats['total_students'] = $children->count();
            $stats['total_meetings'] = $attendances->total();
            $stats['total_reports'] = Progress::whereIn('student_id', $children->pluck('id'))->count();
            
            // Get attendance records for chart
            $attendanceRecords = Attendance::whereIn('student_id', $children->pluck('id'))
                ->select('status', DB::raw('count(*) as total'))
                ->groupBy('status')
                ->get();
            
            // Prepare chart data
            foreach ($attendanceRecords as $record) {
                $chartData['labels'][] = ucfirst($record->status);
                $chartData['data'][] = $record->total;
            }
            
            return view('dashboard.attendance.index', compact('attendances', 'children', 'stats', 'chartData'));
        } elseif ($user->role === 'admin') {
            // Get all students
            $students = User::where('role', 'student')->get();
            
            // Get all attendance records with pagination
            $attendances = Attendance::with(['student', 'teacher'])
                ->latest()
                ->paginate(10);
            
            // Calculate statistics
            $stats['total_students'] = $students->count();
            $stats['total_meetings'] = $attendances->total();
            $stats['total_reports'] = Progress::count();
                
            // Get attendance records for chart
            $attendanceRecords = Attendance::select('status', DB::raw('count(*) as total'))
                ->groupBy('status')
                        ->get();
                    
            // Prepare chart data
            foreach ($attendanceRecords as $record) {
                $chartData['labels'][] = ucfirst($record->status);
                $chartData['data'][] = $record->total;
                        }
            
            return view('dashboard.attendance.index', compact('attendances', 'students', 'stats', 'chartData'));
        }
        
        return redirect()->route('dashboard')->with('error', 'Unauthorized access.');
    }

    public function create(Request $request)
    {
        $user = Auth::user();
        $students = [];
        $selectedStudent = null;
        $recentAttendances = [];

        if (!in_array($user->role, ['teacher', 'admin'])) {
            abort(403, 'Unauthorized');
        }

        if ($user->role === 'teacher') {
            $students = User::where('role', 'student')
                ->where('teacher_id', $user->id)
                ->get();
        } elseif ($user->role === 'admin') {
            // Admin can see all students
            $students = User::where('role', 'student')
                ->with('teacher') // Add teacher relation for display
                ->get();
        }

        // If student_id is provided, get the student and recent attendances
        if ($request->has('student_id')) {
            $studentId = $request->student_id;
            
            // For teacher, ensure the student belongs to them
            if ($user->role === 'teacher') {
                $selectedStudent = User::where('id', $studentId)
                    ->where('teacher_id', $user->id)
                    ->first();
            } else {
                // For admin, any student is fine
                $selectedStudent = User::where('id', $studentId)
                    ->where('role', 'student')
                    ->first();
            }
            
            if ($selectedStudent) {
                $recentAttendances = Attendance::where('student_id', $selectedStudent->id)
                    ->latest('date')
                    ->take(5)
                    ->get();
            }
        }

        return view('dashboard.attendance.create', compact(
            'students', 
            'selectedStudent', 
            'recentAttendances'
        ));
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        
        if (!in_array($user->role, ['teacher', 'admin'])) {
            abort(403, 'Unauthorized');
        }
        
        $request->validate([
            'student_id' => 'required|exists:users,id',
            'date' => 'required|date',
            'status' => 'required|in:present,absent,late',
            'notes' => 'nullable|string|max:255',
            'start_time' => 'nullable|string',
            'end_time' => 'nullable|string',
            'material' => 'nullable|string',
        ]);

        // For admin users, we need to get the teacher_id of the student
        if ($user->role === 'admin') {
            $student = User::findOrFail($request->student_id);
            $teacherId = $student->teacher_id ?? $user->id; // Use admin ID as fallback
        } else {
            $teacherId = $user->id;
        }

        Attendance::create([
            'student_id' => $request->student_id,
            'teacher_id' => $teacherId,
            'date' => $request->date,
            'status' => $request->status,
            'notes' => $request->notes,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'material' => $request->material,
        ]);

        return redirect()->route('attendance.index')
            ->with('success', 'Attendance record created successfully.');
    }

    public function show(Attendance $attendance)
    {
        $user = Auth::user();
        
        // Debug information
        if ($user->role === 'teacher' && $attendance->teacher_id !== $user->id) {
            abort(403, 'Anda tidak memiliki izin untuk melihat presensi ini karena Anda bukan guru yang mengajar siswa ini.');
        }
        
        if ($user->role === 'parent') {
            $studentIds = $user->children->pluck('id');
            if (!$studentIds->contains($attendance->student_id)) {
                abort(403, 'Anda tidak memiliki izin untuk melihat presensi ini karena siswa ini bukan anak Anda.');
            }
        }
        
        return view('dashboard.attendance.show', compact('attendance'));
    }

    public function edit(Attendance $attendance)
    {
        $user = Auth::user();
        
        // Debug information
        if ($user->role === 'teacher' && $attendance->teacher_id !== $user->id) {
            abort(403, 'Anda tidak memiliki izin untuk mengedit presensi ini karena Anda bukan guru yang mengajar siswa ini.');
        }
        
        if ($user->role === 'parent') {
            abort(403, 'Orang tua tidak dapat mengedit presensi.');
        }
        
        if ($user->role !== 'admin' && $user->role !== 'teacher') {
            abort(403, 'Hanya admin dan guru yang dapat mengedit presensi.');
        }
        
        $students = [];

        if ($user->role === 'teacher') {
            $students = User::where('role', 'student')
                ->where('teacher_id', $user->id)
                ->get();
        } elseif ($user->role === 'admin') {
            $students = User::where('role', 'student')->get();
        }

        return view('dashboard.attendance.edit', compact('attendance', 'students'));
    }

    public function update(Request $request, Attendance $attendance)
    {
        $user = Auth::user();
        
        // Permission check
        if ($user->role === 'teacher' && $attendance->teacher_id !== $user->id) {
            abort(403, 'Anda tidak memiliki izin untuk memperbarui presensi ini karena Anda bukan guru yang mengajar siswa ini.');
        }
        
        if ($user->role !== 'admin' && $user->role !== 'teacher') {
            abort(403, 'Hanya admin dan guru yang dapat memperbarui presensi.');
        }

        $request->validate([
            'student_id' => 'required|exists:users,id',
            'date' => 'required|date',
            'status' => 'required|in:present,absent,late',
            'notes' => 'nullable|string|max:255',
            'start_time' => 'nullable|string',
            'end_time' => 'nullable|string',
            'material' => 'nullable|string',
        ]);

        $attendance->update([
            'student_id' => $request->student_id,
            'date' => $request->date,
            'status' => $request->status,
            'notes' => $request->notes,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'material' => $request->material,
        ]);

        return redirect()->route('attendance.index')
            ->with('success', 'Attendance record updated successfully.');
    }

    public function destroy(Attendance $attendance)
    {
        $user = Auth::user();
        
        // Debug information
        if ($user->role === 'teacher' && $attendance->teacher_id !== $user->id) {
            abort(403, 'Anda tidak memiliki izin untuk menghapus presensi ini karena Anda bukan guru yang mengajar siswa ini.');
        }
        
        if ($user->role !== 'admin' && $user->role !== 'teacher') {
            abort(403, 'Hanya admin dan guru yang dapat menghapus presensi.');
        }
        
        $attendance->delete();

        return redirect()->route('attendance.index')
            ->with('success', 'Attendance record deleted successfully.');
    }

    public function parentIndex()
    {
        $user = Auth::user();
        
        if ($user->role !== 'parent') {
            abort(403, 'Unauthorized access.');
        }
        
        // Get children
        $children = User::where('role', 'student')
            ->where('parent_id', $user->id)
            ->get();
        
        // Get attendance records for all children
        $attendances = Attendance::with(['student', 'teacher'])
            ->whereIn('student_id', $children->pluck('id'))
            ->latest('date')
            ->paginate(10);
        
        // Calculate statistics
        $stats = [
            'total_meetings' => $attendances->total(),
            'present_count' => $attendances->where('status', 'present')->count(),
            'absent_count' => $attendances->where('status', 'absent')->count(),
            'late_count' => $attendances->where('status', 'late')->count()
        ];
        
        // Prepare chart data
        $chartData = [
            'labels' => ['Hadir', 'Tidak Hadir', 'Terlambat'],
            'data' => [
                $stats['present_count'],
                $stats['absent_count'],
                $stats['late_count']
            ]
        ];
        
        return view('dashboard.attendance.parent-index', compact('attendances', 'children', 'stats', 'chartData'));
    }
    
    public function parentShow(Attendance $attendance)
    {
        $user = Auth::user();
        
        if ($user->role !== 'parent') {
            abort(403, 'Unauthorized access.');
        }
        
        // Check if the attendance record belongs to one of the parent's children
        $children = User::where('role', 'student')
            ->where('parent_id', $user->id)
            ->pluck('id');
            
        if (!$children->contains($attendance->student_id)) {
            abort(403, 'Anda tidak memiliki izin untuk melihat presensi ini.');
        }
        
        return view('dashboard.attendance.parent-show', compact('attendance'));
    }
} 
 
 