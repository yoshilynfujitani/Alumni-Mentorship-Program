<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\MentorController;


use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\StudentLoginController;
use App\Http\Controllers\StudentSignUpController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
//     return view('app');
// });

//Student Auth
Route::post("/login", [StudentLoginController::class, "login"]);
Route::post("/signup", [StudentSignUpController::class, "signup"]);
Route::get("/checkUser", [StudentLoginController::class, "checkLogin"]);
Route::post("/logout", [StudentLoginController::class, "logout"]);

//Appointments
Route::post("/addAppointment", [AppointmentController::class, "requestAppointment"]);
Route::get("/getAppointments", [AppointmentController::class, "getAppointments"]);

//Mentor
Route::post("/mentorsignupAPI", [MentorController::class, "signup"]);
Route::get("/getmentorAPI", [MentorController::class, "getMentors"]);

//kababaan amin
Route::get('/{vue?}', function(){
    return view('app');
})->where('vue', '[\/\w\.-]*');
