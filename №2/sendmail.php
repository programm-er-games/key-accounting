<?php
use PHPMailer\PHPMailer\PHPMailer;
// use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'C:/Users/ipmin/vendor/autoload.php';

class Mail {
    private $mail;


    function send_mail($to, $subject, $body) {
        try {
            $this->mail->addAddress($to);
            $this->mail->Subject = $subject;
            $this->mail->Body = $body;
            $this->mail->AltBody = $body;
            $this->mail->send();
            return "Успешно!";
        }
        catch (Exception $e) {
            return "Ошибка! " . $this->mail->ErrorInfo;
        }
    }
    function __construct() {
        $this->mail = new PHPMailer(true);
        $this->mail->isSMTP();
        $this->mail->Host = 'tls://smtp.gmail.com';
        $this->mail->Port = 587;
        $this->mail->SMTPAuth = true;
        $this->mail->Username = 'noreplysecure161@gmail.com';
        $this->mail->Password = 'uwdh bpnr bzpr amrp';
        $this->mail->SMTPSecure = "tls";
        $this->mail->setFrom('from@example.com', 'Mailer');
    }
}