<?php

use Illuminate\Http\Request;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('login', 'Api\AuthController@login');
Route::prefix('password')->group(function () {
    Route::post('forgot', 'Api\UserController@forgotPassword');
});
Route::prefix('otp')->group(function () {
    Route::post('verify', 'Api\UserController@verifyOtp');
});

Route::get('all-info', 'Api\AllInfoController@allInfo');
Route::get('departments/all', 'Api\DepartmentController@all');
Route::get('problems/types', 'Api\ProblemController@type');
Route::get('problems/categories', 'Api\ProblemController@category');

Route::prefix('notifications')->group(function () {
    Route::get('/', 'Api\UserNotificationController@notifications');
    Route::get('tickets', 'Api\UserNotificationController@getTicketNotifications');
    Route::get('tasks', 'Api\UserNotificationController@getTaskNotifications');
    Route::get('all', 'Api\UserNotificationController@allNotifications');
});

Route::middleware('auth:api')->group(function () {
    Route::get('dashboard', 'Api\DashboardController@getDashboardData');
    Route::prefix('password')->group(function () {
        Route::post('reset', 'Api\UserController@resetPassword');
        Route::post('change', 'Api\UserController@changePassword');
    });
    Route::prefix('organizations')->group(function () {
        Route::get('types', 'Api\OrganizationController@getOrganizationTypeData');
        Route::post('create', 'Api\OrganizationController@create');
        Route::get('all', 'Api\OrganizationController@allOrganizations');
        Route::post('tickets', 'Api\OrganizationController@getTicketData');
        Route::prefix('products')->group(function () {
            Route::post('all', 'Api\OrganizationController@getUsedProductData');
            Route::post('add', 'Api\OrganizationController@addProducts');
        });
    });

    Route::prefix('products')->group(function () {
        Route::get('types', 'Api\ProductController@getProductTypeData');
        Route::post('create', 'Api\ProductController@create');
        Route::get('all', 'Api\ProductController@getAllProductData');
    });

    Route::prefix('users')->group(function () {
        Route::post('create', 'Api\UserController@create');
        Route::get('all', 'Api\UserController@getAllUserData');
        Route::post('tickets', 'Api\UserController@getTicketData');
        Route::post('tasks', 'Api\UserController@getTaskData');
    });

    Route::prefix('profile')->group(function () {
        Route::post('update', 'Api\ProfileController@updateProfile');
        Route::post('change-image', 'Api\ProfileController@changeProfilePicture');
    });
    Route::prefix('tickets')->group(function () {
        Route::post('create', 'Api\TicketController@create');
        Route::post('transfer', 'Api\TicketController@transfer');
        Route::post('solve', 'Api\TicketController@solve');
        Route::post('all', 'Api\TicketController@all');
        Route::post('created', 'Api\TicketController@created');
        Route::post('transfered', 'Api\TicketController@transfered');
        Route::post('opened', 'Api\TicketController@opened');
        Route::post('assigned', 'Api\TicketController@assigned');
        Route::post('closed', 'Api\TicketController@closed');
        Route::post('search', 'Api\TicketController@search');
        Route::prefix('remarks')->group(function () {
            Route::post('add', 'Api\RemarkController@addTicketRemark');
            Route::post('all', 'Api\RemarkController@getTicketWiseRemarks');
        });
    });
    Route::prefix('surveys')->group(function () {
        Route::post('create/{is_quick_survey?}', 'Api\SurveyController@create');
        Route::get('all', 'Api\SurveyController@all');
    });
    Route::prefix('tasks')->group(function () {
        Route::post('create', 'Api\TaskController@createTask');
        Route::post('details', 'Api\TaskController@getTaskDetails');
        Route::get('all', 'Api\TaskController@getAllTasks');
        Route::post('inprogress', 'Api\TaskController@inProgressTask');
        Route::post('complete', 'Api\TaskController@completeTask');
        Route::prefix('filter')->group(function () {
            Route::post('all', 'Api\TaskController@filterAllTasks');
            Route::post('new', 'Api\TaskController@filterNewTasks');
            Route::post('inprogress', 'Api\TaskController@filterInProgressTasks');
            Route::post('completed', 'Api\TaskController@filterCompletedTasks');
        });
        Route::prefix('remarks')->group(function () {
            Route::post('add', 'Api\RemarkController@addTaskRemark');
            Route::post('all', 'Api\RemarkController@getTaskWiseRemarks');
        });
    });

    Route::prefix('logs')->group(function () {
        Route::post('system', 'Api\LogController@getSystemLogData');
        Route::post('organization', 'Api\LogController@getOrganizationLogData');
    });
});

require_once 'smartkarobar/api.php';
require_once 'restroms/api.php';
require_once 'upasthiti/api.php';
