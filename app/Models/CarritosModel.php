<?php

namespace App\Models;
use CodeIgniter\Model;

class CarritosModel extends Model
{
    protected $table = 'carritos';
    protected $primaryKey = 'id_carrito';
    protected $allowedFields = ['id_usuario','fecha_creado'];
}