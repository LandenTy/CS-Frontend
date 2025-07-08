<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require __DIR__ . "/vendor/autoload.php";

$mail = new PHPMailer(true);

// $mail->SMTPDebug = SMTP::DEBUG_SERVER;

$mail->isSMTP();
$mail->SMTPAuth = true;

$mail->Host = "smtp.gmail.com";
$mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
$mail->Port = 587;
$mail->Username = "LandenBarker1@gmail.com";
$mail->Password = "xaxtdhaiiamjhfzd";
$mail->setFrom('LandenBarker1@gmail.com', 'Your Name');
$mail->addReplyTo('LandenBarker1@gmail.com', 'Your Name');

$mail->isHtml(true);

return $mail;