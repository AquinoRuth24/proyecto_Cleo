<head>
    <title>Dar De Alta Productos</title>
    <link href="<?= base_url('assets/css/bootstrap.min.css') ?>" rel="stylesheet">
    <link href="<?= base_url('assets/css/miestilo.css') ?>" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="icon" href="<?= base_url('assets/img/logo.jpg') ?>" type="image/x-icon">

</head>

<div class="container mt-4 p-3 rounded" style="background-color: darkgray;">
    <div class="d-flex justify-content-between align-items-center position-relative">
        <div style="width: 150px;"></div>
        <h2 class="mb-0 text-center flex-grow-1">Dar De Alta Un Producto</h2>
        <a href="<?= site_url('producto') ?>" class="btn btn-primary">
            <i class="bi bi-arrow-left-circle"></i> Volver
        </a>
    </div>
</div>

<form action="<?= site_url('producto/crearProducto') ?>" method="POST" enctype="multipart/form-data">
    <div class="crearProducto">
        <div class="mb-3">
            <label class="form-label">Nombre:</label>
            <input type="text" name="nombre" class="form-control" placeholder="Ej: Remera blanca" style="color: black;" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Descripción:</label>
            <textarea name="descripcion" class="form-control" rows="3" required></textarea>
        </div>
        <div class="mb-3">
            <label class="form-label">Precio:</label>
            <input type="number" name="precio" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Stock:</label>
            <input type="number" name="stock" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="id_categoria" class="form-label">Categoría</label>
            <select name="id_categoria" id="id_categoria" class="form-select" required>
                <option value="">Selecciona una categoría</option>
                <?php foreach ($categorias as $categoria): ?>
                    <option value="<?= $categoria['id_categoria'] ?>">
                        <?= esc($categoria['nombre']) ?>
                    </option>
                <?php endforeach; ?>
                <option value="otros">Otra categoría</option>
            </select>
        </div>
        <div class="mb-3 d-none" id="nuevaCategoriaDiv">
            <label for="nueva_categoria" class="form-label">Nueva Categoría</label>
            <input type="text" class="form-control" name="nueva_categoria" id="nueva_categoria" placeholder="Ingrese una nueva categoría">
        </div>
        <div class="mb-3">
            <label for="id_subcategoria" class="form-label">Subcategoría</label>
            <select name="id_subcategoria" id="id_subcategoria" class="form-select" required>
                <option value="">Selecciona una subcategoría</option>
                <?php foreach ($subcategorias as $sub): ?>
                    <option value="<?= $sub['id_subcategoria'] ?>">
                        <?= esc($sub['nombre']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="mb-3 d-none" id="nuevaSubcategoriaDiv">
            <label for="nueva_subcategoria" class="form-label">Nueva Subcategoría</label>
            <input type="text" class="form-control" name="nueva_subcategoria" id="nueva_subcategoria" placeholder="Ingrese una nueva subcategoría">
        </div>
        <div class="mb-3">
            <label class="form-label">Imagen principal:</label>
            <input type="file" name="imagen" class="form-control" accept="image/*" required>
        </div>
        <div class="d-flex justify-content-between">
            <button type="submit" class="btn btn-success">
                <i class="bi bi-check-circle"></i> Guardar
            </button>
            <a href="<?= site_url('producto') ?>" class="btn btn-secondary">
                <i class="bi bi-x-circle"></i> Cancelar
            </a>
        </div>
    </div>
    </div>
</form>

<script>
    document.getElementById('id_categoria').addEventListener('change', function() {
        const categoriaId = this.value;
        const subSelect = document.getElementById('id_subcategoria');

        // Limpiar subcategorías anteriores
        subSelect.innerHTML = '<option value="">Selecciona una subcategoría</option>';

        if (categoriaId) {
            fetch("<?= base_url('subcategorias') ?>/" + categoriaId)
                .then(res => res.json())
                .then(data => {
                    data.forEach(sub => {
                        const option = document.createElement('option');
                        option.value = sub.id_subcategoria;
                        option.textContent = sub.nombre;
                        subSelect.appendChild(option);
                    });
                    const otros = document.createElement('option');
                    otros.value = 'otros';
                    otros.textContent = 'Otros';
                    subSelect.appendChild(otros);
                });
        }
    });

    document.getElementById('id_subcategoria').addEventListener('change', function() {
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

<script>
    const categoriaSelect = document.getElementById('id_categoria');
    const subSelect = document.getElementById('id_subcategoria');
    const nuevaCategoriaDiv = document.getElementById('nuevaCategoriaDiv');
    const nuevaCategoriaInput = document.getElementById('nueva_categoria');

    categoriaSelect.addEventListener('change', function() {
        const categoriaId = this.value;
        if (categoriaId === 'otros') {
            nuevaCategoriaDiv.classList.remove('d-none');
            nuevaCategoriaInput.setAttribute('required', 'required');
            subSelect.innerHTML = '<option value="otros">Otros</option>';
        } else {
            nuevaCategoriaDiv.classList.add('d-none');
            nuevaCategoriaInput.removeAttribute('required');

            // Limpiar y cargar subcategorías normalmente
            subSelect.innerHTML = '<option value="">Selecciona una subcategoría</option>';

            if (categoriaId) {
                fetch("<?= base_url('subcategorias') ?>/" + categoriaId)
                    .then(res => res.json())
                    .then(data => {
                        data.forEach(sub => {
                            const option = document.createElement('option');
                            option.value = sub.id_subcategoria;
                            option.textContent = sub.nombre;
                            subSelect.appendChild(option);
                        });
                        const otros = document.createElement('option');
                        otros.value = 'otros';
                        otros.textContent = 'Otros';
                        subSelect.appendChild(otros);
                    });
            }
        }
    });

    document.getElementById('id_subcategoria').addEventListener('change', function() {
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