<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

class UserController extends Controller
{	    
    public function Register(Request $request)
    {
    	$validator = Validator::make($request->all(),
    		[
    			'name' => 'required|string|max:255',
 				'email' => 'required|string|email|max:255|unique:users',
 				'password' => 'required|string|min:6|confirmed',
    		]
    	);

		if ($validator->fails()) 
		{
			return Response()->json($validator->errors()->toJson(), 400);
		}

		$user = User::create(
			[
				'name' => $request->get('name'),
				'email' => $request->get('email'),
				'password' => Hash::make($request->get('password')),
			]
		);

		$token = JWTAuth::fromUser($user);

		return Response()->json(compact('user', 'token'), 201);
    }

    public function login(Request $request)
    {
    	$credentials = $request->only('email', 'password');

    	try 
    	{
    		if (! $token = JWTAuth::attempt($credentials)) 
    		{
    			return Response()->json(['error' => 'invalid_credentials'], 400);
    		}
    	} 

    	catch (JWTException $e) 
    	{
    		return Response()->json(['error' => 'could_not_create_token', 500]);
    	}

    	return Response()->json(compact('token'));
    }

    public function getAuthenticatedUser()
    {
    	try 
    	{
    		if(! $user = JWTAuth::parseToken()->authenticate())
    		{
    			return Response()->json(['user_not_found'], 404);
    		}
    	} 

    	catch (Tymon\JWTAuth\Exceptions\TokenExpiredException $e)
    	{
    		return Response()->json(['token_expired'], $e->getStatusCode());
    	}

    	catch (Tymon\JWTAuth\Exceptions\TokenInvalidException $e) 
    	{
    		return Response()->json(['token_invalid'], $e->getStatusCode());
    	}

    	catch (Tymon\JWTAuth\Exceptions\JWTException $e) 
    	{
    		return Response()->json(['token_absent'], $e->getStatusCode());
    	}

    	return Response()->json(compact('user'));
    }
}
