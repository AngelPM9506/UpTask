<div class="contenedor reset">
    <?php include_once __DIR__ . '/../template/nombre-sitio.php' ?>
    <div class="contenedor-sm">
        <p class="descripcion-pagina">Crea tu cuenta en UpTask</p>
    <?php include_once __DIR__ . '/../template//alertas.php' ?>
    <?php if($mostrar) : ?>
        <form class="formulario" method="post">
        <div class="campo">
            <label for="password">Contraseña</label>
            <input type="password" id="password" name="password" placeholder="Tu Contraseña">
        </div>
        <div class="campo">
            <label for="password2">Repetir Contraseña</label>
            <input type="password" id="password2" name="password2" placeholder="Repite tu Contraseña">
        </div>
        <input type="submit" class="boton" value="Reestablecer">
        </form>
    <?php endif; ?>
        <div class="acciones">
            <a href="/">¿Listo? Iniciar Sesión</a>
            <a href="/olvido-pass">¿Olvidaste tu contraseña?</a>
        </div>
    </div> <!-- Contenedor sm -->
</div>