<?php

namespace Classes;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;

class Email
{

    public $nombre;
    public $email;
    public $token;

    public function __construct($nombre, $email, $token)
    {
        $this->nombre = $nombre;
        $this->email = $email;
        $this->token = $token;
    }

    public function enviarConfirmacion()
    {
        // Crear el objeto de email
        $mail = new PHPMailer(true);

        // Configurar SMTP
        $mail->isSMTP();
        $mail->Host = $_ENV['MAIL_HOST'];
        $mail->SMTPAuth = true;
        $mail->Username = $_ENV['MAIL_USER'];
        $mail->Password = $_ENV['MAIL_PASS'];
        $mail->SMTPSecure = 'tls';
        $mail->Port = $_ENV['MAIL_PORT'];
        
        // Contenido del email
        $mail->setFrom('correo@axity.com', 'axity');
        $mail->addAddress($this->email);
        $mail->Subject = 'Confirma tu cuenta';

        // Habilitar HTML
        $mail->isHTML(true);
        $mail->CharSet = 'UTF-8';

        $contenido = "<html>";
        $contenido .= "<p>Hola <strong>" . $this->nombre . "</strong> Haz creado tu cuenta en Axity, solo debes confirmarla presionando el siguiente enlace </p>";
        $contenido .= "<p>Presiona aquí: <a href='" . $_ENV['APP_URL'] . "/confirmar?token=" . $this->token . "'>Confirmar Cuenta</a></p>";
        $contenido .= "<p>Si tu no solicitaste esta cuenta, puedes ignorar el mensaje </p>";
        $contenido .= "</html>";

        $mail->Body = $contenido;

        // Enviamos el email
        $mail->send();
    }

    public function enviarInstrucciones()
    {
        // Crear el objeto de email
        $mail = new PHPMailer();

        // Configurar SMTP
        $mail->isSMTP();
        $mail->Host = $_ENV['MAIL_HOST'];
        $mail->SMTPAuth = true;
        $mail->Username = $_ENV['MAIL_USER'];
        $mail->Password = $_ENV['MAIL_PASS'];
        $mail->SMTPSecure = 'tls';
        $mail->Port = $_ENV['MAIL_PORT'];
        // Contenido del email
        $mail->setFrom('correo@axity.com', 'axity');
        $mail->addAddress($this->email);
        $mail->Subject = 'Reestablece tu cuenta';

        // Habilitar HTML
        $mail->isHTML(true);
        $mail->CharSet = 'UTF-8';

        $contenido = "<html>";
        $contenido .= "<p>Hola <strong>" . $this->nombre . "</strong> Parece que haz olvidado tu password de <strong>Axity</strong>, puedes recuperarlo presionando el siguiente enlace </p>";
        $contenido .= "<p>Presiona aquí: <a href='" . $_ENV['APP_URL'] . "/reestablecer?token=" . $this->token . "'>Reestablecer Password</a></p>";
        $contenido .= "<p>Si tu no solicitaste reestablecer tu password, puedes ignorar el mensaje </p>";
        $contenido .= "</html>";

        $mail->Body = $contenido;

        // Enviamos el email
        $mail->send();
    }
}
