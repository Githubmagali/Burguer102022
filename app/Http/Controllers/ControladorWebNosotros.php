<?php

namespace App\Http\Controllers;
use App\Entidades\Sucursal;
use App\Entidades\Postulacion;
use Illuminate\Http\Request;


class ControladorWebNosotros extends Controller //permita que todos accedan sin tener una habilitacion de acceso
{
    public function index()
    {
        $pg='nosotros';
        $sucursal = new Sucursal();
        $aSucursales = $sucursal->obtenerTodos();
        $postulacion= new Postulacion();
        $aPostulaciones = $sucursal->obtenerTodos();


            return view("web.nosotros", compact('pg','aSucursales', 'aPostulaciones'));
    }
    public function enviar(Request $request){ //colocamos los datos que enviamos, recorda ubicarlo en la ruta via POST
        $nombre= $request->input('TxtNombre');
        $apellido= $request->input('TxtApellido');
        $celular= $request->input('TxtCelular');
        $correo= $request->input('TxtCorreo');
        
         $postulacion = new Postulacion(); //toda la info va a estar almacenada aca por ende creamos este objeto
           $postulacion->nombre =$nombre;
           $postulacion->apellido= $apellido;
           $postulacion->celular=$celular;
           $postulacion->correo=$correo;
           $postulacion->curriculum="";
           $postulacion->insertar(); //ejecuta insertar en la base de datos con todos los datos que tiene
        
    return redirect("/gracias-postulacion");

        }
        
   

}

