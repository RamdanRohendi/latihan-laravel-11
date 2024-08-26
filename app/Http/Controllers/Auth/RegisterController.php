<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    public function index()
    {
        return view('pages.auth.register');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => ['required', 'email', 'unique:users'],
            'password' => 'required|confirmed|min:6',
            'password_confirmation' => 'required',
        ], [
            'name.required' => 'Name harus diisi!!',
            'password.confirmed' => 'Password harus sama!!',
        ]);

        $input = $request->all();
        unset($input['_token']);
        unset($input['password_confirmation']);

        $user = User::create($input);

        return redirect()->route('login');
    }
}
