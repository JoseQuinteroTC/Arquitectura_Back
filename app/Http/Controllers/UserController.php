<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;


use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Mail\WelcomeMail;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\message;

use App\changePassword;
class UserController extends Controller
{
    //
    public function showAll()
    {
        $product = User::all();

        return $product;
    }

    public function showId($id)
    {
        $user = User::find($id);

        return response()
            ->json(['usuario' => $user]);
    }

    public function showToken($token)
    {
        $user = User::where('remember_token', $token)->first();

        return response()
            ->json($user);
    }

    public function findName($name)
    {
        $user = User::where('name', 'LIKE', '%' . $name)->get();
        return response()
            ->json($user);
    }

    //update

    public function changePassword(Request $request)
    {
        $user = User::findOrFail($request->id);

        // if ($user->password == $request->password) {
        if (Hash::check($request->password, $user->password)) {
            $user->password = Hash::make($request->newPassword);
            $user->save();
            return response()
                ->json(['data' => $user,]);
        }

        return response()
            ->json(['La contraseña actual no es la correcta'], 401);
    }

    public function updateData(Request $request)
    {
        $user = User::findOrFail($request->id);

        if ($user->email != $request->email ) {
            $validator = validator::make($request->all(), [
                'email' => 'required|unique:users',
            ]);
            if ($validator->fails()) {
                return response()->json("Ya existe un usuario con el correo ingresado", 401);
            }
        }

        $user->name = $request->name;
        $user->lastName = $request->lastName;
        $user->email = $request->email;
        $user->save();

        return response()
            ->json(['data' => $user,]);
    }

    //delete

    public function deleteUser($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return response()
            ->json(['status' => 'eliminado',]);
    }

    public function saveImg(Request $request)
    {
        if ($request->hasFile('foto')) {
            $foto = $request->file('foto');

            $nombreArchivo = $request->id . '.' . $foto->getClientOriginalExtension();

            // Guardar la foto en almacenamiento local
            $ruta = $foto->storeAs('profile_photo', $nombreArchivo, 'public_html');

            return response()
                ->json("Foto guardada exitosamente");
        }

        return response()
            ->json("No se ha proporcionado ninguna foto", 404);
    }

    public function sendResetLinkEmail($email)
    {
        $user = User::where('email', $email)->first();
        $pin = rand(100000, 999999);

        if ($user) {

            Mail::to($email)->send(new changePassword ($user->name, $user->lastName, $pin));

            $user->pin = $pin;
            $user->save();
            return response()
            ->json("Correo enviado", 200);
        }

        return response()
            ->json("correo no existe", 404);
    }

    public function validatePin(Request $request)
    {
        $user = User::where('email', $request->email)->first();

        if ($user->pin == $request->pin) {
            return response()
                ->json("Pin valido");
        }

        return response()
            ->json("Pin invalido", 404);
    }

    public function resetPassword(Request $request)
    {
        $user = User::where('email', $request->email)->first();

        $user->password = Hash::make($request->password);
        $user->save();

        return response()
            ->json(['data' => $user,]);
    }
}
