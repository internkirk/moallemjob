<?php

namespace App\Http\Controllers;

use App\Models\JobBackground;
use App\Models\Skill;
use App\Models\Teacher;
use Illuminate\Http\Request;

class JobBackgroundController extends Controller
{
    public function index()
    {
    }
    public function create($id)
    {
        $teacher = Teacher::findOrFail($id);
        return view('panel.users.teacher.job-background.create', compact('teacher'));
    }
    public function store(Request $request)
    {
        $request->validate([
            // 'salary' => ['required'],
            'major' => ['required'],
            // 'province' => ['required'],
            'city' => ['required'],
        ]);

        JobBackground::create([
            'teacher_id' => $request->teacher_id,
            'major' => $request->major,
            'start_year' => $request->start_year,
            'end_year' => $request->end_year,
            'school' => $request->school,
            'city' => $request->city,
            'is_pre_school' => $request->is_pre_school ? true : false,
            'is_elementary' => $request->is_elementary ? true : false,
            'is_middle_school' => $request->is_middle_school ? true : false,
            'is_high_school' => $request->is_high_school ? true : false,
            'is_techinical_college' => $request->is_techinical_college ? true : false,
            'is_foreign_lan_teacher' => $request->is_foreign_lan_teacher ? true : false,
            'is_entrance_exam_teacher' => $request->is_entrance_exam_teacher ? true : false,
            'is_academic_counsellor' => $request->is_academic_counsellor ? true : false,
            'is_manager' => $request->is_manager ? true : false,
            'is_deputy' => $request->is_deputy ? true : false,
            'is_couch' => $request->is_couch ? true : false,
            'is_teacher' => $request->is_teacher ? true : false,
            'is_dabir' => $request->is_dabir ? true : false,
            'is_honar_amouz' => $request->is_honar_amouz ? true : false,
        ]);


        return redirect()->route('panel.teacher.job.background.show', $request->teacher_id)->with([
            'success' => 'با موفقیت ساخته شد'
        ]);
    }
    public function edit($teacher_id, $id)
    {
        $teacher = Teacher::findOrFail($teacher_id);
        $jobBackground = JobBackground::where('id',$id)->first();
        return view('panel.users.teacher.job-background.edit',compact('jobBackground','teacher'));
    }
    public function update(Request $request, $id)
    {
        $request->validate([
            // 'salary' => ['required'],
            'major' => ['required'],
            // 'province' => ['required'],
            'city' => ['required'],
        ]);

        JobBackground::findOrFail($id)->update([
            'teacher_id' => $request->teacher_id,
            'major' => $request->major,
            'start_year' => $request->start_year,
            'end_year' => $request->end_year,
            'school' => $request->school,
            'city' => $request->city,
            'is_pre_school' => $request->is_pre_school ? true : false,
            'is_elementary' => $request->is_elementary ? true : false,
            'is_middle_school' => $request->is_middle_school ? true : false,
            'is_high_school' => $request->is_high_school ? true : false,
            'is_techinical_college' => $request->is_techinical_college ? true : false,
            'is_foreign_lan_teacher' => $request->is_foreign_lan_teacher ? true : false,
            'is_entrance_exam_teacher' => $request->is_entrance_exam_teacher ? true : false,
            'is_academic_counsellor' => $request->is_academic_counsellor ? true : false,
            'is_manager' => $request->is_manager ? true : false,
            'is_deputy' => $request->is_deputy ? true : false,
            'is_couch' => $request->is_couch ? true : false,
            'is_teacher' => $request->is_teacher ? true : false,
            'is_dabir' => $request->is_dabir ? true : false,
            'is_honar_amouz' => $request->is_honar_amouz ? true : false,
        ]);

        return redirect()->route('panel.teacher.job.background.show',$request->teacher_id)->with([
            'success' => 'با موفقیت ویرایش شد'
        ]);
    }
    public function show($id)
    {
        $teacher = Teacher::findOrFail($id);
        $jobBackgrounds = JobBackground::where('teacher_id', $id)->get();
        return view('panel.users.teacher.job-background.show', compact('jobBackgrounds', 'teacher'));
    }
    public function delete(Request $request)
    {
        JobBackground::findOrFail($request->id)->delete();

        return redirect()->route('panel.teacher.job.background.show',$request->teacher_id)->with([
            'success' => 'با موفقیت حذف شد'
        ]);
    }
}
