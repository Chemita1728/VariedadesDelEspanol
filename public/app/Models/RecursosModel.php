<?php

namespace App\Models;
use CodeIgniter\Model;

class RecursosModel extends Model{
    
    protected $table      = 'resource';
    protected $primaryKey = 'resourceId';

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['title', 'description', 'state', 'source', 'variety', 
        'spanishlvlRes', 'author', 'editor', 'file', 'fileFormat', 'file2', 'file2Format', 
        'link', 'expComment', 'author', 'publisher', 'publishDate'];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;

}

?>