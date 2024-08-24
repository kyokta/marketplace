<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8',
            'confirm_password' => 'required|same:password'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'Failed',
                'message' => 'Validation error',
                'data' => $validator->errors()
            ], 422);
        }

        $input = $request->only('name', 'email', 'password');
        $input['password'] = bcrypt($input['password']);
        $user = User::create($input);

        $success['email'] = $user->email;
        $success['name'] = $user->name;
        $success['token'] = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'status' => 'Success',
            'message' => 'Registration successful',
            'data' => $success
        ]);
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'Failed',
                'message' => 'Validation error',
                'data' => $validator->errors()
            ], 422);
        }

        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $auth = Auth::user();
            $success['email'] = $auth->email;
            $success['name'] = $auth->name;
            $success['token'] = $auth->createToken('auth_token')->plainTextToken;

            return response()->json([
                'status' => 'Success',
                'message' => 'Login successful',
                'data' => $success
            ]);
        } else {
            return response()->json([
                'status' => 'Failed',
                'message' => 'Invalid email or password',
                'data' => null
            ], 401);
        }
    }

    public function logout()
    {
        $user = Auth::user();

        if (!$user) {
            return response()->json([
                'status' => 'Failed',
                'message' => 'Invalid or expired token'
            ], 401);
        }

        $user->currentAccessToken()->delete();

        return response()->json([
            'status' => 'Success',
            'message' => 'Logout successful'
        ]);
    }
}
