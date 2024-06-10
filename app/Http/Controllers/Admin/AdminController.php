<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Request\UpdateAdminRequest;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index (User $user)
    {
        return view ('admin.index', compact('user'));
    }

    public function edit ($userId)
    {
        $user = User::findOrFail($userId);
        $roles = ['admin', 'author', 'registered'];

        return view('admin.edit', compact('user', 'roles'));
    }

    public function update (Request $request, User $user)
    {
        $user->update([
            'role' => $request->role,
        ]);

        return redirect()->route('user.index');
    }
}
