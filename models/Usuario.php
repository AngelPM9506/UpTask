<?php

namespace Model;

class Usuario extends ActiveRecord {
    protected static $tabla = 'usuarios'; 
    protected static $columnasDB = ['id','nombre','apellido','email','password','token','confirmado']; 

    /*public $id;
    public $nombre;
    public $apellido;
    public $email;
    public $password;
    public $password2;
    public $token;
    public $confirmado;*/

    public function __construct($args = []){
        $this -> id = $args['id'] ?? null ;
        $this -> nombre = $args['nombre'] ?? '' ;
        $this -> apellido = $args['apellido'] ?? '' ;
        $this -> email = $args['email'] ?? '' ;
        $this -> password = $args['password'] ?? '' ;
        $this -> password2 = $args['password2'] ?? null ;
        $this -> password_actual = $args['password_actual'] ?? null ;
        $this -> password_nuevo = $args['password_nuevo'] ?? null ;
        $this -> password_nuevo2 = $args['password_nuevo2'] ?? null ;
        $this -> token = $args['token'] ?? '' ;
        $this -> confirmado = $args['confirmado'] ?? '0' ;
    }
    /** Validacion para nuevas cuentas **/
    public function validarNuevaCuenta() : array{
        if (!$this->nombre) {
            self::$alertas['error'][] = 'El Nombre de usuario es obligatorio';
        }
        if (!$this->apellido) {
            self::$alertas['error'][] = 'El Apellidor de usuario es obligatorio';
        }
        if (!$this->email) {
            self::$alertas['error'][] = 'Colocar un email es obligatorio';
        }
        if (!$this->password) {
            self::$alertas['error'][] = 'Colocar una contraseña es obligatorio';
        }
        /**Longitud de la contraseña */
        if (strlen($this->password) < 6) {
            self::$alertas['error'][] = 'La contraseña debe terner almenos 6 caracteres';
        }
        if ($this->password !== $this->password2) {
            self::$alertas['error'][] = 'El campo de repetir contraseña es diferente al de contraseña intenta de nuevo';
        }
        return self::$alertas;
    }
    /**Comprobar password**/
    public function comprobar_password() : bool{
        return password_verify($this->password_actual, $this->password);
    }
    /**Hashea el pasword**/
    public function hashPassword() : void{
        $this->password = password_hash($this->password, PASSWORD_BCRYPT);
    }
    /**Generar un token */
    public function crearToken() : void{
        $this->token = md5(uniqid());
    }
    /**Validar correo para recuperar contraseña**/
    public function validarCorreo(){
        if (!$this->email) {
            self::$alertas['error'][] = 'Colocar un email es obligatorio';
        }
        /**filtrar que realmente se tenga un correo y no cualquoer string**/
        if (!filter_var($this->email,FILTER_VALIDATE_EMAIL)) {
            self::$alertas['error'][] = 'Email no valido intenta de nuevo';
        }
        return self::$alertas;
    }
    /**Validar el reestablecimiento de contraseña**/
    public function validarNuevoPassword(){
        if (!$this->password) {
            self::$alertas['error'][] = 'Colocar una contraseña es obligatorio';
        }
        /**Longitud de la contraseña */
        if (strlen($this->password) < 6) {
            self::$alertas['error'][] = 'La contraseña debe terner almenos 6 caracteres';
        }
        if ($this->password !== $this->password2) {
            self::$alertas['error'][] = 'El campo de repetir contraseña es diferente al de contraseña intenta de nuevo';
        }
        return self::$alertas;
    }
    public function validarLogin(){        
        if (!$this->email) {
            self::$alertas['error'][] = 'Colocar un email es obligatorio';
        }
        /**filtrar que realmente se tenga un correo y no cualquoer string**/
        if (!filter_var($this->email,FILTER_VALIDATE_EMAIL)) {
            self::$alertas['error'][] = 'Email no valido intenta de nuevo';
        }
        if (!$this->password) {
            self::$alertas['error'][] = 'Colocar una contraseña es obligatorio';
        }
        return self::$alertas;
    }
    public function validar_perfil(){
        if (!$this->nombre) {
            self::$alertas['error'][] = 'El Nombre de usuario es obligatorio';
        }
        if (!$this->apellido) {
            self::$alertas['error'][] = 'El Apellidor de usuario es obligatorio';
        }
        if (!$this->email) {
            self::$alertas['error'][] = 'Colocar un email es obligatorio';
        }
        return self::$alertas;
    }
    public function nuevo_password(){
        /**que existan valores en los password */
        if (!$this->password_actual) {
            self::$alertas['error'][] = 'Colocar tu contraseña actual es obligatorio';
        }
        if (!$this->password_nuevo) {
            self::$alertas['error'][] = 'Colocar una contraseña es obligatorio';
        }
        /**Longitud de la contraseña nueva */
        if (strlen($this->password_nuevo) < 6) {
            self::$alertas['error'][] = 'La contraseña nueva debe terner almenos 6 caracteres';
        }
        if ($this->password_nuevo !== $this->password_nuevo2) {
            self::$alertas['error'][] = 'El campo de repetir contraseña nueva es diferente al de contraseña nueva intenta de nuevo';
        }
        return self::$alertas;
    }
}