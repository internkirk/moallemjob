<?php

namespace App\Http\Controllers\api;


use App\Http\Controllers\Controller;
use App\Http\Resources\AcademyResource;
use App\Models\Academy;
use Exception;
use Illuminate\Http\Request;

class InstitueController extends Controller
{
    public function index()
    {
         try {

           $institues = Academy::whereHas('academyLevel',function($q){
                $q->whereIn('title',['آموزشگاه زبان خارجی','آموزشگاه علمی آزاد']);
            })->get();

          return AcademyResource::collection($institues);

         } catch (Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ]);
         }
    }
}
