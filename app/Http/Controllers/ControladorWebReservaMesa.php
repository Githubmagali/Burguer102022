<?php
namespace App\Http\Controllers;
use App\Entidades\Sucursal;
use Illuminate\Http\Request;


class ControladorWebReservaMesa extends Controller //permita que todos accedan sin tener una habilitacion de acceso
{
    public function index()
    {

        $pg= "reserva-mesa";
        $sucursal = new Sucursal();
        $aSucursales = $sucursal->obtenerTodos();
  
            return view("web.reserva-mesa", compact('pg', 'aSucursales'));
    }
}