<?php

namespace App\Http\Controllers\Custom;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
     public function store(Request $request)
     {
       $request->validate([
           'password' => 'required|string|min:8|confirmed',
           'password_confirmation' => 'required',
       ]);

       $register = new User;

       $register->name = $request->name;
       $register->email = $request->reg_email;
       $register->password = Hash::make($request->password);

       $register->save();

       return back();
     }
}
