<?php

namespace App\Models;
use CodeIgniter\Model;

class PerfilesModel extends Model
{
    protected $table = 'perfiles';
    protected $primaryKey = 'id_perfil';
    protected $allowedFields = ['descripcion','activo'];
}