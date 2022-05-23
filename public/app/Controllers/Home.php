<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index()
    {
        echo view('header');
        //echo view('usuarios/usuarios');
        echo view('inicio');
        echo view('footer');
    }
}
