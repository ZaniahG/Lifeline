<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\Utility;
use App\Models\User;
use App\Models\Store;
use App\Models\Plan;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('auth.login');
    }

    public function store(LoginRequest $request)
    {

        $data["code"] = 403;
        $validator = Validator::make($request->all(), [
            'email' => 'required',
            'password' => 'required',
        ]);

        if ($validator->fails()) {

            foreach (json_decode($validator->errors()) as $val) {
                $data["msg"] = $val;
                break;
            }
            return response()->json($data);
        }

        // $request->boolean('remember')
        if (!Auth::attempt(array_merge($request->only('email', 'password')), 1)) {
            $data["msg"] = trans('auth.failed');
            return response()->json($data);
        }

        $data["code"] = 200;
        $data["msg"] = "You have signed in successfully";

        $data["redirect"] = route('photocards');
        return response()->json($data);
    }

    public function showLoginForm()
    {
        return view('auth.login');
    }

    /**
     * Destroy an authenticated session.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request)
    {

        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
