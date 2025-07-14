<?php

namespace App\Models;
use CodeIgniter\Model;

class ConsultaModel extends Model
{
    protected $table = 'consulta';
    protected $primaryKey = 'id_consulta';
    protected $allowedFields = ['id_usuario','mensaje','fecha_envio','contestado','nombre','email','respuesta' ];
}