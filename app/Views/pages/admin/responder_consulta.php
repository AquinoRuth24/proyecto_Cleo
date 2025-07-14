<head>
    <title>Responder A Consultas</title>
    <link href="<?= base_url('assets/css/bootstrap.min.css') ?>" rel="stylesheet">
    <link href="<?= base_url('assets/css/miestilo.css') ?>" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="icon" href="<?= base_url('assets/img/logo.jpg') ?>" type="image/x-icon">

</head>
<div class="container mt-5">
    <div class="card shadow-lg">
        <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
            <h5 class="mb-0">
                <i class="bi bi-chat-dots"></i> Responder Consulta
            </h5>
            <a href="<?= site_url('admin/consultas') ?>" class="btn btn-outline-light btn-sm">
                <i class="bi bi-arrow-left-circle"></i> Volver
            </a>
        </div>

        <div class="card-body">
            <div class="mb-4 row">
                <div class="col-md-6">
                    <p><strong>Nombre:</strong> <?= esc($consulta['nombre']) ?></p>
                    <p><strong>Email:</strong> <?= esc($consulta['email']) ?></p>
                </div>
                <div class="col-md-6">
                    <p><strong>Fecha:</strong> <?= date('d/m/Y H:i:s', strtotime($consulta['fecha_envio'])) ?></p>
                    <p>
                        <strong>Estado:</strong>
                        <?php if ($consulta['contestado']): ?>
                            <span class="badge bg-success">Respondida</span>
                        <?php else: ?>
                            <span class="badge bg-warning text-dark">Pendiente</span>
                        <?php endif; ?>
                    </p>
                </div>
            </div>

            <div class="mb-4">
                <h6 class="text-muted">Mensaje del usuario:</h6>
                <div class="p-3 bg-light rounded border">
                    <?= esc($consulta['mensaje']) ?>
                </div>
            </div>

            <form method="POST" action="<?= site_url('consultas/responder/' . $consulta['id_consulta']) ?>">
                <div class="mb-3">
                    <label for="respuesta" class="form-label fw-bold">Tu Respuesta:</label>
                    <textarea name="respuesta" id="respuesta" class="form-control" rows="6" required
                        placeholder="Escribí tu respuesta aquí..."><?= esc($consulta['respuesta']) ?></textarea>
                </div>

                <div class="d-flex justify-content-end">
                    <button type="submit" class="btn btn-success me-2">
                        <i class="bi bi-send-check"></i> Enviar respuesta
                    </button>
                    <a href="<?= site_url('admin/consultas') ?>" class="btn btn-secondary">
                        <i class="bi bi-x-circle"></i> Cancelar
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="<?= base_url('assets/js/bootstrap.js') ?>"></script>