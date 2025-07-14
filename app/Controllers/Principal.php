<?php

namespace App\Controllers;
use App\Models\CategoriaModel;
class Principal extends BaseController
{
    public function index()
    {
        // Proteger la página: solo usuarios logueados pueden verla
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/login')->with('error', 'Por favor, inicie sesión para acceder a esta página.');
        }

        $CategoriaModel = new CategoriaModel();
        $categorias = $CategoriaModel->findAll();

        return view('templates/main-layout', [
            'title' => 'Bienvenido - Cleo',
            'content' => view('pages/usuarioLogeado', [
                'nombre' => session('nombre'),
                'email' => session('email'),
                'telefono' => session('telefono'),
                'categorias' => $categorias
            ])
        ]);
    }
    
}
