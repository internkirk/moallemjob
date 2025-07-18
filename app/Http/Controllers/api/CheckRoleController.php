<?php

namespace App\Http\Controllers\api;

use Exception;
use Illuminate\Http\Request;
use App\Http\Services\Jwt\Jwt;
use App\Http\Controllers\Controller;

class CheckRoleController extends Controller
{
    public function verify(Request $request)
    {

        try {
            
            $request->validate([
                'token' => ['required']
            ]);


            $result = Jwt::payload($request->token)->check();

            if (!$result) {
                return response()->json([
                    'message' => 'توکن دستکاری شده است'
                ]);
            }


            $data = Jwt::getPayload($request->token)->first();

            return response()->json([
                'role' => $data['role']
            ]);



        } catch (Exception $e) {
            
            return response()->json([
                'error' => $e->getMessage()
            ],400);

        }


    }
}
