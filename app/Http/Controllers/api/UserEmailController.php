<?php
namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;

class UserEmailController extends Controller
{
    public function update(Request $request)
    {
        try {

            if (auth()->user()->teacher != null) {
                $this->getStrategy('teacher', $request);
            }
            if (auth()->user()->academy != null) {
                $this->getStrategy('academy', $request);
            }

            return response()->json([
                'message' => 'updated',
            ]);

        } catch (Exception $e) {
            return response()->json([
                'error' => $e->getMessage(),
            ]);
        }
    }

    private function getStrategy($role, $request)
    {
        if ($role == 'academy') {
            $this->academyEmailUpdate($request);
        }
        if ($role == 'teacher') {
            $this->teacherEmailUpdate($request);
        }
    }

    private function academyEmailUpdate(Request $request)
    {
        auth()->user()->update([
            'email' => $request->email,
        ]);

        auth()->user()->academy()->update([
            'email' => $request->email,
        ]);
    }
    private function teacherEmailUpdate(Request $request)
    {
        auth()->user()->update([
            'email' => $request->email,
        ]);

        auth()->user()->teacher()->update([
            'email' => $request->email,
        ]);
    }
}
