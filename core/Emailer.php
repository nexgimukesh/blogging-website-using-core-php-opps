<?php
require_once __DIR__.'/../vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;

class Emailer
{
    public function sendEmail($subject, $body)
    {
        // create a new object
        $mail = new PHPMailer();
        // configure an SMTP
        $mail->isSMTP();
        $mail->Host = 'sandbox.smtp.mailtrap.io';
        $mail->SMTPAuth = true;
        $mail->Username = 'f54217ec876a0c';
        $mail->Password =  '09cce785526720';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 2525;

        $mail->setFrom('confirmation@hotel.com', 'Your Admin');
        $mail->addAddress('me@gmail.com', 'Me');
        $mail->Subject = $subject;

        // Set HTML 
        $mail->isHTML(TRUE);
        $mail->Body = $body;

        // send the message
        return $mail->send();


        // if (!$mail->send()) {
        //     echo 'Message could not be sent.';
        //     echo 'Mailer Error: ' . $mail->ErrorInfo;
        // } else {
        //     echo 'Message has been sent';
        // }
    }
}
?>


<?php
// Start with PHPMailer class
//use PHPMailer\PHPMailer\PHPMailer;
//require_once './vendor/autoload.php';
// // create a new object
// $mail = new PHPMailer();
// // configure an SMTP
// $mail->isSMTP();
// $mail->Host = 'live.smtp.mailtrap.io';
// $mail->SMTPAuth = true;
// $mail->Username = 'api';
// $mail->Password = '1a2b3c4d5e6f7g';
// $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
// $mail->Port = 587;

// $mail->setFrom('confirmation@hotel.com', 'Your Hotel');
// $mail->addAddress('me@gmail.com', 'Me');
// $mail->Subject = 'Thanks for choosing Our Hotel!';
// // Set HTML 
// $mail->isHTML(TRUE);
// $mail->Body = '<html>Hi there, we are happy to <br>confirm your booking.</br> Please check the document in the attachment.</html>';
// $mail->AltBody = 'Hi there, we are happy to confirm your booking. Please check the document in the attachment.';
// // add attachment 
// // just add the '/path/to/file.pdf'
// $attachmentPath = './confirmations/yourbooking.pdf';
// if (file_exists($attachmentPath)) {
//     $mail->addAttachment($attachmentPath, 'yourbooking.pdf');
// }

// // send the message
// if(!$mail->send()){
//     echo 'Message could not be sent.';
//     echo 'Mailer Error: ' . $mail->ErrorInfo;
// } else {
//     echo 'Message has been sent';
// }
?>