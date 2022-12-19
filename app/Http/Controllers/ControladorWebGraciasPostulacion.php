<?php

namespace App\Http\Controllers;
use App\Entidades\Sucursal;



class ControladorWebGraciasPostulacion extends Controller //permita que todos accedan sin tener una habilitacion de acceso
{
    public function index()
    {
        $pg = "login";
        $sucursal = new Sucursal();
        $aSucursales = $sucursal->obtenerTodos();
       


            return view("web.gracias-postulacion", compact('pg', 'aSucursales'));
    }
}