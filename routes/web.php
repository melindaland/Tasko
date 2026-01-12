<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;

Route::get('/', function () {
    return view('accueil');
})->name('home');

// Authentication Routes
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);

// Protected Routes
Route::middleware('auth')->group(function () {
    Route::get('/workspace', function () {
        return view('workspace');
    })->name('workspace');

    Route::get('/profile', function () {
        return view('profile');
    })->name('profile');

    // Project Routes
    Route::prefix('projects/{project}')->group(function () {
        Route::get('/dashboard', [App\Http\Controllers\ProjectController::class, 'dashboard'])->name('projects.dashboard');
        Route::get('/kanban', [App\Http\Controllers\ProjectController::class, 'kanban'])->name('projects.kanban');
        Route::get('/roadmap', [App\Http\Controllers\ProjectController::class, 'roadmap'])->name('projects.roadmap');
    });

    // Task Attachment Download
    Route::get('/tasks/{task}/attachments/{index}/download', [App\Http\Controllers\TaskAttachmentController::class, 'download'])
        ->name('task.download-attachment');
});
