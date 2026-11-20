<?php
$titulo = $titulo ?? 'Inicio';
$seccion = $seccion ?? 'inicio';
$menu = [
    'inicio' => ['Inicio', ''],
    'libros' => ['Libros', 'libros_listar.php'],
    'miembros' => ['Miembros', 'miembros_listar.php'],
    'prestamos' => ['Préstamos', 'prestamos_listar.php'],
];
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= e($titulo) ?> | Biblioteca</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?= BASE_URL ?>estilos.css" rel="stylesheet">
</head>
<body>
<nav class="navbar navbar-expand-md navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand" href="<?= BASE_URL ?>">Biblioteca</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#menu">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="menu">
            <ul class="navbar-nav ms-auto">
                <?php foreach ($menu as $clave => [$texto, $ruta]): ?>
                    <li class="nav-item">
                        <a class="nav-link<?= $seccion === $clave ? ' active' : '' ?>" href="<?= BASE_URL . $ruta ?>"><?= $texto ?></a>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>
</nav>
<main class="container py-4">
<?php if (!empty($_SESSION['mensaje'])): ?>
    <div class="alert alert-<?= e($_SESSION['mensaje']['tipo']) ?> alert-dismissible fade show">
        <?= e($_SESSION['mensaje']['texto']) ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    <?php unset($_SESSION['mensaje']); ?>
<?php endif; ?>
