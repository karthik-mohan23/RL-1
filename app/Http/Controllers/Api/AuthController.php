<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\SignupRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{

    public function signup(SignupRequest $request) {
        $data = $request->validated(); // returns an array containing only the validated input data 

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password'])
        ]);
    
        $token = $user->createToken('main')->plainTextToken;
    
        return response([
        'user' => $user,
        'token' => $token
        ]);
    }

    public function login(LoginRequest $request) {

   
        $credentials = $request->validated();
        if(!Auth::attempt($credentials)) {
        return response([
        'message' => 'Provided credentials are incorrect'
        ]);
    }

        $user = Auth::user();
        // Both methods ($request->user() and Auth::user()) ultimately achieve the same goal of retrieving the currently authenticated user.
        $token = $user->createToken('main')->plainTextToken;
        return response([
            'user' => $user,
            'token' => $token,
        ]);
    }

  

    public function logout(Request $request) {

        $user = $request->user();
        //   When a user makes a request to log out, typically, this request would contain some sort of authentication token in the header (like a bearer token) or in the request payload. Laravel automatically handles the authentication process and makes the authenticated user available via the $request->user() method call.
        $user->currentAccessToken->delete();
        return response('',204);

    }
}
