<?php

namespace App\Http\Controllers;
use App\Entidades\Sucursal;


class ControladorWebRecuperarClave extends Controller //permita que todos accedan sin tener una habilitacion de acceso
{
    public function index()
    {
        $pg='recuperar-clave';

        $sucursal = new Sucursal();
        $aSucursales = $sucursal->obtenerTodos();
        
            return view("web.recuperar-clave", compact('pg','aSucursales'));
    }
}