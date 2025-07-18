<?php

namespace App\Http\Controllers\api;

use Exception;
use App\Models\Course;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\CourseResource;

class CourseController extends Controller
{
    public function index()
    {
        try {

            $courses = Course::where('status',true)->get();
            return CourseResource::collection($courses);


        } catch (Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], 400);
        }
    }

    public function show($id)
    {
        try {

            $course = Course::where('id',$id)->get();
            return CourseResource::collection($course);


        } catch (Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], 400);
        }
    }
}
