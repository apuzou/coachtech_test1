<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ContactController;
use Laravel\Fortify\Features;

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

Route::get('/', [ContactController::class, 'index'])->name('contact.index');
Route::post('/contact/confirm', [ContactController::class, 'confirm'])->name('contact.confirm');
Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');
Route::get('/contact/thanks', [ContactController::class, 'thanks'])->name('contact.thanks');

// Fortifyのルート
Route::group(['middleware' => config('fortify.middleware', ['web'])], function () {
    $limiter = config('fortify.limiters.login');
    $twoFactorLimiter = config('fortify.limiters.two-factor');

    // ログインルート
    Route::get('/login', function () {
        return view('auth.login');
    })->middleware(['guest:' . config('fortify.guard')])->name('login');

    Route::post('/login', [Laravel\Fortify\Http\Controllers\AuthenticatedSessionController::class, 'store'])
        ->middleware(array_filter([
            'guest:' . config('fortify.guard'),
            $limiter ? 'throttle:' . $limiter : null,
        ]));

    // 登録ルート
    Route::get('/register', function () {
        return view('auth.register');
    })->middleware(['guest:' . config('fortify.guard')])->name('register');

    Route::post('/register', [Laravel\Fortify\Http\Controllers\RegisteredUserController::class, 'store'])
        ->middleware(['guest:' . config('fortify.guard')]);

    // ログアウトルート
    Route::post('/logout', [Laravel\Fortify\Http\Controllers\AuthenticatedSessionController::class, 'destroy'])
        ->name('logout');
});
