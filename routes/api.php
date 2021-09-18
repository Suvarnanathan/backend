<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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
Route::get('/unauthorized', function () {
    return response()->json(["Please login to system","Un Authenticated"], 401);
})->name('unauthorized');

Route::namespace('App\Http\Controllers\API')->group(function () {
    Route::post('register', 'RegisterController@register');
    Route::post('login', 'RegisterController@login');
    Route::group(['middleware' => ['auth:api']], function () {
        //change password
        Route::post('change-password', 'RegisterController@changePassword');
        //logout
        Route::post('logout', 'RegisterController@logout')->name('logout');
        //jobCategories routes 
        Route::apiResource('job-categories', 'JobCategoryController');
        //country route
        Route::get('countries','CountryController@index');
        //job type
        Route::get('job-types','JobTypeController@index');
        //jobSubcategories routes
        Route::apiResource('job-sub-categories','JobSubCategoryController');
        Route::get('job-sub-categories/job-category/{jobCategoryId}','JobSubCategoryController@getJobSubCategoriesByJobCategoryId');
        //skills
        Route::apiResource('skills','SkillController');
    });

//////////////////////////////////////////////////////////////////////////////
    // Route::group(['middleware' => ['auth:api', 'role:admin']], function () {
///////////////////////////////////////////////////////////////////////////////

    Route::group(['middleware' => ['auth:api']], function () {
        Route::get('users/{roleName}', 'UsersManagementController@getUsersbyRole');
        //certificate routes
        Route::apiResource('certificates', 'CertificateController');
        //certificateImages routes
        Route::post('certificate-images/{certificateId}', 'CertificateImageController@upload');
        //get certificate image by certificate id
        Route::get('certificate-images/certificate/{certificateId}', 'CertificateImageController@show');
        //get certificate details by user id
        Route::get('certificates/user/{userId}', 'CertificateController@getCertificateByUserId');
        Route::apiResource('certificate-images', 'CertificateImageController');
        Route::post('user/{roleName}/search', 'UsersManagementController@search');
        Route::get('users', 'UsersManagementController@index');
        //personalinfo routes 
        Route::apiResource('personal-infos', 'PersonalInfoController');
        Route::get('personal-infos/user/{id}', 'PersonalInfoController@getPersonalInfoByUserId');
        Route::put('personal-infos/user/{id}', 'PersonalInfoController@updatAboutByUserId');
        Route::post('profile-images/{personalInfoId}', 'profileImageController@store');

        //profile image routes

        //education routes 
        Route::apiResource('educations', 'EducationController');
        Route::get('educations/user/{id}', 'EducationController@getEducationByUserId');

        //license routes 
        Route::apiResource('licenses', 'LicenseController');
        Route::delete('licenses/{licenseId}/delete','LicenseController@destroyLicense');
        //license image routes 
        Route::apiResource('licenses/images', 'LicenseController');
        //get license image by license id
        Route::post('licenses/{licenseId}/image', 'LicenseController@upload');
        Route::get('licenses/{licenseId}/image', 'LicenseController@show');
        //get license details by user id
        Route::get('licenses/user/{userId}', 'LicenseController@getLicenseByUserId');

        //job experience routes
        Route::apiResource('job-experiences','JobExperienceController');
        Route::get('job-experiences/user/{userId}','JobExperienceController@getJobExperiencesByUserId');
       

        //skills
        Route::get('skills/user/{userId}','SkillController@getSkillsByUserId');
        Route::post('userSkills','SkillUserController@store');
        //send mail
    });
    Route::post('sendmail', 'MailController@attachment_email');
    Route::post('password/email', 'ForgotPasswordController@forgot');
    Route::post('password/reset', 'ForgotPasswordController@reset')->name('password.reset');
});

