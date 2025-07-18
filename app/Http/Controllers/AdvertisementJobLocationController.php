<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Advertisement;
use App\Models\AdvertisementJobLocation;

class AdvertisementJobLocationController extends Controller
{
    public function index()
    {
    }
    public function create($id)
    {
        $advertisement = Advertisement::findOrFail($id);
        return view('panel.advertisement.job-location.create', compact('advertisement'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'province' => ['required'],
            'city' => ['required'],
        ]);

        AdvertisementJobLocation::create([
            'advertisement_id' => $request->advertisement_id,
            'city' => $request->city,
            'province' => $request->province,
        ]);


        return redirect()->route('panel.advertisement.job.location.show', $request->advertisement_id)->with([
            'success' => 'با موفقیت ساخته شد'
        ]);
    }
    public function edit($teacher_id, $id)
    {
        $advertisement = Advertisement::findOrFail($teacher_id);
        $jobLocation = AdvertisementJobLocation::where('id',$id)->first();
        return view('panel.advertisement.job-location.edit',compact('jobLocation','advertisement'));
    }
    public function update(Request $request, $id)
    {
        $request->validate([
            'province' => ['required'],
            'city' => ['required'],
        ]);

        AdvertisementJobLocation::findOrFail($id)->update([
            'advertisement_id' => $request->advertisement_id,
            'city' => $request->city,
            'province' => $request->province,
        ]);

        return redirect()->route('panel.advertisement.job.location.show',$request->advertisement_id)->with([
            'success' => 'با موفقیت ویرایش شد'
        ]);
    }
    public function show($id)
    {
        $advertisement = Advertisement::findOrFail($id);
        $jobLocations = AdvertisementJobLocation::where('advertisement_id', $id)->get();
        return view('panel.advertisement.job-location.show', compact('jobLocations', 'advertisement'));
    }
    public function delete(Request $request)
    {
        AdvertisementJobLocation::findOrFail($request->id)->delete();

        return redirect()->route('panel.advertisement.job.location.show',$request->advertisement_id)->with([
            'success' => 'با موفقیت حذف شد'
        ]);
    }
}
