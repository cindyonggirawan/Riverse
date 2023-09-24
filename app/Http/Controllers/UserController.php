<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        return view('admin.Tables.User.users', [
            'title' => 'Users',
            'users' => User::all()
        ]);
    }

    public function show(User $user)
    {
        return view('admin.Tables.User.user', [
            'title' => 'User',
            'user' => $user
        ]);
    }
}
