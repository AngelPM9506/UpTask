<?php

namespace Classes; 

use PHPMailer\PHPMailer\PHPMailer;

class Email{
    protected $email;
    protected $nombre;
    protected $token;

    public function __construct($email, $nombre, $token){
        $this->email = $email;
        $this->nombre = $nombre;
        $this->token = $token;
    }
    public function enviarcorreo($tipo){
        $mail = new PHPMailer();
        $mail->isSMTP();
        $mail->Host = 'smtp.mailtrap.io';
        $mail->SMTPAuth = true;
        $mail->Port = 2525;
        $mail->Username = 'f2cbb4d8224efa';
        $mail->Password = '04b8125eae7c74';
        /**Configuracion propia**/
        $mail->setFrom('cuentas@uptask.com');
        $mail->addAddress($this->email);

        $mail->isHTML(TRUE);
        $mail->CharSet = 'UTF-8';

        $contenido = "<html>";
        if ($tipo === 'confirmacion') {
            /**si se tiene que enviar una confirmaccion por correo electronico**/
            $mail->Subject = 'Confirma tu cuenta';
            $contenido .="<p><strong>Hola ".$this->nombre."</strong> Has Creado tu cuenta en UpTask, solo debes confirmarla en el siguiente enlace</p>";
            $contenido .="<p>Preciona aquí: <a href='https://".$_SERVER['HTTP_HOST']."/confirmar?token=".$this->token ."'>Confirmar Cuenta</a></p>";
            $contenido .="<p>Si tu no creaste esta cuenta, puedes ignorar este mensaje</p>";
        }elseif($tipo === 'reset'){
            /**si se tiene que enviar una solicitud para reestablecer contraseña por correo electronico**/
            $mail->Subject = 'Reestablecer tu contraseña';
            $contenido .="<p><strong>Hola ".$this->nombre."</strong> Has solicitado reestablecer tu contraseña en UpTask, solo debes entrar en el siguiente enlace</p>";
            $contenido .="<p>Preciona aquí: <a href='https://".$_SERVER['HTTP_HOST']."/reestablecer?token=".$this->token ."'>Reestablecer contraseña</a></p>";
            $contenido .="<p>Si tu NO has solicitado reestablecer tu contraseña, puedes ignorar este mensaje</p>";
        }
        $contenido .="</html>";

        $mail->Body = $contenido;
        /**enviar el email**/
        $mail->send();
    }
}
