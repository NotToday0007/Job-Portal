<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\JobController;
use App\Http\Controllers\FindJobsController;
use App\Http\Controllers\JobDetailsController;
use App\Models\User;
use App\Models\Category;
use App\Models\JobType;
use App\Models\Job;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\TokenVerificationMiddleware;

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

Route::get('/', function () {
    return view('welcome');
});
Route::get('/',[HomeController::class,'index'])->name('home')->middleware([TokenVerificationMiddleware::class]);
Route::get('/login',[UserController::class,'login'])->name('logIN');
Route::get('/Registration',[UserController::class,'Registration']);
Route::post('/UserRegistration', [UserController::class, 'userRegistration'])->name('UserRegistration');

Route::post('/UserLogin', [UserController::class, 'UserLogin'])->name('UserLogin');



Route::get('/verify',[UserController::class,'verifyRoute']);
Route::post('/verify-otp', [UserController::class, 'verifyOtp']);
Route::get('/userprofile', [AccountController::class, 'accountRoute'])->middleware([TokenVerificationMiddleware::class]);

Route::get('/user-profile', [AccountController::class, 'getProfile'])->middleware([TokenVerificationMiddleware::class]);
Route::post('/update-profile', [AccountController::class, 'updateProfile'])->middleware([TokenVerificationMiddleware::class]);
Route::post('/update-password', [AccountController::class, 'updatePassword'])->middleware([TokenVerificationMiddleware::class]);
Route::get('/logout',[UserController::class,'UserLogout']);



Route::post("/create-product",[AccountController::class,'UpdateProduct'])->middleware([TokenVerificationMiddleware::class]);
Route::get('/get-profile', [AccountController::class, 'getProfilePic'])->middleware([TokenVerificationMiddleware::class]);
Route::get('/post-job',[JobController::class,'postJob'])->middleware([TokenVerificationMiddleware::class]);


Route::get('/list-category', [JobController::class, 'CategoryList'])->middleware([TokenVerificationMiddleware::class]);

Route::get('/job-types', [JobController::class, 'JobTypes'])->middleware([TokenVerificationMiddleware::class]);

Route::post('/save-job', [JobController::class, 'saveJob'])->middleware([TokenVerificationMiddleware::class]);
Route::get('/my-job',[JobController::class,'myJob'])->middleware([TokenVerificationMiddleware::class]);
Route::get('/job-list',[JobController::class,'listCategory'])->middleware([TokenVerificationMiddleware::class]);
// Route to fetch jobs
Route::get('/api/jobs', [JobController::class, 'get'])->middleware([TokenVerificationMiddleware::class]);
Route::get('/jobs', action: [JobController::class, 'getJobs'])->middleware([TokenVerificationMiddleware::class]);
// Route::get('/myJob-view',[JobController::class,'myJobView'])->middleware([TokenVerificationMiddleware::class]);
// Route::get('/view-job',[JobController::class,'JobView'])->middleware([TokenVerificationMiddleware::class]);
Route::get('/view-job/{id}', [JobController::class, 'JobView'])->name('view-job')->middleware([TokenVerificationMiddleware::class]);
// web.php
Route::get('/jobs/{id}', [JobController::class, 'show'])->name('jobs.show')->middleware([TokenVerificationMiddleware::class]);
Route::get('/myJob-view', [JobController::class, 'myJobView'])->name('job.view')->middleware([TokenVerificationMiddleware::class]);
Route::get('/job/edit', [JobController::class, 'myJobedit'])->name('job.view')->middleware([TokenVerificationMiddleware::class]);
Route::get('/jobs/edit/{id}', [JobController::class, 'edit'])->name('jobs.show')->middleware([TokenVerificationMiddleware::class]);
Route::post('/job/update/{id}', [JobController::class, 'update'])->middleware([TokenVerificationMiddleware::class]);
Route::post('/job/delete', [JobController::class, 'delete'])->middleware([TokenVerificationMiddleware::class]);
Route::get ('/get-featureJob',[HomeController::class,'getFeatureJob'])->middleware([TokenVerificationMiddleware::class]);
Route::get ('/find-jobs',[FindJobsController::class,'findJobs'])->middleware([TokenVerificationMiddleware::class]);
Route::get ('/job-details/{id}',[JobDetailsController::class,'jobDetails'])->middleware([TokenVerificationMiddleware::class]);
Route::get ('/job-save/{id}',[JobDetailsController::class,'jobSaved'])->middleware([TokenVerificationMiddleware::class]);
Route::get ('/job-apply/{id}',[JobDetailsController::class,'jobApplied'])->middleware([TokenVerificationMiddleware::class]);
Route::get('/jobs', [JobController::class, 'getJobsWithApplicantCount']);
Route::get ('/job-applied',[JobDetailsController::class,'jobsAppliedRedirect'])->middleware([TokenVerificationMiddleware::class]);
Route::get('/user/applied-jobs', [JobDetailsController::class, 'getUserAppliedJobs'])->middleware([TokenVerificationMiddleware::class]);
Route::get ('/job-saved',[JobDetailsController::class,'jobsSaved'])->middleware([TokenVerificationMiddleware::class]);
Route::get('/user/saved-jobs', [JobDetailsController::class, 'getUserSavedJobs'])->middleware([TokenVerificationMiddleware::class]);
Route::get('/view/job-applied/{id}', [JobDetailsController::class, 'jobAppliedView'])->middleware([TokenVerificationMiddleware::class]);
Route::post('/job-applied/delete', [JobDetailsController::class, 'jobAppliedDelete'])->middleware([TokenVerificationMiddleware::class]);
Route::post('/job-saved/delete', [JobDetailsController::class, 'jobSavedDelete'])->middleware([TokenVerificationMiddleware::class]);
