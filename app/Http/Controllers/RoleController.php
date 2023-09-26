<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function index()
    {
        return view('admin.Tables.Role.roles', [
            'title' => 'Roles',
            'roles' => Role::orderBy('name', 'asc')
                ->get()
        ]);
    }

    public function show(Role $role)
    {
        return view('admin.Tables.Role.role', [
            'title' => 'Role',
            'role' => $role
        ]);
    }
}
