<?php

function conectarDB() : mysqli {
    $db = new mysqli(
        $_ENV['DB_HOST'], 
        $_ENV['DB_USER'], 
        $_ENV['DB_PASS'], 
        $_ENV['DB_NAME']
    );

    $db->set_charset('utf8');

    if(!$db){
        echo "Error no se pudo conectar";
        exit; // Usamos este exit para que no se sigan ejecutando las lineas siguientes y para no revelar informacion sensible
    } 

    return $db;
}