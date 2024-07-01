<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HospitalController;
use App\Http\Controllers\PatientController;

Route::get('/', [AuthController::class, 'login'])->name('login');

Route::post('/login', [AuthController::class, 'authenticate'])->name('auth');

Route::get('/dashboard', function () {
    return view('layouts/master');
})->middleware(['auth']);

Route::group(['middleware' => 'auth'], function () {
    Route::get('/hospitals', [HospitalController::class, 'index'])->name('hospitals');
    Route::post('/hospitals/paginate', [HospitalController::class, 'paginate'])->name('hospitals.paginate');

    Route::post('/hospitals/store', [HospitalController::class, 'store'])->name('hospitals.store');
    Route::get('/hospitals/show/{id}', [HospitalController::class, 'show'])->name('hospitals.show');
    Route::put('/hospitals/update/{id}', [HospitalController::class, 'update'])->name('hospitals.update');
    Route::delete('/hospitals/delete/{id}', [HospitalController::class, 'destroy'])->name('hospitals.delete');

    Route::get('/patients', [PatientController::class, 'index'])->name('patients');
    Route::post('/patients/paginate', [PatientController::class, 'paginate'])->name('patients.paginate');

    Route::post('/patients/store', [PatientController::class, 'store'])->name('patients.store');
    Route::get('/patients/show/{id}', [PatientController::class, 'show'])->name('patients.show');
    Route::put('/patients/update/{id}', [PatientController::class, 'update'])->name('patients.update');
    Route::delete('/patients/delete/{id}', [PatientController::class, 'destroy'])->name('patients.delete');

});

Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
