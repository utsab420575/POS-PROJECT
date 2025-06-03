<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('index');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


//for logout ;
Route::get('admin/logout',[AdminController::class,'AdminDestroy'])->name('admin.logout');



// Route to show logout success message/page
Route::get('/logout-success', [AdminController::class, 'AdminLogoutPage'])->name('logout.success');


Route::get('/admin/profile', [AdminController::class, 'AdminProfile'])->name('admin.profile');
Route::post('/admin/profile/store', [AdminController::class, 'AdminProfileStore'])->name('admin.profile.store');
Route::get('/change/password', [AdminController::class, 'ChangePassword'])->name('change.password');
require __DIR__.'/auth.php';
