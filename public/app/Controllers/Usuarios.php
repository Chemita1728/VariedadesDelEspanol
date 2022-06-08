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

    public function index()
    {
        echo view('header');
        echo view('inicio');
        echo view('footer');
    }

    public function cargarVista($nombre,$data)
    {
        $vista = 'usuarios/'.$nombre;
        echo view('header');
        echo view($vista, $data);
        echo view('footer');
    }
    
    //PAGINA DE USUARIOS ACTIVOS
    public function activos()
    {
        $rolRegistrado = session('role');
        $mailRegistrado = session('email');
        
        if( $rolRegistrado == 3 ){
            $usuarios = $this->usuarios->where('activo', 1)
                                        ->where('email <>', $mailRegistrado)
                                        ->orderBy("role", "asc", "respMail", "asc", "apellidos", "asc")
                                        ->findAll();   
        } else {
            $usuarios = $this->usuarios->where('activo', 1)
                                        ->where('email <>', $mailRegistrado)
                                        ->where('role <>', 3)
                                        ->orderBy("role", "asc", "respMail", "asc", "apellidos", "asc")
                                        ->findAll();
        }

        foreach($usuarios as $usuario){
            if( $usuario['respMail'] ==  $mailRegistrado ){
                $mios[] = $usuario;
            } else {
                $otros[] = $usuario;
            }
        }
        foreach( $otros as $otro ){
            $mios[] = $otro;
        }


        $tipo = (['funcion' => 0, 'flecha' => 'fa-arrow-down']);
        $data = ['titulo' => 'Usuarios', 'datos' => $mios, 'tipo' => $tipo];

        $this->cargarVista("usuarios",$data);
    }

    //PAGINA DE USUARIOS NO ACTIVOS
    public function noActivos()
    {
        $rolRegistrado = session('role');
        $mailRegistrado = session('email');
        
        if( $rolRegistrado == 3 ){
            $usuarios = $this->usuarios->where('activo', 0)
                                        ->where('tempId', 0)
                                        ->where('email <>', $mailRegistrado)
                                        ->orderBy("role", "asc", "apellidos", "asc")
                                        ->findAll();   
        } else {
            $usuarios = $this->usuarios->where('activo', 0)
                                        ->where('tempId', 0)
                                        ->where('email <>', $mailRegistrado)
                                        ->where('role <>', 3)
                                        ->orderBy("role", "asc", "apellidos", "asc")
                                        ->findAll();
        }

        $tipo = (['funcion' => 1, 'flecha' => 'fa-arrow-up']);
        $data = ['titulo' => 'Usuarios No Activos', 'datos' => $usuarios, 'tipo' => $tipo];

        $this->cargarVista("usuarios",$data);
    }

    public function buscarActivo()
    {
        $rolRegistrado = session('role');
        $mailRegistrado = session('email');
        $busqueda = $this->request->getPost('info');
        $dondeBuscar = $this->request->getPost('donde');

        if( $rolRegistrado == 3 ){
            $usuarios = $this->usuarios->where('activo', 1)
                                        ->where('email <>', $mailRegistrado)
                                        ->like($dondeBuscar, $busqueda)
                                        ->orderBy("role", "desc", "apellidos", "asc")
                                        ->findAll();
        } else {
            $usuarios = $this->usuarios->where('activo', 1)
                                        ->where('email <>', $mailRegistrado)
                                        ->where('role <>', 3)
                                        ->like($dondeBuscar, $busqueda)
                                        ->orderBy("role", "asc", "apellidos", "asc")
                                        ->findAll();
        }

        $titulo = 'Usuarios que contienen "' . $busqueda .'"';
        $tipo = (['funcion' => 0, 'flecha' => 'fa-arrow-down']);
        $titulo = 'Usuarios Activos que contienen "' . $busqueda .'"';
        $data = ['titulo' => $titulo, 'datos' => $usuarios, 'tipo' => $tipo];

        $this->cargarVista("usuarios",$data);
    }
    public function buscarNoActivo()
    {
        $rolRegistrado = session('role');
        $mailRegistrado = session('email');
        $busqueda = $this->request->getPost('info');
        $dondeBuscar = $this->request->getPost('donde');

        if( $rolRegistrado == 3 ){
            $usuarios = $this->usuarios->where('activo', 0)
                                        ->where('tempId', 0)
                                        ->where('email <>', $mailRegistrado)
                                        ->like($dondeBuscar, $busqueda)
                                        ->orderBy("role", "desc", "apellidos", "asc")
                                        ->findAll();
        } else {
            $usuarios = $this->usuarios->where('activo', 0)
                                        ->where('tempId', 0)
                                        ->where('email <>', $mailRegistrado)
                                        ->where('role <>', 3)
                                        ->like($dondeBuscar, $busqueda)
                                        ->orderBy("role", "asc", "apellidos", "asc")
                                        ->findAll();
        }
        $titulo = 'Usuarios que contienen "' . $busqueda .'"';
        $tipo = (['funcion' => 1, 'flecha' => 'fa-arrow-up']);
        $titulo = 'Usuarios No Activos que contienen "' . $busqueda .'"';
        $data = ['titulo' => $titulo, 'datos' => $usuarios, 'tipo' => $tipo];

        $this->cargarVista("usuarios",$data);
    }

    /////////////////////////////////////////////

    //PAGINA DE USUARIOS QUE PERTENECEN A UN EXPERTO
    public function misColaboradores()
    {
        $responsable = session('email');
        $usuarios = $this->usuarios->where('activo', 1)
                                    ->where('role', 1)
                                    ->where('respMail',$responsable)
                                    ->where('tempId', 0)
                                    ->orderBy("apellidos", "asc")
                                    ->findAll();

        $tipo = (['flecha' => 'fa-arrow-down']);
        $data = ['titulo' => 'Mis colaboradores', 'datos' => $usuarios, 'tipo' => $tipo];

        $this->cargarVista("misColaboradores",$data);
    }

    public function buscarColaboradores()
    {
        $responsable = session('email');
        $busqueda = $this->request->getPost('info');
        $dondeBuscar = $this->request->getPost('donde');

        $usuarios = $this->usuarios->where('respMail',$responsable)
                                    ->like($dondeBuscar, $busqueda)
                                    ->orderBy("apellidos", "asc")
                                    ->findAll();

        $titulo = 'Mis colaboradores que contienen "' . $busqueda .'"';
        $tipo = (['flecha' => 'fa-arrow-down']);
        $data = ['titulo' => $titulo, 'datos' => $usuarios, 'tipo' => $tipo];

        $this->cargarVista("misColaboradores",$data);
    }
    /////////////////////////////////////////////

    //NUEVO USUARIO
    public function nuevoUsuario()
    {
        $data = ['titulo' => 'Nuevo Usuario'];
        $this->cargarVista("nuevoUsuario", $data);
    }

    /*
    public function mensaje()
    {
        $mensaje = 'Resultado:<br>';
        $data = ['titulo' => 'Nuevo Usuario'];

        $controller = \Config\Services::email();
        $controller->setTo('chema172839@gmail.com');
        $controller->setFrom('variedadesesp@gmail.com', "Antonio" );

        $controller->setSubject('Solicitud de Registro');
        $controller->setMessage("Hola wey");
        
        if($controller->send()){
            $mensaje = $mensaje . "-El usuario ha sido avisado correctamente<br>";
        } else{
            $mensaje = $mensaje . "-No va<br>";
        }

        $session = session();
        $session->setFlashdata('msg',$mensaje);
        $this->cargarVista("nuevoUsuario",$data);
    }
    */

    public function registroTemporal()
    {
        
        $nombre = $this->request->getPost('nombre');
        $apellidos = $this->request->getPost('apellidos');
        $email = $this->request->getPost('email');
        $respNombre = $this->request->getPost('respNombre');
        $respApellidos = $this->request->getPost('respApellidos');
        $respMail = $this->request->getPost('respMail');
        $tempId = random_int(1, 10000);
        $num = $tempId;

        $mensaje = 'Resultado:<br>';
        $usuarioIgual = $this->usuarios->where('email', $email)->findAll();
        $data=(['','']);

        if( count($usuarioIgual) != 0 ){
            $mensaje = $mensaje . "-El correo del usuario que has introducido ya existe<br>";   
        }
        else{
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
            // $controller->setFrom('variedadesesp@gmail.com', $respNombre. $respApellidos );
            $controller->setFrom('variedadesesp@gmail.com', "Variedades Del Español" );
            $controller->setTo($email);
    
            $controller->setSubject('Solicitud de Registro');
            $vista = view('emails/mensaje', $data);
            $controller->setMessage($vista);
            if($controller->send()){
                $mensaje = $mensaje . "-El usuario ha sido avisado correctamente<br>";
            }
        }
        $session = session();
        $session->setFlashdata('msg',$mensaje);
        $this->cargarVista("nuevoUsuario",$data);
    }

    public function registroParaUsuario()
    {
        $tempId = $_GET["tempId"];
        $usuarios = $this->usuarios->where('tempId', $tempId)->first();
        $data = ['titulo' => 'Registro para el usuario', 'datos' => $usuarios];

        $this->cargarVista("registroParaUsuario",$data);
    }

    public function insertar()
    {
        $password = password_hash( $this->request->getPost('password'), PASSWORD_DEFAULT );
        $this->usuarios->update( $this->request->getPost('id'),
                                    ['spanishlvl' => $this->request->getPost('spanishlvl'),
                                    'university' => $this->request->getPost('university'),
                                    'birthPlace' => $this->request->getPost('birthPlace'),
                                    'password' => $password,
                                    'activo' => 1,
                                    'tempId' => 0 ]);        
        return redirect()->to(base_url());
    }

    /////////////////////////////////////////////
    
    //INICIAR SESION
    public function inicioSesion()
    {
        $data = ['titulo' => 'Inicio de Sesión'];
        $this->cargarVista("inicioSesion",$data);
    }
    /////////////////////////////////////////////

    //PAGINA DATOS PERSONALES
    public function datosPersonales()
    {
        $usuario = $this->usuarios->where('id', session('id'))->first();
        $data = ['titulo' => 'Datos Personales', 'datos' => $usuario];

        $this->cargarVista("datosPersonales",$data); 
    }
    //PAGINA PARA CAMBIAR DATOS PERSONALES
    public function cambioDatosPersonales()
    {
        $usuario = $this->usuarios->where('id', session('id'))->first();
        $data = ['titulo' => 'Datos Personales', 'datos' => $usuario];

        $this->cargarVista("cambioDatosPersonales",$data);  
    }
    public function cambiarDatosPersonales()
    {
        $mensaje = 'Resultado:<br>';
        $this->usuarios->update( session('id'),
                                    ['nombre' => $this->request->getPost('nombre'),
                                    'apellidos' => $this->request->getPost('apellidos'),
                                    'spanishlvl' => $this->request->getPost('spanishlvl'),
                                    'university' => $this->request->getPost('university'),
                                    'birthPlace' => $this->request->getPost('birthPlace')]);

        $mensaje = $mensaje . "-Sus datos han sido cambiados<br>";
        $session = session();
        $session->setFlashdata('msg',$mensaje);

        $usuario = $this->usuarios->where('id', session('id'))->first();
        $data = ['titulo' => 'Datos Personales', 'datos' => $usuario];

        $this->cargarVista("datosPersonales",$data); 
    }
    //PAGINA PARA CAMBIAR CONTRASEÑA PERSONAL
    public function cambioPassPersonal()
    {
        
        $id = session('id');
        $data = ['titulo' => 'Cambio Contraseña', 'id' => $id];
        
        
        $this->cargarVista("cambioPassPersonal",$data); 
    }
    public function cambiarPassPersonal()
    {
        $usuario = $this->usuarios->where('id', session('id'))->first();
        $antPass = $this->request->getPost('antPass');
        $nuevaPass = $this->request->getPost('nuevaPass');
        $nuevaPass2 = $this->request->getPost('nuevaPass2');
        
        $mensaje = 'Resultado:<br>';
        
        if( password_verify($antPass, $usuario['password']) ){
            if( $nuevaPass == $nuevaPass2 ){
                $password = password_hash( $nuevaPass, PASSWORD_DEFAULT );
                $this->usuarios->update( session('id'),['password' => $password]);
                $mensaje = $mensaje . "-Su contraseña ha sido cambiada con exito<br>";
                $paginaQueCargar = "datosPersonales";
            } else{
                $mensaje = $mensaje . "-La nueva contraseña no ha sido introducida 2 veces correctamente<br>";
                $paginaQueCargar = "cambioPassPersonal";
            }
        } else {
            $mensaje = $mensaje . "-La contraseña que ha introducido no es la actual<br>";
            $paginaQueCargar = "cambioPassPersonal";
        }
        
        $session = session();
        $session->setFlashdata('msg',$mensaje);
        
        $usuario = $this->usuarios->where('id', session('id'))->first();
        $data = ['titulo' => 'Datos Personales', 'datos' => $usuario, 'id' => session('id')];
        $this->cargarVista($paginaQueCargar,$data);  
        
    }
    


    //EDICION DE USUARIOS QUE NO SON TU
    public function editar($id)
    {

        $usuario = $this->usuarios->where('id',$id)->first();
        // $data = ['titulo' => 'Editar Usuario', 'datos' => $usuario, 'origen' => $origen];
        $data = ['titulo' => 'Editar Usuario', 'datos' => $usuario];

        $this->cargarVista("editar",$data);  
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

    public function desactivar($id)
    {

        $this->usuarios->update( $id, ['activo' => 0]);
        $usuario = $this->usuarios->where('id',$id)->first();

        $mensaje = 'Resultado:<br>';

        $mensaje = $mensaje . "-El usuario ".$usuario['nombre']." ".$usuario['apellidos']." ha sido desactivado<br>"; 
        $session = session();
        $session->setFlashdata('msg',$mensaje);

        return redirect()->to(base_url().'/usuarios/activos');
    }
    public function activar($id)
    {
        $this->usuarios->update( $id, ['activo' => 1]);

        $usuario = $this->usuarios->where('id',$id)->first();

        $mensaje = 'Resultado:<br>';

        $mensaje = $mensaje . "-El usuario ".$usuario['nombre']." ".$usuario['apellidos']." ha sido reactivado<br>"; 
        $session = session();
        $session->setFlashdata('msg',$mensaje);

        return redirect()->to(base_url().'/usuarios/noActivos');
    }

    public function login()
    {
        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');
    
        //////////CAMBIAR
        $usuario = $this->usuarios->where('email',$email)->first();

        if(password_verify($password, $usuario['password'])){
        
            $data = [ "id" => $usuario['id'],
                        "email" => $usuario['email'],
                        "nombre" => $usuario['nombre'],
                        "apellidos" => $usuario['apellidos'],
                        "role" => $usuario['role'],
                        "spanishlvl" => $usuario['spanishlvl'],
                        "university" => $usuario['university'],
                        "birthPlace" => $usuario['birthPlace'],
                        "respMail" => $usuario['respMail']
                    ];

            $session = session();
            $session->set($data);
            return redirect()->to(base_url('/recursos'));
        
        } else {
            return redirect()->to(base_url('/recursos'));
        }
    }

    public function logout()
    {
        $session = session();
        $session->destroy();
        return redirect()->to(base_url('/recursos'));
    }

////////////////////////////////////////////////////////////////////////////////////
/////// Registro masivo y csv ////////
    public function registroMasivo()
    {
        $data = ['titulo' => 'Registro Masivo de usuarios'];
        $this->cargarVista("registroMasivo",$data);
    }

    public function cargarArchivo()
    {

        $respNombre = $this->request->getPost('respNombre');
        $respApellidos = $this->request->getPost('respApellidos');
        $respMail = $this->request->getPost('respMail');

        $archivo = $_FILES['archivo']['tmp_name'];
        $archivoAbierto = fopen($archivo, "r");

        $mensaje = 'Resultado:<br>';
        $correctos = 0;
        if( $archivoAbierto ){
            
            while( ($datos = fgetcsv($archivoAbierto, ",")) == true ){

                $usuarioIgual = $this->usuarios->where('email', $datos[2])->findAll();

                if( count($usuarioIgual) != 0 ){
                    $mensaje = $mensaje . "-El correo del usuario $datos[0] $datos[1] ya existe<br>";    
                }
                else{
                    $tempId = random_int(1, 10000);
                    $num = $tempId;

                    $this->usuarios->insert(['email' => $datos[2],
                                                'nombre' => $datos[0],
                                                'apellidos' => $datos[1],
                                                'role' => '1',
                                                'activo' => '0',
                                                'respMail' => $respMail,
                                                'tempId' => $num]);
                    
                    $data = (['email' => $datos[2],
                                'nombre' => $datos[0],
                                'apellidos' => $datos[1],
                                'respMail' => $respMail,
                                'respNombre' => $respNombre,
                                'respApellidos' => $respApellidos,
                                'tempId' => $num]);
            
                    $controller = \Config\Services::email();
                    //$controller->setFrom('variedadesesp@gmail.com', $respNombre. $respApellidos );
                    $controller->setFrom('variedadesesp@gmail.com', "Variedades Del Español" );
                    $controller->setTo($datos[2]);
            
                    $controller->setSubject('Solicitud de Registro');
                    $vista = view('emails/mensaje', $data);
                    $controller->setMessage($vista);
                    if( $controller->send() ) $correctos++;
                }
            }  

            if( $correctos != 0 ){
                $mensaje = $mensaje . "-La solucitud ha sido mandada a $correctos usuarios correctamente";
            }
            $session = session();
            $session->setFlashdata('msg',$mensaje);
        }
        
        $data = ['titulo' => 'Registro Masivo de usuarios'];
        $this->cargarVista("registroMasivo",$data);
        
    }
}

