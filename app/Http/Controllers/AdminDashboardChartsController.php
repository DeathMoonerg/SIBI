<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Attendance;
use App\Models\Progress;
use App\Models\Schedule;
use Carbon\Carbon;

class AdminDashboardChartsController extends Controller
{
    /**
     * Calculate and return statistics for the admin dashboard
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function calculateStatistics(Request $request)
    {
        // Get period from request (weekly, monthly, yearly), default to weekly
        $period = $request->input('period', 'weekly');
        
        $statistics = $this->getPeriodStatistics($period);
        $programDistribution = $this->getProgramDistribution();
        $teachersData = $this->getTeachersData();
        
        return response()->json([
            'statsLabels' => $statistics['labels'],
            'activeStudentsData' => $statistics['activeStudents'],
            'meetingsData' => $statistics['meetings'],
            'programLabels' => $programDistribution['labels'],
            'programData' => $programDistribution['data'],
            'teachersData' => $teachersData
        ]);
    }
    
    /**
     * Get statistics based on specified period
     * 
     * @param string $period
     * @return array
     */
    private function getPeriodStatistics($period)
    {
        $statsLabels = [];
        $activeStudentsData = [];
        $meetingsData = [];
        
        switch ($period) {
            case 'weekly':
                // Data for the last 4 weeks
                for ($i = 3; $i >= 0; $i--) {
                    $date = Carbon::now()->subWeeks($i);
                    $startDate = $date->copy()->startOfWeek();
                    $endDate = $date->copy()->endOfWeek();
                    
                    $statsLabels[] = $startDate->format('d M') . ' - ' . $endDate->format('d M');
                    
                    // Active students in that week (based on attendance)
                    $activeStudentIds = Attendance::whereBetween('date', [
                        $startDate->format('Y-m-d'),
                        $endDate->format('Y-m-d')
                    ])->pluck('student_id')->unique()->toArray();
                    
                    $activeStudentsData[] = count($activeStudentIds);
                    
                    // Meetings in that week
                    $meetingsCount = Attendance::whereBetween('date', [
                        $startDate->format('Y-m-d'),
                        $endDate->format('Y-m-d')
                    ])->count();
                    
                    // If no attendance data, use schedule data as fallback
                    if ($meetingsCount == 0) {
                        $meetingsCount = Schedule::whereBetween('date', [
                            $startDate->format('Y-m-d'),
                            $endDate->format('Y-m-d')
                        ])->count();
                    }
                    
                    $meetingsData[] = max(1, $meetingsCount); // Ensure minimum value of 1 for chart display
                }
                break;
                
            case 'monthly':
                // Data for the last 6 months
                for ($i = 5; $i >= 0; $i--) {
                    $date = Carbon::now()->subMonths($i);
                    $startDate = $date->copy()->startOfMonth();
                    $endDate = $date->copy()->endOfMonth();
                    
                    $statsLabels[] = $date->format('M Y');
                    
                    // Active students in that month (based on attendance)
                    $activeStudentIds = Attendance::whereBetween('date', [
                        $startDate->format('Y-m-d'),
                        $endDate->format('Y-m-d')
                    ])->pluck('student_id')->unique()->toArray();
                    
                    $activeStudentsData[] = count($activeStudentIds);
                    
                    // Meetings in that month
                    $meetingsCount = Attendance::whereBetween('date', [
                        $startDate->format('Y-m-d'),
                        $endDate->format('Y-m-d')
                    ])->count();
                    
                    // If no attendance data, use schedule data as fallback
                    if ($meetingsCount == 0) {
                        $meetingsCount = Schedule::whereBetween('date', [
                            $startDate->format('Y-m-d'),
                            $endDate->format('Y-m-d')
                        ])->count();
                    }
                    
                    $meetingsData[] = max(1, $meetingsCount);
                }
                break;
                
            case 'yearly':
                // Data for the last 5 years
                for ($i = 4; $i >= 0; $i--) {
                    $date = Carbon::now()->subYears($i);
                    $startDate = $date->copy()->startOfYear();
                    $endDate = $date->copy()->endOfYear();
                    
                    $statsLabels[] = $date->format('Y');
                    
                    // Active students in that year (based on attendance)
                    $activeStudentIds = Attendance::whereBetween('date', [
                        $startDate->format('Y-m-d'),
                        $endDate->format('Y-m-d')
                    ])->pluck('student_id')->unique()->toArray();
                    
                    $activeStudentsData[] = count($activeStudentIds);
                    
                    // Meetings in that year
                    $meetingsCount = Attendance::whereBetween('date', [
                        $startDate->format('Y-m-d'),
                        $endDate->format('Y-m-d')
                    ])->count();
                    
                    // If no attendance data, use schedule data as fallback
                    if ($meetingsCount == 0) {
                        $meetingsCount = Schedule::whereBetween('date', [
                            $startDate->format('Y-m-d'),
                            $endDate->format('Y-m-d')
                        ])->count();
                    }
                    
                    $meetingsData[] = max(1, $meetingsCount);
                }
                break;
                
            default:
                // Default to weekly if period is not valid
                return $this->getPeriodStatistics('weekly');
        }
        
        return [
            'labels' => $statsLabels,
            'activeStudents' => $activeStudentsData,
            'meetings' => $meetingsData
        ];
    }
    
    /**
     * Get program distribution data
     * 
     * @return array
     */
    private function getProgramDistribution()
    {
        $programLabels = [];
        $programData = [];
        
        // Get all programs that are assigned to students
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
                
                // Count active students in this program
                $count = User::where('role', 'student')
                    ->where('program', $program)
                    ->count();
                
                $programData[] = $count;
            }
        }
        
        return [
            'labels' => $programLabels,
            'data' => $programData
        ];
    }
    
    /**
     * Get teachers data with student count
     * 
     * @return array
     */
    private function getTeachersData()
    {
        $teachers = User::where('role', 'teacher')->get();
        $teachersData = [];
        
        foreach ($teachers as $teacher) {
            // Count students assigned to this teacher
            $studentsCount = User::where('teacher_id', $teacher->id)
                ->where('role', 'student')
                ->count();
                
            $teachersData[] = [
                'id' => $teacher->id,
                'name' => $teacher->name,
                'email' => $teacher->email,
                'students_count' => $studentsCount,
                'created_at' => $teacher->created_at->format('Y-m-d')
            ];
        }
        
        return $teachersData;
    }
} 