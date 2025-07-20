<head>
    <title>Actualizar Stock</title>
    <link href="<?= base_url('assets/css/bootstrap.min.css') ?>" rel="stylesheet">
    <link href="<?= base_url('assets/css/miestilo.css') ?>" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="icon" href="<?= base_url('assets/img/logo.jpg') ?>" type="image/x-icon">
</head>
<div class="container mt-4 p-3 rounded" style="background-color: darkgray;">
    <div class="d-flex justify-content-between align-items-center position-relative">
        <div style="width: 150px;"></div>
        <h2 class="mb-0 text-center flex-grow-1">Actializar Stock</h2>
        <a href="<?= site_url('producto') ?>" class="btn btn-primary">
            <i class="bi bi-arrow-left-circle"></i> Volver
        </a>
    </div>
</div>

<form action="<?= site_url('producto/actualizarStock/' . $producto['id_producto']) ?>" method="POST">
    <?= csrf_field() ?>
    <div class="crearProducto"> 
    <div class="mb-3">
        <label>Nombre:</label>
        <input type="text" class="form-control" value="<?= esc($producto['nombre']) ?>" readonly>
    </div>
    <div class="mb-3">
        <label>Stock actual:</label>
        <input type="number" class="form-control" name="stock" value="<?= esc($producto['stock']) ?>" min="0">
    </div>
    <button type="submit" class="btn btn-success">Actualizar Stock</button>
    </div>
</form>

<script src="<?= base_url('assets/js/bootstrap.js') ?>"></script>