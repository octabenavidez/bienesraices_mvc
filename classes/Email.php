<?php

namespace Classes;

use PHPMailer\PHPMailer\PHPMailer;

class Email {

    public $respuestas;

    public function __construct($respuestas)
    {
        $this->respuestas = $respuestas;
    }

    public function enviarEmail() {

        // Crear una instancia de PHPmailer
        $mail = new PHPMailer();
        $mail->isSMTP();
        $mail->Host = $_ENV['MAIL_HOST'];
        $mail->SMTPAuth = true;
        $mail->Port = $_ENV['MAIL_PORT'];
        $mail->Username = $_ENV['MAIL_USER'];
        $mail->Password = $_ENV['MAIL_PASS'];

        // Configurar contenido del mail
        $mail->setFrom('admin@bienesraices.com');
        $mail->addAddress('admin@bienesraices.com', 'BienesRaices.com');
        $mail->Subject = 'Tienes un nuevo mensaje';

        // Habilitar HTML
        $mail->isHTML(true);
        $mail->CharSet = 'UTF-8';

        // Definir el contenido
        $contenido = '<html>';
        $contenido .= '<p>Tienes un nuevo mensaje</p>';
        $contenido .= '<p>Nombre: ' . $this->respuestas['nombre'] .'</p>';

        // Enviar de forma condicional algunos campos de email o telefono
        if($this->respuestas['contacto'] === 'telefono'){
            $contenido .= '<p>Eligio ser contactado por Telefono: </p>';
            $contenido .= '<p>Telefono: ' . $this->respuestas['telefono'] .'</p>';
            $contenido .= '<p>Fecha contacto: ' . $this->respuestas['fecha'] .'</p>';
            $contenido .= '<p>Hora: ' . $this->respuestas['horario'] .'</p>';
        } else{
            
            $contenido .= '<p>Eligio ser contactado por Email: </p>';
            $contenido .= '<p>Email: ' . $this->respuestas['email'] .'</p>';
        }

        $contenido .= '<p>Mensaje: ' . $this->respuestas['mensaje'] .'</p>';
        $contenido .= '<p>Vende o compra: ' . $this->respuestas['tipo'] .'</p>';
        $contenido .= '<p>Precio o presupuesto: $' . $this->respuestas['precio'] .'</p>';

        $contenido .= '</html>';

        $mail->Body = $contenido;
        $mail->AltBody = 'Esto es texto alternativo sin HTML';

         //Enviar el mail
         $mail->send();

    }


}