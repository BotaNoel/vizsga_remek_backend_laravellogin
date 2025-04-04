<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
     * Handle a registration request for the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        // Validáció
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors(),
            ], 422); // Válasz a frontend számára a hibákkal
        }

        // Új felhasználó létrehozása
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'remember_token' => Str::random(60), // Ha szükséges a "remember me" token
        ]);

        // Regisztráció esemény elindítása
        // event(new Registered($user));

        // Bejelentkezés a regisztrált felhasználóval
        Auth::login($user);

        // A felhasználó adatainak visszaküldése
        return response()->json([
            'message' => 'Sikeres regisztráció!',
            'user' => $user,
        ]);
    }

    /**
     * Handle a login request for the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request)
    {
        // Validáció
        $credentials = $request->only('email', 'password');
        
        if (Auth::attempt($credentials)) {
            $user = Auth::user();

            return response()->json([
                'message' => 'Sikeres bejelentkezés!',
                'user' => $user,
            ]);
        }

        return response()->json([
            'error' => 'Hibás e-mail cím vagy jelszó',
        ], 401);
    }
}
