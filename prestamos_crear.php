<?php
require_once __DIR__ . '/conexion.php';

$sqlDisponibles = "SELECT l.libro_id, l.titulo, l.autor
                   FROM Libros l
                   WHERE NOT EXISTS (
                       SELECT 1 FROM Prestamos p WHERE p.libro_id = l.libro_id AND p.estado = 'Prestado'
                   )
                   ORDER BY l.titulo";
$libros = $pdo->query($sqlDisponibles)->fetchAll();
$miembros = $pdo->query('SELECT miembro_id, nombre, apellido FROM Miembros ORDER BY apellido, nombre')->fetchAll();

$prestamo = [
    'libro_id' => $_GET['libro_id'] ?? '',
    'miembro_id' => '',
    'fecha_prestamo' => date('Y-m-d'),
];
$errores = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $prestamo = [
        'libro_id' => filter_input(INPUT_POST, 'libro_id', FILTER_VALIDATE_INT),
        'miembro_id' => filter_input(INPUT_POST, 'miembro_id', FILTER_VALIDATE_INT),
        'fecha_prestamo' => trim($_POST['fecha_prestamo'] ?? ''),
    ];

    $idsDisponibles = array_column($libros, 'libro_id');
    if (!in_array($prestamo['libro_id'], $idsDisponibles)) {
        $errores['libro_id'] = 'Seleccione un libro disponible.';
    }
    if (!in_array($prestamo['miembro_id'], array_column($miembros, 'miembro_id'))) {
        $errores['miembro_id'] = 'Seleccione un miembro.';
    }
    $fecha = DateTime::createFromFormat('Y-m-d', $prestamo['fecha_prestamo']);
    if (!$fecha || $fecha->format('Y-m-d') !== $prestamo['fecha_prestamo']) {
        $errores['fecha_prestamo'] = 'Ingrese una fecha válida.';
    }

    if (!$errores) {
        $consulta = $pdo->prepare(
            "INSERT INTO Prestamos (libro_id, miembro_id, fecha_prestamo, estado) VALUES (?, ?, ?, 'Prestado')"
        );
        $consulta->execute([$prestamo['libro_id'], $prestamo['miembro_id'], $prestamo['fecha_prestamo']]);
        mensaje('success', 'Préstamo registrado correctamente.');
        redirigir('prestamos_listar.php');
    }
}

$titulo = 'Nuevo préstamo';
$seccion = 'prestamos';
require __DIR__ . '/header.php';
?>
<div class="card shadow-sm form-card">
    <div class="card-body p-4">
        <h1 class="h4 mb-4">Nuevo préstamo</h1>

        <?php if (!$libros || !$miembros): ?>
            <div class="alert alert-secondary">
                <?= !$libros ? 'No hay libros disponibles para préstamo.' : 'Primero debe registrar al menos un miembro.' ?>
            </div>
            <a href="prestamos_listar.php" class="btn btn-outline-secondary">Volver</a>
        <?php else: ?>
            <form method="post" novalidate>
                <div class="mb-3">
                    <label class="form-label" for="libro_id">Libro</label>
                    <select class="form-select<?= isset($errores['libro_id']) ? ' is-invalid' : '' ?>" id="libro_id" name="libro_id" required>
                        <option value="">Seleccione un libro</option>
                        <?php foreach ($libros as $libro): ?>
                            <option value="<?= $libro['libro_id'] ?>" <?= $prestamo['libro_id'] == $libro['libro_id'] ? 'selected' : '' ?>>
                                <?= e($libro['titulo']) ?> — <?= e($libro['autor']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <div class="invalid-feedback"><?= e($errores['libro_id'] ?? '') ?></div>
                    <div class="form-text">Solo se muestran los libros disponibles.</div>
                </div>
                <div class="mb-3">
                    <label class="form-label" for="miembro_id">Miembro</label>
                    <select class="form-select<?= isset($errores['miembro_id']) ? ' is-invalid' : '' ?>" id="miembro_id" name="miembro_id" required>
                        <option value="">Seleccione un miembro</option>
                        <?php foreach ($miembros as $miembro): ?>
                            <option value="<?= $miembro['miembro_id'] ?>" <?= $prestamo['miembro_id'] == $miembro['miembro_id'] ? 'selected' : '' ?>>
                                <?= e($miembro['apellido'] . ', ' . $miembro['nombre']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <div class="invalid-feedback"><?= e($errores['miembro_id'] ?? '') ?></div>
                </div>
                <div class="mb-3">
                    <label class="form-label" for="fecha_prestamo">Fecha de préstamo</label>
                    <input type="date" class="form-control<?= isset($errores['fecha_prestamo']) ? ' is-invalid' : '' ?>" id="fecha_prestamo" name="fecha_prestamo" value="<?= e($prestamo['fecha_prestamo']) ?>" required>
                    <div class="invalid-feedback"><?= e($errores['fecha_prestamo'] ?? '') ?></div>
                </div>
                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-dark">Registrar préstamo</button>
                    <a href="prestamos_listar.php" class="btn btn-outline-secondary">Cancelar</a>
                </div>
            </form>
        <?php endif; ?>
    </div>
</div>
<?php require __DIR__ . '/footer.php'; ?>
