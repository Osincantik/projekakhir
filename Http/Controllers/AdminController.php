<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function register()
    {
        $data['title'] = 'Register';
        return view('register.index', $data);
    }

    public function register_action(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'username' => 'required|unique:tb_admin',
            'password' => 'required',
            'password_confirm' => 'required|same:password',
        ]);

        $user = new Admin([
            'name' => $request->name,
            'username' => $request->username,
            'password' => Hash::make($request->password),
        ]);
        $user->save();

        return redirect()->route('login')->with('success', 'Registration success. Please login!');
    }


    public function login()
    {
        $data['title'] = 'Login';
        return view('login.index', $data);
    }

    public function login_action(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);
        if (Auth::attempt(['username' => $request->username, 'password' => $request->password])) {
            $request->session()->regenerate();
            return redirect()->intended('/pertanians');
        }

        return back()->withErrors([
            'password' => 'Wrong username or password',
        ]);
    }

    // public function password()
    // {
    //     $data['title'] = 'Change Password';
    //     return view('admin/password', $data);
    // }

    // public function password_action(Request $request)
    // {
    //     $request->validate([
    //         'old_password' => 'required|current_password',
    //         'new_password' => 'required|confirmed',
    //     ]);
    //     $admin = Admin::find(Auth::id());
    //     $admin->password = Hash::make($request->new_password);
    //     $admin->save();
    //     $request->session()->regenerate();
    //     return back()->with('success', 'Password changed!');
    // }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}