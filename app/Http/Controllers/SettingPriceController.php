<?php

namespace App\Http\Controllers;

use App\Models\SettingPrice;
use Illuminate\Http\Request;

class SettingPriceController extends Controller
{
    public function index()
    {
        $prices = SettingPrice::all();
        return view('panel.setting.price-management.index',compact('prices'));
    }
    public function create()
    {
        return view('panel.setting.price-management.create');
    }
    public function store(Request $request)
    {
        $request->validate([
            'title' => ['required','unique:setting_prices,title'],
            'price' => ['required'],
        ]);

        SettingPrice::create([
            'title' => $request->title,
            'price' => $request->price,
        ]);

        return redirect()->route('panel.setting.price.index')->with([
            'success' => 'با موفقیت ایجاد شد'
        ]);
    }
    public function edit($id)
    {
        $price = SettingPrice::findOrFail($id);
        return view('panel.setting.price-management.edit',compact('price'));
    }
    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => ['required','unique:setting_prices,title,'.$id],
            'price' => ['required'],
        ]);

        SettingPrice::findOrFail($id)->update([
            'title' => $request->title,
            'price' => $request->price,
        ]);

        return redirect()->route('panel.setting.price.index')->with([
            'success' => 'با موفقیت ویرایش شد'
        ]);

    }
    public function delete(Request $request)
    {
        $request->validate([
            'id' => ['required','exists:setting_prices,id']
        ]);

        SettingPrice::findOrFail($request->id)->delete();

        return redirect()->route('panel.setting.price.index')->with([
            'success' => 'با موفقیت حذف شد'
        ]);
    }
}
