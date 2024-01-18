<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\CurriculumsController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\OpenAreaController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\ServiceAdminController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/
Route::group(['prefix' => 'categories'], function ()
{

    Route::post('/get-parent-categories', [CategoriesController::class, 'getParentCategories']);
    Route::post('/get-all-category-data', [CategoriesController::class, 'getAllCategoryData']);
    Route::post('/store', [CategoriesController::class, 'store']);
    Route::post('/show', [CategoriesController::class, 'show']);
    Route::post('/update', [CategoriesController::class, 'update']);
    Route::post('/destroy', [CategoriesController::class, 'destroy']);
    Route::post('/recover', [CategoriesController::class, 'recover']);
    Route::get('/get-directory-path', [CategoriesController::class, 'getDirectoryPath']);
    Route::get('/get-active-categories', [CategoriesController::class, 'getActiveCategories']);

});

Route::group(['prefix' => 'curriculums'], function ()
{

    Route::post('/store', [CurriculumsController::class, 'store']);
    Route::post('/show', [CurriculumsController::class, 'show']);
    Route::post('/update', [CurriculumsController::class, 'update']);
    Route::post('/destroy', [CurriculumsController::class, 'destroy']);
    Route::post('/recover', [CurriculumsController::class, 'recover']);
    Route::post('/get-all-curriculum-data', [CurriculumsController::class, 'getAllCurriculumData']);
    Route::get('/get-directory-path', [CurriculumsController::class, 'getDirectoryPath']);
    Route::post('/take', [CurriculumsController::class, 'take']);
    Route::post('/get-one-taking-curriculum', [CurriculumsController::class, 'getOneTakingCurriculum']);
    Route::post('/get-all-taking-curriculum-data', [CurriculumsController::class, 'getAllTakingCurriculumData']);
    Route::post('/get-certificate', [CurriculumsController::class, 'getCertificate']);
    Route::post('/request-certificate', [CurriculumsController::class, 'requestCertificate']);
    Route::post('/update-certificate', [CurriculumsController::class, 'updateCertificate']);
    Route::post('/get-required-curriculum-status', [CurriculumsController::class, 'getRequiredCurriculumStatus']);
    Route::post('/get-request-certificate', [CurriculumsController::class, 'getRequestCertificate']);
    Route::post('/get-user-achievement-info', [CurriculumsController::class, 'getUserAchievementInfo']);

});

Route::post('/contact', [OpenAreaController::class, 'contact']);
Route::group(['prefix' => 'user'], function()
{
    Route::post('/login', [LoginController::class, 'user_login']);
    Route::post('/logout', [LoginController::class, 'user_logout']);
    Route::post('/password/reset', [ForgotPasswordController::class, 'user_password_reset']);
    Route::post('/registration', [RegisterController::class, 'registration']);
    Route::post('/get_by_token', [LoginController::class, 'get_user_by_token']);
    Route::post('/withdrawal', [LoginController::class, 'withdrawal']);
    Route::post('/check-user-auth', [LoginController::class, 'checkUserAuth']);
    Route::post('/get-all-user-data', [UsersController::class, 'getAllUserData']);
    Route::post('/store', [UsersController::class, 'store']);
    Route::post('/show', [UsersController::class, 'show']);
    Route::post('/update', [UsersController::class, 'update']);
    Route::post('/destroy', [UsersController::class, 'destroy']);
    Route::post('/recover', [UsersController::class, 'recover']);
    Route::post('/get-address', [UsersController::class, 'getAddress']);
});
Route::group(['prefix' => 'service-admin'], function()
{
    Route::post('/login', [LoginController::class, 'admin_login']);
    Route::post('/logout', [LoginController::class, 'admin_logout']);
    Route::post('/password/reset', [ForgotPasswordController::class, 'admin_password_reset']);
    Route::post('/get_by_token', [LoginController::class, 'get_admin_by_token']);
    Route::post('/get-all-admin-data', [ServiceAdminController::class, 'getAllAdminData']);
    Route::post('/store', [ServiceAdminController::class, 'store']);
    Route::post('/show', [ServiceAdminController::class, 'show']);
    Route::post('/update', [ServiceAdminController::class, 'update']);
    Route::post('/destroy', [ServiceAdminController::class, 'destroy']);
    Route::post('/recover', [ServiceAdminController::class, 'recover']);
});
