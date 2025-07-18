<?php

namespace App\Http\Controllers;

use App\Models\AdvertisementEducation;
use Illuminate\Http\Request;
use App\Models\Advertisement;

class AdvertisementEducationController extends Controller
{
    public function index()
    {
    }
    public function create($id)
    {
        $advertisement = Advertisement::findOrFail($id);
        return view('panel.advertisement.job-education.create', compact('advertisement'));
    }
    public function show($id)
    {
        $advertisement = Advertisement::findOrFail($id);
        $educations = AdvertisementEducation::where('advertisement_id', $id)->get();
        return view('panel.advertisement.job-education.show', compact('educations', 'advertisement'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'major' => ['required'],
            'academic_level' => ['required'],
        ]);

        foreach ($request->major as $key => $major) {
            AdvertisementEducation::create([
                'advertisement_id' => $request->advertisement_id,
                'major' => $major,
                'academic_level' => $request->academic_level[$key],
            ]);
        }

        return redirect()->route('panel.advertisement.job.education.show', $request->advertisement_id)->with([
            'success' => 'با موفقیت ساخته شد'
        ]);
    }
    public function edit($advertisement_id, $id)
    {
        $advertisement = Advertisement::findOrFail($advertisement_id);
        $education = AdvertisementEducation::where('id', $id)->first();
        return view('panel.advertisement.job-education.edit', compact('education', 'advertisement'));
    }
    public function update(Request $request, $id)
    {
        $request->validate([
            'major' => ['required'],
            'academic_level' => ['required'],
        ]);

        AdvertisementEducation::findOrFail($id)->update([
            'advertisement_id' => $request->advertisement_id,
            'major' => $request->major,
            'academic_level' => $request->academic_level,
        ]);

        return redirect()->route('panel.advertisement.job.education.show', $request->advertisement_id)->with([
            'success' => 'با موفقیت ویرایش شد'
        ]);
    }

    public function delete(Request $request)
    {
        AdvertisementEducation::findOrFail($request->id)->delete();

        return redirect()->route('panel.advertisement.job.education.show', $request->advertisement_id)->with([
            'success' => 'با موفقیت حذف شد'
        ]);
    }
}
