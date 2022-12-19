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
            if (!Patente::autorizarOperacion("CLIENTEALTA")) { //otra validación
                $codigo = "CLIENTEALTA";
                $mensaje = "No tiene permisos para la operaci&oacute;n.";
                return view('sistema.pagina-error', compact('titulo', 'codigo', 'mensaje'));
            } else {
                 $cliente = New Cliente();
               return view( 'cliente.cliente-nuevo', compact ('titulo','cliente'));
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

        $entidad = new Cliente(); //primero vamosa la base de datos
        $aClientes = $entidad->obtenerFiltrado(); //llama al metodo para que me devuelva los datos figurados
//def en la entidad cliente
        $data = array();
        $cont = 0; //le devuelve los datos del array recorrido
        //tenemos que armar el json solo la cantidad de registros indicada

        $inicio = $request['start']; //de donde va a empezar
        $registros_por_pagina = $request['length']; //cant de registros por pag


        for ($i = $inicio; $i < count($aClientes) && $cont < $registros_por_pagina; $i++) {
            $row = array(); //el inicio lo calcula la grilla y lo va a hacer mientras alla la cant
            //de clientes posibles y ademas sea la cant de clientes a mostrar
            $row[] = "<a href= '/admin/cliente/" . $aClientes[$i]->idcliente. "'class='btn btn-secondary'><i class='fa-solid fa-pencil'></i></a>";
            $row[] = $aClientes[$i]->nombre . "". $aClientes[$i]->apellido;
            $row[] = $aClientes[$i]->dni;
            $row[] = $aClientes[$i]->correo;
            $row[] = $aClientes[$i]->celular;
            $cont++; //crea una fila con datos
            $data[] = $row; //lo agrega a data, despues lo adjunta en el json
        }

        $json_data = array( //json pide que tenga esta serie de datos
            "draw" => intval($request['draw']),
            "recordsTotal" => count($aClientes), //cantidad total de registros sin paginar
            "recordsFiltered" => count($aClientes), //cantidad total de registros en la paginacion
            "data" => $data, //datos del array
        );
        return json_encode($json_data); //devuelve el json convertido
    }

  

    public function guardar(Request $request) {
        try {
            //Define la entidad servicio
            $titulo = "Modificar Cliente";
            $entidad = new  Cliente();
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
    public function editar($id) //viene el id por parametro
    {
        $titulo = "Modificar cliente";
        if (Usuario::autenticado() == true) { //pregunta si el usuario esta autenticado ya que no cualquiera puede editar
            if (!Patente::autorizarOperacion("CLIENTEEDITAR")) {
                $codigo = "CLIENTEEDITAR";
                $mensaje = "No tiene pemisos para la operaci&oacute;n.";
                return view('sistema.pagina-error', compact('titulo', 'codigo', 'mensaje'));
            } else {
               
                $cliente = new Cliente(); //va a la base de datos
                $cliente->obtenerPorId($id); //busca por el id que vino por parametro que lo envio la hoja de rutar

                return view('cliente.cliente-nuevo', compact('menu', 'titulo'));
            }
        } else {
            return redirect('admin/login');
        }
    }

    public function eliminar(Request $request) //el eliminar viaja por ajax y se puede ver en la consola de la pagina 'Red'
    {
        $id = $request->input('id'); //recupera el id que vino por la querystream por la propiedad $request

        if (Usuario::autenticado() == true) { //pregunata si el usuario esta autenticado porque no cualquiera pueda eliminar
            if (Patente::autorizarOperacion("CLIENTEELIMINAR")) {

              
                $entidad = new Cliente(); //llama a la entidad
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