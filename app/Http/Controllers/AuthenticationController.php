<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Knuckles\Scribe\Attributes\Authenticated;
use Knuckles\Scribe\Attributes\Group;
use Knuckles\Scribe\Attributes\Response;

#[Group('Authentication')]
class AuthenticationController extends Controller
{
    #[Response(
        content: ['token' => '1|dsakpodkaspokdopask'],
        description: 'if email and password is correct'
    )]
    #[Response(
        content: ['message' => 'Email or password is wrong'],
        status: 400,
        description: 'if email and password is incorrect'
    )]
    public function login(LoginRequest $request)
    {
        $user = User::query()->where('email', $request->email)->first();

        if (!Hash::check($request->password, $user->password)) {
            return response(['message' => 'Email or password is wrong'], 400);
        }

        $token = $user->createToken('token')->plainTextToken;

        return response(compact('token'));
    }

    #[Response(
        content: ['token' => '1|dsakpodkaspokdopask']
    )]
    public function register(RegisterRequest $request)
    {
        $user = User::create($request->only(['name', 'email', 'password']));

        $user->customer()->create($request->only('phone'));

        $token = $user->createToken('token')->plainTextToken;

        return response(compact('token'));
    }

    #[Authenticated]
    #[Response(
        status: 204
    )]
    public function logout()
    {
        auth()->user()->currentAccessToken()->delete();

        return response()->noContent();
    }
}
