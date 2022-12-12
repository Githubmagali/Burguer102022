<?php

namespace App\Http\Controllers;


class ControladorWebContacto extends Controller //permita que todos accedan sin tener una habilitacion de acceso
{
    public function index()
    {
            return view("web.contacto");
    }
}