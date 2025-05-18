<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Attendance;
use App\Models\Progress;
use App\Models\Program;
use Carbon\Carbon;

class ChartDataController extends Controller
{
    /**
     * Ambil data statistik untuk dashboard admin
     */
    public function getAdminStats(Request $request)
    {
        // Dapatkan parameter periode dari request, default ke 'weekly'
        $period = $request->input('period', 'weekly');
        
        // Data berdasarkan periode
        $statsLabels = [];
        $activeStudentsData = [];
        $meetingsData = [];
        
        if ($period === 'weekly') {
            // Data per minggu (4 minggu terakhir)
            for ($i = 3; $i >= 0; $i--) {
                $date = Carbon::now()->subWeeks($i);
                $startDate = $date->copy()->startOfWeek();
                $endDate = $date->copy()->endOfWeek();
                
                $statsLabels[] = $startDate->format('d M') . ' - ' . $endDate->format('d M');
                
                // Siswa aktif dalam minggu tersebut (berdasarkan kehadiran)
                $activeStudentIds = Attendance::whereBetween('date', [
                    $startDate->format('Y-m-d'),
                    $endDate->format('Y-m-d')
                ])->pluck('student_id')->unique()->toArray();
                
                $activeStudentsData[] = count($activeStudentIds);
                
                // Pertemuan dalam minggu tersebut
                $meetingsData[] = Attendance::whereBetween('date', [
                    $startDate->format('Y-m-d'),
                    $endDate->format('Y-m-d')
                ])->count();
            }
        } else if ($period === 'monthly') {
            // Data per bulan (6 bulan terakhir)
            for ($i = 5; $i >= 0; $i--) {
                $date = Carbon::now()->subMonths($i);
                $startDate = $date->copy()->startOfMonth();
                $endDate = $date->copy()->endOfMonth();
                
                $statsLabels[] = $date->format('M Y');
                
                // Siswa aktif dalam bulan tersebut (berdasarkan kehadiran)
                $activeStudentIds = Attendance::whereBetween('date', [
                    $startDate->format('Y-m-d'),
                    $endDate->format('Y-m-d')
                ])->pluck('student_id')->unique()->toArray();
                
                $activeStudentsData[] = count($activeStudentIds);
                
                // Pertemuan dalam bulan tersebut
                $meetingsData[] = Attendance::whereBetween('date', [
                    $startDate->format('Y-m-d'),
                    $endDate->format('Y-m-d')
                ])->count();
            }
        } else if ($period === 'yearly') {
            // Data per tahun (5 tahun terakhir)
            for ($i = 4; $i >= 0; $i--) {
                $date = Carbon::now()->subYears($i);
                $startDate = $date->copy()->startOfYear();
                $endDate = $date->copy()->endOfYear();
                
                $statsLabels[] = $date->format('Y');
                
                // Siswa aktif dalam tahun tersebut (berdasarkan kehadiran)
                $activeStudentIds = Attendance::whereBetween('date', [
                    $startDate->format('Y-m-d'),
                    $endDate->format('Y-m-d')
                ])->pluck('student_id')->unique()->toArray();
                
                $activeStudentsData[] = count($activeStudentIds);
                
                // Pertemuan dalam tahun tersebut
                $meetingsData[] = Attendance::whereBetween('date', [
                    $startDate->format('Y-m-d'),
                    $endDate->format('Y-m-d')
                ])->count();
            }
        } else {
            // Default fallback ke weekly jika periode tidak valid
            for ($i = 3; $i >= 0; $i--) {
                $date = Carbon::now()->subWeeks($i);
                $startDate = $date->copy()->startOfWeek();
                $endDate = $date->copy()->endOfWeek();
                
                $statsLabels[] = $startDate->format('d M') . ' - ' . $endDate->format('d M');
                
                // Siswa aktif dalam minggu tersebut (berdasarkan kehadiran)
                $activeStudentIds = Attendance::whereBetween('date', [
                    $startDate->format('Y-m-d'),
                    $endDate->format('Y-m-d')
                ])->pluck('student_id')->unique()->toArray();
                
                $activeStudentsData[] = count($activeStudentIds);
                
                // Pertemuan dalam minggu tersebut
                $meetingsData[] = Attendance::whereBetween('date', [
                    $startDate->format('Y-m-d'),
                    $endDate->format('Y-m-d')
                ])->count();
            }
        }
        
        // Data distribusi program yang lebih akurat
        $programLabels = [];
        $programData = [];
        
        // Ambil semua program yang terdaftar pada siswa
        $distinctPrograms = User::where('role', 'student')
            ->whereNotNull('program')
            ->distinct()
            ->pluck('program')
            ->toArray();
        
        if (empty($distinctPrograms)) {
            $programLabels = ['CaLisTung', 'Matematika', 'Bahasa Inggris', 'Hijaiyah', 'Mata Pelajaran SD'];
            $programData = [0, 0, 0, 0, 0];
        } else {
            foreach ($distinctPrograms as $program) {
                $programLabels[] = $program;
                
                // Hitung siswa aktif dalam program ini
                $count = User::where('role', 'student')
                    ->where('program', $program)
                    ->count();
                    
                $programData[] = $count;
            }
        }
        
        // Data guru
        $teachers = User::where('role', 'teacher')->get();
        foreach ($teachers as $teacher) {
            // Update jumlah siswa untuk setiap guru
            $teacher->students_count = User::where('teacher_id', $teacher->id)
                ->where('role', 'student')
                ->count();
            $teacher->save();
        }
        
        return response()->json([
            'statsLabels' => $statsLabels,
            'activeStudentsData' => $activeStudentsData,
            'meetingsData' => $meetingsData,
            'programLabels' => $programLabels,
            'programData' => $programData
        ]);
    }
    
    /**
     * Ambil data statistik untuk dashboard parent
     */
    public function getParentStats(Request $request)
    {
        $parent = auth()->user();
        $children = User::where('parent_id', $parent->id)
            ->where('role', 'student')
            ->pluck('id')
            ->toArray();
        
        // Data progres 6 bulan terakhir
        $progressLabels = [];
        $progressData = [];
        
        for ($i = 5; $i >= 0; $i--) {
            $month = Carbon::now()->subMonths($i);
            $progressLabels[] = $month->format('M');
            
            // Nilai rata-rata bulanan
            $avgScore = Progress::whereIn('student_id', $children)
                ->whereMonth('date', $month->month)
                ->whereYear('date', $month->year)
                ->avg('score') ?? 0;
            
            $progressData[] = round($avgScore, 1);
        }
        
        return response()->json([
            'progressLabels' => $progressLabels,
            'progressData' => $progressData
        ]);
    }

    public function getAdminDashboardData(Request $request)
    {
        // Get monthly statistics for the last 12 months
        $statsLabels = [];
        $totalStudentsData = [];
        $monthlyMeetingsData = [];
        
        for ($i = 11; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);
            $month = $date->format('M');
            $year = $date->format('Y');
            
            $statsLabels[] = $month;
            
            // Total students up to this month
            $totalStudents = User::where('role', 'student')
                ->whereDate('created_at', '<=', $date->endOfMonth())
                ->count();
            
            $totalStudentsData[] = $totalStudents;
            
            // Monthly meetings
            $meetings = Attendance::whereMonth('date', $date->month)
                ->whereYear('date', $date->year)
                ->count();
            
            $monthlyMeetingsData[] = $meetings;
        }
        
        return response()->json([
            'statsLabels' => $statsLabels,
            'totalStudentsData' => $totalStudentsData,
            'monthlyMeetingsData' => $monthlyMeetingsData
        ]);
    }

    public function getTeacherDashboardData(Request $request)
    {
        $teacher = auth()->user();
        
        // Get monthly statistics for the last 12 months
        $statsLabels = [];
        $totalStudentsData = [];
        $monthlyMeetingsData = [];
        
        for ($i = 11; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);
            $month = $date->format('M');
            $year = $date->format('Y');
            
            $statsLabels[] = $month;
            
            // Total students assigned to this teacher up to this month
            $totalStudents = User::where('role', 'student')
                ->where('teacher_id', $teacher->id)
                ->whereDate('created_at', '<=', $date->endOfMonth())
                ->count();
            
            $totalStudentsData[] = $totalStudents;
            
            // Monthly meetings for this teacher
            $meetings = Attendance::where('teacher_id', $teacher->id)
                ->whereMonth('date', $date->month)
                ->whereYear('date', $date->year)
                ->count();
            
            $monthlyMeetingsData[] = $meetings;
        }
        
        return response()->json([
            'statsLabels' => $statsLabels,
            'totalStudentsData' => $totalStudentsData,
            'monthlyMeetingsData' => $monthlyMeetingsData
        ]);
    }
}
