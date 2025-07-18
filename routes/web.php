<?php

use App\Models\Request;
use App\Models\CourseEpisode;
use App\Http\Middleware\isAdmin;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\PlanController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PanelController;
use App\Http\Controllers\SkillController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\AcademyController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\UploadFileController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\JobInDemandController;
use App\Http\Controllers\AdMajorController;
use App\Http\Controllers\UploadVideoController;
use App\Http\Controllers\FileDownloadController;
use App\Http\Controllers\OrderProfileController;
use App\Http\Controllers\PrimeAcademyController;
use App\Http\Controllers\PrimeTeacherController;
use App\Http\Controllers\TicketContentController;
use App\Http\Controllers\SettingPriceController;
use App\Http\Controllers\AdvertisementController;
use App\Http\Controllers\CourseEpisodeController;
use App\Http\Controllers\JobBackgroundController;
use App\Http\Controllers\VideoDownloadController;
use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\CourseCategoryController;
use App\Http\Controllers\FeatureManagerController;
use App\Http\Controllers\ProResumeTicketController;
use App\Http\Controllers\AcademicBackgroundController;
use App\Http\Controllers\PrimeAcademyRequestController;
use App\Http\Controllers\PrimeTeacherRequestController;
use App\Http\Controllers\AdvertisementEducationController;
use App\Http\Controllers\AdvertisementJobSalaryController;
use App\Http\Controllers\AdvertisementSoftSkillController;
use App\Http\Controllers\AdvertisementJobLocationController;
use App\Http\Controllers\SuggestedResumeAlgorithmController;
use App\Http\Controllers\ProfessionalResumeRequestController;
use Laravel\Socialite\Facades\Socialite;
use App\Http\Controllers\AdvertisementJobBackgroundController;
use App\Http\Controllers\AdvertisementJobDescriptionController;
use App\Http\Controllers\AcademyAdditionalInformationController;
use App\Http\Controllers\AdvertisementJobRequirementsController;
use App\Http\Controllers\AdvertisementAdditionalConditionController;


Route::get('/auth/google', function () {
    return Socialite::driver('google')->redirect();
});

Route::get('/auth/google/callback', function () {
    $googleUser = Socialite::driver('google')->user();


    dd($googleUser);
});

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthenticationController::class, 'loginForm'])->name('login.form');
    Route::post('/login', [AuthenticationController::class, 'login'])->name('login');
    Route::get('/register', [AuthenticationController::class, 'registerForm'])->name('register.form');
    Route::post('/register', [AuthenticationController::class, 'register'])->name('register');
});



Route::middleware('auth')->group(function () {

    Route::get('/sign-out', [AuthenticationController::class, 'logout'])->name('logout');
    Route::middleware(isAdmin::class)->group(function () {

        Route::get('/', [PanelController::class, 'index'])->name('panel.index');

        // USER ROUTES
        Route::get('/users', [UserController::class, 'index'])->name('panel.users.index');
        Route::get('/users/create', [UserController::class, 'create'])->name('panel.users.create');
        Route::post('/users/store', [UserController::class, 'store'])->name('panel.users.store');
        Route::get('/users/{id}/edit', [UserController::class, 'edit'])->name('panel.users.edit');
        Route::post('/users/{id}/update', [UserController::class, 'update'])->name('panel.users.update');
        Route::post('/users/delete', [UserController::class, 'delete'])->name('panel.users.delete');

        // ADMIN ROUTES
        Route::get('/admins', [AdminController::class, 'index'])->name('panel.admin.index');
        Route::get('/admin/create', [AdminController::class, 'create'])->name('panel.admin.create');
        Route::post('/admin/store', [AdminController::class, 'store'])->name('panel.admin.store');
        Route::get('/admin/{id}/edit', [AdminController::class, 'edit'])->name('panel.admin.edit');
        Route::post('/admin/{id}/update', [AdminController::class, 'update'])->name('panel.admin.update');
        Route::post('/admin/delete', [AdminController::class, 'delete'])->name('panel.admin.delete');

        // TEACHER ROUTE
        Route::get('/teachers', [TeacherController::class, 'index'])->name('panel.teacher.index');
        Route::get('/teacher/create', [TeacherController::class, 'create'])->name('panel.teacher.create');
        Route::post('/teacher/store', [TeacherController::class, 'store'])->name('panel.teacher.store');
        Route::get('/teacher/{id}/edit', [TeacherController::class, 'edit'])->name('panel.teacher.edit');
        Route::post('/teacher/{id}/update', [TeacherController::class, 'update'])->name('panel.teacher.update');
        Route::post('/teacher/delete', [TeacherController::class, 'delete'])->name('panel.teacher.delete');

        // ACADEMIC BACKGROUND ROUTE
        Route::get('/teachers/academic-background', [AcademicBackgroundController::class, 'index'])->name('panel.teacher.academic.background.index');
        Route::get('/teachers/academic-background/{id}/show', [AcademicBackgroundController::class, 'show'])->name('panel.teacher.academic.background.show');
        Route::get('/teacher/academic-background/{id}/create', [AcademicBackgroundController::class, 'create'])->name('panel.teacher.academic.background.create');
        Route::post('/teacher/academic-background/store', [AcademicBackgroundController::class, 'store'])->name('panel.teacher.academic.background.store');
        Route::get('/teacher/academic-background/{id}/edit', [AcademicBackgroundController::class, 'edit'])->name('panel.teacher.academic.background.edit');
        Route::post('/teacher/academic-background/{id}/update', [AcademicBackgroundController::class, 'update'])->name('panel.teacher.academic.background.update');
        Route::post('/teacher/academic-background/delete', [AcademicBackgroundController::class, 'delete'])->name('panel.teacher.academic.background.delete');

        // JOB BACKGROUND ROUTE
        Route::get('/teachers/job-background', [JobBackgroundController::class, 'index'])->name('panel.teacher.job.background.index');
        Route::get('/teachers/job-background/{id}/show', [JobBackgroundController::class, 'show'])->name('panel.teacher.job.background.show');
        Route::get('/teacher/job-background/{id}/create', [JobBackgroundController::class, 'create'])->name('panel.teacher.job.background.create');
        Route::post('/teacher/job-background/store', [JobBackgroundController::class, 'store'])->name('panel.teacher.job.background.store');
        Route::get('/teacher/job-background/{teacher_id}/{id}/edit', [JobBackgroundController::class, 'edit'])->name('panel.teacher.job.background.edit');
        Route::post('/teacher/job-background/{id}/update', [JobBackgroundController::class, 'update'])->name('panel.teacher.job.background.update');
        Route::post('/teacher/job-background/delete', [JobBackgroundController::class, 'delete'])->name('panel.teacher.job.background.delete');

        // SKILL ROUTE
        Route::get('/teachers/skill', [SkillController::class, 'index'])->name('panel.teacher.skill.index');
        Route::get('/teachers/skill/{id}/show', [SkillController::class, 'show'])->name('panel.teacher.skill.show');
        Route::get('/teacher/skill/{id}/create', [SkillController::class, 'create'])->name('panel.teacher.skill.create');
        Route::post('/teacher/skill/store', [SkillController::class, 'store'])->name('panel.teacher.skill.store');
        Route::get('/teacher/skill/{teacher_id}/{id}/edit', [SkillController::class, 'edit'])->name('panel.teacher.skill.edit');
        Route::post('/teacher/skill/{id}/update', [SkillController::class, 'update'])->name('panel.teacher.skill.update');
        Route::post('/teacher/skill/delete', [SkillController::class, 'delete'])->name('panel.teacher.skill.delete');

        // JOB IN DEMAND ROUTE
        Route::get('/teachers/job-in-demand', [JobInDemandController::class, 'index'])->name('panel.teacher.job.in.demand.index');
        Route::get('/teachers/job-in-demand/{id}/show', [JobInDemandController::class, 'show'])->name('panel.teacher.job.in.demand.show');
        Route::get('/teacher/job-in-demand/{id}/create', [JobInDemandController::class, 'create'])->name('panel.teacher.job.in.demand.create');
        Route::post('/teacher/job-in-demand/store', [JobInDemandController::class, 'store'])->name('panel.teacher.job.in.demand.store');
        Route::get('/teacher/job-in-demand/{teacher_id}/{id}/edit', [JobInDemandController::class, 'edit'])->name('panel.teacher.job.in.demand.edit');
        Route::post('/teacher/job-in-demand/{id}/update', [JobInDemandController::class, 'update'])->name('panel.teacher.job.in.demand.update');
        Route::post('/teacher/job-in-demand/delete', [JobInDemandController::class, 'delete'])->name('panel.teacher.job.in.demand.delete');

        // SETTING ROUTE
        Route::get('settings', [SettingController::class, 'index'])->name('panel.setting.index');
        Route::get('setting/{id}/edit', [SettingController::class, 'edit'])->name('panel.setting.edit');
        Route::get('setting/create', [SettingController::class, 'create'])->name('panel.setting.create');
        Route::post('setting/{id}/update', [SettingController::class, 'update'])->name('panel.setting.update');
        Route::post('setting/store', [SettingController::class, 'store'])->name('panel.setting.store');
        Route::post('setting/delete', [SettingController::class, 'delete'])->name('panel.setting.delete');

        // SETTING PRICE ROUTE
        Route::get('settings/price', [SettingPriceController::class, 'index'])->name('panel.setting.price.index');
        Route::get('setting/price/{id}/edit', [SettingPriceController::class, 'edit'])->name('panel.setting.price.edit');
        Route::get('setting/price/create', [SettingPriceController::class, 'create'])->name('panel.setting.price.create');
        Route::post('setting/price/{id}/update', [SettingPriceController::class, 'update'])->name('panel.setting.price.update');
        Route::post('setting/price/store', [SettingPriceController::class, 'store'])->name('panel.setting.price.store');
        Route::post('setting/price/delete', [SettingPriceController::class, 'delete'])->name('panel.setting.price.delete');

        // BLOG ROUTE
        Route::get('/blogs', [BlogController::class, 'index'])->name('panel.blog.index');
        Route::get('/blog/create', [BlogController::class, 'create'])->name('panel.blog.create');
        Route::post('/blog/store', [BlogController::class, 'store'])->name('panel.blog.store');
        Route::get('/blog/{id}/edit', [BlogController::class, 'edit'])->name('panel.blog.edit');
        Route::post('/blog/{id}/update', [BlogController::class, 'update'])->name('panel.blog.update');
        Route::post('/blog/delete', [BlogController::class, 'delete'])->name('panel.blog.delete');

        // ACADEMY ROUTE
        Route::get('/academies', [AcademyController::class, 'index'])->name('panel.academy.index');
        Route::get('/academy/create', [AcademyController::class, 'create'])->name('panel.academy.create');
        Route::post('/academy/store', [AcademyController::class, 'store'])->name('panel.academy.store');
        Route::get('/academy/{id}/edit', [AcademyController::class, 'edit'])->name('panel.academy.edit');
        Route::post('/academy/{id}/update', [AcademyController::class, 'update'])->name('panel.academy.update');
        Route::post('/academy/delete', [AcademyController::class, 'delete'])->name('panel.academy.delete');

        // ACADEMY ADDITIONAL INFORMATIONS ROUTE
        Route::get('/academy/additional-informations', [AcademyAdditionalInformationController::class, 'index'])->name('panel.academy.additional.informations.index');
        Route::get('/academy/additional-informations/{id}/show', [AcademyAdditionalInformationController::class, 'show'])->name('panel.academy.additional.informations.show');
        Route::get('/academy/additional-informations/{id}/create', [AcademyAdditionalInformationController::class, 'create'])->name('panel.academy.additional.informations.create');
        Route::post('/academy/additional-informations/store', [AcademyAdditionalInformationController::class, 'store'])->name('panel.academy.additional.informations.store');
        Route::get('/academy/additional-informations/{academy_id}/{id}/edit', [AcademyAdditionalInformationController::class, 'edit'])->name('panel.academy.additional.informations.edit');
        Route::post('/academy/additional-informations/{id}/update', [AcademyAdditionalInformationController::class, 'update'])->name('panel.academy.additional.informations.update');
        Route::post('/academy/additional-informations/delete', [AcademyAdditionalInformationController::class, 'delete'])->name('panel.academy.additional.informations.delete');

        // PLAN ROUTE
        Route::get('/plans', [PlanController::class, 'index'])->name('panel.plan.index');
        Route::get('/plan/create', [PlanController::class, 'create'])->name('panel.plan.create');
        Route::post('/plan/store', [PlanController::class, 'store'])->name('panel.plan.store');
        Route::get('/plan/{id}/edit', [PlanController::class, 'edit'])->name('panel.plan.edit');
        Route::post('/plan/{id}/update', [PlanController::class, 'update'])->name('panel.plan.update');
        Route::post('/plan/delete', [PlanController::class, 'delete'])->name('panel.plan.delete');

        // ADVERTISEMENT ROUTE
        Route::get('/advertisements', [AdvertisementController::class, 'index'])->name('panel.advertisement.index');
        Route::get('/advertisement/create', [AdvertisementController::class, 'create'])->name('panel.advertisement.create');
        Route::post('/advertisement/store', [AdvertisementController::class, 'store'])->name('panel.advertisement.store');
        Route::get('/advertisement/{id}/edit', [AdvertisementController::class, 'edit'])->name('panel.advertisement.edit');
        Route::post('/advertisement/{id}/update', [AdvertisementController::class, 'update'])->name('panel.advertisement.update');
        Route::post('/advertisement/delete', [AdvertisementController::class, 'delete'])->name('panel.advertisement.delete');

        // ADVERTISEMENT JOB LOCATION ROUTE
        Route::get('/advertisement/job-location', [AdvertisementJobLocationController::class, 'index'])->name('panel.advertisement.job.location.index');
        Route::get('/advertisement/job-location/{id}/show', [AdvertisementJobLocationController::class, 'show'])->name('panel.advertisement.job.location.show');
        Route::get('/advertisement/job-location/{id}/create', [AdvertisementJobLocationController::class, 'create'])->name('panel.advertisement.job.location.create');
        Route::post('/advertisement/job-location/store', [AdvertisementJobLocationController::class, 'store'])->name('panel.advertisement.job.location.store');
        Route::get('/advertisement/job-location/{advertisement_id}/{id}/edit', [AdvertisementJobLocationController::class, 'edit'])->name('panel.advertisement.job.location.edit');
        Route::post('/advertisement/job-location/{id}/update', [AdvertisementJobLocationController::class, 'update'])->name('panel.advertisement.job.location.update');
        Route::post('/advertisement/job-location/delete', [AdvertisementJobLocationController::class, 'delete'])->name('panel.advertisement.job.location.delete');

        // ADVERTISEMENT JOB REQUIREMENTS ROUTE
        Route::get('/advertisement/job-requirements', [AdvertisementJobRequirementsController::class, 'index'])->name('panel.advertisement.job.requirements.index');
        Route::get('/advertisement/job-requirements/{id}/show', [AdvertisementJobRequirementsController::class, 'show'])->name('panel.advertisement.job.requirements.show');
        Route::get('/advertisement/job-requirements/{id}/create', [AdvertisementJobRequirementsController::class, 'create'])->name('panel.advertisement.job.requirements.create');
        Route::post('/advertisement/job-requirements/store', [AdvertisementJobRequirementsController::class, 'store'])->name('panel.advertisement.job.requirements.store');
        Route::get('/advertisement/job-requirements/{advertisement_id}/{id}/edit', [AdvertisementJobRequirementsController::class, 'edit'])->name('panel.advertisement.job.requirements.edit');
        Route::post('/advertisement/job-requirements/{id}/update', [AdvertisementJobRequirementsController::class, 'update'])->name('panel.advertisement.job.requirements.update');
        Route::post('/advertisement/job-requirements/delete', [AdvertisementJobRequirementsController::class, 'delete'])->name('panel.advertisement.job.requirements.delete');

        // ADVERTISEMENT JOB SALARY ROUTE
        Route::get('/advertisement/job-salary', [AdvertisementJobSalaryController::class, 'index'])->name('panel.advertisement.job.salary.index');
        Route::get('/advertisement/job-salary/{id}/show', [AdvertisementJobSalaryController::class, 'show'])->name('panel.advertisement.job.salary.show');
        Route::get('/advertisement/job-salary/{id}/create', [AdvertisementJobSalaryController::class, 'create'])->name('panel.advertisement.job.salary.create');
        Route::post('/advertisement/job-salary/store', [AdvertisementJobSalaryController::class, 'store'])->name('panel.advertisement.job.salary.store');
        Route::get('/advertisement/job-salary/{advertisement_id}/{id}/edit', [AdvertisementJobSalaryController::class, 'edit'])->name('panel.advertisement.job.salary.edit');
        Route::post('/advertisement/job-salary/{id}/update', [AdvertisementJobSalaryController::class, 'update'])->name('panel.advertisement.job.salary.update');
        Route::post('/advertisement/job-salary/delete', [AdvertisementJobSalaryController::class, 'delete'])->name('panel.advertisement.job.salary.delete');

        // ADVERTISEMENT JOB BACKGROUND ROUTE
        Route::get('/advertisement/job-background', [AdvertisementJobBackgroundController::class, 'index'])->name('panel.advertisement.job.background.index');
        Route::get('/advertisement/job-background/{id}/show', [AdvertisementJobBackgroundController::class, 'show'])->name('panel.advertisement.job.background.show');
        Route::get('/advertisement/job-background/{id}/create', [AdvertisementJobBackgroundController::class, 'create'])->name('panel.advertisement.job.background.create');
        Route::post('/advertisement/job-background/store', [AdvertisementJobBackgroundController::class, 'store'])->name('panel.advertisement.job.background.store');
        Route::get('/advertisement/job-background/{advertisement_id}/{id}/edit', [AdvertisementJobBackgroundController::class, 'edit'])->name('panel.advertisement.job.background.edit');
        Route::post('/advertisement/job-background/{id}/update', [AdvertisementJobBackgroundController::class, 'update'])->name('panel.advertisement.job.background.update');
        Route::post('/advertisement/job-background/delete', [AdvertisementJobBackgroundController::class, 'delete'])->name('panel.advertisement.job.background.delete');

        // ADVERTISEMENT JOB ADDITIONAL CONDITION ROUTE
        Route::get('/advertisement/job-additional-condition', [AdvertisementAdditionalConditionController::class, 'index'])->name('panel.advertisement.job.additional.condition.index');
        Route::get('/advertisement/job-additional-condition/{id}/show', [AdvertisementAdditionalConditionController::class, 'show'])->name('panel.advertisement.job.additional.condition.show');
        Route::get('/advertisement/job-additional-condition/{id}/create', [AdvertisementAdditionalConditionController::class, 'create'])->name('panel.advertisement.job.additional.condition.create');
        Route::post('/advertisement/job-additional-condition/store', [AdvertisementAdditionalConditionController::class, 'store'])->name('panel.advertisement.job.additional.condition.store');
        Route::get('/advertisement/job-additional-condition/{advertisement_id}/{id}/edit', [AdvertisementAdditionalConditionController::class, 'edit'])->name('panel.advertisement.job.additional.condition.edit');
        Route::post('/advertisement/job-additional-condition/{id}/update', [AdvertisementAdditionalConditionController::class, 'update'])->name('panel.advertisement.job.additional.condition.update');
        Route::post('/advertisement/job-additional-condition/delete', [AdvertisementAdditionalConditionController::class, 'delete'])->name('panel.advertisement.job.additional.condition.delete');

        // ADVERTISEMENT JOB EDUCATION ROUTE
        Route::get('/advertisement/job-education', [AdvertisementEducationController::class, 'index'])->name('panel.advertisement.job.education.index');
        Route::get('/advertisement/job-education/{id}/show', [AdvertisementEducationController::class, 'show'])->name('panel.advertisement.job.education.show');
        Route::get('/advertisement/job-education/{id}/create', [AdvertisementEducationController::class, 'create'])->name('panel.advertisement.job.education.create');
        Route::post('/advertisement/job-education/store', [AdvertisementEducationController::class, 'store'])->name('panel.advertisement.job.education.store');
        Route::get('/advertisement/job-education/{advertisement_id}/{id}/edit', [AdvertisementEducationController::class, 'edit'])->name('panel.advertisement.job.education.edit');
        Route::post('/advertisement/job-education/{id}/update', [AdvertisementEducationController::class, 'update'])->name('panel.advertisement.job.education.update');
        Route::post('/advertisement/job-education/delete', [AdvertisementEducationController::class, 'delete'])->name('panel.advertisement.job.education.delete');

        // ADVERTISEMENT JOB SOFT SKILL ROUTE
        Route::get('/advertisement/job-soft-skill', [AdvertisementSoftSkillController::class, 'index'])->name('panel.advertisement.job.soft.skill.index');
        Route::get('/advertisement/job-soft-skill/{id}/show', [AdvertisementSoftSkillController::class, 'show'])->name('panel.advertisement.job.soft.skill.show');
        Route::get('/advertisement/job-soft-skill/{id}/create', [AdvertisementSoftSkillController::class, 'create'])->name('panel.advertisement.job.soft.skill.create');
        Route::post('/advertisement/job-soft-skill/store', [AdvertisementSoftSkillController::class, 'store'])->name('panel.advertisement.job.soft.skill.store');
        Route::get('/advertisement/job-soft-skill/{advertisement_id}/{id}/edit', [AdvertisementSoftSkillController::class, 'edit'])->name('panel.advertisement.job.soft.skill.edit');
        Route::post('/advertisement/job-soft-skill/{id}/update', [AdvertisementSoftSkillController::class, 'update'])->name('panel.advertisement.job.soft.skill.update');
        Route::post('/advertisement/job-soft-skill/delete', [AdvertisementSoftSkillController::class, 'delete'])->name('panel.advertisement.job.soft.skill.delete');

        // ADVERTISEMENT JOB DESCRIPTION ROUTE
        Route::get('/advertisement/job-description', [AdvertisementJobDescriptionController::class, 'index'])->name('panel.advertisement.job.description.index');
        Route::get('/advertisement/job-description/{id}/show', [AdvertisementJobDescriptionController::class, 'show'])->name('panel.advertisement.job.description.show');
        Route::get('/advertisement/job-description/{id}/create', [AdvertisementJobDescriptionController::class, 'create'])->name('panel.advertisement.job.description.create');
        Route::post('/advertisement/job-description/store', [AdvertisementJobDescriptionController::class, 'store'])->name('panel.advertisement.job.description.store');
        Route::get('/advertisement/job-description/{advertisement_id}/{id}/edit', [AdvertisementJobDescriptionController::class, 'edit'])->name('panel.advertisement.job.description.edit');
        Route::post('/advertisement/job-description/{id}/update', [AdvertisementJobDescriptionController::class, 'update'])->name('panel.advertisement.job.description.update');
        Route::post('/advertisement/job-description/delete', [AdvertisementJobDescriptionController::class, 'delete'])->name('panel.advertisement.job.description.delete');

        // ORDER ROUTE
        Route::get('/orders', [OrderController::class, 'index'])->name('panel.order.index');
        Route::get('/orders/{id}/show', [OrderController::class, 'show'])->name('panel.order.show');
        Route::post('/orders/store', [OrderController::class, 'store'])->name('panel.order.store');

        // ORDER PROFILE ROUTE
        Route::get('/orders/profile', [OrderProfileController::class, 'index'])->name('panel.order.profile.index');
        Route::get('/orders/profile{id}/show', [OrderProfileController::class, 'show'])->name('panel.order.profile.show');
        Route::post('/orders/profile/store', [OrderProfileController::class, 'store'])->name('panel.order.profile.store');

        // ADVERTISEMENT JOB DESCRIPTION ROUTE
        Route::get('/plan/algorithm', [SuggestedResumeAlgorithmController::class, 'index'])->name('panel.suggested.resume.algorithm.index');
        Route::get('/plan/algorithm/{id}/show', [SuggestedResumeAlgorithmController::class, 'show'])->name('panel.suggested.resume.algorithm.show');
        Route::get('/plan/algorithm/create', [SuggestedResumeAlgorithmController::class, 'create'])->name('panel.suggested.resume.algorithm.create');
        Route::post('/plan/algorithm/store', [SuggestedResumeAlgorithmController::class, 'store'])->name('panel.suggested.resume.algorithm.store');
        Route::get('/plan/algorithm/{id}/edit', [SuggestedResumeAlgorithmController::class, 'edit'])->name('panel.suggested.resume.algorithm.edit');
        Route::post('/plan/algorithm/{id}/update', [SuggestedResumeAlgorithmController::class, 'update'])->name('panel.suggested.resume.algorithm.update');
        Route::post('/plan/algorithm/delete', [SuggestedResumeAlgorithmController::class, 'delete'])->name('panel.suggested.resume.algorithm.delete');

        // FEATURE MANAGEMENT ROUTE
        Route::get('/setting/feature-management', [FeatureManagerController::class, 'index'])->name('panel.feature.management.index');
        Route::get('/setting/feature-management/{id}/show', [FeatureManagerController::class, 'show'])->name('panel.feature.management.show');
        Route::get('/setting/feature-management/create', [FeatureManagerController::class, 'create'])->name('panel.feature.management.create');
        Route::post('/setting/feature-management/store', [FeatureManagerController::class, 'store'])->name('panel.feature.management.store');
        Route::get('/setting/feature-management/{id}/edit', [FeatureManagerController::class, 'edit'])->name('panel.feature.management.edit');
        Route::post('/setting/feature-management/{id}/update', [FeatureManagerController::class, 'update'])->name('panel.feature.management.update');
        Route::post('/setting/feature-management/delete', [FeatureManagerController::class, 'delete'])->name('panel.feature.management.delete');

        // PRIME TEACHER ROUTE
        Route::get('/teacher/prime/list', [PrimeTeacherController::class, 'index'])->name('panel.prime.teacher.index');
        Route::get('/teacher/prime/{id}/show', [PrimeTeacherController::class, 'show'])->name('panel.prime.teacher.show');
        Route::get('/teacher/prime/create', [PrimeTeacherController::class, 'create'])->name('panel.prime.teacher.create');
        Route::post('/teacher/prime/store', [PrimeTeacherController::class, 'store'])->name('panel.prime.teacher.store');
        Route::get('/teacher/prime/{id}/edit', [PrimeTeacherController::class, 'edit'])->name('panel.prime.teacher.edit');
        Route::post('/teacher/prime/{id}/update', [PrimeTeacherController::class, 'update'])->name('panel.prime.teacher.update');
        Route::post('/teacher/prime/delete', [PrimeTeacherController::class, 'delete'])->name('panel.prime.teacher.delete');

        // PRIME TEACHER REQUEST ROUTE
        Route::get('/teacher/prime/requests-list', [PrimeTeacherRequestController::class, 'index'])->name('panel.prime.teacher.requests.index');
        Route::get('/teacher/prime/request/{id}/show', [PrimeTeacherRequestController::class, 'show'])->name('panel.prime.teacher.requests.show');
        Route::get('/teacher/prime/request/create', [PrimeTeacherRequestController::class, 'create'])->name('panel.prime.teacher.requests.create');
        Route::post('/teacher/prime/request/store', [PrimeTeacherRequestController::class, 'store'])->name('panel.prime.teacher.requests.store');
        Route::get('/teacher/prime/request/{id}/edit', [PrimeTeacherRequestController::class, 'edit'])->name('panel.prime.teacher.requests.edit');
        Route::post('/teacher/prime/request/{id}/update', [PrimeTeacherRequestController::class, 'update'])->name('panel.prime.teacher.requests.update');
        Route::post('/teacher/prime/request/delete', [PrimeTeacherRequestController::class, 'delete'])->name('panel.prime.teacher.requests.delete');

        // PRIME ACADEMY ROUTE
        Route::get('/academy/prime/index', [PrimeAcademyController::class, 'index'])->name('panel.prime.academy.index');
        // Route::get('/teacher/prime/{id}/show', [PrimeTeacherController::class, 'show'])->name('panel.prime.teacher.show');
        // Route::get('/teacher/prime/create', [PrimeTeacherController::class, 'create'])->name('panel.prime.teacher.create');
        // Route::post('/teacher/prime/store', [PrimeTeacherController::class, 'store'])->name('panel.prime.teacher.store');
        // Route::get('/teacher/prime/{id}/edit', [PrimeTeacherController::class, 'edit'])->name('panel.prime.teacher.edit');
        // Route::post('/teacher/prime/{id}/update', [PrimeTeacherController::class, 'update'])->name('panel.prime.teacher.update');
        Route::post('/academy/prime/delete', [PrimeAcademyController::class, 'delete'])->name('panel.prime.academy.delete');

        // PRIME ACADEMY REQUEST ROUTE
        Route::get('/academy/prime/requests/index', [PrimeAcademyRequestController::class, 'index'])->name('panel.prime.academy.requests.index');
        Route::get('/academy/prime/request/{id}/show', [PrimeAcademyRequestController::class, 'show'])->name('panel.prime.academy.requests.show');
        Route::get('/academy/prime/request/create', [PrimeAcademyRequestController::class, 'create'])->name('panel.prime.academy.requests.create');
        Route::post('/academy/prime/request/store', [PrimeAcademyRequestController::class, 'store'])->name('panel.prime.academy.requests.store');
        Route::get('/academy/prime/request/{id}/edit', [PrimeAcademyRequestController::class, 'edit'])->name('panel.prime.academy.requests.edit');
        Route::post('/academy/prime/request/{id}/update', [PrimeAcademyRequestController::class, 'update'])->name('panel.prime.academy.requests.update');
        Route::post('/academy/prime/request/delete', [PrimeAcademyRequestController::class, 'delete'])->name('panel.prime.academy.requests.delete');

        // SHOP COURSE ROUTE
        Route::get('/shop/courses', [CourseController::class, 'index'])->name('panel.shop.course.index');
        Route::get('/shop/course/create', [CourseController::class, 'create'])->name('panel.shop.course.create');
        Route::post('/shop/course/store', [CourseController::class, 'store'])->name('panel.shop.course.store');
        Route::get('/shop/course/{id}/edit', [CourseController::class, 'edit'])->name('panel.shop.course.edit');
        Route::post('/shop/course/{id}/update', [CourseController::class, 'update'])->name('panel.shop.course.update');
        Route::post('/shop/course/delete', [CourseController::class, 'delete'])->name('panel.shop.course.delete');

        // SHOP COURSE EPISODE ROUTE
        Route::get('/shop/courses/{course_id}/episodes', [CourseEpisodeController::class, 'index'])->name('panel.shop.course.episode.index');
        Route::get('/shop/course/{course_id}/episode/create', [CourseEpisodeController::class, 'create'])->name('panel.shop.course.episode.create');
        Route::post('/shop/course/episode/store', [CourseEpisodeController::class, 'store'])->name('panel.shop.course.episode.store');
        Route::get('/shop/course/episode/{id}/edit', [CourseEpisodeController::class, 'edit'])->name('panel.shop.course.episode.edit');
        Route::post('/shop/course/episode/{id}/update', [CourseEpisodeController::class, 'update'])->name('panel.shop.course.episode.update');
        Route::post('/shop/course/episode/{course_id}/delete', [CourseEpisodeController::class, 'delete'])->name('panel.shop.course.episode.delete');

        // CHUNKED VIDEO UPLOAD 
        Route::get('/shop/course/episode/{id}/upload',[UploadVideoController::class,'index'])->name('panel.shop.course.episode.upload.video.index');
        Route::post('/shop/course/episode/upload/store',[UploadVideoController::class,'store'])->name('panel.shop.course.episode.upload.video.store');
        
        // VIDEO DOWNLOAD
        Route::get('/shop/course/episode/download/{id}/{filename}',[VideoDownloadController::class,'download'])->name('panel.shop.course.episode.download.video');

        // COURSE CATEGORY ROUTE
        Route::get('/shop/courses/category', [CourseCategoryController::class, 'index'])->name('panel.shop.course.category.index');
        Route::get('/shop/course/category/create', [CourseCategoryController::class, 'create'])->name('panel.shop.course.category.create');
        Route::post('/shop/course/category/store', [CourseCategoryController::class, 'store'])->name('panel.shop.course.category.store');
        Route::get('/shop/course/category/{id}/edit', [CourseCategoryController::class, 'edit'])->name('panel.shop.course.category.edit');
        Route::post('/shop/course/category/{id}/update', [CourseCategoryController::class, 'update'])->name('panel.shop.course.category.update');
        Route::post('/shop/course/category/delete', [CourseCategoryController::class, 'delete'])->name('panel.shop.course.category.delete');

        // SHOP PRODUCT ROUTE
        Route::get('/shop/products', [ProductController::class, 'index'])->name('panel.shop.product.index');
        Route::get('/shop/product/create', [ProductController::class, 'create'])->name('panel.shop.product.create');
        Route::post('/shop/product/store', [ProductController::class, 'store'])->name('panel.shop.product.store');
        Route::get('/shop/product/{id}/edit', [ProductController::class, 'edit'])->name('panel.shop.product.edit');
        Route::post('/shop/product/{id}/update', [ProductController::class, 'update'])->name('panel.shop.product.update');
        Route::post('/shop/product/delete', [ProductController::class, 'delete'])->name('panel.shop.product.delete');

        // CHUNKED FILE UPLOAD 
        Route::get('/shop/product/file/{id}/upload',[UploadFileController::class,'index'])->name('panel.shop.product.upload.file.index');
        Route::post('/shop/product/file/upload/store',[UploadFileController::class,'store'])->name('panel.shop.product.upload.file.store');

        // FILE DOWNLOAD
        Route::get('/shop/product/file/download/{id}/{filename}',[FileDownloadController::class,'download'])->name('panel.shop.product.download.file');

         // PRO RESUME REQUEST ROUTE
         Route::get('/pro-resume-requests', [ProfessionalResumeRequestController::class, 'index'])->name('panel.pro.resume.request.index');
         Route::get('/pro-resume-requests/{id}/edit', [ProfessionalResumeRequestController::class, 'edit'])->name('panel.pro.resume.request.edit');
         Route::post('/pro-resume-requests/{id}/update', [ProfessionalResumeRequestController::class, 'update'])->name('panel.pro.resume.request.update');
         Route::post('/pro-resume-request/delete', [ProfessionalResumeRequestController::class, 'delete'])->name('panel.pro.resume.request.delete');

         // PRO RESUME TICKET ROUTE
         Route::get('{id}/pro-resume-ticket', [ProResumeTicketController::class, 'index'])->name('panel.pro.resume.ticket.index');
         Route::post('/pro-resume-ticket/store', [ProResumeTicketController::class, 'store'])->name('panel.pro.resume.ticket.store');
         
          // ADVERTISEMENT SETTING ROUTE
        Route::get('/advertisement/major', [AdMajorController::class, 'index'])->name('panel.major.index');
        Route::get('/advertisement/major/{id}/show', [AdMajorController::class, 'show'])->name('panel.major.show');
        Route::get('/advertisement/major/create', [AdMajorController::class, 'create'])->name('panel.major.create');
        Route::post('/advertisement/major/store', [AdMajorController::class, 'store'])->name('panel.major.store');
        Route::get('/advertisement/major/{id}/edit', [AdMajorController::class, 'edit'])->name('panel.major.edit');
        Route::post('/advertisement/major/{id}/update', [AdMajorController::class, 'update'])->name('panel.major.update');
        Route::post('/advertisement/major/delete', [AdMajorController::class, 'delete'])->name('panel.major.delete');
        
        // TICKET ROUTE
        Route::get('/tickets', [TicketController::class, 'index'])->name('panel.ticket.index');
        // Route::get('/ticket/{id}/show', [TicketController::class, 'show'])->name('panel.ticket.show');
        // Route::get('/ticket/create', [TicketController::class, 'create'])->name('panel.ticket.create');
        // Route::post('/ticket/store', [TicketController::class, 'store'])->name('panel.ticket.store');
        // Route::get('/ticket/{id}/edit', [TicketController::class, 'edit'])->name('panel.ticket.edit');
        Route::get('/ticket/{ticket}/close', [TicketController::class, 'close'])->name('panel.ticket.close');
        Route::post('/ticket/delete', [TicketController::class, 'delete'])->name('panel.ticket.delete');

         // TICKET CONTENT ROUTE
         Route::get('/ticket/{ticket}/contents', [TicketContentController::class, 'index'])->name('panel.ticket.content.index');
         Route::post('/ticket/content/store', [TicketContentController::class, 'store'])->name('panel.ticket.content.store');

    });

});



