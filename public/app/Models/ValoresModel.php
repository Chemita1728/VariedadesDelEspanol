<?php

namespace App\Models;
use CodeIgniter\Model;

class ValoresModel extends Model{
    
    protected $table      = 'values';
    protected $primaryKey = 'valID';

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['charID', 'valID', 'at1', 'at2', 'at3'];

    protected $useTimestamps = false;
    protected $skipValidation = true;

}

?>