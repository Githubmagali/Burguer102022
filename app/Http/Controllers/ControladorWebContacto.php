<?php

namespace App\Http\Controllers;
use App\Entidades\Sucursal;
use App\Entidades\Postulacion;
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

  
 
    }
