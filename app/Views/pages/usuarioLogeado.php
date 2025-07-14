<h2 class="mt-4 text-center text-primary fw-bold">¡Bienvenido, <?= esc(session('nombre')) ?>!</h2>
<p class="text-center">Gracias por iniciar sesión en <strong>Yesi Yohi Store</strong>.</p>

<?php if (session()->getFlashdata('message')): ?>
    <div class="alert alert-success text-center"><?= session()->getFlashdata('message') ?></div>
<?php endif; ?>

<div class="container d-flex justify-content-center mt-5">
    <div class="card shadow" style="width: 100%; max-width: 500px;">
        <div class="card-header bg-gradient" style="background: linear-gradient(to right, #0f0c29, #302b63, #24243e); color: white;">
            <h5 class="mb-0">Información de usuario</h5>
        </div>
        <div class="card-body bg-light">
            <p><i class="bi bi-person-circle text-primary"></i> <strong>Nombre:</strong> <?= esc(session('nombre')) ?></p>
            <p><i class="bi bi-envelope-fill text-primary"></i> <strong>Email:</strong> <?= esc(session('email')) ?></p>
            <p><i class="bi bi-telephone-fill text-primary"></i> <strong>Teléfono:</strong> <?= esc(session('telefono')) ?></p>
        </div>
    </div>
</div>