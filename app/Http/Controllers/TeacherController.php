<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TeacherController extends Controller
{
    public function index()
    {
        $teachers = Teacher::all();
        return view('panel.users.teacher.index', compact('teachers'));
    }
    public function create()
    {
        $users = User::all();
        return view('panel.users.teacher.create',compact('users'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'first_name' => ['required', 'max:255'],
            'last_name' => ['required', 'max:255'],
            // 'is_male' => ['required'],
            // 'is_single' => ['required'],
            'avatar' => ['sometimes', 'mimes:png,jpg,webp.jpeg', 'image'],
            'description' => ['sometimes'],
            'age' => ['required'],
            'city' => ['required'],
            'province' => ['required'],
            // 'is_selected' => ['required'],
            'phone' => ['required', 'unique:teachers,phone'],
            'email' => ['required', 'email', 'unique:teachers,email'],
        ]);


        $teacher = Teacher::create([
            'user_id' => $request->user_id,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'is_male' => $request->is_male == 'on' ? true : false,
            'is_single' => $request->is_single == 'on' ? true : false,
            'avatar' => '/',
            'description' => $request->description,
            'age' => $request->age,
            'city' => $request->city,
            'province' => $request->province,
            'is_selected' => $request->is_selected == 'on' ? true : false,
            'phone' => $request->phone,
            'email' => $request->email,
        ]);

        if ($request->file('avatar')) {
            $this->saveImages($request, $teacher->id);
        }

        if ($request->file('selection_image')) {
            $this->saveSelectionImages($request, $teacher->id);
        }

        return redirect()->route('panel.teacher.index')->with([
            'success' => 'با موفقیت ساخته شد'
        ]);
    }
    public function update(Request $request, $id)
    {

        $request->validate([
            'first_name' => ['required', 'max:255'],
            'last_name' => ['required', 'max:255'],
            // 'is_male' => ['required'],
            // 'is_single' => ['required'],
            'avatar' => ['sometimes'],
            'description' => ['sometimes'],
            'age' => ['required'],
            'city' => ['required'],
            'province' => ['required'],
            // 'is_selected' => ['required'],
            'phone' => ['required', 'unique:teachers,phone,' . $id],
            'email' => ['required', 'email', 'unique:teachers,email,' . $id],
        ]);

        Teacher::findOrFail($id)->update([
            'user_id' => $request->user_id,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'is_male' => $request->is_male == 'on' ? true : false,
            'is_single' => $request->is_single == 'on' ? true : false,
            'description' => $request->description,
            'age' => $request->age,
            'city' => $request->city,
            'province' => $request->province,
            'is_selected' => $request->is_selected == 'on' ? true : false,
            'phone' => $request->phone,
            'email' => $request->email,
        ]);


        if ($request->file('avatar')) {
            $this->saveImages($request, $id);
        }

        if ($request->file('selection_image')) {
            $this->saveSelectionImages($request, $id);
        }


        return redirect()->route('panel.teacher.index')->with([
            'success' => 'با موفقیت ویرایش شد'
        ]);
    }
    public function edit($id)
    {
        $users = User::all();
        $teacher = Teacher::findOrFail($id);
        return view('panel.users.teacher.edit', compact('teacher','users'));
    }
    public function delete(Request $request)
    {
        Teacher::findOrFail($request->id)->delete();

        Storage::disk('public')->deleteDirectory("/teacher/images/" . $request->id);

        return redirect()->route('panel.teacher.index')->with([
            'success' => 'با موفقیت حذف شد'
        ]);
    }

    private function saveImages(Request $request, $id)
    {

        $path = [];

        // foreach ($request->file('image') as $key => $image) {

        Storage::disk('public')->deleteDirectory("/teacher/images/" . $id);

        Storage::disk('public')->makeDirectory('/teacher/images/');
        $path[] = "/storage/" . Storage::disk('public')->put("/teacher/images/" . $id, $request->avatar);
        // }

        Teacher::findOrFail($id)->update([
            'avatar' => json_encode($path)
        ]);
    }
    private function saveSelectionImages(Request $request, $id)
    {

        $path = [];

        // foreach ($request->file('image') as $key => $image) {

        Storage::disk('public')->deleteDirectory("/teacher/images/selection_image/" . $id);

        Storage::disk('public')->makeDirectory('/teacher/images/');
        $path[] = "/storage/" . Storage::disk('public')->put("/teacher/images/selection_image/" . $id, $request->selection_image);
        // }

        Teacher::findOrFail($id)->update([
            'selection_image' => json_encode($path)
        ]);
    }
}
