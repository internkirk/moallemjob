<?php

namespace App\Http\Controllers\api;

use Exception;
use App\Models\Academy;
use App\Models\PrimeTeacher;
use Illuminate\Http\Request;
use App\Models\Advertisement;
use App\Http\Controllers\Controller;
use App\Http\Resources\TeacherResource;
use App\Http\Resources\PrimeTeacherResource;
use App\Models\AdvertisementJobIntroduction;
use App\Http\Resources\AdvertisementResource;

class PrimeTeacherController extends Controller
{
   public function index()
    {

        try {

            // if(auth()->user()->userPlan?->latest()->first() === NULL || auth()->user()->userPlan?->latest()->first()->isExpired()){
            //     return response()->json([
            //         'message' => ' پکیجی خریداری نشده یا منقضی شده'
            //     ]);
            // }

            // //check the user has a plan
            // if (!auth()->user()->userPlan?->plan) {
            //     return response()->json([
            //         'message' => 'ابتدا باید یک پکیج تهیه کنید'
            //     ]);
            // }


            // if (!auth()->user()->userPlan?->access_to_best_teachers_list) {
            //     return response()->json([
            //         'message' => 'لطفا پلنی تهیه کنید که در آن میتوانید به این لیست دسترسی داشته باشید'
            //     ]);
            // }



            $teachers = PrimeTeacher::paginate(15);

            return PrimeTeacherResource::collection($teachers);

        } catch (Exception $e) {

            return response()->json([
                'error' => $e->getMessage()
            ], 400);

        }

    }

    public function filterize(Request $request)
    {
        $result = $this->getStrategy($request);

        return PrimeTeacherResource::collection($result);
    }


    private function getStrategy($request)
    {
        // if ($request->by_search) {
            return $this->filterBySearch($request);
        // } else if ($request->by_select) {
        //     return $this->filterBySelect($request);
        // }
    }


    private function filterBySearch($request)
    {

        $prime_teachers = collect();

        $prime_teachers = [];

        if ($request->academy_level) {

            if ($request->academy_level == 'پیش دبستانی') {
                $academy_level_column = 'is_pre_school';
            } else if ($request->academy_level == 'ابتدایی') {
                $academy_level_column = 'is_elementary';
            } else if ($request->academy_level == 'متوسطه اول') {
                $academy_level_column = 'is_middle_school';
            } else if ($request->academy_level == 'متوسطه دوم') {
                $academy_level_column = 'is_high_school';
            } else if ($request->academy_level == 'هنرستان') {
                $academy_level_column = 'is_techinical_college';
            } else if ($request->academy_level == 'مدرس زبان خارجی') {
                $academy_level_column = 'is_foreign_lan_teacher';
            } else if ($request->academy_level == 'مدرس کنکور') {
                $academy_level_column = 'is_entrance_exam_teacher';
            } else if ($request->academy_level == 'مشاور تحصیلی و تربیتی') {
                $academy_level_column = 'is_academic_counsellor';
            }

            $prime_teachers = PrimeTeacher::whereHas('teacher.jobInDemand', function ($query) use ($request, $academy_level_column) {
                $query->where($academy_level_column, true);
            })->get();
        }


        if($request->payeh){
            $prime_teachers = PrimeTeacher::whereHas('teacher.jobBackgrounds', function ($query) use ($request) {
                $query->where('payeh', $request->payeh);
            })->get();
        }

        if ($request->major) {
            $prime_teachers = PrimeTeacher::whereHas('teacher.jobInDemand', function ($query) use ($request) {
                $query->where('major', $request->major);
            })->get();
        }

        if ($request->city) {
            $prime_teachers = PrimeTeacher::whereHas('teacher.jobInDemand', function ($query) use ($request) {
                $query->where('city', $request->city);
            })->get();
        }

        if ($request->province) {
            $prime_teachers = PrimeTeacher::whereHas('teacher.jobInDemand', function ($query) use ($request) {
                $query->where('province', $request->city);
            })->get();
        }

        // if ($request->teaching_history) {
        //     $prime_teachers = PrimeTeacher::whereHas('teacher.jobBackgrounds', function ($query) use ($request) {
        //         $query->where('teaching_history', $request->teaching_history);
        //     })->get();
        // }

        if ($request->sex == 1) {
            $prime_teachers = PrimeTeacher::whereHas('teacher', function ($query) use ($request) {
                $query->where('is_male', true);
            })->get();
        }
        if ($request->sex == 0) {
            $prime_teachers = PrimeTeacher::whereHas('teacher', function ($query) use ($request) {
                $query->where('is_male', false);
            })->get();
        }


        if ($request->certificate) {

            if ($request->certificate == 'دبیرستان') {
                $certificate_column = 'is_high_school';
            } else if ($request->certificate == 'کاردانی') {
                $certificate_column = 'is_associate';
            } else if ($request->certificate == 'کارشناسی') {
                $certificate_column = 'is_bachelor';
            } else if ($request->certificate == 'کارشناسی ارشد') {
                $certificate_column = 'is_master';
            } else if ($request->certificate == 'دکترا و بالاتر') {
                $certificate_column = 'is_phd';
            }

            $prime_teachers = PrimeTeacher::whereHas('teacher.jobInDemand', function ($query) use ($request, $certificate_column) {
                $query->where($certificate_column, true);
            })->get();
        }



        foreach ($prime_teachers as $key => $teacher) {
            $teacher = PrimeTeacher::where('teacher_id', $teacher->teacher_id)->first();
            $prime_teachers->push($teacher);
        }

        return $prime_teachers->flatten()->unique();
    }

    private function filterBySelect($request)
    {
    }
}
