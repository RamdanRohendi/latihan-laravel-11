<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(Request $request)
    {
        if ($request->has('search')) {
            $users = User::where('name', 'like', '%' . $request->search . '%')->get();
        } else {
            $users = User::all();
        }

        return view('pages.master.users.index', [
            'users' => $users,
        ]);
    }

    public function create()
    {
        return view('pages.master.users.form');
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

        // $user = new User();
        // $user->name = $request->name;
        // $user->email = $request->email;
        // $user->password = $request->password;
        // $user->save();

        // $user = User::create($request->all());
        $user = User::create($input);

        return redirect()->route('admin.users.index');
    }

    public function edit($id)
    {
        return view('pages.master.users.form', [
            'user' => User::find($id),
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'email' => 'required|unique:users,email,' . $id,
            'name' => 'required',
        ], [
            'name.required' => 'Name harus diisi!!',
        ]);

        $user = User::find($id);

        if (!$user) {
            return redirect()->back();
        }

        $user->email = $request->email;
        $user->name = $request->name;
        $user->save();

        // User::where('id', $id)->update([
        //     'name' => $request->name,
        // ]);

        return redirect()->route('admin.users.index');
    }

    public function destroy($id)
    {
        $user = User::find($id);

        if (!$user) {
            return redirect()->back();
        }

        $user->delete();

        return redirect()->route('admin.users.index');
    }
}
