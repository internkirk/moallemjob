<?php

namespace App\Http\Controllers;

use App\Models\JobInDemand;
use App\Models\Teacher;
use Illuminate\Http\Request;

class JobInDemandController extends Controller
{
    public function index()
    {
    }
    public function create($id)
    {
        $teacher = Teacher::findOrFail($id);
        return view('panel.users.teacher.job-in-demand.create', compact('teacher'));
    }
    public function store(Request $request)
    {
        $request->validate([
            // 'start_year' => ['required'],
            // 'end_year' => ['required'],
            'major' => ['required'],
            // 'school' => ['required'],
            'city' => ['required'],
        ]);

        JobInDemand::create([
            'teacher_id' => $request->teacher_id,
            'major' => $request->major,
            'salary' => $request->salary,
            'province' => $request->province,
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
            'is_full_time' => $request->is_full_time ? true : false,
            'is_half_time' => $request->is_half_time ? true : false,
            'is_part_time' => $request->is_part_time ? true : false,
        ]);


        return redirect()->route('panel.teacher.job.in.demand.show', $request->teacher_id)->with([
            'success' => 'با موفقیت ساخته شد'
        ]);
    }
    public function edit($teacher_id, $id)
    {
        $teacher = Teacher::findOrFail($teacher_id);
        $jobInDemand = JobInDemand::where('id', $id)->first();
        return view('panel.users.teacher.job-in-demand.edit', compact('jobInDemand', 'teacher'));
    }
    public function update(Request $request, $id)
    {
        $request->validate([
            // 'start_year' => ['required'],
            // 'end_year' => ['required'],
            'major' => ['required'],
            // 'school' => ['required'],
            'city' => ['required'],
        ]);

        JobInDemand::findOrFail($id)->update([
            'teacher_id' => $request->teacher_id,
            'major' => $request->major,
            'salary' => $request->salary,
            'province' => $request->province,
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
            'is_full_time' => $request->is_full_time ? true : false,
            'is_half_time' => $request->is_half_time ? true : false,
            'is_part_time' => $request->is_part_time ? true : false,
        ]);

        return redirect()->route('panel.teacher.job.in.demand.show', $request->teacher_id)->with([
            'success' => 'با موفقیت ویرایش شد'
        ]);
    }
    public function show($id)
    {
        $teacher = Teacher::findOrFail($id);
        $jobInDemands = JobInDemand::where('teacher_id', $id)->get();
        return view('panel.users.teacher.job-in-demand.show', compact('jobInDemands', 'teacher'));
    }
    public function delete(Request $request)
    {
        JobInDemand::findOrFail($request->id)->delete();

        return redirect()->route('panel.teacher.job.in.demand.show', $request->teacher_id)->with([
            'success' => 'با موفقیت حذف شد'
        ]);
    }
}
