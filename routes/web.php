<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Models\cases;
use App\Http\Controllers\SlideController;
use App\Http\Controllers\DoctorReviewController;
use App\Http\Controllers\CaseController;
use App\Http\Controllers\AiAnalysisController;
use App\Http\Controllers\DashboardController;

//Route::get('/', function () {
//  return view('welcome');
//});

Route::get('/', function () {
    return view('home');
})->name('home');


Route::middleware(['auth', 'role:doctor'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');

    Route::get('/cases-archive', [CaseController::class, 'archive'])
        ->name('cases.archive');

    Route::patch('/cases/{id}/restore', [CaseController::class, 'restore'])
        ->name('cases.restore');

    Route::post('/cases/{case}/slides', [SlideController::class, 'store'])
        ->name('cases.slides.store');

    Route::get('/cases/{case}/slides/{slide}/download', [SlideController::class, 'download'])
        ->name('cases.slides.download');

    Route::patch('/cases/{case}/complete', [CaseController::class, 'complete'])
        ->name('cases.complete');

    Route::delete('/cases/{case}/slides/{slide}', [SlideController::class, 'destroy'])
        ->name('cases.slides.destroy');

    Route::get(
        '/cases/{case}/slides/{slide}/viewer-info',
        [SlideController::class, 'viewerInfo']
    )->name('cases.slides.viewer-info');

    Route::get(
        '/cases/{case}/slides/{slide}/tiles/{level}/{column}/{row}',
        [SlideController::class, 'tile']
    )
        ->whereNumber('level')
        ->whereNumber('column')
        ->whereNumber('row')
        ->name('cases.slides.tile');

    Route::put(
        '/cases/{case}/slides/{slide}/review',
        [DoctorReviewController::class, 'save']
    )->name('cases.slides.review.save');

    Route::post(
        '/cases/{case}/slides/{slide}/analysis',
        [AiAnalysisController::class, 'run']
    )->name('cases.slides.analysis.run');

    Route::resource('cases', CaseController::class);
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
