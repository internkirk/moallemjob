<?php
namespace App\Http\Controllers\api;

use Exception;
use App\Models\User;
use App\Models\Skill;
use App\Models\Teacher;
use Illuminate\Http\Request;
use App\Models\JobExperience;
use App\Http\Controllers\Controller;
use App\Http\Resources\TeacherResource;
use Illuminate\Support\Facades\Storage;
use App\Http\Services\Teacher\Resume\ResumeService;

class TeacherController extends Controller
{

    public function index()
    {
        try {
            $teachers = Teacher::paginate(10);

            return TeacherResource::collection($teachers);

        } catch (Exception $e) {

            return response()->json([
                'error' => $e->getMessage(),
            ], 400);
        }
    }
    public function show($id)
    {
        try {
            $teacher = Teacher::where('user_id', $id)->get();

            return TeacherResource::collection($teacher);

        } catch (Exception $e) {

            return response()->json([
                'error' => $e->getMessage(),
            ], 400);

        }
    }


    public function teacherAvatarStore(Request $request)
    {
        try {

            $request->validate([
                'avatar' => ['required', 'mimes:png,jpg,webp.jpeg', 'image'],
            ]);

            $teacher = Teacher::where('user_id', auth()->user()->id)->get();

            if ($teacher->isNotEmpty()) {
                $this->saveImages($request, $teacher->first()->id);
            } else {

                $teacher = Teacher::Create([
                    'user_id'    => auth()->user()->id,
                    'first_name' => ' ',
                    'last_name'  => ' ',
                    'avatar'     => '/',
                ]);

                $this->saveImages($request, $teacher->first()->id);
            }

        } catch (Exception $e) {
            return response()->json([
                'error' => $e->getMessage(),
            ], 400);
        }
    }
    public function teacherSelectionImageStore(Request $request)
    {
        try {

            $request->validate([
                'selection_image' => ['required', 'mimes:png,jpg,webp.jpeg', 'image'],
            ]);

            $teacher = Teacher::where('user_id', auth()->user()->id)->get();

            if ($teacher->isNotEmpty()) {
                $this->saveSelectionImage($request, $teacher->first()->id);
            } else {

                $teacher = Teacher::Create([
                    'user_id'         => auth()->user()->id,
                    'first_name'      => ' ',
                    'last_name'       => ' ',
                    'selection_image' => '/',
                ]);

                $this->saveSelectionImage($request, $teacher->first()->id);
            }

        } catch (Exception $e) {
            return response()->json([
                'error' => $e->getMessage(),
            ], 400);
        }
    }
    public function teacherStore(Request $request)
    {
        try {
            $request->validate([
                'first_name'  => ['required', 'max:255'],
                'last_name'   => ['required', 'max:255'],
                'avatar'      => ['sometimes', 'mimes:png,jpg,webp.jpeg', 'image'],
                'description' => ['sometimes'],
                'age'         => ['required'],
                'city'        => ['required'],
                'province'    => ['required'],
                'phone'       => ['required'],
                'email'       => ['required'],
            ]);

            $teacher = Teacher::where('user_id', auth()->user()->id)->first();

            if ($teacher === null) {
                $request->validate([
                    'phone' => ['unique:teachers,phone'],
                    'email' => ['email', 'unique:teachers,email'],
                ]);
            } else {
                $request->validate([
                    'phone' => ['unique:teachers,phone,' . $teacher->id],
                    'email' => ['email', 'unique:teachers,email,' . $teacher->id],
                ]);
            }

            ResumeService::teacherStore($request);

            return response()->json([
                'teacher_id' => $teacher->id,
                'message'    => 'data saved successfully',
            ]);
        } catch (Exception $e) {
            return response()->json([
                'error' => $e->getMessage(),
            ], 400);
        }
    }
    public function academicBackgroundStore(Request $request)
    {
        try {
            $request->validate([
                'major'              => ['required'],
                'university'         => ['required'],
                'gpa'                => ['required'],
                'year_of_graduation' => ['required'],
            ]);

            if (auth()->user()->teacher === null) {
                return response()->json([
                    'message' => 'لطفا ابتدا اطلاعات اولیه خود را وارد کنید',
                ]);
            }

            ResumeService::academicBackgroundStore($request);

            return response()->json([
                // 'teacher_id' => $request->teacher_id,
                'message' => 'data saved successfully',
            ]);

        } catch (Exception $e) {
            return response()->json([
                'error' => $e->getMessage(),
            ], 400);
        }
    }
    public function jobBackgroundStore(Request $request)
    {
        try {

            $request->validate([
                'start_year' => ['required'],
                'end_year'   => ['required'],
                'major'      => ['required'],
                'school'     => ['required'],
                'city'       => ['required'],
            ]);

            if (auth()->user()->teacher === null) {
                return response()->json([
                    'message' => 'لطفا ابتدا اطلاعات اولیه خود را وارد کنید',
                ]);
            }

            ResumeService::jobBackgroundStore($request);

            //   $job_experience =  explode(',',$request->job_experience);

            return response()->json([
                // 'teacher_id' => $request->teacher_id,
                'message' => 'data saved successfully',
                // 'data' => $job_experience
            ]);

        } catch (Exception $e) {
            return response()->json([
                'error' => $e->getMessage(),
            ], 400);
        }
    }
    public function skillStore(Request $request)
    {
        try {

            $request->validate([
                'title'       => ['required'],
                'proficiency' => ['required'],
            ]);

            if (auth()->user()->teacher === null) {
                return response()->json([
                    'message' => 'لطفا ابتدا اطلاعات اولیه خود را وارد کنید',
                ]);
            }

            ResumeService::skillStore($request);

            return response()->json([
                // 'teacher_id' => $request->teacher_id,
                'message' => 'data saved successfully',
            ]);

        } catch (Exception $e) {
            return response()->json([
                'error' => $e->getMessage(),
            ], 400);
        }
    }
    public function jobInDemandStore(Request $request)
    {
        try {

            $request->validate([
                'salary'   => ['required'],
                'major'    => ['required'],
                'province' => ['required'],
                'city'     => ['required'],
            ]);

            if (auth()->user()->teacher === null) {
                return response()->json([
                    'message' => 'لطفا ابتدا اطلاعات اولیه خود را وارد کنید',
                ]);
            }

            ResumeService::jobInDemandStore($request);

            return response()->json([
                // 'teacher_id' => $request->teacher_id,
                'message' => 'data saved successfully',
            ]);

        } catch (Exception $e) {
            return response()->json([
                'error' => $e->getMessage(),
            ], 400);
        }
    }



    public function skillDelete(Request $request)
    {
        try {
            $request->validate([
                'skill_id' => ['required', 'exists:skills,id'],
            ]);

            Skill::findOrFail($request->skill_id)->delete();

            return response()->json([
                // 'teacher_id' => $request->teacher_id,
                'message' => 'data deleted successfully',
            ]);

        } catch (Exception $e) {
            return response()->json([
                'error' => $e->getMessage(),
            ], 400);
        }
    }
    public function deleteJobExperience(Request $request)
    {
        try {

            $request->validate([
                'experience_id' => ['required', 'exists:job_experiences,id'],
            ]);

            JobExperience::findOrFail($request->experience_id)->delete();

            return response()->json([
                'message' => 'deleted successfully',
            ]);

        } catch (Exception $e) {
            return response()->json([
                'error' => $e->getMessage(),
            ], 400);
        }
    }



    public function teacherAvatarGet()
    {
        try {

            $teacher = Teacher::where('user_id', auth()->user()->id)->first();

            return response()->json([
                'عکس' => $teacher->avatar ? $teacher->avatar : '#',
            ]);

        } catch (Exception $e) {
            return response()->json([
                'error' => $e->getMessage(),
            ], 400);
        }
    }
    public function teacherSelectionImageGet()
    {
        try {

            $teacher = Teacher::where('user_id', auth()->user()->id)->first();

            return response()->json([
                'عکس' => $teacher->selection_image ? $teacher->selection_image : '#',
            ]);

        } catch (Exception $e) {
            return response()->json([
                'error' => $e->getMessage(),
            ], 400);
        }
    }
    public function teacherGet()
    {
        try {

            if (auth()->user()->teacher === null) {
                return response()->json([
                    'message' => 'لطفا ابتدا اطلاعات اولیه خود را وارد کنید',
                ]);
            }

            return ResumeService::teacherGet();

        } catch (Exception $e) {
            return response()->json([
                'error' => $e->getMessage(),
            ], 400);
        }
    }
    public function academicBackgroundGet()
    {

        try {

            if (auth()->user()->teacher === null) {
                return response()->json([
                    'message' => 'لطفا ابتدا اطلاعات اولیه خود را وارد کنید',
                ]);
            }

            return ResumeService::academicBackgroundGet();

        } catch (Exception $e) {
            return response()->json([
                'error' => $e->getMessage(),
            ], 400);
        }
    }
    public function jobBackgroundGet()
    {
        try {

            if (auth()->user()->teacher === null) {
                return response()->json([
                    'message' => 'لطفا ابتدا اطلاعات اولیه خود را وارد کنید',
                ]);
            }

            return ResumeService::jobBackgroundGet();

        } catch (Exception $e) {
            return response()->json([
                'error' => $e->getMessage(),
            ], 400);
        }
    }
    public function skillGet()
    {
        try {

            if (auth()->user()->teacher === null) {
                return response()->json([
                    'message' => 'لطفا ابتدا اطلاعات اولیه خود را وارد کنید',
                ]);
            }

            return ResumeService::skillGet();

        } catch (Exception $e) {
            return response()->json([
                'error' => $e->getMessage(),
            ], 400);
        }
    }
    public function jobInDemandGet()
    {

        try {

            if (auth()->user()->teacher === null) {
                return response()->json([
                    'message' => 'لطفا ابتدا اطلاعات اولیه خود را وارد کنید',
                ]);
            }

            return ResumeService::jobInDemandGet();

        } catch (Exception $e) {
            return response()->json([
                'error' => $e->getMessage(),
            ], 400);
        }

    }



    private function saveImages(Request $request, $id)
    {
        $path = [];

        Storage::disk('public')->deleteDirectory("/teacher/images/" . $id);

        Storage::disk('public')->makeDirectory('/teacher/images/');
        $path[] = "/storage/" . Storage::disk('public')->put("/teacher/images/" . $id, $request->avatar);

        Teacher::findOrFail($id)->update([
            'avatar' => json_encode($path),
        ]);
    }
    private function saveSelectionImage(Request $request, $id)
    {
        $path = [];

        Storage::disk('public')->deleteDirectory("/teacher/images/selection_image/" . $id);

        Storage::disk('public')->makeDirectory('/teacher/images/');
        $path[] = "/storage/" . Storage::disk('public')->put("/teacher/images/selection_image/" . $id, $request->selection_image);

        Teacher::findOrFail($id)->update([
            'selection_image' => json_encode($path),
        ]);
    }
}
