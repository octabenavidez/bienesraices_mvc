<?php

namespace Model;

class Imagenes extends ActiveRecord{
    // Base de datos
    protected static $tabla = 'imagenes';
    protected static $columnasDB = ['imagenes_id', 'url', 'propiedad_id'];

    public $imagenes_id;
    public $url;
    public $propiedad_id;

    // Setear la url de las imagenes
    public function setImagen($imagen){
        // Elimina la imagen previa
        if(!is_null($this->url)){
           $this->borrarImagen();
        }

        // Asignar al atributo de imagen el nombre de la imagen
        if($imagen){
           $this->url = $imagen; 
        }
    }

    public function borrarImagen(){
        // Comprobar si existe el archivo
        $existeArchivo = file_exists(CARPETA_IMAGENES_DESCRIPTIVAS . $this->url);
        if($existeArchivo){
            unlink(CARPETA_IMAGENES_DESCRIPTIVAS . $this->url);
        }
    }

    // Setear el id de las propiedades en las imagenes
    public function setID($id){
        if($id){
            $this->propiedad_id = $id; 
        }
    }

    public static function images($id){
        $query = "SELECT P.titulo,I.url FROM propiedades P INNER JOIN imagenes I ON P.id = I.propiedad_id WHERE P.id = ${id}";
     
        $resultado = self::consultarSQL($query);

        // debuguear($resultado);

        return $resultado;
    }

    public function eliminarImagenes($url) {
        // Eliminar la propiedad
        $query = "DELETE FROM imagenes WHERE url = '$url' LIMIT 1";
        $resultado = self::$db->query($query);

        if($resultado){
            $this->borrarImagen();

            header('Location: /admin?resultado=2');    
        }
    }


}