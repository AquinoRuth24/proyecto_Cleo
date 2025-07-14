<?php
namespace App\Models;
use CodeIgniter\Model;

class DetalleVentaModel extends Model {
    protected $table = 'detalle_ventas';
    protected $primaryKey = 'id_detalle_venta';
    protected $allowedFields = ['id_venta', 'id_producto', 'cantidad', 'precio_unitario'];
}