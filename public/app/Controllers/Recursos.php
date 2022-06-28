<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\RecursosModel;
use App\Models\ValoresModel;
use App\Models\CompuestoModel;
use App\Models\CaracteristicasModel;

class Recursos extends BaseController
{
    protected $recursos;

    public function __construct()
    {
        $this->recursos = new RecursosModel();
        $this->valores = new ValoresModel();
        $this->compuestos = new CompuestoModel();
        $this->caracteristicas = new CaracteristicasModel();
    }

    public function index()
    {
        $recursos = $this->recursos->where('state', 5)
                                    ->orderBy("created_at", "asc")
                                    ->findAll();     

        $data = ['recursos' => $recursos];
        
        echo view('header');
        echo view('inicio', $data);
        echo view('footer');
    }

    public function cargarVista($nombre,$data)
    {
        $vista = 'recursos/'.$nombre;
        echo view('header');
        echo view($vista, $data);
        echo view('footer');
    }

    // Función que carga la pagina para ver un recurso
    public function recurso($id)
    {
        $recurso = $this->recursos->where('resourceID', $id)
                                    ->first(); 

        $idRec = $recurso['resourceID'];
        $relaciones = $this->compuestos->where('resID', $idRec)
                                        ->findAll();
        
        $caracteristicas = $this->caracteristicas->findAll();
        $valores = [];

        if( count($relaciones) != 0 ){
            foreach( $relaciones as $relacion){
                // echo ($relacion['charID']);
                // echo ($relacion['valID']);
                $idChar = $relacion['charID'];
                $idVal = $relacion['valID'];
                $valor = $this->valores->where('charID', $idChar)->where('valID', $idVal)->first();
                array_push($valores, $valor);
            }
        }

        $data = ['recurso' => $recurso, 'valores' => $valores, 'caracteristicas' => $caracteristicas ];
        $this->cargarVista("Recurso",$data);
    }

    // Función que carga la pagina para crear un nuevo recurso
    public function nuevoRecurso()
    {
        $valores = $this->valores->findAll();
        $data = ['titulo' => 'Nuevo Recurso', 'valores' => $valores];

        $this->cargarVista("nuevoRecurso",$data);
    }

    // funcion que crea el nuevo recurso
    // si lo crea un colaborador se manda para la revision de un expreto
    // si lo crea un experto o un administrador se publica directamente
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
            'state' => 5,
            'font' => $font,
            'variety' => $variety,
            'spanishlvl' => session('spanishlvl'),
            'autor' => $autor,
            'editor' => session('email'),
            'proposerMail' => session('email'),
            'publisherMail' => session('email'),
            'publishDate' => date('Y-m-d')]);
            
            $mensaje = $mensaje . "-El recurso se ha publicado<br>";
        }

        $recurso = $this->recursos->where('title', $title)
                                    ->where("description", $description)
                                    ->first(); 

        if(!empty($_POST['pro'])) {
            foreach($_POST['pro'] as $value){
                $this->compuestos->insert(['resID' => $recurso['resourceID'], 'charID' => 1, 'valID' => $value ]);
            }
        }
        if(!empty($_POST['gra'])) {
            foreach($_POST['gra'] as $value){
                $this->compuestos->insert(['resID' => $recurso['resourceID'], 'charID' => 2, 'valID' => $value ]);
            }
        }
        if(!empty($_POST['voc'])) {
            foreach($_POST['voc'] as $value){
                $this->compuestos->insert(['resID' => $recurso['resourceID'], 'charID' => 3, 'valID' => $value ]);
            }
        }

        $session = session();
        $session->setFlashdata('msg',$mensaje);
        return redirect()->to(base_url().'/recursos/nuevoRecurso');
    }
    
    // -Funcion que carga la vista de los recursos a revisar
    // -Si la persona registrada es un colaborador se cargan los recursos que le ha
    // devuelto editor para volver a revisar con su comentario respectivamente
    // -En este caso solo salen los recirsos del colaborador pendientes de revisión
    // -Si la persona registrada es un experto o un administrador, se cargan los 
    // recursos que sus supervisados han creado para la supervision
    // -En este caso salen primero los recursos de los supervisados de la persona registrada
    // y debajo todos los demas pendientes.
    public function aRevisar($rol)
    {

        $email = session('email');

        if( $rol == 1 ){
            $where = "state=2 OR state=4";
            $recursos = $this->recursos->where("proposerMail", session('email'))
                                    ->where($where)
                                    ->orderBy("created_at", "desc")
                                    ->findAll();   

            $data = ['titulo' => 'Recursos a Revisar', 'recursos' => $recursos, 'tipo' => 1];
            $this->cargarVista("aRevisar",$data);
        }
        else if( $rol > 1 ){
            $where = "state=1 OR state=3";
            $recursos = $this->recursos->where($where)
                                        ->orderBy('state', 'desc', 'created_at', 'asc')
                                        ->findAll();   
            
            $mios=([]);
            $otros=([]);
    
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
            
    
            $data = ['titulo' => 'Recursos a Revisar', 'recursos' => $mios, 'tipo' => 2];
            $this->cargarVista("aRevisar",$data);
        }
    }

    // -Función que carga la vista de un recurso a revisar por un experto o administrador
    public function validarRecurso($id)
    {
        //forma1
        // $where = "state=3 OR state=1";
        // $recurso = $this->recursos->where('resourceID', $id)
        //                             ->where($where)
        //                             ->first();
        //forma2
        // $recurso = $this->recursos->where('resourceID', $id)
        //                             ->where('state', 1)
        //                             ->orWhere('state', 3)
        //                             ->first();     

        $recurso = $this->recursos->where('resourceID', $id)
                                    ->first(); 

        $data = ['recurso' => $recurso];
        $this->cargarVista("validarRecurso",$data);
    }

    // -Función para que un recurso no se publique y el colaborador lo tenga que revisar
    public function enviarComentario($id)
    {

        $comentario = $this->request->getPost('comentario');
        $estado = $this->request->getPost('state');

        $mensaje = 'Resultado:<br>';
        $data=(['','']);

        $nuevoEstado = 2;
        if( $estado == 3 ) $nuevoEstado = 4;

        $this->recursos->update( $id, ['state' => $nuevoEstado,
                                    'publisherMail' => session('email'),
                                    'expComment' => $comentario]);    

        $mensaje = $mensaje . "-El recurso ha sido mandado al colaborador para la revision<br>";

        $session = session();
        $session->setFlashdata('msg',$mensaje);
        return redirect()->to(base_url().'/recursos/aRevisar/2');
        
    }

    // -Función para que un experto o administrador publiquen un recurso de un colaborador
    public function publicar($id)
    {

        $mensaje = 'Resultado:<br>';
        $data=(['','']); 

        $this->recursos->update( $id, ['state' => 5,
                                    'expComment' => NULL,
                                    'publisherMail' => session('email'),
                                    'publishDate' => date('Y-m-d')]);    

        $mensaje = $mensaje . "-El recurso se ha publicado<br>";
        
        $session = session();
        $session->setFlashdata('msg',$mensaje);
        return redirect()->to(base_url().'/recursos/aRevisar/2');

    }

    //-Función que carga la vista de un recurso a revisar por un colaborador
    public function revisarRecurso($id)
    {

        // $where = "state=4 OR state=2";
        // $recurso = $this->recursos->where('resourceID', $id)
        //                             ->where($where)
        //                             ->first(); 
        
        $recurso = $this->recursos->where('resourceID', $id)
                                    ->first();

        $data = ['recurso' => $recurso];
        $this->cargarVista("revisarRecurso",$data);
    }

    public function mandarRevision($id)
    {
        $title = $this->request->getPost('title');
        $description = $this->request->getPost('description');
        $font = $this->request->getPost('font');
        $variety = $this->request->getPost('variety');

        $mensaje = 'Resultado:<br>';
        $data=(['','']);

        $this->recursos->update( $id, ['title' => $title,
                                'description' => $description,
                                'state' => 3,
                                'font' => $font,
                                'variety' => $variety]);

        $mensaje = $mensaje . "-El vuelto a ser mandado para la revisión<br>";
        
        $session = session();
        $session->setFlashdata('msg',$mensaje);
        return redirect()->to(base_url().'/recursos/aRevisar/1');

    }




}

