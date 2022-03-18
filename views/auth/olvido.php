<div class="contenedor olvido">
    <?php include_once __DIR__ . '/../template/nombre-sitio.php' ?>
    <div class="contenedor-sm">
        <p class="descripcion-pagina">Recupra tu acceso UpTask</p>
        <?php include_once __DIR__ . '/../template/alertas.php' ?>
        <form action="/olvido-pass" class="formulario" method="post">
        <div class="campo">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" placeholder="Tu Email" >
        </div>
        <input type="submit" class="boton" value="Enviar instrucciones">
        </form>
        <div class="acciones">
            <a href="/">¿Ya tienes Cuenta? Iniciar Sesión</a>
            <a href="/olvido-pass">¿Olvidaste tu contraseña?</a>
        </div>
    </div> <!-- Contenedor sm -->
</div>