<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Mail\ResetPassword;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

/**
 * Class UserController
 *
 * @package App\Http\Controllers
 */
class UserController extends Controller
{
    public function register(Request $request){
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);
        try{
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt($request->password),
            ]);
        } catch (\Exception $e) {
            Log::error($request->email.' '.$e->getMessage());
            return back()->with('failure', 'Προέκυψε σφάλμα, επικοινωνήστε με τον διαχειριστή!');
        }
    
        Auth::login($user);

        return redirect()->route('index')->with('success', 'Καλώς ήρθατε '.Auth::user()->name);
    }

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

            return redirect()->route('index')->with('success', 'Καλώς ήρθατε '.Auth::user()->name);
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

    public function change_password(Request $request){
        $incomingFields = $request->all();
        $rules = [
            'new_password' => 'min:6|same:new_password_confirmation',
            'new_password_confirmation' => 'same:new_password|min:8'
        ];

        $validator = Validator::make($incomingFields, $rules);

        if($validator->fails()){
            return back()
                ->with('failure',$validator->errors()->first());
        }
        $user = Auth::user();

        $user->password = bcrypt($incomingFields['new_password']);
        try{
            $user->save();
        } 
        catch (\Exception $e) {
            Log::error($user->id.' '.$e->getMessage());
            return back()->with('failure', 'Προέκυψε σφάλμα, επικοινωνήστε με τον διαχειριστή!');
        }

        return redirect(route('index'))->with('success', 'Ο νέος σας κωδικός αποθηκεύτηκε επιτυχώς');
    }

    public function reset_password(Request $request){
        $incomingFields = $request->all();
        $request->validate([
            'email' => 'required|string|email',
        ]);

        $user = User::where('email', $incomingFields['email'])->first();
        if($user == null){
            return back()->with('failure', 'Δεν υπάρχει χρήστης με αυτό το email');
        }
        $newPassword = Str::random(8);
        $user->password = bcrypt($newPassword);
        try{
            $user->save();
            Mail::to($user->email)->send(new ResetPassword($newPassword));
        } 
        catch (\Exception $e) {
            Log::error($user->id.' '.$e->getMessage());
            return back()->with('failure', 'Προέκυψε σφάλμα, επικοινωνήστε με τον διαχειριστή!');
        }
        
        return redirect(url('/login'))->with('success', 'Ελέγξτε το email σας για τον νέο κωδικό πρόσβασης');
    }
}
