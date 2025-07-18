<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;

class UserController extends Controller
{
    public function index()
    {
        $users = User::where('is_admin',false)->get();
        return view('panel.users.index', compact('users'));
    }
    public function create()
    {
    }
    public function store()
    {
    }
    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('panel.users.edit', compact('user'));
    }
    public function update(Request $request, $id)
    {
        $request->validate([
            'first_name' => ['required', 'max:255', 'string'],
            'last_name' => ['required', 'max:255', 'string'],
            'phone' => ['required', 'max:255'],
            'email' => ['required', 'email'],
            // 'password' => ['required', Password::min(8)->mixedCase()->uncompromised(), 'confirmed'],
        ]);


        User::findOrFail($id)->update([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'phone' => $request->phone,
            'is_admin' => true,
            'email' => $request->email,
            // 'password' => Hash::make($request->password),
        ]);

        return redirect()->route('panel.users.index')->with([
            'success' => 'با موفقیت ویرایش شد'
        ]);
    }
    public function delete(Request $request)
    {
        User::findOrFail($request->id)->delete();

        return redirect()->route('panel.users.index')->with([
            'success' => 'با موفقیت حذف شد'
        ]);
    }
}
