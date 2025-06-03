<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\LoginRequest;

class LoginRegisterController extends Controller
{
    /**
     * Display a registration form.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function register()
    {
        return view('register');
    }

    /**
     * Store a new user.
     *
     * @param  RegisterRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(RegisterRequest $request)
    {
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);

        $credentials = $request->only('email', 'password');
        Auth::attempt($credentials);
        $request->session()->regenerate();
        return redirect()->route('dashboard')
        ->withSuccess(trans('messages.user_register'));
    }

    /**
     * Display a login form.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function login()
    {
        return view('login');
    }

    /**
     * Authenticate the user.
     *
     * @param  LoginRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function authenticate(LoginRequest $request)
    {
        $credentials['email'] = $request->get('email');
        $credentials['password'] = $request->get('password');
        if(Auth::attempt($credentials))
        {
            $request->session()->regenerate();
            return redirect()->route('dashboard')
                ->withSuccess(trans('messages.user_login_success'));
        }

        return back()->withErrors([
            'email' => trans('messages.cred_not_mached'),
        ])->onlyInput('email');

    } 
}
