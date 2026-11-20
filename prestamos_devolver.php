<?php
require_once __DIR__ . '/conexion.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    redirigir('prestamos_listar.php');
}

$id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);

$consulta = $pdo->prepare(
    "UPDATE Prestamos SET estado = 'Devuelto', fecha_devolucion = CURDATE()
     WHERE prestamo_id = ? AND estado = 'Prestado'"
);
$consulta->execute([$id]);

if ($consulta->rowCount() > 0) {
    mensaje('success', 'Devolución registrada correctamente.');
} else {
    mensaje('danger', 'El préstamo no existe o ya fue devuelto.');
}

redirigir('prestamos_listar.php');
