<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Hash;

class HomeController extends Controller
{

    public function users()
    {
        if(!Session::get('login_id'))
        return redirect('/login');

        $users = User::all();
        return view('users', compact('users'));
    }

    public function profile()
    {
        if(!Session::get('login_id'))
        return redirect('/login');

        $user = User::whereId(Session::get('login_id'))->first();
        return view('profile', compact('user'));
    }

    public function updateProfile(Request $request)
    {
        if(!Session::get('login_id'))
        return redirect('/login');

        $user = User::whereId(Session::get('login_id'))->first();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->save();

        return response()->json([
            "status" => "success",
            "data" => $user
        ]);
    }

    public function changePassword(Request $request)
    {
        if(!Session::get('login_id'))
        return redirect('/login');

        $user = User::whereId(Session::get('login_id'))->first();

        if (!Hash::check($request->old_password, $user->password)) {
            return response()->json([
                "status" => "failed",
                "data" => $user
            ]);
        }
        $user->password = Hash::make($request->password);
        $user->save();

        return response()->json([
            "status" => "success",
            "data" => $user
        ]);
    }
}
