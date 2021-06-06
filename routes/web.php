<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;

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

/*Route::get('/', function () {
    return view('welcome');
});*/
/*Route::get('/login',' LoginController@show_login_form')->name('login');
Route::post('/login','LoginController@process_login')->name('login');
*/
Route::get('/login',[LoginController::class,"show_login_form"])->name('login');
Route::post('/login',[LoginController::class,"process_login"])->name('login');
Route::get('/register',[LoginController::class,'show_signup_form'])->name('register');
Route::post('/register',[LoginController::class, 'process_signup'])->name('register');
Route::get('/varifyEmailId/{id}',[LoginController::class,'varifyEmailId']);
//Route::get('/login', [WebAdminController::class,"login"]);

Route::namespace('Auth')->group(function () {
    Route::get('/dashboard',[LoginController::class,'viewDashboard'])->name('dashboard');
    Route::post('/logout','LoginController@logout')->name('logout');
    Route::post('/logout','LoginController@logout')->name('logout');
    Route::get('/send-mail-by-event',[LoginController::class,'sendMailByEvent'])->name('send-mail-by-event');
    Route::get('/send-mail-by-queue',[LoginController::class,'sendMailEnqueue'])->name('send-mail-by-queue');

});
