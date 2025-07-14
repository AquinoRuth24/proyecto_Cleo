<head>
    <title>Editar Productos</title>
    <link href="<?= base_url('assets/css/bootstrap.min.css') ?>" rel="stylesheet">
    <link href="<?= base_url('assets/css/miestilo.css') ?>" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="icon" href="<?= base_url('assets/img/logo.jpg') ?>" type="image/x-icon">

</head>

<?php if (isset($validation)): ?>
    <div class="alert alert-danger">
        <?= $validation->listErrors() ?>
    </div>
<?php endif; ?>
<div class="container mt-4 p-3 rounded" style="background-color: darkgray;">
    <div class="d-flex justify-content-between align-items-center position-relative">
        <div style="width: 150px;"></div>
        <h2 class="mb-0 text-center flex-grow-1">Editar Un Producto</h2>
        <a href="<?= site_url('producto') ?>" class="btn btn-primary">
            <i class="bi bi-arrow-left-circle"></i> Volver
        </a>
    </div>
</div>

<form action="<?= site_url('producto/editarProducto/' . $producto['id_producto']) ?>" method="POST" enctype="multipart/form-data">
    <div class="crearProducto">
        <div class="mb-3">
            <label>Nombre:</label>
            <input type="text" name="nombre" class="form-control" value="<?= esc($producto['nombre']) ?>" required>
        </div>
        <div class="mb-3">
            <label>Descripción:</label>
            <textarea name="descripcion" class="form-control" required><?= esc($producto['descripcion']) ?></textarea>
        </div>
        <div class="mb-3">
            <label>Precio:</label>
            <input type="number" name="precio" class="form-control" value="<?= esc($producto['precio']) ?>" required>
        </div>
        <div class="mb-3">
            <label>Stock:</label>
            <input type="number" name="stock" class="form-control" value="<?= esc($producto['stock']) ?>" required>
        </div>
        <div class="mb-3">
            <label for="id_categoria" class="form-label">Categoría</label>
            <select name="id_categoria" id="id_categoria" class="form-select" required>
                <option value="">Seleccione categoría</option>
                <?php foreach ($categorias as $categoria): ?>
                    <option value="<?= $categoria['id_categoria'] ?>" <?= set_value('id_categoria', $producto['id_categoria']) == $categoria['id_categoria'] ? 'selected' : '' ?>>
                        <?= esc($categoria['nombre']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="mb-3">
            <label for="id_subcategoria" class="form-label">Subcategoría</label>
            <select name="id_subcategoria" id="id_subcategoria" class="form-select" required>
                <option value="">Seleccione subcategoría</option>
                <?php foreach ($subcategorias as $sub): ?>
                    <option value="<?= $sub['id_subcategoria'] ?>" <?= $producto['id_subcategoria'] == $sub['id_subcategoria'] ? 'selected' : '' ?>>
                        <?= esc($sub['nombre']) ?>
                    </option>
                <?php endforeach; ?>
                <option value="otros">otro</option>
            </select>
        </div>

        <div class="mb-3 d-none" id="nuevaSubcategoriaDiv">
            <label for="nueva_subcategoria" class="form-label">Nueva Subcategoría</label>
            <input type="text" class="form-control" name="nueva_subcategoria" id="nueva_subcategoria" placeholder="Ingrese una nueva subcategoría">
        </div>
        <div class="mb-3">
            <label>Agregar nuevas imágenes:</label>
            <input type="file" name="imagenes[]" class="form-control" accept="image/*" multiple>
        </div>
        <?php if (!empty($imagenes)): ?>
            <div class="mb-3">
                <label>Imágenes actuales:</label><br>
                <?php foreach ($imagenes as $img): ?>
                    <img src="<?= base_url('assets/img/' . $img['url_imagen']) ?>" width="100" class="rounded border m-1" title="<?= $img['es_principal'] ? 'Principal' : '' ?>">
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
        <button type="submit" class="btn btn-primary">Actualizar</button>
        <a href="<?= site_url('producto') ?>" class="btn btn-secondary">Cancelar</a>
    </div>
</form>

<script>
document.getElementById('id_subcategoria').addEventListener('change', function () {
    const div = document.getElementById('nuevaSubcategoriaDiv');
    if (this.value === 'otros') {
        div.classList.remove('d-none');
        document.getElementById('nueva_subcategoria').setAttribute('required', 'required');
    } else {
        div.classList.add('d-none');
        document.getElementById('nueva_subcategoria').removeAttribute('required');
    }
});
</script>


<script src="<?= base_url('assets/js/bootstrap.js') ?>"></script>