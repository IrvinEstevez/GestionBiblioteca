<?php
require_once __DIR__ . '/conexion.php';

$buscar = trim($_GET['buscar'] ?? '');

$sql = "SELECT l.*,
               EXISTS(SELECT 1 FROM Prestamos p WHERE p.libro_id = l.libro_id AND p.estado = 'Prestado') AS prestado
        FROM Libros l";
$parametros = [];
if ($buscar !== '') {
    $sql .= ' WHERE l.titulo LIKE :b1 OR l.autor LIKE :b2 OR l.genero LIKE :b3';
    $parametros = [':b1' => "%$buscar%", ':b2' => "%$buscar%", ':b3' => "%$buscar%"];
}
$sql .= ' ORDER BY l.titulo';

$consulta = $pdo->prepare($sql);
$consulta->execute($parametros);
$libros = $consulta->fetchAll();

$titulo = 'Libros';
$seccion = 'libros';
require __DIR__ . '/header.php';
?>
<div class="d-flex justify-content-between align-items-center mb-3">
    <h1 class="h3 mb-0">Libros</h1>
    <a href="libros_crear.php" class="btn btn-dark">Nuevo libro</a>
</div>

<div class="card shadow-sm">
    <div class="card-body">
        <form class="row g-2 mb-3" method="get">
            <div class="col-sm-8 col-md-6">
                <input type="search" name="buscar" class="form-control" placeholder="Buscar por título, autor o género" value="<?= e($buscar) ?>">
            </div>
            <div class="col-auto">
                <button class="btn btn-outline-dark">Buscar</button>
                <?php if ($buscar !== ''): ?>
                    <a href="libros_listar.php" class="btn btn-link">Limpiar</a>
                <?php endif; ?>
            </div>
        </form>

        <?php if ($libros): ?>
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead>
                    <tr>
                        <th>#</th><th>Título</th><th>Autor</th><th>Género</th><th>Año</th><th>Estado</th><th class="text-end">Acciones</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($libros as $libro): ?>
                        <tr>
                            <td><?= $libro['libro_id'] ?></td>
                            <td><?= e($libro['titulo']) ?></td>
                            <td><?= e($libro['autor']) ?></td>
                            <td><?= e($libro['genero']) ?></td>
                            <td><?= $libro['anio_publicacion'] ?></td>
                            <td>
                                <?php if ($libro['prestado']): ?>
                                    <span class="badge text-bg-secondary">Prestado</span>
                                <?php else: ?>
                                    <span class="badge text-bg-light border">Disponible</span>
                                <?php endif; ?>
                            </td>
                            <td class="text-end acciones">
                                <a href="libros_editar.php?id=<?= $libro['libro_id'] ?>" class="btn btn-sm btn-outline-primary">Editar</a>
                                <form action="libros_eliminar.php" method="post" class="d-inline" onsubmit="return confirm('¿Eliminar este libro?');">
                                    <input type="hidden" name="id" value="<?= $libro['libro_id'] ?>">
                                    <button class="btn btn-sm btn-outline-danger">Eliminar</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <p class="text-muted mb-0">No se encontraron libros.</p>
        <?php endif; ?>
    </div>
</div>
<?php require __DIR__ . '/footer.php'; ?>
