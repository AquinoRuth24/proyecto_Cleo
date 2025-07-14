<?php

namespace App\Controllers;

use App\Models\ProductoModel;
use App\Models\ImagenModel;
use App\Models\CategoriaModel;

class Home extends BaseController
{
    function index(): string
    {
        $ProductoModel = new ProductoModel();
        $ImagenModel = new ImagenModel();
        $CategoriaModel = new CategoriaModel();
        $productos = $ProductoModel->findAll();
        $imagenesBd = $ImagenModel->findAll();
        $categorias = $CategoriaModel->findAll();
        $imagenes = [];
        foreach ($imagenesBd as $imagen) {
            $imagenes[$imagen['id_producto']][] = $imagen['url_imagen'];
        }
        // Se definen las categorías a mostrar en la página principal
        $categoriasMostrar = ['pulseras','anillos','collares'];
        // Se filtran las categorías para mostrar solo las que están en $categoriasMostrar
        $categoriasFiltradas = array_filter($categorias, function ($cat) use ($categoriasMostrar) {
            return in_array($cat['nombre'], $categoriasMostrar);
        });

        $imagenesCategorias = [
            'Hombres' => 'assets/img/Camiseta-Barcelona2.jpg',
            'Mujeres' => 'assets/img/remera-Mujer.jpg',
            'Niños' => 'assets/img/remera-Nino.jpg',
            'Remeras' => 'assets/img/remera-masculina.jpg',
            'Buzos' => 'assets/img/buzo.jpg',
            'Camperas' => 'assets/img/campera-femenina.jpg',
            'Pantalones' => 'assets/img/pantalon-hombre.jpg',
            'Jeans' => 'assets/img/jeans-mujer.jpg',
            'Calzas' => 'assets/img/calza.jpg'
        ];

        return view('templates/main-layout', [
            'title' => 'Principal-Cleo',
            'content' => view('pages/principal', ['productos' => $productos, 'imagenes' => $imagenes, 'categorias' => $categoriasFiltradas, 'imagenesCategorias' => $imagenesCategorias])
        ]);
    }
    function quienesSomos(): string
    {
        return view('templates/main-layout', [
            'title' => '¿Quienes Somos? - Cleo',
            'content' => view('pages/quienesSomos')
        ]);
    }
    function comercializacion(): string
    {
        return view('templates/main-layout', [
            'title' => 'Comercializacion - Cleo',
            'content' => view('pages/comercializacion')
        ]);
    }
    function informacionContacto(): string
    {
        return view('templates/main-layout', [
            'title' => 'Informacion de Contacto - Cleo',
            'content' => view('pages/informacionContacto')
        ]);
    }
    function terminosYUsos(): string
    {
        return view('templates/main-layout', [
            'title' => 'Terminos y Usos - Cleo',
            'content' => view('pages/terminosYUsos')
        ]);
    }

    function catalogoProductos(): string
    {
        return view('templates/main-layout', [
            'title' => 'Catalogo de Productos - Cleo',
            'content' => view('pages/catalogoProductos')
        ]);
    }
    function consultas()
    {
        return view('templates/main-layout', [
            'title' => 'Consultas-Cleo',
            'content' => view('pages/consultas')
        ]);
    }

    function administrador(): string
    {
        return view('templates/main-layout', [
            'title' => 'administrador - Cleo',
            'content' => view('pages/administrador')
        ]);
    }


    function carrito(): string
    {
        return view('templates/main-layout', [
            'title' => 'Mi Carrito - Cleo',
            'content' => view('pages/carrito')
        ]);
    }
    function login(): string
    {
        return view('templates/main-layout', [
            'title' => 'Inicio Sesion- Cleo',
            'content' => view('pages/login')
        ]);
    }
    function registrar(): string
    {
        return view('templates/main-layout', [
            'title' => 'Registro de Usuario - Cleo',
            'content' => view('pages/registrar')
        ]);
    }

    function guardarUsuario()
    {
        $nombre = $this->request->getPost('nombre');
        $email = $this->request->getPost('email');
        $telefono = $this->request->getPost('telefono');
        $password = $this->request->getPost('password');
    }



    function enviarMensaje()
    {
        $nombre = $this->request->getPost('nombre');
        $email = $this->request->getPost('email');
        $telefono = $this->request->getPost('telefono');
        $mensaje = $this->request->getPost('mensaje');

        // Acá podrías guardar el mensaje en la base de datos o enviarlo por email
        // Ejemplo de guardar en la tabla 'mensajes':
        /*
    $contactoModel = new \App\Models\ContactoModel();
    $contactoModel->save([
        'nombre' => $nombre,
        'email' => $email,
        'telefono' => $telefono,
        'mensaje' => $mensaje,
    ]);
    */

        return redirect()->back()->with('mensaje', '¡Gracias por tu consulta! Te responderemos pronto.');
    }
}
