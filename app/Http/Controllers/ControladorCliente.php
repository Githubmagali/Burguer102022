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
        
        $titulo = "Nuevo Cliente";
        if (Usuario::autenticado() == true) { //validación
            if (!Patente::autorizarOperacion("CLIENTECONSULTA")) { //otra validación
                $codigo = "CLIENTECONSULTA";
                $mensaje = "No tiene permisos para la operaci&oacute;n.";
                return view('sistema.pagina-error', compact('titulo', 'codigo', 'mensaje'));
            } else {
                
                $cliente = New Cliente();
               return view( 'cliente.cliente-nuevo', compact ('titulo','cliente') );
            }
        } else {
            return redirect('admin/login');
        }
    }
    public function index() //carga la pantlla
    {
        $titulo = "Listado de cliente";
        if (Usuario::autenticado() == true) {
            if (!Patente::autorizarOperacion("CLIENTECONSULTA")) { //consulta si tiene el permiso
                $codigo = "CLIENTECONSULTA";
                $mensaje = "No tiene permisos para la operaci&oacute;n.";
                return view('sistema.pagina-error', compact('titulo', 'codigo', 'mensaje'));
            } else {
                return view('cliente.cliente-listar', compact('titulo'));
            }
        } else {
            return redirect('admin/login');
        }
    }

    public function cargarGrilla()
    {
        $request = $_REQUEST;

        $entidad = new Cliente();
        $aClientes = $entidad->obtenerFiltrado();

        $data = array();
        $cont = 0;

        $inicio = $request['start'];
        $registros_por_pagina = $request['length'];


        for ($i = $inicio; $i < count($aClientes) && $cont < $registros_por_pagina; $i++) {
            $row = array();
            $row[] = "<a href= '/admin/cliente/" . $aClientes[$i]->idcliente."' class='btn btn-secondary'><i class='fa-solid fa-pencil'></i></a>";
            $row[] = $aClientes[$i]->nombre . "". $aClientes[$i]->apellido;
            $row[] = $aClientes[$i]->dni;
            $row[] = $aClientes[$i]->correo;
            $row[] = $aClientes[$i]->celular;
            $cont++;
            $data[] = $row;
        }

        $json_data = array(
            "draw" => intval($request['draw']),
            "recordsTotal" => count($aClientes), //cantidad total de registros sin paginar
            "recordsFiltered" => count($aClientes), //cantidad total de registros en la paginacion
            "data" => $data,
        );
        return json_encode($json_data);
    }

  

    public function guardar(Request $request) {
        try {
            //Define la entidad servicio
            $titulo = "Modificar Cliente";
            $entidad = new  Cliente();
            $entidad->cargarDesdeRequest($request); //agarra el request del formulario y lo carga al propio objeto


            if ($_FILES["archivo"]["error"] === UPLOAD_ERR_OK) { //Se adjunta imagen
                $extension = pathinfo($_FILES["archivo"]["name"], PATHINFO_EXTENSION);
                 $nombre = date("Ymdhmsi") . ".$extension";
                 $archivo = $_FILES["archivo"]["tmp_name"];
                 move_uploaded_file($archivo, env('APP_PATH') . "/public/files/$nombre"); //guardaelarchivo
                 $entidad->imagen = $nombre;
             }
            //validaciones
            if ($entidad->nombre == "") {
                $msg["ESTADO"] = MSG_ERROR;
                $msg["MSG"] = "Complete todos los datos";
            } else {
                if ($_POST["id"] > 0) {
                    //Es actualizacion
                    $productAnt = new Cliente();
                    $productAnt->obtenerPorId($entidad->idcliente);


                    if($_FILES["archivo"]["error"] === UPLOAD_ERR_OK){
                        //Eliminar imagen anterior
                        @unlink(env('APP_PATH') . "/public/files/$productAnt->imagen");                            
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
               
                $_POST["id"] = $entidad->idcliente;
                return view('cliente.cliente-listar', compact('titulo', 'msg'));
            }
        } catch (Exception $e) {
            $msg["ESTADO"] = MSG_ERROR;
            $msg["MSG"] = ERRORINSERT;
        }

        $id = $entidad->cliente;
        $cliente = new Cliente();
        $cliente->obtenerPorId($id);

        return view('cliente.cliente-nuevo', compact('msg', 'cliente', 'titulo')) . '?id=' . $cliente->idcliente;

    }
    public function editar($id)
    {
        $titulo = "Modificar cliente";
        if (Usuario::autenticado() == true) {
            if (!Patente::autorizarOperacion("CLIENTEEDITAR")) {
                $codigo = "CLIENTEEDITAR";
                $mensaje = "No tiene pemisos para la operaci&oacute;n.";
                return view('sistema.pagina-error', compact('titulo', 'codigo', 'mensaje'));
            } else {
               
                

                $cliente = new Cliente();
                $cliente->obtenerPorId($id);

                return view('cliente.cliente-nuevo', compact('menu', 'titulo'));
            }
        } else {
            return redirect('admin/login');
        }
    }

    public function eliminar(Request $request)
    {
        $id = $request->input('id');

        if (Usuario::autenticado() == true) {
            if (Patente::autorizarOperacion("CLIENTEELIMINAR")) {

              
                $entidad = new Cliente();
                $entidad->cargarDesdeRequest($request);
                $entidad->eliminar();
               
                $entidad->eliminar();

                $aResultado["err"] = EXIT_SUCCESS; //eliminado correctamente
            } else {
                $codigo = "CLIENTEELIMINAR";
                $aResultado["err"] = "No tiene pemisos para la operaci&oacute;n.";
            }
            echo json_encode($aResultado);
        } else {
            return redirect('admin/login');
        }
    }


}