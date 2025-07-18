<?php

namespace App\Http\Controllers\api;

use Exception;
use App\Models\Academy;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Schema;

class AcademyProfileCompletionController extends Controller
{
    public function academy()
    {
        try {

           return $this->checkResumeCompletion(auth()->user()->academy->id);

        } catch (Exception $e) {

            return response()->json([
                'error' => $e->getMessage()
            ], 400);

        }

    }
    private function checkResumeCompletion($academy_id)
    {
        $allTables = [];

        $academy = Academy::findOrFail($academy_id);

        $allTables[] = 'academies';
        $allTables[] = $this->getTableName('academyAdditionalInformation', $academy);


        $allTableWithColumns = [];
        $academyProfileCompletedColumnsCount = 0;
        
        foreach ($allTables as $key => $table) {

            $columns = Schema::getColumnListing($table);
    
            $allTableWithColumns[] = $columns;

            foreach ($columns as $column) {
                if ($table == 'academies') {
                    $res[] = DB::table($table)->whereNotNull($column)->where('id' , $academy_id)->get();
                }
                if ($table == 'academy_additional_information') {
                    $res[] = DB::table($table)->whereNotNull($column)->where('academy_id' , $academy_id)->get();
    
                }
            }
        }
        
        foreach (Arr::flatten(array_unique($res)) as $key => $table) {

            foreach ($table as $key => $column) {
                if ($column != NULL && $column != '') {
                    $academyProfileCompletedColumnsCount++;
                }
            }

        }
        
        $result = ( $academyProfileCompletedColumnsCount / collect(Arr::flatten($allTableWithColumns))->count() ) * 100;

        return response()->json([
            'data' => round($result, 0, PHP_ROUND_HALF_UP)
        ]);
    }


    private function getTableName($table, $academy)
    {
        return $academy->getRelationTableName($table);
    }
}
