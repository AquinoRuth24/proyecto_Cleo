<section class="hero bg-light py-5 text-center">
    <div class="container">
        <h1 class="display-5">Consultas</h1>
        <p class="lead">¿Tenés alguna duda? ¡Escribinos y te responderemos pronto!</p>
    </div>
</section>

<section class="formulario py-5">
    <div class="container">
        <?php if (session()->getFlashdata('mensaje')): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <?= session()->getFlashdata('mensaje') ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
            </div>
        <?php endif; ?>

        <div class="card shadow-lg mx-auto" style="max-width: 600px;">
            <div class="card-body">
                <h2 class="card-title text-center mb-4">Formulario de Consultas</h2>

                <form action="<?= base_url('/consultas/enviar') ?>" method="post">
                    <?php if (!session()->get('isLoggedIn')): ?>
                        <div class="mb-3">
                            <label for="nombre" class="form-label">Nombre completo</label>
                            <input type="text" class="form-control" id="nombre" name="nombre"
                                value="<?= esc(session()->get('nombre') ?? '') ?>"
                                required minlength="3" maxlength="50"
                                pattern="^[A-Za-zÁÉÍÓÚáéíóúÑñ\s]+$" placeholder="Ej: María López">
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">Correo electrónico</label>
                            <input type="email" class="form-control" id="email" name="email"
                                value="<?= esc(session()->get('email') ?? '') ?>"
                                required pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$"
                                maxlength="50" minlength="10" placeholder="Ej: lucas.beltran@gmail.com">
                        </div>
                    <?php endif; ?>

                    <div class="mb-3">
                        <label for="mensaje" class="form-label">Consulta</label>
                        <textarea class="form-control" id="mensaje" name="mensaje" rows="5"
                            required minlength="10" maxlength="1000"
                            placeholder="Escribí tu mensaje aquí..."></textarea>
                    </div>

                    <div class="d-grid">
                        <button type="submit" class="btn btn-success btn-lg">
                            <i class="bi bi-send-fill me-1"></i> Enviar Consulta
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>