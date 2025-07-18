<?php

namespace App\Http\Controllers\api;

use App\Models\UserPlan;
use Exception;
use App\Models\Plan;
use App\Models\Order;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Redirect;

class OrderController extends Controller
{
    public function pay(Request $request)
    {
        $request->validate([
            'plan_id' => ['required', 'exists:plans,id', 'numeric']
        ]);

        try {
            $plan = Plan::findOrFail($request->plan_id);

            $code = $this->generateCode();


            $order = Order::create([
                'user_id' => auth()->user()->id,
                'plan_id' => $plan->id,
                'price' => $plan->price,
                'code' => $code,
                'status' => false
            ]);


            $body = [
                'merchant' => env("MERCHANT_ZIBAL", "zibal"),
                'amount' => $order->price,
                'callbackUrl' => route('order.verify'),
                'orderId' => $order->id
            ];

            $ch = curl_init();

            $url = "https://gateway.zibal.ir/v1/request";
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($body));
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));

            $result = curl_exec($ch);

            $result = json_decode($result, true);

            curl_close($ch);

            // if ($result['result'] = 100) {
            //     Redirect::to("https://gateway.zibal.ir/start/" . $result['trackId'])->send();
            // }
            
             return response()->json([
                'url' => "https://gateway.zibal.ir/start/" . $result['trackId']
            ]);
        } catch (Exception $e) {

            return response()->json([
                'error' => $e->getMessage()
            ]);

        }

    }


    public function verify(Request $request)
    {
        try {

            $body = [
                'merchant' => env("MERCHANT_ZIBAL", "zibal"),
                'trackId' => $request->trackId
            ];

            $ch = curl_init();

            $url = "https://gateway.zibal.ir/v1/verify";
            // curl_setopt($ch, CURLOPT_USERAGENT, 'ZarinPal Rest Api v1');
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($body));
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));

            $result = curl_exec($ch);

            curl_close($ch);

            $result = json_decode($result, true);

            if ($result['result'] == 100 && $result['message'] == 'success') {
                Order::findOrFail($result['orderId'])->update([
                    'status' => true
                ]);

                $order = Order::findOrFail($result['orderId']);

                UserPlan::updateOrCreate([
                    'user_id' => $order->user_id,
                    'plan_id' => $order->plan_id
                ], [
                    'user_id' => $order->user_id,
                    'plan_id' => $order->plan_id
                ]);

                return response()->json([
                  'message' =>  'success'
                ]);

            }
        } catch (Exception $e) {

            return response()->json([
                'error' => $e->getMessage()
            ]);
        }

    }


    private function generateCode()
    {
        $number = bin2hex(Str::random(25));

        $result = $this->checkCodeIsExist($number);

        if ($result) {
            $this->generateCode();
        }

        return $number;
    }
    private function checkCodeIsExist($code)
    {
        $result = Order::where('code', $code)->first();

        if (!is_null($result)) {
            return true;
        }
        return false;
    }
}
