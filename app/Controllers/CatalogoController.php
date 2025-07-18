<?php

namespace App\Controllers;

use App\Models\ProductoModel;
use App\Models\CategoriaModel;
use App\Models\ImagenModel;
use App\Models\SubcategoriasModel;

class CatalogoController extends BaseController
{
    public function index()
    {
        $ProductoModel      = new ProductoModel();
        $CategoriaModel     = new CategoriaModel();
        $ImagenModel        = new ImagenModel();
        $SubcategoriasModel = new SubcategoriasModel();

        $nombre     = $this->request->getGet('nombre');
        $categoria  = $this->request->getGet('categoria');
        $subcategoria = $this->request->getGet('subcategoria'); 
        $precioMin  = $this->request->getGet('precio_min');
        $precioMax  = $this->request->getGet('precio_max');


        $builder = $ProductoModel
            ->select('productos.*, imagen.url_imagen')
            ->join('imagen', 'imagen.id_producto = productos.id_producto AND imagen.es_principal = 1', 'left')
            ->where('productos.activo', 1)
            ->where('productos.stock >', 0);

        if ($nombre) {
            $builder->like('productos.nombre', $nombre);
        }

        if ($categoria) {
            $builder->where('productos.id_categoria', $categoria);
        }

        if ($subcategoria) {
            $builder->where('productos.id_subcategoria', $subcategoria);
        }

        if ($precioMin) {
            $builder->where('productos.precio >=', $precioMin);
        }

        if ($precioMax) {
            $builder->where('productos.precio <=', $precioMax);
        }

        $productos      = $builder->findAll();
        $categorias     = $CategoriaModel->findAll();
        $subcategorias  = $SubcategoriasModel->findAll();

        // Mapa ID categoría -> nombre
        $categoriasMap = [];
        foreach ($categorias as $cat) {
            $categoriasMap[$cat['id_categoria']] = $cat['nombre'];
        }

        // Agrupar subcategorías por categoría
        $categoriasAgrupadas = [];
        foreach ($subcategorias as $sub) {
            $catNombre = $categoriasMap[$sub['id_categoria']] ?? 'Sin categoría';
            $categoriasAgrupadas[$catNombre][] = $sub;
        }

        return view('pages/catalogoProductos', [
            'productos'           => $productos,
            'categorias'          => $categorias,
            'subcategorias'       => $subcategorias,
            'categoriasAgrupadas' => $categoriasAgrupadas,
            'categoriasMap'       => $categoriasMap,
            'filtros'             => [
                'nombre'        => $nombre,
                'categoria'     => $categoria,
                'subcategoria'  => $subcategoria,
                'precio_min'    => $precioMin,
                'precio_max'    => $precioMax
            ],
            'title' => 'Catálogo de Productos - Cleo'
        ]);
    }
}
