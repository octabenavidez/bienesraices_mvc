<fieldset>
    <legend>Información General</legend>
    
    <label for="vendedor">Nombre:</label>
    <input type="text" id="vendedor" name="vendedor[nombre]" placeholder="Nombre Vendedor" value="<?php echo s($vendedor->nombre);?>">

    <label for="apellido">Apellido:</label>
    <input type="text" id="apellido" name="vendedor[apellido]" placeholder="Apellido Vendedor" value="<?php echo s($vendedor->apellido);?>">
</fieldset>

<fieldset>
    <legend>Información Extra</legend>
    
    <label for="telefono">Teléfono:</label>
    <input type="text" id="telefono" name="vendedor[telefono]" placeholder="Teléfono Vendedor" value="<?php echo s($vendedor->telefono);?>">

</fieldset>