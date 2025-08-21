<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function hash() {
       $senha = Hash::make(123456);
        dd($senha);
    }

    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if(Auth::attempt($credentials, $request->has('remember'))){
            $user = User::where('email', $request->email)->get()[0];

            if($user) {
                $request->session()->regenerate();
                return redirect()->intended('home');
            }else {
                return back()->with('error', 'Usuário inativo, contate o administrador!');
            }
        }

        return back()->with('error-credenciais', 'As credenciais fornecidas são inválidas!');
    }

    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'status' => 1,
            'perfil' => 1,
            'remember_token' => Str::random(60),
        ]);

        Auth::login($user);
        $request->session()->regenerate();

        return redirect()->route('dashboard'); // Redirecionar após o registro
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }
}
