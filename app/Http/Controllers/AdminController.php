<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{

    public function index()
    {
        $admins = User::where('is_admin', true)->get();
        return view('panel.users.admin.index', compact('admins'));
    }
    public function create()
    {
        return view('panel.users.admin.create');
    }
    public function store(Request $request)
    {
        $request->validate([
            'first_name' => ['required', 'max:255'],
            'last_name' => ['required', 'max:255'],
            'email' => ['required', 'email', 'unique:users,email'],
            'phone' => ['required', 'unique:users,phone'],
            'address' => ['sometimes'],
            'password' => ['required','min:8'],
        ]);

        User::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'phone' => $request->phone,
            'is_admin' => true,
            'password' => Hash::make($request->password),
            'address' => $request->address,
        ]);


        return redirect()->route('panel.admin.index')->with([
            'success' => 'با موفقیت ساخته شد'
        ]);

    }
    public function edit($id)
    {
        $admin = User::findOrFail($id);
        return view('panel.users.admin.edit', compact('admin'));
    }
    public function update(Request $request, $id)
    {
        $request->validate([
            'first_name' => ['required', 'max:255'],
            'last_name' => ['required', 'max:255'],
            'email' => ['required', 'email', 'unique:users,email,' . $id],
            'phone' => ['required', 'unique:users,phone,' . $id],
            'address' => ['sometimes'],
            'password' => ['required','min:8'],
        ]);

        User::findOrFail($id)->update([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
            'address' => $request->address,
        ]);

        return redirect()->route('panel.admin.index')->with([
            'success' => 'با موفقیت ویرایش شد'
        ]);
    }
    public function show()
    {

    }
    public function delete(Request $request)
    {
        User::findOrFail($request->id)->delete();

        return redirect()->route('panel.admin.index')->with([
            'success' => 'با موفقیت حذف شد'
        ]);
    }
}
