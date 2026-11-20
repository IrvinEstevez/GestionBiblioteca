<?php
define('BASE_URL', '/biblioteca/');

require_once __DIR__ . '/funciones.php';

$host = 'localhost';
$baseDatos = 'biblioteca';
$usuario = 'root';
$clave = '';

try {
    $pdo = new PDO(
        "mysql:host=$host;charset=utf8mb4",
        $usuario,
        $clave,
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ]
    );

    $existe = $pdo->query("SHOW DATABASES LIKE " . $pdo->quote($baseDatos))->fetchColumn();
    if (!$existe) {
        $script = file_get_contents(__DIR__ . '/biblioteca.sql');
        $pdo->exec($script);
        $pdo = null;
        $pdo = new PDO(
            "mysql:host=$host;charset=utf8mb4",
            $usuario,
            $clave,
            [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            ]
        );
        mensaje('info', 'La base de datos se creó automáticamente con datos de ejemplo.');
    }

    $pdo->exec("USE `$baseDatos`");
} catch (PDOException $ex) {
    $titulo = 'Sin conexión';
    $seccion = '';
    require __DIR__ . '/header.php';
    ?>
    <div class="card shadow-sm form-card">
        <div class="card-body p-4">
            <h1 class="h4 mb-3">No se pudo conectar a la base de datos</h1>
            <p class="text-muted">Verifique que el servicio <strong>MySQL</strong> esté iniciado en el panel de XAMPP y vuelva a cargar la página.</p>
            <p class="small text-muted mb-3">Detalle: <?= e($ex->getMessage()) ?></p>
            <a href="<?= BASE_URL ?>" class="btn btn-dark">Reintentar</a>
        </div>
    </div>
    <?php
    require __DIR__ . '/footer.php';
    exit;
}
