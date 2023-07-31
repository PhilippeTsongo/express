<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'Exception.php';
require 'PHPMailer.php';
require 'SMTP.php';

class Email
{
  private $mail;

  function __construct()
  {
    # Instantiation and passing `true` enables exceptions
    $this->mail = new PHPMailer(true);
    date_default_timezone_set('Etc/UTC');
    # Server settings
    # $this->mail->SMTPDebug = SMTP::DEBUG_SERVER;                      # Enable verbose debug output
    $this->mail->isSMTP();                                              # Send using SMTP
    $this->mail->Host       = 'riba.rw';                       # Set the SMTP server to send through
    $this->mail->SMTPAuth   = true;                                     # Enable SMTP authentication
    $this->mail->Username   = 'admin@riba.rw';               # SMTP username
    $this->mail->Password   = '!qis+vS5AFa6';                           # SMTP password
    $this->mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;           # Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` also accepted
    $this->mail->Port       = 587;                                      # TCP port to connect to
  }

  public function send_pro($_contacts = array(), $_subject, $_body){
     $_contacts     = (object)$_contacts;
     $fromemail_    = 'info@cnsplateforme.com';//$_contacts->fromEmail;
     $fromname_     = 'CNS Store Plateforme';//$_contacts->fromName;
     $replytoemail_ = 'info@cnsplateforme.com';//$fromemail_;
     $replytoname_  = 'CNS Store Plateforme';//$fromname_;
     $toemail_      = $_contacts->toEmail;
     $toname_       = $_contacts->toName;

     try {
         # Recipients
         $this->mail->setFrom($fromemail_, $fromname_);
         # Add a recipient
         $this->mail->addAddress($toemail_, $toname_);

         $this->mail->addReplyTo($replytoemail_, $replytoname_);
         # $this->mail->addCC('cc@example.com');
         # $this->mail->addBCC('bcc@example.com');

         # Attachments
         # $this->mail->addAttachment('/var/tmp/file.tar.gz');         # Add attachments
         # $this->mail->addAttachment('/tmp/image.jpg', 'new.jpg');    # Optional name

         # Content
         $this->mail->isHTML(true);                                  # Set email format to HTML
         $this->mail->Subject = $_subject;
         $this->mail->Body    = $_body;
        # $this->mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

         if($this->mail->send()) return true;

     } catch (Exception $e) {
         return false;
     }
   }



   
   public function send($_subject, $_body, $toemail_, $toname_ = '', $_addCC = true){
    // $_contacts     = (object)$_contacts;
     $fromemail_    = 'info@cnsplateforme.com';//$_contacts->fromEmail;
     $fromname_     = 'CNS Store Plateforme';//$_contacts->fromName;
     $replytoemail_ = 'info@cnsplateforme.com';//$fromemail_;
     $replytoname_  = 'CNS Store Plateforme';//$fromname_;
    // $toemail_      = $_contacts->toEmail;
    // $toname_       = $_contacts->toName;

    try {
        # Recipients
        $this->mail->setFrom($fromemail_, $fromname_);
        # Add a recipient
        $this->mail->addAddress($toemail_, $toname_);

        $this->mail->addReplyTo($replytoemail_, $replytoname_);
        
        // if($_addCC == true):
        //   $this->mail->addCC('mmhiribidi@liaisongroup.net');
        //   $this->mail->addCC('claudine@globalrisk.rw');
        //   $this->mail->addCC('b.uwase@olea.africa');
        //   $this->mail->addCC('maggy@liaisongroup.net');
        // endif;
  
        # $this->mail->addCC('cc@example.com');
        # $this->mail->addBCC('bcc@example.com');

        # Attachments
        # $this->mail->addAttachment('/var/tmp/file.tar.gz');         # Add attachments
        # $this->mail->addAttachment('/tmp/image.jpg', 'new.jpg');    # Optional name

        # Content
        $this->mail->isHTML(true);                                  # Set email format to HTML
        $this->mail->Subject = $_subject;
        $this->mail->Body    = $_body;
       # $this->mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

        if($this->mail->send()) return true;

    } catch (Exception $e) {
        var_dump($e);
        return false;
    }
  }
}

 ?>
