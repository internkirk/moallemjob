<?php

namespace App\Http\Controllers;

use App\Models\PrimeTeacher;
use Illuminate\Http\Request;
use App\Models\PrimeTeacherRequest;
use App\Models\PrimeTeacherResponse;
use Illuminate\Support\Facades\Storage;

class PrimeTeacherRequestController extends Controller
{
    public function index()
    {
        $requests = PrimeTeacherRequest::orderByDesc('created_at')->get();
        return view('panel.prime-teachers.requests.index', compact('requests'));
    }
    public function show($id)
    {
        $request = PrimeTeacherRequest::findOrFail($id);
        return view('panel.prime-teachers.requests.show', compact('request'));
    }
    public function edit($id)
    {
        $request = PrimeTeacherRequest::findOrFail($id);
        return view('panel.prime-teachers.requests.edit', compact('request'));
    }
    public function update(Request $request, $id)
    {
        $primeRequest = PrimeTeacherRequest::findOrFail($id);

        $primeRequest->update([
            'status' => $request->status == 'true' ? true : false
        ]);

        if ($request->has('response') && $request->response != NULL) {

            $primeRequest = PrimeTeacherRequest::findOrFail($id);

           PrimeTeacherResponse::create([
                'teacher_id' => $primeRequest->teacher_id,
                'request_id' => $id,
                'text' => $request->response
            ]);

        }

        if ($request->status == 'true') {
            $this->addToPrimeTeachers($primeRequest->teacher_id);
        }

        if ($request->status == 'false') {
            $this->removeFromPrimeTeachers($primeRequest->teacher_id);
        }

        return redirect()->route('panel.prime.teacher.requests.index')->with([
            'success' => 'با موفقیت ویرایش شد'
        ]);
    }
    public function delete(Request $request)
    {

        $request->validate([
            'id' => ['required', 'exists:prime_teacher_requests,id']
        ]);

         PrimeTeacherRequest::findOrFail($request->id)->delete();

        Storage::disk('public')->deleteDirectory("/prime-teacher-requests/images/" . $request->id);

        return redirect()->route('panel.prime.teacher.requests.index')->with([
            'success' => 'با موفقیت حذف شد'
        ]);
    }


    private function addToPrimeTeachers($teacher_id)
    {
        PrimeTeacher::updateOrCreate(['teacher_id' => $teacher_id], [
            'teacher_id' => $teacher_id
        ]);
    }

    private function removeFromPrimeTeachers($teacher_id)
    {
        PrimeTeacher::where('teacher_id', $teacher_id)->delete();
    }
}
