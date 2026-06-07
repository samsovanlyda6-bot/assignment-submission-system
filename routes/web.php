<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\AssignmentController;
use App\Http\Controllers\EnrollmentController;
use App\Http\Controllers\SubmissionController;
use App\Http\Controllers\GradeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HomeController;

// Public Routes
Route::get('/', [HomeController::class, 'welcome'])->name('welcome');
Route::get('/home', [HomeController::class, 'index'])->name('home')->middleware('auth');

// Authentication Routes (Breeze)
require __DIR__.'/auth.php';

// Protected Routes (require authentication)
Route::middleware(['auth'])->group(function () {

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
 // Enrollment Routes
    Route::resource('enrollments', EnrollmentController::class);
    // Role-based dashboards
    Route::get('/admin/dashboard', [DashboardController::class, 'adminDashboard'])->name('admin.dashboard');
    Route::get('/teacher/dashboard', [DashboardController::class, 'teacherDashboard'])->name('teacher.dashboard');
    Route::get('/student/dashboard', [DashboardController::class, 'studentDashboard'])->name('student.dashboard');

    // ==================== ENROLLMENT RESOURCE ROUTES ====================
    Route::resource('enrollments', EnrollmentController::class);

    // ==================== COURSE RESOURCE ROUTES ====================
    Route::resource('courses', CourseController::class);

    // ==================== ASSIGNMENT RESOURCE ROUTES ====================
    Route::resource('assignments', AssignmentController::class);

    // ==================== SUBMISSION RESOURCE ROUTES ====================
    Route::resource('submissions', SubmissionController::class);

    // ==================== GRADE ROUTES ====================
    Route::prefix('grades')->name('grades.')->group(function () {
        Route::get('/', [GradeController::class, 'index'])->name('index');
        Route::get('/assignment/{assignment_id}', [GradeController::class, 'byAssignment'])->name('by-assignment');
        Route::get('/submission/{submission_id}/edit', [GradeController::class, 'edit'])->name('edit');
        Route::put('/submission/{submission_id}', [GradeController::class, 'update'])->name('update');
    });

    // ==================== STUDENT ROUTES ====================
    Route::prefix('student')->name('student.')->group(function () {
        Route::get('/my-courses', [EnrollmentController::class, 'myCourses'])->name('my-courses');
        Route::get('/submissions', [SubmissionController::class, 'mySubmissions'])->name('submissions.index');
        Route::get('/submissions/create/{assignment_id}', [SubmissionController::class, 'create'])->name('submissions.create');
        Route::post('/submissions', [SubmissionController::class, 'store'])->name('submissions.store');
        Route::get('/my-grades', [GradeController::class, 'myGrades'])->name('grades.my-grades');
        Route::get('/my-feedback', [FeedbackController::class, 'myFeedback'])->name('feedback.my-feedback');
    });

    // ==================== ADMIN ROUTES ====================
    Route::prefix('admin')->name('admin.')->group(function () {
        Route::resource('users', UserController::class);
        Route::resource('roles', RoleController::class);
        Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
        Route::post('/reports/submissions', [ReportController::class, 'generateSubmissionsReport'])->name('reports.submissions');
        Route::post('/reports/grades', [ReportController::class, 'generateGradesReport'])->name('reports.grades');
        Route::post('/reports/performance', [ReportController::class, 'generatePerformanceReport'])->name('reports.performance');
        Route::delete('/reports/{id}', [ReportController::class, 'destroy'])->name('reports.destroy');
    });

    // ==================== TEACHER ROUTES ====================
    Route::prefix('teacher')->name('teacher.')->group(function () {
        Route::get('/grades/assignment/{assignment_id}', [GradeController::class, 'byAssignment'])->name('grades.by-assignment');
        Route::get('/grades/submission/{submission_id}/edit', [GradeController::class, 'edit'])->name('grades.edit');
        Route::put('/grades/submission/{submission_id}', [GradeController::class, 'update'])->name('grades.update');
        Route::get('/feedbacks/submission/{submission_id}', [FeedbackController::class, 'index'])->name('feedbacks.index');
        Route::post('/feedbacks/submission/{submission_id}', [FeedbackController::class, 'store'])->name('feedbacks.store');
    });

    // ==================== NOTIFICATION ROUTES ====================
    Route::prefix('notifications')->name('notifications.')->group(function () {
        Route::get('/', [NotificationController::class, 'index'])->name('index');
        Route::post('/{id}/read', [NotificationController::class, 'markAsRead'])->name('mark-read');
        Route::post('/read-all', [NotificationController::class, 'markAllAsRead'])->name('mark-all-read');
        Route::delete('/{id}', [NotificationController::class, 'destroy'])->name('destroy');
    });

    // ==================== PROFILE ROUTES ====================
    Route::prefix('profile')->name('profile.')->group(function () {
        Route::get('/', [ProfileController::class, 'index'])->name('index');
        Route::put('/', [ProfileController::class, 'update'])->name('update');
        Route::put('/password', [ProfileController::class, 'updatePassword'])->name('password');
    });
});
