<div class="barra-mobile">
    <a href="/dashboard"><h1>UpTask</h1></a>
    <div class="menu">
        <img src="build/img/menu.svg" alt="iamgen menu" id="mobile-menu">
    </div>
</div>

<div class="barra">
    <p>Hola: <span><?php echo $_SESSION['nombre'].' '.$_SESSION['apellido'];?> </span></p>
    <a href="/logout" class="cerrar-sesion">Cerrar Sesión</a>
</div>