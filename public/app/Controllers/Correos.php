<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class Correos extends BaseController
{

    public function __construct(){}

    /**
     * It sends an email to the user with the data that the user has entered.
     */
    public function sendMail()
    {
        $nombre = $this->request->getPost('nombre');
        $apellidos = $this->request->getPost('apellidos');
        $email = $this->request->getPost('email');
        $respNombre = $this->request->getPost('respNombre');
        $respApellidos = $this->request->getPost('respApellidos');
        $respMail = $this->request->getPost('respMail');

        $data = (['nombre' => $nombre,
                    'apellidos' => $apellidos,
                    'email' => $email,
                    'respNombre' => $respNombre,
                    'respApellidos' => $respApellidos,
                    'respMail' => $respMail]);

        $controller = \Config\Services::email();
        $controller->setFrom($respMail, $respNombre. $respApellidos );
        $controller->setTo($email);

        $controller->setSubject('Solicitud de Registro');
        $vista = view('emails/mensaje', $data);
        $controller->setMessage($vista);

        
        if($controller->send()){
            echo("correo enviado");
            echo($nombre);
        }
        else{
            echo("No se ha enviado");
        }
    }
}

