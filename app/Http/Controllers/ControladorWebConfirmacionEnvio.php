<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;


class ControladorWebConfirmacionEnvio extends Controller //permita que todos accedan sin tener una habilitacion de acceso
{
    public function index()
    {

        $pg= "confirmacion-envio";
  
            return view("web.confirmacion-envio", compact('pg'));
    }
}