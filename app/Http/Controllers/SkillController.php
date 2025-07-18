<?php

namespace App\Http\Controllers;

use App\Models\Skill;
use App\Models\Teacher;
use Illuminate\Http\Request;
use App\Models\JobBackground;

class SkillController extends Controller
{
    public function index()
    {
    }
    public function create($id)
    {
        $teacher = Teacher::findOrFail($id);
        return view('panel.users.teacher.skill.create', compact('teacher'));
    }
    public function show($id)
    {
        $teacher = Teacher::findOrFail($id);
        $skills = Skill::where('teacher_id', $id)->get();
        return view('panel.users.teacher.skill.show', compact('skills', 'teacher'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'title' => ['required'],
            'proficiency' => ['required'],
        ]);
        
        foreach ($request->title as $key => $title) {
            Skill::create([
                'teacher_id' => $request->teacher_id,
                'title' => $title,
                'proficiency' => $request->proficiency[$key],
            ]);
        }


        return redirect()->route('panel.teacher.skill.show', $request->teacher_id)->with([
            'success' => 'با موفقیت ساخته شد'
        ]);
    }
    public function edit($teacher_id, $id)
    {
        $teacher = Teacher::findOrFail($teacher_id);
        $skill = Skill::where('id', $id)->first();
        return view('panel.users.teacher.skill.edit', compact('skill', 'teacher'));
    }
    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => ['required'],
            'proficiency' => ['required'],
        ]);

        Skill::findOrFail($id)->update([
            'teacher_id' => $request->teacher_id,
            'title' => $request->title,
            'proficiency' => $request->proficiency,
        ]);

        return redirect()->route('panel.teacher.skill.show', $request->teacher_id)->with([
            'success' => 'با موفقیت ویرایش شد'
        ]);
    }
    public function delete(Request $request)
    {
        Skill::findOrFail($request->id)->delete();

        return redirect()->route('panel.teacher.skill.show', $request->teacher_id)->with([
            'success' => 'با موفقیت حذف شد'
        ]);
    }
}
