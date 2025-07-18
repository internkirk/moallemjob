<?php

namespace App\Http\Controllers;

use App\Models\OrderProfile;
use Illuminate\Http\Request;

class OrderProfileController extends Controller
{
    public function index()
    {
        $orders = OrderProfile::all();
        return view('panel.order.profile.index', compact('orders'));
    }
    public function show($id)
    {
        $order = OrderProfile::findOrFail($id);
        return view('panel.order.profile.show', compact('order'));
    }
}
