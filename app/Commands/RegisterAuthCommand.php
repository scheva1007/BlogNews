<?php
//
//namespace App\Commands;
//
//use App\Http\Request\RegistrationAuthRequest;
//use App\Models\User;
//use Illuminate\Support\Facades\Hash;
//
//class RegisterAuthCommand
//{
//    public function userCreate (RegistrationAuthRequest $request )
//    {
//        $register = User::create ([
//            'name' => $request->name,
//            'email' => $request->email,
//            'password' => Hash::make($request->password),
//        ]);
//
//        return $register;
//    }
//}
