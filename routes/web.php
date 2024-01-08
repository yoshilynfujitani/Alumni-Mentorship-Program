<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\PDCController;


use App\Http\Controllers\ConvoController;
use App\Http\Controllers\MentorController;
use App\Http\Controllers\TicketController;
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
Route::get("/checkuserstatus", [StudentLoginController::class, "checkUserStatus"]);
Route::post("/logout", [StudentLoginController::class, "logout"]);

//Student
Route::post("/addAppointment", [AppointmentController::class, "requestAppointment"]);
Route::get("/getAppointments", [AppointmentController::class, "getAppointments"]);
Route::post("/requestticket", [TicketController::class, "requestTicket"]);
Route::get("/getpiechartdata", [AppointmentController::class, "getPieChartData"]);
Route::get("/getbarchartdata", [AppointmentController::class, "getBarChartData"]);
Route::post("/getconvo", [ConvoController::class, "getChat"]);
Route::post("/sendconvo", [ConvoController::class, "sendChat"]);

//Mentor
Route::post("/mentorsignupAPI", [MentorController::class, "signup"]);
Route::post("/getmentorAPI", [MentorController::class, "getMentors"]);
Route::post("/getmentorstudent", [MentorController::class, "getMentorsStudent"]);
Route::get("/getstudentrequests", [MentorController::class, "getMentorAppointment"]);
Route::post("/verifyrequest", [MentorController::class, "verifyRequest"]);

//PDC
Route::post("/editmentorstatus", [PDCController::class, "updateMentorStatus"]);
Route::get("/gettickets", [TicketController::class, "getTickets"]);
Route::get("/gettickets", [TicketController::class, "getTickets"]);
Route::post("/verifyticket", [TicketController::class, "verifyTicket"]);

//kababaan amin
Route::get('/{vue?}', function(){
    return view('app');
})->where('vue', '[\/\w\.-]*');
