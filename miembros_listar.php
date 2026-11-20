<?php
require_once __DIR__ . '/conexion.php';

$buscar = trim($_GET['buscar'] ?? '');

$sql = "SELECT m.*,
               (SELECT COUNT(*) FROM Prestamos p WHERE p.miembro_id = m.miembro_id AND p.estado = 'Prestado') AS activos
        FROM Miembros m";
$parametros = [];
if ($buscar !== '') {
    $sql .= ' WHERE m.nombre LIKE :b1 OR m.apellido LIKE :b2 OR m.email LIKE :b3';
    $parametros = [':b1' => "%$buscar%", ':b2' => "%$buscar%", ':b3' => "%$buscar%"];
}
$sql .= ' ORDER BY m.apellido, m.nombre';

$consulta = $pdo->prepare($sql);
$consulta->execute($parametros);
$miembros = $consulta->fetchAll();

$titulo = 'Miembros';
$seccion = 'miembros';
require __DIR__ . '/header.php';
?>
<div class="d-flex justify-content-between align-items-center mb-3">
    <h1 class="h3 mb-0">Miembros</h1>
    <a href="miembros_crear.php" class="btn btn-dark">Nuevo miembro</a>
</div>

<div class="card shadow-sm">
    <div class="card-body">
        <form class="row g-2 mb-3" method="get">
            <div class="col-sm-8 col-md-6">
                <input type="search" name="buscar" class="form-control" placeholder="Buscar por nombre, apellido o correo" value="<?= e($buscar) ?>">
            </div>
            <div class="col-auto">
                <button class="btn btn-outline-dark">Buscar</button>
                <?php if ($buscar !== ''): ?>
                    <a href="miembros_listar.php" class="btn btn-link">Limpiar</a>
                <?php endif; ?>
            </div>
        </form>

        <?php if ($miembros): ?>
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead>
                    <tr>
                        <th>#</th><th>Nombre</th><th>Apellido</th><th>Correo</th><th>Suscripción</th><th>Préstamos activos</th><th class="text-end">Acciones</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($miembros as $miembro): ?>
                        <tr>
                            <td><?= $miembro['miembro_id'] ?></td>
                            <td><?= e($miembro['nombre']) ?></td>
                            <td><?= e($miembro['apellido']) ?></td>
                            <td><?= e($miembro['email']) ?></td>
                            <td><?= fecha($miembro['fecha_suscripcion']) ?></td>
                            <td><?= $miembro['activos'] ?></td>
                            <td class="text-end acciones">
                                <a href="miembros_editar.php?id=<?= $miembro['miembro_id'] ?>" class="btn btn-sm btn-outline-primary">Editar</a>
                                <form action="miembros_eliminar.php" method="post" class="d-inline" onsubmit="return confirm('¿Eliminar este miembro?');">
                                    <input type="hidden" name="id" value="<?= $miembro['miembro_id'] ?>">
                                    <button class="btn btn-sm btn-outline-danger">Eliminar</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <p class="text-muted mb-0">No se encontraron miembros.</p>
        <?php endif; ?>
    </div>
</div>
<?php require __DIR__ . '/footer.php'; ?>
