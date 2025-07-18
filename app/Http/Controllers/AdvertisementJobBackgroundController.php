<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Advertisement;
use App\Models\AdvertisementJobBackground;

class AdvertisementJobBackgroundController extends Controller
{
    public function index()
    {
    }
    public function create($id)
    {
        $advertisement = Advertisement::findOrFail($id);
        return view('panel.advertisement.job-background.create', compact('advertisement'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'as_intern' => ['required'],
            'must_have_background' => ['required'],
            'background' => ['required_if:must_have_background,true'],
        ],[
            'background.required_if' => 'با توجه به اینکه سابقه کار را فعال کرده اید ،،باید این فیلد را پر کنید'
        ]);

        AdvertisementJobBackground::create([
            'advertisement_id' => $request->advertisement_id,
            'as_intern' => $request->as_intern == 'true' ? true : false,
            'must_have_background' => $request->must_have_background == 'true' ? true : false,
            'background' => $request->background,
        ]);


        return redirect()->route('panel.advertisement.job.background.show', $request->advertisement_id)->with([
            'success' => 'با موفقیت ساخته شد'
        ]);
    }
    public function edit($teacher_id, $id)
    {
        $advertisement = Advertisement::findOrFail($teacher_id);
        $jobBackground = AdvertisementJobBackground::where('id', $id)->first();
        return view('panel.advertisement.job-background.edit', compact('jobBackground', 'advertisement'));
    }
    public function update(Request $request, $id)
    {
        $request->validate([
            'as_intern' => ['required'],
            'must_have_background' => ['required'],
            'background' => ['required_if:must_have_background,true'],
        ],[
            'background.required_if' => 'با توجه به اینکه سابقه کار را فعال کرده اید ،باید این فیلد را پر کنید'
        ]);

        AdvertisementJobBackground::findOrFail($id)->update([
            'advertisement_id' => $request->advertisement_id,
            'as_intern' => $request->as_intern == 'true' ? true : false,
            'must_have_background' => $request->must_have_background == 'true' ? true : false,
            'background' => $request->background,
        ]);

        return redirect()->route('panel.advertisement.job.background.show', $request->advertisement_id)->with([
            'success' => 'با موفقیت ویرایش شد'
        ]);
    }
    public function show($id)
    {
        $advertisement = Advertisement::findOrFail($id);
        $jobBackgrounds = AdvertisementJobBackground::where('advertisement_id', $id)->get();
        return view('panel.advertisement.job-background.show', compact('jobBackgrounds', 'advertisement'));
    }
    public function delete(Request $request)
    {
        AdvertisementJobBackground::findOrFail($request->id)->delete();

        return redirect()->route('panel.advertisement.job.background.show', $request->advertisement_id)->with([
            'success' => 'با موفقیت حذف شد'
        ]);
    }
}
