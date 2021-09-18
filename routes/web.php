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
    return view('welcome');
});
Route::get('reset', function () {
    Artisan::call('route:clear');
    Artisan::call('cache:clear');
    Artisan::call('config:clear');
    Artisan::call('config:cache');
    Artisan::call('storage:link');
    // Artisan::call('passport:install');
});
Route::get('migrate', function () {
    Artisan::call('migrate:fresh');  
    return "migrated"; 
});

Route::get('seed', function () {
    Artisan::call('db:seed');   
});

Route::get('candidates/generate-pdf', 'App\Http\Controllers\API\MailController@openPDF');
Route::get('resume', 'App\Http\Controllers\API\MailController@pdfGenerator');