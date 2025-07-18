<?php

namespace App\Http\Controllers\api;

use Exception;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\FeatureManager;
use App\Http\Controllers\Controller;
use App\Http\Resources\AdStatisticResource;

class AdStatisticController extends Controller
{
    public function AdvertisementWatchCount()
    {
        try {

            $feature = FeatureManager::where('feature','AdWatchCount')->first();

            if (!$feature->status) {
                return response()->json([
                 'message' =>   'this feature is disabled by admin'
                ],400);
            }

            $user = auth()->user();

           $user = User::where('id',$user->id)->get();

            return AdStatisticResource::collection($user);

        } catch (Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], 400);
        }
    }
}
