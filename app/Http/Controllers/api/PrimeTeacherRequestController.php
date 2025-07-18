<?php

namespace App\Http\Controllers\api;


use App\Models\PrimeTeacherResponse;
use Exception;
use App\Models\Teacher;
use App\Models\PrimeTeacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\PrimeTeacherRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;

class PrimeTeacherRequestController extends Controller
{
    public function store(Request $request)
    {


        try {


            /////// check user paid the price for request


            $request->validate([
                'files' => ['required']
            ]);


            if (!$this->checkResumeIsCompleted(auth()->user()->teacher->id)) {

                return response()->json([
                 'message' =>   'لطفا ابتدا رزومه خود را کامل کنید'
                ],400);

            }
            


            if (!$request->has('files') && $request->file('files') != NULL) {
                return response()->json([
                  'message' =>  'please send files too'
                ], 400);
            }


            $record = PrimeTeacherRequest::create([
                'teacher_id' => auth()->user()->teacher->id,
                'files' => '/'
            ]);


            $this->saveImages($request, $record->id);


             return response()->json([
              'message' =>  'request sent successfully',
              'request_id' => $record->id
            ]);

        } catch (Exception $e) {

            return response()->json([
                'error' => $e->getMessage()
            ], 400);

        }

    }
    
    public function check()
    {
        try {


            $result = PrimeTeacher::where('teacher_id',auth()->user()->teacher->id)->get();
            if ($result->isNotEmpty()) {
                return response()->json([
                    'message' => 'شما معلم برتر هستید'
                ]);
            }

            $result = PrimeTeacherRequest::where('teacher_id',auth()->user()->teacher->id)->get();
           
            if ($result->isEmpty()) {
               return response()->json([
                    'message' => 'تا به حال درخواستی ثبت نکرده اید'
                ]);
            }

            $result = PrimeTeacherRequest::where('teacher_id',auth()->user()->teacher->id)->where('status',0)->get();
            
            if ($result->isNotEmpty()) {

               $response = PrimeTeacherResponse::where('teacher_id',auth()->user()->teacher->id)->where('request_id',$result->first()->id)->get();
                if ($response->isNotEmpty()) {
                    return response()->json([
                        'message' => 'درخواست شما رد شد',
                        'reason' => $response->first()->text
                    ]);
                }

               return response()->json([
                    'message' => 'درخواست شما در حال بررسی است'
                ]);
            }


        } catch (Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], 400);
        }

    }


    private function saveImages(Request $request, $id)
    {

        $path = [];

        Storage::disk('public')->deleteDirectory("/prime-teacher-requests/images/" . $id);

        // foreach ($request->file('files') as $key => $image) {

            Storage::disk('public')->makeDirectory('/prime-teacher-requests/images/');
            $path[] = "/storage/" . Storage::disk('public')->put("/prime-teacher-requests/images/" . $id, $request->file('files'));

        // }

        PrimeTeacherRequest::findOrFail($id)->update([
            'files' => json_encode($path)
        ]);
    }


    private function checkResumeIsCompleted($teacher_id)
    {
        $allTables = [];

        $teacher = Teacher::findOrFail($teacher_id);

        $allTables[] = $this->getTableName('skills', $teacher);
        $allTables[] = $this->getTableName('academicBackground', $teacher);
        $allTables[] = $this->getTableName('jobInDemand', $teacher);
        $allTables[] = $this->getTableName('jobBackgrounds', $teacher);





        foreach ($allTables as $key => $table) {

            $columns = Schema::getColumnListing($table);

            foreach ($columns as $column) {
                $res[] = DB::table($table)->whereNotNull($column)->get();
            }
        }

        foreach (array_unique($res) as $key => $columns) {

            return  $this->checkColumnIsNotEmptyOrNull($columns->first());
   
        }

        return true;
    }


    private function getTableName($table, $teacher)
    {
        return $teacher->getRelationTableName($table);
    }


    private function checkColumnIsNotEmptyOrNull($columns)
    {

        if ($columns === NULL)
            return false;

        foreach ($columns as $key => $column) {
            if ($column === null || $column === '') {
                return false;
            }
        }

        return true;
    }



}
