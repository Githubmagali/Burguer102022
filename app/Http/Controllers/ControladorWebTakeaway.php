<?php

namespace App\Http\Controllers;


class ControladorWebTakeaway extends Controller //permita que todos accedan sin tener una habilitacion de acceso
{
    public function index()
    {
            return view("web.takeaway");
    }
}