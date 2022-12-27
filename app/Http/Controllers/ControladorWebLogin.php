<?php

namespace App\Http\Controllers;
use App\Entidades\Sucursal;
use App\Entidades\Cliente;
use Illuminate\Http\Request;

class ControladorWebLogin extends Controller //permita que todos accedan sin tener una habilitacion de acceso
{
    public function index()
    {
        $pg = "login";
        $sucursal = new Sucursal();
        $aSucursales = $sucursal->obtenerTodos();


            return view("web.login", compact('pg','aSucursales'));
    }
   public function ingresar(Request $request){
        $correo = $request->input('txtCorreo');
        $clave = $request->input('txtClave');

$cliente =new Cliente();
$cliente->obtenerPorCorreo($correo);
if($cliente->idcliente > 0 && password_verify($clave, $cliente->clave)){ //si cliente es mayor o igual que cero es porque encontro algo
 return redirect("/mi-cuenta");
   }else {
    $msg="Usuario o clave incorrecta";
    
    $sucursal = new Sucursal();
    $aSucursales = $sucursal->obtenerTodos();
    return view("web.login", compact('msg', 'aSucursales')); //al redirect no podemos pasar variable via compact
}
   }
}