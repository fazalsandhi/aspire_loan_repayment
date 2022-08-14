<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\LoginRequest;
use App\Models\User;

class AuthController extends Controller
{
    public function register(RegisterRequest $request){
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password)
        ]);
        $token = $user->createToken('Aspire')->accessToken;
        $user->token = $token;
        return response()->json(['error' => false, 'message' => 'Success', 'data' => $user], 200);
    }

    public function login(LoginRequest $request){
        $data = [
            'email' => $request->email,
            'password' => $request->password
        ];
 
        if (auth()->attempt($data)) {
            $user = auth()->user();
            $user->token = $user->createToken('Aspire')->accessToken;
            return response()->json(['error' => false, 'message' => 'Success', 'data' => $user], 200);
        } else {
            return response()->json(['error' => true,'message' => 'Unauthorised'], 401);
        }
    }
}
