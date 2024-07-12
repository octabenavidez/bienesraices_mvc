<?php

namespace Controllers;

use Model\Propiedad;
use MVC\Router;
use Model\Vendedor;

class VendedorController{
    public static function crear(Router $router){
        $vendedor = new Vendedor;

        // Declarar la array de errores vacia
        $errores = Vendedor::getErrores();

        if($_SERVER['REQUEST_METHOD'] === 'POST'){

            // Crear una nueva instancia
            $vendedor = new Vendedor($_POST['vendedor']);
            
            // Validar que no haya campos vacios
            $errores = $vendedor->validar();
    
            // Si no hay errores
            if(empty($errores)){
                $vendedor->guardar();
            }
        }

        $router->render('vendedores/crear', [
            'vendedor' => $vendedor,
            'errores' => $errores,
        ]);
    }

    public static function actualizar(Router $router){
        $id = validarORedireccionar('/admin');

        // Obtener el arreglo del vendedor
        $vendedor = Vendedor::find($id);

        // Declarar la array de errores vacia
        $errores = Vendedor::getErrores();

        if($_SERVER['REQUEST_METHOD'] === 'POST'){
        
            // Asignar los valores
            $args = $_POST['vendedor'];
    
            // Sincronizar objeto en memoria con lo que el usuario escribio
            $vendedor->sincronizar($args);
    
            // Validacion
            $errores = $vendedor->validar();
    
            if(empty($errores)){
                $vendedor->guardar();
            }
        }

        $router->render('/vendedores/actualizar', [
            'vendedor' => $vendedor,
            'errores' => $errores,
        ]);
    }

    public static function eliminar(){
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            // Validar id
            $id = $_POST['id'];
            $id = filter_var($id, FILTER_VALIDATE_INT);
    
            if($id){
    
                $tipo = $_POST['tipo'];
    
                if(validarTipoContenido($tipo)){
                    $vendedor = Vendedor::find($id);

                    // Obtener todas las propiedades asociadas a este vendedor
                    $propiedades = Propiedad::where('vendedores_id', $id);

                    // Actualizar el vendedores_id a NULL para cada propiedad
                    foreach ($propiedades as $propiedad) {
                        Propiedad::actualizarCampo($propiedad->id, 'vendedores_id', null);
                    }
                
                    $vendedor->eliminar();
                } 
            }
        }
    }
}