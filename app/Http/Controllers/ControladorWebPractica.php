<?php

namespace App\Http\Controllers;
use App\Entidades\Sucursal;
use App\Entidades\Cliente;

use Illuminate\Http\Request;


class ControladorWebPractica extends Controller //permita que todos accedan sin tener una habilitacion de acceso
{
    public function index()
    {
        $pg='practica';
        $sucursal = new Sucursal();
        $aSucursales = $sucursal->obtenerTodos();

        $cliente = new Cliente();
        $aClientes = $cliente->obtenerTodos();
        
        
            return view("web.practica",compact('pg','aSucursales', 'aClientes'));
    }

 
    }