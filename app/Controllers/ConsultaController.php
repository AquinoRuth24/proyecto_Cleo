<?php

namespace App\Controllers;

use App\Models\ConsultaModel;
use App\Models\UsuarioModel;
use CodeIgniter\Controller as BaseController;

class ConsultaController extends BaseController
{
    protected $ConsultaModel;

    public function __construct()
    {
        $this->ConsultaModel = new ConsultaModel();
    }

    public function index()
    {
        $datosUsuario = [];

        if (session()->has('usuario')) {
            $datosUsuario['nombre'] = session('nombre') ?? '';
            $datosUsuario['email']  = session('email') ?? '';
        }
        return view('templates/main-layout', [
            'title'   => 'Consultas - Cleo',
            'content' => view('pages/consultas', ['datosUsuario' => $datosUsuario])
        ]);
    }


    public function enviar()
    {
        if ($this->request->getMethod() === 'POST') {
            $data = [
                'mensaje' => $this->request->getPost('mensaje'),
                'fecha_envio' => date('Y-m-d H:i:s'),
                'contestado' => 0
            ];

            if (session()->get('isLoggedIn')) {
                $userId = session()->get('user_id');

                // Validar que sea un ID existente
                if (!empty($userId) && is_numeric($userId)) {
                    $data['id_usuario'] = $userId;
                }
            } else {
                // Para usuarios no registrados: nombre y email
                $nombre = $this->request->getPost('nombre');
                $email  = $this->request->getPost('email');

                if (empty($nombre) || empty($email)) {
                    session()->setFlashdata('mensaje', 'Nombre y email son obligatorios para enviar la consulta.');
                    return redirect()->to('/consultas');
                }

                $data['nombre'] = $nombre;
                $data['email']  = $email;
            }

            if ($this->ConsultaModel->insert($data)) {
                session()->setFlashdata('mensaje', 'Consulta enviada correctamente.');
            } else {
                session()->setFlashdata('mensaje', 'Error al enviar la consulta. Intenta nuevamente.');
            }
        }

        return redirect()->to('/consultas');
    }

    public function misConsultas()
    {
        $usuarioId = session()->get('user_id');
        if (!$usuarioId) {
            return redirect()->to('/login')->with('mensaje', 'Debes iniciar sesión para ver tus consultas.');
        }

        $consultas = $this->ConsultaModel
            ->where('id_usuario', $usuarioId)
            ->orderBy('fecha_envio', 'DESC')
            ->findAll();

        return view('pages/mis_consultas', [
            'title' => 'Mis Consultas',
            'consultas' => $consultas
        ]);
    }


    public function admin()
    {
        if (!session()->get('isLoggedIn') || session()->get('id_perfil') !== '3') {
            return redirect()->to('/login')->with('error', 'Acceso no autorizado.');
        }
        $ConsultaModel = new ConsultaModel();
        $UsuarioModel = new UsuarioModel();

        $consultas = $ConsultaModel
            ->select('consulta.*, usuario.nombre as usuario_nombre, usuario.email as usuario_email')
            ->join('usuario', 'usuario.id_usuario = consulta.id_usuario', 'left')
            ->orderBy('fecha_envio', 'DESC')
            ->findAll();


        return view('pages/admin/consultas', [
            'title' => 'Consultas de usuarios',
            'consultas' => $consultas
        ]);
    }
    public function marcarContestado($id)
    {
        $this->ConsultaModel->update($id, ['contestado' => 1]);

        return redirect()->to(site_url('admin/consultas'))->with('mensaje', 'Consulta marcada como contestada.');
    }
    public function responder($id)
    {
        if ($this->request->getMethod() === 'POST') {
            $respuesta = $this->request->getPost('respuesta');

            $this->ConsultaModel->update($id, [
                'respuesta' => $respuesta,
                'contestado' => 1
            ]);

            return redirect()->to(site_url('admin/consultas'))->with('mensaje', 'Consulta respondida correctamente.');
        }

        $consulta = $this->ConsultaModel->find($id);

        return view('pages/admin/responder_consulta', [
            'title' => 'Responder Consulta',
            'consulta' => $consulta
        ]);
    }
    public function verRespuesta()
    {
        if ($this->request->getMethod() === 'post') {
            $email = $this->request->getPost('email');

            $consultas = $this->ConsultaModel
                ->where('email', $email)
                ->where('contestado', 1)
                ->orderBy('fecha_envio', 'DESC')
                ->findAll();

            return view('pages/consultas_no_logueado', [
                'title' => 'Respuestas a tus Consultas',
                'consultas' => $consultas,
                'email' => $email
            ]);
        }
    }
}
