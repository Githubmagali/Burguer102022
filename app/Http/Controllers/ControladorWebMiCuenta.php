<?php

namespace App\Http\Controllers;
use App\Entidades\Sucursal;


class ControladorWebMiCuenta extends Controller //permita que todos accedan sin tener una habilitacion de acceso
{
    public function index()
    {
        $pg='mi-cuenta';
        $sucursal = new Sucursal();
        $aSucursales = $sucursal->obtenerTodos();
        
            return view("web.mi-cuenta", compact('pg','aSucursales'));
    }
}