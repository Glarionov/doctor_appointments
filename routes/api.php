<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

//  В реальности это делалось бы через apiResources, но раз у нас только store-запросы, сделаю так
Route::post('/doctors', [\App\Http\Controllers\DoctorController::class, 'store'])->name('doctor.create');
Route::post('/patients', [\App\Http\Controllers\PatientController::class, 'store'])->name('patient.create');
Route::post('/appointments', [\App\Http\Controllers\AppointmentsController::class, 'store'])->name('appointment.create');
Route::get('/appointments', [\App\Http\Controllers\AppointmentsController::class, 'index'])->name('appointment.index');
