<?php

namespace App\Http\Controllers\Custom;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;


class LoginController extends Controller
{
    public function index()
    {
        return view('auth.login');
    }

    public function authenticate(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'login_password' => 'required|string',
        ]);

        $user = User::where('email', $request->email)->first();


        if (!$user) {
            return back()->withErrors(['email' => 'Email address not found.'])->withInput($request->only('email'));
        }

        if($user->login_attempt > 3) {
            return back()->withErrors(['email' => 'Account has been locked. Contact administrator.'])->withInput($request->only('email'));
        }

        if (!Hash::check($request->login_password, $user->password)) {

            $user->login_attempt = $user->login_attempt + 1;
            $user->save();

            return back()->withErrors(['login_password' => 'Invalid password.'])->withInput($request->only('email'));
        }

        $request->session()->put([
            'user_id' => $user->id
        ]);

        $user->login_attempt = 0;
        $user->login_date = date("Y-m-d h:s:i");
        $user->status = 1;
        $user->save();

        Session::put('login_id', $user->id );
        Session::put('login_email', $user->email );
        return redirect('/profile');
    }

    public function destroy()
    {
        $user = User::where('email', Session::get('login_email'))->first();
        $user->status = 0;
        $user->save();

        Session::forget('login_id');
        Session::forget('login_email');
        return redirect('/login');
    }
}
