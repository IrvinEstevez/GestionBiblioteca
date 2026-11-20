<?php
require_once __DIR__ . '/conexion.php';
require_once __DIR__ . '/miembros_validar.php';

$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
$consulta = $pdo->prepare('SELECT * FROM Miembros WHERE miembro_id = ?');
$consulta->execute([$id]);
$miembro = $consulta->fetch();

if (!$miembro) {
    mensaje('danger', 'El miembro no existe.');
    redirigir('miembros_listar.php');
}

$errores = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $miembro = datosMiembro($_POST);
    $errores = validarMiembro($miembro);
    if (!$errores) {
        try {
            $consulta = $pdo->prepare(
                'UPDATE Miembros SET nombre = ?, apellido = ?, email = ?, fecha_suscripcion = ? WHERE miembro_id = ?'
            );
            $consulta->execute([$miembro['nombre'], $miembro['apellido'], $miembro['email'], $miembro['fecha_suscripcion'], $id]);
            mensaje('success', 'Miembro actualizado correctamente.');
            redirigir('miembros_listar.php');
        } catch (PDOException $ex) {
            if ($ex->getCode() !== '23000') {
                throw $ex;
            }
            $errores['email'] = 'Ya existe un miembro con este correo.';
        }
    }
}

$titulo = 'Editar miembro';
$seccion = 'miembros';
require __DIR__ . '/header.php';
?>
<div class="card shadow-sm form-card">
    <div class="card-body p-4">
        <h1 class="h4 mb-4">Editar miembro</h1>
        <?php require __DIR__ . '/miembros_form.php'; ?>
    </div>
</div>
<?php require __DIR__ . '/footer.php'; ?>
