<?php

namespace App\Http\Controllers\Auth;



use Illuminate\Http\Request;
use Illuminate\Auth\Events\Registered;
use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;



class LoginController extends Controller
{

	
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);
        if(Auth::attempt($credentials))
        {
            $request->session()->regenerate();
            return redirect()->route('home')
                ->withSuccess('You have successfully logged in!');
        }
		 return back()->withErrors([
            'email' => 'Your provided credentials do not match in our records.',
        ])->onlyInput('email');
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
	
    public function showForm()
    {
        return view('auth.login');
    }


}