<?php

namespace App\Http\Controllers\api;

use Exception;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class UserPasswordController extends Controller
{
    public function store(Request $request)
    {
        try {

            auth()->user()->update([
                'password' => Hash::make($request->password)
            ]);

            return response()->json([
                'message' => 'success'
            ]);

        } catch (Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ]);
        }
    }
}
