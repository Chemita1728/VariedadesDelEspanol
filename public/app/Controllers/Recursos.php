<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\RecursosModel;

class Recursos extends BaseController
{
    protected $recursos;

    public function __construct()
    {
        $this->recursos = new RecursosModel();
    }

    public function index()
    {
        echo view('header');
        echo view('inicio');
        echo view('footer');
    }

    public function cargarVista($nombre,$data)
    {
        $vista = 'recursos/'.$nombre;
        echo view('header');
        echo view($vista, $data);
        echo view('footer');
    }

    public function nuevoRecurso()
    {
        $data = ['titulo' => 'Nuevo Recurso'];

        $this->cargarVista("nuevoRecurso",$data);
    }

    public function crearRecurso()
    {
        $title = $this->request->getPost('title');
        $description = $this->request->getPost('description');
        $font = $this->request->getPost('font');
        $variety = $this->request->getPost('variety');

        $autor = session('nombre'). " " .session('apellidos');

        $mensaje = 'Resultado:<br>';
        $data=(['','']);

        if (session('role') == 1){
            $this->recursos->insert(['title' => $title,
                                    'description' => $description,
                                    'state' => 1,
                                    'font' => $font,
                                    'variety' => $variety,
                                    'spanishlvl' => session('spanishlvl'),
                                    'autor' => $autor,
                                    'editor' => session('respMail'),
                                    'proposerMail' => session('email'),
                                    'publisherMail' => session('respMail')]);

            $mensaje = $mensaje . "-El recurso ha sido mandado para supervisión<br>";
        }
        if (session('role') > 1){
            $this->recursos->insert(['title' => $title,
                                    'description' => $description,
                                    'state' => 4,
                                    'font' => $font,
                                    'variety' => $variety,
                                    'spanishlvl' => session('spanishlvl'),
                                    'autor' => $autor,
                                    'editor' => session('email'),
                                    'proposerMail' => session('email'),
                                    'publisherMail' => session('email')]);

            $mensaje = $mensaje . "-El recurso se ha publicado<br>";
        }
        $session = session();
        $session->setFlashdata('msg',$mensaje);
        $this->cargarVista("nuevoRecurso",$data);
    }

    public function aRevisar()
    {

        $email = session('email');
        
        $recursos = $this->recursos->where('state', 1)
                                    ->orderBy("created_at", "asc")
                                    ->findAll();   
        
        // $mios=([]);
        // $otros=([]);

        foreach($recursos as $recurso){
            if( $recurso['editor'] == $email ){
                $mios[] = $recurso;
            } else {
                $otros[] = $recurso;
            }
        }
        foreach( $otros as $otro ){
            $mios[] = $otro;
        }
        

        $data = ['titulo' => 'Recursos a Revisar', 'recursos' => $mios];
        $this->cargarVista("aRevisar",$data);
    }
}

