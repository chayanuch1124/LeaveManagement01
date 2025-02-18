<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';



use App\Http\Controllers\EmployeeController;
// แสดงหน้า Dashboard
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [EmployeeController::class, 'dashboard'])->name('dashboard');
});

use App\Http\Controllers\LeaveController;

Route::middleware(['auth'])->group(function () {
    Route::get('/leave/apply', [LeaveController::class, 'create'])->name('leave.apply'); // เปิดฟอร์มขอลา
    Route::post('/leave/apply', [LeaveController::class, 'store'])->name('leave.store'); // ✅ เพิ่ม Route นี้
    Route::get('/leave/{id}/edit', [LeaveController::class, 'edit'])->name('leave.edit');
    Route::put('/leave/{id}', [LeaveController::class, 'update'])->name('leave.update');
    Route::delete('/leave/{id}', [LeaveController::class, 'destroy'])->name('leave.destroy');
    Route::get('/leave/index', [LeaveController::class, 'index'])->name('leave.index');
    Route::get('/leaves/{id}', [LeaveController::class, 'show'])->name('leave.show');
    Route::put('leave/{id}/status', [LeaveController::class, 'updateStatus'])->name('leave.updateStatus');
});

// use App\Http\Controllers\LeaveController;
// use App\Http\Controllers\EmployeeController;


// // ✅ Employee เข้าถึงเฉพาะ /dashboard, leave.apply, leave.edit
// Route::middleware(['auth', 'role:employee,admin'])->group(function () {
//     Route::get('/dashboard', [EmployeeController::class, 'index'])->name('dashboard');
//     Route::get('/leave/apply', [LeaveController::class, 'create'])->name('leave.apply');
//     Route::post('/leave/apply', [LeaveController::class, 'store'])->name('leave.store');
//     Route::get('/leave/{id}/edit', [LeaveController::class, 'edit'])->name('leave.edit');
//     Route::put('/leave/{id}', [LeaveController::class, 'update'])->name('leave.update');
//     Route::delete('/leave/{id}', [LeaveController::class, 'destroy'])->name('leave.destroy');
// });

// // ✅ Admin เข้าถึงทุกหน้า
// Route::middleware(['auth', 'role:admin'])->group(function () {
//     Route::get('/dashboard', [EmployeeController::class, 'dashboard'])->name('dashboard');
//     Route::get('/leave/index', [LeaveController::class, 'index'])->name('leave.index');
//     Route::get('/leaves/{id}', [LeaveController::class, 'show'])->name('leave.show');
//     Route::put('/leave/{id}', [LeaveController::class, 'update'])->name('leave.approval.update');

// });





// use App\Http\Controllers\LeaveController;

// use App\Http\Middleware\IsEmployee;

// Route::middleware(['auth', IsEmployee::class])->group(function () {
//     Route::get('/dashboard', [EmployeeController::class, 'dashboard'])->name('dashboard');
//     Route::get('/leave/apply', [LeaveController::class, 'create'])->name('leave.apply');
//     Route::post('/leave/apply', [LeaveController::class, 'store'])->name('leave.store');
//     Route::get('/leave/{id}/edit', [LeaveController::class, 'edit'])->name('leave.edit');
//     Route::put('/leave/{id}', [LeaveController::class, 'update'])->name('leave.update');  
//     Route::delete('/leave/{id}', [LeaveController::class, 'destroy'])->name('leave.destroy');
// });
