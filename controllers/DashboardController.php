<?php 
namespace Controllers;

use Model\Proyecto;
use Model\Usuario;
use MVC\Router;

class DashboardController{
    public static function index(Router $router){
        session_start();
        isAuth();
        $id = $_SESSION['id'];
        $proyectos = Proyecto::belongsTo('propietarioId', $id);
        $router->render('dashboard/index',[
            'titulo' => 'proyectos',
            'proyectos' => $proyectos
        ]);
    }
    public static function crear_proyecto(Router $router){
        session_start();
        isAuth();
        $alertas = [];
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $proyecto = new Proyecto($_POST);
            /**Valiodacion**/
            $alertas = $proyecto->validarProyecto();
            if (empty($alertas)) {
                /**Generar una url unica**/
                $hash = md5(uniqid());
                $proyecto->url = $hash;
                /**Almacenar el creador del proyecto**/
                $proyecto->propietarioId = $_SESSION['id'];
                /**almacenar proyecto */
                $proyecto->guardar();
                /**redireccionar**/
                header('Location: /proyecto?item='.$proyecto->url);
            }
        }
        $router->render('dashboard/crear-proyecto',[
            'titulo' => 'crear-proyecto',
            'alertas' => $alertas
        ]);
    }
    public static function perfil(Router $router){
        session_start();
        isAuth();
        $alertas = [];
        $usuario = Usuario::find($_SESSION['id']);
        if ($_SERVER['REQUEST_METHOD']=== 'POST') {
            $usuario->sincronizar($_POST);
            $alertas = $usuario->validar_perfil();
            if (empty($alertas)) {
                /**Verificar que el correo del usuario no se repita con otro usuario**/
                $existeUsuario = Usuario::where('email',$usuario->email);
                if ($existeUsuario && $existeUsuario->id !== $usuario->id) {
                    /**Mensaje de error**/
                    Usuario::setAlerta('error','Correo de usuario ya registrado intenta con otro correo');
                }else{
                    /** Proceder a hacer cambios**/
                    /**Guardar cambios */
                    $usuario->guardar();
                    /**Ǵenerar alerta de exito */
                    Usuario::setAlerta('exito','Datos Actualizados Correctamente');
                    /**Asignar el nombre nuevo a la barra**/
                    $_SESSION['nombre'] = $usuario->nombre;
                    $_SESSION['apellido'] = $usuario->apellido;
                    $_SESSION['email'] = $usuario->email;
                    /**Guardar alertas para mostrarlos**/
                }
                $alertas = Usuario::getAlertas();
            }
        }
        $router->render('dashboard/perfil',[
            'titulo' => 'perfil',
            'alertas' => $alertas,
            'usuario' => $usuario
        ]);
    }

    public static function proyecto(Router $router){
        session_start();
        isAuth();
        $url = s($_GET['item']);
        if(!$url) header('Location: /dashboard');
        /**Revisar que la persona que visita el proyecto, es quien lo creo**/
        $proyecto = Proyecto::where('url', $url);
        if ($proyecto->propietarioId !== $_SESSION['id']) {
            header('Location: /dashboard');
        }
        $router->render('dashboard/proyecto',[
            'titulo' => 'proyecto: '. $proyecto->proyecto
        ]);
    }
    public static function cambiar_password(Router $router) {
        session_start();
        isAuth();
        $alertas = [];
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $usuario = Usuario::find($_SESSION['id']);
            /**sincronizar datos */
            $usuario->sincronizar($_POST);
            $alertas = $usuario->nuevo_password();
            if (empty($alertas)) {
                $resultado = $usuario->comprobar_password();
                if ($resultado) {
                    /**asignar el nuevo pasword**/
                    $usuario->password = $usuario->password_nuevo;
                    /**hashear de nuevo el pasword**/
                    $usuario->hashPassword();
                    /**guardar cambios */
                    $resultado = $usuario->guardar();
                    if ($resultado) {
                        Usuario::setAlerta('exito','Contraseña nueva guardada correctamente');
                    }
                }else{
                    /**mandar alerta de password incorrecta */
                    Usuario::setAlerta('error', 'Contraseña actual incorrecta intenta de nuevo');
                }
                $alertas = Usuario::getAlertas();
            }
        }
        $router->render('dashboard/cambiar-password',[
            'titulo' => 'Cambiar Contraseña',
            'alertas' => $alertas
        ]);
    }
}