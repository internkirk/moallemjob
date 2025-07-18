<?php

namespace App\Http\Controllers\api;

use Exception;
use App\Http\Controllers\Controller;
use App\Http\Resources\PlanResource;
use App\Models\Plan;
use App\Models\UserPlan;
use Illuminate\Http\Request;

class PlanController extends Controller
{
    public function index()
    {
        try {

            $plans = Plan::all();
            return PlanResource::collection($plans);

        } catch (\Exception $e) {

            return response()->json([
                'error' => $e->getMessage()
            ], 400);

        }
    }
    
     public function checkPlan()
    {

        try {

            

             if(auth()->user()->userPlan?->latest()->first() === NULL || auth()->user()->userPlan?->latest()->first()->isExpired()){
                return response()->json([
                    'message' => ' پکیجی خریداری نشده یا منقضی شده'
                ]);
            }


          $userPlan = UserPlan::where('user_id',auth()->user()->id)->where('plan_id',auth()->user()->userPlan->plan_id)->get();
          
          $plan = Plan::where('id',$userPlan->first()->plan_id)->get();
          
          return PlanResource::collection($plan);

            
        } catch (Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ],400);
        }
    }
}
