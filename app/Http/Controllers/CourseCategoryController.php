<?php

namespace App\Http\Controllers;

use App\Models\CourseCategory;
use Illuminate\Http\Request;

class CourseCategoryController extends Controller
{
    public function index()
    {
        $categories = CourseCategory::all();
        return view('panel.shop.course.category.index', compact('categories'));
    }
    public function create()
    {
        return view('panel.shop.course.category.create');
    }
    public function store(Request $request)
    {
        $request->validate([
            'title' => ['required', 'unique:course_categories,title']
        ]);


        CourseCategory::create([
            'title' => $request->title
        ]);


        return redirect()->route('panel.shop.course.category.index')->with([
            'success' => 'با موفقیت ایجاد شد'
        ]);
    }
    public function edit($id)
    {
        $category = CourseCategory::findOrFail($id);
        return view('panel.shop.course.category.edit', compact('category'));
    }
    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => ['required', 'unique:course_categories,title,' . $id]
        ]);


        CourseCategory::findOrFail($id)->update([
            'title' => $request->title
        ]);

        return redirect()->route('panel.shop.course.category.index')->with([
            'success' => 'با موفقیت ویرایش شد'
        ]);
    }
    public function delete(Request $request)
    {
        $request->validate([
            'id' => ['required','exists:course_categories,id']
        ]);

        CourseCategory::findOrFail($request->id)->delete();

        return redirect()->route('panel.shop.course.category.index')->with([
            'success' => 'با موفقیت حذف شد'
        ]);
    }
}
