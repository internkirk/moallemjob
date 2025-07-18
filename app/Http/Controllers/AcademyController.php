<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Academy;
use App\Models\AcademyLevel;
use App\Models\PrimeAcademy;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AcademyController extends Controller
{
    public function index()
    {
        $academies = Academy::all();
        return view('panel.academy.index', compact('academies'));
    }
    public function create()
    {

        $users = User::all();
        return view('panel.academy.create', compact('users'));
    }
    public function store(Request $request)
    {

        $request->validate([
            'name' => ['required', 'max:255'],
            'logo' => ['sometimes', 'mimes:png,jpg,webp.jpeg', 'image'],
            'description' => ['sometimes'],
            'short_description' => ['required'],
            'city' => ['required'],
            'province' => ['required'],
            'website' => ['sometimes'],
            'students_number' => ['required', 'numeric'],
            'phone' => ['required', 'unique:academies,phone', 'numeric'],
            'academy_level_title' => ['required']
        ]);


        $academy = Academy::create([
            'user_id' => $request->user_id,
            'name' => $request->name,
            'logo' => '/',
            'description' => $request->description,
            'short_description' => $request->short_description,
            'city' => $request->city,
            'province' => $request->province,
            'website' => $request->website,
            'students_number' => $request->students_number,
            'phone' => $request->phone,
            'email' => $request->email,
        ]);

        if ($request->is_prime_academy) {
            PrimeAcademy::updateOrCreate(['academy_id', $academy->id],[
                'academy_id' => $academy->id
            ]);
        }

        if ($request->file('logo')) {
            $this->saveImages($request, $academy->id);
        }

        if ($request->academy_level_title) {

            foreach ($request->academy_level_title as $key => $title) {
                AcademyLevel::create([
                    'title' => $title,
                    'academy_id' => $academy->id
                ]);
            }

        }


        return redirect()->route('panel.academy.index')->with([
            'success' => 'با موفقیت ایجاد شد'
        ]);
    }
    public function edit($id)
    {
        $academy = Academy::findOrFail($id);
        $users = User::all();
        return view('panel.academy.edit', compact('academy', 'users'));
    }
    public function update(Request $request, $id)
    {
        $request->validate([

            'name' => ['required', 'max:255'],
            'logo' => ['sometimes', 'mimes:png,jpg,webp.jpeg', 'image'],
            'description' => ['sometimes'],
            'short_description' => ['required'],
            'city' => ['required'],
            'province' => ['required'],
            'website' => ['sometimes'],
            'students_number' => ['required', 'numeric'],
            'phone' => ['required', 'unique:academies,phone,' . $id, 'numeric'],
        ]);

        Academy::findOrFail($id)->update([
            'user_id' => $request->user_id,
            'name' => $request->name,
            'description' => $request->description,
            'short_description' => $request->short_description,
            'city' => $request->city,
            'province' => $request->province,
            'website' => $request->website,
            'students_number' => $request->students_number,
            'phone' => $request->phone,
            'email' => $request->email,
        ]);

        if ($request->is_prime_academy) {
            PrimeAcademy::updateOrCreate(['academy_id'=> $id],[
                'academy_id' => $id
            ]);
        }

        if ($request->file('logo')) {
            $this->saveImages($request, $id);
        }

        return redirect()->route('panel.academy.index')->with([
            'success' => 'با موفقیت ویرایش شد'
        ]);
    }
    public function delete(Request $request)
    {
        $academy = Academy::findOrFail($request->id);
        
        Storage::disk('public')->deleteDirectory("/academy/additional-informations/establishment_license_image/images/" . $academy->academyAdditionalInformation->id);
        Storage::disk('public')->deleteDirectory("/academy/additional-informations/startup_license_image/images/" . $academy->academyAdditionalInformation->id);
        Storage::disk('public')->deleteDirectory("/academy/additional-informations/profile_image/images/" . $academy->academyAdditionalInformation->id);
        Storage::disk('public')->deleteDirectory("/academy/additional-informations/school_image/images/" . $academy->academyAdditionalInformation->id);
        Storage::disk('public')->deleteDirectory("/academy/images/" . $request->id);
        
        Academy::findOrFail($request->id)->delete();

        return redirect()->route('panel.academy.index')->with([
            'success' => 'با موفقیت حذف شد'
        ]);
    }



    private function saveImages(Request $request, $id)
    {
        $path = [];

        Storage::disk('public')->deleteDirectory("/academy/images/" . $id);

        Storage::disk('public')->makeDirectory('/academy/images/');
        $path[] = "/storage/" . Storage::disk('public')->put("/academy/images/" . $id, $request->logo);


        Academy::findOrFail($id)->update([
            'logo' => json_encode($path)
        ]);
    }
}
