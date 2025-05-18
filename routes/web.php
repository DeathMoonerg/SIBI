<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PageController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\MainAuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProgressController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\TeachersController;
use App\Http\Controllers\StudentsController;
use App\Http\Controllers\ParentsController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\BillingController;
use App\Http\Controllers\PaymentsController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\ChartDataController;
use App\Http\Controllers\AdminDashboardChartsController;
use App\Http\Controllers\PolicyController;
use App\Http\Controllers\ReviewController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Main pages
Route::get('/', [PageController::class, 'home'])->name('home');
Route::get('/about', [PageController::class, 'about'])->name('about');
Route::get('/classes', [PageController::class, 'classes'])->name('classes');
Route::get('/contact', [PageController::class, 'contact'])->name('contact');

// Secondary pages
Route::get('/facility', [PageController::class, 'facility'])->name('facility');
Route::get('/team', [PageController::class, 'team'])->name('team');
Route::get('/call-to-action', [PageController::class, 'callToAction'])->name('call-to-action');
Route::get('/appointment', [PageController::class, 'appointment'])->name('appointment');
Route::get('/testimonial', [PageController::class, 'testimonial'])->name('testimonial');
Route::get('/404', [PageController::class, 'notFound'])->name('404');

// Authentication
Route::get('/login', [LoginController::class, 'loginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Protected routes
Route::middleware(['auth'])->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Policies
    Route::resource('policies', PolicyController::class);
    Route::put('/policies/{policy}/toggle-status', [PolicyController::class, 'toggleStatus'])->name('policies.toggle-status');
    
    // Perkembangan Anak Didik
    Route::middleware(['auth', 'check.progress.access'])->group(function () {
        Route::get('/progress', [ProgressController::class, 'index'])->name('progress.index');
        Route::get('/progress/create', [ProgressController::class, 'create'])->name('progress.create');
        Route::post('/progress', [ProgressController::class, 'store'])->name('progress.store');
        Route::get('/progress/detail', [ProgressController::class, 'detail'])->name('progress.detail');
        Route::get('/progress/{progress}', [ProgressController::class, 'show'])->name('progress.show');
        Route::get('/progress/{progress}/edit', [ProgressController::class, 'edit'])->name('progress.edit');
        Route::put('/progress/{progress}', [ProgressController::class, 'update'])->name('progress.update');
        Route::delete('/progress/{progress}', [ProgressController::class, 'destroy'])->name('progress.destroy');
        
        // Comment routes
        Route::post('/progress/{progress}/comment', [ProgressController::class, 'comment'])->name('progress.comment');
        Route::put('/progress/{progress}/comment', [ProgressController::class, 'updateComment'])->name('progress.updateComment');
        Route::delete('/progress/{progress}/comment', [ProgressController::class, 'deleteComment'])->name('progress.deleteComment');
        
        // Reply routes
        Route::post('/progress/{progress}/reply', [ProgressController::class, 'reply'])->name('progress.reply');
        Route::put('/progress/{progress}/reply', [ProgressController::class, 'updateReply'])->name('progress.updateReply');
        Route::delete('/progress/{progress}/reply', [ProgressController::class, 'deleteReply'])->name('progress.deleteReply');
        
        // Verification routes
        Route::post('/progress/{progress}/verify', [ProgressController::class, 'verify'])->name('progress.verify');
        Route::post('/progress/{progress}/unverify', [ProgressController::class, 'unverify'])->name('progress.unverify');
    });
    
    // Presensi
    Route::get('/attendance', [AttendanceController::class, 'index'])->name('attendance.index');
    Route::get('/attendance/create', [AttendanceController::class, 'create'])->name('attendance.create');
    Route::post('/attendance', [AttendanceController::class, 'store'])->name('attendance.store');
    Route::get('/attendance/{attendance}', [AttendanceController::class, 'show'])->name('attendance.show');
    Route::get('/attendance/{attendance}/edit', [AttendanceController::class, 'edit'])->name('attendance.edit');
    Route::put('/attendance/{attendance}', [AttendanceController::class, 'update'])->name('attendance.update');
    Route::delete('/attendance/{attendance}', [AttendanceController::class, 'destroy'])->name('attendance.destroy');
    
    // Parent Attendance Routes
    Route::get('/parent/attendance', [AttendanceController::class, 'parentIndex'])->name('parent.attendance.index');
    Route::get('/parent/attendance/{attendance}', [AttendanceController::class, 'parentShow'])->name('parent.attendance.show');
    
    // Billing
    Route::get('/billing', [BillingController::class, 'index'])->name('billing.index');
    Route::get('/billing/{billing}', [BillingController::class, 'show'])->name('billing.show');
    
    // Profile
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.update-password');
    
    // Students Management (Accessible to both teachers and admins)
    Route::get('/students', [StudentsController::class, 'index'])->name('students.index');
    Route::get('/students/create', [StudentsController::class, 'create'])->name('students.create');
    Route::post('/students', [StudentsController::class, 'store'])->name('students.store');
    Route::get('/students/{student}', [StudentsController::class, 'show'])->name('students.show');
    Route::get('/students/{student}/edit', [StudentsController::class, 'edit'])->name('students.edit');
    Route::put('/students/{student}', [StudentsController::class, 'update'])->name('students.update');
    Route::delete('/students/{student}', [StudentsController::class, 'destroy'])->name('students.destroy');
    
    // Teachers Management (Accessible to both teachers and admins)
    Route::get('/teachers', [TeachersController::class, 'index'])->name('teachers.index');
    Route::get('/teachers/create', [TeachersController::class, 'create'])->name('teachers.create');
    Route::post('/teachers', [TeachersController::class, 'store'])->name('teachers.store');
    Route::get('/teachers/{teacher}', [TeachersController::class, 'show'])->name('teachers.show');
    Route::get('/teachers/{teacher}/edit', [TeachersController::class, 'edit'])->name('teachers.edit');
    Route::put('/teachers/{teacher}', [TeachersController::class, 'update'])->name('teachers.update');
    Route::delete('/teachers/{teacher}', [TeachersController::class, 'destroy'])->name('teachers.destroy');
});

// Admin routes
Route::middleware(['auth'])->prefix('admin')->group(function () {
    Route::get('/', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/contacts', [AdminController::class, 'contacts'])->name('admin.contacts');
    Route::get('/teachers', [AdminController::class, 'teachers'])->name('admin.teachers');
    Route::get('/students', [AdminController::class, 'students'])->name('admin.students');
    Route::get('/testimonials', [AdminController::class, 'testimonials'])->name('admin.testimonials');
    Route::patch('/contacts/{contact}/mark-as-read', [AdminController::class, 'markContactAsRead'])->name('admin.contacts.mark-as-read');
});

// Payments (Admin only)
Route::middleware(['auth'])->group(function () {
    Route::get('/payments', [PaymentsController::class, 'index'])->name('payments.index');
    Route::get('/payments/create', [PaymentsController::class, 'create'])->name('payments.create');
    Route::post('/payments', [PaymentsController::class, 'store'])->name('payments.store');
    Route::get('/payments/{payment}', [PaymentsController::class, 'show'])->name('payments.show');
});

// Settings (Admin only)
Route::middleware(['auth'])->group(function () {
    Route::get('/settings', [SettingsController::class, 'index'])->name('settings.index');
    Route::put('/settings', [SettingsController::class, 'update'])->name('settings.update');
});

// Parents Management (Admin only)
Route::middleware(['auth'])->group(function () {
    Route::get('/parents', [ParentsController::class, 'index'])->name('parents.index');
    Route::get('/parents/create', [ParentsController::class, 'create'])->name('parents.create');
    Route::post('/parents', [ParentsController::class, 'store'])->name('parents.store');
    Route::get('/parents/{parent}', [ParentsController::class, 'show'])->name('parents.show');
    Route::get('/parents/{parent}/edit', [ParentsController::class, 'edit'])->name('parents.edit');
    Route::put('/parents/{parent}', [ParentsController::class, 'update'])->name('parents.update');
    Route::delete('/parents/{parent}', [ParentsController::class, 'destroy'])->name('parents.destroy');
});

// Form submissions
Route::post('/contact', [App\Http\Controllers\ContactController::class, 'store'])->name('contact.store');
Route::post('/appointment', [PageController::class, 'storeAppointment'])->name('appointment.store');

// Registration Routes
Route::post('/register', [RegistrationController::class, 'store'])->name('register.store');

// Route untuk chart data
Route::middleware('auth')->group(function () {
    Route::get('/chart/admin-stats', [ChartDataController::class, 'getAdminStats'])->name('chart.admin-stats');
    Route::get('/chart/parent-stats', [ChartDataController::class, 'getParentStats'])->name('chart.parent-stats');
    Route::get('/chart/admin-dashboard', [ChartDataController::class, 'getAdminDashboardData'])->name('chart.admin-dashboard');
    Route::get('/chart/teacher-dashboard', [ChartDataController::class, 'getTeacherDashboardData'])->name('chart.teacher-dashboard');
});

// Review routes
Route::middleware('auth')->group(function () {
    Route::resource('reviews', ReviewController::class);
    Route::patch('reviews/{review}/approve', [App\Http\Controllers\ReviewController::class, 'approve'])->name('reviews.approve');
});
