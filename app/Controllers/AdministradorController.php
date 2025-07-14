<?php

namespace App\Controllers;

use App\Models\CabeceraModel;
use App\Models\FacturaModel;
use App\Models\ProductoModel;
use App\Models\UsuarioModel;
use App\Models\ImagenModel;


class AdministradorController extends BaseController
{
    public function administrador()
    {
        if (!session()->get('isLoggedIn') || session()->get('id_perfil') !== '3') {
            return redirect()->to('/login')->with('error', 'Acceso no autorizado.');
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

        return view('pages/administrador', ['productos' => $productos]);
    }

    public function ventas()
    {
        if (!session()->get('isLoggedIn') || session()->get('id_perfil') !== '3') {
            return redirect()->to('/login')->with('error', 'Acceso no autorizado.');
        }

        $CabeceraModel = new \App\Models\CabeceraModel();
        $FacturaModel = new \App\Models\FacturaModel();
        $ProductoModel = new \App\Models\ProductoModel();
        $UsuarioModel = new \App\Models\UsuarioModel();

        // Trae todas las ventas (cabeceras de factura)
        $ventas = $CabeceraModel->orderBy('fecha_creacion', 'DESC')->findAll();

        // Por cada cabecera, busca el usuario y los productos facturados
        foreach ($ventas as &$venta) {
            $venta['usuario'] = $UsuarioModel->find($venta['id_usuario']);

            $facturas = $FacturaModel->where('id_cabecera', $venta['id_cabecera'])->findAll();

            foreach ($facturas as &$factura) {
                $producto = $ProductoModel->find($factura['id_producto']);
                $factura['producto'] = $producto ? $producto['nombre'] : 'Producto eliminado';
            }

            $venta['facturas'] = $facturas;
        }

        return view('pages/admin/ventas', ['ventas' => $ventas]);
    }
    public function facturas()
    {
        if (!session()->get('isLoggedIn') || session()->get('id_perfil') !== '3') {
            return redirect()->to('/login')->with('error', 'Acceso no autorizado.');
        }

        $CabeceraModel = new CabeceraModel();
        $FacturaModel = new FacturaModel();
        $ProductoModel = new ProductoModel();
        $UsuarioModel = new UsuarioModel();

        $fecha = $this->request->getGet('fecha');
        $cliente = $this->request->getGet('cliente');

        $builder = $CabeceraModel;


        if (!empty($fecha)) {
            $builder = $builder->where('DATE(fecha_creacion)', $fecha);
        }


        if (!empty($cliente)) {
            $builder = $builder->where('id_usuario', $cliente);
        }


        $cabeceras = $builder->orderBy('fecha_creacion', 'DESC')->findAll();

        foreach ($cabeceras as &$cabecera) {

            $cabecera['usuario'] = $UsuarioModel->find($cabecera['id_usuario']);

            $facturas = $FacturaModel->where('id_cabecera', $cabecera['id_cabecera'])->findAll();

            foreach ($facturas as &$factura) {
                $producto = $ProductoModel->find($factura['id_producto']);
                $factura['producto'] = $producto ? $producto['nombre'] : 'Producto eliminado';
            }

            $cabecera['facturas'] = $facturas;
        }
        $usuarios = $UsuarioModel->findAll();

        return view('pages/admin/facturas', [
            'cabeceras' => $cabeceras,
            'usuarios' => $usuarios,
            'fecha' => $fecha,
            'clienteSeleccionado' => $cliente
        ]);
    }
    private function verificarAcceso()
    {
        if (!session()->get('isLoggedIn') || session()->get('id_perfil') !== '3') {
            redirect()->to('/login')->with('error', 'Acceso no autorizado.')->send();
            exit;
        }
    }
    public function registrarVenta()
    {
        $this->verificarAcceso();

        $CabeceraModel = new \App\Models\CabeceraModel();
        $FacturaModel = new \App\Models\FacturaModel();

        $id_usuario = 1;
        $fecha = date('Y-m-d H:i:s');

        $CabeceraModel->insert([
            'id_usuario' => $id_usuario,
            'fecha_creacion' => $fecha,
            'precio_total' => 15000
        ]);

        $id_cabecera = $CabeceraModel->insertID();

        $FacturaModel->insert([
            'id_cabecera' => $id_cabecera,
            'id_producto' => 1,
            'cantidad' => 1,
            'precio_unitario' => 15000.00,
            'descuento' => 0,
            'subtotal' => 15000.00
        ]);

        return redirect()->to('/admin/facturas')->with('mensaje', 'Venta registrada correctamente.');
    }

}
