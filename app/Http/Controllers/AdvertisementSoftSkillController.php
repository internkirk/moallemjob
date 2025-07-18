<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Advertisement;
use App\Models\AdvertisementSoftSkill;

class AdvertisementSoftSkillController extends Controller
{
    public function index()
    {
    }
    public function create($id)
    {
        $advertisement = Advertisement::findOrFail($id);
        return view('panel.advertisement.job-soft-skill.create', compact('advertisement'));
    }
    public function show($id)
    {
        $advertisement = Advertisement::findOrFail($id);
        $skills = AdvertisementSoftSkill::where('advertisement_id', $id)->get();
        return view('panel.advertisement.job-soft-skill.show', compact('skills', 'advertisement'));
    }
    public function store(Request $request)
    {
        
        $request->validate([
            'skill' => ['required'],
        ]);

        foreach ($request->skill as $key => $skill) {
            AdvertisementSoftSkill::create([
                'advertisement_id' => $request->advertisement_id,
                'skill' => $skill,
            ]);
        }

        return redirect()->route('panel.advertisement.job.soft.skill.show', $request->advertisement_id)->with([
            'success' => 'با موفقیت ساخته شد'
        ]);
    }
    public function edit($advertisement_id, $id)
    {
        $advertisement = Advertisement::findOrFail($advertisement_id);
        $skill = AdvertisementSoftSkill::where('id', $id)->first();
        return view('panel.advertisement.job-soft-skill.edit', compact('skill', 'advertisement'));
    }
    public function update(Request $request, $id)
    {
        $request->validate([
            'skill' => ['required'],
        ]);

        AdvertisementSoftSkill::findOrFail($id)->update([
            'advertisement_id' => $request->advertisement_id,
            'skill' => $request->skill,
        ]);

        return redirect()->route('panel.advertisement.job.soft.skill.show', $request->advertisement_id)->with([
            'success' => 'با موفقیت ویرایش شد'
        ]);
    }

    public function delete(Request $request)
    {
        AdvertisementSoftSkill::findOrFail($request->id)->delete();

        return redirect()->route('panel.advertisement.job.soft.skill.show', $request->advertisement_id)->with([
            'success' => 'با موفقیت حذف شد'
        ]);
    }
}
