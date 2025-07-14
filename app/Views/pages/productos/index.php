<head>
    <title>Lista De Productos</title>
    <link href="<?= base_url('assets/css/bootstrap.min.css') ?>" rel="stylesheet">
    <link href="<?= base_url('assets/css/miestilo.css') ?>" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="icon" href="<?= base_url('assets/img/logo.jpg') ?>" type="image/x-icon">
</head>
<nav class="navbar navbar-expand-lg navbar-dark"
    style="background: linear-gradient(to right, #0f0c29, #302b63, #24243e);">
    <div class="container-fluid">
        <img src="<?= base_url('assets/img/logo.jpg') ?>" alt="Logo" height="60" class="me-2">
        <a class="navbar-brand fw-bold" href="#">ADMIN</a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarAdmin"
            aria-controls="navbarAdmin" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarAdmin">
            <ul class="navbar-nav me-auto d-flex flex-row">
                <li class="nav-item me-3">
                    <a class="nav-link" href="<?= site_url('principal') ?>">Home</a>
                </li>
                <li class="nav-item me-3">
                    <a class="nav-link" href="<?= site_url('usuario') ?>">Usuarios</a>
                </li>
                <li class="nav-item me-3">
                    <a class="nav-link" href="<?= site_url('producto') ?>">Productos</a>
                </li>
                <li class="nav-item me-3">
                    <a class="nav-link" href="<?= site_url('admin/ventas') ?>">Ventas</a>
                </li>
                <li class="nav-item me-3">
                    <a class="nav-link" href="<?= site_url('admin/consultas') ?>">Consultas</a>
                </li>
                <li class="nav-item me-3">
                    <a class="nav-link" href="<?= site_url('admin/facturas') ?>">Facturas</a>
                </li>
            </ul>
            <ul class="navbar-nav ms-auto d-flex align-items-center flex-row">
                <span class="navbar-text text-white me-3">
                    Usuario: <?= session('usuario') ?? 'admin' ?>
                </span>
                <li class="nav-item">
                    <a class="btn btn-outline-light" href="<?= site_url('logout') ?>">Cerrar sesión</a>
                </li>
            </ul>
        </div>
    </div>
</nav>
<!-- Estilos DataTables -->
<link href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css" rel="stylesheet">
<?php if (session()->getFlashdata('success')): ?>
    <div class="alert alert-success">
        <?= session()->getFlashdata('success') ?>
    </div>
<?php endif; ?>

<div class="container mt-4">
    <div class="d-flex justify-content-between mb-3">
        <h2>Productos</h2>
        <div>
            <a href="<?= site_url('producto/crearProducto') ?>" class="btn btn-success">Agregar</a>
            <a href="<?= site_url('producto/productosEliminados') ?>" class="btn btn-danger">Eliminados</a>
        </div>
    </div>

    <table id="tabla-productos" class="table table-striped table-bordered">
        <thead class="table-light">
            <tr>
                <th>ID</th>
                <th>Producto</th>
                <th>Precio</th>
                <th>Stock</th>
                <th>Imagen</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($productos as $producto): ?>
                <tr>
                    <td><?= esc($producto['id_producto']) ?></td>
                    <td><?= esc($producto['nombre']) ?></td>
                    <td>$<?= number_format($producto['precio'], 2) ?></td>
                    <td><?= esc($producto['stock']) ?></td>
                    <td>
                        <?php if (!empty($imagenes[$producto['id_producto']])): ?>
                            <img src="<?= base_url('/productos/img/' . $imagenes[$producto['id_producto']][0]) ?>" width="50" class="rounded">
                        <?php else: ?>
                            <span class="text-muted">Sin imagen</span>
                        <?php endif ?>
                    </td>
                    <td>
                        <a href="<?= site_url('producto/editarProducto/' . $producto['id_producto']) ?>" class="btn btn-sm btn-primary">Editar</a>
                        <a href="<?= site_url('producto/eliminarProducto/' . $producto['id_producto']) ?>" class="btn btn-sm btn-secondary">Borrar</a>
                    </td>
                </tr>
            <?php endforeach ?>
        </tbody>
    </table>
</div>

<!-- Scripts de DataTables -->
<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

<script>
    $(document).ready(function() {
        $('#tabla-productos').DataTable({
            language: {
                url: "<?= base_url('assets/i18n/es-ES.json') ?>"
            }
        });
    });
</script>
<script src="<?= base_url('assets/js/bootstrap.js') ?>"></script>