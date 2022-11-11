<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /**
     * register a new user with name,email and encrypt password
     * create token
     * @param Request $request
     * @return Response
     */
    public function register(Request $request)
    {
        $fields = $request->validate(
            [
                'name' => 'required|string',
                'email' => 'required|string|unique:users,email',
                'password' => 'required|string|confirmed'
            ]
        );
        $user = User::create(
            [
                'name' => $fields['name'],
                'email' => $fields['email'],
                'password' => bcrypt($fields['password'])
            ]
        );
        $token = $user->createToken('appToken')->plainTextToken;
        $response =
            [
            'user' => $user,
            'token' => $token
            ];
        return response($response,201);
    }
    /**
     *check email and decrypted password in the database to login
     * create token
     * @param Request $request
     * @return Response
     */
    public function login(Request $request)
    {
        $fields=$request->validate(
            [
                'email' => 'required|string',
                'password' => 'required|string'
            ]
        );
        $user = User::where('email',$fields['email']) -> first();
        if(!$user |!Hash::check($fields['password'],$user->password))
        {
            return response(
                [
                    'massage'=>'not correct'
                ]
                ,401
            );
        }
        $token = $user->createToken('appToken')->plainTextToken;
        $response =
            [
            'user' => $user,
            'token' => $token
            ];
        return response($response,201);
    }
    /**
     * logout and delete token for the user
     * @return Response
     */
    public function logout()
    {
        Auth::user()
            ->tokens
            ->each(function($token, $key)
        {
            $token -> delete();
        }
        );

        return response()->json('Successfully logged out');
    }
}
