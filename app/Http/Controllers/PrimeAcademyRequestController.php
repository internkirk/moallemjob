<?php

namespace App\Http\Controllers;

use App\Models\PrimeAcademy;
use Illuminate\Http\Request;
use App\Models\PrimeAcademyRequest;
use App\Models\PrimeTeacherResponse;
use App\Models\PrimeAcademyResponse;
use Illuminate\Support\Facades\Storage;

class PrimeAcademyRequestController extends Controller
{
    public function index()
    {
        $requests = PrimeAcademyRequest::orderByDesc('created_at')->get();
        return view('panel.prime-academy.requests.index', compact('requests'));
    }
    public function show($id)
    {
        $request = PrimeAcademyRequest::findOrFail($id);
        return view('panel.prime-academy.requests.show', compact('request'));
    }
    public function edit($id)
    {
        $request = PrimeAcademyRequest::findOrFail($id);
        return view('panel.prime-academy.requests.edit', compact('request'));
    }
    public function update(Request $request, $id)
    {
        $primeRequest = PrimeAcademyRequest::findOrFail($id);

        $primeRequest->update([
            'status' => $request->status == 'true' ? true : false
        ]);

        if ($request->has('response') && $request->response != NULL) {

            $primeRequest = PrimeAcademyRequest::findOrFail($id);

             PrimeAcademyResponse::create([
                'request_id' => $primeRequest->id,
                'academy_id' => $primeRequest->academy_id,
                'text' => $request->response
            ]);

        }

        if ($request->status == 'true') {
            $this->addToPrimeAcademies($primeRequest->academy_id);
        }

        if ($request->status == 'false') {
            $this->removeFromPrimeAcademies($primeRequest->academy_id);
        }

        return redirect()->route('panel.prime.academy.requests.index')->with([
            'success' => 'با موفقیت ویرایش شد'
        ]);
    }
    public function delete(Request $request)
    {

        $request->validate([
            'id' => ['required', 'exists:prime_academy_requests,id']
        ]);

         PrimeAcademyRequest::findOrFail($request->id)->delete();

        Storage::disk('public')->deleteDirectory("/prime-academy-requests/images/" . $request->id);

        return redirect()->route('panel.prime.academy.requests.index')->with([
            'success' => 'با موفقیت حذف شد'
        ]);
    }


    private function addToPrimeAcademies($academy_id)
    {
        PrimeAcademy::updateOrCreate(['academy_id' => $academy_id], [
            'academy_id' => $academy_id
        ]);
    }

    private function removeFromPrimeAcademies($academy_id)
    {
        PrimeAcademy::where('academy_id', $academy_id)->delete();
    }
}
