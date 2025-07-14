<?= $this->extend('templates/main-layout') ?>
<?= $this->section('contenido') ?>

<?php if (session()->getFlashdata('success')): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <?= session()->getFlashdata('success') ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
    </div>
<?php endif; ?>

<?php if (session()->getFlashdata('error')): ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <?= session()->getFlashdata('error') ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
    </div>
<?php endif; ?>

<div class="catalogo">
    <h1>Catalogo De Productos</h1>
</div>
<div class="container-fluid">
    <div class="row">
        <!-- FILTROS LATERALES -->
        <aside class="col-md-3 mb-4">
            <form method="get" action="<?= site_url('catalogoProductos') ?>" class="filtros p-3 bg-white shadow rounded">
                <h5 class="mb-3"><i class="bi bi-funnel"></i> Filtros</h5>

                <div class="mb-3">
                    <input type="text" name="nombre" class="form-control" placeholder="Nombre del producto" value="<?= esc($filtros['nombre'] ?? '') ?>">
                </div>

                <div class="mb-3">
                    <div class="accordion mb-3" id="accordionCategoriasPrincipal">
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingCategorias">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseCategorias" aria-expanded="false" aria-controls="collapseCategorias">
                                    Categorías
                                </button>
                            </h2>
                            <div id="collapseCategorias" class="accordion-collapse collapse" aria-labelledby="headingCategorias">
                                <div class="accordion-body">
                                    <div class="accordion" id="subcategoriasAccordion">
                                        <?php foreach ($categoriasAgrupadas as $grupo => $subcategorias): ?>
                                            <div class="accordion-item">
                                                <h2 class="accordion-header" id="heading<?= md5($grupo) ?>">
                                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse<?= md5($grupo) ?>" aria-expanded="false" aria-controls="collapse<?= md5($grupo) ?>">
                                                        <?= esc($grupo) ?>
                                                    </button>
                                                </h2>
                                                <div id="collapse<?= md5($grupo) ?>" class="accordion-collapse collapse" aria-labelledby="heading<?= md5($grupo) ?>" data-bs-parent="#subcategoriasAccordion">
                                                    <div class="accordion-body">
                                                        <?php if (!empty($subcategorias) && is_array($subcategorias)): ?>
                                                            <?php foreach ($subcategorias as $sub): ?>
                                                                <div class="form-check">
                                                                    <input class="form-check-input"
                                                                        type="radio"
                                                                        name="subcategoria"
                                                                        value="<?= esc($sub['id_subcategoria']) ?>"
                                                                        id="cat<?= esc($sub['id_subcategoria']) ?>"
                                                                        <?= (isset($filtros['subcategoria']) && $filtros['subcategoria'] == $sub['id_subcategoria']) ? 'checked' : '' ?>>
                                                                    <label class="form-check-label" for="cat<?= esc($sub['id_subcategoria']) ?>">
                                                                        <?= esc($sub['nombre']) ?>
                                                                    </label>
                                                                </div>
                                                            <?php endforeach; ?>
                                                        <?php else: ?>
                                                            <p>No hay subcategorías disponibles.</p>
                                                        <?php endif; ?>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="mb-3">
                    <input type="number" name="precio_min" class="form-control" placeholder="Precio mínimo" value="<?= esc($filtros['precio_min'] ?? '') ?>">
                </div>

                <div class="mb-3">
                    <input type="number" name="precio_max" class="form-control" placeholder="Precio máximo" value="<?= esc($filtros['precio_max'] ?? '') ?>">
                </div>

                <button type="submit" class="btn btn-primary w-100"><i class="bi bi-search"></i> Buscar</button>
                <a href="<?= site_url('catalogoProductos') ?>" class="btn btn-secondary w-100 mt-2"><i class="bi bi-x-circle"></i> Limpiar</a>

            </form>
        </aside>

        <!-- LISTADO DE PRODUCTOS -->
        <section class="col-md-9">
            <div class="d-flex justify-content-end mb-3">
                <a href="<?= site_url('catalogoProductos') ?>" class="btn btn-outline-secondary btn-sm">
                    <i class="bi bi-x-circle"></i> Limpiar filtros
                </a>
            </div>
            <div class="row">

                <?php foreach ($productos as $prod): ?>
                    <div class="col-md-4 mb-4">
                        <div class="card product-card shadow-sm">
                            <div class="position-relative">
                                <img src="<?= base_url('productos/img/' . esc($prod['url_imagen'] ?? 'default.jpg')) ?>" class="card-img-top" alt="<?= esc($prod['nombre']) ?>">
                                <?php if ($prod['stock'] <= 3): ?>
                                    <span class="badge bg-warning text-dark position-absolute top-0 start-0 m-2">¡Últimas unidades!</span>
                                <?php elseif (!empty($prod['etiqueta'])): ?>
                                    <span class="badge bg-danger position-absolute top-0 start-0 m-2"><?= esc($prod['etiqueta']) ?></span>
                                <?php endif; ?>
                            </div>
                            <div class="card-body text-center">
                                <h5 class="card-title"><?= esc($prod['nombre']) ?></h5>
                                <p class="card-text text-primary fw-bold">$<?= esc($prod['precio']) ?></p>
                                <p class="text-muted small"><?= esc($categoriasMap[$prod['id_categoria']] ?? 'Sin categoría') ?></p>
                                <a href="<?= base_url('carrito/agregar/' . $prod['id_producto']) ?>" class="btn btn-outline-primary w-100">
                                    <i class="bi bi-cart-plus"></i> Agregar al carrito
                                </a>

                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </section>
    </div>
</div>


<script src="<?= base_url('assets/js/bootstrap.js') ?>"></script>
<script>
    document.querySelectorAll('input[name="categoria"]').forEach(radio => {
        radio.addEventListener('change', function() {
            this.closest('form').submit();
        });
    });
</script>

<?= $this->endSection() ?>