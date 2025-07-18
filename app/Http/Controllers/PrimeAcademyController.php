<?php

namespace App\Http\Controllers;

use App\Models\PrimeAcademy;
use Illuminate\Http\Request;
use App\Models\PrimeAcademyRequest;

class PrimeAcademyController extends Controller
{
    public function index()
    {
        $records = PrimeAcademy::all();
        return view('panel.prime-academy.index',compact('records'));
    }
    public function delete(Request $request)
    {

        $request->validate([
            'id' => ['required','numeric','exists:prime_academies,academy_id']
        ]);

        PrimeAcademyRequest::where('academy_id',$request->id)->update([
            'status' => false
        ]);

        PrimeAcademy::where('academy_id', $request->id)->delete();
        return redirect()->route('panel.prime.academy.index')->with([
            'success' => 'با موفقیت حذف شد'
        ]);
    }
}
