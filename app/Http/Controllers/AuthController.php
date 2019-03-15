<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\User;

class AuthController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('jwt', ['except' => ['login','signup']]);
    }

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login()
    {
        $data = request(['email','password']);

        $validator = Validator::make($data, [
            'email' => ['required', 'string', 'email', 'max:255'],
            'password' => ['required', 'string', 'min:6'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'error' => $validator->errors()
            ], Response::HTTP_BAD_REQUEST);
        }

        if (!User::where('email', $data['email'])->first()) {
            return response()->json([
                'error' => "There is no account with this email"
            ], Response::HTTP_BAD_REQUEST);
        };

        if ($token = auth()->attempt($data)) {
            $user = auth()->user();
            return response()->json([
                'user' => $user,
                'token' => $token
            ], Response::HTTP_OK);
        } else {
            return response()->json([
                'error' => 'email and/or password are incorrect'
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function signup(Request $request)
    {
        $data = request(['name', 'email', 'password', 'password_confirmation']);

        $validator = Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:190', 'unique:users'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'error' => $validator->errors()
            ], Response::HTTP_BAD_REQUEST);
        }

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);

        $token = auth()->attempt(['email' => $data['email'], 'password' => $data['password']]);

        return response()->json([
            'user' => $user,
            'token' => $token
        ], Response::HTTP_OK);
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function user()
    {
        if (!$user = auth()->user()) {
            return response()->json([
                'error' => "You are not authorized"
            ], Response::HTTP_FORBIDDEN);
        } else {
            return response()->json([
                'user' => $user,
            ], Response::HTTP_OK);
        }
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth()->logout();

        return response()->json([
            'user' => null,
            'token' => null
        ], Response::HTTP_OK);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return response()->json([
            'token' => auth()->refresh()
        ], Response::HTTP_OK);
    }
}
