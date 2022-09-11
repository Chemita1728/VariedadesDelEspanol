<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UsuariosModel;
use App\Models\RecursosModel;

class Usuarios extends BaseController
{
    protected $usuarios;
    protected $recursos;

    /**
     * The function __construct() is a constructor function that creates a new instance of the
     * UsuariosModel and RecursosModel classes
     */
    public function __construct(){
        $this->usuarios = new UsuariosModel();
        $this->recursos = new RecursosModel();
    }

    /**
    * It gets all the resources from the database and displays them in the view
    */
    public function index(){
        $recursos = $this->recursos->where('state', 4)
                                    ->orderBy("created_at", "asc")
                                    ->findAll();     

        $data = ['recursos' => $recursos];
        
        echo view('header');
        echo view('inicio', $data);
        echo view('footer');
    }

    /**
     * It loads a view, and passes it some data
     * 
     * @param nombre The name of the view file.
     * @param data An array of data to be passed to the view.
     */
    public function cargarVista($nombre,$data){
        $vista = 'usuarios/'.$nombre;
        echo view('header');
        echo view($vista, $data);
        echo view('footer');
    }
    
    /**
     * It loads the view "usuariosActivos" and passes the array  to it
     */
    public function usuariosActivos(){
        $data = ['titulo' => 'Usuarios Activos'];
        $this->cargarVista("usuariosActivos",$data);
    }
    /**
     * It loads the view "usuariosNoActivos" and passes the array  to it
     */
    public function usuariosNoActivos(){
        $data = ['titulo' => 'Usuarios No Activos'];
        $this->cargarVista("usuariosNoActivos",$data);
    }
    /**
     * It loads the view "misColaboradores" and passes the array  to it
     */
    public function misColaboradores(){
        $data = ['titulo' => 'Mis Colaboradores'];
        $this->cargarVista("misColaboradores",$data);
    }

    /**
     * It gets all the users from the database, then it separates them into two arrays, one for the
     * users that are under the logged user's responsibility and another one for the rest of the users.
     * Then it merges both arrays and returns the result as a JSON object
     */
    public function buscarUsuarios(){
        $rolRegistrado = session('role');
        $mailRegistrado = session('email');

        if( isset($_POST['palabra']) ) {
            $palabra = $this->request->getPost('palabra');
            $parametro = $this->request->getPost('parametro');
            if( $rolRegistrado == 3 ){
                $usuarios = $this->usuarios->where('activo', 1)
                                            ->where('email <>', $mailRegistrado)
                                            ->like($parametro, $palabra)
                                            ->orderBy("role", "asc", "respMail", "asc", "apellidos", "asc")
                                            ->findAll();   
            } else {
                $usuarios = $this->usuarios->where('activo', 1)
                                            ->where('email <>', $mailRegistrado)
                                            ->where('role <>', 3)
                                            ->like($parametro, $palabra)
                                            ->orderBy("role", "asc", "respMail", "asc", "apellidos", "asc")
                                            ->findAll();
            }
        } else {
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
        }

        $mios=([]);
        $otros=([]);

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
        echo json_encode($mios);

    }

    /**
     * It returns a list of users that are not active, but only if the user is logged in as an admin
     */
    public function buscarUsuariosNoActivos(){
        $rolRegistrado = session('role');
        $mailRegistrado = session('email');

        if( isset($_POST['palabra']) ) {
            $palabra = $this->request->getPost('palabra');
            $parametro = $this->request->getPost('parametro');

            if( $rolRegistrado == 3 ){
                $usuarios = $this->usuarios->where('activo', 0)
                                            ->where('tempId', 0)
                                            ->where('email <>', $mailRegistrado)
                                            ->like($parametro, $palabra)
                                            ->orderBy("role", "asc", "apellidos", "asc")
                                            ->findAll();   
            } else {
                $usuarios = $this->usuarios->where('activo', 0)
                                            ->where('tempId', 0)
                                            ->where('email <>', $mailRegistrado)
                                            ->where('role <>', 3)
                                            ->like($parametro, $palabra)
                                            ->orderBy("role", "asc", "apellidos", "asc")
                                            ->findAll();
            }
        } else {
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
        }
        echo json_encode($usuarios);
    }

    /**
     * It returns a list of users that are active, have a role of 1, have a respMail that matches the
     * session email, and have a tempId of 0
     */
    public function buscarMisColaboradores(){
        $responsable = session('email');
        if( isset($_POST['palabra']) ) {
            $palabra = $this->request->getPost('palabra');
            $parametro = $this->request->getPost('parametro');
            $usuarios = $this->usuarios->where('activo', 1)
                                ->where('role', 1)
                                ->where('respMail',$responsable)
                                ->where('tempId', 0)
                                ->like($parametro, $palabra)
                                ->orderBy("apellidos", "asc")
                                ->findAll();  
        } else {
            $usuarios = $this->usuarios->where('activo', 1)
                                ->where('role', 1)
                                ->where('respMail',$responsable)
                                ->where('tempId', 0)
                                ->orderBy("apellidos", "asc")
                                ->findAll(); 
        }
        echo json_encode($usuarios);
    }

    /**
     * It loads the view "nuevoUsuario" and passes the variable  to it
     */
    public function nuevoUsuario(){
        $data = ['titulo' => 'Nuevo Usuario'];
        $this->cargarVista("nuevoUsuario", $data);
    }

   /**
    * It takes the data from the form, checks if the email is already in the database, and if it isn't,
    * it sends an email to the user with a link to activate the account
    */
    public function registroTemporal(){
        
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
                // echo ( "MANDAO" );
                $mensaje = $mensaje . "-El usuario ha sido avisado correctamente<br>";
            }
            
        }

        $session = session();
        $session->setFlashdata('msg',$mensaje);
        $this->cargarVista("nuevoUsuario",$data);
        
    }

    /**
     * It gets the user's id from the url and then it gets the user's data from the database
     */
    public function registroParaUsuario(){
        $tempId = $_GET["tempId"];
        $usuarios = $this->usuarios->where('tempId', $tempId)->first();
        $data = ['titulo' => 'Registro para el usuario', 'datos' => $usuarios];

        $this->cargarVista("registroParaUsuario",$data);
    }

    /**
     * It takes the password from the form, hashes it, and then compares it to the password in the
     * database. If they match, it redirects to the home page, registered. If they don't match, it
     * displays an error message
     * 
     * @return the view of the page.
     */
    public function insertar(){
        $pass1 = $this->request->getPost('password');
        $pass2 = $this->request->getPost('password2');
        $id = $this->request->getPost('id');
        $mensaje = 'Resultado:<br>';

        if( $pass1 == $pass2 ){
            $password = password_hash( $pass1, PASSWORD_DEFAULT );
            $this->usuarios->update( $id,
                                    ['spanishlvl' => $this->request->getPost('spanishlvl'),
                                    'university' => $this->request->getPost('university'),
                                    'birthPlace' => $this->request->getPost('birthPlace'),
                                    'password' => $password,
                                    'activo' => 1,
                                    'tempId' => 0 ]); 

            return redirect()->to(base_url());
        } else {
            $usuario = $this->usuarios->where('id', $id)->first();

            $mensaje = $mensaje . "-Las contraseñas que has introducido no coinciden<br>";
            $session = session();
            $session->setFlashdata('msg',$mensaje);

            $data = ['titulo' => 'Registro para el usuario', 'datos' => $usuario];
            $this->cargarVista("registroParaUsuario",$data);
        }  
    }

    /**
     * It loads the view "inicioSesion" and passes the array  to it
     */
    public function inicioSesion(){
        $data = ['titulo' => 'Inicio de Sesión'];
        $this->cargarVista("inicioSesion",$data);
    }
    
    /**
     * It loads the view "datosPersonales" with the credentials
     */
    public function datosPersonales(){
        $usuario = $this->usuarios->where('id', session('id'))->first();
        $data = ['titulo' => 'Datos Personales', 'datos' => $usuario];

        $this->cargarVista("datosPersonales",$data); 
    }
    
    /**
     * It loads a view called "cambioDatosPersonales" and passes it an array of credentials
     */
    public function cambioDatosPersonales(){
        $usuario = $this->usuarios->where('id', session('id'))->first();
        $data = ['titulo' => 'Datos Personales', 'datos' => $usuario];

        $this->cargarVista("cambioDatosPersonales",$data);  
    }

    /**
     * It updates the user's data in the database
     */
    public function cambiarDatosPersonales(){
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
    
    /**
     * It loads a view called "cambioPassPersonal" and passes it an array with two elements, "titulo"
     * and "id"
     */
    public function cambioPassPersonal(){
        
        $id = session('id');
        $data = ['titulo' => 'Cambio Contraseña', 'id' => $id];
        
        
        $this->cargarVista("cambioPassPersonal",$data); 
    }

    /**
     * It takes the user's old password, the new password and the new password repeated, and if the old
     * password is correct, it changes the password to the new one
     */
    public function cambiarPassPersonal(){
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
    
    /**
     * It loads a view called "editar" and passes it an array of data
     * 
     * @param id The id of the user to edit
     */
    public function editar($id){

        $usuario = $this->usuarios->where('id',$id)->first();
        $data = ['titulo' => 'Editar Usuario', 'datos' => $usuario];

        $this->cargarVista("editar",$data);  
    }

    /**
     * It updates the user's information in the database
     * 
     * @return the view of the page.
     */
    public function actualizar(){
        $this->usuarios->update( $this->request->getPost('id'),
                                    ['nombre' => $this->request->getPost('nombre'),
                                    'apellidos' => $this->request->getPost('apellidos'),
                                    'spanishlvl' => $this->request->getPost('spanishlvl'),
                                    'university' => $this->request->getPost('university'),
                                    'birthPlace' => $this->request->getPost('birthPlace'),
                                    'role' => $this->request->getPost('role')]);
        return redirect()->to(base_url().'/usuarios');
    }

    /**
     * It activates a user by setting the `activo` field to `1` in the database
     * 
     * @param id The id of the user to be activated
     */
    public function activar($id){
        $this->usuarios->update( $id, ['activo' => 1]);

        $usuario = $this->usuarios->where('id',$id)->first();

        $mensaje = 'Resultado:<br>';

        $mensaje = $mensaje . "-El usuario ".$usuario['nombre']." ".$usuario['apellidos']." ha sido reactivado<br>"; 
        $session = session();
        $session->setFlashdata('msg',$mensaje);

        return redirect()->to(base_url().'/usuarios/usuariosNoActivos');
    }

    /**
     * It desactivates a user
     * 
     * @param id The id of the user to be deactivated.
     */
    public function desactivar($id){
        $this->usuarios->update( $id, ['activo' => 0]);
        $usuario = $this->usuarios->where('id',$id)->first();

        $mensaje = 'Resultado:<br>';

        $mensaje = $mensaje . "-El usuario ".$usuario['nombre']." ".$usuario['apellidos']." ha sido desactivado<br>"; 
        $session = session();
        $session->setFlashdata('msg',$mensaje);

        return redirect()->to(base_url().'/usuarios/usuariosActivos');
    }

    /**
     * It checks if the password is correct and if the user is active. If so, it creates a session with
     * the user's data and redirects to the resources page. If not, it shows an error message
     * 
     * @return the view of the login page.
     */
    public function login(){
        $email = trim($this->request->getPost('email'));
        $password = $this->request->getPost('password');
        $mensaje = 'Resultado:<br>';
    
        $usuario = $this->usuarios->where('email',$email)->first();

        if(password_verify($password, $usuario['password']) && $usuario['activo'] == 1 ){
        
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

            $mensaje = $mensaje . "-La contraseña o el usuario no son correctos<br>";
            $session = session();
            $session->setFlashdata('msg',$mensaje);

            $data = ['titulo' => 'Inicio de Sesión'];
            $this->cargarVista("inicioSesion",$data);
            
        }
    }

    /**
     * It destroys the session and redirects to the base url.
     * 
     * @return A redirect to the base url with the path /recursos
     */
    public function logout(){
        $session = session();
        $session->destroy();
        return redirect()->to(base_url('/recursos'));
    }

    /**
     * It loads the view "registroMasivo" and passes the array  to it
     */
    public function registroMasivo(){
        $data = ['titulo' => 'Registro Masivo de usuarios'];
        $this->cargarVista("registroMasivo",$data);
    }

    /**
    * It reads a CSV file, and for each row, it checks if the email address already exists in the
    * database. If it does, it adds a message to the  variable. If it doesn't, it adds the user
    * to the database, and sends an email to the user
    */
    public function cargarArchivo(){

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

