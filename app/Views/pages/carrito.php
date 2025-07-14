<?= $this->extend('templates/main-layout') ?>

<?= $this->section('contenido') ?>

<div class="container mt-5">
    <h2>Tu carrito</h2>

    <?php if (empty($carrito)): ?>
        <p>El carrito está vacío.</p>
    <?php else: ?>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Producto</th>
                    <th>Precio Unitario</th>
                    <th>Cantidad</th>
                    <th>Total</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php $total = 0; ?>
                <?php foreach ($carrito as $item): ?>
                    <?php $subtotal = $item['precio'] * $item['cantidad']; ?>
                    <?php $total += $subtotal; ?>
                    <tr>
                        <td><?= esc($item['nombre']) ?></td>
                        <td>$<?= number_format($item['precio'], 2) ?></td>
                        <td><?= esc($item['cantidad']) ?></td>
                        <td>$<?= number_format($subtotal, 2) ?></td>
                        <td>
                            <a href="<?= base_url('carrito/eliminar/' . $item['id']) ?>" class="btn btn-danger btn-sm">Eliminar</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
                <tr>
                    <td colspan="3"><strong>Total</strong></td>
                    <td colspan="2"><strong>$<?= number_format($total, 2) ?></strong></td>
                </tr>
            </tbody>
        </table>
        <a href="<?= base_url('carrito/vaciar') ?>" class="btn btn-warning">Vaciar carrito</a>
        <form action="<?= base_url('carrito/terminarCompra') ?>" method="POST" style="display:inline;">
            <button type="submit" class="btn btn-success">Finalizar compra</button>
        </form>
        <a href="<?= base_url('mi-historial') ?>" class="btn btn-info">Ver historial de compras</a>
    <?php endif; ?>

    <br><br>
    <a href="<?= base_url('/catalogoProductos') ?>" class="btn btn-secondary">Seguir comprando</a>
</div>

<?= $this->endSection() ?>