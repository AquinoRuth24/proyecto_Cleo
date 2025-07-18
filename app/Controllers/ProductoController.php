<?php

namespace App\Controllers;

use App\Models\ProductoModel;
use App\Models\ImagenModel;
use App\Models\CategoriaModel;
use CodeIgniter\Controller;
use App\Models\SubcategoriasModel;

class ProductoController extends Controller
{
    public function index()
    {
        if (!session()->get('isLoggedIn') || session()->get('id_perfil') !== '3') {
            return redirect()->to('/login')->with('error', 'Acceso no autorizado.');
        }

        $ProductoModel = new ProductoModel();
        $ImagenModel = new ImagenModel();

        $productos = $ProductoModel
            ->where('activo', 1)
            ->findAll();
        $imagenes = [];

        foreach ($productos as &$producto) {
            $imagenes[$producto['id_producto']] = array_column(
                $ImagenModel->where('id_producto', $producto['id_producto'])->findAll(),
                'url_imagen'
            );
        }

        return view('pages/productos/index', ['productos' => $productos, 'imagenes' => $imagenes]);
    }

    public function crearProducto()
    {
        if (!session()->get('isLoggedIn') || session()->get('id_perfil') !== '3') {
            return redirect()->to('/login')->with('error', 'Acceso no autorizado.');
        }
        helper(['form']);
        $CategoriaModel = new CategoriaModel();
        $SubcategoriasModel = new SubcategoriasModel();
        $categorias = $CategoriaModel->findAll();
        $subcategorias = $SubcategoriasModel->findAll();

        if ($this->request->getMethod() === 'POST') {
            $validationRules = [
                'nombre'        => 'required|min_length[3]',
                'descripcion'   => 'required|min_length[3]',
                'precio'        => 'required|decimal',
                'stock'         => 'required|integer',
                'id_categoria'  => 'required|integer',
                'id_subcategoria' => 'required|integer',
                'imagen'        => 'uploaded[imagen]|is_image[imagen]|mime_in[imagen,image/jpg,image/jpeg,image/png]'
            ];

            if (!$this->validate($validationRules)) {
                return view('pages/productos/crearProducto', [
                    'validation' => $this->validator,
                    'categorias' => $categorias,
                    'subcategorias'  => $subcategorias
                ]);
            }
            $idCategoria = $this->request->getPost('id_categoria');
            $idSubcategoria = $this->request->getPost('id_subcategoria');

            if ($idCategoria === 'otros') {
                $nuevaCategoria = trim($this->request->getPost('nueva_categoria'));
                if (!empty($nuevaCategoria)) {
                    $idCategoria = $CategoriaModel->insert([
                        'nombre' => $nuevaCategoria
                    ]);
                } else {
                    return redirect()->back()->withInput()->with('error', 'Debes ingresar una nueva categoría.');
                }
            }

            if ($idSubcategoria === 'otros') {
                $nuevaSub = trim($this->request->getPost('nueva_subcategoria'));

                if (!empty($nuevaSub)) {
                    $idSubcategoria = $SubcategoriasModel->insert([
                        'nombre' => $nuevaSub,
                        'id_categoria' => $idCategoria
                    ]);
                } else {
                    return redirect()->back()->withInput()->with('error', 'Debes ingresar una subcategoría nueva.');
                }
            }

            $ProductoModel = new ProductoModel();
            $ImagenModel = new ImagenModel();

            $datos = [
                'nombre'        => $this->request->getPost('nombre'),
                'descripcion'   => $this->request->getPost('descripcion'),
                'precio'        => $this->request->getPost('precio'),
                'stock'         => $this->request->getPost('stock'),
                'activo'        => 1,
                'id_categoria'  => $this->request->getPost('id_categoria'),
                'id_subcategoria' => $idSubcategoria,
            ];

            if (!$ProductoModel->insert($datos)) {
                dd('Error al insertar producto', $ProductoModel->errors());
            }

            $idProducto = $ProductoModel->insertID();
            $imagen = $this->request->getFile('imagen');

            if ($imagen && $imagen->isValid() && !$imagen->hasMoved()) {
                $nombreImagen = $imagen->getRandomName();

                if (!$imagen->move(FCPATH . 'productos/img/', $nombreImagen)) {
                    dd('Error al mover la imagen');
                }

                $ImagenModel->insert([
                    'id_producto'  => $idProducto,
                    'url_imagen'   => $nombreImagen,
                    'es_principal' => 1
                ]);
            }

            session()->setFlashdata('success', 'Producto creado exitosamente.');
            return redirect()->to('/producto');
        }

        return view('pages/productos/crearProducto', ['categorias' => $categorias, 'subcategorias' => $subcategorias]);
    }

    public function editarProducto($id)
    {
        if (!session()->get('isLoggedIn') || session()->get('id_perfil') !== '3') {
            return redirect()->to('/login')->with('error', 'Acceso no autorizado.');
        }
        helper(['form', 'url']);
        $ProductoModel = new ProductoModel();
        $ImagenModel = new ImagenModel();
        $CategoriaModel = new CategoriaModel();
        $SubcategoriasModel = new SubcategoriasModel();

        $categorias = $CategoriaModel->findAll();
        $subcategorias = $SubcategoriasModel->findAll();

        if ($this->request->getMethod() === 'POST') {
            $validationRules = [
                'nombre'        => 'required|min_length[3]',
                'descripcion'   => 'required|min_length[3]',
                'precio'        => 'required|decimal',
                'stock'         => 'required|integer',
                'id_categoria'  => 'required|integer',
                'id_subcategoria' => 'required|integer',
            ];

            if (!$this->validate($validationRules)) {
                $producto = $ProductoModel->find($id);
                $imagenes = $ImagenModel->where('id_producto', $id)->findAll();
                return view('pages/productos/editarProducto', [
                    'producto'   => $producto,
                    'imagenes'   => $imagenes,
                    'categorias' => $categorias,
                    'validation' => $this->validator
                ]);
            }

            $ProductoModel->update($id, [
                'nombre'        => $this->request->getPost('nombre'),
                'descripcion'   => $this->request->getPost('descripcion'),
                'precio'        => $this->request->getPost('precio'),
                'stock'         => $this->request->getPost('stock'),
                'id_categoria'  => $this->request->getPost('id_categoria'),
            ]);

            // Procesar múltiples imágenes (si se suben)
            $imagenes = $this->request->getFiles()['imagenes'] ?? [];

            $esPrimera = true; // Solo una se marcará como principal si no hay ninguna
            foreach ($imagenes as $img) {
                if ($img->isValid() && !$img->hasMoved()) {
                    $nombre = $img->getRandomName();
                    $img->move(FCPATH . 'productos/img/', $nombre);

                    $ImagenModel->insert([
                        'id_producto'  => $id,
                        'url_imagen'   => $nombre,
                        'es_principal' => $esPrimera ? 1 : 0
                    ]);

                    $esPrimera = false;
                }
            }

            return redirect()->to('/producto')->with('success', 'Producto actualizado con éxito');
        }

        $producto = $ProductoModel->find($id);
        $imagenes = $ImagenModel->where('id_producto', $id)->findAll();
        $subcategorias = $SubcategoriasModel
            ->where('id_categoria', $producto['id_categoria'])
            ->findAll();
        return view('pages/productos/editarProducto', [
            'producto'   => $producto,
            'imagenes'   => $imagenes,
            'categorias' => $categorias,
            'subcategorias' => $subcategorias,
        ]);
    }
    public function eliminarProducto($id)
    {
        if (!session()->get('isLoggedIn') || session()->get('id_perfil') !== '3') {
            return redirect()->to('/login')->with('error', 'Acceso no autorizado.');
        }
        $ProductoModel = new ProductoModel();

        $ProductoModel->update($id, ['activo' => 0]);

        return redirect()->to('producto')->with('success', 'Producto eliminado lógicamente');
    }

    public function productosEliminados()
    {
        if (!session()->get('isLoggedIn') || session()->get('id_perfil') !== '3') {
            return redirect()->to('/login')->with('error', 'Acceso no autorizado.');
        }
        $ProductoModel = new ProductoModel();

        $productos = $ProductoModel->where('activo', 0)->findAll();

        return view('pages/productos/productosEliminados', ['productos' => $productos]);
    }

    public function restaurarProducto($id)
    {
        if (!session()->get('isLoggedIn') || session()->get('id_perfil') !== '3') {
            return redirect()->to('/login')->with('error', 'Acceso no autorizado.');
        }
        $ProductoModel = new ProductoModel();
        $ProductoModel->update($id, ['activo' => 1]);

        return redirect()->to('producto')->with('success', 'Producto restaurado');
    }
    public function editarStock($id)
    {
        $productoModel = new ProductoModel();
        $producto = $productoModel->find($id);

        if (!$producto) {
            return redirect()->to('producto')->with('error', 'Producto no encontrado.');
        }

        return view('pages/productos/editarStock', ['producto' => $producto]);
    }
    public function actualizarStock($id)
    {
        $productoModel = new ProductoModel();
        $nuevoStock = $this->request->getPost('stock');

        $productoModel->update($id, ['stock' => $nuevoStock]);

        return redirect()->to('producto')->with('message', 'Stock actualizado correctamente.');
    }
}
