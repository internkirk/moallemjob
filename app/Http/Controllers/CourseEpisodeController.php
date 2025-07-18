<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;
use App\Models\CourseEpisode;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Laravel\Facades\Image;

class CourseEpisodeController extends Controller
{
    public function index($id)
    {
        $episodes = CourseEpisode::where('course_id',$id)->get();
        $course = Course::findOrFail($id);
        return view('panel.shop.course.episode.index',compact('episodes','course'));
    }
    public function create($course_id)
    {
        return view('panel.shop.course.episode.create',compact('course_id'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'title' => ['required', 'max:512'],
            'duration' => ['nullable'],
            'thumbnail' => ['required', 'image', 'mimes:png,jpg,jpeg,webp,gif,avi'],
            'description' => ['required'],
            'short_description' => ['required']
        ]);


        preg_match_all('/<img src="data:image\/([^;]+);base64,([^"]+)"/', $request->description, $matches);
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

            $request->description = str_replace('data:image/' . $extension . ';base64,' . $base64, $url, $request->description);

        }

        preg_match_all('/<img src="data:image\/([^;]+);base64,([^"]+)"/', $request->short_description, $matches);
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

            $request->description = str_replace('data:image/' . $extension . ';base64,' . $base64, $url, $request->description);

        }

        $episode = CourseEpisode::create([
            'course_id' => $request->course_id,
            'title' => $request->title,
            'duration' => $request->duration,
            'status' => $request->status == 'true' ? true : false,
            'thumbnail' => '/',
            'description' => $request->description,
            'short_description' => $request->short_description,
        ]);

        if ($request->file('thumbnail')) {
            $this->saveImages($request, $episode->id);
        }

        return redirect()->route('panel.shop.course.episode.index',$request->course_id)->with([
            'success' => 'با موفقیت ساخته شد'
        ]);
    }
    public function edit($id)
    {
        $episode = CourseEpisode::findOrFail($id); 
        return view('panel.shop.course.episode.edit',compact('episode'));
    }
    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => ['required', 'max:512'],
            'duration' => ['nullable'],
            'description' => ['required'],
            'short_description' => ['required']
        ]);


        preg_match_all('/<img src="data:image\/([^;]+);base64,([^"]+)"/', $request->description, $matches);
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

            $request->description = str_replace('data:image/' . $extension . ';base64,' . $base64, $url, $request->description);

        }

        preg_match_all('/<img src="data:image\/([^;]+);base64,([^"]+)"/', $request->short_description, $matches);
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

            $request->description = str_replace('data:image/' . $extension . ';base64,' . $base64, $url, $request->description);

        }

         CourseEpisode::findOrFail($id)->update([
            'course_id' => $request->course_id,
            'title' => $request->title,
            'duration' => $request->duration,
            'status' => $request->status == 'true' ? true : false,
            'description' => $request->description,
            'short_description' => $request->short_description,
        ]);

        if ($request->file('thumbnail')) {
            $this->saveImages($request, $id);
        }

        return redirect()->route('panel.shop.course.episode.index',$request->course_id)->with([
            'success' => 'با موفقیت ویرایش شد'
        ]);
    }
    public function delete(Request $request, $course_id)
    {
        $request->validate([
            'id' => ['required', 'numeric','exists:course_episodes,id']
        ]);

        Storage::disk('public')->deleteDirectory("/course/episode/$request->id");
        Storage::disk('private')->deleteDirectory("/videos/$request->id");

        CourseEpisode::findOrFail($request->id)->delete();

        return redirect()->route('panel.shop.course.episode.index',$course_id)->with([
            'success' => 'با موفقیت حذف شد'
        ]);
    }

    private function saveImages(Request $request, $id)
    {

        $path = [];

        // foreach ($request->file('image') as $key => $image) {

        Storage::disk('public')->deleteDirectory("/course/episode/$id/thumbnail/image/");

        Storage::disk('public')->makeDirectory("/course/episode/$id/thumbnail/image/");
        $path[] = "/storage/" . Storage::disk('public')->put("/course/episode/$id/thumbnail/image/", $request->thumbnail);

        // }

        CourseEpisode::findOrFail($id)->update([
            'thumbnail' => json_encode($path)
        ]);
    }
}
