<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\AttendanceController;
use App\Http\Controllers\Api\ReportManagerController;
use App\Http\Controllers\Api\HrExecutiveReportController;
use App\Http\Controllers\Api\SalesExecutiveReportController;
use App\Http\Controllers\Api\HolidayController;
use App\Http\Controllers\Api\LeaveController;
use App\Http\Controllers\Api\EmployeeController;
use App\Http\Controllers\Api\NoticeController;
use App\Http\Controllers\Api\Refferencecontroller;
use App\Http\Controllers\Api\MessagesController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

Route::post('/login', [AuthController::class, 'login']);
Route::post('/refresh-token', [AuthController::class, 'refreshToken']);
Route::post('/employees', [EmployeeController::class, 'store']);
Route::middleware('auth:sanctum')->group(function(){

    // Auth
    Route::get('/profile', [AuthController::class, 'profile']);
    Route::post('/logout', [AuthController::class, 'logout']);

    // Attendance
    Route::prefix('attendance')->group(function () {
        Route::get('/attendances', [AttendanceController::class, 'index']);
        Route::get('/today', [AttendanceController::class, 'today']);
        Route::post('/submit', [AttendanceController::class, 'submit']);
    });

    // Reports
    Route::prefix('report')->group(function () {
        Route::get('/report-list', [ReportManagerController::class, 'reportList']);
        Route::post('/report-create', [ReportManagerController::class, 'reportCreate']);
    });

    Route::prefix('hr-executive')->group(function () {
        Route::get('/report-list', [HrExecutiveReportController::class, 'reportList']);
        Route::post('/report-create', [HrExecutiveReportController::class, 'reportCreate']);
    });

    Route::prefix('sales-executive')->group(function () {
        Route::get('/report-list', [SalesExecutiveReportController::class, 'reportList']);
        Route::post('/report-create', [SalesExecutiveReportController::class, 'reportCreate']);
    });

    // Holiday
    Route::get('/holiday', [HolidayController::class, 'index']);

    // Leaves (REST fixed)
    Route::get('/leaves', [LeaveController::class, 'index']);
    Route::post('/leaves', [LeaveController::class, 'store']);

    // Employees
    Route::get('/employees', [EmployeeController::class, 'index']);
    


    Route::get('/employees/{id}', [EmployeeController::class, 'show']);     
    Route::get('/employees/{id}/edit', [EmployeeController::class, 'edit']); 
    Route::put('/employees/{id}', [EmployeeController::class, 'update']);   
    Route::post('/employees/{id}/update', [EmployeeController::class, 'update']); 


    // Notices
    Route::get('/notices', [NoticeController::class, 'index']);

    
    Route::get('/refference', [Refferencecontroller::class, 'index']);
    Route::post('/refference', [Refferencecontroller::class, 'store']);

     // Messages
    Route::get('/messages', [MessagesController::class, 'index']);
    Route::get('/messages/{id}', [MessagesController::class, 'chat']);
    Route::post('/messages', [MessagesController::class, 'store']); 
    Route::post('/message-file', [MessagesController::class, 'uploadFile']);

});