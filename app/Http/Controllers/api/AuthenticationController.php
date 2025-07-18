<?php

namespace App\Http\Controllers\api;

use Exception;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Academy;
use App\Models\Teacher;
use App\Models\AuthCode;
use Illuminate\Http\Request;
use App\Http\Services\Jwt\Jwt;
use App\Http\Services\Sms\Sms;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class AuthenticationController extends Controller
{
    public function authenticate(Request $request)
    {
        $request->validate([
            'phone' => ['required', 'exists:users,phone'],
            'password' => ['required', 'min:8'],
        ]);

        if (strlen($request->password) < 8) {
            return response()->json([
                'message' => 'password must be at least 8 characters',
                'status' => 300
            ]);
        }

        $user = User::where('phone', $request->phone)->first();

        if ($user && Hash::check($request->password, $user->password)) {

            if (!is_null($user->tokens()->where('tokenable_id', $user->id)->first())) {
                $user->tokens()->where('tokenable_id', $user->id)->delete();
            }

            DB::table('personal_access_tokens')->where('tokenable_id', $user->id)->delete();

            $token = $user->createToken('API Token', ['*'], Carbon::now()->addWeeks(4))->plainTextToken;

            return response()->json([
                'message' => 'Token created successfully',
                'Access_token' => $token
            ]);
        }

        return response()->json([
            'message' => 'User Not Found',
            'status' => 404
        ]);
    }
    public function register(Request $request)
    {
        try {
            $request->validate([
                'first_name' => ['required', 'max:255'],
                'last_name' => ['required', 'max:255'],
                'email' => ['required', 'email', 'unique:users,email'],
                'password' => ['required', 'min:8'],
                'phone' => ['required', 'unique:users,phone'],
            ]);

            $result = User::where('email', $request->email)->first();

            if (!is_null($result)) {
                return response()->json([
                    'message' => 'email is already exists',
                    'status' => 300
                ]);
            }

            if (strlen($request->password) < 8) {
                return response()->json([
                    'message' => 'password must be at least 8 characters',
                    'status' => 300
                ]);
            }


            $user = User::create([
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'phone' => $request->phone,
            ]);

            DB::table('personal_access_tokens')->where('tokenable_id', $user->id)->delete();

            $token = $user->createToken('API Token', ['*'], Carbon::now()->addWeeks(4))->plainTextToken;

            return response()->json([
                'message' => 'User created successfully',
                'Access_token' => $token
            ]);

        } catch (Exception $e) {
            return response()->json([
                // 'message' => 'User  not created',
                $e->getMessage()
            ]);
        }
    }


    public function loginOrRegisterForTeachers(Request $request)
    {

        try {

            $request->validate([
                'phone' => ['required'],
            ]);

            $user = User::where('phone', $request->phone)->first();


            $res = Academy::where('user_id', $user?->id)->first();
            if ($res !== NULL) {
                return response()->json([
                    'message' => 'شما قبلا به عنوان آموزشگاه ثبت نام کرده اید'
                ]);
            }


            if (!is_null($user)) {

                // DB::table('personal_access_tokens')->where('tokenable_id', $user->id)->delete();

                // $token = $user->createToken('API Token', ['*'], Carbon::now()->addWeeks(4))->plainTextToken;

                // $data = [
                //     'role' => 'معلم'
                // ];

                // $role_token = Jwt::payload($data)->getToken();


                // $code = $this->generateCode();

                // AuthCode::updateOrCreate(['phone' => $request->phone], [
                //     'phone' => $request->phone,
                //     'code' => $code
                // ]);

                //////////////  Send Confirmation Code to User With SMS  //////////////
                // Sms::loginAndRegister()->variables($request->phone,(string)$code)->to($request->phone)->send();

                // Sms::welcome()->to($user->phone)->send();

                return response()->json([
                    'message' => 'you have an account',
                    // 'Access_token' => $token,
                    // 'role_token' => $role_token
                ]);
            } else {

                // $user = User::create([
                //     'phone' => $request->phone,
                // ]);

                // DB::table('personal_access_tokens')->where('tokenable_id', $user->id)->delete();

                // $token = $user->createToken('API Token', ['*'], Carbon::now()->addWeeks(4))->plainTextToken;

                // $data = [
                //     'role' => 'معلم'
                // ];

                // $role_token = Jwt::payload($data)->getToken();

                $code = $this->generateCode();

                AuthCode::updateOrCreate(['phone' => $request->phone], [
                    'phone' => $request->phone,
                    'code' => $code
                ]);

                //////////////  Send Confirmation Code to User With SMS  //////////////
                Sms::loginAndRegister()->variables($request->phone, (string) $code)->to($request->phone)->send();

                return response()->json([
                    'message' => 'you do not have an account',
                    // 'Access_token' => $token,
                    // 'role_token' => $role_token
                ]);
            }


        } catch (Exception $e) {
            return response()->json([
                $e->getMessage()
            ], 400);
        }

    }

    public function loginOrRegisterForAcademy(Request $request)
    {

        try {

            $request->validate([
                'phone' => ['required'],
            ]);

            $user = User::where('phone', $request->phone)->first();

            $res = Teacher::where('user_id', $user?->id)->first();
            if ($res !== NULL) {
                return response()->json([
                    'message' => 'شما قبلا به عنوان معلم ثبت نام کرده اید'
                ]);
            }


            if (!is_null($user)) {

                // DB::table('personal_access_tokens')->where('tokenable_id', $user->id)->delete();

                // $token = $user->createToken('API Token', ['*'], Carbon::now()->addWeeks(4))->plainTextToken;


                // $data = [
                //     'role' => 'آموزشگاه'
                // ];

                // $role_token = Jwt::payload($data)->getToken();

                // Sms::welcome()->to($user->phone)->send();

                return response()->json([
                    'message' => 'you have an account',
                    // 'Access_token' => $token,
                    // 'role_token' => $role_token
                ]);
            } else {
                // $user = User::create([
                //     'phone' => $request->phone,
                // ]);

                // DB::table('personal_access_tokens')->where('tokenable_id', $user->id)->delete();

                // $token = $user->createToken('API Token', ['*'], Carbon::now()->addWeeks(4))->plainTextToken;

                // $data = [
                //     'role' => 'آموزشگاه'
                // ];

                // $role_token = Jwt::payload($data)->getToken();

                $code = $this->generateCode();

                AuthCode::updateOrCreate(['phone' => $request->phone], [
                    'phone' => $request->phone,
                    'code' => $code
                ]);

                // //////////////  Send Confirmation Code to User With SMS  //////////////
                Sms::loginAndRegister()->variables($request->phone, (string) $code)->to($request->phone)->send();

                return response()->json([
                    'message' => 'you do not have an account',
                    // 'Access_token' => $token,
                    // 'role_token' => $role_token
                ]);
            }


        } catch (Exception $e) {
            return response()->json([
                $e->getMessage()
            ], 400);
        }

    }



    public function loginTeacher(Request $request)
    {
        try {

            $request->validate([
                'phone' => ['required', 'min:11', 'exists:users,phone'],
                'password' => ['required', 'min:8']
            ], [
                "phone.exists" => "لطفا ابتدا ثبت نام کنید",
                "password.min" => "رمز عبور حداقل باید 8 کاراکتر باشد",
            ]);


            $user = User::where('phone', $request->phone)->first();
            if ($user === NULL) {
                return response()->json([
                    'message' => 'لطفا ابتدا ثبت نام کنید'
                ]);
            }

            $result = Hash::check($request->password, $user->password);
            if (!$result) {
                return response()->json([
                    'message' => 'شماره موبایل یا رمز عبور اشتباه است'
                ]);
            }


            $res = Academy::where('user_id', $user?->id)->first();
            if ($res !== NULL) {
                return response()->json([
                    'message' => 'شما قبلا به عنوان آموزشگاه ثبت نام کرده اید'
                ]);
            }

            DB::table('personal_access_tokens')->where('tokenable_id', $user->id)->delete();

            $token = $user->createToken('API Token', ['*'], Carbon::now()->addWeeks(4))->plainTextToken;

            $data = [
                'role' => 'معلم'
            ];

            $role_token = Jwt::payload($data)->getToken();


            Sms::welcome()->to($user->phone)->send();


            return response()->json([
                'message' => 'Token created successfully',
                'Access_token' => $token,
                'role_token' => $role_token
            ]);


        } catch (Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ]);
        }
    }
    public function registerTeacher(Request $request)
    {
        try {

            $request->validate([
                'phone' => ['required', 'min:11', 'exists:users,phone'],
                'password' => ['required', 'min:8'],
            ]);

            $user = User::create([
                'phone' => $request->phone,
                'password' => Hash::make($request->password)
            ]);

            DB::table('personal_access_tokens')->where('tokenable_id', $user->id)->delete();

            $token = $user->createToken('API Token', ['*'], Carbon::now()->addWeeks(4))->plainTextToken;

            $data = [
                'role' => 'معلم'
            ];

            $role_token = Jwt::payload($data)->getToken();

            Sms::welcome()->to($user->phone)->send();

            return response()->json([
                'message' => 'User created successfully',
                'Access_token' => $token,
                'role_token' => $role_token
            ]);

        } catch (Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
            ]);
        }
    }


    public function loginAcademy(Request $request)
    {
        try {

            $request->validate([
                'phone' => ['required', 'min:11', 'exists:users,phone'],
                'password' => ['required', 'min:8']
            ], [
                "phone.exists" => "لطفا ابتدا ثبت نام کنید",
                "password.min" => "رمز عبور حداقل باید 8 کاراکتر باشد",
            ]);


            $user = User::where('phone', $request->phone)->first();
            if ($user === NULL) {
                return response()->json([
                    'message' => 'لطفا ابتدا ثبت نام کنید'
                ]);
            }

            $result = Hash::check($request->password, $user->password);
            if (!$result) {
                return response()->json([
                    'message' => 'شماره موبایل یا رمز عبور اشتباه است'
                ]);
            }


            $res = Teacher::where('user_id', $user?->id)->first();
            if ($res !== NULL) {
                return response()->json([
                    'message' => 'شما قبلا به عنوان معلم ثبت نام کرده اید'
                ]);
            }

            DB::table('personal_access_tokens')->where('tokenable_id', $user->id)->delete();

            $token = $user->createToken('API Token', ['*'], Carbon::now()->addWeeks(4))->plainTextToken;

            $data = [
                'role' => 'آموزشگاه'
            ];

            $role_token = Jwt::payload($data)->getToken();

            Sms::welcome()->to($user->phone)->send();

            return response()->json([
                'message' => 'Token created successfully',
                'Access_token' => $token,
                'role_token' => $role_token
            ]);


        } catch (Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ]);
        }
    }
    public function registerAcademy(Request $request)
    {
        try {

            $request->validate([
                'phone' => ['required', 'min:11', 'exists:users,phone'],
                'password' => ['required', 'min:8'],
            ]);

            $user = User::create([
                'phone' => $request->phone,
                'password' => Hash::make($request->password)
            ]);

            DB::table('personal_access_tokens')->where('tokenable_id', $user->id)->delete();

            $token = $user->createToken('API Token', ['*'], Carbon::now()->addWeeks(4))->plainTextToken;

            $data = [
                'role' => 'آموزشگاه'
            ];

            $role_token = Jwt::payload($data)->getToken();

            Sms::welcome()->to($user->phone)->send();

            return response()->json([
                'message' => 'User created successfully',
                'Access_token' => $token,
                'role_token' => $role_token
            ]);

        } catch (Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
            ]);
        }
    }


    public function checkCode(Request $request)
    {
        try {

            $request->validate([
                'phone' => ['required', 'min:11', 'unique:users,phone'],
                'code' => ['required', 'min:4', 'max:4'],
            ]);

            $code = AuthCode::where('phone', $request->phone)->where('code', $request->code)->first();

            if ($code === NULL) {
                return response()->json([
                    'message' => 'کد نامعتبر است'
                ]);
            }

            $code->delete();

            return response()->json([
                'message' => 'success'
            ]);

        } catch (Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
            ]);
        }
    }
    // public function sendConfirmationCode(Request $request)
    // {
    //     try {

    //         $request->validate([
    //             'phone' => ['required', 'min:11', 'unique:users,phone']
    //         ]);

    //         $code = $this->generateCode();

    //         AuthCode::updateOrCreate(['phone' => $request->phone], [
    //             'phone' => $request->phone,
    //             'code' => $code
    //         ]);

    //         //////////////  Send Confirmation Code to User With SMS  //////////////

    //         Sms::login()->variables((string) $code)->to($request->phone)->send();

    //         return response()->json([
    //             'message' => 'code sent successfully',
    //             'code' => $code
    //         ]);


    //     } catch (Exception $e) {
    //         return response()->json([
    //             'message' => $e->getMessage()
    //         ]);
    //     }
    // }

    public function makePassword(Request $request)
    {
        try {

            $request->validate([
                'phone' => ['required', 'unique:users,phone'],
                'password' => ['required']
            ]);

            $user = User::create([
                'phone' => $request->phone,
                'password' => Hash::make($request->password)
            ]);

            DB::table('personal_access_tokens')->where('tokenable_id', $user->id)->delete();

            $token = $user->createToken('API Token', ['*'], Carbon::now()->addWeeks(4))->plainTextToken;


            $data = [
                'role' => 'معلم'
            ];

            $role_token = Jwt::payload($data)->getToken();

            return response()->json([
                'message' => 'User created successfully',
                'Access_token' => $token,
                'role_token' => $role_token
            ]);


        } catch (Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ]);
        }
    }

    // public function generateLongExpireDateToken()
    // {
    //     // try {

    //     //     $user = auth()->user();

    //     //     DB::table('personal_access_tokens')->where('tokenable_id', $user->id)->delete();

    //     //     $token = $user->createToken('API Token', ['*'], Carbon::now()->addWeeks(4))->plainTextToken;

    //     //     return response()->json([
    //     //         'message' => 'Token created successfully',
    //     //         'Access_token' => $token
    //     //     ]);

    //     // } catch (Exception $e) {

    //     //     return response()->json([
    //     //         'error' => $e->getMessage()
    //     //     ], 400);

    //     // }
    // }


    private function generateCode()
    {

        $code = rand(1111, 9999);

        $result = AuthCode::where('code', $code)->first();

        if ($result === NULL) {
            return $code;
        }

        return $this->generateCode();

    }
}
