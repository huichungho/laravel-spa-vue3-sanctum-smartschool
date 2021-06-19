<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\CustomerController;
use App\Http\Controllers\API\UserController;

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

// Route::get('/', function () {
//     return view('welcome');
// });



// Route::group(['prefix' => 'auth'], function(){
//     Auth::routes();
//     Route::get('email/verify/{id}', 'Auth\VerificationController@verify')->name('verification.verify');
//     Route::get('email/resend', 'Auth\VerificationController@resend')->name('verification.resend');
// });

Route::get('{any}', function () {
    return view('app');
})->where('any', '.*');

Auth::routes(['verify' => true]);

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
