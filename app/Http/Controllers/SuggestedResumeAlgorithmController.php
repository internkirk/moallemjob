<?php

namespace App\Http\Controllers;

use App\Models\AdvertisementAdditionalCondition;
use Illuminate\Http\Request;
use App\Models\AdvertisementEducation;
use App\Models\AdvertisementJobSalary;
use App\Models\AdvertisementSoftSkill;
use App\Models\AdvertisementJobLocation;
use App\Models\SuggestedResumeAlgorithm;
use App\Models\AdvertisementJobBackground;
use App\Models\AdvertisementJobDescription;
use App\Models\AdvertisementJobIntroduction;
use App\Models\AdvertisementJobRequirements;

class SuggestedResumeAlgorithmController extends Controller
{
    public function index()
    {
        $items = SuggestedResumeAlgorithm::all();
        return view('panel.plan.suggested-resume-algorithm.index', compact('items'));
    }
    public function create()
    {
        $colNames = $this->getModelColumns();
        return view('panel.plan.suggested-resume-algorithm.create', compact('colNames'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'items' => ['required']
        ]);

        SuggestedResumeAlgorithm::create([
            'items' => json_encode($request->items)
        ]);

        return redirect()->route('panel.suggested.resume.algorithm.index')->with([
            'success' => 'با موفقیت ساخته شد'
        ]);
    }
    public function edit($id)
    {
        $item = SuggestedResumeAlgorithm::findOrFail($id);
        $colNames = $this->getModelColumns();
        return view('panel.plan.suggested-resume-algorithm.edit', compact('item', 'colNames'));
    }
    public function update(Request $request, $id)
    {
        $request->validate([
            'items' => ['required']
        ]);
        SuggestedResumeAlgorithm::findOrFail($id)->update([
            'items' => json_encode($request->items)
        ]);
        return redirect()->route('panel.suggested.resume.algorithm.index')->with([
            'success' => 'با موفقیت ویرایش شد'
        ]);
    }
    public function delete(Request $request)
    {
        SuggestedResumeAlgorithm::findOrFail($request->id)->delete();
        return redirect()->route('panel.suggested.resume.algorithm.index')->with([
            'success' => 'با موفقیت حذف شد'
        ]);
    }

    private function getModelColumns()
    {

        $columns = [];

        $models = [
            AdvertisementJobIntroduction::class,
            AdvertisementJobDescription::class,
            AdvertisementSoftSkill::class,
            AdvertisementJobSalary::class,
            AdvertisementJobRequirements::class,
            AdvertisementJobLocation::class,
            AdvertisementJobBackground::class,
            AdvertisementEducation::class,
            AdvertisementAdditionalCondition::class,
        ];

        foreach ($models as $key => $model) {
            $columns[] = $model::getColumns();
        }

        return $columns;
    }
}
