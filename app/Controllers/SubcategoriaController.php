<?php
namespace App\Controllers;

use App\Models\SubcategoriasModel;
use CodeIgniter\Controller;

class SubcategoriaController extends Controller
{
    public function obtenerPorCategoria($idCategoria)
    {
        $subModel = new SubcategoriasModel();
        $subcategorias = $subModel->where('id_categoria', $idCategoria)->findAll();

        return $this->response->setJSON($subcategorias);
    }
}
