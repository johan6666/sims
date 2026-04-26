<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\AdminAcademicYearController;
use App\Http\Controllers\AdminClassController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AdminMenuCrudController;
use App\Http\Controllers\AdminMenuDataController;
use App\Http\Controllers\AdminAttendanceSessionController;
use App\Http\Controllers\AdminTeacherAssignmentController;
use App\Http\Controllers\AdminTeacherPayrollController;
use App\Http\Controllers\AdminPermissionManagementController;
use App\Http\Controllers\AdminRoleManagementController;
use App\Http\Controllers\AdminStudentController;
use App\Http\Controllers\AdminSubjectController;
use App\Http\Controllers\AdminTeacherAttendanceController;
use App\Http\Controllers\AdminUserManagementController;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\PpdbController;
use App\Http\Controllers\PortalController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
| Production: php artisan route:cache untuk optimize routing
*/

// Admin auth
Route::get('/admin/login', [AdminAuthController::class, 'create'])->name('login');
Route::post('/admin/login', [AdminAuthController::class, 'store'])->name('login.store');
Route::post('/admin/logout', [AdminAuthController::class, 'destroy'])->name('logout');

// Admin Panel
Route::middleware(['auth', 'role:admin|super_admin|guru'])->group(function () {
    Route::get('/admin', [AdminController::class, 'index'])->name('admin.index');

    Route::prefix('admin/api')->name('admin.api.')->group(function () {
        Route::get('/users', [AdminUserManagementController::class, 'index'])
            ->middleware('permission:sistem-pengaturan.user-management.list')
            ->name('users.index');
        Route::post('/users', [AdminUserManagementController::class, 'store'])
            ->middleware('permission:sistem-pengaturan.user-management.create')
            ->name('users.store');
        Route::put('/users/{user}', [AdminUserManagementController::class, 'update'])
            ->middleware('permission:sistem-pengaturan.user-management.update')
            ->name('users.update');
        Route::delete('/users/{user}', [AdminUserManagementController::class, 'destroy'])
            ->middleware('permission:sistem-pengaturan.user-management.delete')
            ->name('users.destroy');

        Route::get('/students', [AdminStudentController::class, 'index'])
            ->middleware('permission:kesiswaan.data-siswa.list')
            ->name('students.index');
        Route::post('/students', [AdminStudentController::class, 'store'])
            ->middleware('permission:kesiswaan.data-siswa.create')
            ->name('students.store');
        Route::put('/students/{student}', [AdminStudentController::class, 'update'])
            ->middleware('permission:kesiswaan.data-siswa.update')
            ->name('students.update');
        Route::delete('/students/{student}', [AdminStudentController::class, 'destroy'])
            ->middleware('permission:kesiswaan.data-siswa.delete')
            ->name('students.destroy');
        Route::get('/students/template', [AdminStudentController::class, 'downloadTemplate'])
            ->middleware('permission:kesiswaan.data-siswa.list')
            ->name('students.template');
        Route::get('/students/template-sample', [AdminStudentController::class, 'downloadSampleTemplate'])
            ->middleware('permission:kesiswaan.data-siswa.list')
            ->name('students.template-sample');

        Route::get('/roles', [AdminRoleManagementController::class, 'index'])
            ->middleware('permission:sistem-pengaturan.role-permission.list')
            ->name('roles.index');
        Route::post('/roles', [AdminRoleManagementController::class, 'store'])
            ->middleware('permission:sistem-pengaturan.role-permission.create')
            ->name('roles.store');
        Route::put('/roles/{role}', [AdminRoleManagementController::class, 'update'])
            ->middleware('permission:sistem-pengaturan.role-permission.update')
            ->name('roles.update');
        Route::delete('/roles/{role}', [AdminRoleManagementController::class, 'destroy'])
            ->middleware('permission:sistem-pengaturan.role-permission.delete')
            ->name('roles.destroy');

        Route::get('/permissions', [AdminPermissionManagementController::class, 'index'])
            ->middleware('permission:sistem-pengaturan.permission-management.list')
            ->name('permissions.index');
        Route::post('/permissions', [AdminPermissionManagementController::class, 'store'])
            ->middleware('permission:sistem-pengaturan.permission-management.create')
            ->name('permissions.store');
        Route::put('/permissions/{permission}', [AdminPermissionManagementController::class, 'update'])
            ->middleware('permission:sistem-pengaturan.permission-management.update')
            ->name('permissions.update');
        Route::delete('/permissions/{permission}', [AdminPermissionManagementController::class, 'destroy'])
            ->middleware('permission:sistem-pengaturan.permission-management.delete')
            ->name('permissions.destroy');

        Route::get('/menus', [AdminMenuCrudController::class, 'index'])
            ->middleware('permission:sistem-pengaturan.menu-management.list')
            ->name('menus.index');
        Route::post('/menus', [AdminMenuCrudController::class, 'store'])
            ->middleware('permission:sistem-pengaturan.menu-management.create')
            ->name('menus.store');
        Route::put('/menus/{menu}', [AdminMenuCrudController::class, 'update'])
            ->middleware('permission:sistem-pengaturan.menu-management.update')
            ->name('menus.update');
        Route::delete('/menus/{menu}', [AdminMenuCrudController::class, 'destroy'])
            ->middleware('permission:sistem-pengaturan.menu-management.delete')
            ->name('menus.destroy');

        Route::get('/menu-data/{menu:slug}', [AdminMenuDataController::class, 'index'])
            ->middleware('menu_permission:list')
            ->name('menu-data.index');
        Route::post('/menu-data/{menu:slug}', [AdminMenuDataController::class, 'store'])
            ->middleware('menu_permission:create')
            ->name('menu-data.store');
        Route::put('/menu-data/{menu:slug}/{recordId}', [AdminMenuDataController::class, 'update'])
            ->middleware('menu_permission:update')
            ->name('menu-data.update');
        Route::delete('/menu-data/{menu:slug}/{recordId}', [AdminMenuDataController::class, 'destroy'])
            ->middleware('menu_permission:delete')
            ->name('menu-data.destroy');

        Route::get('/attendance-sessions', [AdminAttendanceSessionController::class, 'index'])
            ->middleware('permission:akademik.absensi-siswa.list')
            ->name('attendance-sessions.index');
        Route::post('/attendance-sessions', [AdminAttendanceSessionController::class, 'store'])
            ->middleware('permission:akademik.absensi-siswa.create')
            ->name('attendance-sessions.store');
        Route::put('/attendance-sessions/{attendanceSession}', [AdminAttendanceSessionController::class, 'update'])
            ->middleware('permission:akademik.absensi-siswa.update')
            ->name('attendance-sessions.update');
        Route::delete('/attendance-sessions/{attendanceSession}', [AdminAttendanceSessionController::class, 'destroy'])
            ->middleware('permission:akademik.absensi-siswa.delete')
            ->name('attendance-sessions.destroy');

        Route::get('/teacher-assignments', [AdminTeacherAssignmentController::class, 'index'])
            ->middleware('permission:kepegawaian.penugasan-guru.list')
            ->name('teacher-assignments.index');
        Route::post('/teacher-assignments', [AdminTeacherAssignmentController::class, 'store'])
            ->middleware('permission:kepegawaian.penugasan-guru.create')
            ->name('teacher-assignments.store');
        Route::put('/teacher-assignments/{teacherAssignment}', [AdminTeacherAssignmentController::class, 'update'])
            ->middleware('permission:kepegawaian.penugasan-guru.update')
            ->name('teacher-assignments.update');
        Route::delete('/teacher-assignments/{teacherAssignment}', [AdminTeacherAssignmentController::class, 'destroy'])
            ->middleware('permission:kepegawaian.penugasan-guru.delete')
            ->name('teacher-assignments.destroy');

        Route::get('/subjects', [AdminSubjectController::class, 'index'])
            ->middleware('permission:akademik.mata-pelajaran.list')
            ->name('subjects.index');
        Route::post('/subjects', [AdminSubjectController::class, 'store'])
            ->middleware('permission:akademik.mata-pelajaran.create')
            ->name('subjects.store');
        Route::put('/subjects/{subject}', [AdminSubjectController::class, 'update'])
            ->middleware('permission:akademik.mata-pelajaran.update')
            ->name('subjects.update');
        Route::delete('/subjects/{subject}', [AdminSubjectController::class, 'destroy'])
            ->middleware('permission:akademik.mata-pelajaran.delete')
            ->name('subjects.destroy');

        Route::get('/classes', [AdminClassController::class, 'index'])
            ->middleware('permission:akademik.kelas.list')
            ->name('classes.index');
        Route::post('/classes', [AdminClassController::class, 'store'])
            ->middleware('permission:akademik.kelas.create')
            ->name('classes.store');
        Route::put('/classes/{class}', [AdminClassController::class, 'update'])
            ->middleware('permission:akademik.kelas.update')
            ->name('classes.update');
        Route::delete('/classes/{class}', [AdminClassController::class, 'destroy'])
            ->middleware('permission:akademik.kelas.delete')
            ->name('classes.destroy');

        Route::get('/academic-years', [AdminAcademicYearController::class, 'index'])
            ->middleware('permission:sistem-pengaturan.tahun.list')
            ->name('academic-years.index');
        Route::post('/academic-years', [AdminAcademicYearController::class, 'store'])
            ->middleware('permission:sistem-pengaturan.tahun.create')
            ->name('academic-years.store');
        Route::put('/academic-years/{academicYear}', [AdminAcademicYearController::class, 'update'])
            ->middleware('permission:sistem-pengaturan.tahun.update')
            ->name('academic-years.update');
        Route::delete('/academic-years/{academicYear}', [AdminAcademicYearController::class, 'destroy'])
            ->middleware('permission:sistem-pengaturan.tahun.delete')
            ->name('academic-years.destroy');

        Route::get('/teacher-attendances', [AdminTeacherAttendanceController::class, 'index'])
            ->middleware('permission:kepegawaian.absensi-guru.list')
            ->name('teacher-attendances.index');
        Route::post('/teacher-attendances/check-in', [AdminTeacherAttendanceController::class, 'checkIn'])
            ->middleware('permission:kepegawaian.absensi-guru.create')
            ->name('teacher-attendances.check-in');
        Route::post('/teacher-attendances/check-out', [AdminTeacherAttendanceController::class, 'checkOut'])
            ->middleware('permission:kepegawaian.absensi-guru.update')
            ->name('teacher-attendances.check-out');
        Route::post('/teacher-attendances/manual', [AdminTeacherAttendanceController::class, 'manualStore'])
            ->middleware('permission:kepegawaian.absensi-guru.create')
            ->name('teacher-attendances.manual.store');
        Route::put('/teacher-attendances/manual/{teacherAttendance}', [AdminTeacherAttendanceController::class, 'manualUpdate'])
            ->middleware('permission:kepegawaian.absensi-guru.update')
            ->name('teacher-attendances.manual.update');

        Route::get('/payrolls', [AdminTeacherPayrollController::class, 'index'])
            ->middleware('permission:kepegawaian.penggajian.list')
            ->name('payrolls.index');
        Route::post('/payrolls', [AdminTeacherPayrollController::class, 'store'])
            ->middleware('permission:kepegawaian.penggajian.create')
            ->name('payrolls.store');
        Route::put('/payrolls/{teacherPayroll}', [AdminTeacherPayrollController::class, 'update'])
            ->middleware('permission:kepegawaian.penggajian.update')
            ->name('payrolls.update');
        Route::delete('/payrolls/{teacherPayroll}', [AdminTeacherPayrollController::class, 'destroy'])
            ->middleware('permission:kepegawaian.penggajian.delete')
            ->name('payrolls.destroy');
    });
});

// Landing Page
Route::get('/', [LandingController::class, 'index'])->name('landing');

// PPDB Routes
Route::prefix('ppdb')->name('ppdb.')->group(function () {
    Route::get('/', [PpdbController::class, 'index'])->name('index');
    Route::get('/daftar', [PpdbController::class, 'daftar'])->name('daftar');
    Route::post('/daftar', [PpdbController::class, 'storeDaftar'])->name('daftar.store');
    Route::get('/cek-status', [PpdbController::class, 'cek'])->name('cek');
});

// Portal Siswa
Route::prefix('portal')->name('portal.')->group(function () {
    Route::get('/', [PortalController::class, 'index'])->name('index');
});
