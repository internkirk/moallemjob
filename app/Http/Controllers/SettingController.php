<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Laravel\Facades\Image;

class SettingController extends Controller
{

    public function index()
    {
        $settings = Setting::latest()->orderBy('created_at','desc')->get();
        return view('panel.setting.index',compact('settings'));
    }
    public function create()
    {
        return view('panel.setting.create');
    }
    public function store(Request $request)
    {
        $request->validate([
            'site_title' => ['required', 'max:255'],
            'logo' => ['nullable', 'image', 'mimes:png,jpg.webp,jpeg'],
            'contact_us' => ['nullable'],
            'about_us' => ['nullable']
        ]);

        preg_match_all('/<img src="data:image\/([^;]+);base64,([^"]+)"/', $request->contact_us, $matches);
        $imageFormats = $matches[1];
        $images = $matches[2];

        foreach ($images as $index => $base64) {
            $randomChar = md5(time() . mt_rand(99, 999999));
            $image = Image::read(base64_decode($base64));
            $extension = $imageFormats[$index];
            Storage::disk('public')->makeDirectory('/images/');

            $image->save(public_path() . "/storage/images/" . $randomChar . ".webp")->toWebp(10);
            $path = "images/" . $randomChar . ".webp";
            $url = Storage::url($path);

            $request->contact_us = str_replace('data:image/' . $extension . ';base64,' . $base64, $url, $request->contact_us);

        }

        preg_match_all('/<img src="data:image\/([^;]+);base64,([^"]+)"/', $request->about_us, $matches);
        $imageFormats = $matches[1];
        $images = $matches[2];

        foreach ($images as $index => $base64) {
            $randomChar = md5(time() . mt_rand(99, 999999));
            $image = Image::read(base64_decode($base64));
            $extension = $imageFormats[$index];
            Storage::disk('public')->makeDirectory('/images/');

            $image->save(public_path() . "/storage/images/" . $randomChar . ".webp")->toWebp(10);
            $path = "images/" . $randomChar . ".webp";
            $url = Storage::url($path);

            $request->about_us = str_replace('data:image/' . $extension . ';base64,' . $base64, $url, $request->about_us);

        }

        $questions = [];

            $setting = Setting::create([
                'site_title' => $request->site_title,
                'logo' => '/',
                'contact_us' => $request->contact_us,
                'about_us' => $request->about_us,
                  'enamad' => $request->enamad
            ]);

            if ($request->file('logo')) {
                $this->saveImages($request, $setting->id);
            }

            foreach ($request->question_title as $key => $question) {
                $questions[$question] = $request->question_answer[$key];
            }

            $setting->update([
                'questions' => json_encode($questions)
            ]);

        return redirect()->route('panel.setting.index')->with([
            'success' => 'با موفقیت ایجاد شد'
        ]);
    }
    public function edit()
    {
        $setting = Setting::first();

        return view('panel.setting.edit', compact('setting'));
    }
    public function update(Request $request, $id)
    {
        $request->validate([
            'site_title' => ['required', 'max:255'],
            'logo' => ['nullable', 'image', 'mimes:png,jpg.webp,jpeg'],
            'contact_us' => ['nullable'],
            'about_us' => ['nullable']
        ]);

        preg_match_all('/<img src="data:image\/([^;]+);base64,([^"]+)"/', $request->contact_us, $matches);
        $imageFormats = $matches[1];
        $images = $matches[2];

        foreach ($images as $index => $base64) {
            $randomChar = md5(time() . mt_rand(99, 999999));
            $image = Image::read(base64_decode($base64));
            $extension = $imageFormats[$index];
            Storage::disk('public')->makeDirectory('/images/');

            $image->save(public_path() . "/storage/images/" . $randomChar . ".webp")->toWebp(10);
            $path = "images/" . $randomChar . ".webp";
            $url = Storage::url($path);

            $request->contact_us = str_replace('data:image/' . $extension . ';base64,' . $base64, $url, $request->contact_us);

        }

        preg_match_all('/<img src="data:image\/([^;]+);base64,([^"]+)"/', $request->about_us, $matches);
        $imageFormats = $matches[1];
        $images = $matches[2];

        foreach ($images as $index => $base64) {
            $randomChar = md5(time() . mt_rand(99, 999999));
            $image = Image::read(base64_decode($base64));
            $extension = $imageFormats[$index];
            Storage::disk('public')->makeDirectory('/images/');

            $image->save(public_path() . "/storage/images/" . $randomChar . ".webp")->toWebp(10);
            $path = "images/" . $randomChar . ".webp";
            $url = Storage::url($path);

            $request->about_us = str_replace('data:image/' . $extension . ';base64,' . $base64, $url, $request->about_us);

        }


        $questions = [];

        $setting = Setting::findOrFail($id);

        if (!is_null($setting)) {
            $setting->update([
                'site_title' => $request->site_title,
                'contact_us' => $request->contact_us,
                'about_us' => $request->about_us,
                  'enamad' => $request->enamad
            ]);

            if ($request->file('logo')) {
                $this->saveImages($request, $id);
            }

            foreach ($request->question_title as $key => $question) {
                $questions[$question] = $request->question_answer[$key];
            }

            Setting::findOrFail($id)->update([
                'questions' => json_encode($questions)
            ]);

        } else {

            $setting = Setting::create([
                'site_title' => $request->site_title,
                'logo' => '/',
                'contact_us' => $request->contact_us,
                'about_us' => $request->about_us,
                  'enamad' => $request->enamad
            ]);

            if ($request->file('logo')) {
                $this->saveImages($request, $id);
            }

            foreach ($request->question_title as $key => $question) {
                $questions[$question] = $request->question_answer[$key];
            }

            $setting->update([
                'questions' => json_encode($questions)
            ]);

        }

        return redirect()->route('panel.setting.index')->with([
            'success' => 'با موفقیت ویرایش شد'
        ]);
    }

    private function saveImages(Request $request, $id)
    {
        $path = [];

        Storage::disk('public')->deleteDirectory("/setting/logo/" . $id);

        Storage::disk('public')->makeDirectory('/setting/logo/');
        $path[] = "/storage/" . Storage::disk('public')->put("/setting/logo/" . $id, $request->logo);


        Setting::findOrFail($id)->update([
            'logo' => json_encode($path)
        ]);
    }
}
