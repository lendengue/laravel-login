<?php

namespace App\Http\Controllers;

use App\Repositories\UserRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    protected $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = [
            'username' => $request['username'],
            'password' => $request['password']
        ];
        
        $verifyCredentials = $this->userRepository->verifyCredentials($credentials['username'], $credentials['password']);

        if (!$verifyCredentials) {
            return redirect()->back()->with(['error' => 'Invalid credentials.'])
                ->withInput($request->only(['username']));
        }
        if (Auth::attempt($credentials)) {
            $this->setSessionData(Auth::user());
            
            return redirect()->intended('/home');
        } else {
            return redirect()->back()->with(['error' => 'Unable to login. Please try again.'])
                ->withInput($request->only(['username']));
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
            'username'  =>  $user->username,
            'email'     =>  $user->email
        ]);
    }
    
}
