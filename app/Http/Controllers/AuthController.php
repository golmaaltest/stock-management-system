<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            'name'      => ['required', 'string', 'max:255'],
            'email'     => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password'  => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'name'      => $request->name,
            'email'     => $request->email,
            'password'  => Hash::make($request->password),
        ]);

        event(new Registered($user));

        Auth::login($user);

        return response()->json([
            'name'      => $request->name,
            'email'     => $request->email,
            'password'  => $request->password,
            'message'   => __('User registerd successfully.'),
        ]);
    }

    public function login(Request $request)
    {
        $validated = $request->validate([
            'email'     => 'required|email',
            'password'  => 'required',
        ]);
        if (Auth::attempt($validated)) {
            $user = Auth::user();
            return response()->json([
                'token' => $user->createToken('API Token')->plainTextToken,
            ]);
        }
        return response()->json(['error' => 'Unauthorized'], 401);
    }

    public function logout(Request $request)
    {
        if ($user = Auth::user()) {
            $user->tokens->each(function ($token) {
                $token->delete();
            });

            return response()->json(['message' => __('Logged out successfully')]);
        } else {
            return response()->json(['message' => __('User not authenticated')], 401);
        }
    }
}
