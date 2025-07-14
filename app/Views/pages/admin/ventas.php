<head>
    <meta charset="UTF-8">
    <title>Ventas Realizadas</title>
    <link href="<?= base_url('assets/css/bootstrap.min.css') ?>" rel="stylesheet">
    <link href="<?= base_url('assets/css/miestilo.css') ?>" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="icon" href="<?= base_url('assets/img/logo.jpg') ?>" type="image/x-icon">

</head>

<!-- NAVBAR -->
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
                    <a class="nav-link" href="<?= site_url('administrador') ?>">Home</a>
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
<div class="container mt-4 p-3 rounded" style="background-color: darkgray;">
    <div class="d-flex justify-content-between align-items-center position-relative">
        <div style="width: 150px;"></div>
        <h2 class="mb-0 text-center flex-grow-1"><i class="bi bi-cart-check"></i>Gestion De Ventas</h2>
        <a href="<?= site_url('administrador') ?>" class="btn btn-primary">
            <i class="bi bi-arrow-left-circle"></i> Volver
        </a>
    </div>
</div>

<div class="container mt-5">
    <div class="card shadow-sm border-0 mb-4">
        <div class="card-body py-3 px-4" style="background-color: #b3b3b3; border-radius: 0.5rem;">
            <div class="d-flex justify-content-between align-items-center">
                <h4 class="text-center flex-grow-1 mb-0 text-dark" style="font-weight: 600;">Listado de Ventas</h4>
                <a href="<?= site_url('administrador') ?>" class="btn btn-primary rounded">
                    <i class="bi bi-arrow-left-circle"></i> Volver
                </a>
            </div>
        </div>
    </div>

    <div class="table-responsive">
        <table class="table table-bordered align-middle text-center shadow-sm">
            <thead class="table-dark text-white">
                <tr>
                    <th>ID Venta</th>
                    <th>Fecha</th>
                    <th>Cliente</th>
                    <th>Detalle</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($ventas)): ?>
                    <tr>
                        <td colspan="5" class="text-center text-muted">No hay ventas registradas.</td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($ventas as $venta): ?>
                        <tr>
                            <td class="fw-semibold"><?= $venta['id_cabecera'] ?></td>
                            <td><?= date('d/m/Y H:i', strtotime($venta['fecha_creacion'])) ?></td>
                            <td>
                                <?= esc($venta['usuario']['nombre']) ?> <?= esc($venta['usuario']['apellido']) ?><br>
                                <small class="text-muted"><?= esc($venta['usuario']['email']) ?></small>
                            </td>
                            <td class="text-start">
                                <ul class="mb-0 list-unstyled">
                                    <?php foreach ($venta['facturas'] as $detalle): ?>
                                        <li>
                                            <strong><?= esc($detalle['producto']) ?></strong> |
                                            Cant: <?= $detalle['cantidad'] ?> |
                                            Precio: $<?= number_format($detalle['precio_unitario'], 2, ',', '.') ?>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>
                            </td>
                            <td class="fw-bold text-success">
                                $<?= number_format($venta['precio_total'], 2, ',', '.') ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<script src="<?= base_url('assets/js/bootstrap.min.js') ?>"></script>