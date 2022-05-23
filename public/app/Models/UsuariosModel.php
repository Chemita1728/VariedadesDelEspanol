<?php

namespace App\Models;
use CodeIgniter\Model;

class UsuariosModel extends Model{
    
    protected $table      = 'users';
    protected $primaryKey = 'id';

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['email', 'password', 'nombre', 'apellidos', 'role', 'activo', 'spanishlvl', 'university', 'birthPlace', 'respMail', 'tempId'];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;

}

?>