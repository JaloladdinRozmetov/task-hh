<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmployeeController;

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



Auth::routes(['register'=>false]);
Route::middleware(['auth'])->group(function () {
    Route::get('/',function (){
        return view('home');
    });
    Route::get('employees',[App\Http\Controllers\EmployeeController::class,'index'])->name('employees.index');
    Route::get('employees/create',[App\Http\Controllers\EmployeeController::class,'create'])->name('employees.create');
    Route::post('employees',[App\Http\Controllers\EmployeeController::class,'store'])->name('employees.store');
    Route::get('employees/{id}',[App\Http\Controllers\EmployeeController::class,'show'])->name('employees.show');
    Route::get('employees/{id}/edit',[App\Http\Controllers\EmployeeController::class,'edit'])->name('employees.edit');
    Route::post('employees/{id}',[App\Http\Controllers\EmployeeController::class,'destroy'])->name('employees.destroy');
    Route::post('employees/{id}/update',[App\Http\Controllers\EmployeeController::class,'update'])->name('employees.update');



    Route::get('company',[App\Http\Controllers\CompanyController::class,'index'])->name('company.index');
    Route::get('company/create',[App\Http\Controllers\CompanyController::class,'create'])->name('company.create');
    Route::post('company',[App\Http\Controllers\CompanyController::class,'store'])->name('company.store');
    Route::get('company/{id}',[App\Http\Controllers\CompanyController::class,'show'])->name('company.show');
    Route::get('company/{id}/edit',[App\Http\Controllers\CompanyController::class,'edit'])->name('company.edit');
    Route::post('company/{id}',[App\Http\Controllers\CompanyController::class,'destroy'])->name('company.destroy');
    Route::post('company/{id}/update',[App\Http\Controllers\CompanyController::class,'update'])->name('company.update');

});

