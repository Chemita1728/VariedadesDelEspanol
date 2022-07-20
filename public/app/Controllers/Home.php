<?php

namespace App\Controllers;

class Home extends BaseController
{

    protected $recursos;

    public function __construct(){}

    public function index()
    {
        $data = [];
        echo view('header');
        echo view('inicio', $data);
        echo view('footer');
    }
}
