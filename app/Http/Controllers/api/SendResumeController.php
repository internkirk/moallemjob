<?php

namespace App\Http\Controllers\api;

use Exception;
use App\Models\Teacher;
use App\Http\Resources\GetResumeHistoryResource;
use Illuminate\Support\Arr;
use App\Http\Resources\ResumeAdvertisementResource;
use Illuminate\Http\Request;
use App\Models\Advertisement;
use App\Models\ResumeAdvertisement;
use App\Http\Controllers\Controller;
use App\Http\Resources\TeacherResource;
use App\Http\Resources\AdvertisementResource;

class SendResumeController extends Controller
{
    public function store(Request $request)
    {
        try {





            $request->validate([
                'advertisement_id' => ['required', 'exists:advertisements,id']
            ]);

            // $result = ResumeAdvertisement::where('advertisement_id', $request->advertisement_id)->where('resume_id', auth()->user()->teacher->id)->get();

            // if (auth()->user()->reachedRecruitmentDeclarationQuantityLimitation($result->count())) {
            //     return response()->json([
            //      'message' => 'شما به محدودیت ارسال اگهی خود رسیده اید ، لطفا پنل خود را ارتقا دهید'
            //     ]);
            // }
            
            
            $user = auth()->user()->teacher;

            if ($user === NULL) {
                return response()->json([
                    'message' => 'برای ارسال رزومه ، ابتدا باید رزومه خود را پر کنید'
                ]);
            }


            $res = ResumeAdvertisement::where('advertisement_id', $request->advertisement_id)->where('resume_id', auth()->user()->teacher->id)->first();

            if ($res != NULL) {
                return response()->json([
                  'message' =>  'شما قبلا برای این آگهی رزومه خود را ارسال کرده اید'
                ]);
            }

            ResumeAdvertisement::create([
                'advertisement_id' => $request->advertisement_id,
                'resume_id' => auth()->user()->teacher->id,
                'status' => 'ارسال شده'
            ]);
            
            
            return response()->json([
                'message' => 'success'
            ]);

        } catch (Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], 400);
        }
    }
    
    public function checkResumeAlreadySended(Request $request)
    {

         try {


            $res = ResumeAdvertisement::where('advertisement_id', $request->advertisement_id)->where('resume_id', auth()->user()->teacher->id)->first();

            if ($res != NULL) {
                // $teacher = Teacher::findOrFail(auth()->user()->teacher->id);

                return response()->json([
                    'message' => 'غیر مجاز',
                    // 'resume' => TeacherResource::collection($teacher)
                ]);
            } else {
                return response()->json([
                    'message' => 'مجاز'
                ]);
            }

        } catch (Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], 400);
        }
    }
    
    public function sendResumeHistory()
    {
        try {

            // $advertisement_resumes = auth()->user()->teacher->advertisementResume;

            // $ads = [];
            
             $result = ResumeAdvertisement::where('resume_id',auth()->user()->teacher->id)->get();
            
            // dd($result);
 
            // if ($advertisement_resumes != NULL) {
            //     foreach ($advertisement_resumes as $key => $advertisement_resume) {
            //         $ads[] = ResumeAdvertisement::where('advertisement_id', $advertisement_resume->advertisement_id)->where('resume_id',auth()->user()->teacher->id)->get();
            //     }
            // }

            return ResumeAdvertisementResource::collection($result);

        } catch (Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], 400);
        }
    }
    
    public function getResumeHistory($advertisement_id)
    {
        

        try {

            $user = auth()->user();

           $advertisement = Advertisement::findOrFail($advertisement_id);
        

            if($user->id != $advertisement->user_id){
                return response()->json([
                    'message' => 'آگهی متعلق به شما نمیباشد'
                ]);
            }

            $result = ResumeAdvertisement::where('advertisement_id',$advertisement_id)->get();

            return GetResumeHistoryResource::collection($result);

        } catch (Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], 400);
        }
    }
    
    
    public function allGetResumeHistory()
    {
        
        try {
            
            $user = auth()->user();
    
            $advertisement = ResumeAdvertisement::whereHas('advertisement.user',function($q)use($user){
                $q->where('id',$user->id);
            })->get();

            return GetResumeHistoryResource::collection($advertisement);

        } catch (Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], 400);
        }
    }
    
    public function getResume($id)
    {
        try {
                
            $resume_advertisement = ResumeAdvertisement::where('id',$id)->get();

            return GetResumeHistoryResource::collection($resume_advertisement);

        } catch (Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], 400);
        }
    }
    
    public function sendResumeHistoryById($id)
    {
        try {

            $user = auth()->user();
            
            
            
             if ($user->teacher == NULL)
                return response()->json([
                    'message' => 'برای دریافت اطلاعات باید معلم باشید'
                ]);

            $record = ResumeAdvertisement::findOrFail($id);
            

            if ($user->teacher->id != $record->resume_id) {
                return response()->json([
                    'message' => 'رزومه متعلق به شما نمیباشد'
                ]);
            }

            $result = ResumeAdvertisement::where('id', $id)->get();

            return ResumeAdvertisementResource::collection($result);

        } catch (Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], 400);
        }
    }
    
     public function changeStatus(Request $request, $id)
    {
        try {

            $user = auth()->user();

            $record = ResumeAdvertisement::where('id', $id)->get();

            if ($user->id != $record->first()->advertisement->user_id) {
                return response()->json([
                    'message' => 'آگهی متعلق به شما نمیباشد'
                ]);
            }

            $result = ResumeAdvertisement::where('id', $id)->update([
                'status' => $request->status
            ]);

            if ($result == 1)
                return response()->json(['message' => 'update']);

            return response()->json(['message' => 'does not updated'], 304);

        } catch (Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], 400);
        }
    }
    
    public function cancel($advertisement_id)
    {
        try {

          $res = ResumeAdvertisement::where('resume_id', auth()->user()->teacher->id)->where('advertisement_id', $advertisement_id)->delete();

          if ($res) {   
            return response()->json([
                'message' => 'deleted'
            ]);
        }

        return response()->json([
            'message' => 'not deleted'
        ]);

        } catch (Exception $e) {

            return response()->json([
                'error' => $e->getMessage()
            ], 400);

        }
    }
}
