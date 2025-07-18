<?php

// use Exception;
use App\Models\Academy;
use App\Models\Teacher;
use Illuminate\Http\Request;
use App\Http\Services\Sms\Sms;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\api\BlogController;
use App\Http\Controllers\api\PlanController;
use App\Http\Controllers\api\ProResumeOrder;
use App\Http\Controllers\api\BrandController;
use App\Http\Controllers\api\OrderController;
use App\Http\Controllers\api\CourseController;
use App\Http\Controllers\api\TicketController;
use App\Http\Controllers\api\AcademyController;
use App\Http\Controllers\api\PrimeAcademyOrder;
use App\Http\Controllers\api\ProblemController;
use App\Http\Controllers\api\ProductController;
use App\Http\Controllers\api\RequestController;
use App\Http\Controllers\api\SettingController;
use App\Http\Controllers\api\TeacherController;
use App\Http\Controllers\api\CategoryController;
use App\Http\Controllers\api\InstitueController;
use App\Http\Controllers\OrderProfileController;
use App\Http\Controllers\api\CheckRoleController;
use App\Http\Controllers\api\ConnectorController;
use App\Http\Controllers\api\UserEmailController;
use App\Http\Controllers\api\SendResumeController;
use App\Http\Controllers\api\UserAdLikeController;
use App\Http\Controllers\api\AdStatisticController;
use App\Http\Controllers\api\UserAdWatchController;
use App\Http\Controllers\api\PrimeAcademyController;
use App\Http\Controllers\api\PrimeTeacherController;
use App\Http\Controllers\api\ProResumeRequestTicket;
use App\Http\Controllers\api\SuggestedJobController;
use App\Http\Controllers\api\UserPasswordController;
use App\Http\Controllers\api\AdvertisementController;
use App\Http\Controllers\api\AuthenticationController;
use App\Http\Controllers\api\ProfessionalResumeRequest;
use App\Http\Controllers\api\SuggestedCourseController;
use App\Http\Controllers\api\SuggestedResumeController;
use App\Http\Controllers\api\SuggestedProductController;
use App\Http\Controllers\api\PrimeAcademyRequestController;
use App\Http\Controllers\api\PrimeTeacherRequestController;
use App\Http\Controllers\api\AcademyProfileCompletionController;
use App\Http\Controllers\api\TeacherProfileCompletionController;

Route::get('/test', function () {
    try{
        
   return Sms::welcome()->to('09154191764')->send();
        
    }catch(Exception $e){
        return response()->json(['error' => $e->getMessage()]);
    }
});

Route::post('authenticate',[AuthenticationController::class,'authenticate']);
Route::post('register',[AuthenticationController::class,'register']);

Route::post('login-register', [AuthenticationController::class, 'loginOrRegisterForTeachers']);
Route::post('login-register-academy', [AuthenticationController::class, 'loginOrRegisterForAcademy']);

Route::post('make-password', [AuthenticationController::class, 'makePassword']);

Route::post('login-teacher', [AuthenticationController::class, 'loginTeacher']);
Route::post('register-teacher', [AuthenticationController::class, 'registerTeacher']);
Route::post('login-academy', [AuthenticationController::class, 'loginAcademy']);
Route::post('register-academy', [AuthenticationController::class, 'registerAcademy']);
Route::post('send-auth-code', [AuthenticationController::class, 'sendConfirmationCode']);
Route::post('check-auth-code', [AuthenticationController::class, 'checkCode']);



Route::get('logout', function (Request $request) {
    $user = Auth::user();
    $user->tokens()->where('id', $user->currentAccessToken()->id)->delete();

    return response()->json([
        'message' => 'You have been logged out',
    ]);
})->middleware('auth:sanctum');

Route::post('/redirect',function(){
   return  Http::get('https://www.google.com');
});


Route::get('/user', function () {
    $user = auth()->user();

    if ($user->teacher != NULL) {
        
        return [
            'آیدی' => $user->teacher->user_id,
            'نام' => $user->teacher->first_name,
            'نام خانوادگی' => $user->teacher->last_name,
            'ایمیل' => $user->teacher->email,
        ];

    } else if ($user->academy != NULL) {

       return [
            'آیدی' => $user->academy->id,
            'نام آموزشگاه' => $user->academy->name,
            'شماره تلفن آموزشگاه' => $user->academy->phone,
            'وب سایت' => $user->academy->website,
        ];
    } else {

        return [
            'آیدی' => $user->id,
            'نام' => $user->first_name,
            'نام خانوادگی' => $user->last_name,
            'ایمیل' => $user->email,
        ];
    }
})->middleware('auth:sanctum');


Route::get('blogs', [BlogController::class, 'index']);
Route::get('blog/{id}', [BlogController::class, 'show']);

Route::get('academies', [AcademyController::class, 'index']);
Route::get('academy/{id}', [AcademyController::class, 'show']);

Route::get('teachers', [TeacherController::class, 'index']);
Route::get('teacher/{id}', [TeacherController::class, 'show']);

Route::get('site_title', [SettingController::class, 'site_title']);
Route::get('logo', [SettingController::class, 'logo']);
Route::get('about_us', [SettingController::class, 'aboutUs']);
Route::get('contact_us', [SettingController::class, 'contactUs']);
Route::get('questions', [SettingController::class, 'questions']);
Route::get('enamad', [SettingController::class, 'enamad']);
Route::get('plans', [PlanController::class, 'index']);
Route::get('advertisements', [AdvertisementController::class, 'index']);
Route::get('advertisement/{id}', [AdvertisementController::class, 'show']);

Route::post('ad/filterize',[AdvertisementController::class,'filterize']);
Route::get('ad/{id}/similar',[AdvertisementController::class,'similarJobs']);

Route::get('/institues',[InstitueController::class,'index']);

Route::middleware(['auth:sanctum'])->group(function () {

     Route::post('academy-store', [AcademyController::class, 'academyStore']);
    Route::post('academy-additional-information-store', [AcademyController::class, 'academyAdditionalInformationStore']);
    Route::post('academy-profile-image-store', [AcademyController::class, 'academyProfileImageStore']);
     Route::post('academy/academic-level/{id}/delete', [AcademyController::class, 'deleteAcademicLevel']);
     Route::post('prime/academy/check', [AcademyController::class, 'primeAcademyCheck']);
    
    Route::get('academy-get', [AcademyController::class, 'academyGet']);
    Route::get('academy-additional-information-get', [AcademyController::class, 'academyAdditionalInformationGet']);
    Route::get('academy-profile-image-get', [AcademyController::class, 'academyProfileImageGet']);

    Route::post('teacher-store', [TeacherController::class, 'teacherStore']);
    Route::post('teacher-avatar-store', [TeacherController::class, 'teacherAvatarStore']);
    Route::post('teacher-selection-image-store', [TeacherController::class, 'teacherSelectionImageStore']);
    Route::post('teacher-academic-backgrounds-store', [TeacherController::class, 'academicBackgroundStore']);
    Route::post('teacher-job-backgrounds-store', [TeacherController::class, 'jobBackgroundStore']);
    Route::post('teacher-skills-store', [TeacherController::class, 'skillStore']);
    Route::post('teacher-skills-delete', [TeacherController::class, 'skillDelete']);
    Route::post('teacher-job-in-demands-store', [TeacherController::class, 'jobInDemandStore']);
    
    Route::post('teacher-job-experience-delete', [TeacherController::class, 'deleteJobExperience']);
    
    Route::get('academy-getAdvertisements', [AdvertisementController::class, 'getAdvertisement']);
    Route::post('advertisement/{advertisement_id}/job-introduction/update', [AdvertisementController::class, 'jobIntroductionUpdate']);
    Route::post('advertisement/{advertisement_id}/job-location/update', [AdvertisementController::class, 'locationUpdate']);
    Route::post('advertisement/{advertisement_id}/job-requirement/update', [AdvertisementController::class, 'requirementUpdate']);
    Route::post('advertisement/{advertisement_id}/job-salary/update', [AdvertisementController::class, 'salaryUpdate']);
    Route::post('advertisement/{advertisement_id}/job-background/update', [AdvertisementController::class, 'jobBackgroundUpdate']);
    Route::post('advertisement/{advertisement_id}/job-additional-condition/update', [AdvertisementController::class, 'additionalConditionUpdate']);
    Route::post('advertisement/{advertisement_id}/job-education/update', [AdvertisementController::class, 'educationUpdate']);
    Route::post('advertisement/{advertisement_id}/job-skill/update', [AdvertisementController::class, 'softSkillUpdate']);
    Route::post('advertisement/{advertisement_id}/job-description/update', [AdvertisementController::class, 'jobDescriptionUpdate']);
    
    Route::get('advertisement/majors/get', [AdvertisementController::class, 'getMajors']);
    
    Route::delete('advertisement/job-education/{id}/delete', [AdvertisementController::class, 'educationDelete']);
    
    Route::delete('advertisement/{id}/delete', [AdvertisementController::class, 'advertisementDelete']);
    
    Route::delete('advertisement/job-skill/{id}/delete', [AdvertisementController::class, 'skillSoftDelete']);
    
     Route::post('urgent-ad/store',[AdvertisementController::class,'addToUrgent']);
     Route::post('featured-ad/store',[AdvertisementController::class,'addToFeatured']);
    
    
    Route::get('teacher-get', [TeacherController::class, 'teacherGet']);
    Route::get('teacher-avatar-get', [TeacherController::class, 'teacherAvatarGet']);
    Route::get('teacher-selection-image-get', [TeacherController::class, 'teacherSelectionImageGet']);
    Route::get('teacher-academic-backgrounds-get', [TeacherController::class, 'academicBackgroundGet']);
    Route::get('teacher-job-backgrounds-get', [TeacherController::class, 'jobBackgroundGet']);
    Route::get('teacher-skills-get', [TeacherController::class, 'skillGet']);
    Route::get('teacher-job-in-demands-get', [TeacherController::class, 'jobInDemandGet']);

    Route::get('connector', [ConnectorController::class, 'get']);
    Route::post('connector/store', [ConnectorController::class, 'store']);

    Route::get('token/generate/refresh', [AuthenticationController::class, 'generateLongExpireDateToken']);


    // Route::get('advertisement/getAdvertisement', [AdvertisementController::class, 'getAdvertisement']);
    Route::post('advertisement/job-introduction/store', [AdvertisementController::class, 'jobIntroduction']);
    Route::post('advertisement/job-location/store', [AdvertisementController::class, 'location']);
    Route::post('advertisement/job-requirement/store', [AdvertisementController::class, 'requirement']);
    Route::post('advertisement/job-salary/store', [AdvertisementController::class, 'salary']);
    Route::post('advertisement/job-background/store', [AdvertisementController::class, 'jobBackground']);
    Route::post('advertisement/job-additional-condition/store', [AdvertisementController::class, 'additionalCondition']);
    Route::post('advertisement/job-education/store', [AdvertisementController::class, 'education']);
    Route::post('advertisement/job-skill/store', [AdvertisementController::class, 'softSkill']);
    Route::post('advertisement/job-description/store', [AdvertisementController::class, 'jobDescription']);

    Route::post('order/pay', [OrderController::class, 'pay']);
    
    Route::post('order/profile/pay', [ProResumeOrder::class, 'pay']);
    
    Route::post('order/prime/academy/pay', [PrimeAcademyOrder::class, 'pay']);

    Route::get('suggested-resume', [SuggestedResumeController::class, 'show']);
    Route::get('ad/statistics', [AdStatisticController::class, 'AdvertisementWatchCount']);

    Route::post('prime-teacher/request', [PrimeTeacherRequestController::class, 'store']);


    Route::post('prime-academy/request', [PrimeAcademyRequestController::class, 'store']);
    Route::get('prime-teacher/request/check', [PrimeTeacherRequestController::class, 'check']);


    Route::post('ad-watch/request', [UserAdWatchController::class, 'store']);
    Route::get('watched-ad', [UserAdWatchController::class, 'index']);

    Route::post('ad-like/request', [UserAdLikeController::class, 'store']);
    Route::post('ad-like/request/delete', [UserAdLikeController::class, 'delete']);
    Route::get('liked-ad', [UserAdLikeController::class, 'index']);

    Route::get('suggested-jobs', [SuggestedJobController::class, 'show']);

    Route::get('suggested-course', [SuggestedCourseController::class, 'index']);
    Route::post('suggested-course/filterize', [SuggestedCourseController::class, 'filterize']);
    Route::get('suggested-product', [SuggestedProductController::class, 'index']);


    Route::get('pro-resume/requests', [ProfessionalResumeRequest::class, 'index']);
    Route::post('pro-resume/request', [ProfessionalResumeRequest::class, 'store']);

    Route::get('pro-resume/request/tickets/{request_id}', [ProResumeRequestTicket::class, 'index']);
    Route::post('pro-resume/request/tickets/store', [ProResumeRequestTicket::class, 'store']);

    Route::post('send-resume', [SendResumeController::class, 'store']);
    Route::post('send-resume/{id}/cancel', [SendResumeController::class, 'cancel']);
    Route::post('/check/send-resume', [SendResumeController::class, 'checkResumeAlreadySended']);
    Route::get('/send-resume/history', [SendResumeController::class, 'sendResumeHistory']);
    Route::get('/get-resume/{id}/history', [SendResumeController::class, 'getResumeHistory']);
    Route::get('/get-resume/history/all', [SendResumeController::class, 'allGetResumeHistory']);
    Route::post('/send-resume/{id}/change-status', [SendResumeController::class, 'changeStatus']);
    Route::get('/send-resume/{id}/status/get', [SendResumeController::class, 'sendResumeHistoryById']);

    
    Route::post('/role-token/verify',[CheckRoleController::class,'verify']);
    
    
    Route::get('/teacher/profile/completion',[TeacherProfileCompletionController::class,'teacher']);
    Route::get('/academy/profile/completion',[AcademyProfileCompletionController::class,'academy']);
    
    Route::get('/check-plan',[PlanController::class,'checkPlan']);
    
     Route::get("/advertisements/analysis",[AdvertisementController::class, 'adAnalysis']);
     
     Route::post('prime-teachers/filterize', [PrimeTeacherController::class, 'filterize']);
     
    Route::get("/tickets",[TicketController::class, 'index']);
    Route::get("/ticket/{id}/show",[TicketController::class, 'show']);
    Route::post("/ticket/store",[TicketController::class, 'store']);
    Route::post("/ticket/{id}/continue",[TicketController::class, 'continueTicket']);
    
    Route::post('/set/password', [UserPasswordController::class, 'store']);
    Route::post('/update/email', [UserEmailController::class, 'update']);
});


    Route::get('order/verify', [OrderController::class, 'verify'])->name('order.verify');
    Route::get('order/profile/verify', [ProResumeOrder::class, 'verify'])->name('order.profile.verify');
    Route::get('order/prime/academy/verify', [PrimeAcademyOrder::class, 'verify'])->name('order.prime.academy.verify');

    Route::get('prime-teachers', [PrimeTeacherController::class, 'index']);
    Route::get('prime-academies', [PrimeAcademyController::class, 'index']);

 Route::get('shop/products', [ProductController::class, 'index']);
    Route::get('shop/product/{id}', [ProductController::class, 'show']);
        Route::get('shop/courses', [CourseController::class, 'index']);
    Route::get('shop/course/{id}', [CourseController::class, 'show']);
    
    
    Route::get('/user-role', function (Request $request) {
        
    

    $user = auth()->user();

    $is_teacher = Teacher::where('user_id', $user->id)->first();
    $is_academy = Academy::where('user_id', $user->id)->first();
    
    $role = '';
    
    if(!is_null($is_teacher))
        $role = 'معلم';
        
    if(!is_null($is_academy))
        $role = 'آموزشگاه';
        
    if(is_null($is_teacher) && is_null($is_academy))
        $role = 'کاربر عادی';

    return response()->json([
        'نقش' => $role
    ]);

})->middleware(['auth:sanctum']);
    
    