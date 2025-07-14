<head>
    <title>Consultas Realizadas</title>
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
<div class="container mt-4 p-3 rounded" style="background-color: #e3f2fd;">
    <div class="d-flex justify-content-between align-items-center position-relative">
        <div style="width: 150px;"></div>
        <h2 class="mb-0 text-center flex-grow-1">Consultas Realizadas</h2>
        <a href="<?= site_url('administrador') ?>" class="btn btn-outline-primary">
            <i class="bi bi-arrow-left-circle"></i> Volver
        </a>
    </div>
</div>

<div class="container mt-4">
    <?php if (session()->getFlashdata('mensaje')): ?>
        <div class="alert alert-success text-center fw-bold">
            <?= session()->getFlashdata('mensaje') ?>
        </div>
    <?php endif ?>

    <div class="table-responsive">
        <table class="table table-bordered table-striped table-hover align-middle text-center">
            <thead class="table-primary">
                <tr>
                    <th>Nombre</th>
                    <th>Email</th>
                    <th>Mensaje</th>
                    <th>Respuesta</th>
                    <th>Fecha</th>
                    <th>Estado</th>
                    <th>Acción</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($consultas as $consulta): ?>
                    <tr>
                        <td class="text-start">
                            <?= esc($consulta['usuario_nombre'] ?? $consulta['nombre'] ?? 'Desconocido') ?>
                        </td>
                        <td>
                            <?= esc($consulta['usuario_email'] ?? $consulta['email'] ?? '-') ?>
                        </td>
                        <td class="text-start">
                            <?= esc($consulta['mensaje']) ?>
                        </td>
                        <td class="text-start">
                            <?= esc($consulta['respuesta']) ?: '<em class="text-muted">Sin respuesta</em>' ?>
                        </td>
                        <td><?= date('d/m/Y H:i', strtotime($consulta['fecha_envio'])) ?></td>
                        <td>
                            <?php if ($consulta['contestado']): ?>
                                <span class="badge bg-success">Contestado</span>
                            <?php else: ?>
                                <span class="badge bg-warning text-dark">Pendiente</span>
                            <?php endif ?>
                        </td>
                        <td>
                            <?php if (!$consulta['contestado']): ?>
                                <a href="<?= site_url('consultas/responder/' . $consulta['id_consulta']) ?>" class="btn btn-sm btn-success">
                                    Responder
                                </a>
                            <?php else: ?>
                                <span class="text-muted">Ya respondida</span>
                            <?php endif ?>
                        </td>
                    </tr>
                <?php endforeach ?>
            </tbody>
        </table>
    </div>
</div>

<script src="<?= base_url('assets/js/bootstrap.js') ?>"></script>