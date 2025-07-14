<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// Página principal
$routes->get('/', 'Home::index');

// Páginas informativas
$routes->get('/quienesSomos', 'Home::quienesSomos');
$routes->get('/comercializacion', 'Home::comercializacion');
$routes->get('/informacionContacto', 'Home::informacionContacto');
$routes->get('/terminosYUsos', 'Home::terminosYUsos');
$routes->get('/registrar', 'Home::registrar');

// Consultas
$routes->get('/consulta', 'ConsultaController::index');
$routes->post('/consultas/enviar', 'ConsultaController::enviar');
$routes->get('mis_consultas', 'ConsultaController::misConsultas');
$routes->match(['get', 'post'], 'consultas/verRespuesta', 'ConsultaController::verRespuesta');
$routes->match(['get', 'post'], 'consultas/responder/(:num)', 'ConsultaController::responder/$1');
$routes->get('admin/consultas', 'ConsultaController::admin');
$routes->get('consultas/marcarContestado/(:num)', 'ConsultaController::marcarContestado/$1');
$routes->post('contacto/mensaje', 'ConsultaController::enviar');



//$routes->get('/consultas', 'Home::consultas');
$routes->get('/consultas', 'ConsultaController::index');
$routes->post('/consultas/enviar', 'ConsultaContoller::enviar');

// Autenticación
$routes->match(['get', 'post'], '/login', 'UsuarioController::login');
$routes->get('/logout', 'UsuarioController::logout');

// Registro de usuarios y administradores

$routes->post('/registrar', 'UsuarioController::registrar');
$routes->get('/administrador', 'AdministradorController::administrador');
$routes->get('usuario', 'UsuarioController::index');


// Página principal después del login
$routes->get('/principal', 'Principal::index');
$routes->get('/usuarioLogeado', 'UsuarioController::usuarioLogeado');



// productos
$routes->get('/producto', 'ProductoController::index');
$routes->match(['get', 'post'], '/producto/crearProducto', 'ProductoController::crearProducto');
$routes->get('/producto/eliminarProducto/(:num)', 'ProductoController::eliminarProducto/$1');
$routes->get('/producto/productosEliminados', 'ProductoController::productosEliminados');
$routes->get('/producto/restaurarProducto/(:num)', 'ProductoController::restaurarProducto/$1');
$routes->match(['get', 'post'], '/producto/editarProducto/(:num)', 'ProductoController::editarProducto/$1');

// ventas
$routes->get('admin/ventas', 'AdministradorController::ventas');
$routes->get('admin/facturas', 'AdministradorController::facturas');

// Categorías
$routes->get('catalogoProductos', 'CatalogoController::index');

// carrito de compras
$routes->get('carrito', 'CarritoController::ver');
$routes->get('carrito/agregar/(:num)', 'CarritoController::agregar/$1');
$routes->get('carrito/eliminar/(:num)', 'CarritoController::eliminar/$1');
$routes->get('mis-facturas', 'UsuarioController::misFacturas');


$routes->get('carrito/vaciar', 'CarritoController::vaciar');
$routes->get('pages/gracias', 'CarritoController::gracias');
$routes->get('mi-historial', 'CarritoController::historial');
$routes->post('carrito/terminarCompra', 'CarritoController::terminarCompra');
$routes->get('admin/registrar-venta', 'AdministradorController::registrarVenta');
$routes->get('subcategorias/(:num)', 'SubcategoriaController::obtenerPorCategoria/$1');
