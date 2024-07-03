<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
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
}
