<?php

namespace App\Http\Controllers\api;

use Exception;
use App\Models\UserAdLike;
use Illuminate\Http\Request;
use App\Models\Advertisement;
use App\Http\Controllers\Controller;
use App\Http\Resources\AdvertisementResource;

class UserAdLikeController extends Controller
{
    public function index()
    {
        try {

            $ads = Advertisement::whereHas('userAdLike',function ($q){

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

            UserAdLike::updateOrCreate(['user_id' => auth()->user()->id, 'advertisement_id' => $request->advertisement_id], [
                'user_id' => auth()->user()->id,
                'advertisement_id' => $request->advertisement_id
            ]);

            return response()->json([
              'message' =>  'advertisement added to liked list successfully'
            ]);

        } catch (Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], 400);
        }
    }
    
     public function delete(Request $request)
    {
        try {

            UserAdLike::where('advertisement_id',$request->advertisement_id)->where('user_id',auth()->user()->id)->delete();

            return response()->json([
              'message' =>  'advertisement added to liked list successfully'
            ]);

        } catch (Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], 400);
        }
    }
}
