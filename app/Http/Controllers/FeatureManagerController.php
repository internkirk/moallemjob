<?php

namespace App\Http\Controllers;

use App\Models\FeatureManager;
use Illuminate\Http\Request;

class FeatureManagerController extends Controller
{
    public function index()
    {
        $features = FeatureManager::all();
        return view('panel.setting.feature-management.index', compact('features'));
    }
    public function create()
    {
        return view('panel.setting.feature-management.create');
    }
    public function store(Request $request)
    {
        $request->validate([
            'feature' => ['required', 'unique:feature_managers,feature']
        ]);

        FeatureManager::create([
            'feature' => $request->feature,
            'fa_title' => $request->fa_title,
            'status' => $request->status == "true" ? true : false
        ]);

        return redirect()->route('panel.feature.management.index')->with([
            'success' => 'با موفقیت ساخته شد'
        ]);
    }
    public function edit($id)
    {
        $feature = FeatureManager::findOrFail($id);
        return view('panel.setting.feature-management.edit', compact('feature'));
    }
    public function update(Request $request, $id)
    {
        $request->validate([
            'feature' => ['required', 'unique:feature_managers,feature,'.$id]
        ]);

        FeatureManager::findOrFail($id)->update([
            'feature' => $request->feature,
            'fa_title' => $request->fa_title,
            'status' => $request->status == "true" ? true : false
        ]);

        return redirect()->route('panel.feature.management.index')->with([
            'success' => 'با موفقیت ویرایش شد'
        ]);
    }
    public function delete(Request $request)
    {
        FeatureManager::findOrFail($request->id)->delete();
        return redirect()->route('panel.feature.management.index')->with([
            'success' => 'با موفقیت حذف شد شد'
        ]);
    }
}
