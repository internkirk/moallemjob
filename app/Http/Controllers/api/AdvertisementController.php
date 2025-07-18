<?php

namespace App\Http\Controllers\api;

use Exception;
use Illuminate\Support\Arr;
use App\Models\AdWatchCount;
use App\Models\Academy;
use Illuminate\Http\Request;
use App\Models\Advertisement;
use App\Http\Controllers\Controller;
use App\Models\AdvertisementEducation;
use App\Models\AdvertisementJobSalary;
use App\Models\AdMajor;
use App\Models\AdvertisementSoftSkill;
use App\Models\AdvertisementJobLocation;
use App\Models\AdvertisementJobBackground;
use App\Http\Resources\AdAnalyseResource;
use App\Models\AdvertisementJobDescription;
use App\Models\AdvertisementJobIntroduction;
use App\Models\AdvertisementJobRequirements;
use App\Http\Resources\AdvertisementResource;
use App\Models\AdvertisementAdditionalCondition;

class AdvertisementController extends Controller
{
    
    public function adAnalysis()
    {
        try {

            $user = auth()->user();

            $ads = Advertisement::where('user_id',$user->id)->get();

            if($ads == NULL || $ads->isEmpty()){
                return response()->json([
                    'message' => 'شما آگهی ثبت شده ندارید'
                ]);
            }

            return AdAnalyseResource::collection($ads);

        } catch (Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ]);
        }
    }
    
    public function addToUrgent(Request $request)
    {
       try {
        $user = auth()->user();

        $result = Advertisement::findOrFail($request->advertisement_id);

        if ($result == NULL) {
            return response()->json([
                'message' => 'اگهی وجود ندارد'
            ]);
        }

        if ($result->user_id != $user->id) {
            return response()->json([
                'message' => 'آگهی متعلق به شما نمیباشد'
            ]);
        }

        if ($user->userPlan?->latest()->first() == NULL) {
            return response()->json([
                'message' => 'باید ابتدا یک پکیج خریداری نمایید'
            ]);
        }
        if ($user->userPlan?->latest()->first()->plan->isExpired()) {
            return response()->json([
                'message' => 'پکیج شما منقضی شده است'
            ]);
        }

        if ($user->userPlan?->latest()->first()->plan->is_suggested_resume) {
            Advertisement::where('id', $request->advertisement_id)->update([
                'is_urgent' => true
            ]);

            return response()->json([
                'message' => 'updated'
            ]);

        } else {

            return response()->json([
                'message' => 'لطفا برای فوری بودن آگهی خود پکیج خود را ارتقا دهید'
            ]);

        }
       } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ]);
       }
    }

    
     public function addToFeatured(Request $request)
    {
         try {
            $user = auth()->user();
        
        $result = Advertisement::findOrFail($request->advertisement_id);

        if ($result == NULL) {
            return response()->json([
                'message' => 'اگهی وجود ندارد'
            ]);
        }

        if ($result->user_id != $user->id) {
            return response()->json([
                'message' => 'آگهی متعلق به شما نمیباشد'
            ]);
        }

        if ($user->userPlan?->latest()->first() == NULL) {
            return response()->json([
                'message' => 'باید ابتدا یک پکیج خریداری نمایید'
            ]);
        }

        if ($user->userPlan?->latest()->first()->plan->isExpired()) {
            return response()->json([
                'message' => 'پکیج شما منقضی شده است'
            ]);
        }


        $featured_ads = Advertisement::where('user_id', $user->id)->where('is_featured')->get();

        $featured_ad_qunatity_limitation = $user->userPlan?->latest()->first()->plan->outstanding_job_quantity;

        if ($featured_ads->count() >= $featured_ad_qunatity_limitation) {
            return response()->json([
                'message' => 'شما به محدودیت برجسته سازی آگهی های خود رسیده اید ، لطفا پکیج خود را ارتقا دهید'
            ]);
        }


        if ($user->userPlan?->latest()->first()->plan->is_suggested_resume) {
            Advertisement::where('id', $request->advertisement_id)->update([
                'is_featured' => true
            ]);

            return response()->json([
                'message' => 'updated'
            ]);

        } else {

            return response()->json([
                'message' => 'لطفا برای فوری بودن آگهی خود پکیج خود را ارتقا دهید'
            ]);

        }
        } catch (Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ]);
        }
    }

    ////////////////////////////   Filter Section   //////////////////////////////
    public function filterize(Request $request)
    {
        $result = $this->getStrategy($request);

        // dd($result);

        return AdvertisementResource::collection($result);
    }


    private function getStrategy($request)
    {
        if ($request->by_search) {
            return $this->filterBySearch($request);
        } else if ($request->by_select) {
            return $this->filterBySelect($request);
        }else if ($request->by_location) {
            return $this->filterByLocation($request);
        }else if ($request->by_search_main_page) {
            return $this->filterBySearchInMainpage($request);
        }else if ($request->by_academic_level) {
            return $this->filterByAcademyLevel($request);
        }
    }


    private function filterByAcademyLevel($request)
    {

        if($request->academic_level){   
            $advertisements = collect();
            
            $ad_id = AdvertisementJobIntroduction::where('academic_level',$request->academic_level)->get('advertisement_id');
            
            foreach($ad_id as $key => $id){
                $advertisements->push(Advertisement::where('id', $id->advertisement_id)->get());
            }
            
            return $advertisements->flatten()->unique();
        }
    }


    private function filterBySearch($request)
    {

        $advertisements = collect();

        $academy_user_ids = [];
        $advertisement_ids = [];

        if ($request->title) {
            $academy_user_ids = Academy::where('name', "LIKE", "%" . $request->title . "%")->get();
            $advertisement_ids = AdvertisementJobIntroduction::where('job_title', "LIKE", "%" . $request->title . "%")->orWhere('major', "LIKE", "%" . $request->title . "%")->get();
        }
        if($request->province){
            $academy_user_ids = Academy::where('province', $request->province)->get();
        }
        if($request->academy_level){
            $academy_user_ids = Academy::whereHas('academyLevel', function ($query) use ($request) {
                    $query->where('title', $request->academy_level);
            })->get();
        }

        
        
        foreach ($advertisement_ids as $key => $id) {
            $advertisements->push(Advertisement::where('id', $id->advertisement_id)->get());
        }
        
        foreach ($academy_user_ids as $key => $id) {
            $advertisements->push(Advertisement::where('user_id', $id->user_id)->get());
        }

        return $advertisements->flatten()->unique();
    }
    
    private function filterBySearchInMainpage($request)
    {

        $advertisements = collect();

        $academy_user_ids = [];
        $advertisement_ids = [];

        if ($request->title) {
            $academy_user_ids = Academy::where('name', "LIKE", "%" . $request->title . "%")->get();
            $advertisement_ids = AdvertisementJobIntroduction::where('job_title', "LIKE", "%" . $request->title . "%")->orWhere('major', "LIKE", "%" . $request->title . "%")->get();

        }

        if ($request->province_or_city) {
            $academy_user_ids = Academy::where('province', $request->province_or_city)->orWhere('city' ,$request->province_or_city)->get();
        }

        if ($request->academy_level) {
            $academy_user_ids = Academy::whereHas('academyLevel', function ($query) use ($request) {
                $query->where('title', $request->academy_level);
            })->get();
        }

        foreach ($advertisement_ids as $key => $id) {
            $advertisements->push(Advertisement::where('id', $id->advertisement_id)->get());
        }

        foreach ($academy_user_ids as $key => $id) {
            $advertisements->push(Advertisement::where('user_id', $id->user_id)->get());
        }

        return $advertisements->flatten()->unique();
    }

    
     private function filterByLocation($request)
    {
        $advertisements = collect();

        $academy_user_ids = [];

        if ($request->province) {
            $academy_user_ids = Academy::where('province', $request->province)->get();
        }

        foreach ($academy_user_ids as $key => $id) {
            $advertisements->push(Advertisement::where('user_id', $id->user_id)->get());
        }

        return $advertisements->flatten()->unique();
    }

    private function filterBySelect($request)
    {

    }
    
    
     public function similarJobs($id)
    {

        $result = $this->getSimilarJobsStrategy($id);

        return AdvertisementResource::collection($result);
    }

    private function getSimilarJobsStrategy($id)
    {
        $results = collect();

        $results[] = $this->byProvince($id);
        $results[] = $this->byAcademyLevel($id);

     
        return $results->first()->flatten()->unique();
    }

    private function byProvince($id)
    {
        $advertisement = Advertisement::where('id', $id)->get();

        $academies = Advertisement::whereHas('location', function($query)use($advertisement){
            $query->where('province',$advertisement->first()->location?->province);
        })->get();

        return $academies;
    }
    private function byAcademyLevel($id)
    {
        $advertisement = Advertisement::where('id', $id)->get();
        
        foreach ($advertisement->first()->user->academy->academyLevel as $key => $academy_level) {
            $academy_user_ids = Advertisement::whereHas('user.academy.academyLevel', function ($query) use ($academy_level) {
                $query->where('title', $academy_level->title);
            })->get();
        }

        return $academy_user_ids;
    }

 ////////////////////////////   Get Section   //////////////////////////////

    public function index()
    {
        try {
            $ads = [];

            $ads[] = Advertisement::whereHas('user.userPlan.plan', function ($q) {

                $q->where('is_two_possibility_in_search_results', true);

            })->get();
            $ads[] = Advertisement::whereHas('user.userPlan.plan', function ($q) {

                $q->where('is_two_possibility_to_visit_by_job_seekers', true);

            })->get();
            $ads[] = Advertisement::whereHas('user.userPlan.plan', function ($q) {

                $q->where('is_one_and_half_possibility_in_search_results', true);

            })->get();
            $ads[] = Advertisement::whereHas('user.userPlan.plan', function ($q) {

                $q->where('is_one_and_half_possibility_to_visit_by_job_seekers', true);

            })->get();


            
            $ads[] = Advertisement::all();
            $ads = Arr::flatten($ads);
            
            $finalAds = [];
            foreach (array_unique($ads) as $key => $ad) {
                if (!$ad->advertisementExpired()) {
                    $finalAds[] = $ad;
                }
            }
            
            return AdvertisementResource::collection(array_unique(Arr::flatten($finalAds)));

        } catch (Exception $e) {

            return response()->json([
                'error' => $e->getMessage()
            ], 400);
        }
    }


    public function show($id)
    {
        try {


            $res = AdWatchCount::where('advertisement_id', $id)->first();
            if ($res === NULL) {
                AdWatchCount::create([
                    'advertisement_id' => $id,
                    'count' => 1
                ]);
            } else {
                $result = Advertisement::where('id', $id)->first();

                if($result === NULL){   
                    AdWatchCount::where('advertisement_id', $id)->update([
                        'advertisement_id' => $id,
                        'count' => $res->count + 1
                    ]);
                }
            }


            $advertisements = Advertisement::where('id', $id)->get();
            
            
            
            return AdvertisementResource::collection($advertisements);

        } catch (Exception $e) {

            return response()->json([
                'error' => $e->getMessage()
            ], 400);
        }
    }

    public function getAdvertisement()
    {
        try {

            $advertisements = Advertisement::where('user_id', auth()->user()->id)->get();

            return AdvertisementResource::collection($advertisements);

        } catch (Exception $e) {

            return response()->json([
                'error' => $e->getMessage()
            ], 400);
        }
    }
    
    public function getMajors()
    {
        try {

            $advertisements = AdMajor::all();

            return $advertisements;

        } catch (Exception $e) {

            return response()->json([
                'error' => $e->getMessage()
            ], 400);
        }
    }

    public function jobIntroduction(Request $request)
    {

        if (auth()->user()->reachedRecruitmentDeclarationExpireTime()) {
            response()->json([
                'message' => 'شما به محدودیت انتشار آگهی پکیج خود رسیده اید ، لطفا برای انتشار آگهی یک پکیج خریداری نمایید'
            ]);
        }
        ;

        try {

            $request->validate([
                'job_title' => ['required', 'max:255'],
                'academic_level' => ['required', 'max:255'],
                'school_role' => ['required', 'max:255'],
                'academic_section' => ['required', 'max:255'],
                'major' => ['required', 'max:255'],
                'cooperation_type' => ['required', 'max:255'],
            ]);

            // $res = Advertisement::where('user_id', auth()->user()->id)->first();

            // if ($res) {
            //     $advertisement = Advertisement::where('user_id', auth()->user()->id)->first();
            // } else {
                $advertisement = Advertisement::create([
                    'user_id' => auth()->user()->id,
                ]);
            // }


            AdvertisementJobIntroduction::updateOrCreate(['advertisement_id' => $advertisement->id], [
                'advertisement_id' => $advertisement->id,
                'job_title' => $request->job_title,
                'academic_level' => $request->academic_level,
                'school_role' => $request->school_role,
                'academic_section' => $request->academic_section,
                'major' => json_encode($request->major,JSON_UNESCAPED_UNICODE),
                'cooperation_type' => $request->cooperation_type,
            ]);

            return response()->json([
                'message' => 'date saved successfully',
                // 'advertisement_id' => $advertisement->id
            ]);

        } catch (Exception $e) {

            return response()->json([
                'error' => $e->getMessage()
            ], 400);
        }
    }


    public function location(Request $request)
    {

        if (auth()->user()->reachedRecruitmentDeclarationExpireTime()) {
            response()->json([
                'message' => 'شما به محدودیت انتشار آگهی پکیج خود رسیده اید ، لطفا برای انتشار آگهی یک پکیج خریداری نمایید'
            ]);
        }

        try {

            $request->validate([
                'province' => ['required'],
                'city' => ['required'],
            ]);

            // $res = Advertisement::where('user_id', auth()->user()->id)->first();

            // if ($res) {
                $advertisement = Advertisement::where('user_id', auth()->user()->id)->latest('created_at')->first();
        
            // } else {
            //     $advertisement = Advertisement::create([
            //         'user_id' => auth()->user()->id,
            //     ]);
            // }

            AdvertisementJobLocation::updateOrCreate(['advertisement_id' => $advertisement->id], [
                'advertisement_id' => $advertisement->id,
                'city' => $request->city,
                'province' => $request->province,
            ]);

            return response()->json([
                'message' => 'date saved successfully',
                'advertisement_id' => $advertisement->id
            ]);

        } catch (Exception $e) {

            return response()->json([
                'error' => $e->getMessage()
            ], 400);
        }
    }


    public function requirement(Request $request)
    {

        if (auth()->user()->reachedRecruitmentDeclarationExpireTime()) {
            response()->json([
                'message' => 'شما به محدودیت انتشار آگهی پکیج خود رسیده اید ، لطفا برای انتشار آگهی یک پکیج خریداری نمایید'
            ]);
        }
        ;

        try {

            $request->validate([
                'min_age' => ['required'],
                'max_age' => ['required'],
                'sex' => ['required'],
            ]);

            // $res = Advertisement::where('user_id', auth()->user()->id)->first();

            // if ($res) {
                $advertisement = Advertisement::where('user_id', auth()->user()->id)->latest('created_at')->first();
            // } else {
            //     $advertisement = Advertisement::create([
            //         'user_id' => auth()->user()->id,
            //     ]);
            // }

            AdvertisementJobRequirements::updateOrCreate(['advertisement_id' => $advertisement->id], [
                'advertisement_id' => $advertisement->id,
                'min_age' => $request->min_age,
                'max_age' => $request->max_age,
                'sex' => $request->sex,
            ]);

            return response()->json([
                'message' => 'date saved successfully',
                'advertisement_id' => $advertisement->id
            ]);

        } catch (Exception $e) {

            return response()->json([
                'error' => $e->getMessage()
            ], 400);
        }
    }


    public function salary(Request $request)
    {

        if (auth()->user()->reachedRecruitmentDeclarationExpireTime()) {
            response()->json([
                'message' => 'شما به محدودیت انتشار آگهی پکیج خود رسیده اید ، لطفا برای انتشار آگهی یک پکیج خریداری نمایید'
            ]);
        }
        ;

        try {

            $request->validate([
                'min_salary' => ['required'],
                'max_salary' => ['required'],
            ]);

            // $res = Advertisement::where('user_id', auth()->user()->id)->first();

            // if ($res) {
                $advertisement = Advertisement::where('user_id', auth()->user()->id)->latest('created_at')->first();
            // } else {
            //     $advertisement = Advertisement::create([
            //         'user_id' => auth()->user()->id,
            //     ]);
            // }

            AdvertisementJobSalary::updateOrCreate(['advertisement_id' => $advertisement->id], [
                'advertisement_id' => $advertisement->id,
                'min_salary' => $request->min_salary,
                'max_salary' => $request->max_salary,
                'benefits' => $request->benefits,
            ]);

            return response()->json([
                'message' => 'date saved successfully',
                'advertisement_id' => $advertisement->id
            ]);

        } catch (Exception $e) {

            return response()->json([
                'error' => $e->getMessage()
            ], 400);
        }
    }


    public function jobBackground(Request $request)
    {

        if (auth()->user()->reachedRecruitmentDeclarationExpireTime()) {
            response()->json([
                'message' => 'شما به محدودیت انتشار آگهی پکیج خود رسیده اید ، لطفا برای انتشار آگهی یک پکیج خریداری نمایید'
            ]);
        }
        ;

        try {

            $request->validate([
                'as_intern' => ['required'],
                'must_have_background' => ['required'],
                'background' => ['required_if:must_have_background,true'],
            ]);

            // $res = Advertisement::where('user_id', auth()->user()->id)->first();

            // if ($res) {
                $advertisement = Advertisement::where('user_id', auth()->user()->id)->latest('created_at')->first();
            // } else {
            //     $advertisement = Advertisement::create([
            //         'user_id' => auth()->user()->id,
            //     ]);
            // }

            AdvertisementJobBackground::updateOrCreate(['advertisement_id' => $advertisement->id], [
                'advertisement_id' => $advertisement->id,
                'as_intern' => $request->as_intern,
                'must_have_background' => $request->must_have_background,
                'background' => $request->background,
            ]);

            return response()->json([
                'message' => 'date saved successfully',
                'advertisement_id' => $advertisement->id
            ]);

        } catch (Exception $e) {

            return response()->json([
                'error' => $e->getMessage()
            ], 400);
        }
    }


    public function additionalCondition(Request $request)
    {

        if (auth()->user()->reachedRecruitmentDeclarationExpireTime()) {
            response()->json([
                'message' => 'شما به محدودیت انتشار آگهی پکیج خود رسیده اید ، لطفا برای انتشار آگهی یک پکیج خریداری نمایید'
            ]);
        }
        ;

        try {

            $request->validate([
                'military_service' => ['required'],
                'selection_certificate' => ['required'],
                'no_crime_certificate' => ['required'],
            ]);

            // $res = Advertisement::where('user_id', auth()->user()->id)->first();

            // if ($res) {
                $advertisement = Advertisement::where('user_id', auth()->user()->id)->latest('created_at')->first();
            // } else {
            //     $advertisement = Advertisement::create([
            //         'user_id' => auth()->user()->id,
            //     ]);
            // }

            AdvertisementAdditionalCondition::updateOrCreate(['advertisement_id' => $advertisement->id], [
                'advertisement_id' => $advertisement->id,
                'military_service' => $request->military_service,
                'selection_certificate' => $request->selection_certificate,
                'no_crime_certificate' => $request->no_crime_certificate,
            ]);

            return response()->json([
                'message' => 'date saved successfully',
                'advertisement_id' => $advertisement->id
            ]);

        } catch (Exception $e) {

            return response()->json([
                'error' => $e->getMessage()
            ], 400);
        }
    }


    public function education(Request $request)
    {
        
        

        if (auth()->user()->reachedRecruitmentDeclarationExpireTime()) {
            response()->json([
                'message' => 'شما به محدودیت انتشار آگهی پکیج خود رسیده اید ، لطفا برای انتشار آگهی یک پکیج خریداری نمایید'
            ]);
        }
        ;

        try {

            $request->validate([
                'major' => ['required'],
                'academic_level' => ['required'],
            ]);

            // $res = Advertisement::where('user_id', auth()->user()->id)->first();

            // if ($res) {
                $advertisement = Advertisement::where('user_id', auth()->user()->id)->latest('created_at')->first();
            // } else {
            //     $advertisement = Advertisement::create([
            //         'user_id' => auth()->user()->id,
            //     ]);
            // }

            // AdvertisementEducation::where('advertisement_id', $advertisement->id)->delete();

            // foreach ($request->major as $key => $major) {
            //     AdvertisementEducation::updateOrCreate(['advertisement_id' => $advertisement->id, 'major' => $major, 'academic_level' => $request->academic_level[$key]], [
            //         'advertisement_id' => $advertisement->id,
            //         'major' => $major,
            //         'academic_level' => $request->academic_level[$key],
            //     ]);
            // }
            
            
            
            
            // $request->validate([
            //     'major' => ['required'],
            //     'academic_level' => ['required'],
            // ]);


            $majors = [];
            $academic_levels = [];

            $request_majors = explode(",", $request->major[0]);


            foreach ($request_majors as $key => $major) {
                $majors[] = $major;
            }

            $request_academic_levels = explode(",", $request->academic_level[0]);

            foreach ($request_academic_levels as $key => $academic_level) {
                $academic_levels[] = $academic_level;
            }


            // AdvertisementEducation::where('advertisement_id', $advertisement->id)->delete();

            foreach ($majors as $key => $major) {
                AdvertisementEducation::updateOrCreate(['advertisement_id' => $advertisement->id, 'major' => $major, 'academic_level' => $academic_levels[$key]], [
                    'advertisement_id' => $advertisement->id,
                    'major' => $major,
                    'academic_level' => $academic_levels[$key],
                ]);
            }

            return response()->json([
                'message' => 'date saved successfully',
                'advertisement_id' => $advertisement->id
            ]);

        } catch (Exception $e) {

            return response()->json([
                'error' => $e->getMessage()
            ], 400);
        }
    }


    public function softSkill(Request $request)
    {

        if (auth()->user()->reachedRecruitmentDeclarationExpireTime()) {
            response()->json([
                'message' => 'شما به محدودیت انتشار آگهی پکیج خود رسیده اید ، لطفا برای انتشار آگهی یک پکیج خریداری نمایید'
            ]);
        }
        ;

        try {

            $request->validate([
                'skill' => ['required'],
            ]);

            // $res = Advertisement::where('user_id', auth()->user()->id)->first();

            // if ($res) {
                $advertisement = Advertisement::where('user_id', auth()->user()->id)->latest('created_at')->first();
            // } else {
            //     $advertisement = Advertisement::create([
            //         'user_id' => auth()->user()->id,
            //     ]);
            // }

            // AdvertisementSoftSkill::where('advertisement_id', $advertisement->id)->delete();

            // foreach ($request->skill as $key => $skill) {
            //     AdvertisementSoftSkill::updateOrCreate(['advertisement_id' => $advertisement->id, 'skill' => $skill], [
            //         'advertisement_id' => $advertisement->id,
            //         'skill' => $skill,
            //     ]);
            // }
            
            
            $skills = [];

            $request_skills = explode(",", $request->skill[0]);


            foreach ($request_skills as $key => $major) {
                $skills[] = $major;
            }

            AdvertisementSoftSkill::where('advertisement_id', $advertisement->id)->delete();

            foreach ($request_skills as $key => $skill) {
                AdvertisementSoftSkill::updateOrCreate(['advertisement_id' => $advertisement->id, 'skill' => $skill], [
                    'advertisement_id' => $advertisement->id,
                    'skill' => $skill,
                ]);
            }

            return response()->json([
                'message' => 'date saved successfully',
                'advertisement_id' => $advertisement->id
            ]);

        } catch (Exception $e) {

            return response()->json([
                'error' => $e->getMessage()
            ], 400);
        }
    }

    public function jobDescription(Request $request)
    {

        if (auth()->user()->reachedRecruitmentDeclarationExpireTime()) {
            response()->json([
                'message' => 'شما به محدودیت انتشار آگهی پکیج خود رسیده اید ، لطفا برای انتشار آگهی یک پکیج خریداری نمایید'
            ]);
        }
        ;

        try {

            $request->validate([
                'job_time' => ['required'],
            ]);

            // $res = Advertisement::where('user_id', auth()->user()->id)->first();

            // if ($res) {
                $advertisement = Advertisement::where('user_id', auth()->user()->id)->latest('created_at')->first();
            // } else {
            //     $advertisement = Advertisement::create([
            //         'user_id' => auth()->user()->id,
            //     ]);
            // }

            AdvertisementJobDescription::updateOrCreate(['advertisement_id' => $advertisement->id], [
                'advertisement_id' => $advertisement->id,
                'job_time' => $request->job_time,
                'job_description' => $request->job_description,
            ]);

            return response()->json([
                'message' => 'date saved successfully',
                'advertisement_id' => $advertisement->id
            ]);

        } catch (Exception $e) {

            return response()->json([
                'error' => $e->getMessage()
            ], 400);
        }
    }
 


    ////////////////////////////   Update Section //////////////////////////////

    public function jobIntroductionUpdate(Request $request, $advertisement_id)
    {

        if (auth()->user()->reachedRecruitmentDeclarationExpireTime() || auth()->user()->reachedRecruitmentDeclarationQuantityLimitation(auth()->user()->advertisements?->count())) {
           return response()->json([
                'message' => 'شما به محدودیت انتشار آگهی پکیج خود رسیده اید ، لطفا برای انتشار آگهی یک پکیج خریداری نمایید'
            ]);
        }

        try {

            $request->validate([
                'job_title' => ['required', 'max:255'],
                'academic_level' => ['required', 'max:255'],
                'school_role' => ['required', 'max:255'],
                'academic_section' => ['required', 'max:255'],
                'major' => ['required', 'max:255'],
                'cooperation_type' => ['required', 'max:255'],
            ]);



            AdvertisementJobIntroduction::where('advertisement_id', $advertisement_id)->update([
                'advertisement_id' => $advertisement_id,
                'job_title' => $request->job_title,
                'academic_level' => $request->academic_level,
                'school_role' => $request->school_role,
                'academic_section' => $request->academic_section,
                'major' => json_encode($request->major,JSON_UNESCAPED_UNICODE),
                'cooperation_type' => $request->cooperation_type,
            ]);

            return response()->json([
                'message' => 'updated successfully',
            ]);

        } catch (Exception $e) {

            return response()->json([
                'error' => $e->getMessage()
            ], 400);
        }
    }


    public function locationUpdate(Request $request, $advertisement_id)
    {

        if (auth()->user()->reachedRecruitmentDeclarationExpireTime()) {
            response()->json([
                'message' => 'شما به محدودیت انتشار آگهی پکیج خود رسیده اید ، لطفا برای انتشار آگهی یک پکیج خریداری نمایید'
            ]);
        }
        ;

        try {

            $request->validate([
                'province' => ['required'],
                'city' => ['required'],
            ]);


            AdvertisementJobLocation::where('advertisement_id', $advertisement_id)->update([
                'advertisement_id' => $advertisement_id,
                'city' => $request->city,
                'province' => $request->province,
            ]);

            return response()->json([
                'message' => 'updated successfully',
            ]);

        } catch (Exception $e) {

            return response()->json([
                'error' => $e->getMessage()
            ], 400);
        }
    }


    public function requirementUpdate(Request $request, $advertisement_id)
    {

        if (auth()->user()->reachedRecruitmentDeclarationExpireTime()) {
            response()->json([
                'message' => 'شما به محدودیت انتشار آگهی پکیج خود رسیده اید ، لطفا برای انتشار آگهی یک پکیج خریداری نمایید'
            ]);
        }
        ;

        try {

            $request->validate([
                'min_age' => ['required'],
                'max_age' => ['required'],
                'sex' => ['required'],
            ]);


            AdvertisementJobRequirements::where('advertisement_id', $advertisement_id)->update([
                'advertisement_id' => $advertisement_id,
                'min_age' => $request->min_age,
                'max_age' => $request->max_age,
                'sex' => $request->sex,
            ]);

            return response()->json([
                'message' => 'updated successfully',
            ]);

        } catch (Exception $e) {

            return response()->json([
                'error' => $e->getMessage()
            ], 400);
        }
    }


    public function salaryUpdate(Request $request, $advertisement_id)
    {

        if (auth()->user()->reachedRecruitmentDeclarationExpireTime()) {
            response()->json([
                'message' => 'شما به محدودیت انتشار آگهی پکیج خود رسیده اید ، لطفا برای انتشار آگهی یک پکیج خریداری نمایید'
            ]);
        }
        ;

        try {

            $request->validate([
                'min_salary' => ['required'],
                'max_salary' => ['required'],
            ]);


            AdvertisementJobSalary::where('advertisement_id', $advertisement_id)->update([
                'advertisement_id' => $advertisement_id,
                'min_salary' => $request->min_salary,
                'max_salary' => $request->max_salary,
                'benefits' => $request->benefits,
            ]);

            return response()->json([
                'message' => 'updated successfully',
            ]);

        } catch (Exception $e) {

            return response()->json([
                'error' => $e->getMessage()
            ], 400);
        }
    }


    public function jobBackgroundUpdate(Request $request, $advertisement_id)
    {

        if (auth()->user()->reachedRecruitmentDeclarationExpireTime()) {
            response()->json([
                'message' => 'شما به محدودیت انتشار آگهی پکیج خود رسیده اید ، لطفا برای انتشار آگهی یک پکیج خریداری نمایید'
            ]);
        }
        ;

        try {

            $request->validate([
                'as_intern' => ['required'],
                'must_have_background' => ['required'],
                'background' => ['required_if:must_have_background,true'],
            ]);


            AdvertisementJobBackground::where('advertisement_id', $advertisement_id)->update([
                'advertisement_id' => $advertisement_id,
                'as_intern' => $request->as_intern,
                'must_have_background' => $request->must_have_background,
                'background' => $request->background,
            ]);

            return response()->json([
                'message' => 'updated successfully',
            ]);

        } catch (Exception $e) {

            return response()->json([
                'error' => $e->getMessage()
            ], 400);
        }
    }


    public function additionalConditionUpdate(Request $request, $advertisement_id)
    {

        if (auth()->user()->reachedRecruitmentDeclarationExpireTime()) {
            response()->json([
                'message' => 'شما به محدودیت انتشار آگهی پکیج خود رسیده اید ، لطفا برای انتشار آگهی یک پکیج خریداری نمایید'
            ]);
        }

        try {

            $request->validate([
                'military_service' => ['required'],
                'selection_certificate' => ['required'],
                'no_crime_certificate' => ['required'],
            ]);

            AdvertisementAdditionalCondition::where('advertisement_id', $advertisement_id)->update([
                'advertisement_id' => $advertisement_id,
                'military_service' => $request->military_service,
                'selection_certificate' => $request->selection_certificate,
                'no_crime_certificate' => $request->no_crime_certificate,
            ]);

            return response()->json([
                'message' => 'updated successfully',
            ]);

        } catch (Exception $e) {

            return response()->json([
                'error' => $e->getMessage()
            ], 400);
        }
    }


    public function educationDelete($id)
    {
        try {

            AdvertisementEducation::where('id', $id)->delete();

            return response()->json([
                'message' => ' deleted successfully',
            ]);

        } catch (Exception $e) {

            return response()->json([
                'error' => $e->getMessage()
            ], 400);
        }
    }

    public function educationUpdate(Request $request, $advertisement_id)
    {

        if (auth()->user()->reachedRecruitmentDeclarationExpireTime()) {
            response()->json([
                'message' => 'شما به محدودیت انتشار آگهی پکیج خود رسیده اید ، لطفا برای انتشار آگهی یک پکیج خریداری نمایید'
            ]);
        }
        ;

        try {
            
         $majors =[];
         $academic_levels =[];
         
         $request_majors = explode(",",$request->major[0]);
         

        foreach ($request_majors as $key => $major) {
           $majors[] = $major;
        }
        
        $request_academic_levels = explode(",",$request->academic_level[0]);
        
        foreach ($request_academic_levels as $key => $academic_level) {
           $academic_levels[] = $academic_level;
        }

            $request->validate([
                'major' => ['required'],
                'academic_level' => ['required'],
            ]);


            // AdvertisementEducation::where('advertisement_id', $advertisement_id)->delete();

             foreach ($majors as $key => $major) {
                AdvertisementEducation::updateOrCreate(['advertisement_id' => $advertisement_id, 'major' => $major, 'academic_level' => $academic_levels[$key]], [
                    'advertisement_id' => $advertisement_id,
                    'major' => $major,
                    'academic_level' => $academic_levels[$key],
                ]);
            }
            return response()->json([
                'message' => ' updated successfully',
            ]);

        } catch (Exception $e) {

            return response()->json([
                'error' => $e->getMessage()
            ], 400);
        }
    }


    public function skillSoftDelete($id)
    {
        try {

            AdvertisementSoftSkill::where('id', $id)->delete();

            return response()->json([
                'message' => ' deleted successfully',
            ]);

        } catch (Exception $e) {

            return response()->json([
                'error' => $e->getMessage()
            ], 400);
        }
    }

    public function softSkillUpdate(Request $request, $advertisement_id)
    {

        if (auth()->user()->reachedRecruitmentDeclarationExpireTime()) {
            response()->json([
                'message' => 'شما به محدودیت انتشار آگهی پکیج خود رسیده اید ، لطفا برای انتشار آگهی یک پکیج خریداری نمایید'
            ]);
        }

        try {

            $request->validate([
                'skill' => ['required'],
            ]);

           
            $skills =[];
            
            $request_skills = explode(",",$request->skill[0]);
            
   
           foreach ($request_skills as $key => $major) {
              $skills[] = $major;
           }

            AdvertisementSoftSkill::where('advertisement_id', $advertisement_id)->delete();

            foreach ($request_skills as $key => $skill) {
                AdvertisementSoftSkill::updateOrCreate(['advertisement_id' => $advertisement_id, 'skill' => $skill], [
                    'advertisement_id' => $advertisement_id,
                    'skill' => $skill,
                ]);
            }

            return response()->json([
                'message' => 'date updated successfully',
            ]);

        } catch (Exception $e) {

            return response()->json([
                'error' => $e->getMessage()
            ], 400);
        }
    }

    public function jobDescriptionUpdate(Request $request, $advertisement_id)
    {

        if (auth()->user()->reachedRecruitmentDeclarationExpireTime()) {
            response()->json([
                'message' => 'شما به محدودیت انتشار آگهی پکیج خود رسیده اید ، لطفا برای انتشار آگهی یک پکیج خریداری نمایید'
            ]);
        }
        ;

        try {

            $request->validate([
                'job_time' => ['required'],
            ]);


            AdvertisementJobDescription::where('advertisement_id', $advertisement_id)->update([
                'advertisement_id' => $advertisement_id,
                'job_time' => $request->job_time,
                'job_description' => $request->job_description,
            ]);

            return response()->json([
                'message' => 'date updated successfully',
            ]);

        } catch (Exception $e) {

            return response()->json([
                'error' => $e->getMessage()
            ], 400);
        }
    }

    public function advertisementDelete($advertisement_id)
    {
        try {
            Advertisement::findOrFail($advertisement_id)->delete();

            return response()->json([
                'message' => 'date deleted successfully',
            ]);

        } catch (Exception $e) {

            return response()->json([
                'error' => $e->getMessage()
            ], 400);
        }
    }
}
