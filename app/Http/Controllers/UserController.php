<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * Class UserController
 *
 * @package App\Http\Controllers
 */
class UserController extends Controller
{
    /**
     * Handle the user login.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
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

    /**
     * Handle the user logout.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout(Request $request){
        Auth::logout();

        $request->session()->invalidate();

        return redirect()->route('index')->with('success', 'Αποσυνδεθήκατε');
    }
}
