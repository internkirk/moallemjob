<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AdMajor;

class AdMajorController extends Controller
{
    public function index()
    {
        $majors = AdMajor::all();
        return view('panel.advertisement.setting.index', compact('majors'));
    }
    public function create()
    {
        return view('panel.advertisement.setting.create');
    }
    public function store(Request $request)
    {
        $request->validate([
            'title' => ['required', 'unique:ad_majors,title']
        ]);

        AdMajor::create([
            'title' => $request->title,
        ]);

        return redirect()->route('panel.major.index')->with([
            'success' => 'با موفقیت ساخته شد'
        ]);
    }
    public function edit($id)
    {
        $major = AdMajor::findOrFail($id);
        return view('panel.advertisement.setting.edit', compact('major'));
    }
    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => ['required', 'unique:ad_majors,title,'.$id]
        ]);

        AdMajor::findOrFail($id)->update([
            'title' => $request->title,
        ]);

        return redirect()->route('panel.major.index')->with([
            'success' => 'با موفقیت ویرایش شد'
        ]);
    }
    public function delete(Request $request)
    {
        AdMajor::findOrFail($request->id)->delete();
        return redirect()->route('panel.major.index')->with([
            'success' => 'با موفقیت حذف شد شد'
        ]);
    }
}
