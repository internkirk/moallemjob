<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Connector;
use Exception;
use Illuminate\Http\Request;

class ConnectorController extends Controller
{
    public function get()
    {
        try {

            $user = auth()->user();
           $result = Connector::where('user_id', $user->id)->first();

            return response()->json([
                'data' => $result
            ]);

        } catch (Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], 400);
        }
    }

    public function store(Request $request)
    {
        try {

             Connector::updateOrCreate(['user_id' => auth()->user()->id],[
                'user_id' => auth()->user()->id,
                'name' => $request->name,
                'phone' => $request->phone,
                'school_role' => $request->school_role,
            ]);

            return response()->json([
                'message' => 'data saved successfully'
            ]);

        } catch (Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], 400);
        }
    }
}
