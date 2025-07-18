<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Advertisement;
use App\Models\AdvertisementAdditionalCondition;

class AdvertisementAdditionalConditionController extends Controller
{
    public function index()
    {
    }
    public function create($id)
    {
        $advertisement = Advertisement::findOrFail($id);
        return view('panel.advertisement.job-additional-condition.create', compact('advertisement'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'military_service' => ['required'],
            'selection_certificate' => ['required'],
            'no_crime_certificate' => ['required'],
        ]);

        AdvertisementAdditionalCondition::create([
            'advertisement_id' => $request->advertisement_id,
            'military_service' => $request->military_service == 'true' ? true : false,
            'selection_certificate' => $request->selection_certificate == 'true' ? true : false,
            'no_crime_certificate' => $request->no_crime_certificate == 'true' ? true : false,
        ]);


        return redirect()->route('panel.advertisement.job.additional.condition.show', $request->advertisement_id)->with([
            'success' => 'با موفقیت ساخته شد'
        ]);
    }
    public function edit($teacher_id, $id)
    {
        $advertisement = Advertisement::findOrFail($teacher_id);
        $jobAdditionalCondition = AdvertisementAdditionalCondition::where('id', $id)->first();
        return view('panel.advertisement.job-additional-condition.edit', compact('jobAdditionalCondition', 'advertisement'));
    }
    public function update(Request $request, $id)
    {
        $request->validate([
            'military_service' => ['required'],
            'selection_certificate' => ['required'],
            'no_crime_certificate' => ['required'],
        ]);

        AdvertisementAdditionalCondition::findOrFail($id)->update([
            'advertisement_id' => $request->advertisement_id,
            'military_service' => $request->military_service == 'true' ? true : false,
            'selection_certificate' => $request->selection_certificate == 'true' ? true : false,
            'no_crime_certificate' => $request->no_crime_certificate == 'true' ? true : false,
        ]);

        return redirect()->route('panel.advertisement.job.additional.condition.show', $request->advertisement_id)->with([
            'success' => 'با موفقیت ویرایش شد'
        ]);
    }
    public function show($id)
    {
        $advertisement = Advertisement::findOrFail($id);
        $jobAdditionalConditions = AdvertisementAdditionalCondition::where('advertisement_id', $id)->get();
        return view('panel.advertisement.job-additional-condition.show', compact('jobAdditionalConditions', 'advertisement'));
    }
    public function delete(Request $request)
    {
        AdvertisementAdditionalCondition::findOrFail($request->id)->delete();

        return redirect()->route('panel.advertisement.job.additional.condition.show', $request->advertisement_id)->with([
            'success' => 'با موفقیت حذف شد'
        ]);
    }
}
