<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Laravel\Facades\Image;
class BlogController extends Controller
{
    public function index()
    {
        $blogs = Blog::all();
        return view('panel.blog.index', compact('blogs'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'title' => ['required', 'max:255'],
            'thumbnail' => ['required', 'image', 'mimes:png,jpg,jpeg,webp'],
            'description' => ['sometimes'],
            'short_description' => ['sometimes'],
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

        $blog = Blog::create([
            'title' => $request->title,
            'thumbnail' => '/',
            'description' => $request->description,
            'short_description' => $request->short_description,
        ]);

        if ($request->file('thumbnail')) {
            $this->saveImages($request, $blog->id);
        }

        return redirect()->route('panel.blog.index')->with([
            'success' => 'با موفقیت ایجاد شد'
        ]);
    }
    public function create()
    {
        return view('panel.blog.create');
    }
    public function edit($id)
    {
        $blog = Blog::findOrFail($id);
        return view('panel.blog.edit', compact('blog'));
    }
    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => ['required', 'max:255'],
            'thumbnail' => ['sometimes', 'image', 'mimes:png,jpg,jpeg,webp'],
            'description' => ['sometimes'],
            'short_description' => ['sometimes'],
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

        Blog::findOrFail($id)->update([
            'title' => $request->title,
            'description' => $request->description,
            'short_description' => $request->short_description,
        ]);

        if ($request->file('thumbnail')) {
            $this->saveImages($request, $id);
        }

        return redirect()->route('panel.blog.index')->with([
            'success' => 'با موفقیت ویرایش شد'
        ]);

    }
    public function delete(Request $request)
    {
        Blog::findOrFail($request->id)->delete();

        Storage::disk('public')->deleteDirectory("/blog/images/" . $request->id);

        return redirect()->route('panel.blog.index')->with([
            'success' => 'با موفقیت حذف شد'
        ]);
    }
    private function saveImages(Request $request, $id)
    {

        $path = [];

        // foreach ($request->file('image') as $key => $image) {

        Storage::disk('public')->deleteDirectory("/blog/images/" . $id);

        Storage::disk('public')->makeDirectory('/blog/images/');
        $path[] = "/storage/" . Storage::disk('public')->put("/blog/images/" . $id, $request->thumbnail);
        // }

        Blog::findOrFail($id)->update([
            'thumbnail' => json_encode($path)
        ]);
    }
}
