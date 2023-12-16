<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserController extends Controller
{
    function index(Request $request)
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
}
