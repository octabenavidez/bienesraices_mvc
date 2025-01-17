<?php 

define('TEMPLATE_URL', __DIR__ . '/templates');
define('FUNCIONES_URL', __DIR__ . 'funciones.php');
define('CARPETA_IMAGENES', $_SERVER['DOCUMENT_ROOT'] . '/imagenes/');
define('CARPETA_IMAGENES_DESCRIPTIVAS', $_SERVER['DOCUMENT_ROOT'] . '/imagenes/otras/');

function estaAutenticado(){
    session_start();

    if(!$_SESSION['login']){
        header('Location: /bienesraices/');
    } 
}

function debuguear($variable) {
    echo "<pre>";
    var_dump($variable);
    echo "</pre>";
    exit;
}

// Escapa / Sanitizar el HTML

function s($html) : string{
    $s = htmlspecialchars($html);
    return $s;
}

// Validar tipo contenido

function validarTipoContenido($tipo){
    $tipos = ['vendedor', 'propiedad'];
    return in_array($tipo, $tipos);
}

// Mostrar los mensajes

function mostrarNotificacion($codigo){
    $mensaje = '';

    switch($codigo){
        case 1:
            $mensaje = 'Creado Correctamente';
            break;
        case 2:
            $mensaje = 'Actualizado Correctamente';
            break;
        case 3:
            $mensaje = 'Eliminado Correctamente';
            break;   
        default:
            $mensaje = false;
            break;
    }

    return $mensaje;
}


function validarORedireccionar(string $url){
    // Validar la URL por ID valido
    $id = $_GET['id'];
    $id = filter_var($id, FILTER_VALIDATE_INT);

    if(!$id){
        header("Location: ${url}");
    }

    return $id;
}