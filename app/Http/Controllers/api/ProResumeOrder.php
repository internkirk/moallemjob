<?php

namespace App\Http\Controllers\api;

use Exception;
use Illuminate\Support\Str;
use App\Models\OrderProfile;
use App\Models\SettingPrice;
use Illuminate\Http\Request;
use App\Models\ProResumeUser;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;

class ProResumeOrder extends Controller
{
    public function pay()
    {


        try {

            $code = $this->generateCode();

            $setting = SettingPrice::where('title', 'رزومه حرفه ای')->first();

            if ($setting === NULL) {
                return response()->json([
                    'لطفا قیمت پرداختی را در پنل تعیین کنید'
                ]);
            }

            $order = OrderProfile::create([
                'user_id' => auth()->user()->id,
                'code' => $code,
                'price' => $setting->price,
                'subject' => $setting->title,
                'status' => false
            ]);


            $body = [
                'merchant' => env("MERCHANT_ZIBAL", "zibal"),
                'amount' => $order->price,
                'callbackUrl' => route('order.profile.verify'),
                'orderId' => $order->id,
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
                OrderProfile::findOrFail($result['orderId'])->update([
                    'status' => true
                ]);

                $order = OrderProfile::findOrFail($result['orderId']);

                ProResumeUser::updateOrCreate(['user_id' => $order->user_id],[
                    'user_id' => $order->user_id,
                ]);

                return response()->json([
                   'message' => 'success'
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
        $result = OrderProfile::where('code', $code)->first();

        if (!is_null($result)) {
            return true;
        }
        return false;
    }
}
