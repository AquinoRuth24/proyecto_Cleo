<head>
    <meta charset="UTF-8">
    <title>Facturas</title>
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
<div class="container mt-5">
    <div class="card shadow-sm border-0 mb-4">
        <div class="card-body py-3 px-4" style="background-color: #b3b3b3; border-radius: 0.5rem;">
            <div class="d-flex justify-content-between align-items-center">
                <h4 class="text-center flex-grow-1 mb-0 text-dark" style="font-weight: 600;">Facturas De Clientes</h4>
                <a href="<?= site_url('administrador') ?>" class="btn btn-primary rounded">
                    <i class="bi bi-arrow-left-circle"></i> Volver
                </a>
            </div>
        </div>
    </div>

    <form method="get" class="card card-body shadow-sm mb-4 border-light">
        <div class="row g-3">
            <div class="col-md-4">
                <label class="form-label fw-semibold">Fecha</label>
                <input type="date" name="fecha" class="form-control" value="<?= esc($fecha) ?>">
            </div>
            <div class="col-md-4">
                <label class="form-label fw-semibold">Cliente</label>
                <select name="cliente" class="form-select">
                    <option value="">Todos</option>
                    <?php foreach ($usuarios as $usuario): ?>
                        <option value="<?= $usuario['id_usuario'] ?>" <?= $clienteSeleccionado == $usuario['id_usuario'] ? 'selected' : '' ?>>
                            <?= esc($usuario['nombre']) ?> (<?= esc($usuario['email']) ?>)
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-4 d-flex align-items-end">
                <button type="submit" class="btn btn-primary w-100">
                    <i class="bi bi-search"></i> Filtrar
                </button>
            </div>
        </div>
    </form>

    <?php if (empty($cabeceras)): ?>
        <div class="alert alert-info text-center">No se encontraron facturas para los filtros aplicados.</div>
    <?php endif; ?>

    <?php foreach ($cabeceras as $cabecera): ?>
        <div class="card mb-4 shadow-sm border-light">
            <div class="card-header bg-dark text-white">
                Factura N° <?= $cabecera['id_cabecera'] ?> | Usuario: <?= $cabecera['usuario']['nombre'] . ' ' . $cabecera['usuario']['apellido'] ?? 'Desconocido' ?> | Fecha: <?= date('d/m/Y H:i', strtotime($cabecera['fecha_creacion'])) ?>
            </div>
            <div class="card-body bg-light p-0">
                <div class="table-responsive">
                    <table class="table table-bordered m-0 text-center align-middle">
                        <thead class="table-dark text-white">
                            <tr>
                                <th>Producto</th>
                                <th>Cantidad</th>
                                <th>Precio Unitario</th>
                                <th>Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($cabecera['facturas'] as $factura): ?>
                                <tr>
                                    <td><?= esc($factura['producto']) ?></td>
                                    <td><?= $factura['cantidad'] ?></td>
                                    <td>$<?= number_format($factura['precio_unitario'], 2, ',', '.') ?></td>
                                    <td class="fw-semibold text-end">$<?= number_format($factura['subtotal'], 2, ',', '.') ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <div class="p-3 text-end fw-bold text-dark fs-5">
                    Total: $<?= number_format($cabecera['precio_total'], 2, ',', '.') ?>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>

<script src="<?= base_url('assets/js/bootstrap.min.js') ?>"></script>