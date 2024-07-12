<main class="contenedor seccion contenido-centrado">
        <h1>Actualizar Propiedad</h1>

        <a href="/admin" class="boton-verde">Volver</a>

        <?php foreach($errores as $error): ?> 
            <div class="alerta-larga error">
                <?php echo $error;?>
            </div>
        <?php endforeach; ?>

        <form class="formulario" method="POST" enctype="multipart/form-data">
            <?php include __DIR__ . '/formulario.php' ?>

            <input type="submit" value="Actualizar Propiedad" class="boton-verde">
        </form>
</main>