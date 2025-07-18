<?php

namespace App\Http\Controllers\api;

use App\Models\Blog;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BlogController extends Controller
{
    public function index()
    {
        try {
            $blogs = Blog::all();

            return response()->json([
                'data' => $blogs
            ]);

        } catch (\Exception $e) {

            return response()->json([
                'error' => $e->getMessage()
            ], 400);

        }
    }


    public function show($id)
    {
        try {
            $blog = Blog::findOrFail($id);

            return response()->json([
                'data' => $blog
            ]);

        } catch (\Exception $e) {

            return response()->json([
                'error' => $e->getMessage()
            ], 400);

        }
    }
}
