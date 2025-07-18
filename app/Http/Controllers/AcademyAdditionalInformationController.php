<?php

namespace App\Http\Controllers;

use App\Models\Academy;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\AcademyAdditionalInformation;

class AcademyAdditionalInformationController extends Controller
{
    public function index()
    {
    }
    public function create($id)
    {
        $academy = Academy::findOrFail($id);
        return view('panel.academy.additional-informations.create', compact('academy'));
    }
    public function show($id)
    {
        $academy = Academy::findOrFail($id);
        $informations = AcademyAdditionalInformation::where('academy_id', $id)->get();
        return view('panel.academy.additional-informations.show', compact('informations', 'academy'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'establishment_year' => ['required'],
            'establishment_license_image' => ['required', 'image', 'mimes:png,jpg,jpeg,webp'],
            'startup_license_image' => ['required', 'image', 'mimes:png,jpg,jpeg,webp'],
            'profile_image' => ['sometimes'],
            'benefits' => ['sometimes'],
            'school_image' => ['sometimes'],
        ]);

        $information = AcademyAdditionalInformation::create([
            'academy_id' => $request->academy_id,
            'establishment_year' => $request->establishment_year,
            'establishment_license_image' => '/',
            'startup_license_image' => '/',
            'profile_image' => '/',
            'benefits' => $request->benefits,
            'school_image' => '/',
        ]);

        if ($request->file('establishment_license_image')) {
            $this->saveImages($request, 'establishment_license_image', $information->id);
        }
        if ($request->file('startup_license_image')) {
            $this->saveImages($request, 'startup_license_image', $information->id);
        }
        if ($request->file('profile_image')) {
            $this->saveImages($request, 'profile_image', $information->id);
        }
        if ($request->file('school_image')) {
            $this->saveMultipleImages($request->file('school_image'), 'school_image', $information->id);
        }

        return redirect()->route('panel.academy.additional.informations.show', $request->academy_id)->with([
            'success' => 'با موفقیت ساخته شد'
        ]);
    }
    public function edit($academy_id, $id)
    {
        $academy = Academy::findOrFail($academy_id);
        $information = AcademyAdditionalInformation::where('id', $id)->first();
        return view('panel.academy.additional-informations.edit', compact('information', 'academy'));
    }
    public function update(Request $request, $id)
    {
        $request->validate([
            'establishment_year' => ['required'],
            'establishment_license_image' => ['sometimes', 'image', 'mimes:png,jpg,jpeg,webp'],
            'startup_license_image' => ['sometimes', 'image', 'mimes:png,jpg,jpeg,webp'],
            'profile_image' => ['sometimes'],
            'benefits' => ['sometimes'],
            'school_image' => ['sometimes'],
        ]);


        $res = AcademyAdditionalInformation::findOrFail($id);
        $res->update([
            'establishment_year' => $request->establishment_year,
            'benefits' => $request->benefits,
        ]);

        if ($request->file('establishment_license_image')) {
            $this->saveImages($request, 'establishment_license_image', $id);
        }
        if ($request->file('startup_license_image')) {
            $this->saveImages($request, 'startup_license_image', $id);
        }
        if ($request->file('profile_image')) {
            $this->saveImages($request, 'profile_image', $id);
        }
        if ($request->file('school_image')) {
            $this->saveMultipleImages($request->file('school_image'), 'school_image', $id);
        }

        return redirect()->route('panel.academy.additional.informations.show', $request->academy_id)->with([
            'success' => 'با موفقیت ویرایش شد'
        ]);

    }
    public function delete(Request $request)
    {
        AcademyAdditionalInformation::findOrFail($request->id)->delete();

        Storage::disk('public')->deleteDirectory("/academy/additional-informations/establishment_license_image/images/" . $request->id);
        Storage::disk('public')->deleteDirectory("/academy/additional-informations/startup_license_image/images/" . $request->id);
        Storage::disk('public')->deleteDirectory("/academy/additional-informations/profile_image/images/" . $request->id);
        Storage::disk('public')->deleteDirectory("/academy/additional-informations/school_image/images/" . $request->id);

        return redirect()->route('panel.academy.additional.informations.show', $request->academy_id)->with([
            'success' => 'با موفقیت حذف شد'
        ]);
    }

    private function saveImages(Request $request, $folder, $id)
    {
        $path = [];

        Storage::disk('public')->deleteDirectory("/academy/additional-informations/$folder/images/" . $id);

        Storage::disk('public')->makeDirectory("/academy/additional-informations/$folder/images/");

        $path[] = "/storage/" . Storage::disk('public')->put("/academy/additional-informations/$folder/images/" . $id, $request->$folder);

        AcademyAdditionalInformation::findOrFail($id)->update([
            $folder => json_encode($path)
        ]);
    }

    private function saveMultipleImages($request, $folder, $id)
    {
        $path = [];

        Storage::disk('public')->deleteDirectory("/academy/additional-informations/$folder/images/" . $id);

        Storage::disk('public')->makeDirectory("/academy/additional-informations/$folder/images/");

        foreach ($request as $key => $image) {
            $path[] = "/storage/" . Storage::disk('public')->put("/academy/additional-informations/$folder/images/" . $id, $image);
        }

        AcademyAdditionalInformation::findOrFail($id)->update([
            $folder => json_encode($path)
        ]);
    }
}
