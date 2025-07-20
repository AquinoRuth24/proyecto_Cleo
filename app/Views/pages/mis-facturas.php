<?= $this->extend('templates/main-layout') ?>

<?= $this->section('contenido') ?>
<div class="container mt-5">
    <h2>Mis facturas</h2>

    <?php if (empty($facturas)): ?>
        <p>No tenés compras registradas todavía.</p>
    <?php else: ?>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID Compra</th>
                    <th>Fecha</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($facturas as $compra): ?>
                    <tr>
                        <td><?= $compra['id_cabecera'] ?></td>
                        <td><?= $compra['fecha_creacion'] ?></td>
                        <td>$<?= number_format($compra['precio_total'], 2) ?></td>
                        <td>
                            <a href="<?= site_url('factura/ver/' . $compra['id_cabecera']) ?>"
                                class="btn btn-sm btn-primary">
                                Ver Detalle
                            </a>
                        </td>
                    </tr>
                <?php endforeach ?>
            </tbody>
        </table>
    <?php endif ?>
</div>
<script src="<?= base_url('assets/js/bootstrap.js') ?>"></script>
<?= $this->endSection() ?>