<?= $this->extend('templates/main-layout') ?>

<?= $this->section('contenido') ?>
<div class="container mt-5">
    <div class="card shadow">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0">Mis Consultas</h4>
        </div>
        <div class="card-body">

            <?php if (empty($consultas)): ?>
                <div class="alert alert-info text-center">No has enviado ninguna consulta aún.</div>
            <?php else: ?>
                <div class="table-responsive">
                    <table class="table table-bordered align-middle text-center">
                        <thead class="table-dark">
                            <tr>
                                <th>Mensaje</th>
                                <th>Fecha</th>
                                <th>Estado</th>
                                <th>Respuesta</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($consultas as $consulta): ?>
                                <tr>
                                    <td class="text-start"><?= esc($consulta['mensaje']) ?></td>
                                    <td><?= date('d/m/Y H:i', strtotime($consulta['fecha_envio'])) ?></td>
                                    <td>
                                        <?php if ($consulta['contestado']): ?>
                                            <span class="badge bg-success">Respondida</span>
                                        <?php else: ?>
                                            <span class="badge bg-warning text-dark">Pendiente</span>
                                        <?php endif ?>
                                    </td>
                                    <td class="text-start">
                                        <?php if (!empty($consulta['respuesta'])): ?>
                                            <?= esc($consulta['respuesta']) ?>
                                        <?php else: ?>
                                            <em class="text-muted">Aún sin respuesta</em>
                                        <?php endif ?>
                                    </td>
                                </tr>
                            <?php endforeach ?>
                        </tbody>
                    </table>
                </div>
            <?php endif ?>

        </div>
    </div>
</div>
<?= $this->endSection() ?>