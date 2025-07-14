<head>
    <meta charset="UTF-8">
    <title>Panel Administrador</title>
    <link href="<?= base_url('assets/css/bootstrap.min.css') ?>" rel="stylesheet">
    <link href="<?= base_url('assets/css/miestilo.css') ?>" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="icon" href="<?= base_url('assets/img/logo.jpg') ?>" type="image/x-icon">
</head>


    <?php if (session()->getFlashdata('message')): ?>
        <div class="alert alert-success"><?= session()->getFlashdata('message') ?></div>
    <?php endif; ?>
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

    <div class="container mt-5">
        <h2 class="mb-4">Bienvenido, <?= session('usuario') ?? 'Administrador' ?></h2>
        <div class="row g-4">
            <div class="col-md-3">
                <a href="<?= site_url('usuario') ?>" class="text-decoration-none text-dark">
                    <div class="card text-center shadow-sm">
                        <div class="card-body">
                            <i class="bi bi-people-fill display-4"></i>
                            <h5 class="card-title mt-2">Usuarios</h5>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-md-3">
                <a href="<?= site_url('producto') ?>" class="text-decoration-none text-dark">
                    <div class="card text-center shadow-sm">
                        <div class="card-body">
                            <i class="bi bi-box-seam display-4"></i>
                            <h5 class="card-title mt-2">Productos</h5>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-md-3">
                <a href="<?= site_url('admin/ventas') ?>" class="text-decoration-none text-dark">
                    <div class="card text-center shadow-sm">
                        <div class="card-body">
                            <i class="bi bi-cart-check-fill display-4"></i>
                            <h5 class="card-title mt-2">Ventas</h5>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-md-3">
                <a href="<?= site_url('admin/consultas') ?>" class="text-decoration-none text-dark">
                    <div class="card text-center shadow-sm">
                        <div class="card-body">
                            <i class="bi bi-chat-dots-fill display-4"></i>
                            <h5 class="card-title mt-2">Consultas</h5>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-md-3">
                <a href="<?= site_url('admin/facturas') ?>" class="text-decoration-none text-dark">
                    <div class="card text-center shadow-sm">
                        <div class="card-body">
                            <i class="bi bi-file-earmark-text-fill display-4"></i>
                            <h5 class="card-title mt-2">Facturas</h5>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>
    <script src="<?= base_url('assets/js/bootstrap.js') ?>"></script>
