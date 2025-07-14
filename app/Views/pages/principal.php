<!-- Sección Hero (moderna) -->
<section class="hero h-[80vh] bg-cover bg-center flex items-center justify-center text-white text-center" style="background-image: linear-gradient(rgba(0,0,0,0.5), rgba(0,0,0,0.5)), url('https://images.unsplash.com/photo-1483985988355-763728e1935b?auto=format&fit=crop&w=1600&q=80');">
    <div class="px-4">
        <h1 class="text-4xl md:text-6xl font-bold mb-4">Bienvenido a Cleo</h1>
        <p class="text-xl md:text-2xl mb-6">dónde los sueños se vuelven accesorios.</p>
        <p>Diseños únicos en tonos naturales</p>
        <a href="<?php echo base_url('catalogoProductos'); ?>" class="bg-pink-600 hover:bg-pink-700 text-white font-semibold py-3 px-6 rounded-full text-lg transition duration-300">
            Ver Catalogo
        </a>
    </div>
</section>

<!-- Productos -->
<div class="container mt-5">
    <div class="border rounded shadow p-4 bg-white">
        <h4 class="mb-4 text-center">Productos destacados</h4>

        <div id="carouselProductos" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-inner">

                <?php foreach ($productos as $index => $producto): ?>
                    <div class="carousel-item <?= $index === 0 ? 'active' : '' ?>">
                        <div class="d-flex justify-content-center">
                            <div class="card" style="width: 250px;">

                                <!-- Galería de imágenes -->
                                <?php if (!empty($imagenes[$producto['id_producto']])): ?>
                                    <div class="d-flex flex-wrap justify-content-center">
                                        <?php foreach ($imagenes[$producto['id_producto']] as $imgIndex => $imagen): ?>
                                            <img src="<?= base_url('productos/img/' . esc($imagen)) ?>" class="m-1 border rounded"
                                                alt="<?= $producto['nombre'] ?>"
                                                style="width: 200px; height: 250px; object-fit: cover; cursor: zoom-in;"
                                                <?php endforeach; ?>
                                                <div class="d-flex justify-content-center">
                                            <button class="btn btn-primary" onclick="abrirGaleria(<?= htmlspecialchars(json_encode(array_map(function ($img) {
                                                                                                        return base_url('assets/img/' . $img);
                                                                                                    }, $imagenes[$producto['id_producto']]))) ?>, 0)">
                                                Ver galería
                                            </button>
                                    </div>
                                <?php endif; ?>

                                <div class="card-body text-center">
                                    <h6 class="card-title"><?= esc($producto['nombre']) ?></h6>
                                </div>

                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>

            </div>

            <!-- Controles carrusel principal -->
            <button class="carousel-control-prev" type="button" data-bs-target="#carouselProductos"
                data-bs-slide="prev">
                <span class="carousel-control-prev-icon bg-dark rounded-circle p-2" aria-hidden="true"></span>
                <span class="visually-hidden">Anterior</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouselProductos"
                data-bs-slide="next">
                <span class="carousel-control-next-icon bg-dark rounded-circle p-2" aria-hidden="true"></span>
                <span class="visually-hidden">Siguiente</span>
            </button>
        </div>
    </div>
</div>

<!-- Modal galería -->
<div class="modal fade" id="imagenModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content bg-dark position-relative">
            <button type="button" class="btn-close btn-close-white position-absolute top-0 end-0 m-3" data-bs-dismiss="modal" aria-label="Close"></button>


            <div class="modal-body text-center p-0">
                <img id="imagenModalSrc" src="" class="img-fluid" style="max-height: 90vh;">
            </div>

            <button class="btn btn-dark position-absolute top-50 start-0 translate-middle-y" onclick="cambiarImagen(-1)"
                style="z-index: 1055;">
                ‹
            </button>
            <button class="btn btn-dark position-absolute top-50 end-0 translate-middle-y" onclick="cambiarImagen(1)"
                style="z-index: 1055;">
                ›
            </button>
        </div>
    </div>
</div>

<section class="container my-5">
    <h4 class="text-center mb-4">Explorá nuestras categorías</h4>
    <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-4">
        <?php foreach ($categorias as $cat): ?>
            <div class="col">
                <a href="<?= base_url('catalogoProductos?categoria=' . $cat['id_categoria']) ?>" class="text-decoration-none">
                    <div class="card h-100 shadow-sm">
                        <img src="<?= base_url($imagenesCategorias[$cat['nombre']] ?? 'assets/img/default.jpg') ?>"
                            class="card-img-top" alt="<?= esc($cat['nombre']) ?>" style="height: 180px; object-fit: cover;">
                        <div class="card-body text-center">
                            <h6 class="card-title text-dark mb-0"><?= esc($cat['nombre']) ?></h6>
                        </div>
                    </div>
                </a>
            </div>
        <?php endforeach; ?>
    </div>
</section>

<script>
    let galeriaActual = [];
    let indiceActual = 0;

    function abrirGaleria(imagenes, indice) {
        galeriaActual = imagenes;
        indiceActual = indice;
        mostrarImagen();
        const modal = new bootstrap.Modal(document.getElementById('imagenModal'));
        modal.show();
    }

    function mostrarImagen() {
        const img = document.getElementById('imagenModalSrc');
        img.src = galeriaActual[indiceActual];
    }

    function cambiarImagen(direccion) {
        indiceActual += direccion;
        if (indiceActual < 0) indiceActual = galeriaActual.length - 1;
        if (indiceActual >= galeriaActual.length) indiceActual = 0;
        mostrarImagen();
    }
</script>