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

    /*
    public function sacarCaracteristicas(){
        $caracteristicas = $this->caracteristicas->findAll();
        return $caracteristicas;
    }

    public function sacarValoresRecurso($id){

        $relaciones = $this->compuestos->where('resID', $id)
                                        ->findAll();
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
        return $valores;

    }
    // Función que carga la pagina para ver un recurso
    public function recurso($id)
    {
        $recurso = $this->recursos->where('resourceID', $id)
                                    ->first(); 

        $idRec = $recurso['resourceID'];
        $caracteristicas = sacarCaracteristicas();
        $valores = sacarValoresRecurso($idRec);

        $data = ['recurso' => $recurso, 'valores' => $valores, 'caracteristicas' => $caracteristicas ];
        $this->cargarVista("Recurso",$data);
    }
    */

    // Función que carga la pagina para ver un recurso
    public function recursos()
    {
        $valores = $this->valores->findAll();
        $data = ['valores' => $valores];
        $this->cargarVista("recursos",$data);
    }

    // Función que carga la pagina para ver un recurso
    public function recurso($id)
    {
        $recurso = $this->recursos->where('resourceID', $id)
                                    ->first(); 

        $data = ['recurso' => $recurso];
        $this->cargarVista("Recurso",$data);
    }

    //Funcion para cargar los nombres de cada caracteristica
    public function cargarCaracteristicas(){
        $parametro = $this->request->getPost('parametro');
        $caracteristica = $this->caracteristicas->where('charID', $parametro)
                                                    ->first();
        echo json_encode($caracteristica);                                            
    }

    //Funcion para cargar los valores pertenecientes a un recurso dependiendo de la caracteristica elegida
    public function cargarValores(){
        $id = $this->request->getPost('id');
        $parametro = $this->request->getPost('parametro');

        $relaciones = $this->compuestos->where('resID', $id)
                                        ->where('charID', $parametro)
                                        ->findAll();

        $valores = [];
        foreach( $relaciones as $relacion){
            $idVal = $relacion['valID'];
            $valor = $this->valores->where('charID', $parametro)
                                    ->where('valID', $idVal)
                                    ->first();
            array_push($valores, $valor);
        }

        echo json_encode($valores);  
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
        
        $file = $this->request->getFile('file');        
        
        if( $file->isValid() && ! $file->hasMoved() ){

            $mime = $file->getMimeType(); // video/mp4
            $format = substr($mime, 0, strpos($mime, "/")); // video

            if( $format == "image" ) $carpeta = "public/uploads/imagenes";
            else if( $format == "video" ) $carpeta = "public/uploads/videos";
            else if( $format == "application" ) $carpeta = "public/uploads/pdfs";

            $format2 = $file->guessExtension(); // mp4
            $nombreArchivo = $file->getRandomName();
            // echo $format;
            // echo $format2;
            $file->move(ROOTPATH.$carpeta, $nombreArchivo);
            $this->recursos->update( $recurso['resourceID'], ['format' => $format,
                                                                'format2' => $format2,
                                                                'file' => $nombreArchivo]);  
        }

        // echo("Pronunciación");
        if(!empty($_POST['pro'])) {
            foreach($_POST['pro'] as $value){
                // echo($value.", ");
                $this->compuestos->insert(['resID' => $recurso['resourceID'], 'charID' => 1, 'valID' => $value ]);
            }
        }
        // echo("Gramatica");
        if(!empty($_POST['gra'])) {
            foreach($_POST['gra'] as $value){
                // echo($value.", ");
                $this->compuestos->insert(['resID' => $recurso['resourceID'], 'charID' => 2, 'valID' => $value ]);
            }
        }
        // echo("Vocabulario");
        if(!empty($_POST['vocFinal'])) {
            foreach($_POST['vocFinal'] as $value){
                // echo($value.", ");
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
        $recurso = $this->recursos->where('resourceID', $id)
                                    ->first();

        $idRec = $recurso['resourceID'];
        $relaciones = $this->compuestos->where('resID', $idRec)
                                        ->findAll();
        
        $caracteristicas = $this->caracteristicas->findAll();
        $todosLosValores = $this->valores->findAll();
        $valoresDeRecurso = [];

        if( count($relaciones) != 0 ){
            foreach( $relaciones as $relacion){
                $idChar = $relacion['charID'];
                $idVal = $relacion['valID'];
                $valor = $this->valores->where('charID', $idChar)->where('valID', $idVal)->first();
                array_push($valoresDeRecurso, $valor);
            }
        }


        $data = ['recurso' => $recurso, 'valoresDeRecurso' => $valoresDeRecurso, 'todosLosValores' => $todosLosValores, 'caracteristicas' => $caracteristicas ];
        $this->cargarVista("revisarRecurso",$data);
    }

    // Función que usa el colaborador cuando el experto dice que su recurso no es correcto
    // para volver a mandarlo para que lo revisen
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
                                //'state' => 2,
                                'font' => $font,
                                'variety' => $variety]);

        //hago este for para ver los checkbox que esta seleccionados de cada tipo
        for ($i = 1; $i <= 3; $i++) {  
            if($i == 1) $vector="pro";
			if($i == 2) $vector="gra";
			if($i == 3) $vector="vocFinal";                    
        
            //compruebo si hay algun checkbox seleccionado
            if(!empty($_POST[$vector])) {

                $relaciones = $this->compuestos->where('resID', $id)
                                                ->where('charID', $i)
                                                ->findAll(); 

                // miro todas las relaciones que tiene el recurso y las comparo con las seleccionadas
                foreach( $relaciones as $relacion ){
                    $estaSeleccionado = false;
                    foreach($_POST[$vector] as $value){
                        //si la relacion sigue seleccionada se queda como esta
                        if( $relacion['valID'] == $value ) $estaSeleccionado = true;
                    }
                    // si alguna de las relaciones no esta seleccionada se borra de la tabla
                    if( $estaSeleccionado == false ){
                        $this->compuestos->where('resID', $id)
                                            ->where('charID', $i)
                                            ->where('valID', $relacion['valID'])
                                            ->delete();
                    }
                }

                // miro todos los seleccionados y los busco en la tabla
                foreach($_POST[$vector] as $value){
                    $busco = $this->compuestos->where('resID', $id)
                                                ->where("charID", $i)
                                                ->where("valID", $value)
                                                ->first(); 
                    // si no estan en la tabla los añado
                    if( $busco == NULL ){                         
                        $this->compuestos->insert(['resID' => $id, 'charID' => $i, 'valID' => $value ]);
                    } 
                }
            }
        }                   

        $mensaje = $mensaje . "-El vuelto a ser mandado para la revisión<br>";
        
        $session = session();
        $session->setFlashdata('msg',$mensaje);
        return redirect()->to(base_url().'/recursos/aRevisar/1');

    }

    public function buscarVocabulario()
    {
        // if( isset($_POST['palabra']) ) {
        //     $palabra = $this->request->getPost('palabra');
        //     $vocabulario = $this->valores->where('charID', 3)
        //                                 ->like('at1', $palabra)
        //                                 ->findAll();
        // } else {
        //     $vocabulario = $this->valores->where('charID', 3)
        //                                 ->findAll();                         
        // }

        if( isset($_POST['palabra']) ) {
            $palabra = ['at1' => $this->request->getPost('palabra')];
        } else $palabra = ['at1' => ''];

        $vocabulario = $this->valores->where('charID', 3)
                                        ->like($palabra)
                                        ->findAll();                        

        echo json_encode($vocabulario);
    }

    public function introducirVocabulario()
    {
        $lema = $this->request->getPost('lema');
        $forma = $this->request->getPost('forma');
        $significado = $this->request->getPost('sign');

        $vocabulario = $this->valores->where('charID', 3)->findAll();
        $num = count($vocabulario) + 1;

        $this->valores->insert(['charID' => 3,
                                'valID' => $num,
                                'at1' => $lema,
                                'at2' => $forma,
                                'at3' => $significado]);      
    }

    public function cargarSeleccionados()
    {
        $vocabularioDeRecurso = [];

        $id = $this->request->getPost('id');
        $recurso = $this->recursos->where('resourceID', $id)
                                        ->first();
        $idRec = $recurso['resourceID'];

        $relaciones = $this->compuestos->where('resID', $idRec)
                                        ->where('charID', 3)
                                        ->findAll();

        if( count($relaciones) != 0 ){
            foreach( $relaciones as $relacion){
                $idChar = $relacion['charID'];
                $idVal = $relacion['valID'];
                $valor = $this->valores->where('charID', $idChar)->where('valID', $idVal)->first();
                array_push($vocabularioDeRecurso, $valor);
            }
        }
        echo json_encode($vocabularioDeRecurso);
    }

    public function editarRecurso($id){
        $recurso = $this->recursos->where('resourceID', $id)
                                    ->first();

        $idRec = $recurso['resourceID'];
        $relaciones = $this->compuestos->where('resID', $idRec)
                                        ->findAll();
        
        $caracteristicas = $this->caracteristicas->findAll();
        $todosLosValores = $this->valores->findAll();
        $valoresDeRecurso = [];

        if( count($relaciones) != 0 ){
            foreach( $relaciones as $relacion){
                $idChar = $relacion['charID'];
                $idVal = $relacion['valID'];
                $valor = $this->valores->where('charID', $idChar)->where('valID', $idVal)->first();
                array_push($valoresDeRecurso, $valor);
            }
        }


        $data = ['recurso' => $recurso, 'valoresDeRecurso' => $valoresDeRecurso, 'todosLosValores' => $todosLosValores, 'caracteristicas' => $caracteristicas ];
        $this->cargarVista("editarRecurso",$data);
    }

    public function mandarEdicion($id)
    {
        $title = $this->request->getPost('title');
        $description = $this->request->getPost('description');
        $font = $this->request->getPost('font');
        $variety = $this->request->getPost('variety');

        $mensaje = 'Resultado:<br>';
        $data=(['','']);

        if( session('role') > 1 ){
            $this->recursos->update( $id, ['title' => $title,
                                    'description' => $description,
                                    'font' => $font,
                                    'variety' => $variety]);
        } else {
            $this->recursos->update( $id, ['title' => $title,
                                    'description' => $description,
                                    'state' => 3,
                                    'font' => $font,
                                    'variety' => $variety]);
        }

        //hago este for para ver los checkbox que esta seleccionados de cada tipo
        for ($i = 1; $i <= 3; $i++) {  
            if($i == 1) $vector="pro";
			if($i == 2) $vector="gra";
			if($i == 3) $vector="vocFinal";                    
        
            //compruebo si hay algun checkbox seleccionado
            if(!empty($_POST[$vector])) {

                $relaciones = $this->compuestos->where('resID', $id)
                                                ->where('charID', $i)
                                                ->findAll(); 

                // miro todas las relaciones que tiene el recurso y las comparo con las seleccionadas
                foreach( $relaciones as $relacion ){
                    $estaSeleccionado = false;
                    foreach($_POST[$vector] as $value){
                        //si la relacion sigue seleccionada se queda como esta
                        if( $relacion['valID'] == $value ) $estaSeleccionado = true;
                    }
                    // si alguna de las relaciones no esta seleccionada se borra de la tabla
                    if( $estaSeleccionado == false ){
                        $this->compuestos->where('resID', $id)
                                            ->where('charID', $i)
                                            ->where('valID', $relacion['valID'])
                                            ->delete();
                    }
                }

                // miro todos los seleccionados y los busco en la tabla
                foreach($_POST[$vector] as $value){
                    $busco = $this->compuestos->where('resID', $id)
                                                ->where("charID", $i)
                                                ->where("valID", $value)
                                                ->first(); 
                    // si no estan en la tabla los añado
                    if( $busco == NULL ){                         
                        $this->compuestos->insert(['resID' => $id, 'charID' => $i, 'valID' => $value ]);
                    } 
                }
            }
        }                   

        $mensaje = $mensaje . "-La edición del recurso ha sido mandada<br>";
        
        $session = session();
        $session->setFlashdata('msg',$mensaje);
        return redirect()->to(base_url('/recursos'));
    }

    public function nuevaPronunciacion()
    {
        $data=(['','']);
        $this->cargarVista("nuevaPronunciacion",$data);
    }

    public function crearPronunciacion(){
        $pro1 = $this->request->getPost('pro1');
        $pro2 = $this->request->getPost('pro2');
        $pro3 = $this->request->getPost('pro3');
        $mensaje = 'Resultado:<br>';
        $data=(['','']);

        $pronunciacion = $this->valores->where('charID', 1)->findAll();
        $cont = count($pronunciacion) + 1;
    
        $this->valores->insert(['charID' => 1,
                                    'valID' => $cont,
                                    'at1' => $pro1,
                                    'at2' => $pro2,
                                    'at3' => $pro3]);
            
        $mensaje = $mensaje . "-La nueva caracteristica de pronunciación ha sido creada<br>";

        $session = session();
        $session->setFlashdata('msg',$mensaje);
        $this->cargarVista("nuevaPronunciacion",$data);
    }

    public function nuevaGramatica()
    {
        $data=(['','']);
        $this->cargarVista("nuevaGramatica",$data);
    }

    public function crearGramatica(){
        $gra1 = $this->request->getPost('gra1');
        $gra2 = $this->request->getPost('gra2');
        $gra3 = $this->request->getPost('gra3');
        $mensaje = 'Resultado:<br>';
        $data=(['','']);

        $gramatica = $this->valores->where('charID', 2)->findAll();
        $cont = count($gramatica) + 1;
    
        $this->valores->insert(['charID' => 2,
                                    'valID' => $cont,
                                    'at1' => $gra1,
                                    'at2' => $gra2,
                                    'at3' => $gra3]);
            
        $mensaje = $mensaje . "-La nueva caracteristica de gramática ha sido creada<br>";

        $session = session();
        $session->setFlashdata('msg',$mensaje);
        $this->cargarVista("nuevaGramatica",$data);
    }

    public function buscarRecursos()
    {

        //seleccionamos titulo o descripcion
        if( $this->request->getPost('busqueda1') == 1 ) $parametro1 = "title";
        else $parametro1 = "description";
        //buscamos en titulo o descripcion
        if( isset($_POST['texto1']) ) {
            $texto1 = [$parametro1 => $this->request->getPost('texto1')];
        } else $texto1 = [$parametro1 => ''];
        //buscamos en autor
        if( isset($_POST['autor']) ) {
            $autor = ['autor' => $this->request->getPost('autor')];
        } else $autor = ['autor' => ''];
        
        // buscamos en nivel de español
        if( $this->request->getPost('nivel') != '' ){
            $nivel = [ 'spanishlvl' => $this->request->getPost('nivel') ];
        } else $nivel = ['spanishlvl !=' => null];
        //buscamos en variedad del español
        if ( $this->request->getPost('variedad') != '' ){
            $variedad = [ 'variety'=> $this->request->getPost('variedad') ];
        } else $variedad = ['variety !='=> null];
        //buscamos en format1
        if ( isset($_POST['formato']) ){
            $formato = ['format' => $this->request->getPost('formato')];;
        } else $formato = ['format !=' => null];
        // //buscamos en format2
        if ( isset($_POST['formatoSecundario']) ){
            $formato2 = ['format2' => $this->request->getPost('formatoSecundario')];;
        } else $formato2 = ['format2 !=' => null];

        // if(!empty($_POST['vocabulario'])) {
        //     foreach($_POST['vocabulario'] as $value){
        //         $numeros[] = $value;
        //     }
        // }

        /*
        $numerosPronunciacion = [2, 3, 5];
        $pronunciacion = $this->compuestos->where('charID', 1)
                                            ->whereIn('valID', $numerosPronunciacion)
                                            ->findAll(); 

        $numerosGramatica = [1];
        $gramatica = $this->compuestos->where('charID', 2)
                                            ->whereIn('valID', $numerosGramatica)
                                            ->findAll(); 

        $numerosVocabulario = [1, 2 ];
        $vocabulario = $this->compuestos->where('charID', 3)
                                            ->whereIn('valID', $numerosVocabulario)
                                            ->findAll(); 
        */

        $recursos = $this->recursos->where('state', 5)
                                    ->like($texto1)
                                    ->like($autor)
                                    ->where($nivel)
                                    ->where($variedad)
                                    ->where($formato)
                                    ->where($formato2)
                                    ->orderBy("created_at", "asc")
                                    ->findAll();  

        /*
        $mios=([]);
        foreach($recursos as $recurso){
            $encontrado = false;
            foreach($pronunciacion as $pro){
                if( $recurso['resourceID'] == $pro['resID'] ){
                    $mios[] = $recurso;
                    $encontrado = true;
                }
            }
            if( $encontrado == false ){
                foreach($gramatica as $gra){
                    if( $recurso['resourceID'] == $gra['resID'] ){
                        $mios[] = $recurso;
                        $encontrado = true;
                    }
                }
            }
            if( $encontrado == false ){
                foreach($vocabulario as $voc){
                    if( $recurso['resourceID'] == $voc['resID'] ){
                        $mios[] = $recurso;
                    }
                }
            }

        }

        echo json_encode($mios);
        */
        echo json_encode($recursos);
    }



}

