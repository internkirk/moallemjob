<?php

namespace App\Http\Controllers\api;

use App\Http\Resources\CourseResource;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use Exception;
use App\Models\Course;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProductController extends Controller
{
    public function index()
    {
        try {

            $products = Product::where('status', true)->get();
            return ProductResource::collection($products);

        } catch (Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], 400);
        }
    }

    public function show($id)
    {
        try {

            $product = Product::where('id', $id)->get();
            return ProductResource::collection($product);

        } catch (Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], 400);
        }
    }
}
