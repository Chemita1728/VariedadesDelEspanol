<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UsuariosModel;

class Usuarios extends BaseController
{
    protected $usuarios;

    public function __construct()
    {
        $this->usuarios = new UsuariosModel();
    }

    //PAGINA DE USUARIOS
    public function index($activo = 1)
    {
        $rolRegistrado = session('role');
        
        if( $rolRegistrado == 3 ){
            $usuarios = $this->usuarios->where('activo',$activo)
                                        ->orderBy("role", "desc", "apellidos", "asc")
                                        ->findAll();
            $data = ['titulo' => 'Usuarios', 'datos' => $usuarios];
        } else {
            $usuarios = $this->usuarios->where('activo',$activo)
                                        ->where('role <>', 3)
                                        ->orderBy("role", "desc", "apellidos", "asc")
                                        ->findAll();
            $data = ['titulo' => 'Usuarios', 'datos' => $usuarios];
        }
        

        echo view('header');
        echo view('usuarios/usuarios', $data);
        echo view('footer');
    }
    /////////////////////////////////////////////

    //PAGINA DE USUARIOS QUE PERTENECEN A UN EXPERTO
    public function misColaboradores()
    {

        $responsable = session('email');
        $usuarios = $this->usuarios->where('respMail',$responsable)
                                    ->orderBy("apellidos", "asc")
                                    ->findAll();

        $data = ['titulo' => 'Usuarios', 'datos' => $usuarios];

        echo view('header');
        echo view('usuarios/usuarios', $data);
        echo view('footer');
    }
    /////////////////////////////////////////////

    //NUEVO USUARIO
    public function nuevoUsuario()
    {
        $data = ['titulo' => 'Nuevo Usuario'];

        echo view('header');
        echo view('usuarios/nuevoUsuario', $data);
        echo view('footer');
    }

    public function registroTemporal()
    {
        $nombre = $this->request->getPost('nombre');
        $apellidos = $this->request->getPost('apellidos');
        $email = $this->request->getPost('email');
        $respNombre = $this->request->getPost('respNombre');
        $respApellidos = $this->request->getPost('respApellidos');
        $respMail = $this->request->getPost('respMail');
        $tempId = rand(1, 9999999999);
        $num = $tempId;

        $this->usuarios->insert(['email' => $email,
                                    'nombre' => $nombre,
                                    'apellidos' => $apellidos,
                                    'role' => '1',
                                    'activo' => '0',
                                    'respMail' => $respMail,
                                    'tempId' => $num]);
        
        $data = (['email' => $email,
                    'nombre' => $nombre,
                    'apellidos' => $apellidos,
                    'respMail' => $respMail,
                    'respNombre' => $respNombre,
                    'respApellidos' => $respApellidos,
                    'tempId' => $num]);

        $controller = \Config\Services::email();
        $controller->setFrom($respMail, $respNombre. $respApellidos );
        $controller->setTo($email);

        $controller->setSubject('Solicitud de Registro');
        $vista = view('emails/mensaje', $data);
        $controller->setMessage($vista);

        
        if($controller->send()){
            echo("correo enviado");
        }
        else{
            echo("No se ha enviado");
        }
    }

    public function registroParaUsuario()
    {
        $tempId = $_GET["tempId"];
        $usuarios = $this->usuarios->where('tempId', $tempId)->first();
        $data = ['titulo' => 'Registro para el usuario', 'datos' => $usuarios];

        echo view('header');
        echo view('usuarios/registroParaUsuario', $data);
        echo view('footer');
    }

    public function insertar()
    {
        $password = password_hash( $this->request->getPost('password'), PASSWORD_DEFAULT );
        $this->usuarios->update( $this->request->getPost('id'),
                                    ['spanishlvl' => $this->request->getPost('spanishlvl'),
                                    'university' => $this->request->getPost('university'),
                                    'birthPlace' => $this->request->getPost('birthPlace'),
                                    'password' => $password,
                                    'active' => 1,
                                    'tempId' => 0 ]);        
        return redirect()->to(base_url());
    }

    /////////////////////////////////////////////
    
    //INICIAR SESION
    public function inicioSesion()
    {
        $data = ['titulo' => 'Inicio de Sesión'];

        echo view('header');
        echo view('usuarios/inicioSesion', $data);
        echo view('footer');
    }
    /////////////////////////////////////////////

    //PAGINA DATOS PERSONALES
    public function datosPersonales()
    {
        $usuario = $this->usuarios->where('id', session('id'))->first();
        $data = ['titulo' => 'Datos Personales', 'datos' => $usuario];

        echo view('header');
        echo view('usuarios/datosPersonales', $data);
        echo view('footer'); 
    }
    //PAGINA PARA CAMBIAR DATOS PERSONALES
    public function cambioDatosPersonales()
    {
        $usuario = $this->usuarios->where('id', session('id'))->first();
        $data = ['titulo' => 'Datos Personales', 'datos' => $usuario];

        echo view('header');
        echo view('usuarios/cambioDatosPersonales', $data);
        echo view('footer'); 
    }
    public function cambiarDatosPersonales()
    {
        $this->usuarios->update( session('id'),
                                    ['nombre' => $this->request->getPost('nombre'),
                                    'apellidos' => $this->request->getPost('apellidos'),
                                    'spanishlvl' => $this->request->getPost('spanishlvl'),
                                    'university' => $this->request->getPost('university'),
                                    'birthPlace' => $this->request->getPost('birthPlace')]);
        
        $usuario = $this->usuarios->where('id', session('id'))->first();
        $data = ['titulo' => 'Datos Personales', 'datos' => $usuario];
        echo view('header');
        echo view('usuarios/datosPersonales', $data);
        echo view('footer'); 
    }
    //PAGINA PARA CAMBIAR CONTRASEÑA PERSONAL
    public function cambioPassPersonal()
    {
        $id = session('id');
        $data = ['titulo' => 'Cambio Contraseña', 'id' => $id];

        echo view('header');
        echo view('usuarios/cambioPassPersonal', $data);
        echo view('footer'); 
    }
    public function cambiarPassPersonal()
    {
        $usuario = $this->usuarios->where('id', session('id'))->first();
        $antPass = $this->request->getPost('antPass');
        $nuevaPass = $this->request->getPost('nuevaPass');
        $nuevaPass2 = $this->request->getPost('nuevaPass2');
        
        if( password_verify($antPass, $usuario['password']) && $nuevaPass == $nuevaPass2 ){
            $password = password_hash( $nuevaPass, PASSWORD_DEFAULT );
            $this->usuarios->update( session('id'),['password' => $password]);
        }
        
        $usuario = $this->usuarios->where('id', session('id'))->first();
        $data = ['titulo' => 'Datos Personales', 'datos' => $usuario];
        echo view('header');
        echo view('usuarios/datosPersonales', $data);
        echo view('footer'); 
    }
    


    //EDICION DE USUARIOS QUE NO SON TU
    public function editar($id)
    {
        $usuario = $this->usuarios->where('id',$id)->first();
        $data = ['titulo' => 'Editar Usuario', 'datos' => $usuario];

        echo view('header');
        echo view('usuarios/editar', $data);
        echo view('footer'); 
    }

    public function actualizar()
    {
        $this->usuarios->update( $this->request->getPost('id'),
                                    ['nombre' => $this->request->getPost('nombre'),
                                    'apellidos' => $this->request->getPost('apellidos'),
                                    'spanishlvl' => $this->request->getPost('spanishlvl'),
                                    'university' => $this->request->getPost('university'),
                                    'birthPlace' => $this->request->getPost('birthPlace'),
                                    'role' => $this->request->getPost('role')]);
        return redirect()->to(base_url().'/usuarios');
    }

    public function eliminar($id)
    {
        $this->usuarios->update( $id, ['activo' => 0]);
        return redirect()->to(base_url().'/usuarios');
    }

    public function login()
    {
        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');
    
        $usuario = $this->usuarios->where('email',$email)->first();

        if(password_verify($password, $usuario['password'])){
        
            $data = [ "id" => $usuario['id'],
                        "email" => $usuario['email'],
                        "nombre" => $usuario['nombre'],
                        "apellidos" => $usuario['apellidos'],
                        "role" => $usuario['role'],
                        "spanishlvl" => $usuario['spanishlvl'],
                        "university" => $usuario['university'],
                        "birthPlace" => $usuario['birthPlace']
                    ];

            $session = session();
            $session->set($data);
            return redirect()->to(base_url('/'));
        
        } else {
            echo("no va");
            //return redirect()->to(base_url('/'));
        }
    }

    public function logout()
    {
        $session = session();
        $session->destroy();
        return redirect()->to(base_url('/'));
    }

}

