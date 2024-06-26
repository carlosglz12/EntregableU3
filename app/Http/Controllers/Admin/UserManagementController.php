<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;

class UserManagementController extends Controller
{
    public function index()
    {
        $users = User::all();
        return view('Admin.admin', compact('users'));
    }

    public function create()
    {
        $roles = Role::all();
        return view('Admin.create', compact('roles'));
    }

    public function edit(User $user)
    {
        $roles = Role::all();
        return view('Admin.edit', compact('user', 'roles'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'role_id' => 'required|exists:roles,id',
        ]);

        $user->update([
            'role_id' => $request->role_id,
        ]);

        return redirect()->route('admin.users.index');
    }
}
