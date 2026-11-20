<?php
require_once __DIR__ . '/conexion.php';
require_once __DIR__ . '/libros_validar.php';

$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
$consulta = $pdo->prepare('SELECT * FROM Libros WHERE libro_id = ?');
$consulta->execute([$id]);
$libro = $consulta->fetch();

if (!$libro) {
    mensaje('danger', 'El libro no existe.');
    redirigir('libros_listar.php');
}

$errores = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $libro = datosLibro($_POST);
    $errores = validarLibro($libro);
    if (!$errores) {
        $consulta = $pdo->prepare(
            'UPDATE Libros SET titulo = ?, autor = ?, genero = ?, anio_publicacion = ? WHERE libro_id = ?'
        );
        $consulta->execute([$libro['titulo'], $libro['autor'], $libro['genero'], $libro['anio_publicacion'], $id]);
        mensaje('success', 'Libro actualizado correctamente.');
        redirigir('libros_listar.php');
    }
}

$titulo = 'Editar libro';
$seccion = 'libros';
require __DIR__ . '/header.php';
?>
<div class="card shadow-sm form-card">
    <div class="card-body p-4">
        <h1 class="h4 mb-4">Editar libro</h1>
        <?php require __DIR__ . '/libros_form.php'; ?>
    </div>
</div>
<?php require __DIR__ . '/footer.php'; ?>
