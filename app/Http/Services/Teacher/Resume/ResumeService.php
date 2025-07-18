<?php
namespace App\Http\Services\Teacher\Resume;

use App\Models\JobExperience;
use Exception;
use App\Models\User;
use App\Models\Skill;
use App\Models\Teacher;
use App\Models\JobInDemand;
use Illuminate\Http\Request;
use App\Models\JobBackground;
use App\Models\AcademicBackground;
use Illuminate\Support\Facades\Storage;



class ResumeService
{
    public function __call($method, $args)
    {
        return $this->call($method, $args);
    }

    public static function __callStatic($method, $args)
    {

        return (new static())->call($method, $args);

    }
    private function call($method, $args)
    {
        if (!method_exists($this, '_' . $method)) {
            throw new Exception('Call undefined method ' . $method);
        }

        return $this->{'_' . $method}(...$args);
    }

    private function _teacherStore(Request $request)
    {
        User::findOrFail(auth()->user()->id)->update([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'phone' => $request->phone,
        ]);

        $teacher = Teacher::updateOrCreate(['user_id' => auth()->user()->id], [
            'user_id' => auth()->user()->id,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'is_male' => $request->is_male ? true : false,
            'is_single' => $request->is_single ? true : false,
            // 'avatar' => '/',
            'description' => $request->description,
            'age' => $request->age,
            'city' => $request->city,
            'province' => $request->province,
            'is_selected' => $request->is_selected ? true : false,
            'phone' => $request->phone,
            'email' => $request->email,
        ]);

        if ($request->file('avatar')) {
            $this->saveImages($request, $teacher->id);
        }
    }
    private function _academicBackgroundStore(Request $request)
    {

        AcademicBackground::updateOrCreate(['teacher_id' => auth()->user()->teacher->id], [
            'teacher_id' => auth()->user()->teacher->id,
            'major' => $request->major,
            'university' => $request->university,
            'gpa' => $request->gpa,
            'year_of_graduation' => $request->year_of_graduation,
            'is_high_school' => $request->is_high_school ? true : false,
            'is_associate' => $request->is_associate ? true : false,
            'is_bachelor' => $request->is_bachelor ? true : false,
            'is_master' => $request->is_master ? true : false,
            'is_phd' => $request->is_phd ? true : false,
        ]);

    }
    private function _skillStore(Request $request)
    {

        $skills = [];

        $result = Skill::where('teacher_id', auth()->user()->teacher->id)->get();

        if ($result === NULL || $result->isEmpty()) {

            foreach ($request->title as $key => $title) {

                $skills[$title] = $request->proficiency[$key];

            }

        } else {

            foreach ($result as $key => $record) {
                $skills[$record->title] = $record->proficiency;
            }


            foreach ($request->title as $key => $title) {
                $skills[$title] = $request->proficiency[$key];
            }

        }


        foreach ($skills as $title => $value) {
            Skill::updateOrCreate(['teacher_id' => auth()->user()->teacher->id, 'title' => $title, 'proficiency' => $value], [
                'teacher_id' => auth()->user()->teacher->id,
                'title' => $title,
                'proficiency' => $value,
            ]);
        }

    }
    private function _jobInDemandStore(Request $request)
    {

        [$is_pre_school, $is_elementary, $is_middle_school, $is_high_school, $is_techinical_college, $is_foreign_lan_teacher, $is_entrance_exam_teacher, $is_academic_counsellor] = [false, false, false, false, false, false, false, false];
        [$is_part_time, $is_half_time, $is_full_time] = [false, false, false];
        [$is_manager, $is_deputy, $is_couch, $is_teacher, $is_dabir, $is_honar_amouz] = [false, false, false, false, false, false];


        if ($request->academic_level == 'پیش دبستانی') {
            $is_pre_school = true;
        }
        if ($request->academic_level == 'ابتدایی') {
            $is_elementary = true;
        }
        if ($request->academic_level == 'متوسطه اول') {
            $is_middle_school = true;
        }
        if ($request->academic_level == 'متوسطه نظری') {
            $is_high_school = true;
        }
        if ($request->academic_level == 'هنرستان') {
            $is_techinical_college = true;
        }
        if ($request->academic_level == 'مدرس زبان خارجی') {
            $is_foreign_lan_teacher = true;
        }
        if ($request->academic_level == 'مدرس کنکور') {
            $is_entrance_exam_teacher = true;
        }
        if ($request->academic_level == 'مشاور تحصیلی و تربیتی') {
            $is_academic_counsellor = true;
        }


        if ($request->school_role == 'مدیر') {
            $is_manager = true;
        }
        if ($request->school_role == 'معاون') {
            $is_deputy = true;
        }
        if ($request->school_role == 'مربی') {
            $is_couch = true;
        }
        if ($request->school_role == 'آموزگار') {
            $is_teacher = true;
        }
        if ($request->school_role == 'دبیر') {
            $is_dabir = true;
        }
        if ($request->school_role == 'هنرآموزگار') {
            $is_honar_amouz = true;
        }


        if ($request->time == 'پاره وقت') {
            $is_part_time = true;
        }
        if ($request->time == 'نیمه وقت') {
            $is_half_time = true;
        }
        if ($request->time == 'تمام وقت') {
            $is_full_time = true;
        }


        JobInDemand::updateOrCreate(['teacher_id' => auth()->user()->teacher->id], [
            'teacher_id' => auth()->user()->teacher->id,
            'major' => $request->major,
            'payeh' => $request->payeh,
            'salary' => $request->salary,
            'province' => $request->province,
            'city' => $request->city,
            'is_pre_school' => $is_pre_school ? true : false,
            'is_elementary' => $is_elementary ? true : false,
            'is_middle_school' => $is_middle_school ? true : false,
            'is_high_school' => $is_high_school ? true : false,
            'is_techinical_college' => $is_techinical_college ? true : false,
            'is_foreign_lan_teacher' => $is_foreign_lan_teacher ? true : false,
            'is_entrance_exam_teacher' => $is_entrance_exam_teacher ? true : false,
            'is_academic_counsellor' => $is_academic_counsellor ? true : false,
            'is_manager' => $is_manager ? true : false,
            'is_deputy' => $is_deputy ? true : false,
            'is_couch' => $is_couch ? true : false,
            'is_teacher' => $is_teacher ? true : false,
            'is_dabir' => $is_dabir ? true : false,
            'is_honar_amouz' => $is_honar_amouz ? true : false,
            'is_full_time' => $is_full_time ? true : false,
            'is_half_time' => $is_half_time ? true : false,
            'is_part_time' => $is_part_time ? true : false,
        ]);

    }
    private function _jobBackgroundStore(Request $request)
    {
        

        
        // [$is_pre_school, $is_elementary, $is_middle_school, $is_high_school, $is_techinical_college, $is_foreign_lan_teacher, $is_entrance_exam_teacher, $is_academic_counsellor] = [false, false, false, false, false, false, false, false];
        [$is_manager, $is_deputy, $is_couch, $is_teacher, $is_dabir, $is_honar_amouz] = [false, false, false, false, false, false];

        // if ($request->academic_level == 'پیش دبستانی') {
        //     $is_pre_school = true;
        // }
        // if ($request->academic_level == 'ابتدایی') {
        //     $is_elementary = true;
        // }
        // if ($request->academic_level == 'متوسطه اول') {
        //     $is_middle_school = true;
        // }
        // if ($request->academic_level == 'متوسطه نظری') {
        //     $is_high_school = true;
        // }
        // if ($request->academic_level == 'هنرستان') {
        //     $is_techinical_college = true;
        // }
        // if ($request->academic_level == 'مدرس زبان خارجی') {
        //     $is_foreign_lan_teacher = true;
        // }
        // if ($request->academic_level == 'مدرس کنکور') {
        //     $is_entrance_exam_teacher = true;
        // }
        // if ($request->academic_level == 'مشاور تحصیلی و تربیتی') {
        //     $is_academic_counsellor = true;
        // }


        if ($request->school_role == 'مدیر') {
            $is_manager = true;
        }
        if ($request->school_role == 'معاون') {
            $is_deputy = true;
        }
        if ($request->school_role == 'مربی') {
            $is_couch = true;
        }
        if ($request->school_role == 'آموزگار') {
            $is_teacher = true;
        }
        if ($request->school_role == 'دبیر') {
            $is_dabir = true;
        }
        if ($request->school_role == 'هنرآموزگار') {
            $is_honar_amouz = true;
        }

        JobBackground::updateOrCreate(['teacher_id' => auth()->user()->teacher->id], [
            'teacher_id' => auth()->user()->teacher->id,
            'major' => $request->major,
            'payeh' => $request->payeh,
            'teaching_exp' => $request->teaching_exp,
            'start_year' => $request->start_year,
            'end_year' => $request->end_year,
            'school' => $request->school,
            'city' => $request->city,
            'is_pre_school' => $request->is_pre_school == 'true' ? true : false,
            'is_elementary' => $request->is_elementary == 'true' ? true : false,
            'is_middle_school' => $request->is_middle_school == 'true'? true : false,
            'is_high_school' => $request->is_high_school == 'true'? true : false,
            'is_techinical_college' => $request->is_techinical_college == 'true' ? true : false,
            'is_foreign_lan_teacher' => $request->is_foreign_lan_teacher == 'true'? true : false,
            'is_entrance_exam_teacher' => $request->is_entrance_exam_teacher == 'true'? true : false,
            'is_academic_counsellor' => $request->is_academic_counsellor == 'true' ? true : false,
            'is_manager' => $is_manager  ? true : false,
            'is_deputy' => $is_deputy  ? true : false,
            'is_couch' => $is_couch  ? true : false,
            'is_teacher' => $is_teacher  ? true : false,
            'is_dabir' =>  $is_dabir  ? true : false,
            'is_honar_amouz' =>  $is_honar_amouz  ? true : false,
        ]);

         $job_experience = explode(',',$request->job_experience);

        if (is_array($job_experience) && $job_experience != []) {
            foreach ($job_experience as $key => $text) {
                JobExperience::updateOrCreate(['teacher_id' => auth()->user()->teacher->id, 'text' => $text], [
                    'teacher_id' => auth()->user()->teacher->id,
                    'text' => $text
                ]);
            }
        }
    }
    private function _teacherGet()
    {

        $teacher = Teacher::where('user_id', auth()->user()->id)->first();

        return response()->json([
            'id' => $teacher->id,
            'نام' => $teacher->first_name,
            'نام خانوادگی' => $teacher->last_name,
            'جنسیت' => $teacher->is_male ? 'مرد' : 'زن',
            'وضعیت تاهل' => $teacher->is_single ? 'مجرد' : 'متاهل',
            'سن' => $teacher->age,
            'شماره همراه' => $teacher->phone,
            'ایمیل' => $teacher->email,
            'شهر' => $teacher->city,
            'استان' => $teacher->province,
            'گزینش' => $teacher->is_selected ? 'دارد' : 'ندارد',
            'تصویر گزینش' => $teacher->selection_image,
            'توضیحات' => $teacher->description,
        ]);

    }

    private function _academicBackgroundGet()
    {

        $teacher = Teacher::where('user_id', auth()->user()->id)->first();

        // $academicLevel = '';
        // if ($teacher->academicBackground?->is_high_school) {
        //     $academicLevel = 'متوسطه';
        // } else if ($teacher->academicBackground?->is_associate) {
        //     $academicLevel = 'کاردانی';
        // } else if ($teacher->academicBackground?->is_bachelor) {
        //     $academicLevel = 'کارشناسی';
        // } else if ($teacher->academicBackground?->is_master) {
        //     $academicLevel = 'کارشناسی ارشد';
        // } else if ($teacher->academicBackground?->is_phd) {
        //     $academicLevel = 'دکترا و بالاتر';
        // }

        return response()->json([
            'مقطع تحصیلی' => [
                'متوسطه' => $teacher->academicBackground?->is_high_school ? true : false,
                'کاردانی' => $teacher->academicBackground?->is_associate ? true : false,
                'کارشناسی' => $teacher->academicBackground?->is_bachelor ? true : false,
                'کارشناسی ارشد' => $teacher->academicBackground?->is_master ? true : false,
                'دکترا و بالاتر' => $teacher->academicBackground?->is_phd ? true : false,
            ],
            'رشته تحصیلی' => $teacher->academicBackground?->major,
            'دانشگاه' => $teacher->academicBackground?->university,
            'معدل' => $teacher->academicBackground?->gpa,
            'سال فارغ التحصیلی' => $teacher->academicBackground?->year_of_graduation,
        ]);

    }
    private function _jobInDemandGet()
    {

        $teacher = Teacher::where('user_id', auth()->user()->id)->first();



        $academicLevelForJobInDemand = '';

        $schoolRoleForJobInDemand = '';

        $typeOfCooperation = '';

        if ($teacher->jobInDemand?->is_pre_school) {
            $academicLevelForJobInDemand = 'پیش دبستانی';
        } else if ($teacher->jobInDemand?->is_elemantary) {
            $academicLevelForJobInDemand = 'ابتدایی';
        } else if ($teacher->jobInDemand?->is_middle_school) {
            $academicLevelForJobInDemand = 'متوسطه اول';
        } else if ($teacher->jobInDemand?->is_high_school) {
            $academicLevelForJobInDemand = 'متوسطه نظری';
        } else if ($teacher->jobInDemand?->is_techinical_college) {
            $academicLevelForJobInDemand = 'هنرستان';
        } else if ($teacher->jobInDemand?->is_foreign_lan_teacher) {
            $academicLevelForJobInDemand = 'مدرس زبان خارجی';
        } else if ($teacher->jobInDemand?->is_entrance_exam_teacher) {
            $academicLevelForJobInDemand = 'مدرس کنکور';
        } else if ($teacher->jobInDemand?->is_academic_counsellor) {
            $academicLevelForJobInDemand = 'مشاور تحصیلی و تربیتی';
        }




        if ($teacher->jobInDemand?->is_manager) {
            $schoolRoleForJobInDemand = 'مدیر';
        } else if ($teacher->jobInDemand?->is_couch) {
            $schoolRoleForJobInDemand = 'مربی';
        } else if ($teacher->jobInDemand?->is_teacher) {
            $schoolRoleForJobInDemand = 'آموزگار';
        } else if ($teacher->jobInDemand?->is_dabir) {
            $schoolRoleForJobInDemand = 'دبیر';
        } else if ($teacher->jobInDemand?->is_honar_amouz) {
            $schoolRoleForJobInDemand = 'هنرآموز';
        } else if ($teacher->jobInDemand?->is_deputy) {
            $schoolRoleForJobInDemand = 'معاون';
        }


        if ($teacher->jobInDemand?->is_full_time) {
            $typeOfCooperation = 'تمام وقت';
        } else if ($teacher->jobInDemand?->is_half_time) {
            $typeOfCooperation = 'نیمه وقت';
        } else if ($teacher->jobInDemand?->is_part_time) {
            $typeOfCooperation = 'پاره وقت';
        }


        return response()->json([
            'رشته تحصیلی' => $teacher->jobInDemand?->major,
            'پایه تحصیلی' => $teacher->jobInDemand?->payeh,
            'شهر' => $teacher->jobInDemand?->city,
            'استان' => $teacher->jobInDemand?->province,
            'حقوق درخواستی' => $teacher->jobInDemand?->salary,
            'مقطع تحصیلی' => $academicLevelForJobInDemand,
            'سمت' => $schoolRoleForJobInDemand,
            'نوع همکاری' => $typeOfCooperation
        ]);

    }
    private function _skillGet()
    {

        $teacher = Teacher::where('user_id', auth()->user()->id)->first();

        $skills = json_decode($teacher->skills);

        if (!is_array($skills)) {
            return [];
        }

        $arraySkills = [];

        foreach ($skills as $key => $skill) {
            $array = [
                'آیدی' => $skill->id,
                'عنوان' => $skill->title,
                'مهارت' => $skill->proficiency
            ];

            $arraySkills[] = $array;
        }

        return response()->json($arraySkills);

    }
    private function _jobBackgroundGet()
    {



        $teacher = Teacher::where('user_id', auth()->user()->id)->first();

        $jobBackgroundAcademicLevel = '';

        $schoolRole = '';

        // if ($teacher->jobBackgrounds?->is_pre_school) {
        //     $jobBackgroundAcademicLevel = 'پیش دبستانی';
        // } else if ($teacher->jobBackgrounds?->is_elemantary) {
        //     $jobBackgroundAcademicLevel = 'ابتدایی';
        // } else if ($teacher->jobBackgrounds?->is_middle_school) {
        //     $jobBackgroundAcademicLevel = 'متوسطه اول';
        // } else if ($teacher->jobBackgrounds?->is_high_school) {
        //     $jobBackgroundAcademicLevel = 'متوسطه نظری';
        // } else if ($teacher->jobBackgrounds?->is_techinical_college) {
        //     $jobBackgroundAcademicLevel = 'هنرستان';
        // } else if ($teacher->jobBackgrounds?->is_foreign_lan_teacher) {
        //     $jobBackgroundAcademicLevel = 'مدرس زبان خارجی';
        // } else if ($teacher->jobBackgrounds?->is_entrance_exam_teacher) {
        //     $jobBackgroundAcademicLevel = 'مدرس کنکور';
        // } else if ($teacher->jobBackgrounds?->is_academic_counsellor) {
        //     $jobBackgroundAcademicLevel = 'مشاور تحصیلی و تربیتی';
        // }



        if ($teacher->jobBackgrounds?->is_manager) {
            $schoolRole = 'مدیر';
        } else if ($teacher->jobBackgrounds?->is_couch) {
            $schoolRole = 'مربی';
        } else if ($teacher->jobBackgrounds?->is_teacher) {
            $schoolRole = 'آموزگار';
        } else if ($teacher->jobBackgrounds?->is_dabir) {
            $schoolRole = 'دبیر';
        } else if ($teacher->jobBackgrounds?->is_honar_amouz) {
            $schoolRole = 'هنرآموز';
        } else if ($teacher->jobBackgrounds?->is_deputy) {
            $schoolRole = 'معاون';
        }


        $experiences = [];

        if ($teacher->jobExperience != NULL) {

            foreach ($teacher->jobExperience as $key => $experience) {
                $experiences[] = ['آیدی' => $experience->id, 'متن' => $experience->text];
            }
        }

        return response()->json([
           'مقطع تحصیلی' => [
                'پیش دبستانی' => $teacher->jobBackgrounds?->is_pre_school ? true : false,
                'ابتدایی' => $teacher->jobBackgrounds?->is_elementary ? true : false,
                'متوسطه اول' => $teacher->jobBackgrounds?->is_middle_school ? true : false,
                'متوسطه نظری' => $teacher->jobBackgrounds?->is_high_school ? true : false,
                'هنرستان' => $teacher->jobBackgrounds?->is_techinical_college ? true : false,
                'مدرس زبان خارجی' => $teacher->jobBackgrounds?->is_foreign_lan_teacher ? true : false,
                'مدرس کنکور' => $teacher->jobBackgrounds?->is_entrance_exam_teacher ? true : false,
                'مشاور تحصیلی و تربیتی' => $teacher->jobBackgrounds?->is_academic_counsellor ? true : false,
            ],
            'سمت' => $schoolRole,
            'رشته تحصیلی' => $teacher->jobBackgrounds?->major,
            'پایه تحصیلی' => $teacher->jobBackgrounds?->payeh,
            'سابقه تدریس' => $teacher->jobBackgrounds?->teaching_exp,
            'شهر' => $teacher->jobBackgrounds?->city,
            'آموزشگاه' => $teacher->jobBackgrounds?->school,
            'سال شروع' => $teacher->jobBackgrounds?->start_year,
            'سال پایان' => $teacher->jobBackgrounds?->end_year,
            'تجربه کاری' => [
                $experiences
            ]
        ]);

    }

    private function saveImages(Request $request, $id)
    {
        $path = [];

        Storage::disk('public')->deleteDirectory("/teacher/images/" . $id);

        Storage::disk('public')->makeDirectory('/teacher/images/');
        $path[] = "/storage/" . Storage::disk('public')->put("/teacher/images/" . $id, $request->avatar);

        Teacher::findOrFail($id)->update([
            'avatar' => json_encode($path)
        ]);
    }

}