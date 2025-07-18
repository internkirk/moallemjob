<?php

namespace App\Http\Controllers;

use App\Models\Teacher;
use Illuminate\Http\Request;
use App\Models\AcademicBackground;

class AcademicBackgroundController extends Controller
{

    public function index()
    {
    }
    public function create($id)
    {
        $teacher = Teacher::findOrFail($id);
        return view('panel.users.teacher.academic-background.create', compact('teacher'));
    }
    public function show($id)
    {
        $teacher = Teacher::findOrFail($id);
        $academicBackground = AcademicBackground::where('teacher_id', $id)->first();
        return view('panel.users.teacher.academic-background.show', compact('academicBackground', 'teacher'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'major' => ['required'],
            'university' => ['required'],
            'gpa' => ['required'],
            'year_of_graduation' => ['required']
        ]);

        AcademicBackground::create([
            'teacher_id' => $request->teacher_id,
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


        return redirect()->route('panel.teacher.academic.background.show', $request->teacher_id)->with([
            'success' => 'با موفقیت ساخته شد'
        ]);
    }
    public function edit($id)
    {
        $teacher = Teacher::findOrFail($id);
        $academicBackground = AcademicBackground::where('teacher_id',$id)->first();
        return view('panel.users.teacher.academic-background.edit',compact('academicBackground','teacher'));
    }
    public function update(Request $request, $id)
    {
        $request->validate([
            'major' => ['required'],
            'university' => ['required'],
            'gpa' => ['required'],
            'year_of_graduation' => ['required']
        ]);

        AcademicBackground::findOrFail($id)->update([
            'teacher_id' => $request->teacher_id,
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

        return redirect()->route('panel.teacher.academic.background.show',$request->teacher_id)->with([
            'success' => 'با موفقیت ویرایش شد'
        ]);
    }
    public function delete(Request $request)
    {
        AcademicBackground::findOrFail($request->id)->delete();

        return redirect()->route('panel.teacher.academic.background.show',$request->teacher_id)->with([
            'success' => 'با موفقیت حذف شد'
        ]);
    }
}
