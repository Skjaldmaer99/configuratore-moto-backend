<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function register(RegisterRequest $request) {
        try {
            $data = $request->validated();

            $user = User::create([
                "name" => $data['name'],
                "email" => $data['email'],
                "password" => $data['password'],
                "role" =>  $data['role']
            ]);

            event(new Registered($user)); // per far scaturire la verifica email

            return response()->json([
                'success' => true,
                'messagge' => "Utente registrato con successo",
                'data' => $user
            ], 201);
        } catch(\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }

    public function login(LoginRequest $request) {
        try {
            $credentials = $request->validated();

            if(!Auth::attempt($credentials)) { // attempt() fa "Controlla se email/password corrispondono a un utente nel database; se sì, loggalo.”
                return response()->json([
                'success' => false,
                'message' => "Credenziali non valide"
            ]);
            }

            $user = Auth::user();

            $token = $user->createToken('auth_token')->plainTextToken;

            return response()->json([
                "success" => true,
                "message" => "Login effettuato con successo",
                "user" => new UserResource($user),
                "token" => $token
            ], 200);

        } catch(\Exception $e) {
            return response()->json([
                "success" => false,
                "message" => $e->getMessage()
            ]);
        }
    }

    public function logout() {
        Auth::user()->currentAccessToken()->delete();

        return response()->json([
            "success" => true,
            "message" => "Logout effettuato con successo",
        ], 200);
    }

    public function user() {
        try {
            $user = new UserResource(Auth::user());
    
            return response()->json([
                "success" => true,
                "user" => $user,
                "message" => "User autenticato ritornato con successo"
            ]);
        } catch(\Exception $e) {
            return response()->json([
                "success" => false,
                "message" => $e->getMessage()
            ]);
        }
    }
}
