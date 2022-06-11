<?php

namespace App\Controllers;
use App\Models\RecursosModel;

class Home extends BaseController
{

    protected $recursos;

    public function __construct()
    {
        $this->recursos = new RecursosModel();
    }

    public function index()
    {
        $recursos = $this->recursos->where('state', 4)
                                    ->orderBy("created_at", "asc")
                                    ->findAll();     

        $data = ['recursos' => $recursos];
        
        echo view('header');
        echo view('inicio', $data);
        echo view('footer');
    }
}
