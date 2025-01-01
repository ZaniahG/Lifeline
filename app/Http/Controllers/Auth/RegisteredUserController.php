<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\IdolImage;
use App\Models\User;
use App\Models\Plan;
use App\Models\Utility;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     *
     * @return \Illuminate\View\View
     */

    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Handle an incoming registration request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $data["code"] = 403;
        $token = Str::random(40);

        $validator = Validator::make($request->all(), [
            'name' => ['required', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        if ($validator->fails()) {
            foreach (json_decode($validator->errors()) as $val) {
                if (is_array($val) && count($val) >= 1) {
                    $data["msg"] = $val[0];
                } else {
                    $data["msg"] = $val;
                }
                return response()->json($data);
            }
        }
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'remember_token' => $token,

        ]);

        IdolImage::create([
            'user_id' => $user->id,
            'idol_name' => "Idol's name here",
        ]);

        $data["code"] = 200;
        $data["redirect"] = route('login');
        $data["msg"] = "Your account has been successfully created. Please log in to continue";
        return response()->json($data);
    }

    public function showRegistrationForm($lang = '')
    {
        return view('auth.register');
    }
}
