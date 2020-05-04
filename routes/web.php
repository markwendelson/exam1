<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return redirect('login');
});

Route::get('/logout', 'Custom\LoginController@destroy')->name('logout');
Route::get('/login', 'Custom\LoginController@index')->name('getLogin');
Route::post('/login', 'Custom\LoginController@authenticate')->name('postLogin');

Route::post('/register', 'Custom\RegisterController@store')->name('postRegister');

Route::post('/validate-email', 'Auth\RegisterController@validateEmail')->name('validate.email');

Route::get('/users', 'HomeController@users')->name('users');
Route::get('/profile', 'HomeController@profile')->name('profile');
Route::post('/profile', 'HomeController@updateProfile')->name('profile.update');
Route::post('/changepassword', 'HomeController@changePassword')->name('profile.changepassword');
