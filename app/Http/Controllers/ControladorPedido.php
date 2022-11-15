<?php

namespace App\Http\Controllers;

use App\Entidades\Pedido; //include_once "app/Entidades/Sistema/Menu.php";
use App\Entidades\Sucursal;
use App\Entidades\Cliente;
use App\Entidades\Estado;
use App\Entidades\Sistema\Patente;
use App\Entidades\Sistema\Usuario;
use Illuminate\Http\Request;

require app_path() . '/start/constants.php';

class ControladorPedido extends Controller
{
    public function nuevo()
    {
        $titulo = "Nuevo Pedido";

        $sucursal = new Sucursal();
        $aSucursales = $sucursal->obtenerTodos();

        $cliente = new Cliente();
        $aClientes = $cliente->obtenerTodos();

        $estado = new Estado();
        $aEstados = $estado->obtenerTodos();

        return view ('pedido.pedido-nuevo', compact('titulo','aSucursales','aClientes', 'aEstados')); //en la carpeta resurses->views tenemos lass vistas
       
    }
    public function index()
    {
        $titulo = "Listado de pedidos";
        if (Usuario::autenticado() == true) {
            if (!Patente::autorizarOperacion("MENUCONSULTA")) {
                $codigo = "MENUCONSULTA";
                $mensaje = "No tiene permisos para la operaci&oacute;n.";
                return view('sistema.pagina-error', compact('titulo', 'codigo', 'mensaje'));
            } else {
                return view('pedido.pedido-listar', compact('titulo'));
            }
        } else {
            return redirect('admin/login');
        }
    }
    public function guardar(Request $request) {
        try {
            //Define la entidad servicio
            $titulo = "Modificar pedido";
            $entidad = new Pedido();
            $entidad->cargarDesdeRequest($request); //agarra el request del formulario y lo carga al propio objeto

            //validaciones
            if ($entidad->nombre == "") {
                $msg["ESTADO"] = MSG_ERROR;
                $msg["MSG"] = "Complete todos los datos";
            } else {
            
                if ($_POST["id"] > 0) {
                    //Es actualizacion
                    $entidad->guardar();

                    $msg["ESTADO"] = MSG_SUCCESS;// msg_SUCCESS esta almacenado en app->providers->star->constants.php 
                    $msg["MSG"] = OKINSERT;
                } else {
                    //Es nuevo
                    $entidad->insertar();
                    $msg["MSG"] = OKINSERT;
                }
               
                $_POST["id"] = $entidad->idpedido;
                return view('pedido.pedido-listar', compact('titulo', 'msg'));
            }
        } catch (Exception $e) {
            $msg["ESTADO"] = MSG_ERROR;
            $msg["MSG"] = ERRORINSERT;
        }

        $id = $entidad->pedido;
        $pedido = new Pedido();
        $pedido->obtenerPorId($id);

        return view('pedido.pedido-nuevo', compact('msg', 'pedido', 'titulo')) . '?id=' . $pedido->idpedido;
}
}