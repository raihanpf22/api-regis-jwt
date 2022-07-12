<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use JWTAuth;
use Tymon\JWTAuth\Exception\JWTException;

class UserController extends Controller
{
    //
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');
        try{
            if (! $token = JWTAuth::attempt($credentials)) 
            {
                return response()->json(['error' => 'invalid_credentials'], 400);    
            }

        }catch(JWTException $err){
            return response()->json(['error' => 'couldnt_create_token'], 500);
        }
        return response()->json(compact('token'));
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors()->toJson(), 400);
        }
        $user = User::create([
            'name' => $request->get('name'),
            'email' => $request->get('email'),
            'password' =>Hash::make($request->get('password')),
        ]);

        $token = JWTAuth::fromUser($user);

        return response()->json(compact('user', 'token'), 201);
    }

    public function getAuthenticatedUser()
    {
        try {
            if (! $user = JWTAuth::parseToken()->authenticate()) {
                return response()->json('user_not_found', 404);
            }
        } catch (Tymon\JWTAuth\Exceptions\TokenExpiredException $err) {

            return response()->json(['token_expired'], $err->getStatusCode());

        } catch (Tymon\JWTAuth\Exception\TokenInvalidException $err){
            
            return response()->json(['token_invalid'], $err->getStatusCode());

        }catch (Tymon\JWTAuth\Exception\JWTException $err){

            return response()->json(['token_absent'], $err-> getStatusCode());
                
        }

        return response()->json(compact('user'));
    }

}
