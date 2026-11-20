<?php
function datosMiembro($entrada)
{
    return [
        'nombre' => trim($entrada['nombre'] ?? ''),
        'apellido' => trim($entrada['apellido'] ?? ''),
        'email' => trim($entrada['email'] ?? ''),
        'fecha_suscripcion' => trim($entrada['fecha_suscripcion'] ?? date('Y-m-d')),
    ];
}

function validarMiembro($miembro)
{
    $errores = [];
    if ($miembro['nombre'] === '') {
        $errores['nombre'] = 'El nombre es obligatorio.';
    }
    if ($miembro['apellido'] === '') {
        $errores['apellido'] = 'El apellido es obligatorio.';
    }
    if (!filter_var($miembro['email'], FILTER_VALIDATE_EMAIL)) {
        $errores['email'] = 'Ingrese un correo electrónico válido.';
    }
    $fecha = DateTime::createFromFormat('Y-m-d', $miembro['fecha_suscripcion']);
    if (!$fecha || $fecha->format('Y-m-d') !== $miembro['fecha_suscripcion']) {
        $errores['fecha_suscripcion'] = 'Ingrese una fecha válida.';
    }
    return $errores;
}
