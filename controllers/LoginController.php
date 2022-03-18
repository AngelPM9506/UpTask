<?php

namespace Controllers;

use Classes\Email;
use Model\Usuario;
use MVC\Router;

class LoginController{
    public static function index(Router $router){
        $alertas = [];
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $usuario = new Usuario($_POST);
            $alertas = $usuario->validarLogin();
            if (empty($alertas)) {
                /**verificar que el usuario exista**/
                $usuario = Usuario::where('email', $usuario->email);
                if (!$usuario) {
                    Usuario::setAlerta('error', 'Usuario no registrado');
                }elseif(!$usuario->confirmado){
                    Usuario::setAlerta('error', 'Usuario no No confirmado, revisa tu bandeja de entrada para confirmar');
                }else{
                    /**El usuario existe y esta confirmado**/
                    if (password_verify($_POST['password'], $usuario->password)) {
                        session_start();
                        /**iniciar la sesion del usuario**/
                        $_SESSION['id'] = $usuario->id;
                        $_SESSION['nombre'] = $usuario->nombre;
                        $_SESSION['apellido'] = $usuario->apellido;
                        $_SESSION['email'] = $usuario->email;
                        $_SESSION['login'] = true;
                        /**Redireccionar**/
                        header('Location: /dashboard');
                    }else{
                        Usuario::setAlerta('error', 'password Incorrecto');
                    }
                }
            }
        }
        /**revisar de nuevo las aertas**/
        $alertas = Usuario::getAlertas();
        /**Render a la vista**/
        $router->render('auth/login',[
            'titulo' => 'Inicio de sesion',
            'alertas' => $alertas
        ]);
    }
    public static function logout(Router $router){
        session_start();
        $_SESSION = [];
        header('Location: /');
    }
    public static function crear(Router $router){
        /**Primero crear un objeto vacio de usuario**/
        $usuario = new Usuario;
        $alertas = [];
        /** */
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $usuario->sincronizar($_POST);
            $alertas = $usuario->validarNuevaCuenta();
            if (empty($alertas)) {
                $existeUsurario = Usuario::where('email', $usuario->email);
                if ($existeUsurario) {
                    Usuario::setAlerta('error', 'El usuario ya esta registrado');
                    $alertas = Usuario::getAlertas();
                }else{
                    /**hashear usuario**/
                    $usuario->hashPassword();
                    /**Eliminar password2**/
                    unset($usuario->password2);
                    unset($usuario->password_actual);
                    unset($usuario->password_nuevo);
                    unset($usuario->password_nuevo2);
                    /**Crear token**/
                    $usuario->crearToken();
                    /**Crear un nuevo usuario**/
                    //debuguear($usuario->guardar());
                    $resultado = $usuario->guardar();
                    /**Enviar emial**/
                    $email = new Email($usuario->email, $usuario->nombre, $usuario->token);
                    $email->enviarcorreo('confirmacion');
                    /**Cuando re direccionar al mensaje */
                    if ($resultado) {
                        header('Location: /mensaje');
                    }
                }
            }
        }
        $router->render('auth/crear',[
            'titulo' => 'Crear Cuenta',
            'usuario' => $usuario,
            'alertas' => $alertas
        ]);
    }
    public static function olvidoPass(Router $router){
        $alertas = [];
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $usuario = new Usuario($_POST);
            $alertas = $usuario->validarCorreo();
            if (empty($alertas)) {
                /**buscar el usuario**/
                $usuario = Usuario::where('email', $usuario->email);
                if ($usuario) {
                    if ($usuario->confirmado) {
                        /**Generar token**/
                        $usuario->crearToken();
                        unset($usuario->password2);
                        /**Actualizar usuario**/
                        $usuario->guardar();
                        /**Enviar email**/
                        $email = new Email($usuario->email, $usuario->nombre, $usuario->token);
                        $email->enviarcorreo('reset');
                        /**imprimar alerta**/
                        Usuario::setAlerta('exito', 'Enviamos las instrucciones a tu email para reestablecer tu contraseña');
                    }else{
                        Usuario::setAlerta('error', 'Usuario no confirmado, revisa tu email y sigue las instrucciones');
                    }
                }else{
                    Usuario::setAlerta('error', 'El usuario no existe');
                }
            }
        }
        $alertas = Usuario::getAlertas() ?? '';
        /**Mostrar la vista**/
        $router->render('auth/olvido',[
            'titulo' => 'nueva contraseña',
            'alertas' => $alertas
        ]);
    }
    public static function reestablecer(Router $router){
        $token = s($_GET['token']);
        $mostrar = true;
        if(!$token) header('Location: /');
        /**identifiacr el usuario con este token**/
        $usuario = Usuario::where('token',$token);
        if (empty($usuario)) {
            Usuario::setAlerta('error','URL Invalido no se cambiara ningun dato');
            $mostrar = false;
        }
        //debuguear($usuario);
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            /**Reestablecer contraseña**/
            $usuario->sincronizar($_POST);
            /**Validar contraseña nueva**/
            $alertas = $usuario->validarNuevoPassword();
            if (empty($alertas)) {
                /**hashear password**/
                $usuario->hashPassword();
                /**Eliminar token**/
                $usuario->token = 0;
                /**Eliminar passwoed2**/
                unset($usuario->passowrd2);
                /**Guardar nueva contraseña**/
                $usuario->guardar();
                /**Mandar mensaje de exito**/
                Usuario::setAlerta('exito','Nueva Contraseña Guardada Exitosamente ya puedes iniciar sesión');
                $mostrar = false;
            }
        }
        $alertas = Usuario::getAlertas();
        $router->render('auth/reestablecer',[
            'titulo' => 'reestablecer contraseña',
            'alertas' => $alertas,
            'mostrar' => $mostrar
        ]);
    }
    public static function mensaje(Router $router){
        Usuario::setAlerta('mensaje','Hemos enviado las instrucciones para confirmar tu cuenta a tu email');
        $alertas = Usuario::getAlertas();
        $router->render('auth/mensaje',[
            'titulo' => 'Cuenta creada exitosamente',
            'alertas' => $alertas
        ]);
    }
    public static function confirmar(Router $router){
        $token = s($_GET['token']);
        if(!$token) header('Location: /');
        /**Encontrar al usuario con este token**/
        $usuario = Usuario::where('token', $token);
        if (empty($usuario)) {
            /**No se encontro el usuario con ese token**/
            Usuario::setAlerta('error','Token no valido');
        }else{
            /**Confirmar cuenta**/
            $usuario->confirmado = 1;
            $usuario->token = null;
            unset($usuario->password2);
            $usuario->guardar();
            Usuario::setAlerta('exito','Email validado correctamente, ya puedes iniciar sesión');
        }
        $alertas = Usuario::getAlertas() ?? '';

        $router->render('auth/confirmar',[
            'titulo' => 'confirmación de cuenta',
            'alertas' => $alertas
        ]);
    }
}