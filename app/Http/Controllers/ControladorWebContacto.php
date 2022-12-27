<?php

namespace App\Http\Controllers;
use App\Entidades\Sucursal;

use Illuminate\Http\Request;


class ControladorWebContacto extends Controller //permita que todos accedan sin tener una habilitacion de acceso
{
    public function index()
    {
        $pg='contacto';
        $sucursal = new Sucursal();
        $aSucursales = $sucursal->obtenerTodos();

        
        
            return view("web.contacto",compact('pg','aSucursales'));
    }

  public function enviar(Request $request){
    $nombre= $request->input('txtNombre');
    $celular=$request->input('txtTelefono');
    $correo=$request->input('txtCorreo');
    $mensaje=$request->input('txtMensaje');

    return redirect("/confirmacion-envio");
  }
 
    }
