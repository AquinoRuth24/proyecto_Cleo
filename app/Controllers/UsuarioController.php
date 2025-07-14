<?php

namespace App\Controllers;

use App\Models\UsuarioModel;
use App\Models\ProductoModel;
use App\Models\ImagenModel;
use CodeIgniter\Controller;
use App\Models\CabeceraModel;

class UsuarioController extends Controller
{
    public function registrar()
    {
        $request = service('request');

        $nombre = $request->getPost('nombre');
        $apellido = $request->getPost('apellido');
        $telefono = $request->getPost('telefono');
        $email = $request->getPost('email');
        $password = $request->getPost('password');
        $confirmar = $request->getPost('confirmar_password');

        // Validar contraseñas iguales
        if ($password !== $confirmar) {
            return redirect()->back()->withInput()->with('error', 'Las contraseñas no coinciden.');
        }

        // Validar email duplicado
        $UsuarioModel = new UsuarioModel();
        if ($UsuarioModel->where('email', $email)->first()) {
            return redirect()->back()->withInput()->with('error', 'Este correo ya está registrado.');
        }

        // Guardar usuario
        $UsuarioModel->insert([
            'nombre' => $nombre,
            'apellido' => $apellido,
            'telefono' => $telefono,
            'email' => $email,
            'password' => password_hash($password, PASSWORD_BCRYPT),
            'id_perfil' => 1, // Asignar perfil cliente por defecto
            'estado' => 1 // Asignar estado activo por defecto
        ]);

        return redirect()->to('/login')->with('success', 'Usuario registrado correctamente.');
    }

    public function login()
    {
        $request = service('request');
        if (session()->get('isLoggedIn')) {
            return redirect()->to('/')->with('message', 'Ya estás logueado.');
        }
        if ($request->getMethod() === 'POST') {
            $email = $request->getPost('email');
            $password = $request->getPost('password');

            $UsuarioModel = new usuarioModel();
            $usuario = $UsuarioModel->where('email', $email)->first();

            if (!$usuario) {
                return redirect()->back()->withInput()->with('error', 'Usuario no encontrado.');
            }
            if (!password_verify($password, $usuario['password'])) {
                return redirect()->back()->withInput()->with('error', 'Contraseña incorrecta.');
            }
            $session = session();
            $session->set([
                'user_id' => $usuario['id_usuario'],
                'id_perfil' => $usuario['id_perfil'],
                'nombre' => $usuario['nombre'],
                'email' => $usuario['email'],
                'telefono' => $usuario['telefono'],
                'isLoggedIn' => true,
            ]);
            if ($usuario['id_perfil'] == 3) {
                return redirect()->to('/administrador')->with('message', 'Bienvenido al panel administrador.');
            } else {
                return redirect()->to('/')->with('message', 'Inicio de sesión exitoso.');
            }
        }
        return view('templates/main-layout', [
            'title' => 'Inicio Sesion- Cleo',
            'content' => view('pages/login')
        ]);
    }


    public function logout()
    {
        $session = session();
        $session->destroy();
        return redirect()->to('/principal')->with('message', 'Sesión cerrada correctamente.');
    }

    public function usuarioLogeado()
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/login')->with('error', 'Debes iniciar sesión para acceder a esta página.');
        }
        $ProductoModel = new ProductoModel();
        $ImagenModel = new ImagenModel();
        $productos = $ProductoModel->findAll();
        $imagenesBd = $ImagenModel->findAll();
        // Se combinan los productos con sus imágenes
        $imagenes = [];
        foreach ($imagenesBd as $imagen) {
            $imagenes[$imagen['id_producto']][] = $imagen['url_imagen'];
        }

        return view('templates/main-layout', [
            'title' => 'Bienvenido - Cleo',
            'content' => view('pages/usuarioLogeado', [
                'nombre' => session('nombre'),
                'email' => session('email'),
                'telefono' => session('telefono'),
                'productos' => $productos,
                'imagenes' => $imagenes
            ])
        ]);
    }
    public function index()
    {
        $UsuarioModel = new UsuarioModel();
        $CabeceraModel = new CabeceraModel();

        $usuarios = $UsuarioModel->findAll();

        foreach ($usuarios as &$usuario) {
            $usuario['compras'] = $CabeceraModel
                ->where('id_usuario', $usuario['id_usuario'])
                ->countAllResults();
        }

        return view('pages/admin/usuarios', ['usuarios' => $usuarios]);
    }
    public function misFacturas()
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/login')->with('error', 'Debés iniciar sesión para ver tus facturas.');
        }

        $idUsuario = session()->get('user_id');

        $CabeceraModel = new \App\Models\CabeceraModel();
        
        $facturas = $CabeceraModel
            ->where('id_usuario', $idUsuario)
            ->orderBy('fecha_creacion', 'DESC')
            ->findAll();

        return view('pages/mis-facturas', [
            'title' => 'Mis Facturas',
            'facturas' => $facturas
        ]);
    }
}
