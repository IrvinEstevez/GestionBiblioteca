<?php
require_once __DIR__ . '/conexion.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    redirigir('miembros_listar.php');
}

$id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);

try {
    $consulta = $pdo->prepare('DELETE FROM Miembros WHERE miembro_id = ?');
    $consulta->execute([$id]);
    if ($consulta->rowCount() > 0) {
        mensaje('success', 'Miembro eliminado correctamente.');
    } else {
        mensaje('danger', 'El miembro no existe.');
    }
} catch (PDOException $ex) {
    mensaje('warning', 'No se puede eliminar el miembro porque tiene préstamos registrados.');
}

redirigir('miembros_listar.php');
