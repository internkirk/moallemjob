<?php

namespace App\Http\Controllers\api;

use Exception;
use Illuminate\Http\Request;
use App\Models\ProResumeUser;
use App\Models\ProResumeTicket;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Http\Resources\ProResumeResource;

class ProResumeRequestTicket extends Controller
{
    public function index($request_id)
    {

        try {

            $result = ProResumeUser::where('user_id', auth()->user()->id)->first();

            if ($result === NULL) {
                return response()->json([
                  'message' =>  'باید برای ثبت درخواست ، ابتدا هزینه را پرداخت کنید'   
                ]);
            }
            
            $tickets = ProResumeTicket::where('request_id', $request_id)->orderBy("created_at",'asc')->get();

            return ProResumeResource::collection($tickets);


        } catch (Exception $e) {

            return response()->json([
                'error' => $e->getMessage()
            ],400);

        }

    }
    public function store(Request $request)
    {


        try {

            $result = ProResumeUser::where('user_id', auth()->user()->id)->first();

            if ($result === NULL) {
                return response()->json([
                 'message' =>   'باید برای ثبت درخواست ، ابتدا هزینه را پرداخت کنید'   
                ]);
            }
            
            $request->validate([
                'text' => ['nullable'],
                'request_id' => ['required', 'exists:professional_resume_requests,id']
            ]);
    
    
           $ticket = ProResumeTicket::create([
                'text' => $request->text ? $request->text : ' ',
                'request_id' => $request->request_id,
                'is_admin' => false
            ]);
    
            if ($request->hasFile('file')) {
                $this->saveFile($request, $ticket->id);
            }

            return response()->json([
                'message' => 'data saved successfully'
            ]);


        } catch (Exception $e) {

            return response()->json([
                'error' => $e->getMessage()
            ],400);

        }

    }

    private function saveFile(Request $request, $id)
    {
        $path = [];

        Storage::disk('public')->deleteDirectory("/ticket/file/" . $id);

        Storage::disk('public')->makeDirectory('/ticket/file/');
        $path[] = "/storage/" . Storage::disk('public')->put("/ticket/file/" . $id, $request->file);

        ProResumeTicket::findOrFail($id)->update([
            'file' => json_encode($path)
        ]);
    }
}
