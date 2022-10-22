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
    
    /**
     * It connects to the database, and then creates a new instance of each of the models
     */
    public function __construct(){
        $this->db = \Config\Database::connect();
        $this->recursos = new RecursosModel();
        $this->valores = new ValoresModel();
        $this->compuestos = new CompuestoModel();
        $this->caracteristicas = new CaracteristicasModel();
    }

    /**
     * It gets all the resources from the database and displays them in the home page
     */
    public function index(){
        $recursos = $this->recursos->where('state', 5)
                                    ->orderBy("created_at", "asc")
                                    ->findAll();     

        $data = ['recursos' => $recursos];
        
        echo view('header');
        echo view('inicio', $data);
        echo view('footer');
    }

    /**
     * It loads the header, footer and the sobreNosotros view.
     */
    public function sobreNosotros(){
        
        echo view('header');
        echo view('sobreNosotros');
        echo view('footer');
    }

    /**
     * It loads a view from resources, and passes it some data
     * 
     * @param nombre The name of the view file.
     * @param data An array of data that will be passed to the view.
     */
    public function cargarVista($nombre,$data){
        $vista = 'recursos/'.$nombre;
        echo view('header');
        echo view($vista, $data);
        echo view('footer');
    }

    /**
     * It loads a view from characteristics, and passes it some data
     * 
     * @param nombre The name of the view file.
     * @param data An array of data that will be passed to the view.
     */
    public function cargarVistaCaracteristicas($nombre,$data){
        $vista = 'caracteristicas/'.$nombre;
        echo view('header');
        echo view($vista, $data);
        echo view('footer');
    }

    /**
     * It loads the view "recursos" and passes the data array to it.
     */
    public function recursos(){
        $valores = $this->valores->findAll();
        $data = ['valores' => $valores];
        $this->cargarVista("recursos",$data);
    }

    /**
     * It gets the resource with the id passed as a parameter, and then it gets the author of that
     * resource
     * 
     * @param id The id of the resource you want to retrieve.
     */
    public function recurso($id){
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

    /**
     * It takes a parameter from a form, and then returns a JSON object with the data from the database
     */
    public function cargarCaracteristicas(){
        $parametro = $this->request->getPost('parametro');
        $caracteristica = $this->caracteristicas->where('charID', $parametro)
                                                    ->first();
        echo json_encode($caracteristica);                                            
    }

    /**
     * It takes the id of a resource and the id of a parameter, and returns the values of that
     * parameter that are associated with that resource
     */
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

    /**
     * It loads the view nuevoRecurso.php
     */
    public function nuevoRecurso(){
        $valores = $this->valores->findAll();
        $data = ['titulo' => 'Nuevo Recurso', 'valores' => $valores];

        $this->cargarVista("nuevoRecurso",$data);
    }

    /**
     * It takes the data from a form, inserts it into a database, and then redirects the user to a
     * different page
     * 
     * @return the view of the form to create a new resource.
     */
    public function crearRecurso(){
        $title = $this->request->getPost('title');
        $description = $this->request->getPost('description');
        $nivel = $this->request->getPost('nivel');
        $variety = $this->request->getPost('variety');
        $source = $this->request->getPost('source');
        $link = $this->request->getPost('link');
        
        $mensaje = 'Resultado:<br>';
        $data=(['','']);
        
        // If you are a collaborator
        if (session('role') == 1){
            $this->recursos->insert(['title' => $title,
                                        'description' => $description,
                                        'state' => 1,
                                        'spanishlvlRes' => $nivel,
                                        'variety' => $variety,
                                        'source' => $source,
                                        'link' => $link,
                                        'author' => session('email'),
                                        'publisher' => session('respMail')]);
            
            $mensaje = $mensaje . "-El recurso ha sido mandado para supervisión<br>";
        }
        // If you are an expert or admin
        if (session('role') > 1){
            $this->recursos->insert(['title' => $title,
                                        'description' => $description,
                                        'state' => 5,
                                        'spanishlvlRes' => $nivel,
                                        'variety' => $variety,
                                        'source' => $source,
                                        'link' => $link,
                                        'author' => session('email'),
                                        'publisher' => session('email'),
                                        'publishDate' => date('Y-m-d')]);
            
            $mensaje = $mensaje . "-El recurso se ha publicado<br>";
        }
        
        /* Updating the fileFormat and file columns in the database. */
        $recurso = $this->recursos->where('title', $title)
                                    ->where("description", $description)
                                    ->first(); 

        for( $i = 0; $i<2; $i++){
            if( $i == 0){
                $file = $this->request->getFile('file');   
                $folder = "files";
                $formatColumn = "fileFormat";
                $column = "file";
                $nombreArchivo = "primario_Rec".$recurso['resourceID'];
            } 
            else{
                $file = $this->request->getFile('file2'); 
                $folder = "secondaryFiles";
                $formatColumn = "file2Format";
                $column = "file2";
                $nombreArchivo = "secundario_Rec".$recurso['resourceID'];
            }
            if( $file->isValid() && ! $file->hasMoved() ){
    
                $fileFormat = $file->guessExtension();
                if( $fileFormat == "" ) $fileFormat = "docx"; 
                //$nombreArchivo = $file->getRandomName();
    
                /* Moving the file to the folder "uploads/files" and updating the database with the new
                file name. */
                $file->move(ROOTPATH."public/uploads/".$folder , $nombreArchivo);
                $this->recursos->update( $recurso['resourceID'], [$formatColumn => $fileFormat,
                                                                    $column => $nombreArchivo]);
            }
        }

        /* Inserting the values of the checkboxes into the database. */
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
    
    /**
     * It's a function that gets all the resources that are in a state of 2 or 4 (for the author) or 1
     * or 3 (for the reviewer) and displays them in a table
     * 
     * @param rol 1 = collaborator, 2 = expert, 3 = admin
     */
    public function aRevisar($rol){        
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

    /**
     * It gets the resource with the given id, joins the users table to get the author's name, and then
     * loads the view with the result
     * 
     * @param id The id of the resource to be validated
     */
    public function validarRecurso($id){
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

    /**
     * It updates the resource's state to 2 or 4 depending on the state it was in before, and then
     * redirects to the same page
     * 
     * @param id The id of the resource to be updated
     */
    public function enviarComentario($id){

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
 
    /**
     * It updates the state of a resource to 5 (published) and sets the publisher and publish date
     * 
     * @param id The id of the resource to be published
     */
    public function publicar($id){
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

    /**
     * It takes the id of a resource, finds the resource, finds all the values of the resource, finds
     * all the values of the characteristics, and then loads the view with all of that data
     * 
     * @param id the id of the resource to be reviewed
     */
    public function revisarRecurso($id){
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

    /**
     * It updates a resource in the database, and if a file is not uploaded, it updates the file
     * information in the database
     * 
     * @param id The id of the resource
     */
    public function mandarRevision($id){
        $title = $this->request->getPost('title');
        $description = $this->request->getPost('description');
        $nivel = $this->request->getPost('nivel');
        $variety = $this->request->getPost('variety');
        $source = $this->request->getPost('source');
        $link = $this->request->getPost('link');

        $mensaje = 'Resultado:<br>';
        $data=(['','']);

        $this->recursos->update( $id, ['title' => $title,
                                'description' => $description,
                                'state' => 3,
                                'spanishlvlRes' => $nivel,
                                'variety' => $variety,
                                'source' => $source,
                                'link' => $link,
                                'variety' => $variety]);

        $recurso = $this->recursos->where('resourceID', $id)->first();   
        for( $i = 0; $i<2; $i++){
            if( $i == 0){
                $file = $this->request->getFile('file');   
                $folder = "files";
                $formatColumn = "fileFormat";
                $column = "file";
                $nombreArchivo = "primario_Rec".$recurso['resourceID'];
            } 
            else{
                $file = $this->request->getFile('file2'); 
                $folder = "secondaryFiles";
                $formatColumn = "file2Format";
                $column = "file2";
                $nombreArchivo = "secundario_Rec".$recurso['resourceID'];
            }

            if( $file->isValid() && ! $file->hasMoved() ){
                
                /* If the resource already has a file, it is deleted from the server. */
                if( $recurso[$column] != "" ) {
                    unlink( ROOTPATH."public/uploads/".$folder."/".$recurso[$column] );
                }

                $fileFormat = $file->guessExtension();
                if( $fileFormat == "" ) $fileFormat = "docx"; 
                //$nombreArchivo = $file->getRandomName();
    
                /* Moving the file to the folder "uploads/files" and updating the database with the new
                file name. */
                $file->move(ROOTPATH."public/uploads/".$folder , $nombreArchivo);
                $this->recursos->update( $recurso['resourceID'], [$formatColumn => $fileFormat,
                                                                    $column => $nombreArchivo]);
            }
        }

        /* Checking if the checkboxes are checked and if they are, it is adding them to the database. */
        for ($i = 1; $i <= 3; $i++) {  
            if($i == 1) $vector="pro";
			if($i == 2) $vector="gra";
			if($i == 3) $vector="vocFinal";                    
        
            /* Checking if the post is empty. */
            if(!empty($_POST[$vector])) {

                $relaciones = $this->compuestos->where('resID', $id)
                                                ->where('charID', $i)
                                                ->findAll(); 

                /* Checking if the values in the database are still selected. If they are not, it
                deletes them. */
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

                /* Inserting values into a table if not yet included. */
                foreach($_POST[$vector] as $value){
                    $busco = $this->compuestos->where('resID', $id)
                                                ->where("charID", $i)
                                                ->where("valID", $value)
                                                ->first(); 
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

    /**
     * It receives a POST request with a word, and returns a JSON with all the words that match the
     * word in the database
     */
    public function buscarVocabulario(){
        if( isset($_POST['palabra']) ) {
            $palabra = ['at1' => $this->request->getPost('palabra')];
        } else $palabra = ['at1' => ''];

        $vocabulario = $this->valores->where('charID', 3)
                                        ->like($palabra)
                                        ->orderBy("at1", "asc")
                                        ->findAll();                        

        echo json_encode($vocabulario);
    }

    /**
     * It takes the values from the form, and inserts them into the database
     */
    public function introducirVocabulario(){
        $lema = $this->request->getPost('lema');
        $forma = $this->request->getPost('forma');
        $significado = $this->request->getPost('sign');

        $vocabulario = $this->valores->where('charID', 3)->findAll();
        foreach( $vocabulario as $value){
            $last = $value['valID'];
        }

        $this->valores->insert(['charID' => 3,
                                'valID' => $last+1,
                                'at1' => $lema,
                                'at2' => $forma,
                                'at3' => $significado]);      
    }

    /**
     * It takes the id of a resource, finds the resource, then finds all the values associated with
     * that resource, and returns them as an array
     */
    public function cargarSeleccionados(){
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

    /**
     * It gets a resource from the database, gets all the values of that resource, gets all the values
     * from the database, and gets all the characteristics from the database
     * 
     * @param id the id of the resource to be edited
     */
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

    /**
     * It updates a resource in the database
     * 
     * @param id The id of the resource to be edited
     */
    public function mandarEdicion($id){
        $title = $this->request->getPost('title');
        $description = $this->request->getPost('description');
        $nivel = $this->request->getPost('nivel');
        $variety = $this->request->getPost('variety');
        $source = $this->request->getPost('source');
        $link = $this->request->getPost('link');

        $mensaje = 'Resultado:<br>';
        $data=(['','']);        

        /* Updating the database with the new information. */
        if( session('role') > 1 ){
            $this->recursos->update( $id, ['title' => $title,
                                    'description' => $description,
                                    'spanishlvlRes' => $nivel,
                                    'variety' => $variety,
                                    'source' => $source,
                                    'link' => $link,
                                    'variety' => $variety]);
        } else {
            $this->recursos->update( $id, ['title' => $title,
                                    'state' => 3,
                                    'description' => $description,
                                    'spanishlvlRes' => $nivel,
                                    'variety' => $variety,
                                    'source' => $source,
                                    'link' => $link,
                                    'variety' => $variety]);
        }

        
        $recurso = $this->recursos->where('resourceID', $id)->first();   
        for( $i = 0; $i<2; $i++){
            if( $i == 0){
                $file = $this->request->getFile('file');   
                $folder = "files";
                $formatColumn = "fileFormat";
                $column = "file";
                $nombreArchivo = "primario_Rec".$recurso['resourceID'];
            } 
            else{
                $file = $this->request->getFile('file2'); 
                $folder = "secondaryFiles";
                $formatColumn = "file2Format";
                $column = "file2";
                $nombreArchivo = "secundario_Rec".$recurso['resourceID'];
            }

            if( $file->isValid() && ! $file->hasMoved() ){
                
                /* If the resource already has a file, it is deleted from the server. */
                if( $recurso[$column] != "" ) {
                    unlink( ROOTPATH."public/uploads/".$folder."/".$recurso[$column] );
                }

                $fileFormat = $file->guessExtension();
                if( $fileFormat == "" ) $fileFormat = "docx"; 
                //$nombreArchivo = $file->getRandomName();
    
                /* Moving the file to the folder "uploads/files" and updating the database with the new
                file name. */
                $file->move(ROOTPATH."public/uploads/".$folder , $nombreArchivo);
                $this->recursos->update( $recurso['resourceID'], [$formatColumn => $fileFormat,
                                                                    $column => $nombreArchivo]);
            }
        }

        /* Checking if the checkboxes are checked and if they are, it is adding them to the database. */
        for ($i = 1; $i <= 3; $i++) {  
            if($i == 1) $vector="pro";
			if($i == 2) $vector="gra";
			if($i == 3) $vector="vocFinal";                    
        
            //compruebo si hay algun checkbox seleccionado
            if(!empty($_POST[$vector])) {

                $relaciones = $this->compuestos->where('resID', $id)
                                                ->where('charID', $i)
                                                ->findAll(); 

                /* Checking if the values in the database are still selected. If they are not, it
                deletes them. */
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

                /* Inserting values into a table if not yet included. */
                foreach($_POST[$vector] as $value){
                    $busco = $this->compuestos->where('resID', $id)
                                                ->where("charID", $i)
                                                ->where("valID", $value)
                                                ->first(); 
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

    /**
     * It loads a view with a variable called proGra, which is a collection of objects
     * 
     * @param tipo the ID of the characteristic
     */
    public function nuevaProGra($tipo){
        $proGra = $this->caracteristicas
                                ->where('charID', $tipo)
                                ->first();
        $data = ['proGra' => $proGra, 'tipo' => $tipo];
        $this->cargarVistaCaracteristicas("nuevaProGra",$data);
    }

    /**
     * Creating a new pronunciation or grammar characteristic.
     * 
     * @param tipo the type of the characteristic, in this case, it's "proGra"
     */
    public function crearProGra( $tipo ){
        $proGra1 = $this->request->getPost('proGra1');
        $proGra2 = $this->request->getPost('proGra2');
        $proGra3 = $this->request->getPost('proGra3');
        $mensaje = 'Resultado:<br>';
        $data=(['','']);

        $proGra = $this->valores->where('charID', $tipo)->findAll();
        foreach( $proGra as $value){
            $last = $value['valID'];
        }
    
        $this->valores->insert(['charID' => $tipo,
                                    'valID' => $last+1,
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
        $this->cargarVistaCaracteristicas("nuevaProGra",$data);
    }

    /**
     * It takes a bunch of parameters from a form, and then uses them to query the database for
     * resources that match the parameters
     */
    public function buscarRecursos( ){
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

        //buscamos en source
        if( isset($_POST['source']) ) {
            $source = ['source' => $this->request->getPost('source')];
        } else {
            $source = ['source !=' => null];
        }

        //buscamos en fileFormat
        if( isset($_POST['fileFormat']) ) {
            $fileFormat = ['fileFormat' => $this->request->getPost('fileFormat')];
        } else {
            $fileFormat = ['fileFormat !=' => null];
        }

        $recursos = $this->recursos->where('state', 5)
                                    ->like($texto1)
                                    // ->orlike($texto2)
                                    //falta poner que busque descripcion
                                    ->where($nivel)
                                    ->where($variedad)
                                    ->where($source)
                                    ->where($fileFormat)
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
            $mios = array_unique($mios, SORT_REGULAR);
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
            $mios = array_unique($mios, SORT_REGULAR);
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
            $mios = array_unique($mios, SORT_REGULAR);
            echo json_encode($mios);

        } else {
            // echo json_encode(array_slice($recursos, $first, 9));
            echo json_encode($recursos);
        }

    }

    /**
     * It creates a CSV file with the data of a resource, and then it downloads it.
     * 
     * @param id The id of the resource you want to download.
     */
    public function crearCSV( $id ){

        $url = "../public/tempFiles/rec".$id.".csv";
        //FORMA 1
        $headersEsp = array("idRecurso", "Autor", "Editor", "Titulo", "Descripción", "Estado", "Fuente", "VariedadEspañol", "NivelEspañol", "Link", "FechaPublicación");
        $dataName = array("resourceID", "author", "publisher", "title", "description", "state", "source", "variety", "spanishlvlRes", "link", "publishDate");
        $file = fopen($url, "w");
        $recurso = $this->recursos->where('resourceID', $id)->get()->getRowArray();

        $variedad = ['Castellano', 'Andaluz', 'Canario', 'Caribeño', 'Mexicano-Centroamericano', 'Andino', 'Austral', 'Chileno', 'Español de Guinea Ecuatorial', 'Judeoespañol'];
        $nivel = ['A1', 'A2', 'B1', 'B2', 'C1', 'C2'];

        fputcsv($file, $headersEsp);
        $linea = array();
        for( $i = 0; $i < count($dataName)-1; $i++ ){
            if( $i == 7 ) $linea[] = $variedad[$recurso[$dataName[$i]]];
            else if( $i == 8 ) $linea[] = $nivel[$recurso[$dataName[$i]]];
            else $linea[] = $recurso[$dataName[$i]];
        }
        fputcsv($file, $linea);

        //FORMA 2
        // $headersEsp = array("idRecurso", "Autor", "Editor", "Titulo", "Descripción", "Estado", "Fuente", "VariedadEspañol", "NivelEspañol", "Link", "FechaPublicación");
        // $dataName = array("resourceID", "author", "publisher", "title", "description", "state", "source", "variety", "spanishlvlRes", "link", "publishDate");
        // $file = fopen("../public/tempFiles/rec".$id.".csv", "w");
        // $recurso = $this->recursos->where('resourceID', $id)->first();

        // for( $i = 0; $i < count($dataName); $i++ ){
        //     $linea = array($headersEsp[$i], $recurso[$dataName[$i]]);
        //     fputcsv($file, $linea);
        // }

        fclose($file);

        if (file_exists($url)) {
            header('Content-Description: File Transfer');
            header('Content-Type: text/csv');
            header('Content-Disposition: attachment; filename='.basename($url));
            header('Content-Transfer-Encoding: binary');
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            //header('Content-Length: ' . filesize($file_example));
            ob_clean();
            flush();
            readfile($url);
            // readfile($file_example);
            exit;
        }
        else {
            echo 'Archivo no disponible.';
        }

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

        // $a = new PharData('archive.tar');

        // // ADD FILES TO archive.tar FILE
        // $a->addFile('../public/tempFiles/rec".$id.".csv');
    
        // // COMPRESS archive.tar FILE. COMPRESSED FILE WILL BE archive.tar.gz
        // $a->compress(Phar::GZ);

        // header("Content-type: application/octet-stream");
        // header("Content-disposition: attachment; filename=archive.tar");
        // // leemos el archivo creado
        // readfile('archive.tar');
    
        // // NOTE THAT BOTH FILES WILL EXISTS. SO IF YOU WANT YOU CAN UNLINK archive.tar
        // unlink('archive.tar');

    }

    /**
     * It downloads a file from the server
     * 
     * @param id The ID of the resource you want to download.
     */
    public function descargarArchivo( $id ){

        $recurso = $this->recursos->where('resourceID', $id)->first(); 

        $fileFormat = $recurso['fileFormat'];
        $file = $recurso['file'];

        $url = "../public/uploads/files/".$file;

        if (file_exists($url)) {
            header('Content-Description: File Transfer');
            if( $fileFormat == "pdf" ){ header('Content-Type: application/pdf'); } 
            else { header('Content-Type: application/vnd.openxmlformats-officedocument.wordprocessingml.document'); }
            header('Content-Disposition: attachment; filename=archivoAsociado.'.$fileFormat);
            header('Content-Transfer-Encoding: binary');
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            //header('Content-Length: ' . filesize($file_example));
            ob_clean();
            flush();
            readfile($url);
            // readfile($file_example);
            exit;
        }
        else {
            echo 'Archivo no disponible.';
        }

    }

    public function descargarArchivoSecundario( $id ){

        $recurso = $this->recursos->where('resourceID', $id)->first(); 

        $fileFormat = $recurso['file2Format'];
        $file = $recurso['file2'];

        $url = "../public/uploads/secondaryFiles/".$file;

        if (file_exists($url)) {
            header('Content-Description: File Transfer');
            if( $fileFormat == "pdf" ){ header('Content-Type: application/pdf'); } 
            else { header('Content-Type: application/vnd.openxmlformats-officedocument.wordprocessingml.document'); }
            header('Content-Disposition: attachment; filename=archivoAsociado.'.$fileFormat);
            header('Content-Transfer-Encoding: binary');
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            //header('Content-Length: ' . filesize($file_example));
            ob_clean();
            flush();
            readfile($url);
            // readfile($file_example);
            exit;
        }
        else {
            echo 'Archivo no disponible.';
        }

    }

    public function borrarRecurso(){
        
        $id = $this->request->getPost('id');
        $title = $this->request->getPost('title');
        $this->recursos->delete( $id );                    
        echo "El recurso con el título \"".utf8_decode($title)."\" se ha borrado.";

    }

    public function listaCaracteristicas($tipo){
        $valores = $this->valores->where('charID', $tipo)->findAll();
        $data = ['valores' => $valores, 'tipo' => $tipo];
        $this->cargarVistaCaracteristicas("listaCaracteristicas",$data);
    }

    public function borrarPronunciacion(){
        $valID = $this->request->getPost('valID');
        $this->valores->where('charID', 1)
                        ->where('valID', $valID)
                        ->delete();
        echo "La caracteristica seleccionada se ha borrado.";
    }
    public function borrarGramatica(){
        $valID = $this->request->getPost('valID');
        $this->valores->where('charID', 2)
                        ->where('valID', $valID)
                        ->delete();
        echo "La caracteristica seleccionada se ha borrado.";
    }
    public function borrarVocabulario(){
        $valID = $this->request->getPost('valID');
        $this->valores->where('charID', 3)
                        ->where('valID', $valID)
                        ->delete();
        echo "La caracteristica seleccionada se ha borrado.";
    }

}
