<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;


class ControladorWebNuevoRegistro extends Controller //permita que todos accedan sin tener una habilitacion de acceso
{
    public function index()
    {

        $pg= "nuevo-registro";
  
            return view("web.nuevo-registro", compact('pg'));
    }
}