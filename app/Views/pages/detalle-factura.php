<?= $this->extend('templates/main-layout') ?>
<?= $this->section('contenido') ?>

<a href="<?= site_url('mis-facturas') ?>" class="btn btn-secondary">Volver</a>

<div class="detalles-factura">
    <img src="<?= base_url('assets/img/logo.jpg') ?>" alt="Logo" height="90" class="me-2">
    <h2>Factura N° <?= $factura['id_cabecera'] ?></h2>
    <h4><strong>Fecha:</strong> <?= $factura['fecha_creacion'] ?></h4>
</div>
<div class="container mt-5">
    <h4>Detalles</h4>
    <table class="table table-bordered align-middle text-center">
        <thead class="table-light">
            <tr>
                <th>Imagen</th>
                <th>Producto</th>
                <th>Cantidad</th>
                <th>Precio Unitario</th>
                <th>Descuento</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($detalles as $detalle): ?>
                <tr>
                    <td>
                        <?php if (!empty($detalle['url_imagen'])): ?>
                            <img src="<?= base_url('productos/img/' . $detalle['url_imagen']) ?>"
                                alt="<?= $detalle['nombre_producto'] ?>"
                                style="width: 80px; height: auto;">
                        <?php else: ?>
                            <span class="text-muted">Sin imagen</span>
                        <?php endif; ?>
                    </td>
                    <td><?= $detalle['nombre_producto'] ?? 'Producto eliminado' ?></td>
                    <td><?= $detalle['cantidad'] ?></td>
                    <td>$<?= number_format($detalle['precio_unitario'], 2) ?></td>
                    <td><?= $detalle['descuento'] ?? 0 ?>%</td>
                    <td>$<?= number_format($detalle['subtotal'], 2) ?></td>
                </tr>
            <?php endforeach ?>
        </tbody>
        <tfoot>
            <tr>
                <td colspan="5" class="text-start"><strong>Total:</strong></td>
                <td><strong>$<?= number_format($total, 2) ?></strong></td>
            </tr>
        </tfoot>

    </table>
</div>

<script src="<?= base_url('assets/js/bootstrap.js') ?>"></script>
<?= $this->endSection() ?>