<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Attendance;
use App\Models\Progress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\Program;

class DashboardController extends Controller
{
    /**
     * Display the appropriate dashboard based on user role.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        $user = Auth::user();
        
        if ($user->role === 'teacher') {
            return $this->teacherDashboard();
        } elseif ($user->role === 'admin') {
                return $this->adminDashboard();
        } elseif ($user->role === 'parent') {
                return $this->parentDashboard();
        }
        
        return redirect()->route('home');
    }

    /**
     * Show the dashboard based on user role.
     *
     * @return \Illuminate\View\View
     */
    public function adminDashboard()
    {
        // Get current user
        $user = auth()->user();
        
        // Total Students
        $totalStudents = User::where('role', 'student')->count();
        
        // Total Teachers
        $totalTeachers = User::where('role', 'teacher')->count();
        
        // Monthly Meetings (based on attendance records)
        $monthlyMeetings = Attendance::whereMonth('date', Carbon::now()->month)
            ->whereYear('date', Carbon::now()->year)
            ->count();
        
        // New Registrations (students registered this month)
        $newStudentsThisMonth = User::where('role', 'student')
            ->whereMonth('created_at', Carbon::now()->month)
            ->whereYear('created_at', Carbon::now()->year)
            ->count();
        
        // Recent Teachers (last 5) with student count
        $recentTeachers = User::where('role', 'teacher')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();
        
        // Calculate student count for each teacher
        foreach ($recentTeachers as $teacher) {
            $teacher->students_count = User::where('teacher_id', $teacher->id)
                ->where('role', 'student')
                ->count();
        }
        
        // Recent Students (last 5) with teacher info
        $recentStudents = User::where('role', 'student')
            ->with(['parent', 'teacher'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        
        // Assign teachers to students if not already assigned
        foreach ($recentStudents as $student) {
            if (!$student->teacher_id) {
                // Get a teacher to assign if there are any
                $teacher = User::where('role', 'teacher')->inRandomOrder()->first();
                if ($teacher) {
                    $student->teacher_id = $teacher->id;
                    $student->save();
                    // Reload teacher data
                    $student->load('teacher');
                }
            }
        }
        
        // Program Distribution with actual data
        $programLabels = [];
        $programData = [];
        
        // Get distinct programs from students
        $distinctPrograms = User::where('role', 'student')
            ->whereNotNull('program')
            ->distinct()
            ->pluck('program')
            ->toArray();
        
        foreach ($distinctPrograms as $program) {
            $programLabels[] = $program;
            $programData[] = User::where('role', 'student')
                ->where('program', $program)
                ->count();
        }
        
        // If no programs found, use defaults
        if (empty($programLabels)) {
            $programLabels = ['CaLisTung', 'Matematika', 'Bahasa Inggris', 'Hijaiyah', 'Mata Pelajaran SD'];
            $programData = [0, 0, 0, 0, 0];
        }
        
        // Monthly Statistics (last 12 months)
        $statsLabels = [];
        $activeStudentsData = [];
        $meetingsData = [];
        
        // Mendapatkan statistik per bulan untuk 12 bulan terakhir
        for ($i = 11; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);
            $month = $date->format('M');
            $year = $date->format('Y');
            
            $statsLabels[] = $month;
            
            // Seluruh siswa aktif di bulan tersebut (total siswa terdaftar hingga bulan tersebut)
            $activeStudents = User::where('role', 'student')
                ->whereDate('created_at', '<=', $date->endOfMonth())
                ->count();
            
            $activeStudentsData[] = max(1, $activeStudents); // Minimal 1 siswa aktif
            
            // Total pertemuan di bulan tersebut
            $meetings = Attendance::whereMonth('date', $date->month)
                ->whereYear('date', $date->year)
                ->count();
            
            // Pastikan ada nilai minimal untuk chart
            $meetingsData[] = max(1, $meetings);
        }
        
        return view('dashboard.index', compact(
            'totalStudents',
            'totalTeachers',
            'monthlyMeetings',
            'newStudentsThisMonth',
            'recentTeachers',
            'recentStudents',
            'statsLabels',
            'activeStudentsData',
            'meetingsData',
            'programLabels',
            'programData'
        ));
    }

    /**
     * Show the dashboard based on user role.
     *
     * @return \Illuminate\View\View
     */
    public function teacherDashboard()
    {
        $user = Auth::user();
        
        // Total Students Count
        $totalStudents = User::where('role', 'student')
            ->where('teacher_id', $user->id)
            ->count();
        
        // Total Meetings Count
        $totalMeetings = Attendance::where('teacher_id', $user->id)
            ->count();
        
        // Progress Reports Count
        $progressReportsCount = Progress::where('teacher_id', $user->id)
            ->count();
            
        // New Students This Month
        $newStudentsThisMonth = User::where('role', 'student')
            ->where('teacher_id', $user->id)
            ->whereMonth('created_at', Carbon::now()->month)
            ->whereYear('created_at', Carbon::now()->year)
            ->count();
        
        // Recent Students (last 5)
        $recentStudents = User::where('role', 'student')
            ->where('teacher_id', $user->id)
            ->with('parent')
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        
        // Weekly Statistics (last 4 weeks)
        $statsLabels = [];
        $activeStudentsData = [];
        $meetingsData = [];
        
        for ($i = 3; $i >= 0; $i--) {
            $date = Carbon::now()->subWeeks($i);
            $startDate = $date->copy()->startOfWeek();
            $endDate = $date->copy()->endOfWeek();
            
            // Active students in this week
            $activeStudents = User::where('role', 'student')
                ->where('teacher_id', $user->id)
                ->whereBetween('created_at', [$startDate, $endDate])
                ->count();
            
            // Meetings in this week
            $meetings = Attendance::where('teacher_id', $user->id)
                ->whereBetween('date', [$startDate, $endDate])
                ->count();
            
            $statsLabels[] = 'Week ' . ($i + 1);
            $activeStudentsData[] = $activeStudents;
            $meetingsData[] = $meetings;
        }
        
        return view('dashboard.index', compact(
            'totalStudents',
            'totalMeetings',
            'progressReportsCount',
            'newStudentsThisMonth',
            'recentStudents',
            'statsLabels',
            'activeStudentsData',
            'meetingsData'
        ));
    }

    /**
     * Show the dashboard based on user role.
     *
     * @return \Illuminate\View\View
     */
    public function parentDashboard()
    {
        $user = Auth::user();
        
        // Get children
        $children = User::where('role', 'student')
            ->where('parent_id', $user->id)
            ->get();
            
        $totalChildren = $children->count();
        
        // Get total meetings
        $totalMeetings = Attendance::whereIn('student_id', $children->pluck('id'))
            ->count();
        
        // Get programs
        $programs = Program::all();
        
        // Get latest reports with pagination
        $latestReports = Progress::whereIn('student_id', $children->pluck('id'))
            ->with(['student', 'teacher'])
            ->latest()
            ->paginate(10);
        
        // Get all reports for chart
        $reports = Progress::whereIn('student_id', $children->pluck('id'))
            ->with(['student', 'teacher'])
            ->latest()
            ->get();
        
        return view('dashboard.index', compact(
            'children',
            'totalChildren',
            'totalMeetings',
            'programs',
            'latestReports',
            'reports'
        ));
    }

    /**
     * Show the dashboard based on user role.
     *
     * @return \Illuminate\View\View
     */
    public function studentDashboard()
    {
        // Placeholder for student dashboard
        return view('dashboard.index');
    }
} 
 
 