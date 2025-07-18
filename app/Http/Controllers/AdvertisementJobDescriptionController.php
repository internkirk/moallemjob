<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Advertisement;
use App\Models\AdvertisementJobDescription;

class AdvertisementJobDescriptionController extends Controller
{
    public function index()
    {
    }
    public function create($id)
    {
        $advertisement = Advertisement::findOrFail($id);
        return view('panel.advertisement.job-description.create', compact('advertisement'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'job_time' => ['required'],
        ]);

        AdvertisementJobDescription::create([
            'advertisement_id' => $request->advertisement_id,
            'job_time' => $request->job_time,
            'job_description' => $request->job_description,
        ]);


        return redirect()->route('panel.advertisement.job.description.show', $request->advertisement_id)->with([
            'success' => 'با موفقیت ساخته شد'
        ]);
    }
    public function edit($teacher_id, $id)
    {
        $advertisement = Advertisement::findOrFail($teacher_id);
        $jobDescription = AdvertisementJobDescription::where('id',$id)->first();
        return view('panel.advertisement.job-description.edit',compact('jobDescription','advertisement'));
    }
    public function update(Request $request, $id)
    {
        $request->validate([
            'job_time' => ['required'],
        ]);

        AdvertisementJobDescription::findOrFail($id)->update([
            'advertisement_id' => $request->advertisement_id,
            'job_time' => $request->job_time,
            'job_description' => $request->job_description,
        ]);

        return redirect()->route('panel.advertisement.job.description.show',$request->advertisement_id)->with([
            'success' => 'با موفقیت ویرایش شد'
        ]);
    }
    public function show($id)
    {
        $advertisement = Advertisement::findOrFail($id);
        $jobDescriptions = AdvertisementJobDescription::where('advertisement_id', $id)->get();
        return view('panel.advertisement.job-description.show', compact('jobDescriptions', 'advertisement'));
    }
    public function delete(Request $request)
    {
        AdvertisementJobDescription::findOrFail($request->id)->delete();

        return redirect()->route('panel.advertisement.job.description.show',$request->advertisement_id)->with([
            'success' => 'با موفقیت حذف شد'
        ]);
    }
}
