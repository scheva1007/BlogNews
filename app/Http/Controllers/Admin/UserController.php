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

    public function block($id)
    {
        $user = User::findOrFail($id);
        $user->blocked_until = Carbon::now()->addDay();
        $user->save();

        return redirect()->back();
    }
}
