<div class="contenedor login">
    <?php include_once __DIR__ . '/../template/nombre-sitio.php' ?>
    <div class="contenedor-sm">
        <p class="descripcion-pagina">Iniciar Sesion</p>
        <?php include_once __DIR__ . '/../template/alertas.php' ?>
        <form action="/" class="formulario" method="post">
        <div class="campo">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" placeholder="Tu Email">
        </div>
        <div class="campo">
            <label for="password">Contraseña</label>
            <input type="password" id="password" name="password" placeholder="Tu Contraseña">
        </div>
        <input type="submit" class="boton" value="Iniciar Sesión">
        </form>
        <div class="acciones">
            <a href="/crear-cuenta">¿Aán no tienes una cuenta? Crea una</a>
            <a href="/olvido-pass">¿Olvidaste tu contraseña?</a>
        </div>
    </div> <!-- Contenedor sm -->
</div>