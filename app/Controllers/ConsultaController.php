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

            if (!empty($userId) && is_numeric($userId)) {
                $data['id_usuario'] = $userId;
            }
        } else {
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
            $destinatario = session()->get('isLoggedIn') && session()->get('email')
                ? session()->get('email')
                : ($data['email'] ?? null);

            $nombre = session()->get('isLoggedIn') && session()->get('nombre')
                ? session()->get('nombre')
                : ($data['nombre'] ?? 'Usuario');

            // Correo para el usuario
            $mensajeCorreo = "
                <p>Hola <strong>{$nombre}</strong>,</p>
                <p>Gracias por comunicarte con nosotros. Hemos recibido tu consulta y te responderemos a la brevedad.</p>
                <p>Atentamente,<br>Equipo de Cleo</p>
            ";
            $this->enviarCorreo($destinatario, 'Confirmación de consulta - Cleo', $mensajeCorreo);

            // Correo para el administrador
            $mensajeAdmin = "
                <p><strong>{$nombre}</strong> ha enviado una consulta desde Cleo.</p>
                <p><strong>Email:</strong> {$destinatario}</p>
                <p><strong>Mensaje:</strong></p>
                <blockquote>{$data['mensaje']}</blockquote>
                <p>
                    <a href='mailto:{$destinatario}?subject=Respuesta%20a%20tu%20consulta%20en%20Cleo' 
                    style='display:inline-block;padding:10px 15px;background:#28a745;color:#fff;text-decoration:none;border-radius:5px;'>
                        Responder por correo
                    </a>
                </p>
            ";
            $this->enviarCorreo('Cleobisuteria7@gmail.com', 'Nueva consulta recibida', $mensajeAdmin);

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
        $consulta = $this->ConsultaModel->find($id);

        if (!empty($consulta['id_usuario'])) {
            $usuarioModel = new \App\Models\UsuarioModel();
            $usuario = $usuarioModel->find($consulta['id_usuario']);
            $consulta['nombre'] = $usuario['nombre'] ?? 'Cliente';
            $consulta['email'] = $usuario['email'] ?? '';
        }

        if ($this->request->getMethod() === 'POST') {
            $respuesta = $this->request->getPost('respuesta');

            $this->ConsultaModel->update($id, [
                'respuesta' => $respuesta,
                'contestado' => 1
            ]);

            $mensajeCorreo = "
            <p>Hola <strong>{$consulta['nombre']}</strong>,</p>
            <p>Hemos respondido tu consulta:</p>
            <blockquote style='border-left: 4px solid #ccc; padding-left: 10px;'>{$respuesta}</blockquote>
            <p>Gracias por contactarte con Cleo.</p>";

            if (!empty($consulta['email'])) {
                $this->enviarCorreo($consulta['email'], 'Respuesta a tu consulta - Cleo', $mensajeCorreo);
            }

            return redirect()->to(site_url('admin/consultas'))->with('mensaje', 'Consulta respondida correctamente.');
        }

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
    private function enviarCorreo($destinatario, $asunto, $mensaje)
    {
        if (empty($destinatario) || !filter_var($destinatario, FILTER_VALIDATE_EMAIL)) {
            log_message('error', 'Error: destinatario inválido o vacío → ' . var_export($destinatario, true));
            return false;
        }

        $email = \Config\Services::email();
        $email->setTo($destinatario);
        $email->setFrom('Cleobisuteria7@gmail.com', 'Cleo Web');
        $email->setSubject($asunto);
        $email->setMessage($mensaje);

        if (!$email->send()) {
            log_message('error', ' Error al enviar correo: ' . $email->printDebugger(['headers', 'subject', 'body']));
            return false;
        }

        return true;
    }
}
