<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DiscoverController;
use App\Http\Controllers\MyEventsController;
use App\Http\Controllers\JoinHistoryController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', [AuthController::class, 'showHome'])->name('home');
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware('auth')->group(function () {
    Route::get('/discover', [DiscoverController::class, 'index'])->name('discover');
    Route::post('/discover/create', [DiscoverController::class, 'createPost'])->name('discover.create');
    Route::post('/discover/{post}/join', [DiscoverController::class, 'joinPost'])->name('discover.join');

    Route::get('/myevents', [MyEventsController::class, 'index'])->name('myevents');
    Route::get('/myevents/{post}/requests', [MyEventsController::class, 'viewGroupRequests'])->name('myevents.requests');
    Route::post('/myevents/{request}/accept', [MyEventsController::class, 'acceptRequest'])->name('myevents.accept');
    Route::post('/myevents/{request}/reject', [MyEventsController::class, 'rejectRequest'])->name('myevents.reject');

    Route::get('/joinhistory', [JoinHistoryController::class, 'index'])->name('joinhistory');

    Route::get('/messages', [MessageController::class, 'index'])->name('messages');
    Route::get('/messages/group/{post}', [MessageController::class, 'viewGroupChat'])->name('messages.group');
    Route::post('/messages/group/{post}/send', [MessageController::class, 'sendGroupMessage'])->name('messages.group.send');
    Route::get('/messages/direct/{user}', [MessageController::class, 'directMessage'])->name('messages.direct');
    Route::post('/messages/direct/{user}/send', [MessageController::class, 'sendDirectMessage'])->name('messages.direct.send');

    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
    Route::post('/profile/update', [ProfileController::class, 'updateProfile'])->name('profile.update');
});

