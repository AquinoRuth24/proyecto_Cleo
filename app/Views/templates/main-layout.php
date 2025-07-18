<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?></title>
    <link href="assets/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/miestilo.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <link rel="icon" href="assets/img/logo.jpg" type="image/x-icon">
</head>

<body>
    <div class="wrapper">

        <header>
            <?= view("components/navbar") ?>
        </header>

        <main>
            <?php if (isset($content)): ?>
                <?= $content ?>
            <?php else: ?>
                <?= $this->renderSection('contenido') ?>
            <?php endif; ?>
        </main>

        <footer>
            <?= view("components/footer") ?>
        </footer>

    </div>

    <script src="assets/js/bootstrap.js"></script>

</body>

</html>