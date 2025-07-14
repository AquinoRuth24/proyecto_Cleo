<?php

namespace App\Models;
use CodeIgniter\Model;

class CabeceraModel extends Model
{
    protected $table = 'cabecera';
    protected $primaryKey = 'id_cabecera';
    protected $allowedFields = ['id_usuario','precio_total','fecha_creacion','id_factura' ];
}