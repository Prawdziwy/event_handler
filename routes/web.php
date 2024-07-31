<?php

use App\Http\Controllers\Calendar\CalendarController;
use App\Http\Controllers\Calendar\CalendarEventController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\User\ProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [HomeController::class, 'index']);
Route::get('/faq', [HomeController::class, 'faq']);

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::middleware('auth')->group(function () {
    Route::prefix('profile')->name('pages.profile.')->group(function () {
        Route::get('/', [ProfileController::class, 'show'])->name('show');
        Route::post('/', [ProfileController::class, 'update'])->name('update');
        Route::get('/password', [ProfileController::class, 'editPassword'])->name('password.edit');
        Route::post('/password', [ProfileController::class, 'updatePassword'])->name('password.update');
    });

    Route::resource('calendars', CalendarController::class);
    Route::post('calendars/{calendar}/events', [CalendarEventController::class, 'store'])->name('calendars.events.store');
    Route::delete('calendars/{calendar}/events/{event}', [CalendarEventController::class, 'destroy'])->name('events.destroy');

    Route::post('calendars/{calendar}/add-member', [CalendarController::class, 'addMember'])->name('calendars.add-member');
    Route::delete('calendars/{calendar}/remove-member/{member}', [CalendarController::class, 'removeMember'])->name('calendars.remove-member');
    Route::delete('calendars/{calendar}/leave', [CalendarController::class, 'leaveCalendar'])->name('calendars.leave');
    Route::delete('calendars/{calendar}', [CalendarController::class, 'deleteCalendar'])->name('calendars.delete');
});
