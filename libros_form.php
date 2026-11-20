<form method="post" novalidate>
    <div class="mb-3">
        <label class="form-label" for="titulo">Título</label>
        <input type="text" class="form-control<?= isset($errores['titulo']) ? ' is-invalid' : '' ?>" id="titulo" name="titulo" maxlength="150" value="<?= e($libro['titulo']) ?>" required>
        <div class="invalid-feedback"><?= e($errores['titulo'] ?? '') ?></div>
    </div>
    <div class="mb-3">
        <label class="form-label" for="autor">Autor</label>
        <input type="text" class="form-control<?= isset($errores['autor']) ? ' is-invalid' : '' ?>" id="autor" name="autor" maxlength="100" value="<?= e($libro['autor']) ?>" required>
        <div class="invalid-feedback"><?= e($errores['autor'] ?? '') ?></div>
    </div>
    <div class="row">
        <div class="col-md-7 mb-3">
            <label class="form-label" for="genero">Género</label>
            <input type="text" class="form-control<?= isset($errores['genero']) ? ' is-invalid' : '' ?>" id="genero" name="genero" maxlength="50" value="<?= e($libro['genero']) ?>" required>
            <div class="invalid-feedback"><?= e($errores['genero'] ?? '') ?></div>
        </div>
        <div class="col-md-5 mb-3">
            <label class="form-label" for="anio_publicacion">Año de publicación</label>
            <input type="number" class="form-control<?= isset($errores['anio_publicacion']) ? ' is-invalid' : '' ?>" id="anio_publicacion" name="anio_publicacion" min="1000" max="<?= date('Y') ?>" value="<?= e($libro['anio_publicacion']) ?>" required>
            <div class="invalid-feedback"><?= e($errores['anio_publicacion'] ?? '') ?></div>
        </div>
    </div>
    <div class="d-flex gap-2">
        <button type="submit" class="btn btn-dark">Guardar</button>
        <a href="<?= BASE_URL ?>libros_listar.php" class="btn btn-outline-secondary">Cancelar</a>
    </div>
</form>
