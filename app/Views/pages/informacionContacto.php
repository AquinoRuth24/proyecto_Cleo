<section class="hero">
    <h1>Información de Contacto</h1>
    <div class="info">
        <ul class="list-unstyled">
            <li>En esta sección encontrarás información sobre cómo contactarnos y resolver tus dudas.</li>
            <li>Si tienes alguna pregunta o inquietud, no dudes en ponerte en contacto con nosotros!</li>
        </ul>
    </div>
</section>

<div class="container mt-4">
    <div class="row g-4">

        <div class="col-md-6">
            <div class="card h-100 shadow-sm">
                <div class="card-body">
                    <h5 class="card-title"><strong>Donde Encontrarnos!</strong></h5>
                    <ul class="list-unstyled">
                        <li>📍🌍Direccion fisica:</li>
                        <li style="padding-left: 2rem;">Entre las avenidas La Paz y Bariloche,Corrientes,Corrientes,Argentina</li>
                        <iframe
                            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3539.307795686855!2d-58.828155826144965!3d-27.49080151760266!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x94456b0a02186bb9%3A0x6cdc1aa114a73e94!2sColegio%20Secundario%20Dr.%20Luis%20Federico%20Leloir!5e0!3m2!1ses-419!2sar!4v1752533727121!5m2!1ses-419!2sar"
                            width="400" height="200" style="border:0;" allowfullscreen="" loading="lazy"
                            referrerpolicy="no-referrer-when-downgrade">
                        </iframe>
                    </ul>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card h-100 shadow-sm">
                <div class="card-body">
                    <h5 class="card-title"><strong>¿Cómo contactarnos?</strong></h5>
                    <ul class="list-unstyled">
                        <li style="margin-top: 1rem;"> <img src="assets/img/instagram.jpg" alt="Instagram"
                                height="40">Instagram: <a href="https://www.instagram.com/cleo.bisuteriaa?igsh=Z2RmMzM4ZXI3bHB5"
                                target="_blank">@cleo</a></li>
                        <li style="margin-top: 1rem;">Contacto: Aquino Belen:</li>
                        <li style="padding-left: 2rem;"><img src="assets/img/logoWpp.jpg" alt="Whatsapp"
                                height="40">: <a href="tel:+54 9 3795-103530">+54 9 379 530-8583</a></li>
                        <li>📧Email: <a href="mailto:andres.bareiro@outlook.com">andres.bareiro@outlook.com</a></li>
                        <li style="margin-top: 1rem;">Contacto: Aquino Ruth:</li>
                        <li style="padding-left: 2rem;"><img src="assets/img/logoWpp.jpg" alt="Whatsapp"
                                height="40">: <a href="tel:+54 9 379 480-0790">+54 9 379 480-0790</a></li>
                        <li>📧Email: <a href="mailto:aquinoruth2004@gmail.com">aquinoruth2004@gmail.com</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<section class="hero bg-light py-5 text-center">
    <div class="container">
        <h1 class="display-5">Formulario de Mensaje</h1>
        <p class="lead">Envianos tus dudas o comentarios.</p>
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

        <div class="card shadow mx-auto" style="max-width: 600px;">
            <div class="card-body">
                <h2 class="text-center mb-4">Formulario de Mensaje</h2>

                <form action="<?= base_url('/contacto/mensaje') ?>" method="POST">
                    <div class="mb-3">
                        <label for="nombre" class="form-label">Nombre completo</label>
                        <input type="text" class="form-control" id="nombre" name="nombre" required
                            minlength="3" maxlength="50" pattern="^[A-Za-zÁÉÍÓÚáéíóúÑñ\s]+$"
                            placeholder="Ej: María López">
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">Correo electrónico</label>
                        <input type="email" class="form-control" id="email" name="email" required
                            pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$"
                            maxlength="50" minlength="10" placeholder="Ej: lucas.beltran@gmail.com">
                    </div>

                    <div class="mb-3">
                        <label for="mensaje" class="form-label">Mensaje</label>
                        <textarea class="form-control" id="mensaje" name="mensaje" rows="5" required
                            minlength="10" maxlength="1000"
                            placeholder="Escribe tu mensaje aquí..."></textarea>
                    </div>

                    <div class="d-grid">
                        <button type="submit" class="btn btn-success">
                            <i class="bi bi-send-fill me-1"></i> Enviar mensaje
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>