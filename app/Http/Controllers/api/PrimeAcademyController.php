<?php

namespace App\Http\Controllers\api;

use Exception;
use App\Models\PrimeAcademy;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\PrimeAcademyResource;

class PrimeAcademyController extends Controller
{
    public function index()
    {

        try {


            $academies = PrimeAcademy::paginate(15);

            return PrimeAcademyResource::collection($academies);

        } catch (Exception $e) {

            return response()->json([
                'error' => $e->getMessage()
            ], 400);

        }

    }
}
