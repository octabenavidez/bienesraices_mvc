<?php

namespace Controllers;

use Classes\Email;
use MVC\Router;
use Model\Propiedad;
use Model\Imagenes;

class PaginasController{
    public static function index(Router $router){
        $inicio = true;
        $propiedades = Propiedad::get(3);

        $router->render('paginas/index', [
            'propiedades' => $propiedades,
            'inicio' => $inicio
        ]);
    }

    public static function nosotros(Router $router){
        $router->render('paginas/nosotros');
    }

    public static function propiedades(Router $router){
        $propiedades = Propiedad::all();

        $router->render('paginas/propiedades', [
            'propiedades' => $propiedades,
        ]);
    }

    public static function propiedad(Router $router){
        $id = validarORedireccionar('/propiedades');

        //Buscar la propiedad por su id
        $propiedad = Propiedad::find($id);

        $imagenes = Imagenes::images($id);

        $router->render('paginas/propiedad', [
            'propiedad' => $propiedad,
            'imagenes' => $imagenes
        ]);
    }

    public static function blog(Router $router){
        $router->render('paginas/blog');
    }

    public static function entrada(Router $router){
        $router->render('paginas/entrada', [
        ]);
    }

    public static function contacto(Router $router){
        $mensaje = null;

        if($_SERVER['REQUEST_METHOD'] === "POST"){

            $respuestas = $_POST['contacto'];

            $email = new Email($respuestas);
            $email->enviarEmail();

        }

        $router->render('paginas/contacto', [
            'mensaje' => $mensaje
        ]);
    }

}