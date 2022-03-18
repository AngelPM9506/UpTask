<aside class="sidebar">
    <div class="contenedor-sidebar">
        <a href="/dashboard"><h2>UpTask</h2></a>
        <div class="cerrar-menu">
            <img  alt="imagen cerrar menu" src="build/img/cerrar.svg" id="cerrar-menu">
        </div>
    </div>
    <nav class="sidebar-nav">
        <a class="<?php echo ($titulo === 'proyectos') ? 'activo' : '' ; ?>" href="/dashboard">Proyectos</a>
        <a class="<?php echo ($titulo === 'crear-proyecto') ? 'activo' : '' ; ?>" href="/crear-proyecto">Crear Proyecto</a>
        <a class="<?php echo ($titulo === 'perfil') ? 'activo' : '' ; ?>" href="/perfil">Perfil</a>
    </nav>
    <div class="cerrar-sesion-mobile">
        <a href="loguot" class="cerrar-sesion">Cerrar Sesion</a>
    </div>
</aside>