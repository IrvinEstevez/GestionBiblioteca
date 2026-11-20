<?php
function datosLibro($entrada)
{
    return [
        'titulo' => trim($entrada['titulo'] ?? ''),
        'autor' => trim($entrada['autor'] ?? ''),
        'genero' => trim($entrada['genero'] ?? ''),
        'anio_publicacion' => trim($entrada['anio_publicacion'] ?? ''),
    ];
}

function validarLibro($libro)
{
    $errores = [];
    if ($libro['titulo'] === '') {
        $errores['titulo'] = 'El título es obligatorio.';
    }
    if ($libro['autor'] === '') {
        $errores['autor'] = 'El autor es obligatorio.';
    }
    if ($libro['genero'] === '') {
        $errores['genero'] = 'El género es obligatorio.';
    }
    $anio = filter_var($libro['anio_publicacion'], FILTER_VALIDATE_INT);
    if ($anio === false || $anio < 1000 || $anio > (int) date('Y')) {
        $errores['anio_publicacion'] = 'Ingrese un año válido entre 1000 y ' . date('Y') . '.';
    }
    return $errores;
}
