<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function index()
    {
        return view('login');
    }

    public function login(Request $request)
    {
        $credentials = [
            'login' => $request['login'],
            'password' => Hash::make($request['password'])
        ];
        
        if (Auth::attempt($credentials)) {
            $this->setSessionData(Auth::user());
            
            return redirect()->intended('/home');
        } else {
            return redirect()->back()->with(['error' => 'Unable to login. Please try again.'])
                ->withInput($request->only(['login']));
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login-index');
    }

    private function setSessionData($user)
    {
        session([
            'id'        =>  $user->id,
            'login'     =>  $user->login,
            'email'     =>  $user->email
        ]);
    }
    
}
