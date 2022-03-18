<?php include_once __DIR__.'/header-dashboard.php'; ?> 
<div class="contenedor-sm">
    <?php include_once __DIR__.'/../template/alertas.php';?>
        <a href="/cambiar-password" class="enlace" >Cambiar Contraseña</a>
    <form action="/perfil" class="formulario" method="POST">
        <div class="campo">
            <label for="nombre">Nombre</label>
            <input type="text" name="nombre" id="nombre" placeholder="Tu nombre" value="<?php echo $usuario->nombre;?>"/>
        </div>
        <div class="campo">
            <label for="apellido">Apellido</label>
            <input type="text" name="apellido" id="apellido" placeholder="Tu apellido" value="<?php echo $usuario->apellido;?>"/>
        </div>
        <div class="campo">
            <label for="email">Email</label>
            <input type="text" name="email" id="email" placeholder="Tu email" value="<?php echo $usuario->email;?>"/>
        </div>
        <input type="submit" value="Guardar Cambios">
    </form>
</div>
<?php include_once __DIR__.'/footer-dashboard.php'; ?> 