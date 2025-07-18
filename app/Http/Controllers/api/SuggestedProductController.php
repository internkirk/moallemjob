<?php

namespace App\Http\Controllers\api;

use App\Http\Resources\ProductResource;
use Exception;
use App\Models\Skill;
use App\Models\Product;
use App\Models\Teacher;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Schema;

class SuggestedProductController extends Controller
{
    public function index()
    {


        try {

            if (!$this->checkResumeIsCompleted(auth()->user()->teacher->id)) {

                return response()->json([
                  'message' =>  'لطفا ابتدا رزومه خود را کامل کنید'
                ], 400);

            }

            $teacher = Teacher::findOrFail(auth()->user()->teacher->id);

            $products = Product::all();

            $skills = Skill::where('teacher_id', $teacher->id)->get();

            $collection = collect();

            foreach ($products as $key => $course) {
                foreach (json_decode($course->slug) as $key => $slug) {
                    if ($skills != NULL) {
                        foreach ($skills as $key => $skill) {
                            if (str_contains($skill->title, $slug)) {
                                $collection->push($course->id);
                            }
                        }
                    }

                }
            }

            $products=[];

            foreach ($collection->unique() as $key => $id) {
                $products[] = Product::where('id', $id)->get();
            }

            return ProductResource::collection(Arr::flatten($products));

        } catch (Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], 400);
        }


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

            return $this->checkColumnIsNotEmptyOrNull($columns->first());

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
