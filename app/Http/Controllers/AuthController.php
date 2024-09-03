<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function showDashboard()
    {
        return view('pages.dashboard');
    }
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        // Validate the form data
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        if (Auth::attempt(['email' => $request->input('email'),'password' => $request->input('password')],$request->has('remember'))) {
            return redirect()->route('admin.dashboard')->with('success', 'Logged in successfully!');
        }
        return redirect()->back()->with('error', 'Invalid email or password.');
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }
}
