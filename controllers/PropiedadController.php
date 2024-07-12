<?php

namespace Controllers;
use MVC\Router;
use Model\Propiedad;
use Model\Vendedor;
use Model\Imagenes;
use Intervention\Image\ImageManagerStatic as Image;

class PropiedadController{
    public static function index(Router $router) {
        $propiedades = Propiedad::all();

        $vendedores = Vendedor::all();

        // Muestra mensaje condicional
        $resultado = $_GET['resultado'] ?? null;

        $router->render('propiedades/admin', [
            'propiedades' => $propiedades,
            'resultado' => $resultado,
            'vendedores' => $vendedores,
        ]);
    }

    public static function crear(Router $router) {
        $propiedad = new Propiedad;
        $vendedores = Vendedor::all();
        
        // Declarar la array de errores vacia
        $errores = Propiedad::getErrores();
        // Metodo POST para crear
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            
            // Crea una nueva instancia ***
            $propiedad = new Propiedad($_POST['propiedad']);

            
            // Crear carpeta
            if(!is_dir(CARPETA_IMAGENES)){
                mkdir(CARPETA_IMAGENES);
            }

            //Generar un nombre unico
            $nombreImagen = md5(uniqid(rand(), true)) . ".jpg";

            // Resize y set de la imagen
            if($_FILES['propiedad']['tmp_name']['imagen']){
                // Realizar un resize a la imagen con intervention
                $image = Image::make($_FILES['propiedad']['tmp_name']['imagen'])->fit(800, 600);

                // Setear la imagen
                $propiedad->setImagen($nombreImagen);
            }

            // VALIDACION DE ERRORES ***
            $errores = $propiedad->validar();
        
            if(empty($errores)){
                // Guarda la imagen en el servidor
                $image->save(CARPETA_IMAGENES . $nombreImagen);
                
                // Guarda en la base de datos
                $propiedad->guardar();

                $lastID = $propiedad->lastId();

                if($_FILES['imagenes']['tmp_name'][0]){
                    foreach ($_FILES['imagenes']['tmp_name'] as $key => $value){
                        // Instanciamos un nuevo modelo por cada imagen
                        $imagenes = new Imagenes;
        
                        // Crear carpeta
                        if(!is_dir(CARPETA_IMAGENES_DESCRIPTIVAS)){
                            mkdir(CARPETA_IMAGENES_DESCRIPTIVAS);
                        }
        
                        //Generar un nombre unico
                        $nombreImagen = md5(uniqid(rand(), true)) . ".jpg";
        
                        // Realizar un resize a la imagen con intervention
                        $image = Image::make($_FILES['imagenes']['tmp_name'][$key])->fit(800, 600);
        
                        // Setear el nombre de la imagen
                        $imagenes->setImagen($nombreImagen);
    
                        // Setear el id 
                        $imagenes->setID($lastID);
                        
                        // Guarda la imagen en el servidor
                        $image->save(CARPETA_IMAGENES_DESCRIPTIVAS . $nombreImagen);
        
                        // Guarda en la base de datos
                        $imagenes->guardar();
                    }
                }
            }
        }

        $router->render('propiedades/crear', [
            'propiedad' => $propiedad,
            'vendedores' => $vendedores,
            'errores' => $errores,
        ]);
    }

    public static function actualizar(Router $router) {
        $id = validarORedireccionar('/admin');

        $propiedad = Propiedad::find($id);
        $errores = Propiedad::getErrores();
        $vendedores = Vendedor::all();
        $imagenes = Imagenes::images($id);

        // Metodo POST para actualizar
        if($_SERVER['REQUEST_METHOD'] === 'POST'){

            // Asiginar los atributos
            $args = $_POST['propiedad'];
            
            // Sincronizar la informacion del usuario con la existente
            $propiedad->sincronizar($args);

            // Validacion
            $errores = $propiedad->validar();
    
            // Revisar que el arreglo de errores este vacio
            if(empty($errores)){

                // Setear la imagen
                if($_FILES['propiedad']['tmp_name']['imagen']){
                    //Generar un nombre unico
                    $nombreImagen = md5(uniqid(rand(), true)) . ".jpg";
        
                    // Realizar un resize a la imagen con intervention
                    $image = Image::make($_FILES['propiedad']['tmp_name']['imagen'])->fit(800, 600);
                    $propiedad->setImagen($nombreImagen);
                   
                    // Almacenar la imagen
                    $image->save(CARPETA_IMAGENES . $nombreImagen);
                }
    
                $propiedad->guardar();

                if($_FILES['imagenes']['tmp_name'][0]){
                    foreach ($imagenes as $imagen) {
                        $imagen->eliminarImagenes($imagen->url);
                    }
    
                    foreach ($_FILES['imagenes']['tmp_name'] as $key => $value){
            
                        $imagenes = new Imagenes;
        
                        // Crear carpeta
                        if(!is_dir(CARPETA_IMAGENES_DESCRIPTIVAS)){
                            mkdir(CARPETA_IMAGENES_DESCRIPTIVAS);
                        }
        
                        //Generar un nombre unico
                        $nombreImagen = md5(uniqid(rand(), true)) . ".jpg";
        
                        // Realizar un resize a la imagen con intervention
                        $image = Image::make($_FILES['imagenes']['tmp_name'][$key])->fit(800, 600);
        
                        // Setear el nombre de la imagen
                        $imagenes->setImagen($nombreImagen);
    
                        // Setear el id 
                        $imagenes->setID($id);
                        
                        // Guarda la imagen en el servidor
                        $image->save(CARPETA_IMAGENES_DESCRIPTIVAS . $nombreImagen);
        
                        // Guarda en la base de datos
                        $imagenes->guardar();
                    }
                } 
            }
        }

        $router->render('/propiedades/actualizar', [
            'propiedad' => $propiedad,
            'errores' => $errores,
            'vendedores' => $vendedores,
            'imagenes' => $imagenes
        ]);
    }

    public static function eliminar(){
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            // Validar id
            $id = $_POST['id'];
            $id = filter_var($id, FILTER_VALIDATE_INT);
    
            if($id){
    
                $imagenes = Imagenes::images($id);

                foreach ($imagenes as $imagen) {
                    $imagen->eliminarImagenes($imagen->url);
                }

                $tipo = $_POST['tipo'];
    
                if(validarTipoContenido($tipo)){
                    $propiedad = Propiedad::find($id);
                    $propiedad->eliminar();
                } 

                
            }
        }
    }
}