<?php
require_once __DIR__ . '/conexion.php';

$totalLibros = $pdo->query('SELECT COUNT(*) FROM Libros')->fetchColumn();
$totalMiembros = $pdo->query('SELECT COUNT(*) FROM Miembros')->fetchColumn();
$totalActivos = $pdo->query("SELECT COUNT(*) FROM Prestamos WHERE estado = 'Prestado'")->fetchColumn();

$recientes = $pdo->query(
    "SELECT p.fecha_prestamo, l.titulo, CONCAT(m.nombre, ' ', m.apellido) AS miembro
     FROM Prestamos p
     JOIN Libros l ON l.libro_id = p.libro_id
     JOIN Miembros m ON m.miembro_id = p.miembro_id
     WHERE p.estado = 'Prestado'
     ORDER BY p.fecha_prestamo DESC
     LIMIT 5"
)->fetchAll();

$titulo = 'Inicio';
$seccion = 'inicio';
require __DIR__ . '/header.php';
?>
<h1 class="h3 mb-4">Panel principal</h1>

<div class="row g-3 mb-4">
    <div class="col-md-4">
        <div class="card shadow-sm stat-card">
            <div class="card-body">
                <div class="text-muted">Libros registrados</div>
                <div class="numero"><?= $totalLibros ?></div>
                <a href="<?= BASE_URL ?>libros_listar.php" class="small">Ver libros</a>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card shadow-sm stat-card">
            <div class="card-body">
                <div class="text-muted">Miembros</div>
                <div class="numero"><?= $totalMiembros ?></div>
                <a href="<?= BASE_URL ?>miembros_listar.php" class="small">Ver miembros</a>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card shadow-sm stat-card">
            <div class="card-body">
                <div class="text-muted">Préstamos activos</div>
                <div class="numero"><?= $totalActivos ?></div>
                <a href="<?= BASE_URL ?>prestamos_listar.php" class="small">Ver préstamos</a>
            </div>
        </div>
    </div>
</div>

<div class="card shadow-sm">
    <div class="card-body">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2 class="h5 mb-0">Últimos préstamos activos</h2>
            <a href="<?= BASE_URL ?>prestamos_crear.php" class="btn btn-dark btn-sm">Nuevo préstamo</a>
        </div>
        <?php if ($recientes): ?>
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead>
                    <tr><th>Libro</th><th>Miembro</th><th>Fecha de préstamo</th></tr>
                    </thead>
                    <tbody>
                    <?php foreach ($recientes as $fila): ?>
                        <tr>
                            <td><?= e($fila['titulo']) ?></td>
                            <td><?= e($fila['miembro']) ?></td>
                            <td><?= fecha($fila['fecha_prestamo']) ?></td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <p class="text-muted mb-0">No hay préstamos activos.</p>
        <?php endif; ?>
    </div>
</div>
<?php require __DIR__ . '/footer.php'; ?>
