<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\RecursosModel;
use App\Models\ValoresModel;
use App\Models\CompuestoModel;
use App\Models\CaracteristicasModel;

use App\Libraries\ZipFile;

class Recursos extends BaseController
{
    protected $recursos;
    
    public function __construct()
    {
        $this->db = \Config\Database::connect();
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

    public function sobreNosotros()
    {
        
        echo view('header');
        echo view('sobreNosotros');
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
    public function recursos()
    {
        $valores = $this->valores->findAll();
        $data = ['valores' => $valores];
        $this->cargarVista("recursos",$data);
    }

    // Función que carga la pagina para ver un recurso
    public function recurso($id)
    {
        $resultado = $this->db->table('resource')
                                    ->where('resourceID', $id)
                                    ->join('users', 'users.email = resource.author')
                                    ->get()
                                    ->getRowArray();
        // $recurso = $this->recursos->where('resourceID', $id)
        //                             ->first(); 

        $data = ['resultado' => $resultado];
        $this->cargarVista("recurso",$data);
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
        $nivel = $this->request->getPost('nivel');
        $variety = $this->request->getPost('variety');
        $source = $this->request->getPost('source');
        $link = $this->request->getPost('link');
        
        $mensaje = 'Resultado:<br>';
        $data=(['','']);

        $format = "";
        if( $source == "youtube" || $source == "Youtube" ) $format = "video";
        else if ( $source == "kahoot" || $source == "Kahoot" ) $format = "application";
        
        if (session('role') == 1){
            $this->recursos->insert(['title' => $title,
            'description' => $description,
            'state' => 1,
            'spanishlvlRes' => $nivel,
            'variety' => $variety,
            'source' => $source,
            'link' => $link,
            'format' => $format,
            'author' => session('email'),
            'publisher' => session('respMail')]);
            
            $mensaje = $mensaje . "-El recurso ha sido mandado para supervisión<br>";
        }
        if (session('role') > 1){
            $this->recursos->insert(['title' => $title,
            'description' => $description,
            'state' => 5,
            'spanishlvlRes' => $nivel,
            'variety' => $variety,
            'source' => $source,
            'link' => $link,
            'format' => $format,
            'author' => session('email'),
            'publisher' => session('email'),
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

            if( $format == "video" ) $carpeta = "public/uploads/videos";
            else if( $format == "application" ) $carpeta = "public/uploads/pdfs";

            $format2 = $file->guessExtension(); // mp4
            if( $format2 == "" ) $format2 = "docx";
            $nombreArchivo = $file->getRandomName();
            // echo($mime);
            // echo($format);
            // echo($format2);

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
            $resultados = $this->db->table('resource')
                                    ->where("author", session('email'))
                                    ->where($where)
                                    ->join('users', 'users.email = resource.author')
                                    ->orderby("resource.created_at", "desc")
                                    ->get()
                                    ->getResultArray();
            // $recursos = $this->recursos->where("author", session('email'))
            //                         ->where($where)
            //                         ->orderBy("created_at", "desc")
            //                         ->findAll();   
            $data = ['titulo' => 'Recursos a Revisar', 'resultados' => $resultados, 'tipo' => 1];
            $this->cargarVista("aRevisar",$data);
        }
        else if( $rol > 1 ){
            $where = "state=1 OR state=3";
            $resultados = $this->db->table('resource')
                                    ->where($where)
                                    ->join('users', 'users.email = resource.author')
                                    ->orderby('state', 'desc', 'resource.created_at', 'asc')
                                    ->get()
                                    ->getResultArray();
            // $recursos = $this->recursos->where($where)
            //                             ->orderBy('state', 'desc', 'created_at', 'asc')
            //                             ->findAll();   
            $mios=([]);
            $otros=([]);
    
            foreach($resultados as $resultado){
                if( $resultado['respMail'] == $email ){
                    $mios[] = $resultado;
                } else {
                    $otros[] = $resultado;
                }
            }
            foreach( $otros as $otro ){
                $mios[] = $otro;
            }
            
        $data = ['titulo' => 'Recursos a Validar', 'resultados' => $mios, 'tipo' => 2];
        $this->cargarVista("aRevisar",$data);

        }
    }

    // -Función que carga la vista de un recurso a revisar por un experto o administrador
    public function validarRecurso($id)
    {
        $resultado = $this->db->table('resource')
                                ->where("resourceID", $id)
                                ->join('users', 'users.email = resource.author')
                                ->get()
                                ->getRowArray();
        // $recurso = $this->recursos->where('resourceID', $id)
        //                             ->first(); 
        $data = ['resultado' => $resultado];
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
                                    'publisher' => session('email'),
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
                                    'publisher' => session('email'),
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
        $source = $this->request->getPost('source');
        $variety = $this->request->getPost('variety');

        $mensaje = 'Resultado:<br>';
        $data=(['','']);

        $this->recursos->update( $id, ['title' => $title,
                                'description' => $description,
                                'state' => 3,
                                //'state' => 2,
                                'source' => $source,
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
                                        ->orderBy("at1", "asc")
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
        $source = $this->request->getPost('source');
        $variety = $this->request->getPost('variety');

        $mensaje = 'Resultado:<br>';
        $data=(['','']);

        if( session('role') > 1 ){
            $this->recursos->update( $id, ['title' => $title,
                                    'description' => $description,
                                    'source' => $source,
                                    'variety' => $variety]);
        } else {
            $this->recursos->update( $id, ['title' => $title,
                                    'description' => $description,
                                    'state' => 3,
                                    'source' => $source,
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

    public function nuevaProGra($tipo)
    {
        $proGra = $this->caracteristicas
                                ->where('charID', $tipo)
                                ->first();
        $data = ['proGra' => $proGra, 'tipo' => $tipo];
        $this->cargarVista("nuevaProGra",$data);
    }

    public function crearProGra($tipo){
        $proGra1 = $this->request->getPost('proGra1');
        $proGra2 = $this->request->getPost('proGra2');
        $proGra3 = $this->request->getPost('proGra3');
        $mensaje = 'Resultado:<br>';
        $data=(['','']);

        $proGra = $this->valores->where('charID', $tipo)->findAll();
        $cont = count($proGra) + 1;
    
        $this->valores->insert(['charID' => $tipo,
                                    'valID' => $cont,
                                    'at1' => $proGra1,
                                    'at2' => $proGra2,
                                    'at3' => $proGra3]);
            
        $mensaje = $mensaje . "-La nueva caracteristica de pronunciación ha sido creada<br>";

        $session = session();
        $session->setFlashdata('msg',$mensaje);

        $proGra = $this->caracteristicas
                                ->where('charID', $tipo)
                                ->first();
        $data = ['proGra' => $proGra, 'tipo' => $tipo];
        $this->cargarVista("nuevaProGra",$data);
    }

    public function buscarRecursos( $pag )
    {

        $first = ($pag - 1)  * 9 ;

        //buscamos en titulo o descripcion
        if( isset($_POST['texto1']) ) {
            $texto1 = ['title' => $this->request->getPost('texto1')];
            $texto2 = ['description' => $this->request->getPost('texto1')];
        } else {
            $texto1 = ['title' => ''];
            $texto2 = ['description' => ''];
        }
        
        // buscamos en nivel de español
        if( $this->request->getPost('nivel') != '' ){
            $nivel = [ 'spanishlvlRes' => $this->request->getPost('nivel') ];
        } else $nivel = ['spanishlvlRes !=' => null];
        //buscamos en variedad del español
        if ( $this->request->getPost('variedad') != '' ){
            $variedad = [ 'variety'=> $this->request->getPost('variedad') ];
        } else $variedad = ['variety !='=> null];
        //buscamos en format1
        if ( isset($_POST['formato']) ){
            $formato = ['format' => $this->request->getPost('formato')];
        } else $formato = ['format !=' => null];
        //buscamos en format2
        if ( isset($_POST['formatoSecundario']) ){
            $seleccionado = $this->request->getPost('formatoSecundario');
            if( $seleccionado == "youtube" ){
                $formato2 = ['source' => "youtube" ];
            } else if ( $seleccionado == "noYoutube" ){
                $formato2 = ['format2 !=' => "" ];
            } else if ( $seleccionado == "kahoot" ){
                $formato2 = ['source' => "kahoot" ];
            } else {
                $formato2 = ['format2' => $seleccionado ];
            }
        } else $formato2 = ['format2 !=' => null];

        $recursos = $this->recursos->where('state', 5)
                                    ->like($texto1)
                                    ->where($nivel)
                                    ->where($variedad)
                                    ->where($formato)
                                    ->where($formato2)
                                    ->orderBy("publishDate", "asc")
                                    ->findAll();  

        $numerosPronunciacion = $this->request->getPost('proFinal');
        $numerosGramatica = $this->request->getPost('graFinal');
        $numerosVocabulario = $this->request->getPost('vocFinal');
        $mios=([]);

        if( $numerosPronunciacion != null ) {

            $pronunciacion = $this->compuestos->where('charID', 1)
                                                ->whereIn('valID', $numerosPronunciacion)
                                                ->findAll(); 

            foreach($recursos as $recurso){
                $encontrado = false;
                foreach($pronunciacion as $pro){
                    if( $recurso['resourceID'] == $pro['resID'] ){
                        $mios[] = $recurso;
                        $encontrado = true;
                    }
                }
            }
            $mios = array_unique($mios);
            echo json_encode($mios);

        } else if( $numerosGramatica != null ) {

            $gramatica = $this->compuestos->where('charID', 2)
                                                ->whereIn('valID', $numerosGramatica)
                                                ->findAll(); 

            foreach($recursos as $recurso){
                $encontrado = false;
                foreach($gramatica as $gra){
                    if( $recurso['resourceID'] == $gra['resID'] ){
                        $mios[] = $recurso;
                        $encontrado = true;
                    }
                }
            }
            $mios = array_unique($mios);
            echo json_encode($mios);

        } else if( $numerosVocabulario != null ) {

            $vocabulario = $this->compuestos->where('charID', 3)
                                                ->whereIn('valID', $numerosVocabulario)
                                                ->findAll(); 

            foreach($recursos as $recurso){
                $encontrado = false;
                foreach($vocabulario as $voc){
                    if( $recurso['resourceID'] == $voc['resID'] ){
                        $mios[] = $recurso;
                        $encontrado = true;
                    }
                }
            }
            $mios = array_unique($mios);
            echo json_encode($mios);

        } else {
            // echo json_encode(array_slice($recursos, $first, 9));
            echo json_encode($recursos);
        }

    }

    public function crearCSV( $id ){

        $url = "../public/tempFiles/rec".$id.".csv";
        //FORMA 1
        $headersEsp = array("idRecurso", "Autor", "Editor", "Titulo", "Descripción", "Estado", "Fuente", "Formato1", "Formato2", "VariedadEspañol", "NivelEspañol", "Link", "FechaPublicación");
        $dataName = array("resourceID", "author", "publisher", "title", "description", "state", "source", "format", "format2", "variety", "spanishlvlRes", "link", "publishDate");
        $file = fopen($url, "w");
        $recurso = $this->recursos->where('resourceID', $id)->get()->getRowArray();

        $variedad = ['Castellano', 'Andaluz', 'Canario', 'Caribeño', 'Mexicano-Centroamericano', 'Andino', 'Austral', 'Chileno', 'Español de Guinea Ecuatorial', 'Judeoespañol'];
        $nivel = ['A1', 'A2', 'B1', 'B2', 'C1', 'C2'];

        fputcsv($file, $headersEsp);
        $linea = array();
        for( $i = 0; $i < count($dataName)-1; $i++ ){
            if( $i == 9 ) $linea[] = $variedad[$recurso[$dataName[$i]]];
            else if( $i == 10 ) $linea[] = $nivel[$recurso[$dataName[$i]]];
            else $linea[] = $recurso[$dataName[$i]];
        }
        fputcsv($file, $linea);

        //FORMA 2
        // $headersEsp = array("idRecurso", "Autor", "Editor", "Titulo", "Descripción", "Estado", "Fuente", "Formato1", "Formato2", "VariedadEspañol", "NivelEspañol", "Link", "FechaPublicación");
        // $dataName = array("resourceID", "author", "publisher", "title", "description", "state", "source", "format", "format2", "variety", "spanishlvlRes", "link", "publishDate");
        // $file = fopen("../public/tempFiles/rec".$id.".csv", "w");
        // $recurso = $this->recursos->where('resourceID', $id)->first();

        // for( $i = 0; $i < count($dataName); $i++ ){
        //     $linea = array($headersEsp[$i], $recurso[$dataName[$i]]);
        //     fputcsv($file, $linea);
        // }

        fclose($file);

        // if (file_exists($url)) {
        //     header('Content-Description: File Transfer');
        //     header('Content-Type: text/csv');
        //     header('Content-Disposition: attachment; filename='.basename($url));
        //     header('Content-Transfer-Encoding: binary');
        //     header('Expires: 0');
        //     header('Cache-Control: must-revalidate');
        //     header('Pragma: public');
        //     //header('Content-Length: ' . filesize($file_example));
        //     ob_clean();
        //     flush();
        //     readfile($url);
        //     // readfile($file_example);
        //     exit;
        // }
        // else {
        //     echo 'Archivo no disponible.';
        // }

        // Creamos un instancia de la clase ZipArchive
        // $zip = new \ZipArchive();
        // // Creamos y abrimos un archivo zip temporal
        // $zip->open("recurso".$id.".zip",ZipArchive::CREATE);
        // // Añadimos un directorio
        // $dir = 'Recurso'.$id;
        // $zip->addEmptyDir($dir);
        // //Añadimos un archivo dentro del directorio que hemos creado
        // $zip->addFile($url, $dir."/recurso".$id.".csv");
        // // Una vez añadido los archivos deseados cerramos el zip.
        // $zip->close();
        // // Creamos las cabezeras que forzaran la descarga del archivo como archivo zip.
        // header("Content-type: application/octet-stream");
        // header("Content-disposition: attachment; filename=recurso".$id.".zip");
        // // leemos el archivo creado
        // readfile('recurso'.$id.'.zip');
        // // Por último eliminamos el archivo temporal creado
        // unlink('recurso'.$id.'.zip');//Destruye el archivo temporal

        //$this->zip->read_file($url);

        // Download the file to your desktop. Name it "my_backup.zip"
        //$this->zip->download('recursos.zip');
        //$zipFile = new \PhpZip\ZipFile();

    }

}
