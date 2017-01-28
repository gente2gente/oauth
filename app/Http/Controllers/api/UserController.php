<?php

namespace App\Http\Controllers\api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\User;
use App\Traits\UuidModel;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\JsonRequest;

class UserController extends Controller
{
    use UuidModel;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['auth:api']);
        //Marcando los Scopes necesarios para las funciones
        $this->middleware('scope:read,write');
        $this->middleware('scopes:write')->only(['store','update','delete']);
    }
    /**
     * Display all the users.
     *
     * @param
     * @return Response
     */
    public function index()
    {
        $usuarios=User::paginate(2);
        return $usuarios;
    }
    /**
     * Display the specified resource.
     *
     * @param  uuid  $uuid
     * @return Response
     */
    public function show($uuid)
    {
        // Se muestra la información de un usuario.

        $usuario=User::where('uuid',$uuid)->firstOrFail();
        if ($usuario==null)
            {
            return ['error' => "User Not Found"];
            }
        return $usuario;
    }

    /**
     * Display all the users.
     *
     * @param  todo el usuario
     * @return Response
     */
    public function store(Request $request)
    {
        if ($request->has('name') && $request->has('email') && $request->has('password') && $request->has('fnacimiento'))
            {User::create([
                'name' => $request->input('name'),
                'email' => $request->input('email'),
                'password' => bcrypt($request->input('password')),
                'fnacimiento'=>$request->input('fnacimiento'),
                ]);
            return ['created' => true];
            }
        return ['created' => false, 'error' => "Faltan campos"];
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  uuid  $uuid
     * @return Response
     */
    public function update($uuid,Request $request)
    {

        $peticionario = auth()->guard('api')->user();
        $usuario=User::where('uuid',$uuid)->firstOrFail();

        if ($usuario== null)
            return ['error'=>"User not found"];
        if ($peticionario->uuid==$uuid)
            {
            if ($request->has('name'))
                $usuario ->name = $request -> input('name');
            if ($request->has('email'))
                $usuario ->email = $request -> input('email');
            if ($request->has('fnacimiento'))
                $usuario ->fnacimiento = $request -> input('fnacimiento');
            if ($request->has('password'))
                $usuario->password = bcrypt($request->input('password'));

            // Grabamos el usuario en la tabla.
            $usuario->save();
            return ['save'=>true];
        }

        // Esto sucede cuando el usuario que esta autenticado en la API intenta modificar otro usuario
        return ['save'=>false, 'error'=>"Estas intentando modificar otro usuario"];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  uuid  $uuid
     * @return Response
     */
    public function destroy($uuid)
    {
        if (auth()->guard('api')->user()->uuid == $uuid)
            {Auth::logout();
            User::where('uuid',$uuid)->delete();
            }

        return ['delete'=>false, 'error'=>"Estas intentando eliminar otro usuario"];
    }

}
