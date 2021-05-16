<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserController extends Controller
{
    public function Login(Request $request)
    {
        $user = User::whereEmail($request->email)->first();
        if(!is_null($user) && Hash::check($request->password, $user->password))
        {
            $user->api_token = Str::random(150);
            $user->save();
            return response()->json(['res' => true, 'token' => $user->api_token, 'message' => 'Bienvenido al sistema'], 200);
        }
        else
        {
            return response()->json(['res' => false, 'message' => 'Email o contraseña incorrectos'], 200);
        }
    }

    public function Logout()
    {
        $user = auth()->user();
        $user->api_token = null;
        $user->save();
        return response()->json(['res' => true, 'message' => 'Desconectado del sistema'], 200);
    }
}
