<?php

namespace App\Http\Controllers;

use App\Entidades\Cliente; //include_once "app/Entidades/Sistema/Menu.php";
use App\Entidades\Sistema\Patente;
use App\Entidades\Sistema\Usuario;
use Illuminate\Http\Request;

require app_path() . '/start/constants.php';

class ControladorCliente extends Controller
{
    public function nuevo()
    {
        $titulo = "Nuevo menú";
        return view ('cliente.cliente-nuevo', compact('titulo')); //en la carpeta resurses->views tenemos lass vistas
       
    }
}