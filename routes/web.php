<?php

use App\Http\Controllers\ProfileController;
use App\Models\Income;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register')
    ]);
})->name('index');

Route::get('/dashboard', function () {

})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard', [
            'income' => Income::where('user_id', auth()->id())->sum('income'),
            'withdrawn' => \App\Models\Withdraw::where('user_id', auth()->id())->where('status', 'approved')->sum('amount'),
            'top10Affiliates' => \App\Models\Income::top10Affiliates(),
            'sliders' => \App\Models\Slider::latest()->get(['id', 'title', 'image'])
        ]);
    })->name('dashboard');
    Route::get('/courses', [\App\Http\Controllers\DashboardController::class, 'courses'])->name('courses.index');
    Route::get('/income', [\App\Http\Controllers\IncomeController::class, 'index'])->name('income.index');
    Route::resource('withdraw', \App\Http\Controllers\WithdrawController::class)->names([
        'index' => 'withdraw.index',
        'create' => 'withdraw.create',
        'store' => 'withdraw.store',
        'update' => 'withdraw.update',
    ]);
    Route::get('/admin/withdraws', [\App\Http\Controllers\WithdrawController::class, 'adminIndex'])->name('admin.withdraws.index');
    Route::resource('/slider', \App\Http\Controllers\SliderController::class)->names([
        'index' => 'slider.index',
        'create' => 'slider.create',
        'store' => 'slider.store',
        'update' => 'slider.update',
        'destroy' => 'slider.destroy',
    ]);
});

Route::get('/storage-link', function () {
Artisan::call('storage:link');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
