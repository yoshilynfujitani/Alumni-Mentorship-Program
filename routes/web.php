<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\PDCController;


use App\Http\Controllers\ConvoController;
use App\Http\Controllers\EmailController;
use App\Http\Controllers\FieldController;
use App\Http\Controllers\AlumniController;
use App\Http\Controllers\MentorController;
use App\Http\Controllers\RatingController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\ScheduleController;
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
//Mail
Route::post('sendEmail', [EmailController::class, 'sendEmail']);
Route::post('sendEmailAppointment', [EmailController::class, 'sendEmailAppointment']);

//Student Auth
Route::post("/login", [StudentLoginController::class, "login"]);
Route::post("/signup", [StudentSignUpController::class, "signup"]);
Route::get("/checkUser", [StudentLoginController::class, "checkLogin"]);
Route::get("/checkuserstatus", [StudentLoginController::class, "checkUserStatus"]);
Route::post("/logout", [StudentLoginController::class, "logout"]);
Route::get('/user/update-last-active', [StudentLoginController::class, 'updateLastActive']);

Route::get('/user/{id}/online', [StudentLoginController::class, 'isOnline']);
Route::post('/downloadfile', [ConvoController::class, 'downloadFile']);



//Student
Route::post("/addAppointment", [AppointmentController::class, "requestAppointment"]);
Route::post("/getOngoingAppointments", [AppointmentController::class, "getOngoingAppointments"]);
Route::get("/getCountTotalAppointments", [AppointmentController::class, "getCountTotalAppointments"]);
Route::get("/getAppointments", [AppointmentController::class, "getAppointments"]);
Route::post("/requestticket", [TicketController::class, "requestTicket"]);
Route::post("/getpiechartdata", [AppointmentController::class, "getPieChartData"]);
Route::post("/getbarchartdata", [AppointmentController::class, "getBarChartData"]);
Route::post("/getconvo", [ConvoController::class, "getChat"]);
Route::post("/sendconvo", [ConvoController::class, "sendChat"]);
Route::post("/sendfeedback", [FeedbackController::class, "sendFeedback"]);
Route::get("/getTicketStatus", [StudentLoginController::class, "getUserTicketStatus"]);
Route::get("/getAllowToAppointStatus", [StudentLoginController::class, "getUserAllowToAppointStatus"]);
Route::post("/getConvoId", [ConvoController::class, "getConvoId"]);
Route::post("/updateUserRating", [RatingController::class, "calculateRating"]);
Route::post("/searchConvo", [ConvoController::class, "searchConvo"]);
Route::post("/searchMentor", [MentorController::class, "searchMentor"]);
Route::post("/searchAlumni", [AlumniController::class, "searchAlumni"]);

//Mentor
Route::post("/mentorsignupAPI", [MentorController::class, "signup"]);
Route::post("/getmentorAPI", [MentorController::class, "getMentors"]);
Route::post("/getmentorstudent", [MentorController::class, "getMentorsStudent"]);
Route::post("/updatefield", [MentorController::class, "updateField"]);
Route::get("/getfield", [MentorController::class, "getField"]);
Route::get("/getstudentrequests", [MentorController::class, "getMentorAppointment"]);
Route::post("/verifyrequest", [MentorController::class, "verifyRequest"]);
Route::post("/getrecentfeedback", [FeedbackController::class, "getRecentMentorFeedback"]);
Route::post("/getrecenttickets", [TicketController::class, "getRecentStudentTicketRequests"]);
Route::post("/requestReschedule", [AppointmentController::class, "requestReschedule"]);
Route::post("/getAppointment", [AppointmentController::class, "getAppointment"]);
Route::post("/getFeedback", [FeedbackController::class, "getFeedback"]);
Route::post("/setSchedule", [ScheduleController::class, "setSchedule"]);
Route::post("/getLatestSchedule", [ScheduleController::class, "getLatestSchedule"]);
Route::post("/getAllSchedule", [ScheduleController::class, "getAllSchedule"]);
Route::post("/sendrequest", [MentorController::class, "getRequestToBeMentor"]);
Route::post("/checkrequest", [MentorController::class, "checkExisitingMentorRequest"]);


//PDC
Route::post("/editmentorstatus", [PDCController::class, "updateMentorStatus"]);
Route::get("/gettickets", [TicketController::class, "getTickets"]);
Route::get("/getticketsofstudent", [TicketController::class, "getTicketsOfStudent"]);
Route::get("/getalumni", [AlumniController::class, "getAlumni"]);
Route::post("/verifyticket", [TicketController::class, "verifyTicket"]);
Route::post("/searchticket", [TicketController::class, "searchTicket"]);
Route::post("/searchrequest", [MentorController::class, "searchRequest"]);
Route::post("/searchuser", [PDCController::class, "searchUser"]);
Route::post("/assignappointment", [PDCController::class, "assignStudentToMentor"]);
Route::post("/createpdc", [PDCController::class, "createPDCAccount"]);
Route::post("/getpdc", [PDCController::class, "getPDCAccounts"]);
Route::get("/getcolleges", [PDCController::class, "getColleges"]);
Route::post("/resetpdcpassword", [PDCController::class, "resetPDCPassword"]);
Route::post("/resetpassword", [PDCController::class, "resetpassword"]);
Route::get("/getmentorapplications", [MentorController::class, "getMentorApplications"]);
Route::post("/createfield", [FieldController::class, "createField"]);
Route::post("/editfield", [FieldController::class, "editField"]);
Route::post("/getfields", [FieldController::class, "getFields"]);
Route::post("/deletefield", [FieldController::class, "deleteField"]);
Route::post("/verifyinvite", [AlumniController::class, "VerifyInvite"]);





//kababaan amin
Route::get('/{vue?}', function(){
    return view('app');
})->where('vue', '[\/\w\.-]*');
