<?php
require_once __DIR__ . '/conexion.php';

$estado = $_GET['estado'] ?? '';
if (!in_array($estado, ['', 'Prestado', 'Devuelto'], true)) {
    $estado = '';
}

$sql = "SELECT p.*, l.titulo, CONCAT(m.nombre, ' ', m.apellido) AS miembro
        FROM Prestamos p
        JOIN Libros l ON l.libro_id = p.libro_id
        JOIN Miembros m ON m.miembro_id = p.miembro_id";
$parametros = [];
if ($estado !== '') {
    $sql .= ' WHERE p.estado = ?';
    $parametros[] = $estado;
}
$sql .= ' ORDER BY p.estado = \'Devuelto\', p.fecha_prestamo DESC';

$consulta = $pdo->prepare($sql);
$consulta->execute($parametros);
$prestamos = $consulta->fetchAll();

$titulo = 'Préstamos';
$seccion = 'prestamos';
require __DIR__ . '/header.php';
?>
<div class="d-flex justify-content-between align-items-center mb-3">
    <h1 class="h3 mb-0">Préstamos</h1>
    <a href="prestamos_crear.php" class="btn btn-dark">Nuevo préstamo</a>
</div>

<div class="card shadow-sm">
    <div class="card-body">
        <div class="btn-group mb-3">
            <a href="prestamos_listar.php" class="btn btn-sm <?= $estado === '' ? 'btn-dark' : 'btn-outline-dark' ?>">Todos</a>
            <a href="prestamos_listar.php?estado=Prestado" class="btn btn-sm <?= $estado === 'Prestado' ? 'btn-dark' : 'btn-outline-dark' ?>">Prestados</a>
            <a href="prestamos_listar.php?estado=Devuelto" class="btn btn-sm <?= $estado === 'Devuelto' ? 'btn-dark' : 'btn-outline-dark' ?>">Devueltos</a>
        </div>

        <?php if ($prestamos): ?>
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead>
                    <tr>
                        <th>#</th><th>Libro</th><th>Miembro</th><th>Fecha de préstamo</th><th>Fecha de devolución</th><th>Estado</th><th class="text-end">Acciones</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($prestamos as $prestamo): ?>
                        <tr>
                            <td><?= $prestamo['prestamo_id'] ?></td>
                            <td><?= e($prestamo['titulo']) ?></td>
                            <td><?= e($prestamo['miembro']) ?></td>
                            <td><?= fecha($prestamo['fecha_prestamo']) ?></td>
                            <td><?= fecha($prestamo['fecha_devolucion']) ?></td>
                            <td>
                                <?php if ($prestamo['estado'] === 'Prestado'): ?>
                                    <span class="badge text-bg-secondary">Prestado</span>
                                <?php else: ?>
                                    <span class="badge text-bg-light border">Devuelto</span>
                                <?php endif; ?>
                            </td>
                            <td class="text-end acciones">
                                <?php if ($prestamo['estado'] === 'Prestado'): ?>
                                    <form action="prestamos_devolver.php" method="post" class="d-inline" onsubmit="return confirm('¿Registrar la devolución de este libro?');">
                                        <input type="hidden" name="id" value="<?= $prestamo['prestamo_id'] ?>">
                                        <button class="btn btn-sm btn-outline-success">Registrar devolución</button>
                                    </form>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <p class="text-muted mb-0">No hay préstamos para mostrar.</p>
        <?php endif; ?>
    </div>
</div>
<?php require __DIR__ . '/footer.php'; ?>
