<?php

namespace App\Http\Controllers\api;

use Exception;
use Illuminate\Http\Request;
use App\Models\ProResumeUser;
use App\Http\Controllers\Controller;
use App\Http\Resources\ProResumeRequestsResource;
use App\Models\ProfessionalResumeRequest as ProResumeReqModel;

class ProfessionalResumeRequest extends Controller
{

    public function index()
    {

        try {

            $result = ProResumeUser::where('user_id', auth()->user()->id)->first();

            if ($result === NULL) {
                return response()->json([
                  'message' =>  'باید برای ثبت درخواست ، ابتدا هزینه را پرداخت کنید'   
                ]);
            }

           $req = ProResumeReqModel::where(
                'teacher_id',
                auth()->user()->teacher->id,
            )->get();

            return ProResumeRequestsResource::collection($req);

        } catch (Exception $e) {

            return response()->json([
                'error' => $e->getMessage()
            ], 400);

        }
    }

    public function store(Request $request)
    {

        try {

            $result = ProResumeUser::where('user_id', auth()->user()->id)->first();

            if ($result === NULL) {
                return response()->json([
                  'message' =>  'باید برای ثبت درخواست ، ابتدا هزینه را پرداخت کنید'   
                ]);
            }

           $record = ProResumeReqModel::create([
                'teacher_id' => auth()->user()->teacher->id,
                'description' => $request->description,
                'status' => true,
                'request_stage' => 'در انتظار بررسی توسط ادمین'
            ]);

            return response()->json([
                'message' => 'data saved successfully',
                'request_id' => $record->id
            ]);
        } catch (Exception $e) {

            return response()->json([
                'error' => $e->getMessage()
            ], 400);

        }
    }
}
