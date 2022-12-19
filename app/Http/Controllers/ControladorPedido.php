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

        if (Usuario::autenticado() == true) { //validación
            if (!Patente::autorizarOperacion("PEDIDOALTA")) { //otra validación
                $codigo = "PEDIDOALTA";
                $mensaje = "No tiene permisos para la operaci&oacute;n.";
                return view('sistema.pagina-error', compact('titulo', 'codigo', 'mensaje'));
            } else {
                $pedido = New Pedido();
                $sucursal = New Sucursal();
                $aSucursales = $sucursal->obtenerTodos();
                $cliente = New Cliente();
                $aClientes = $cliente->obtenerTodos();
                $estado = New Estado();
                $aEstados = $estado->obtenerTodos();
           
               return view( 'pedido.pedido-nuevo', compact ('titulo','pedido', 'aSucursales', 'aClientes', 'aEstados') );
            }
        } else {
            return redirect('admin/login');
        }
    }
    public function index()
    {
        $titulo = "Listado de pedidos";
        if (Usuario::autenticado() == true) {
            if (!Patente::autorizarOperacion("PEDIDOVER")) {
                $codigo = "PEDIDOVER";
                $mensaje = "No tiene permisos para la operaci&oacute;n.";
                return view('sistema.pagina-error', compact('titulo', 'codigo', 'mensaje'));
            } else {
                return view('pedido.pedido-listar', compact('titulo'));
            }
        } else {
            return redirect('admin/login');
        }
    }
    public function cargarGrilla()
    {
        $request = $_REQUEST;

        $entidad = new Pedido();
        $aPedidos = $entidad->obtenerFiltrado();

        $data = array();
        $cont = 0;

        $inicio = $request['start'];
        $registros_por_pagina = $request['length'];


        for ($i = $inicio; $i < count($aPedidos) && $cont < $registros_por_pagina; $i++) {
            $row = array();
            $row[] ="<a href='/admin/pedido/". $aPedidos[$i]->idpedido."'><i class='fa-solid fa-pencil'></i></a>";
            $row[] = date_format(date_create($aPedidos[$i]->fecha),"d/m/Y") ;
            $row[] = $aPedidos[$i]->descripcion;
            $row[] = "<a href='/admin/sucursal/".$aPedidos[$i]->fk_idsucursal."' class='btn btn-secundary'>".$aPedidos[$i]->sucursal."</a>";
            $row[] = "<a href='/admin/cliente/".$aPedidos[$i]->fk_idcliente."' class='btn btn-secundary'>".$aPedidos[$i]->cliente."</a>";
            $row[] = "<a href='/admin/estado/".$aPedidos[$i]->fk_idestado."' class='btn btn-secundary'>".$aPedidos[$i]->estado."</a>";
            $row[] = $aPedidos[$i]->total;
            $cont++;
            $data[] = $row;
        }
// formauna fila, lo adjunta en el array de data y json adjunta los datos del array conviertiendose en un json
        $json_data = array(
            "draw" => intval($request['draw']),
            "recordsTotal" => count($aPedidos), //cantidad total de registros sin paginar
            "recordsFiltered" => count($aPedidos), //cantidad total de registros en la paginacion
            "data" => $data
        );
        return json_encode($json_data);
    }
    public function guardar(Request $request) {
        try {
            //Define la entidad servicio
            $titulo = "Modificar pedido";
            $entidad = new Pedido();
            $entidad->cargarDesdeRequest($request); //agarra el request del formulario y lo carga al propio objeto

            if ($_FILES["archivo"]["error"] === UPLOAD_ERR_OK) { //Se adjunta imagen
                $extension = pathinfo($_FILES["archivo"]["name"], PATHINFO_EXTENSION);
                 $nombre = date("Ymdhmsi") . ".$extension";
                 $archivo = $_FILES["archivo"]["tmp_name"];
                 move_uploaded_file($archivo, env('APP_PATH') . "/public/files/$nombre"); //guardaelarchivo
                 $entidad->imagen = $nombre;
             }
            
            
            //validaciones
            if ($entidad->fk_idcliente == "" || $entidad->fecha == "") {
                $msg["ESTADO"] = MSG_ERROR;
                $msg["MSG"] = "Complete todos los datos";
            } else {
            
                if ($_POST["id"] > 0) {
                    //Es actualizacion
                    $productAnt = new Pedido();
                    $productAnt->obtenerPorId($entidad->idpedido);


                    if($_FILES["archivo"]["error"] === UPLOAD_ERR_OK){
                        //Eliminar imagen anterior
                        unlink("../public/files/$productAnt->imagen");                           
                    } else {
                        $entidad->imagen = $productAnt->imagen;
                    }

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
public function editar($id)
    {
        $titulo = "Modificar cliente";
        if (Usuario::autenticado() == true) {
            if (!Patente::autorizarOperacion("PEDIDOEDITAR")) {
                $codigo = "PEDIDOEDITAR";
                $mensaje = "No tiene pemisos para la operaci&oacute;n.";
                return view('sistema.pagina-error', compact('titulo', 'codigo', 'mensaje'));
            } else {
               
                

                $pedido = new Pedido();
                $pedido->obtenerPorId($id);

                return view('pedido.pedido-nuevo', compact('pedido', 'titulo'));
            }
        } else {
            return redirect('admin/login');
        }
}

public function eliminar(Request $request)
    {
        $id = $request->input('id');

        if (Usuario::autenticado() == true) {
            if (Patente::autorizarOperacion("PEDIDOBAJA")) {

              
                $entidad = new Pedido();
                $entidad->cargarDesdeRequest($request);
              
                $entidad->eliminar();

                $aResultado["err"] = EXIT_SUCCESS; //eliminado correctamente
            } else {
                $codigo = "PEDIDOBAJA";
                $aResultado["err"] = "No tiene pemisos para la operaci&oacute;n.";
            }
            echo json_encode($aResultado);
        } else {
            return redirect('admin/login');
        }
    }
}