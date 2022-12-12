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
        $titulo = "Nuevo Estado";

        if (Usuario::autenticado() == true) { //validación
            if (!Patente::autorizarOperacion("ESTADOCONSULTA")) { //otra validación
                $codigo = "ESTADOCONSULTA";
                $mensaje = "No tiene permisos para la operaci&oacute;n.";
                return view('sistema.pagina-error', compact('titulo', 'codigo', 'mensaje'));
            } else {
                $estado = New Estado();
               return view( 'estado.estado-nuevo', compact ('titulo','estado') );
            }
        } else {
            return redirect('admin/login');
        }
    }
    public function index()
    {
        $titulo = "Listado de estados";
        if (Usuario::autenticado() == true) {
            if (!Patente::autorizarOperacion("ESTADOCONSULTA")) {
                $codigo = "ESTADOCONSULTA";
                $mensaje = "No tiene permisos para la operaci&oacute;n.";
                return view('sistema.pagina-error', compact('titulo', 'codigo', 'mensaje'));
            } else {
                return view('estado.estado-listar', compact('titulo'));
            }
        } else {
            return redirect('admin/login');
        }
    }
    public function cargarGrilla()
    {
        $request = $_REQUEST;

        $entidad = new Estado();
        $aEstados = $entidad->obtenerFiltrado();

        $data = array();
        $cont = 0;

        $inicio = $request['start'];
        $registros_por_pagina = $request['length'];


        for ($i = $inicio; $i < count($aEstados) && $cont < $registros_por_pagina; $i++) {
            $row = array();
            $row[] = $aEstados[$i]->nombre;
         
            $cont++;
            $data[] = $row;
        }
// formauna fila, lo adjunta en el array de data y json adjunta los datos del array conviertiendose en un json
        $json_data = array(
            "draw" => intval($request['draw']),
            "recordsTotal" => count($aEstados), //cantidad total de registros sin paginar
            "recordsFiltered" => count($aEstados), //cantidad total de registros en la paginacion
            "data" => $data,
        );
        return json_encode($json_data);
    }
    public function guardar(Request $request) {
        try {
            //Define la entidad servicio
            $titulo = "Modificar estado";
            $entidad = new Estado();
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

                    $productAnt = new Estado();
                    $productAnt->obtenerPorId($entidad->idestado);

                    

                    $entidad->guardar();

                    $msg["ESTADO"] = MSG_SUCCESS;// msg_SUCCESS esta almacenado en app->providers->star->constants.php 
                    $msg["MSG"] = OKINSERT;
                } else {
                    //Es nuevo
                    $entidad->insertar();
                    $msg["MSG"] = OKINSERT;
                }
               
                $_POST["id"] = $entidad->idestado;
                return view('estado.estado-listar', compact('titulo', 'msg'));
            }
        } catch (Exception $e) {
            $msg["ESTADO"] = MSG_ERROR;
            $msg["MSG"] = ERRORINSERT;
        }

        $id = $entidad->estado;
        $estado = new Estado();
        $estado->obtenerPorId($id);

        return view('estado.estado-nuevo', compact('msg', 'estado', 'titulo')) . '?id=' . $estado->idestado;

    }
    public function editar($id)
    {
        $titulo = "Modificar cliente";
        if (Usuario::autenticado() == true) {
            if (!Patente::autorizarOperacion("ESTADOEDITAR")) {
                $codigo = "ESTADOEDITAR";
                $mensaje = "No tiene pemisos para la operaci&oacute;n.";
                return view('sistema.pagina-error', compact('titulo', 'codigo', 'mensaje'));
            } else {
               
             $estado = new Estado();
                $estado->obtenerPorId($id);
                return view('estado.estado-nuevo', compact('estado', 'titulo'));
            }
        } else {
            return redirect('admin/login');
        }
    

}
public function eliminar(Request $request)
    {
        $id = $request->input('id');

        if (Usuario::autenticado() == true) {
            if (Patente::autorizarOperacion("ESTADOBAJA")) {

              
                $entidad = new Estado();
                $entidad->cargarDesdeRequest($request);
                              
                $entidad->eliminar();

                $aResultado["err"] = EXIT_SUCCESS; //eliminado correctamente
            } else {
                $codigo = "ESTADOBAJA";
                $aResultado["err"] = "No tiene pemisos para la operaci&oacute;n.";
            }
            echo json_encode($aResultado);
        } else {
            return redirect('admin/login');
        }
    }

}