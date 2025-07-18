<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Resources\AdvertisementResource;
use App\Models\Advertisement;
use App\Models\UserAdWatch;
use Exception;
use Illuminate\Http\Request;

class UserAdWatchController extends Controller
{
    public function index()
    {
        try {

            $ads = Advertisement::whereHas('userAdWatch',function ($q){

                $q->where('user_id',auth()->user()->id);

            })->get();

            return AdvertisementResource::collection($ads);

        } catch (Exception $e) {

            return response()->json([
                'error' => $e->getMessage()
            ], 400);

        }
    }

    public function store(Request $request)
    {
        try {

            UserAdWatch::updateOrCreate(['user_id' => auth()->user()->id, 'advertisement_id' => $request->advertisement_id], [
                'user_id' => auth()->user()->id,
                'advertisement_id' => $request->advertisement_id
            ]);

            return response()->json([
              'message' =>  'advertisement added to watched list successfully'
            ]);

        } catch (Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], 400);
        }
    }
}
