<?php

use App\Http\Controllers\ContactController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::post('/service-requests', [ContactController::class, 'store'])
    ->middleware('throttle:10,1')
    ->name('service-requests.store');

Route::view('/{path}', 'welcome')
    ->whereIn('path', [
        'car-locksmith',
        'used-auto-parts',
        'used-tires',
        'sell-your-junk-car',
        'how-it-works',
        'contact',
        'privacy',
    ]);
