<?php

namespace App\Http\Controllers;
use App\Entidades\Producto;
use App\Entidades\Categoria;
use App\Entidades\Sucursal;
use Session;


class ControladorWebTakeaway extends Controller //permita que todos accedan sin tener una habilitacion de acceso
{
    public function index()
    {
        $pg = "takeaway";
        $producto = new Producto();
        $aProductos = $producto->obtenerTodos();

        $categoria = new Categoria();
        $aCategorias = $categoria->obtenerTodos();

        $sucursal = new Sucursal();
        $aSucursales = $sucursal->obtenerTodos();

        
return view("web.takeaway", compact('pg', 'aProductos','aCategorias', 'aSucursales'));

            
    }
}