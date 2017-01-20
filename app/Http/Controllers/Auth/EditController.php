<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Support\Facades\Validator;
use App\Traits\UuidModel;
use Illuminate\Support\Facades\Hash;

//Indicamos que use el validador del formulario
use App\Http\Requests\EditRequest;

// Indicamos que trabajamos con redirects
use Redirect;

class EditController extends Controller
{

    use UuidModel;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($uuid)
    {
        // Se muestra la información de un usuario.
        // Comprobamos si el $id existe en la base de datos.
        /*$usuario=User::find($id);

        if ($usuario== null)
            return Redirect::to('users');

        return view('perfil')->withElusuario($usuario);*/
        return Redirect::to(url('/'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $uuid
     * @return Response
     */
    public function edit($uuid)
    {
        // Se muestra la información de un usuario.
        // Comprobamos si el $id existe en la base de datos.
        $usuario=User::where('uuid',$uuid)->get();

        if ($usuario== null)
            return Redirect::to(url('/'));

        return view('auth\edit');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($uuid,EditRequest $request)
    {


        $usuario=User::where('uuid',$uuid)->firstOrFail();

        if ($usuario== null)
            return Redirect::to(url('/home'));
        if (Hash::check($request->old_password, $usuario->password))
            {
            if (strcmp ($usuario->name , $request->name) !== 0)
                $usuario ->name = $request -> name;
            if (strcmp ($usuario->email , $request->email) !== 0)
                $usuario ->email = $request -> email;
            if (strcmp ($usuario->fnacimiento , $request->fnacimiento) !== 0)
                $usuario ->fnacimiento = $request -> fnacimiento;
            if ($request->input('password'))
                $usuario->password = Hash::make($request->input('password'));

            // Grabamos el usuario en la tabla.
            $usuario->save();
        }

        // Redireccionamos a la página personal del usuario.
        return Redirect::to(url()->previous());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($uuid)
    {
        Auth::logout();
        $usuario=User::where('uuid',$uuid);
        $usuario->delete();

        return Redirect::to(url('/'));
    }

}
