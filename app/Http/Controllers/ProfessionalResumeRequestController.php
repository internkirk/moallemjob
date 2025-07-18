<?php

namespace App\Http\Controllers;

use App\Models\ProfessionalResumeRequest;
use Illuminate\Http\Request;

class ProfessionalResumeRequestController extends Controller
{
    public function index()
    {
        $requests = ProfessionalResumeRequest::all();
        return view('panel.pro-resume-request.index', compact('requests'));
    }
    
     public function edit($id)
    {
        $request = ProfessionalResumeRequest::findOrFail($id);

        return view('panel.pro-resume-request.edit', compact('request'));
    }

    public function update(Request $request, $id)
    {
        ProfessionalResumeRequest::findOrFail($id)->update([
            'request_stage' => $request->request_stage
        ]);

        return redirect()->route('panel.pro.resume.request.index')->with([
            'success' => 'با موفقیت حذف شد'
        ]);
    }

    public function delete(Request $request)
    {
        $request->validate([
            'id' => ['required', 'exists:professional_resume_requests,id']
        ]);

        ProfessionalResumeRequest::findOrFail($request->id)->delete();

        return redirect()->route('panel.pro.resume.request.index')->with([
            'success' => 'با موفقیت حذف شد'
        ]);
    }
}
