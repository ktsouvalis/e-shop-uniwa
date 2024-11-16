<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function login(Request $request){

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            return redirect()->route('index')->with('success', 'Καλως ήρθατε '.Auth::user()->name);
        }

        return back()
            ->withInput()
            ->with('failure','Ελέγξτε τα στοιχεία σας και προσπαθήστε ξανά');	
    }

    public function logout(Request $request){
        Auth::logout();

        $request->session()->invalidate();

        return redirect()->route('index')->with('success', 'Αποσυνδεθήκατε');
    }
}
