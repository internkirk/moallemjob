<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Advertisement;
use Illuminate\Support\Facades\Storage;
use App\Models\AdvertisementJobIntroduction;

class AdvertisementController extends Controller
{
    public function index()
    {
        $advertisements = AdvertisementJobIntroduction::all();
        return view('panel.advertisement.index', compact('advertisements'));
    }
    public function create()
    {
        return view('panel.advertisement.create');
    }
    public function store(Request $request)
    {

        $request->validate([
            'job_title' => ['required', 'max:255'],
            'academic_level' => ['required', 'max:255'],
            'school_role' => ['required', 'max:255'],
            'academic_section' => ['required', 'max:255'],
            'major' => ['required', 'max:255'],
            'cooperation_type' => ['required', 'max:255'],
            'status' => ['required'],
            'is_featured' => ['required'],
            'is_urgent' => ['required'],
        ]);

        $advertisement = Advertisement::create([
            'user_id' => auth()->user()->id,
            'status' => $request->status == 'true' ? true : false,
            'is_featured' => $request->is_featured == 'true' ? true : false,
            'is_urgent' => $request->is_urgent == 'true' ? true : false
        ]);


        AdvertisementJobIntroduction::create([
            'advertisement_id' => $advertisement->id,
            'job_title' => $request->job_title,
            'academic_level' => $request->academic_level,
            'school_role' => $request->school_role,
            'academic_section' => $request->academic_section,
            'major' => $request->major,
            'status' => $request->status == 'true' ? true : false,
            'cooperation_type' => $request->cooperation_type,
        ]);

        return redirect()->route('panel.advertisement.index')->with([
            'success' => 'با موفقیت ایجاد شد'
        ]);
    }
    public function edit($id)
    {
        $advertisement = AdvertisementJobIntroduction::where('advertisement_id',$id)->first();
        return view('panel.advertisement.edit', compact('advertisement'));
    }
    public function update(Request $request, $id)
    {
        $request->validate([
            'job_title' => ['required', 'max:255'],
            'academic_level' => ['required', 'max:255'],
            'school_role' => ['required', 'max:255'],
            'academic_section' => ['required', 'max:255'],
            'major' => ['required', 'max:255'],
            'cooperation_type' => ['required', 'max:255'],
            'status' => ['required'],
            'is_featured' => ['required'],
            'is_urgent' => ['required'],
        ]);

        AdvertisementJobIntroduction::findOrFail($id)->advertisement()->update([
            'status' => $request->status == 'true' ? true : false,
            'is_featured' => $request->is_featured == 'true' ? true : false,
            'is_urgent' => $request->is_urgent == 'true' ? true : false
        ]);


        AdvertisementJobIntroduction::findOrFail($id)->update([
            'job_title' => $request->job_title,
            'academic_level' => $request->academic_level,
            'school_role' => $request->school_role,
            'academic_section' => $request->academic_section,
            'major' => $request->major,
            // 'status' => $request->status == 'true' ? true : false,
            'cooperation_type' => $request->cooperation_type,
        ]);

        return redirect()->route('panel.advertisement.index')->with([
            'success' => 'با موفقیت ویرایش شد'
        ]);
    }
    public function delete(Request $request)
    {
        AdvertisementJobIntroduction::findOrFail($request->id)->delete();
        return redirect()->route('panel.academy.index')->with([
            'success' => 'با موفقیت حذف شد'
        ]);
    }

}
