<?php

namespace App\Http\Controllers\api;

use App\Models\Setting;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SettingController extends Controller
{
    public function site_title()
    {
        try {
            $setting = Setting::latest()->orderBy('created_at','desc')->get();

            return response()->json([
                'data' => $setting->first()->site_title
            ]);

        } catch (\Exception $e) {

            return response()->json([
                'error' => $e->getMessage()
            ], 400);

        }
    }

    public function logo()
    {
        try {
            $setting = Setting::latest()->orderBy('created_at','desc')->get();

            return response()->json([
                'data' => $setting->first()->logo
            ]);

        } catch (\Exception $e) {

            return response()->json([
                'error' => $e->getMessage()
            ], 400);

        }
    }

    public function aboutUs()
    {
        try {
            $setting = Setting::latest()->orderBy('created_at','desc')->get();

            return response()->json([
                'data' => $setting->first()->about_us
            ]);

        } catch (\Exception $e) {

            return response()->json([
                'error' => $e->getMessage()
            ], 400);

        }
    }

    public function contactUs()
    {
        try {
            $setting = Setting::latest()->orderBy('created_at','desc')->get();

            return response()->json([
                'data' => $setting->first()->contact_us
            ]);

        } catch (\Exception $e) {

            return response()->json([
                'error' => $e->getMessage()
            ], 400);

        }
    }

    public function questions()
    {
        try {
            $setting = Setting::latest()->orderBy('created_at','desc')->get();

            return response()->json([
                'data' => $setting->first()->questions
            ]);

        } catch (\Exception $e) {

            return response()->json([
                'error' => $e->getMessage()
            ], 400);

        }
    }
    
    public function enamad()
    {
        try {
            $setting = Setting::latest()->orderBy('created_at','desc')->get();

            return response()->json([
                'data' => $setting->first()->enamad
            ]);

        } catch (\Exception $e) {

            return response()->json([
                'error' => $e->getMessage()
            ], 400);

        }
    }
}
