<?php

namespace App\Http\Controllers;

use DataTables;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function getData(Request $request)
    {
        $users = User::query();

        if (@$request->tipe == 'plain') {
            return response()->json([
                'status' => 'success',
                'message' => 'Data Users',
                'data' => $users->get()
            ]);
        }

        return DataTables::of($users)
        ->addIndexColumn()
        ->addColumn('action', function ($user) {
            return '
                <a href="'.route('admin.users.edit', $user->id).'" class="font-medium text-blue-600 hover:underline">Edit</a>
                <form action="'.route('admin.users.destroy', $user->id).'" method="POST">
                    <input type="hidden" name="_method" value="DELETE">
                    <input type="hidden" name="_token" value="'.csrf_token().'" />
                    <button
                        type="button"
                        class="font-medium text-red-600 hover:underline btn-delete">
                        Delete
                    </button>
                </form>
            ';
        })
        ->rawColumns(['action'])
        ->make(true);
    }

    public function index()
    {
        return view('pages.master.users.index');
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
            return response()->json([
                'status' => 'error',
                'message' => 'Pengguna tidak ditemukan',
            ]);
        }

        $user->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Pengguna berhasil dihapus',
        ]);
    }
}
