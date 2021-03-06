<div class="contenedor crear">
    <?php include_once __DIR__ . '/../template/nombre-sitio.php' ?>
    <div class="contenedor-sm">
        <p class="descripcion-pagina">Crea tu cuenta en UpTask</p>
    <?php include_once __DIR__ . '/../template/alertas.php' ?>
        <form action="/crear-cuenta" class="formulario" method="post">
        <div class="campo">
            <label for="nombre">Nombre</label>
            <input type="text" id="nombre" name="nombre" placeholder="Tu Nombre" value="<?php echo $usuario->nombre; ?>">
        </div>
        <div class="campo">
            <label for="apellido">Apellido</label>
            <input type="text" id="apellido" name="apellido" placeholder="Tu Apellido" value="<?php echo $usuario->apellido; ?>">
        </div>
        <div class="campo">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" placeholder="Tu Email" value="<?php echo $usuario->email; ?>" >
        </div>
        <div class="campo">
            <label for="password">Contraseña</label>
            <input type="password" id="password" name="password" placeholder="Tu Contraseña">
        </div>
        <div class="campo">
            <label for="password2">Repetir Contraseña</label>
            <input type="password" id="password2" name="password2" placeholder="Repite tu Contraseña">
        </div>
        <input type="submit" class="boton" value="Crear Cuenta">
        </form>
        <div class="acciones">
            <a href="/">¿Ya tienes Cuenta? Iniciar Sesión</a>
            <a href="/olvido-pass">¿Olvidaste tu contraseña?</a>
        </div>
    </div> <!-- Contenedor sm -->
</div>