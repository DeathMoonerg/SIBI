<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Progress;
use App\Models\User;
use App\Models\Attendance;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProgressController extends Controller
{
    use AuthorizesRequests;

    /**
     * Display a listing of the progress reports.
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        $students = collect();
        $children = collect();
        $student = null;
        $progressRecords = collect();
        $totalMeetings = 0;
        $stats = [
            'total_students' => 0,
            'total_meetings' => 0,
            'total_reports' => 0
        ];

        if ($user->role === 'teacher') {
            // Get all students assigned to this teacher
            $students = User::where('role', 'student')
                ->where('teacher_id', $user->id)
                ->withCount(['attendances as meetings_count' => function($query) {
                    $query->where('status', 'present');
                }])
                ->with('lastProgress')
                ->paginate(10);

            // If a specific student is selected
            if ($request->has('student_id')) {
                $student = $students->firstWhere('id', $request->student_id);
                if ($student) {
                    $progressRecords = Progress::where('student_id', $student->id)
                        ->orderBy('date', 'desc')
                        ->get();
                    $totalMeetings = $student->attendances()
                        ->where('status', 'present')
                        ->count();
                }
            }

            // Calculate statistics for teacher
            $stats['total_students'] = $students->total();
            $stats['total_meetings'] = Attendance::where('teacher_id', $user->id)->where('status', 'present')->count();
            if ($student) {
                $stats['total_reports'] = $progressRecords->count();
            } else {
            $stats['total_reports'] = Progress::where('teacher_id', $user->id)->count();
            }
        } elseif ($user->role === 'parent') {
            // Get all children of this parent
            $children = User::where('role', 'student')
                ->where('parent_id', $user->id)
                ->withCount(['attendances as meetings_count' => function($query) {
                    $query->where('status', 'present');
                }])
                ->with(['progresses' => function($query) {
                    $query->where('is_verified', true)
                          ->where('verification_status', 'approved')
                          ->latest('date')
                          ->take(1);
                }])
                ->get();

            // If a specific child is selected
            if ($request->has('student_id')) {
                $student = $children->firstWhere('id', $request->student_id);
                if ($student) {
                    $progressRecords = Progress::where('student_id', $student->id)
                        ->where('is_verified', true)
                        ->where('verification_status', 'approved')
                        ->orderBy('date', 'desc')
                        ->get();
                    $totalMeetings = $student->attendances()
                        ->where('status', 'present')
                        ->count();
                }
            }

            // Calculate statistics for parent
            $stats['total_students'] = $children->count();
            $stats['total_meetings'] = $children->sum('meetings_count');
            if ($student) {
                $stats['total_reports'] = $progressRecords->count();
            } else {
                $stats['total_reports'] = Progress::whereHas('student', function ($query) use ($user) {
                    $query->where('parent_id', $user->id);
                })
                ->where('is_verified', true)
                ->where('verification_status', 'approved')
                ->count();
            }
        } elseif ($user->role === 'admin') {
            // For admin, get all students
            $students = User::where('role', 'student')
                ->with(['teacher', 'parent', 'lastProgress'])
                ->withCount(['attendances as meetings_count' => function($query) {
                    $query->where('status', 'present');
                }])
                ->paginate(10);

            // Admin doesn't have a specific "own" view, admin can see all students
            if ($request->has('student_id')) {
                $student = User::where('id', $request->student_id)
                    ->where('role', 'student')
                    ->first();
                
                if ($student) {
                    $progressRecords = Progress::where('student_id', $student->id)
                        ->orderBy('date', 'desc')
                        ->get();
                    $totalMeetings = $student->attendances()
                        ->where('status', 'present')
                        ->count();
                }
            }

            // Calculate statistics for admin
            $stats['total_students'] = User::where('role', 'student')->count();
            $stats['total_meetings'] = $students->sum('meetings_count');
            if ($student) {
                $stats['total_reports'] = $progressRecords->count();
            } else {
            $stats['total_reports'] = Progress::count();
            }
        }

        // Filter by month and year if provided
        if ($student) {
            if ($request->filled('month') || $request->filled('year')) {
                $progressRecords = Progress::where('student_id', $student->id);
                
                if ($request->filled('month')) {
                    $progressRecords->whereMonth('date', $request->month);
                }
                
                if ($request->filled('year')) {
                    $progressRecords->whereYear('date', $request->year);
                }
                
                $progressRecords = $progressRecords->orderBy('date', 'desc')->get();
                // Update total reports after filtering
                $stats['total_reports'] = $progressRecords->count();
            } else {
                $progressRecords = Progress::where('student_id', $student->id)
                    ->orderBy('date', 'desc')
                    ->get();
                // Update total reports
                $stats['total_reports'] = $progressRecords->count();
            }
        } else {
            $progressRecords = collect();
        }

        // Update chart data based on filtered records
        $chartData = null;
        if ($student && $progressRecords->count() > 0) {
            $chartData = [
                'labels' => $progressRecords->pluck('date')->map(function($date) {
                    return $date->format('d M Y');
                })->toArray(),
                'progressData' => $progressRecords->map(function($record) {
                    return [
                        'y' => $record->score,
                        'material' => $record->material_covered,
                        'achievements' => $record->achievements,
                        'challenges' => $record->challenges,
                        'notes' => $record->notes,
                        'teacher' => $record->teacher->name
                    ];
                })->toArray(),
                'averageScore' => round($progressRecords->avg('score'), 1),
                'highestScore' => $progressRecords->max('score'),
                'lowestScore' => $progressRecords->min('score'),
                'totalMeetings' => $totalMeetings
            ];
        }

        return view('dashboard.progress.index', compact(
            'students',
            'children',
            'student',
            'progressRecords',
            'totalMeetings',
            'stats',
            'chartData'
        ));
    }

    /**
     * Show the form for creating a new progress report.
     */
    public function create(Request $request)
    {
        $user = Auth::user();
        if (!in_array($user->role, ['teacher', 'admin'])) {
            abort(403);
        }

        // For teachers, only show their students
        if ($user->role === 'teacher') {
            $students = User::where('role', 'student')
                ->where('teacher_id', $user->id)
                ->get();
        } 
        // For admins, show all students
        else {
            $students = User::where('role', 'student')->get();
        }

        // Pre-select student if student_id is provided
        $selectedStudentId = $request->input('student_id');
        
        return view('dashboard.progress.create', compact('students', 'selectedStudentId'));
    }

    /**
     * Store a newly created progress report in storage.
     */
    public function store(Request $request)
    {
        $user = Auth::user();
        if (!in_array($user->role, ['teacher', 'admin'])) {
            abort(403);
        }

        $validated = $request->validate([
            'student_id' => 'required|exists:users,id',
            'date' => 'required|date',
            'start_time' => 'required',
            'end_time' => 'required',
            'material_covered' => 'required|string',
            'achievements' => 'required|string',
            'challenges' => 'required|string',
            'score' => 'required|integer|min:0|max:100',
            'overall_score' => 'nullable|integer|min:0|max:100',
            'notes' => 'nullable|string',
        ]);

        // If created by admin, get the teacher_id from the student
        if ($user->role === 'admin') {
            $student = User::findOrFail($validated['student_id']);
            $validated['teacher_id'] = $student->teacher_id ?? $user->id;
        } else {
            $validated['teacher_id'] = $user->id;
        }

        // Set overall_score to score if not provided
        if (!isset($validated['overall_score'])) {
            $validated['overall_score'] = $validated['score'];
        }

        Progress::create($validated);

        return redirect()->route('progress.index')
            ->with('success', 'Progress report created successfully.');
    }

    /**
     * Display the specified progress report.
     */
    public function show(Progress $progress)
    {
        $user = Auth::user();
        
        // Check permissions:
        // - Admin can view all progress reports
        // - Teacher can only view progress reports they created
        // - Parent can only view progress reports of their children
        if ($user->role === 'parent' && !$this->isParentOfStudent($user->id, $progress->student_id)) {
            abort(403);
        } elseif ($user->role === 'teacher' && $user->id !== $progress->teacher_id) {
            abort(403);
        }

        return view('dashboard.progress.show', compact('progress'));
    }

    /**
     * Show the form for editing the specified progress report.
     */
    public function edit(Progress $progress)
    {
        $user = Auth::user();
        // Allow access only to the teacher who created the report or an admin
        if ($user->role !== 'admin' && $user->id !== $progress->teacher_id) {
            abort(403);
        }

        // For teachers, only show their students
        if ($user->role === 'teacher') {
            $students = User::where('role', 'student')
                ->where('teacher_id', $user->id)
                ->get();
        } 
        // For admins, show all students
        else {
            $students = User::where('role', 'student')->get();
        }

        return view('dashboard.progress.edit', compact('progress', 'students'));
    }

    /**
     * Update the specified progress report in storage.
     */
    public function update(Request $request, Progress $progress)
    {
        $user = Auth::user();
        // Allow access only to the teacher who created the report or an admin
        if ($user->role !== 'admin' && $user->id !== $progress->teacher_id) {
            abort(403);
        }

        $validated = $request->validate([
            'student_id' => 'required|exists:users,id',
            'date' => 'required|date',
            'start_time' => 'required',
            'end_time' => 'required',
            'material_covered' => 'required|string',
            'achievements' => 'required|string',
            'challenges' => 'required|string',
            'score' => 'required|integer|min:0|max:100',
            'overall_score' => 'nullable|integer|min:0|max:100',
            'notes' => 'nullable|string',
        ]);

        // If admin edits the report, update the teacher_id if the student has changed
        if ($user->role === 'admin' && $progress->student_id != $validated['student_id']) {
            $student = User::findOrFail($validated['student_id']);
            $validated['teacher_id'] = $student->teacher_id ?? $progress->teacher_id;
        }

        // Set overall_score to score if not provided
        if (!isset($validated['overall_score'])) {
            $validated['overall_score'] = $validated['score'];
        }

        $progress->update($validated);

        return redirect()->route('progress.index')
            ->with('success', 'Progress report updated successfully.');
    }

    /**
     * Remove the specified progress report from storage.
     */
    public function destroy(Progress $progress)
    {
        $user = Auth::user();
        
        // Only the teacher who created the report or an admin can delete it
        if ($user->role !== 'admin' && $user->id !== $progress->teacher_id) {
            abort(403);
        }

        $progress->delete();

        return redirect()->route('progress.index')
            ->with('success', 'Progress report deleted successfully.');
    }
    
    /**
     * Add a parent comment to the progress report.
     */
    public function comment(Request $request, Progress $progress)
    {
        if (Auth::user()->role !== 'parent' || !$this->isParentOfStudent(Auth::id(), $progress->student_id)) {
            abort(403);
        }

        $validated = $request->validate([
            'parent_comment' => 'required|string',
        ]);

        $progress->update([
            'parent_comment' => $validated['parent_comment'],
            'parent_comment_at' => now(),
        ]);

        return redirect()->route('progress.show', $progress)
            ->with('success', 'Comment added successfully.');
    }
    
    /**
     * Add a teacher reply to the parent's comment.
     */
    public function reply(Request $request, Progress $progress)
    {
        if (Auth::user()->id !== $progress->teacher_id) {
            abort(403);
        }

        $validated = $request->validate([
            'teacher_reply' => 'required|string',
        ]);

        $progress->update([
            'teacher_reply' => $validated['teacher_reply'],
            'teacher_reply_at' => now(),
        ]);

        return redirect()->route('progress.show', $progress)
            ->with('success', 'Reply added successfully.');
    }
    
    /**
     * Update a parent's comment on the progress report.
     */
    public function updateComment(Request $request, Progress $progress)
    {
        if (Auth::user()->role !== 'parent' || !$this->isParentOfStudent(Auth::id(), $progress->student_id)) {
            abort(403);
        }

        $validated = $request->validate([
            'parent_comment' => 'required|string',
        ]);

        $progress->update([
            'parent_comment' => $validated['parent_comment'],
            'parent_comment_at' => now(),
        ]);

        return redirect()->route('progress.show', $progress)
            ->with('success', 'Comment updated successfully.');
    }
    
    /**
     * Update a teacher's reply to the parent's comment.
     */
    public function updateReply(Request $request, Progress $progress)
    {
        if (Auth::user()->id !== $progress->teacher_id) {
            abort(403);
        }

        $validated = $request->validate([
            'teacher_reply' => 'required|string',
        ]);

        $progress->update([
            'teacher_reply' => $validated['teacher_reply'],
            'teacher_reply_at' => now(),
        ]);

        return redirect()->route('progress.show', $progress)
            ->with('success', 'Reply updated successfully.');
    }
    
    /**
     * Delete a parent's comment from the progress report.
     */
    public function deleteComment(Progress $progress)
    {
        if (Auth::user()->role !== 'parent' || !$this->isParentOfStudent(Auth::id(), $progress->student_id)) {
            abort(403);
        }

        $progress->update([
            'parent_comment' => null,
            'parent_comment_at' => null,
        ]);

        return redirect()->route('progress.show', $progress)
            ->with('success', 'Comment deleted successfully.');
    }
    
    /**
     * Delete a teacher's reply from the progress report.
     */
    public function deleteReply(Progress $progress)
    {
        if (Auth::user()->id !== $progress->teacher_id) {
            abort(403);
        }

        $progress->update([
            'teacher_reply' => null,
            'teacher_reply_at' => null,
        ]);

        return redirect()->route('progress.show', $progress)
            ->with('success', 'Reply deleted successfully.');
    }
    
    /**
     * Verify a progress report.
     */
    public function verify(Request $request, Progress $progress)
    {
        if (Auth::user()->role !== 'teacher') {
            abort(403);
        }

        // Verify that the teacher is the one who created the report
        if (Auth::id() !== $progress->teacher_id) {
            abort(403, 'Anda hanya dapat memverifikasi laporan yang Anda buat.');
        }

        $validated = $request->validate([
            'verification_status' => 'required|in:approved,rejected',
            'verification_note' => 'required|string|max:1000',
        ]);

        $progress->update([
            'is_verified' => true,
            'verified_at' => now(),
            'verified_by' => Auth::id(),
            'verification_status' => $validated['verification_status'],
            'verification_note' => $validated['verification_note'],
        ]);

        $statusMessage = $validated['verification_status'] === 'approved' ? 'disetujui' : 'ditolak';
        return redirect()->route('progress.show', $progress)
            ->with('success', "Laporan perkembangan telah berhasil {$statusMessage}");
    }

    /**
     * Unverify a progress report.
     */
    public function unverify(Progress $progress)
    {
        if (Auth::user()->role !== 'teacher') {
            abort(403);
        }

        // Verify that the teacher is the one who created the report
        if (Auth::id() !== $progress->teacher_id) {
            abort(403, 'Anda hanya dapat membatalkan verifikasi laporan yang Anda buat.');
        }

        $progress->update([
            'is_verified' => false,
            'verified_at' => null,
            'verified_by' => null,
            'verification_status' => 'pending',
            'verification_note' => null,
        ]);

        return redirect()->route('progress.show', $progress)
            ->with('success', 'Verifikasi laporan perkembangan telah dibatalkan');
    }

    /**
     * Check if user is parent of student.
     */
    private function isParentOfStudent($parentId, $studentId)
    {
        return User::where('id', $studentId)
            ->where('parent_id', $parentId)
            ->exists();
    }

    public function detail(Request $request)
    {
        $user = Auth::user();
        $student = null;
        $progressRecords = collect();
        $chartData = null;
        $totalMeetings = 0;

        if ($request->has('student_id')) {
            // Check permissions based on user role
            if ($user->role === 'teacher') {
                $student = User::where('id', $request->student_id)
                    ->where('teacher_id', $user->id)
                    ->firstOrFail();
            } elseif ($user->role === 'parent') {
                $student = User::where('id', $request->student_id)
                    ->where('parent_id', $user->id)
                    ->firstOrFail();
            } elseif ($user->role === 'admin') {
                $student = User::findOrFail($request->student_id);
            } else {
                abort(403);
            }

            // Get progress records with teacher information
            $progressRecords = Progress::where('student_id', $student->id)
                ->with('teacher')
                ->orderBy('date', 'desc')
                ->paginate(10);

            // Get total meetings
            $totalMeetings = $student->attendances()
                ->where('status', 'present')
                ->count();

            // Prepare chart data
            if ($progressRecords->count() > 0) {
                $chartData = [
                    'labels' => $progressRecords->pluck('date')->map(function ($date) {
                        return $date->format('d/m/Y');
                    })->toArray(),
                    'scores' => $progressRecords->pluck('score')->toArray(),
                    'averageScore' => round($progressRecords->avg('score'), 1),
                    'highestScore' => $progressRecords->max('score'),
                    'lowestScore' => $progressRecords->min('score'),
                    'totalMeetings' => $totalMeetings
                ];
            }
        } else {
            abort(404);
        }

        return view('dashboard.progress.detail.laporan', compact(
            'student',
            'progressRecords',
            'chartData',
            'totalMeetings'
        ));
    }
}
