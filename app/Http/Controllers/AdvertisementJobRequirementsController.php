<?php

namespace App\Http\Controllers;

use App\Models\AdvertisementJobRequirements;
use Illuminate\Http\Request;
use App\Models\Advertisement;

class AdvertisementJobRequirementsController extends Controller
{
    public function index()
    {
    }
    public function create($id)
    {
        $advertisement = Advertisement::findOrFail($id);
        return view('panel.advertisement.job-requirements.create', compact('advertisement'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'min_age' => ['required'],
            'max_age' => ['required'],
            'sex' => ['required'],
        ]);

        AdvertisementJobRequirements::create([
            'advertisement_id' => $request->advertisement_id,
            'min_age' => $request->min_age,
            'max_age' => $request->max_age,
            'sex' => $request->sex,
        ]);


        return redirect()->route('panel.advertisement.job.requirements.show', $request->advertisement_id)->with([
            'success' => 'با موفقیت ساخته شد'
        ]);
    }
    public function edit($teacher_id, $id)
    {
        $advertisement = Advertisement::findOrFail($teacher_id);
        $jobRequirements = AdvertisementJobRequirements::where('id',$id)->first();
        return view('panel.advertisement.job-requirements.edit',compact('jobRequirements','advertisement'));
    }
    public function update(Request $request, $id)
    {
        $request->validate([
            'min_age' => ['required'],
            'max_age' => ['required'],
            'sex' => ['required'],
        ]);

        AdvertisementJobRequirements::findOrFail($id)->update([
            'advertisement_id' => $request->advertisement_id,
            'min_age' => $request->min_age,
            'max_age' => $request->max_age,
            'sex' => $request->sex,
        ]);

        return redirect()->route('panel.advertisement.job.requirements.show',$request->advertisement_id)->with([
            'success' => 'با موفقیت ویرایش شد'
        ]);
    }
    public function show($id)
    {
        $advertisement = Advertisement::findOrFail($id);
        $jobRequirements = AdvertisementJobRequirements::where('advertisement_id', $id)->get();
        return view('panel.advertisement.job-requirements.show', compact('jobRequirements', 'advertisement'));
    }
    public function delete(Request $request)
    {
        AdvertisementJobRequirements::findOrFail($request->id)->delete();

        return redirect()->route('panel.advertisement.job.requirements.show',$request->advertisement_id)->with([
            'success' => 'با موفقیت حذف شد'
        ]);
    }
}
