<?php
namespace App\Models;
use CodeIgniter\Model;

class ProductoModel extends Model {
    protected $table = 'productos';
    protected $primaryKey = 'id_producto';
    protected $allowedFields = ['nombre', 'descripcion', 'precio', 'stock', 'activo','id_categoria','id_subategoria'];
}