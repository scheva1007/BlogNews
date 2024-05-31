<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Request\UpdateCabinetRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class PersonalCabinetController extends Controller
{
    public function edit($userId)
    {
        $user = User::findOrFail($userId);

        return view('cabinet.edit', compact('user'));
    }

    public function update (UpdateCabinetRequest $request, User $user)
    {
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);
        if($request->filled('password')){
            $user->password = Hash::make($request->password);
        }
        $user->save();

        return redirect()->route('cabinet.edit', $user->id);
    }
}
