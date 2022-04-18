<?php
//this commented section should be a cron job to send email based on user approval date
if($isapproved == 'true')
{
  echo "email sending logic here!";
  //die();

  //require_once '../lib/PHPMailer/src/PHPMailer.php';
  //require_once '../lib/PHPMailer/src/Exception.php';
  //require_once '../lib/PHPMailer/src/SMTP.php';

  //send email to approved users
  $to = $contactemail;
  $toFullname = $firstname.' '.$lastname;
  $from = 'dbms-no-reply@dap.edu.ph'; 
  $fromName = 'DAP DBMS Admin'; 
  
  $subject = "You are now APPROVED to use DAP DBMS"; 
  
  $htmlContent = ' 
      <html> 
      <head> 
          <title>You Are Now Approved to Use the DAP DBMS</title> 
      </head> 
      <body> 
          <h1>Congratulations!</h1> 
          <p> 
          Your account has been validated by our team, you may now access your account and encode your agency’s certification details.
          </p> 
      </body> 
      </html>'; 
  
  //
  require_once '../lib/PHPMailer/src/PHPMailer.php';
  require_once '../lib/PHPMailer/src/Exception.php';
  require_once '../lib/PHPMailer/src/SMTP.php';

  use PHPMailer\PHPMailer\PHPMailer;
  use PHPMailer\PHPMailer\Exception;
  use PHPMailer\PHPMailer\SMTP;

  $mail = new PHPMailer(true);

  try {
      //Server settings
      $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
      $mail->isSMTP();                                            //Send using SMTP
      $mail->Host       = 'smtp.gmail.com';
      $mail->SMTPSecure = 'static::ENCRYPTION_STARTTLS';          //Set the SMTP server to send through
      $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
      $mail->Username   = '';                                     //SMTP username
      $mail->Password   = '';                                     //SMTP password
      //$mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;          //Enable implicit TLS encryption
      $mail->Port       = 587;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

      //Recipients
      $mail->setFrom($from, $fromName);
      $mail->addAddress($to, $toFullname);     //Add a recipient
      $mail->addReplyTo($from, $fromName);

      //Content
      $mail->isHTML(true);                                  //Set email format to HTML
      $mail->Subject = $subject;
      $mail->Body    = $htmlContent;
      $mail->AltBody = 'Congratulations! Your account has been validated by our team, you may now access your account and encode your agency certification details.';

      $mail->send();
      //echo 'Message has been sent';
  } catch (Exception $e) {
      echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
  }
}
