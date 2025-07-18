<?php

namespace App\Http\Controllers\api;

use Exception;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use App\Models\Advertisement;
use App\Models\JobBackground;
use App\Models\FeatureManager;
use App\Http\Controllers\Controller;
use App\Models\AdvertisementSoftSkill;
use App\Models\AdvertisementJobBackground;
use App\Http\Resources\AdvertisementResource;

class SuggestedJobController extends Controller
{
    public function show()
    {

       

        try {

            $feature = FeatureManager::where('feature', 'SuggestedJobs')->first();

            if (!$feature->status) {
                return response()->json([
                 'message' =>   'this feature is disabled by admin'
                ], 400);
            }


            $jobs = [];

            //check the user has a plan
            if (!auth()->user()->userPlan) {
                return response()->json([
                 'message' =>   'ابتدا باید یک پکیج تهیه کنید'
                ]);
            }
            
                   

            //check the plan has how many suggested resume
            $suggestLimitation = auth()->user()->userPlan->suggestedJobsNumberLimitation();

            $res = auth()->user()->teacher;

            if ($res) {

                $resume = auth()->user()->teacher;


                $softSkills = AdvertisementSoftSkill::query();
                $softSkillsFlag = false;
                foreach ($resume->skills as $key => $skill) {

                    $array = explode(' ', $skill->title);

                    foreach ($array as $key => $word) {
                        $softSkills->orWhere('skill', 'LIKE', "%$word%");
                        $softSkillsFlag = true;
                    }
                }





                $advertisementJobBackground = AdvertisementJobBackground::query();
                $advertisementJobBackgroundFlag = false;

                if ($resume->jobBackgrounds != NULL) {
                    $advertisementJobBackground->orWhereNotNull('background')->orWhere('must_have_background', true);
                    $advertisementJobBackgroundFlag = true;
                }

                if ($resume->jobBackgrounds === NULL) {
                    $advertisementJobBackground->where('must_have_background', false)->orwhere('as_intern', true);
                    $advertisementJobBackgroundFlag = true;
                }




                if ($softSkillsFlag) {

                    foreach ($softSkills->get() as $key => $record) {
                        $jobs[] = $record->advertisement_id;
                    }

                }

                if ($advertisementJobBackgroundFlag) {

                    foreach ($advertisementJobBackground->get() as $key => $record) {
                        $jobs[] = $record->advertisement_id;
                    }

                }


                if ($jobs != NULL) {

                    foreach (array_unique($jobs) as $key => $id) {

                        $ads[] = Advertisement::where('id', $id)->get();

                    }

                } else {
                    $ads = [];
                }

            } else {
                $ads = [];
            }


            $suggestLimitation;
            $ads = collect(Arr::flatten($ads))->take($suggestLimitation);


            return AdvertisementResource::collection($ads);


        } catch (Exception $e) {

            return response()->json([
                'error' => $e->getMessage()
            ]);
        }


    }
}
