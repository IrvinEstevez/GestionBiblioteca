<?php
require_once __DIR__ . '/conexion.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    redirigir('libros_listar.php');
}

$id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);

try {
    $consulta = $pdo->prepare('DELETE FROM Libros WHERE libro_id = ?');
    $consulta->execute([$id]);
    if ($consulta->rowCount() > 0) {
        mensaje('success', 'Libro eliminado correctamente.');
    } else {
        mensaje('danger', 'El libro no existe.');
    }
} catch (PDOException $ex) {
    mensaje('warning', 'No se puede eliminar el libro porque tiene préstamos registrados.');
}

redirigir('libros_listar.php');
