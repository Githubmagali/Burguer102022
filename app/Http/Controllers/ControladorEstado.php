<?php

namespace App\Http\Controllers;

use App\Entidades\Estado; //include_once "app/Entidades/Sistema/Menu.php";
use App\Entidades\Sistema\Patente;
use App\Entidades\Sistema\Usuario;
use Illuminate\Http\Request;

require app_path() . '/start/constants.php';

class ControladorEstado extends Controller
{
    public function nuevo()
    {
        $titulo = "Nuevo menú";
        return view ('estado.estado-nuevo', compact('titulo')); //en la carpeta resurses->views tenemos lass vistas
       
    }
}