<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Requests\UserLogin;
use App\Http\Requests\UserRegister;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\RedirectResponse;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Validation\ValidationException;

class AuthenticationController extends Controller
{
    public function __construct()
    {
    }


    public function loginForm()
    {
        return view('panel.authentication.login');
    }


    public function registerForm()
    {
        // if (Auth::user()->check()) {
        //     return redirect()->route('user.profile');
        // }
        abort(403);
        return view('panel.authentication.register');
    }

    public function register(Request $request)
    {
        abort(403);
        $request->validate([
            'first_name' => ['required', 'max:255', 'string'],
            'last_name' => ['required', 'max:255', 'string'],
            'phone' => ['required', 'max:255'],
            'email' => ['required', 'email'],
            'password' => ['required', Password::min(8)->mixedCase()->uncompromised(), 'confirmed'],
        ]);


        $user = User::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'phone' => $request->phone,
            'is_admin' => true,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // Storage::disk('public')->makeDirectory("/images/uploads/user/" . $user->id . "/avatar/");
        // $image = Image::read($request->file('avatar'));
        // $image->save(public_path() . "/storage/images/uploads/user/" . $user->id . "/avatar/" . $request->file('avatar')->getClientOriginalName() . ".webp")->toWebp(10);

        // $avatar = "/storage/images/uploads/user/" . $user->id . "/avatar/" . $request->file('avatar')->getClientOriginalName() . ".webp";


        // $user->update([
        //     'avatar' => $avatar
        // ]);

        Auth::login($user);

        return redirect()->route('panel.index');
    }


    public function login(Request $request)
    {

        $request->validate(
            [
                'email' => ['required', 'email', 'exists:users,email'],
                'password' => ['required', 'min:8'],
            ]
        );

        $this->ensureIsNotRateLimited($request);

        $result = Auth::validate($request->only('email', 'password'));


        if ($result) {

            RateLimiter::clear($this->throttleKey($request));

            return $this->successfullLogin($request);
        }

        RateLimiter::hit($this->throttleKey($request));

        return $this->failedLogin();
    }

    protected function getUser($request)
    {
        return User::where('email', $request->email)->firstOrFail();
    }


    protected function failedLogin()
    {
        return back()->with('wrong credentials', true);
    }

    protected function successfullLogin(Request $request)
    {
        $request->session()->regenerate();


        Auth::login($this->getUser($request));

        //    dd( auth()->guard('api')->login($this->getUser($request)));

        // if (!$this->getUser($request)->isAdmin()) {
        //     return redirect()->route('user.panel.index');
        // }

        return redirect()->route('panel.index');

    }

    protected function ensureIsNotRateLimited(Request $request): void
    {
        if (!RateLimiter::tooManyAttempts($this->throttleKey($request), 6)) {
            return;
        }

        $seconds = RateLimiter::availableIn($this->throttleKey($request));

        throw ValidationException::withMessages([
            'email' => trans('auth.throttle', [
                'seconds' => $seconds,
                'minutes' => ceil($seconds / 60),
            ]),
        ]);
    }

    protected function throttleKey(Request $request): string
    {
        return Str::transliterate(Str::lower($request->email) . '|' . $request->ip());
    }



    /**
     * Destroy an authenticated session.
     */
    public function logout(): RedirectResponse
    {
        session()->invalidate();

        Auth::logout();

        session()->regenerateToken();

        return redirect(route('login.form'));
    }
}
