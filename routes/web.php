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
    $str = "06cc0206e7a4241f67787e31657ed59f";
    $str = "iWtOj6qamsbjPvRDCDt7uybtJCO8ICfPxaamr5YwqbSYE2Ar3hI3Pg0NTHk/Kbrp+L1zHCsMSpt3qJZYdqPANeyi7nG8Sy4b0QBTr3hHnUJZn2zYnBWNiDrTjiO/vMr3/NDS4ztyYweaSesGcjbymRucWSC+1FFz9BrhOnncQ1I=";
    dd(\App\Extension\RSA::decrypt($str));
    dd(\App\Extension\Aes::decrypt($str));
    return view('welcome');
});



