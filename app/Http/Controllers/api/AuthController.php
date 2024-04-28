<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required'
        ]);

        $credentials = $request->only(['username', 'password']);
        if(!auth()->attempt($credentials)){
            return response()->json(['message' => 'invalid login'], 400);
        }

        $user = auth()->user();
        $user->token = bcrypt($user->id);
        $user->save();

        return response()->json(['token' => $user->token]);
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required|unique:users,username',
            'password' => 'required',
            'phone' => 'required'
        ]);
        if($validator->fails()){
            return response()->json(['message' => 'invalid field'], 400);
        }

        $user = new User();
        $user->username = $request->username;
        $user->password = bcrypt($request->password);
        $user->phone = $request->phone;
        $user->save();

        return response()->json(['message' => 'Register successfuly']);
    }

    public function logout()
    {
        $user = auth()->user();
        $user->token = null;
        $user->save();

        return response()->json(['message' => 'Logout successfuly']);
    }

    public function current()
    {
        $user = auth()->user();
        return response()->json($user);
    }
}
