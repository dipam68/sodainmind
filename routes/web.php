<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\PlansController;
use App\Http\Controllers\SubscriptionsController;
use App\Http\Controllers\AdminController;

// LOGIN & REGISTER
Route::post('/auth/login', [UsersController::class, 'getLogin']);
Route::get('/auth/login', [UsersController::class, 'showLoginForm']);
Route::get('/auth/register', [UsersController::class, 'showRegisterForm']);
Route::post('/auth/post-register', [UsersController::class, 'postRegister']);
Route::get('/auth/email-activation/{userId}', [UsersController::class, 'sendActivationEmail']);
Route::get('/activate-this/{email}', [UsersController::class, 'activateUser']);
Route::post('/auth/direct-join', [UsersController::class, 'directPayment']);
Route::post('/auth/pay', [UsersController::class, 'getPayment']);
Route::view('/confirm','pages.auth.confirm');

//LOGOUT
Route::get('auth/logout', function(){
    session()->flush();
    return redirect('/');
});

//PUBLIC PAGES
Route::get('/', [HomeController::class, 'index']);
Route::get('/users',[UsersController::class, 'getUsers']);
Route::get('/plan/{id}',[SubscriptionsController::class, 'plan']);
Route::get('/subscription',[SubscriptionsController::class, 'index']);

//ADMIN PAGES
Route::get('/admin', [AdminController::class, 'index']);
Route::get('/admin/settings', [AdminController::class, 'settings'])->name('admin-settings');
Route::post('/admin/new-plan', [AdminController::class, 'newPlan']);
Route::post('/admin/set-trial', [AdminController::class, 'setTrialDay']);
Route::get('/admin/get-trial', [AdminController::class, 'getTrialDay']);
Route::get('/admin/get-plan/{id}', [PlansController::class, 'getPlanData']);
Route::delete('/admin/delete-plan/{id}', [PlansController::class, 'deletePlanData']);

//USER DASHBOARD
Route::get('/user-dashboard', [UsersController::class, 'userDashboard']);
Route::get('/user-dashboard/settings', [UsersController::class, 'settings'])->name('user-settings');


//ACTIONS
Route::post('/pay',[SubscriptionsController::class, 'getPayment']);
Route::post('/pay-upgrade',[SubscriptionsController::class, 'upgradePlan']);
Route::put('/cancel-plan',[SubscriptionsController::class, 'cancelPlan']);