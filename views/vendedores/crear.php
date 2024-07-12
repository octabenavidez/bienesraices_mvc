<main class="contenedor seccion contenido-centrado">
        <h1>Registrar Vendedor</h1>

        <a href="/bienesraices/admin" class="boton-verde">Volver</a>

        <?php foreach($errores as $error): ?> 
        <div class="alerta-larga error">
            <?php echo $error;?>
        </div>
        <?php endforeach; ?>

        <form class="formulario" method="POST" action="/vendedores/crear">
            <?php include __DIR__ . '/formulario.php' ?>

            <input type="submit" value="Registrar Vendedor" class="boton-verde">
        </form>
</main>