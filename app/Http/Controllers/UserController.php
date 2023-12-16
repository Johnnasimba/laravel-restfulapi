<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserController extends Controller
{
    function login(Request $request)
    {
        $user = User::where('email', $request->email)->first();
        if (!$user || !Hash::check($request->password, $user->password)) {

            return response()->json([
                'message' => 'Invalid credentials',
                'user' => $user
            ], 404);
        }

        $token = $user->createToken('my-app-token')->plainTextToken;

        return response()->json([
            'message' => 'User logged in successfully',
            'token' => $token
        ], 200);
    }

    function register(Request $request)
    {
        $user = new User();
        $user->name = $request->name;
        $user->email= $request->email;
        $user->password = Hash::make($request->password);
        $user->save();

        return response()->json([
            'message' => 'User registered successfully',
        ], 200);
    }
}
