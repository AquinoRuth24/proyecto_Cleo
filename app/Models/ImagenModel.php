<?php

namespace App\Models;
use CodeIgniter\Model;

class ImagenModel extends Model
{
    protected $table = 'imagen';
    protected $primaryKey = 'id_imagen';
    protected $allowedFields = ['id_producto','url_imagen','es_principal' ];
}