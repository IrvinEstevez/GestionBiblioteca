<?php
require_once __DIR__ . '/conexion.php';
require_once __DIR__ . '/miembros_validar.php';

$miembro = datosMiembro([]);
$errores = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $miembro = datosMiembro($_POST);
    $errores = validarMiembro($miembro);
    if (!$errores) {
        try {
            $consulta = $pdo->prepare(
                'INSERT INTO Miembros (nombre, apellido, email, fecha_suscripcion) VALUES (?, ?, ?, ?)'
            );
            $consulta->execute([$miembro['nombre'], $miembro['apellido'], $miembro['email'], $miembro['fecha_suscripcion']]);
            mensaje('success', 'Miembro registrado correctamente.');
            redirigir('miembros_listar.php');
        } catch (PDOException $ex) {
            if ($ex->getCode() !== '23000') {
                throw $ex;
            }
            $errores['email'] = 'Ya existe un miembro con este correo.';
        }
    }
}

$titulo = 'Nuevo miembro';
$seccion = 'miembros';
require __DIR__ . '/header.php';
?>
<div class="card shadow-sm form-card">
    <div class="card-body p-4">
        <h1 class="h4 mb-4">Nuevo miembro</h1>
        <?php require __DIR__ . '/miembros_form.php'; ?>
    </div>
</div>
<?php require __DIR__ . '/footer.php'; ?>
