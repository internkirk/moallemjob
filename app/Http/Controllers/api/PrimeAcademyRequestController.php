<?php

namespace App\Http\Controllers\api;

use App\Models\PrimeAcademyUser;
use Exception;
use App\Models\Academy;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\PrimeAcademyRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;

class PrimeAcademyRequestController extends Controller
{
    public function store(Request $request)
    {


        try {

            /////// check user paid the price for request

            $result = PrimeAcademyUser::where('user_id', auth()->user()->id)->first();

            if ($result === NULL) {
                return response()->json([
                  'message' =>  'باید برای ثبت درخواست ، ابتدا هزینه را پرداخت کنید'   
                ]);
            }


            // $request->validate([
            //     'files' => ['required']
            // ]);


            if (!$this->checkResumeIsCompleted(auth()->user()->academy->id)) {

                return response()->json([
                  'message' =>  'لطفا ابتدا رزومه خود را کامل کنید'
                ],400);

            }
            


            // if (!$request->has('files') && $request->file('files') != NULL) {
            //     return response()->json([
            //      'message' =>   'please send files too'
            //     ], 400);
            // }


            $record = PrimeAcademyRequest::create([
                'academy_id' => auth()->user()->academy->id,
                'files' => '/'
            ]);


            if($request->files){
                $this->saveImages($request, $record->id);
            }


            return response()->json([
              'message' =>  'request sent successfully'
            ]);

        } catch (Exception $e) {

            return response()->json([
                'error' => $e->getMessage()
            ], 400);

        }

    }

    private function saveImages(Request $request, $id)
    {

        $path = [];

        Storage::disk('public')->deleteDirectory("/prime-academy-requests/images/" . $id);

        foreach ($request->file('files') as $key => $image) {

            Storage::disk('public')->makeDirectory('/prime-academy-requests/images/');
            $path[] = "/storage/" . Storage::disk('public')->put("/prime-academy-requests/images/" . $id, $image);

        }

        PrimeAcademyRequest::findOrFail($id)->update([
            'files' => json_encode($path)
        ]);
    }


    private function checkResumeIsCompleted($academy_id)
    {
        $allTables = [];

        $academy = Academy::findOrFail($academy_id);

        $allTables[] = $this->getTableName('academyAdditionalInformation', $academy);
        

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
