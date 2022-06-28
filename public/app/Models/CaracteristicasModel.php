<?php

namespace App\Models;
use CodeIgniter\Model;

class CaracteristicasModel extends Model{
    
    protected $table      = 'characteristics';
    protected $primaryKey = 'charID';

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['charID', 'charName', 'title1', 'title2', 'title3'];

    protected $useTimestamps = false;
    protected $skipValidation = true;

}

?>