<section class="registrar">
    <h1>Registro de Usuario</h1>
    <p>Por favor, complete el siguiente formulario para registrarse.</p>
</section>
<?php if (session()->getFlashdata('error')): ?>
    <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
<?php endif; ?>
<?php if (session()->getFlashdata('success')): ?>
    <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
<?php endif; ?>

<form action="<?= base_url('/registrar') ?>" method="post">
    <div class="formularioRegistro">
        <div class="container mt-4">
            <div class="mb-3">
                <label for="nombre" class="form-label">Nombre</label>
                <input type="text" class="form-control border border-dark text-dark" id="nombre" name="nombre" value="<?= old('nombre') ?>" required
                    minlength="3" maxlength="50" title="Nombre" pattern="^[A-Za-zÁÉÍÓÚáéíóúÑñ\s]+$">
            </div>

            <div class="mb-3">
                <label for="apellido" class="form-label">Apellido</label>
                <input type="text" class="form-control border border-dark text-dark" id="apellido" name="apellido" value="<?= old('apellido') ?>" required
                    minlength="3" maxlength="50" title="Apellido" pattern="^[A-Za-zÁÉÍÓÚáéíóúÑñ\s]+$">
            </div>
            <div class="mb-3">
                <label for="telefono" class="form-label">Teléfono</label>
                <input type="tel" class="form-control border border-dark text-dark" id="telefono" name="telefono" value="<?= old('telefono') ?>" required
                    pattern="[0-9]{10}" title="Número de teléfono válido de 10 dígitos" maxlength="10" minlength="10"
                    placeholder="Ej: 3794222684">
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Correo electrónico</label>
                <input type="email" class="form-control border border-dark text-dark" id="email" name="email" value="<?= old('email') ?>" required
                    title="email valido" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$" maxlength="50" minlength="10">
            </div>
            <div>
                <div>
                    <label for="password" class="form-label">Contraseña</label>
                    <input type="password" class="form-control border border-dark text-dark" id="password" name="password" required
                        minlength="6" maxlength="20" title="La contraseña debe tener entre 6 y 20 caracteres">
                </div>
                <div class="mb-3">
                    <label for="confirmar_password" class="form-label">Confirmar Contraseña</label>
                    <input type="password" class="form-control border border-dark text-dark" id="confirmar_password"
                        name="confirmar_password" required minlength="6" maxlength="20"
                        title="La contraseña debe tener entre 6 y 20 caracteres">
                </div>
                <div class="form-check mt-2">
                    <input class="form-check-input" type="checkbox" id="verPassword" onclick="mostrarPassword()">
                    <label class="form-check-label" for="verPassword">Mostrar contraseña</label>
                </div>
            </div>
            <script>
                function mostrarPassword() {
                    var pass = document.getElementById("password");
                    var confirm = document.getElementById("confirmar_password");
                    if (pass.type === "password") {
                        pass.type = "text";
                        confirm.type = "text";
                    } else {
                        pass.type = "password";
                        confirm.type = "password";
                    }
                }
            </script>
            <button type="submit" class="btn btn-primary">Registrar</button>
        </div>
    </div>
</form>
<script>
    const pass = document.getElementById("password");
    const confirm = document.getElementById("confirmar_password");

    pass.addEventListener("input", () => {
        console.log("Contraseña:", pass.type, pass.value);
    });

    confirm.addEventListener("focus", () => {
        console.log("Focus en confirmar contraseña");
        console.log("Tipos actuales:", "Password:", pass.type, "Confirmar:", confirm.type);
    });
</script>