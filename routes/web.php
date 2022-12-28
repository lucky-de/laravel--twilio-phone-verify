<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
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
Auth::routes(['verify' => true]);

Route::get('/home', 'App\Http\Controllers\HomeController@index')->name('home')->middleware('verified');
Route::get('/', function () {
    return view('auth.login');
});
Route::get('/register', function () {
    return view('auth.register');
})->name('register');

Route::get('/verify', function () {
    return view('auth.verify');
})->name('verify');

Route::get('/phone/verify', function () {
    return view('auth.phoneverify');
})->name('phoneverify');

Route::post('/phone/register', 'App\Http\Controllers\Auth\PhoneRegisterController@create');
Route::post('/phone/login', 'App\Http\Controllers\Auth\PhoneLoginController@create')->name('phonelogin');
Route::post('/verify', 'App\Http\Controllers\Auth\PhoneRegisterController@verify')->name('verify');

