<?php

use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;

// DEFAULT
Route::view('/', 'welcome');

// PROFILE
Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

// DASHBOARD
Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

// NOTES
Route::view('notes', 'notes.index')
    ->middleware(['auth'])
    ->name('notes.index');

Route::view('notes/create', 'notes.create')
    ->middleware(['auth'])
    ->name('notes.create');

Volt::route('notes/{note}/edit', 'notes.edit-note')
    ->middleware(['auth'])
    ->name('notes.edit');

require __DIR__ . '/auth.php';
