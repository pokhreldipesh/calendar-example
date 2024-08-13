<?php

use Illuminate\Support\Facades\Route;

Route::get('/', \App\Livewire\Calendar::class)->name('calendar');
