<?php
    // Texto comprimido
    function truncate(string $texto, int $cantidad) : string{
        if(strlen($texto) >= $cantidad) {
            return "<span title='$texto'>" . substr($texto, 0, $cantidad) . " ...</span>";
        } else {
            return $texto;
        }
    }
?>

<div class="contenedor-anuncios">
            <?php foreach( $propiedades as $propiedad){ ?>
                <div class="anuncio">
                    
                    <img loading="lazy" src="/imagenes/<?php echo $propiedad->imagen; ?>" alt="anuncio">
                    
                    <div class="contenido-anuncio">
                        <h3><?php echo $propiedad->titulo; ?></h3>
                        <p class="parrafo-propiedad">
                            <?php 
                            $descripcionChica = truncate($propiedad->descripcion, 39);

                            echo $descripcionChica;
                            ?>
                        </p>
                        <p class="precio"><?php echo $propiedad->precio; ?></p>

                        <ul class="iconos-caracteristicas">
                            <li>
                                <img class="icono" src="build/img/icono_wc.svg" alt="icono wc">
                                <p><?php echo $propiedad->wc; ?></p>
                            </li>
                            <li>
                                <img class="icono" src="build/img/icono_estacionamiento.svg" alt="icono estacionamiento">
                                <p><?php echo $propiedad->estacionamiento; ?></p>
                            </li>
                            <li>
                                <img class="icono" src="build/img/icono_dormitorio.svg" alt="icono habitaciones">
                                <p><?php echo $propiedad->habitaciones; ?></p>
                            </li>
                        </ul>

                        <a href="/propiedad?id=<?php echo $propiedad->id; ?>" class="boton-amarillo-block">Ver propiedad</a>
                    </div> <!-- Termina .contenido-anuncio -->
                </div> <!-- Termina .anuncio -->
            <?php } ?>
        </div> <!-- Termina .contenedor-anuncios -->
