<?php

namespace App\Http\Controllers\api;

use Exception;
use App\Models\Teacher;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Schema;

class TeacherProfileCompletionController extends Controller
{
    public function teacher()
    {
        try {
            
            if(auth()->user()->teacher === NULL){
                return response()->json([
            'data' => (int)0
        ]);
            }

           return $this->checkResumeCompletion(auth()->user()->teacher->id);

        } catch (Exception $e) {

            return response()->json([
                'error' => $e->getMessage()
            ], 400);

        }

    }
    private function checkResumeCompletion($teacher_id)
    {
        $allTables = [];

        $teacher = Teacher::findOrFail($teacher_id);

        $allTables[] = 'teachers';
        $allTables[] = $this->getTableName('skills', $teacher);
        $allTables[] = $this->getTableName('academicBackground', $teacher);
        $allTables[] = $this->getTableName('jobInDemand', $teacher);
        $allTables[] = $this->getTableName('jobBackgrounds', $teacher);

        $allTableWithColumns = [];
        $teacherProfileCompletedColumnsCount = 0;

        foreach ($allTables as $key => $table) {

            $columns = Schema::getColumnListing($table);

            $allTableWithColumns[] = [$table => $columns];

            foreach ($columns as $column) {
                 if ($table == 'teachers') {  
                    $res[] = DB::table($table)->whereNotNull($column)->where('id' , $teacher_id)->get();
                }
                if ($table == 'skills') {  
                    $res[] = DB::table($table)->whereNotNull($column)->where('teacher_id' , $teacher_id)->take(1)->get();
                }
                if ($table == 'academic_backgrounds') {  
                    $res[] = DB::table($table)->whereNotNull($column)->where('teacher_id' , $teacher_id)->get();
                }
                if ($table == 'job_in_demands') {  
                    $res[] = DB::table($table)->whereNotNull($column)->where('teacher_id' , $teacher_id)->get();
                }
                if ($table == 'job_backgrounds') {  
                    $res[] = DB::table($table)->whereNotNull($column)->where('teacher_id' , $teacher_id)->get();
                }
            }
        }

        foreach (Arr::flatten(array_unique($res)) as $key => $table) {

            foreach ($table as $key => $column) {
                if ($column !== NULL && $column !== '') {
                    $teacherProfileCompletedColumnsCount++;
                }
            }

        }

        $result = ($teacherProfileCompletedColumnsCount / collect(Arr::flatten($allTableWithColumns))->count()) * 100;

        return response()->json([
            'data' => round($result, 0, PHP_ROUND_HALF_UP)
        ]);
    }


    private function getTableName($table, $teacher)
    {
        return $teacher->getRelationTableName($table);
    }

}
