<?php
namespace App\Http\Controllers;
use App\Entidades\Cliente;
use App\Entidades\Sucursal;
use Illuminate\Http\Request;


class ControladorWebNuevoRegistro extends Controller //permita que todos accedan sin tener una habilitacion de acceso
{
    public function index()
    {

        $pg= "nuevo-registro";
        $cliente= new Cliente();
        $aClientes = $cliente->obtenerTodos();

        $sucursal= new Sucursal();
        $aSucursales = $sucursal->obtenerTodos();
  
            return view("web.nuevo-registro", compact('pg', 'aClientes', 'aSucursales'));
    }

    public function enviar(Request $request){
        $nombre = $request->input('txtNombre');
        $apellido = $request->input('txtApellido');
        $correo = $request->input('txtCorreo');
        $dni= $request->input('txtDni');
        $celular= $request->input('txtCelular');
        $clave= $request->input('txtClave');

        $cliente = new Cliente();
        $cliente->nombre = $nombre;
        $cliente->apellido = $apellido;
        $cliente->correo = $correo;
        $cliente->dni = $dni;
        $cliente->celular= $celular;
        $clave->nombre = password_hash($clave, PASSWORD_DEFAULT);
        $cliente->insertar();

        return redirect("/login");
    }
}