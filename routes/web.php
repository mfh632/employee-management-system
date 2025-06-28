<?php

use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;

Route::get('/', function () {
    return view('welcome');
})->name('home');



Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Volt::route('settings/profile', 'settings.profile')->name('settings.profile');
    Volt::route('settings/password', 'settings.password')->name('settings.password');
    Volt::route('settings/appearance', 'settings.appearance')->name('settings.appearance');

    Volt::route('/employees', 'show-employees')->name('employees.index');
    Volt::route('/employees/create', 'employees.create')->name('employees.create');
    Volt::route('/employees/{id}/edit', 'employees.edit')->name('employees.edit');

    Volt::route('/departments', 'departments.list')->name('departments.index');
    Volt::route('/designations', 'designations.list')->name('designations.index]'); 
});

require __DIR__.'/auth.php';
