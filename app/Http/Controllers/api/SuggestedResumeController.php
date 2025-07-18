<?php

namespace App\Http\Controllers\api;

use App\Models\FeatureManager;
use Exception;
use App\Models\Skill;
use App\Models\Teacher;
use App\Models\JobInDemand;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use App\Models\JobBackground;
use App\Models\AcademicBackground;
use App\Http\Controllers\Controller;
use App\Models\AdvertisementSoftSkill;
use App\Http\Resources\TeacherResource;
use App\Models\SuggestedResumeAlgorithm;

class SuggestedResumeController extends Controller
{
    public function show()
    {
        try {

            $feature = FeatureManager::where('feature', 'SuggestedResume')->first();

            if (!$feature->status) {
                return response()->json([
                    'message' => 'this feature is disabled by admin'
                ], 400);
            }

            $resumes = [];

            //check the user has a plan
            if (!auth()->user()->userPlan?->plan) {
                return response()->json([
                    'message' => 'ابتدا باید یک پکیج تهیه کنید'
                ]);
            }

            //check the plan has how many suggested resume
            $suggestLimitation = auth()->user()->userPlan->suggestedResumesNumberLimitation();

            $ad = auth()->user()->advertisements;

            if ($ad === NULL) {
                return response()->json([
                    'message' => 'شما آگهی ثبت شده ندارید، لطفا ابتدا یک آگهی ایجاد کنید'
                ]);
            }

            if ($ad != NULL) {
                $jobInDemand = JobInDemand::query();
                $jobInDemandFlag = false;
                foreach ($this->getParameters() as $key => $parameter) {
                    foreach ($ad as $key => $singleAd) {
                        if ($parameter == "job_title") {
                            $jobInDemand->orWhere('major', $singleAd->jobIntroduction->job_title);
                            $jobInDemandFlag = true;
                        }
                    }
                }

                foreach ($this->getParameters() as $key => $parameter) {
                    foreach ($ad as $key => $singleAd) {
                        if ($parameter == "school_role") {
                            $jobInDemand->orWhere(function ($q) use ($singleAd) {
                                if ($singleAd->jobIntroduction?->school_role == "مدیر") {
                                    $q->orWhere('is_manager', true);
                                } else if ($singleAd->jobIntroduction?->school_role == "معاون") {
                                    $q->orWhere('is_deputy', true);
                                } else if ($singleAd->jobIntroduction?->school_role == "مربی") {
                                    $q->orWhere('is_couch', true);
                                } else if ($singleAd->jobIntroduction?->school_role == "آموزگار") {
                                    $q->orWhere('is_teacher', true);
                                } else if ($singleAd->jobIntroduction?->school_role == "دبیر") {
                                    $q->orWhere('is_dabir', true);
                                } else if ($singleAd->jobIntroduction?->school_role == "هنرآموز") {
                                    $q->orWhere('is_honar_amouz', true);
                                }
                                $jobInDemandFlag = true;
                            });
                        }
                    }
                }
                foreach ($this->getParameters() as $key => $parameter) {
                    foreach ($ad as $key => $singleAd) {

                        if ($parameter == "academic_level") {
                            $jobInDemand->orWhere(function ($q) use ($singleAd) {
                                if ($singleAd->jobIntroduction?->academic_level == "پیش دبستانی") {
                                    $q->orWhere('is_pre_school', true);
                                } else if ($singleAd->jobIntroduction?->academic_level == "ابتدایی") {
                                    $q->orWhere('is_elementary', true);
                                } else if ($singleAd->jobIntroduction?->academic_level == "متوسطه اول") {
                                    $q->orWhere('is_middle_school', true);
                                } else if ($singleAd->jobIntroduction?->academic_level == "متوسطه نظری") {
                                    $q->orWhere('is_high_school', true);
                                } else if ($singleAd->jobIntroduction?->academic_level == "هنرستان") {
                                    $q->orWhere('is_techinical_college', true);
                                } else if ($singleAd->jobIntroduction?->academic_level == "مدرس زبان خارجی") {
                                    $q->orWhere('is_foreign_lan_teacher', true);
                                } else if ($singleAd->jobIntroduction?->academic_level == "مدرس کنکور") {
                                    $q->orWhere('is_entrance_exam_teacher', true);
                                } else if ($singleAd->jobIntroduction?->academic_level == "مشاور تحصیلی و تربیتی") {
                                    $q->orWhere('is_academic_counsellor', true);
                                }

                                $jobInDemandFlag = true;
                            });
                        }
                    }
                }
                foreach ($this->getParameters() as $key => $parameter) {
                    foreach ($ad as $key => $singleAd) {
                        if ($parameter == "major") {
                            $jobInDemand->orWhere('major', $singleAd->jobIntroduction?->major);

                            $jobInDemandFlag = true;
                        }
                    }
                }

                foreach ($this->getParameters() as $key => $parameter) {
                    foreach ($ad as $key => $singleAd) {
                        if ($parameter == "cooperation_type") {
                            $jobInDemand->orWhere(function ($q) use ($singleAd) {
                                if ($singleAd->jobIntroduction?->cooperation_type == "نیمه وقت") {
                                    $q->orWhere('is_half_time', true);
                                } else if ($singleAd->jobIntroduction?->cooperation_type == "پاره وقت") {
                                    $q->orWhere('is_part_time', true);
                                } else if ($singleAd->jobIntroduction?->cooperation_type == "تمام وقت") {
                                    $q->orWhere('is_full_time', true);
                                }
                            });

                            $jobInDemandFlag = true;
                        }
                    }
                }
                foreach ($this->getParameters() as $key => $parameter) {
                    foreach ($ad as $key => $singleAd) {
                        if ($parameter == "min_salary") {
                            $jobInDemand->orWhere('salary', '>=', $singleAd->salary->min_salary);

                            $jobInDemandFlag = true;
                        }
                        if ($parameter == "max_salary") {
                            $jobInDemand->orWhere('salary', '<=', $singleAd->salary->max_salary);

                            $jobInDemandFlag = true;
                        }
                    }
                }





                $softSkill = Skill::query();
                $softSkillFlag = false;
                foreach ($this->getParameters() as $key => $parameter) {
                    foreach ($ad as $key => $singleAd) {
                        if ($parameter == "skill") {
                            $softSkill->orWhere(function ($q) use ($singleAd) {
                                foreach ($singleAd->softSkill as $key => $skill) {
                                    $q->orWhere('title', $skill);
                                }
                            });

                            $softSkillFlag = true;
                        }
                    }
                }




                $academicBackground = AcademicBackground::query();
                $academicBackgroundFlag = false;
                foreach ($this->getParameters() as $key => $parameter) {
                    foreach ($ad as $key => $singleAd) {
                        if ($parameter == "major") {
                            $academicBackground->orWhere(function ($q) use ($singleAd) {
                                foreach ($singleAd->education as $key => $value) {
                                    $q->orWhere('major', $value->major);
                                }
                            });

                            $academicBackgroundFlag = true;
                        }
                    }
                }


                foreach ($this->getParameters() as $key => $parameter) {
                    foreach ($ad as $key => $singleAd) {
                        if ($parameter == "academic_level") {
                            $academicBackground->orWhere(function ($q) use ($singleAd) {
                                foreach ($singleAd->education as $key => $value) {
                                    if ($value->academic_level == "متوسطه") {
                                        $q->orWhere('is_high_school', true);
                                    } else if ($value->academic_level == "کاردانی") {
                                        $q->orWhere('is_associate', true);
                                    } else if ($value->academic_level == "کارشناسی") {
                                        $q->orWhere('is_bachelor', true);
                                    } else if ($value->academic_level == "کارشناسی ارشد") {
                                        $q->orWhere('is_master', true);
                                    } else if ($value->academic_level == "دکترا و بالاتر") {
                                        $q->orWhere('is_phd', true);
                                    }
                                }
                            });

                            $academicBackgroundFlag = true;
                        }
                    }
                }



                $teacher = Teacher::query();
                $teacherFlag = false;
                foreach ($this->getParameters() as $key => $parameter) {
                    foreach ($ad as $key => $singleAd) {
                        if ($parameter == "selection_certificate") {
                            $teacher->orWhere(function ($q) use ($singleAd) {
                                if ($singleAd->additionalCondition->selection_certificate) {
                                    $q->orWhere('is_selected', true);
                                }
                            });

                            $teacherFlag = true;
                        }
                    }
                }

                ////////// Location //////////
                foreach ($ad as $key => $singleAd) {
                    foreach ($this->getParameters() as $key => $parameter) {
                        if ($parameter == "city") {
                            $teacher->orWhere('city', $singleAd->location->city);

                            $teacherFlag = true;
                        }
                    }
                    foreach ($this->getParameters() as $key => $parameter) {
                        if ($parameter == "province") {
                            $teacher->orWhere('province', $singleAd->location->province);

                            $teacherFlag = true;
                        }
                    }
                }
                ////////// Requirements /////////
                // if ($ad->has('requirement')) {
                   foreach ($ad as $key => $singleAd) {
                    foreach ($this->getParameters() as $key => $parameter) {
                        if ($parameter == "min_age") {
                            $teacher->orWhere(function ($q) use ($singleAd) {
                                if (18 <= $singleAd->requirement?->min_age && $singleAd->requirement?->min_age <= 60) {
                                    $q->Where('age', ">=", 18)->Where('age', "<=", 60);
                                }
                                if (18 <= $singleAd->requirement?->min_age && $singleAd->requirement?->min_age <= 50) {
                                    $q->Where('age', ">=", 18)->Where('age', "<=", 50);
                                }
                                if (0 < $singleAd->requirement?->min_age) {
                                    $q->Where("id", ">", 0);
                                }
                            });

                            $teacherFlag = true;
                        }
                    }
                }
                    foreach ($this->getParameters() as $key => $parameter) {
                        foreach ($ad as $key => $singleAd) {
                            if ($parameter == "max_age") {
                                $teacher->orWhere(function ($q) use ($singleAd) {
                                    if ($singleAd->requirement?->max_age == "بازه 18 الی 60") {
                                        $q->Where('age', ">=", 18)->Where('age', "<=", 60);
                                    }
                                    if ($singleAd->requirement?->max_age == "بازه 18 الی 50") {
                                        $q->Where('age', ">=", 18)->Where('age', "<=", 50);
                                    }
                                    if ($singleAd->requirement?->max_age == "تفاوتی ندارد") {
                                        $q->Where("id", ">", 0);
                                    }
                                });

                                $teacherFlag = true;
                            }
                        }
                    }
                    foreach ($this->getParameters() as $key => $parameter) {
                        foreach ($ad as $key => $singleAd) {
                            if ($parameter == "sex") {
                                $teacher->orWhere(function ($q) use ($singleAd) {
                                    if ($singleAd->requirement?->sex == 'ترجیحا خانم') {
                                        $q->orWhere('is_male', 0);
                                    }
                                    if ($singleAd->requirement?->sex == 'ترجیحا آقا') {
                                        $q->orWhere('is_male', 1);
                                    }
                                    if ($singleAd->requirement?->sex == 'فقط خانم') {
                                        $q->orWhere('is_male', 0);
                                    }
                                    if ($singleAd->requirement?->sex == 'فقط آقا') {
                                        $q->orWhere('is_male', 1);
                                    }
                                    if ($singleAd->requirement?->sex == 'تفاوتی ندارد') {
                                        
                                        $q->orWhere("id", ">", 0);
                                    }
                                });

                                $teacherFlag = true;
                            }
                        }
                    }
                // }



                $jobBackground = JobBackground::query();
                $jobBackgroundFlag = false;
                foreach ($this->getParameters() as $key => $parameter) {
                    foreach ($ad as $key => $singleAd) {
                        if ($parameter == "city") {
                            $jobBackground->orWhere('city', $singleAd->location->city);

                            $jobBackgroundFlag = true;
                        }
                    }
                }
                foreach ($this->getParameters() as $key => $parameter) {
                    foreach ($ad as $key => $singleAd) {
                        if ($parameter == "school") {
                            $jobBackground->orWhere('school', $singleAd->location->school);

                            $jobBackgroundFlag = true;
                        }
                    }
                }
                foreach ($this->getParameters() as $key => $parameter) {
                    foreach ($ad as $key => $singleAd) {
                        if ($parameter == "major") {
                            $jobBackground->orWhere('major', $singleAd->location->major);

                            $jobBackgroundFlag = true;
                        }
                    }
                }
                foreach ($this->getParameters() as $key => $parameter) {
                    foreach ($ad as $key => $singleAd) {
                        if ($parameter == "start_year") {
                            $jobBackground->orWhere('start_year', $singleAd->location->start_year);

                            $jobBackgroundFlag = true;
                        }
                    }
                }



                if ($jobInDemandFlag) {
                    foreach ($jobInDemand->get() as $key => $record) {

                        $resumes[] = $record->teacher_id;
                    }
                }

                if ($softSkillFlag) {
                    foreach ($softSkill->get() as $key => $record) {

                        $resumes[] = $record->teacher_id;
                    }
                }

                if ($academicBackgroundFlag) {

                    foreach ($academicBackground->get() as $key => $record) {

                        $resumes[] = $record->teacher_id;
                    }
                }

                if ($teacherFlag) {
                    foreach ($teacher->get() as $key => $record) {

                        $resumes[] = $record->id;
                    }
                }

                if ($jobBackgroundFlag) {
                    foreach ($jobBackground->get() as $key => $record) {

                        $resumes[] = $record->teacher_id;
                    }
                }

                if ($resumes != NULL) {
                    foreach (array_unique($resumes) as $key => $id) {
                        $teachers[] = Teacher::where('id', $id)->get();
                    }
                } else {
                    $teachers = [];
                }
            } else {
                $teachers = [];
            }

            $suggestLimitation;
            $teachers = collect(Arr::flatten($teachers))->take($suggestLimitation);

            return TeacherResource::collection($teachers);


        } catch (Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ]);
        }

    }

    private function getParameters()
    {
        $parameter = SuggestedResumeAlgorithm::first();

        if (is_null($parameter)) {

            return response()->json([
                'message' => 'please make an algorithm in panel first'
            ]);

        }

        return json_decode($parameter->items, true);

    }

}
