<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;

class DashboardController extends Controller
{
    public function index()
    {
        $role = 'User';

        if (Gate::allows('admin')) {
            $role = 'Admin';
        }

        return view('pages.master.admin', [
            'role' => $role
        ]);
    }
}
