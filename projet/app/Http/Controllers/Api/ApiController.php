<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;

class ApiController extends Controller
{
    //Register API (POST ,formdata)
    public function register(Request $request)
    {
        // validation de données
        $request->validate([
            "name" => "required",
            "email" => "required|email|unique:users",
            "password" => "required|min:8",
            "role"=>"required|in:admin,candidat,recruteur"
        ]);
        
        // create user
        $user = User::create([
            "name" => $request->name,
            "email" => $request->email,
            "password" => $request->password,
            "role" => $request->role
        ]);
        
        // return response
        return response()->json([
            "status" => true,
            "message" => "inscription reussie",
            "user" => $user
        ]);
        
    }
    //Login API (POST ,formdata)
    public function login(Request $request)
    {
        // data validation
        $request->validate([
            "email" => "required|email",
            "password" => "required"
        ]);

        // JWTAuth
        $token = JWTAuth::attempt([
            "email" => $request->email,
            "password" => $request->password
        ]);

        if(!empty($token)){

            return response()->json([
                "status" => true,
                "message" => "Connexion reussie",
                "token" => $token
            ]);
        }

        return response()->json([
            "status" => false,
            "message" => "Invalid details"
        ]);
    }
    // Profile API (GET)
     public function profile()
     {
        $userdata = auth()->user();

        return response()->json([
            "status" => true,
            "message" => "Profile data",
            "data" => $userdata
        ]);
     }
     //Refresh Token API (GET)
     public function refreshToken()
     {
        $newToken = auth()->refresh();

        return response()->json([
            "status" => true,
            "message" => "Nouveau access token",
            "token" => $newToken
        ]);
     }
    //  Logout Api (GET)
    public function logout()
    {
        auth()->logout();

        return response()->json([
            "status" => true,
            "message" => "Deconnexion reussie"
        ]);
    }
}
