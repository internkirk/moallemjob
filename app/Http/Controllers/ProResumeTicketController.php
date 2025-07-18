<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProResumeTicket;
use Illuminate\Support\Facades\Storage;
use App\Models\ProfessionalResumeRequest;

class ProResumeTicketController extends Controller
{
    public function index($request_id)
    {
        $tickets = ProResumeTicket::where('request_id', $request_id)->orderBy("created_at",'asc')->get();
        return view('panel.pro-resume-ticket.index', compact('tickets','request_id'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'text' => ['required'],
            'request_id' => ['required', 'exists:professional_resume_requests,id']
        ]);


       $ticket = ProResumeTicket::create([
            'text' => $request->text,
            'request_id' => $request->request_id,
            'is_admin' => true
        ]);

        if ($request->hasFile('file')) {
            $this->saveFile($request, $ticket->id);
        }

        return redirect()->route('panel.pro.resume.ticket.index',$request->request_id)->with([
            'success' => 'پاسخ شما با موفقیت ثبت شد'
        ]);
    }

    private function saveFile(Request $request, $id)
    {
        $path = [];

        Storage::disk('public')->deleteDirectory("/ticket/file/" . $id);

        Storage::disk('public')->makeDirectory('/ticket/file/');
        $path[] = "/storage/" . Storage::disk('public')->put("/ticket/file/" . $id, $request->file);

        ProResumeTicket::findOrFail($id)->update([
            'file' => json_encode($path)
        ]);
    }
}
