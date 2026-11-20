<form method="post" novalidate>
    <div class="row">
        <div class="col-md-6 mb-3">
            <label class="form-label" for="nombre">Nombre</label>
            <input type="text" class="form-control<?= isset($errores['nombre']) ? ' is-invalid' : '' ?>" id="nombre" name="nombre" maxlength="60" value="<?= e($miembro['nombre']) ?>" required>
            <div class="invalid-feedback"><?= e($errores['nombre'] ?? '') ?></div>
        </div>
        <div class="col-md-6 mb-3">
            <label class="form-label" for="apellido">Apellido</label>
            <input type="text" class="form-control<?= isset($errores['apellido']) ? ' is-invalid' : '' ?>" id="apellido" name="apellido" maxlength="60" value="<?= e($miembro['apellido']) ?>" required>
            <div class="invalid-feedback"><?= e($errores['apellido'] ?? '') ?></div>
        </div>
    </div>
    <div class="mb-3">
        <label class="form-label" for="email">Correo electrónico</label>
        <input type="email" class="form-control<?= isset($errores['email']) ? ' is-invalid' : '' ?>" id="email" name="email" maxlength="100" value="<?= e($miembro['email']) ?>" required>
        <div class="invalid-feedback"><?= e($errores['email'] ?? '') ?></div>
    </div>
    <div class="mb-3">
        <label class="form-label" for="fecha_suscripcion">Fecha de suscripción</label>
        <input type="date" class="form-control<?= isset($errores['fecha_suscripcion']) ? ' is-invalid' : '' ?>" id="fecha_suscripcion" name="fecha_suscripcion" value="<?= e($miembro['fecha_suscripcion']) ?>" required>
        <div class="invalid-feedback"><?= e($errores['fecha_suscripcion'] ?? '') ?></div>
    </div>
    <div class="d-flex gap-2">
        <button type="submit" class="btn btn-dark">Guardar</button>
        <a href="<?= BASE_URL ?>miembros_listar.php" class="btn btn-outline-secondary">Cancelar</a>
    </div>
</form>
