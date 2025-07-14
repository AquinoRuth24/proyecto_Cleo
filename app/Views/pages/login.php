<div class="background">
    <div class="d-flex justify-content-center align-items-center min-vh-100">
        <div class="login-box p-4 rounded-4">
            <h2 class="text-center text-white mb-4">Inicio De Sesion</h2>

            <?php if (session()->getFlashdata('error')): ?>
                <div class="alert alert-danger">
                    <?= session()->getFlashdata('error') ?>
                </div>
            <?php endif; ?>
            <?php if (session()->getFlashdata('message')): ?>
                <div class="alert alert-success">
                    <?= session()->getFlashdata('message') ?>
                </div>
            <?php endif; ?>

            <form action="<?= base_url('/login') ?>" method="post">
                <div class="input-group mb-3">
                    <span class="input-group-text"><i class="bi bi-person"></i></span>
                    <input type="email" class="form-control" id="email" name="email" required title="ingrese un email valido"
                        pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$" maxlength="50" minlength="10" placeholder="Correo electronico" value="<?= old('email') ?>" required>
                </div>

                <div class="input-group mb-3">
                    <span class="input-group-text"><i class="bi bi-lock"></i></span>
                    <input type="password" class="form-control" name="password" id="password" placeholder="Contraseña" required>
                </div>
                <div class="d-flex justify-content-between mb-3">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="verPassword" onclick="mostrarPassword()">
                        <label class="form-check-label text-white" for="verPassword">Mostrar contraseña</label>
                    </div>
                </div>

                <div class="d-grid mb-3">
                    <button type="submit" class="btn btn-light rounded-pill">Iniciar Sesion</button>
                </div>

                <p class="text-center text-white">No tiene una cuenta? <a href="<?= base_url('/registrar') ?>" class="text-white fw-bold text-decoration-underline">Registrate</a></p>
            </form>
        </div>
    </div>
</div>
<script>
    function mostrarPassword() {
        const input = document.getElementById("password");
        input.type = input.type === "password" ? "text" : "password";
    }
</script>