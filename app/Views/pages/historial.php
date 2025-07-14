<?= $this->extend('templates/main-layout') ?>

<?= $this->section('contenido') ?>

<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2 class="text-primary">Historial de Compras</h2>
        <a href="<?= base_url('/catalogoProductos') ?>" class="btn btn-success">
            <i class="bi bi-plus-circle"></i> Volver al catálogo
        </a>
    </div>

    <?php if (empty($historial)): ?>
        <div class="alert alert-info">No hay compras registradas.</div>
    <?php else: ?>
        <table class="table table-bordered table-striped table-hover shadow">
            <thead class="table-dark">
                <tr>
                    <th># Compra</th>
                    <th>Fecha</th>
                    <th>Productos</th>
                    <th>Total</th>
                    <th>Estado</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($historial as $compra): ?>
                    <tr>
                        <td><?= $compra['id_carrito'] ?></td>
                        <td><?= $compra['fecha_creado'] ?></td>
                        <td>
                            <ul class="list-unstyled mb-0">
                                <?php
                                $totalCompra = 0;
                                foreach ($compra['items'] as $item):
                                    $totalCompra += $item['precio_total'];
                                ?>
                                    <li>
                                        <?= esc($item['nombre_producto']) ?> -
                                        <?= $item['cantidad'] ?> ×
                                        $<?= number_format($item['precio_unitario'], 2) ?> =
                                        <span class="badge bg-secondary">
                                            $<?= number_format($item['precio_total'], 2) ?>
                                        </span>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        </td>
                        <td class="fw-bold text-success">$<?= number_format($totalCompra, 2) ?></td>
                        <td><span class="badge bg-success">Completado</span></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</div>

<?= $this->endSection() ?>