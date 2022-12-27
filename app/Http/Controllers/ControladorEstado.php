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
            if (!Patente::autorizarOperacion("ESTADOALTA")) { //otra validación
                $codigo = "ESTADOALTA";
                $mensaje = "No tiene permisos para la operaci&oacute;n.";
                return view('sistema.pagina-error', compact('titulo', 'codigo', 'mensaje'));
            } else {
                 $estado = New Estado();
               return view( 'estado.estado-nuevo', compact ('titulo','estado'));
            }
        } else {
            return redirect('admin/login');
        }
    }
    public function index() //carga la pantlla
    {
        $titulo = "Listado de estados";
        if (Usuario::autenticado() == true) {
            if (!Patente::autorizarOperacion("ESTADOCONSULTA")) { //consulta si tiene el permiso
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

        $entidad = new Estado(); //primero vamosa la base de datos
        $aEstados = $entidad->obtenerFiltrado(); //llama al metodo para que me devuelva los datos figurados
//def en la entidad cliente
        $data = array();
        $cont = 0; //le devuelve los datos del array recorrido
        //tenemos que armar el json solo la cantidad de registros indicada

        $inicio = $request['start']; //de donde va a empezar
        $registros_por_pagina = $request['length']; //cant de registros por pag


        for ($i = $inicio; $i < count($aEstados) && $cont < $registros_por_pagina; $i++) {
            $row = array(); //el inicio lo calcula la grilla y lo va a hacer mientras alla la cant
            //de clientes posibles y ademas sea la cant de clientes a mostrar
            $row[] = "<a href= '/admin/estado/" . $aEstados[$i]->idestado. "'class='btn btn-secondary'><i class='fa-solid fa-pencil'></i></a>";
           
           
            $cont++; //crea una fila con datos
            $data[] = $row; //lo agrega a data, despues lo adjunta en el json
        }

        $json_data = array( //json pide que tenga esta serie de datos
            "draw" => intval($request['draw']),
            "recordsTotal" => count($aEstados), //cantidad total de registros sin paginar
            "recordsFiltered" => count($aEstados), //cantidad total de registros en la paginacion
            "data" => $data, //datos del array
        );
        return json_encode($json_data); //devuelve el json convertido
    }

  

    public function guardar(Request $request) {
        try {
            //Define la entidad servicio
            $titulo = "Modificar Estado";
            $entidad = new Estado();
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
    public function editar($id) //viene el id por parametro
    {
        $titulo = "Modificar estado";
        if (Usuario::autenticado() == true) { //pregunta si el usuario esta autenticado ya que no cualquiera puede editar
            if (!Patente::autorizarOperacion("ESTADOEDITAR")) {
                $codigo = "ESTADOEDITAR";
                $mensaje = "No tiene pemisos para la operaci&oacute;n.";
                return view('sistema.pagina-error', compact('titulo', 'codigo', 'mensaje'));
            } else {
               
                $estado = new Estado(); //va a la base de datos
                $estado->obtenerPorId($id); //busca por el id que vino por parametro que lo envio la hoja de rutar

                return view('estado.estado-nuevo', compact('menu', 'titulo'));
            }
        } else {
            return redirect('admin/login');
        }
    }

    public function eliminar(Request $request) //el eliminar viaja por ajax y se puede ver en la consola de la pagina 'Red'
    {
        $id = $request->input('id'); //recupera el id que vino por la querystream por la propiedad $request

        if (Usuario::autenticado() == true) { //pregunata si el usuario esta autenticado porque no cualquiera pueda eliminar
            if (Patente::autorizarOperacion("ESTADOBAJA")) {

              
                $entidad = new Estado(); //llama a la entidad
                $entidad->cargarDesdeRequest($request);
                $entidad->eliminar();
               
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