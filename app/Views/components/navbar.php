<?php
$actualMethod = service('router')->methodName();
?>

<nav class="navbar navbar-expand-lg navbar-dark" style="background: linear-gradient(to right, #0f0c29, #302b63, #24243e);">
    <div class="container-fluid">
        <img src="assets/img/logo.jpg" alt="" height="80">
        <a class="navbar-brand" href="<?= base_url() ?>">Cleo</a>

        <!-- Botón hamburguesa -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Opciones del menú -->
        <div class="collapse navbar-collapse shadow" id="navbarNav" style="background-color:rgb(39, 38, 39);">
            <!-- Usuario No Logeado -->
            <ul class="navbar-nav me-auto">
                <li class="nav-item"><a class="nav-link <?= ($actualMethod === 'index') ? 'active text-success' : '' ?>" href="<?= base_url() ?>">Inicio</a></li>
                <li class="nav-item"><a class="nav-link <?= ($actualMethod === 'quienesSomos') ? 'active text-success' : '' ?>" href="<?= base_url('quienesSomos') ?>">Quienes Somos</a></li>
                <li class="nav-item"><a class="nav-link <?= ($actualMethod === 'informacionContacto') ? 'active text-success' : '' ?>" href="<?= base_url('informacionContacto') ?>">Contacto</a></li>
                <li class="nav-item"><a class="nav-link <?= ($actualMethod === 'catalogoProductos') ? 'active text-success' : '' ?>" href="<?= base_url('catalogoProductos') ?>">Catálogo</a></li>
                <!--Usuario logeado-->
                <?php if (session()->get('isLoggedIn')): ?>
                    <li class="nav-item"><a class="nav-link <?= ($actualMethod === 'consultas') ? 'active text-success' : '' ?>" href="<?= base_url('consultas') ?>">Consulta</a></li>
                    <li class="nav-item"><a class="nav-link <?= ($actualMethod === 'misConsultas') ? 'active text-success' : '' ?>" href="<?= base_url('mis_consultas') ?>">Mis Consultas</a></li>
                    <li class="nav-item"><a class="nav-link <?= ($actualMethod === 'usuarioLogeado') ? 'active text-success' : '' ?>" href="<?= base_url('usuarioLogeado') ?>">Usuario</a></li>
                    <li class="nav-item"><a class="nav-link <?= ($actualMethod === 'mis-facturas') ? 'active text-success' : '' ?>" href="<?= base_url('mis-facturas') ?>">Mis Facturas</a></li>
                    <!--Administrador-->
                    <?php if (session()->get('id_perfil') === '3'): ?>
                        <li class="nav-item"><a class="nav-link <?= ($actualMethod === 'administrador') ? 'active text-success' : '' ?>" href="<?= base_url('administrador') ?>">Administración</a></li>
                    <?php endif; ?>
                <?php endif; ?>
            </ul>

            <!-- Iconos y sesión -->
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link text-white" href="<?= base_url('carrito') ?>"><i class="bi bi-cart-fill"></i></a>
                </li>
                <!--Usuario Logeado-->
                <?php if (session()->get('isLoggedIn')): ?>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="<?= base_url('usuarioLogeado') ?>"><i class="bi bi-person-fill"></i></a>
                    </li>
                    <li class="nav-item">
                        <a class="btn btn-outline-light ms-2" href="<?= base_url('/logout') ?>">Cerrar sesión</a>
                    </li>
                <?php else: ?>
                    <!--NO logeado-->
                    <li class="nav-item">
                        <a class="nav-link text-white" href="<?= base_url('login') ?>"><i class="bi bi-person-circle"></i></a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        var navbarCollapse = document.getElementById('navbarNav');
        var navLinks = document.querySelectorAll('.nav-link');

        navLinks.forEach(function(link) {
            link.addEventListener('click', function() {
                if (window.innerWidth < 992) {
                    var collapse = new bootstrap.Collapse(navbarCollapse, {
                        toggle: false
                    });
                    collapse.hide();
                }
            });
        });
    });
</script>