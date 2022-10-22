<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\RecursosModel;
use App\Models\ValoresModel;
use App\Models\CompuestoModel;
use App\Models\CaracteristicasModel;

use App\Libraries\ZipFile;

class Administracion extends BaseController
{    
    /**
     * It connects to the database
     */
    public function __construct(){
        $this->db = \Config\Database::connect();
    }

    /**
     * The function index() is a public function that returns a view of the header, the administration
     * page, and the footer
     */
    public function index(){
        echo view('header');
        echo view('administracion');
        echo view('footer');
    }

    public function getBackup(){
        // $dbhost = 'http://localhost:3306';
        // $dbuser = 'root';
        // $dbpass = 'VariedadesDelEspanol';
        $backup_file = "../public/tempFiles/dbBackup_".date("d_m_y").".sql";
        // $command = "mysqldump --opt -h $dbhost -u $dbuser -p $dbpass ". "test_db | gzip > $backup_file";
        //$command = "mysqldump -u $dbuser -h $dbhost -p $dbpass ". "test_db | gzip > $backup_file";
        //$command = "mysqldump --opt --single-transaction -h=$dbhost --password=$dbpass --user=$dbuser > ".$backup_file;
        $command = "mysqldump -h localhost -u root -P 3306 VariedadesDelEspanol > ".$backup_file;

        system($command);
    }

    public function getBackup2(){
        //Datos de la base de datos
        $mysqlDatabaseName ='VariedadesDelEspanol';
        $mysqlUserName ='root';
        $mysqlPassword ='VariedadesDelEspanol';
        $mysqlHostName ='localhost:3306/db';
        $mysqlExportPath = "../public/tempFiles/dbBackup_".date("d_m_y").".sql";
        
        // Backup con mysqldump
        $command='mysqldump --opt -h' .$mysqlHostName .' -u' .$mysqlUserName .' -p' .$mysqlPassword .' ' .$mysqlDatabaseName .' > ' .$mysqlExportPath;
        
        system($command);
        // exec($command,$output=array(),$worked);
        
        // switch($worked){
        //     case 0:
        //     echo 'La base de datos <b>' .$mysqlDatabaseName .'</b> se ha almacenado correctamente en la siguiente ruta '.getcwd().'/' .$mysqlExportPath .'</b>';
        //     break;
        //     case 1:
        //     echo 'Se ha producido un error al exportar <b>' .$mysqlDatabaseName .'</b> a '.getcwd().'/' .$mysqlExportPath .'</b>';
        //     break;
        //     case 2:
        //     echo 'Se ha producido un error de exportación, compruebe la siguiente información: <br/><br/><table><tr><td>Nombre de la base de datos:</td><td><b>' .$mysqlDatabaseName .'</b></td></tr><tr><td>Nombre de usuario MySQL:</td><td><b>' .$mysqlUserName .'</b></td></tr><tr><td>Contraseña MySQL:</td><td><b>NOTSHOWN</b></td></tr><tr><td>Nombre de host MySQL:</td><td><b>' .$mysqlHostName .'</b></td></tr></table>';
        //     break;
        // }
    }

    public function getBackup3(){
        $dbhost = 'https://localhost:3306';
        $dbuser = 'root';
        $dbpass = 'VariedadesDelEspanol';
        
        $backup_file = "../public/tempFiles/dbBackup_".date("d_m_y").".gz";
        $command = "mysqldump --opt -h $dbhost -u $dbuser -p $dbpass ". "VariedadesDelEspanol | gzip > $backup_file";
        
        system($command);
    }

}
