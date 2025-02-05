<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index ()
    {
        $user = User::all();

        return view('user.index', compact('user'));
    }

    public function block(Request $request, User $user)
    {
        $days = $request->input('days', 1);
        $user->blocked_until = Carbon::now()->addDay($days);
        $user->save();

        return redirect()->back();
    }

    public function edit (User $user)
    {
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
