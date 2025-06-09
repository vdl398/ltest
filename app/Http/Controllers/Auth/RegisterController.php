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



class RegisterController extends Controller
{

	
    public function register(Request $request)
    {
		$param = (array)$request->all();
		$this->validate($request, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
        ]);
        $user = User::create([
            'name' => $param['name'],
            'email' => $param['email'],
            'password' => Hash::make($param['password']),
        ]);
		if (!$user || !(int)$user->id) {
			return back()->withErrors(['email' => 'user create error']);
		}
        event(new Registered($user));
		Auth::login($user);
		return redirect()->route('home')->withSuccess('You have successfully registered & logged in!');
    }
	
	
    public function showForm()
    {
        return view('auth.register');
    }


}