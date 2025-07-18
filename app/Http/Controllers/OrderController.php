<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Plan;
use App\Models\Order;
use App\Models\UserPlan;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::all();
        return view('panel.order.index', compact('orders'));
    }
    public function show($id)
    {
        $order = Order::findOrFail($id);
        return view('panel.order.show', compact('order'));
    }


    public function store(Request $request)
    {
    }

    

}
