<?php

namespace App\Http\Controllers;

use App\Entidades\Categoria;
use App\Entidades\Sistema\Patente;
use App\Entidades\Sistema\Usuario;
use Illuminate\Http\Request;

require app_path() . '/start/constants.php';

class ControladorCategoria extends Controller
{
    public function nuevo()
    {   
        
        $titulo = "Nuevo Categoria";
        if (Usuario::autenticado() == true) { //validación
            if (!Patente::autorizarOperacion("CATEGORIAALTA")) { //otra validación
                $codigo = "CATEGORIAALTA";
                $mensaje = "No tiene permisos para la operaci&oacute;n.";
                return view('sistema.pagina-error', compact('titulo', 'codigo', 'mensaje'));
            } else {
                 $cliente = New Categoria();
               return view( 'categoria.categoria-nuevo', compact ('titulo','categoria'));
            }
        } else {
            return redirect('admin/login');
        }
    }
    public function index() //carga la pantlla
    {
        $titulo = "Listado de categoria";
        if (Usuario::autenticado() == true) {
            if (!Patente::autorizarOperacion("CATEGORIACONSULTA")) { //consulta si tiene el permiso
                $codigo = "CATEGORIACONSULTA";
                $mensaje = "No tiene permisos para la operaci&oacute;n.";
                return view('sistema.pagina-error', compact('titulo', 'codigo', 'mensaje'));
            } else {
                return view('categoria.categoria-listar', compact('titulo'));
            }
        } else {
            return redirect('admin/login');
        }
    }

    public function cargarGrilla()
    {
        $request = $_REQUEST;

        $entidad = new Categoria(); //primero vamosa la base de datos
        $aCategorias = $entidad->obtenerFiltrado(); //llama al metodo para que me devuelva los datos figurados
//def en la entidad cliente
        $data = array();
        $cont = 0; //le devuelve los datos del array recorrido
        //tenemos que armar el json solo la cantidad de registros indicada

        $inicio = $request['start']; //de donde va a empezar
        $registros_por_pagina = $request['length']; //cant de registros por pag


        for ($i = $inicio; $i < count($aCategorias) && $cont < $registros_por_pagina; $i++) {
            $row = array(); //el inicio lo calcula la grilla y lo va a hacer mientras alla la cant
            //de clientes posibles y ademas sea la cant de clientes a mostrar
            $row[] = "<a href= '/admin/cliente/" . $aCategorias[$i]->idcategoria. "'class='btn btn-secondary'><i class='fa-solid fa-pencil'></i></a>";
            $row[] = $aCategorias[$i]->nombre . "". $aCategorias[$i]->apellido;
            $row[] = $aCategorias[$i]->dni;
            $row[] = $aCategorias[$i]->correo;
            $row[] = $aCategorias[$i]->celular;
            $cont++; //crea una fila con datos
            $data[] = $row; //lo agrega a data, despues lo adjunta en el json
        }

        $json_data = array( //json pide que tenga esta serie de datos
            "draw" => intval($request['draw']),
            "recordsTotal" => count($aCategorias), //cantidad total de registros sin paginar
            "recordsFiltered" => count($aCategorias), //cantidad total de registros en la paginacion
            "data" => $data, //datos del array
        );
        return json_encode($json_data); //devuelve el json convertido
    }

  

    public function guardar(Request $request) {
        try {
            //Define la entidad servicio
            $titulo = "Modificar Cliente";
            $entidad = new  Categoria();
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
               
                $_POST["id"] = $entidad->idcategoria;
                return view('categoria.categoria-listar', compact('titulo', 'msg'));
            }
        } catch (Exception $e) {
            $msg["ESTADO"] = MSG_ERROR;
            $msg["MSG"] = ERRORINSERT;
        }

        $id = $entidad->categoria;
        $categoria = new Categoria(); 
        $categoria->obtenerPorId($id);

        return view('categoria.categoria-nuevo', compact('msg', 'categoria', 'titulo')) . '?id=' . $cliente->idcliente;

    }
    public function editar($id) //viene el id por parametro
    {
        $titulo = "Modificar categoria";
        if (Usuario::autenticado() == true) { //pregunta si el usuario esta autenticado ya que no cualquiera puede editar
            if (!Patente::autorizarOperacion("CATEGORIAEDITAR")) {
                $codigo = "CATEGORIAEDITAR";
                $mensaje = "No tiene pemisos para la operaci&oacute;n.";
                return view('sistema.pagina-error', compact('titulo', 'codigo', 'mensaje'));
            } else {
               
                $categoria = new Categoria(); //va a la base de datos
                $categoria->obtenerPorId($id); //busca por el id que vino por parametro que lo envio la hoja de rutar

                return view('categoria.categoria-nuevo', compact('menu', 'titulo'));
            }
        } else {
            return redirect('admin/login');
        }
    }

    public function eliminar(Request $request) //el eliminar viaja por ajax y se puede ver en la consola de la pagina 'Red'
    {
        $id = $request->input('id'); //recupera el id que vino por la querystream por la propiedad $request

        if (Usuario::autenticado() == true) { //pregunata si el usuario esta autenticado porque no cualquiera pueda eliminar
            if (Patente::autorizarOperacion("CATEGORIAELIMINAR")) {

              
                $entidad = new Categoria(); //llama a la entidad
                $entidad->cargarDesdeRequest($request);
                $entidad->eliminar();
               
                $entidad->eliminar();

                $aResultado["err"] = EXIT_SUCCESS; //eliminado correctamente
            } else {
                $codigo = "CATEGORIAELIMINAR";
                $aResultado["err"] = "No tiene pemisos para la operaci&oacute;n.";
            }
            echo json_encode($aResultado);
        } else {
            return redirect('admin/login');
        }
    }


}