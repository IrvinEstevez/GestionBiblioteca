<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

function e($texto)
{
    return htmlspecialchars((string) $texto, ENT_QUOTES, 'UTF-8');
}

function mensaje($tipo, $texto)
{
    $_SESSION['mensaje'] = ['tipo' => $tipo, 'texto' => $texto];
}

function redirigir($ruta)
{
    header('Location: ' . BASE_URL . $ruta);
    exit;
}

function fecha($fecha)
{
    return $fecha ? date('d/m/Y', strtotime($fecha)) : '—';
}
