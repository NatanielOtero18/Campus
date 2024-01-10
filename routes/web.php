<?php

use App\Http\Controllers\Activities\ActivitiesController;
use App\Http\Controllers\Admin\AdminClassController;
use App\Http\Controllers\Admin\AdminTicketsController;
use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\Clasroom\ClassroomController;
use App\Http\Controllers\MessagesController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Student\StudentController;
use App\Http\Controllers\Teacher\TeacherController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

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
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
})->name('Home');

Route::middleware('isStudent')->group(function () {
    Route::get('/dashboard',[StudentController::class,'index'])->name('dashboard');
    Route::get('/myClassroom',[StudentController::class,'classroom'])->name('StudentClassroom');
    Route::get('/myActivities',[StudentController::class,'indexActivities'])->name('activities');
    Route::get('/showActivities/{activity:id}',[StudentController::class,'showActivity'])->name('studentShowActivity');
    Route::post('/completeActivity/{activity:id}',[ActivitiesController::class,'completeActivity'])->name('completeActivity');
});




Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

});

Route::middleware('auth')->group(function (){
    Route::get('/sendTicket',[AdminTicketsController::class,'createTicket'])->name('MessageAdmin');
    Route::post('/storeTicket',[AdminTicketsController::class,'storeTicket'])->name('SendTicket');
    Route::get('/threads',[MessagesController::class,'index'])->name('ListThreads');
    Route::get('/showThread/{thread:id}',[MessagesController::class,'show'])->name('ShowThread');
    Route::get('/message/{user:id}',[MessagesController::class,'create'])->name('Message');    
    Route::post('/message/{thread::id?}',[MessagesController::class,'store'])->name('StoreMessage');
    Route::post('/threadUpdate/{thread:id}',[MessagesController::class,'update'])->name('UpdateThread');

    Route::post('/classRoomChat/{classroom:id}',[MessagesController::class,'classroomChat'])->name('SendClasroomMessage');
});


Route::middleware('isAdmin')->group(function () {
    Route::get('/adminTasks', [AdminTicketsController::class, 'tasks'])->name('AdminTasks');
    Route::get('/adminPanel', [AdminUserController::class, 'index'])->name('AdminPanel');

    Route::post('/addStudent', [AdminUserController::class, 'storeStudent'])->name('AddStudent');
    Route::post('/addTeacher', [AdminUserController::class, 'storeTeacher'])->name('AddTeacher');
    Route::patch('/editUser/{user:id}', [AdminUserController::class, 'updateStudent'])->name('UpdateUser');
    Route::patch('/editTeacher/{user:id}', [AdminUserController::class, 'updateTeacher'])->name('UpdateTeacher');


    Route::get('/adminClassrooms', [AdminClassController::class, 'index'])->name('AdminClasrooms');
    Route::post('/addClassroom', [AdminClassController::class, 'store'])->name('AddClassroom');
    Route::get('/classInfo/{classroom:id}', [AdminClassController::class, 'getClassroom'])->name('ClassroomTable');
    Route::patch('/classUpdate/{classroom:id}', [AdminClassController::class, 'updateClassroom'])->name('UpdateClassroom');
    Route::delete('/unassignTeacher/{classroom:id}', [AdminClassController::class, 'unassignTeacher'])->name('UnTeacher');
    Route::patch('/assignTeacher/{classroom:id}', [AdminClassController::class, 'assignTeacher'])->name('AsTeacher');

    Route::get('/adminTickets',[AdminTicketsController::class,'index'])->name('AdminTickets');
    Route::get('/solveTicket/{ticket:id}',[AdminTicketsController::class,'solveTicket'])->name('SolveTicket');
    Route::patch('/solveTicket/{ticket:id}',[AdminTicketsController::class,'setTicketSolved'])->name('SetSolved');
});

Route::middleware('isTeacher')->group(
    function () {
        Route::get('/teacherTasks', [TeacherController::class, 'tasks'])->name('TeacherTasks');
        Route::get('/myClass', [TeacherController::class, 'index'])->name('TeacherClassroom');
        Route::get('/checkActivities/{user:id}', [ActivitiesController::class, 'showActivities'])->name('CheckActivities');
        Route::get('/teacherActivities', [ActivitiesController::class, 'teacherIndex'])->name('TeacherActivities');
        Route::post('/addActivity', [ActivitiesController::class, 'create'])->name('AddActivity');
        Route::patch('/updateActivity/{activity:id}', [ActivitiesController::class, 'update'])->name('UpdateAcitvity');
        Route::patch('/assingActivity/{user:id}', [TeacherController::class, 'assingActivity'])->name('AssingActivity');
        Route::patch('/assingToAll/{classroom:id}', [TeacherController::class, 'assingAll'])->name('AssingToAll');
        Route::get('/activity/{activity}/user/{user}', [ActivitiesController::class, 'correct'])->name('NeedsCorrection');
        Route::patch('/correctActivity/{activity:id}', [ActivitiesController::class, 'storeCorrection'])->name('CorrectActivity');
    }
);
require __DIR__ . '/auth.php';
