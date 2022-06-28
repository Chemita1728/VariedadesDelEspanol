<?php

namespace App\Models;
use CodeIgniter\Model;

class CompuestoModel extends Model{
    
    protected $table      = 'compound';
    protected $primaryKey = 'resID';

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['resID', 'charID', 'valID'];

    protected $useTimestamps = false;
    protected $skipValidation = true;

}

?>