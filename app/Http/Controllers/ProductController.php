<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\CourseCategory;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Laravel\Facades\Image;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::all();
        return view('panel.shop.product.index', compact('products'));
    }
    public function create()
    {
        $categories = CourseCategory::all();
        return view('panel.shop.product.create',compact('categories'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'title' => ['required', 'max:512'],
            'category_id' => ['required','exists:course_categories,id'],
            'price' => ['nullable'],
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

        $product = Product::create([
            'title' => $request->title,
            'category_id' => $request->category_id,
            'price' => $request->price,
            'slug' => json_encode($request->slug),
            'status' => $request->status == 'true' ? true : false,
            'thumbnail' => '/',
            'description' => $request->description,
            'short_description' => $request->short_description,
        ]);

        if ($request->file('thumbnail')) {
            $this->saveImages($request, $product->id);
        }

        return redirect()->route('panel.shop.product.index')->with([
            'success' => 'با موفقیت ساخته شد'
        ]);
    }
    public function edit($id)
    {
        $product = Product::findOrFail($id);
        $categories = CourseCategory::all();
        return view('panel.shop.product.edit', compact('product','categories'));
    }
    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => ['required', 'max:512'],
            'category_id' => ['required','exists:course_categories,id'],
            'price' => ['nullable'],
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

        Product::findOrFail($id)->update([
            'title' => $request->title,
            'category_id' => $request->category_id,
            'price' => $request->price,
            'slug' => json_encode($request->slug),
            'status' => $request->status == 'true' ? true : false,
            'description' => $request->description,
            'short_description' => $request->short_description,
        ]);

        if ($request->hasFile('thumbnail')) {
            $this->saveImages($request, $id);
        }

        return redirect()->route('panel.shop.product.index')->with([
            'success' => 'با موفقیت ویرایش شد'
        ]);

    }
    public function delete(Request $request)
    {
        $request->validate([
            'id' => ['required', 'numeric','exists:products,id']
        ]);

        Storage::disk('public')->deleteDirectory("/product/thumbnail/image/" . $request->id);

        Product::findOrFail($request->id)->delete();

        return redirect()->route('panel.shop.product.index')->with([
            'success' => 'با موفقیت حذف شد'
        ]);
    }

    private function saveImages(Request $request, $id)
    {

        $path = [];

        // foreach ($request->file('image') as $key => $image) {

        Storage::disk('public')->deleteDirectory("/product/thumbnail/image/" . $id);

        Storage::disk('public')->makeDirectory('/product/thumbnail/image/');
        $path[] = "/storage/" . Storage::disk('public')->put("/product/thumbnail/image/" . $id, $request->thumbnail);

        // }

        Product::findOrFail($id)->update([
            'thumbnail' => json_encode($path)
        ]);
    }
}
