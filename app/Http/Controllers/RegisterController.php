<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

//Illumiate es una librería de PHP que nos permite validar los datos que nos llegan de un formulario
//Facades se usa para acceder a las clases de Laravel sin tener que instanciarlas

class RegisterController extends Controller
{
    public function index()
    {
        return view('auth.register');
    }
    public function store(Request $request)
    {
        // dd($request);
        // dd($request->get('username'));
        

        //Modificar request
        $request->request->add(['username' => Str::slug($request->username)]);

        //VALIDACIÓN

        $request->validate ([
            'name' => 'required|min:1|max:30',
            'username' => 'required|unique:users|min:3|max:20',
            'email' => 'required|email|unique:users|max:60',
            'password' => 'required|min:6|confirmed'
        ]);

        //Crear un registro en la base de datos
        $user = User::create([
            'name'=> $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);

        //Autenticar usuario 
        Auth::attempt([
            'email' => $request->email, 
            'password' => $request->password
        ]);

        //Redireccionar al usuario
        return redirect()->route('posts.index', ['user' => $user->username]);
    }
}

