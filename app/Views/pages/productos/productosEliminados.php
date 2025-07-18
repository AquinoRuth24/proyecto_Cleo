<head>
    <title>Productos Eliminados</title>
    <link href="<?= base_url('assets/css/bootstrap.min.css') ?>" rel="stylesheet">
    <link href="<?= base_url('assets/css/miestilo.css') ?>" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="icon" href="<?= base_url('assets/img/logo.jpg') ?>" type="image/x-icon">
</head>

<div class="container mt-4 p-3 rounded" style="background-color: darkgray;">
    <div class="d-flex justify-content-between align-items-center position-relative">
        <div style="width: 150px;"></div>
        <h2 class="mb-0 text-center flex-grow-1">Productos Eliminados</h2>
        <a href="<?= site_url('producto') ?>" class="btn btn-primary">
            <i class="bi bi-arrow-left-circle"></i> Volver
        </a>
    </div>
</div>
<div class="container mt-4">


    <table class="table table-bordered">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Imagen</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($productos as $producto): ?>
                <tr>
                    <td><?= $producto['id_producto'] ?></td>
                    <td><?= esc($producto['nombre']) ?></td>
                    <td>
                        <?php if (!empty($imagenes[$producto['id_producto']])): ?>
                            <img src="<?= base_url('/productos/img/' . $imagenes[$producto['id_producto']][0]) ?>" width="50" class="rounded">
                        <?php else: ?>
                            <span class="text-muted">Sin imagen</span>
                        <?php endif ?>
                    </td>
                    <td>
                        <a href="<?= site_url('producto/restaurarProducto/' . $producto['id_producto']) ?>" class="btn btn-success btn-sm">Restaurar</a>
                    </td>
                </tr>
            <?php endforeach ?>
        </tbody>
    </table>
</div>
<script src="<?= base_url('assets/js/bootstrap.js') ?>"></script>