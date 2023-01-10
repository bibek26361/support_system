<?php

use App\Http\Controllers\Auth\ForgotPasswordController;
// use Illuminate\Routing\Route;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

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

// Route::get('home', function () {
//     return view('front.pages.index');
// });

// Route::get('about', function () {
//     return view('front.pages.about');
// });

// Route::get('frontservices', function () {
//     return view('front.pages.services');
// });

// Route::get('contact', function () {
//     return view('front.pages.contact');
// });

// Route::get('customers', function () {
//     return view('front.pages.customer');
// });

// Route::get('aaa', function () {
//     return view('back.main');
// });
// Route::get('/index','HomeController@index')->name('index'); 
// Route::get('/about','HomeController@about')->name('about'); 
// Route::get('/frontservices','HomeController@service')->name('frontservices'); 

// backend
Route::get('/', 'DashboardController@index')->name('dashboard.index');
Route::get('dashboard/count', 'DashboardController@count')->name('dashboard.count');

Route::get('notifications/device-tokens', 'NotificationController@getDeviceTokens')->name('notifications.getDeviceTokens');
Route::resource('notifications', 'NotificationController');
Route::post('notifications/createNotification', 'NotificationController@createNotification')->name('notifications.createNotification');
Route::get('notifications/resend/{id}', 'NotificationController@resendNotification')->name('notifications.resend');
Route::get('notifications/send-to-all/{id}', 'NotificationController@sendNotificationToAll')->name('notifications.send-to-all');

Route::resource('user', 'UserController');
// Route::get('profile','UserController@myProfile')->name('user.profile');
Route::get('user/department-wise/{departmentId}', ['uses' => 'UserController@departmentWiseUser', 'as' => 'user.department-wise']);



Route::resource('ticket', 'TicketController');
Route::patch('ticket/updateStatus/{id}', ['uses' => 'TicketController@updateStatus', 'as' => 'ticket.updateStatus']);
Route::get('ticket/fetchTickets', ['uses' => 'TicketController@fetchTickets', 'as' => 'ticket.fetchTickets']);
Route::patch('ticket/updateStatus/{id}', ['uses' => 'TicketController@updateStatus', 'as' => 'ticket.updateStatus']);

Route::get('ticket/state-solved/{id}', 'TicketController@changeStateToSolved')->name('ticket.changeStateToSolved');

Route::get('ticket/assign/transfer/{id}', 'TicketController@transfer')->name('ticket.transfer');
Route::patch('ticket/state-transfer/{id}', 'TicketController@changeStateToTransfer')->name('ticket.changeStateToTransfer');
Route::get('ticket/state-survey/{id}', 'TicketController@changeStateToSurvey')->name('ticket.changeStateToSurvey');
Route::post('ticket/store-image', 'TicketController@storeImage')->name('ticket.store-image');

Route::prefix('tickets')->group(function () {
    Route::get('receive/{id}', 'TicketController@receiveTicket')->name('tickets.receive');
    Route::get('confirmation-pending/{id}', 'TicketController@confirmationPendingTicket')->name('tickets.confirmationPending');
    Route::get('checktime/{id}', 'TicketController@checktimeTicket')->name('tickets.checktime');
    Route::get('ready-to-deliver/{id}', 'TicketController@readyToDeliverTicket')->name('tickets.readyToDeliver');
    Route::get('deliver/{id}', 'TicketController@deliverTicket')->name('tickets.deliver');
    Route::get('cancel/{id}', 'TicketController@cancelTicket')->name('tickets.cancel');
    Route::get('opened', ['uses' => 'TicketController@getOpenedTickets', 'as' => 'tickets.opened']);
    Route::get('assigned', ['uses' => 'TicketController@getAssignedTickets', 'as' => 'tickets.assigned']);
    Route::get('transfered', ['uses' => 'TicketController@getTransferedTickets', 'as' => 'tickets.transfered']);
    Route::get('closed', ['uses' => 'TicketController@getClosedTickets', 'as' => 'tickets.closed']);
    Route::prefix('remarks')->group(function () {
        Route::post('/', 'RemarkController@getTicketWiseRemarks')->name('tickets.remarks');
        Route::post('add', 'RemarkController@addTicketRemark')->name('tickets.addRemark');
    });
});

//department
Route::resource('department', 'DepartmentController');
// Route::get('department.destory', 'DepartmentController@index')->name('department');

//organization
Route::resource('organization', 'OrganizationController');
Route::get('organization/generate-api-key/{id}', 'OrganizationController@generateApiKey')->name('organization.generate-api-key');
Route::get('organization/tickets/{organizationId}', 'TicketController@getOrganizationWiseTickets')->name('organization.tickets');
Route::resource('organizationtype', 'OrganizationTypeController');
Route::resource('problemtype', 'ProblemTypeController');
Route::resource('problemcategory', 'ProblemCategoryController');
Route::get('problemcategory/problemtype-wise/{problemTypeId}', ['uses' => 'ProblemCategoryController@typeWiseCategory', 'as' => 'problemcategory.problemtype-wise']);

Route::resource('surveys', 'SurveyController');

//User Profile
Route::resource('profile', 'ProfileController');
//  Route::get('profile.create', 'ProfileController@create')->name('profile.create');
//  Route::get('profile.edit', 'ProfileController@edit')->name('profile.edit');


Auth::routes();

//forgot password
// Route::get('forget-password', [ForgotPasswordController::class, 'showForgetPasswordForm'])->name('forget.password.get');
// Route::post('forget-password', [ForgotPasswordController::class, 'submitForgetPasswordForm'])->name('forget.password.post'); 
// Route::get('reset-password/{token}', [ForgotPasswordController::class, 'showResetPasswordForm'])->name('reset.password.get');
// Route::post('reset-password', [ForgotPasswordController::class, 'submitResetPasswordForm'])->name('reset.password.post');

Route::get('forgot-password', 'Auth\ForgotPasswordController@forgotPassword')->name('user.forgot-password');
Route::post('forgot-password', 'Auth\ForgotPasswordController@forgotPasswordProcess')->name('user.forgot-password');
Route::get('verify', 'Auth\ForgotPasswordController@verify')->name('user.verify');
Route::post('verify', 'Auth\ForgotPasswordController@verifyProcess')->name('user.verify-process');
// Route::post('change-password','Auth\ForgotPasswordController@changePasswordProcess')->name('user.change-password');

Route::get('/change-password', 'Auth\ChangePasswordController@index')->name('change-password');
Route::post('/change-password', 'Auth\ChangePasswordController@store')->name('change.password');


Route::get('logout', '\App\Http\Controllers\Auth\LoginController@logout');

//task
Route::resource('task', 'TaskController');
Route::post('task/store-image', 'TaskController@storeImage')->name('task.store-image');
Route::prefix('tasks')->group(function () {
    Route::get('new', ['uses' => 'TaskController@getNewTasks', 'as' => 'tasks.new']);
    Route::get('inprogress', ['uses' => 'TaskController@getInProgressTasks', 'as' => 'tasks.inprogress']);
    Route::get('completed', ['uses' => 'TaskController@getCompletedTasks', 'as' => 'tasks.completed']);
});

Route::resource('producttypes', 'ProductTypeController');
Route::resource('products', 'ProductController');
Route::prefix('log')->group(function () {
    Route::get('organization', 'LogController@getOrganizationLog')->name('log.organization');
    Route::get('system', 'LogController@getSystemLog')->name('log.system');
});
