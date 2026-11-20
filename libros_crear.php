<?php
require_once __DIR__ . '/conexion.php';
require_once __DIR__ . '/libros_validar.php';

$libro = datosLibro([]);
$errores = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $libro = datosLibro($_POST);
    $errores = validarLibro($libro);
    if (!$errores) {
        $consulta = $pdo->prepare(
            'INSERT INTO Libros (titulo, autor, genero, anio_publicacion) VALUES (?, ?, ?, ?)'
        );
        $consulta->execute([$libro['titulo'], $libro['autor'], $libro['genero'], $libro['anio_publicacion']]);
        mensaje('success', 'Libro registrado correctamente.');
        redirigir('libros_listar.php');
    }
}

$titulo = 'Nuevo libro';
$seccion = 'libros';
require __DIR__ . '/header.php';
?>
<div class="card shadow-sm form-card">
    <div class="card-body p-4">
        <h1 class="h4 mb-4">Nuevo libro</h1>
        <?php require __DIR__ . '/libros_form.php'; ?>
    </div>
</div>
<?php require __DIR__ . '/footer.php'; ?>
