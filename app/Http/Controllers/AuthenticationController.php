<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class AuthenticationController extends Controller
{
    public function loginView () {
        return view('login');
    }
    public function registrationView () {
        return view('registration');
    }

    public function login (Request $request) {
        $data = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required']
        ]);

        if(Auth::attempt($data)){
            $request->session()->regenerate();
            return to_route('chat.index');
        }
        return back()->withErrors([
            'email' => 'A megadott E-mail cím nem megfelelő!',
            'password' => 'A megadott jelszó nem megfelelő!'
        ]);
    }

    public function registration (Request $request) {
        $request->validate([
            'email' => ['required'],
            'username' => ['required'],
            'password' => ['required'],
        ]);

        $data['name'] = $request->username;
        $data['email'] = $request->email;
        $data['password'] = Hash::make($request->password);

        $user = User::create($data);
        $user->save();

        if(!$user) {
            return back()->withErrors([
                'email' => 'A megadott E-mail cím nem megfelelő!',
                'username' => 'A megadott felhasználónév nem megfelelő!',
                'password' => 'A megadott jelszó nem megfelelő!',
            ]);
        }

        return to_route('chat.index');
    }

    public function logout (){
        Session::flush();
        Auth::logout();

        return to_route('login');
    }
}
