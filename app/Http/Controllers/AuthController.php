<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use \stdClass;
use Illuminate\Support\Facades\Hash;


class AuthController extends Controller
{
    //
    public function register(Request $request)
    {

        $validator = validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'razon_social' => 'required|string|max:255',
            'direccion' => 'required|string|max:255',
            'lastName' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'nit'=> 'required|integer',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(),401);
        }

        $user = User::create([
            'name' => $request->name,
            'razon_social' => $request->razon_social,
            'direccion' => $request->direccion,
            'lastName' => $request->lastName,
            'email' => $request->email,
            'nit' => $request->nit,
            'password' => Hash::make($request->password)
        ]);

        $token = $user->createToken('auth_token')->plainTextToken;

        $user->remember_token = $token;
        $user->save();

        return response()
            ->json(['data' => $user, 'access_token' => $token, 'token_type' => 'Bearer',]);
    }

    public function login(Request $request)
    {
        if (!Auth::attempt($request->only('email', 'password'))) {
            return response()->json(['Mensaje' => 'Correo o contraseña invalidos'], 401);
        }

        $user = User::where('email', $request['email'])->firstOrFail();
        $token = $user->createToken('auth_token')->plainTextToken;

        $user->remember_token = $token;
        $user->save();



        return response()->json([
                'message' => 'Bienvenido ' . $user->name,
                'access_token' => $token,
                'token_type' => 'Bearer',
                'user' => $user,
            ]);
    }

    public function logout(Request $request)
    {

        auth()->user()->tokens()->delete();

        return [
            'Logout OK'
        ];
    }
}
