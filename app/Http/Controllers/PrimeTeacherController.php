<?php

namespace App\Http\Controllers;

use App\Models\PrimeTeacher;
use App\Models\PrimeTeacherRequest;
use Illuminate\Http\Request;

class PrimeTeacherController extends Controller
{
    public function index()
    {
        $records = PrimeTeacher::all();
        return view('panel.prime-teachers.index',compact('records'));
    }
    public function delete(Request $request)
    {

        $request->validate([
            'id' => ['required','numeric','exists:prime_teachers,teacher_id']
        ]);

        PrimeTeacherRequest::where('teacher_id',$request->id)->update([
            'status' => false
        ]);

        PrimeTeacher::where('teacher_id', $request->id)->delete();
        return redirect()->route('panel.prime.teacher.index')->with([
            'success' => 'با موفقیت حذف شد'
        ]);
    }
}
