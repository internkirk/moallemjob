<?php

namespace App\Http\Controllers\api;

use Exception;
use App\Models\Skill;
use App\Models\Course;
use App\Models\Teacher;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use App\Models\JobBackground;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Resources\CourseResource;
use Illuminate\Support\Facades\Schema;

class SuggestedCourseController extends Controller
{
    public function index()
    {


        try {
            
            if(is_null(auth()->user()->teacher)){
                return response()->json([
                   'message' => 'این قابلیت تنها برای معلمین میباشد'
                ]);
            }

            if (!$this->checkResumeIsCompleted(auth()->user()->teacher->id)) {

                return response()->json([
                 'message' =>   'لطفا ابتدا رزومه خود را کامل کنید'
                ]);

            }

            $teacher = Teacher::findOrFail(auth()->user()->teacher->id);

            $courses = Course::all();

            $skills = Skill::where('teacher_id', $teacher->id)->get();

            $collection = collect();

            foreach ($courses as $key => $course) {
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

            $courses=[];

            foreach ($collection->unique() as $key => $id) {
                $courses[] = Course::where('id', $id)->get();
            }

            return CourseResource::collection(Arr::flatten($courses));

        } catch (Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], 400);
        }


    }
    
    public function filterize(Request $request)
    {
        try {

            if (is_null(auth()->user()->teacher)) {
                return response()->json([
                    'message' => 'این قابلیت تنها برای معلمین میباشد'
                ]);
            }

            if (!$this->checkResumeIsCompleted(auth()->user()->teacher->id)) {

                return response()->json([
                    'message' => 'لطفا ابتدا رزومه خود را کامل کنید'
                ]);
            }

            $teacher = Teacher::findOrFail(auth()->user()->teacher->id);

            $courses = Course::all();

            $skills = Skill::where('teacher_id', $teacher->id)->get();

            $collection = collect();

            // $filterize_items_array = json_decode($request->items, true);
            $filterize_items_array = $request->items;

            foreach ($courses as $key => $course) {
                foreach (json_decode($course->slug) as $key => $slug) {
                   
                    if ($skills != NULL) {
                        foreach ($skills as $key => $skill) {
                            if (str_contains($skill->title, $slug)) {
                                foreach ($filterize_items_array as $key => $item) {
                                    if (in_array($item,json_decode($course->slug))) {
                                        $collection->push($course->id);
                                    }
                                }
                            }
                        }
                    }
                }
            }

            $courses = [];

            foreach ($collection->unique() as $key => $id) {
                $courses[] = Course::where('id', $id)->get();
            }

            return CourseResource::collection(Arr::flatten($courses));

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
