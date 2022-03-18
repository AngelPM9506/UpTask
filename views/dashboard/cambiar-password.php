<?php include_once __DIR__.'/header-dashboard.php'; ?> 
<div class="contenedor-sm">
    <?php include_once __DIR__.'/../template/alertas.php';?>
        <a href="/perfil" class="enlace">Volver a perfil</a>
    <form action="/cambiar-password" class="formulario" method="POST">
        <div class="campo">
            <label for="password_actual">Contraseña actual</label>
            <input type="password" name="password_actual" id="password_actual" placeholder="Tu contraseña actual"/>
        </div>
        <div class="campo">
            <label for="password_nuevo">Nueva contraseña</label>
            <input type="password" name="password_nuevo" id="password_nuevo" placeholder="Tu nueva contraseña"/>
        </div>
        <div class="campo">
            <label for="password_nuevo2">Repite la nueva ccontraseña</label>
            <input type="text" name="password_nuevo2" id="password_nuevo2" placeholder="Tu nueva contraseña"/>
        </div>
        <input type="submit" value="Guardar Cambios">
    </form>
</div>
<?php include_once __DIR__.'/footer-dashboard.php'; ?> 


