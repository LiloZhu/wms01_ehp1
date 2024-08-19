<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
/* 使用时注意所有局域网内是否有防火墙和端品关闭的问题  */

require( __DIR__ . "/Exception.php");
require( __DIR__ . "/PHPMailer.php");
require( __DIR__ . "/SMTP.php");

class mail{
    private $_mail;
    
    public function __construct(){
        $this->_mail =  new PHPMailer(true);
        $this->initialization();
    }
    
    
    private function initialization(){
        try{
        //Server settings - outlook.com -> OK
        /*
            $this->_mail->CharSet="UTF-8";
            $this->_mail->SMTPDebug = SMTP::DEBUG_OFF;                         // Enable verbose debug output
            $this->_mail->isSMTP();                                            // Send using SMTP
            $this->_mail->Host       = 'smtp-mail.outlook.com';                // Set the SMTP server to send through
            $this->_mail->SMTPAuth   = true;                                   // Enable SMTP authentication
            $this->_mail->Username   = 'lilo.zhu@msn.com';                     // SMTP username
            $this->_mail->Password   = 'Osram9809$';                           // SMTP password
            $this->_mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
            $this->_mail->Port       = 587;    
        */
         
            //-> Server settings - aliyun enterpies mail -> OK
            $this->_mail->CharSet="UTF-8";
            $this->_mail->SMTPDebug = SMTP::DEBUG_OFF;                         // Enable verbose debug output
            $this->_mail->isSMTP();                                            // Send using SMTP
            $this->_mail->Host       = 'smtp.mxhichina.com';                // Set the SMTP server to send through
            $this->_mail->SMTPAuth   = true;                                   // Enable SMTP authentication
            $this->_mail->Username   = 'admin@ides01.com';                     // SMTP username
            $this->_mail->Password   = 'Osram9809';                           // SMTP password
            $this->_mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
            $this->_mail->Port       = 25;    
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$this->_mail->ErrorInfo}";
        }
    }
    
    public function setMailFrom($_mail_form,$_mail_from_as){
        $this->_mail->setFrom($_mail_form, $_mail_from_as);
    }
    
    public function addMailTo($_mail_to,$_mail_to_as){
        $this->_mail->addAddress($_mail_to, $_mail_to_as);
    }
    
    public function addReplyTo($_replay_to,$_replay_to_as){
        $this->_mail->addAddress($_replay_to, $_replay_to_as);
    }
    
    public function addCC($_cc){
        $this->_mail->addCC($_cc);
    }
    
    public function addBCC($_bcc){
        $this->_mail->addBCC($_bcc);
    }
    
    public function addAttachment($_attachment){
        $this->_mail->addAttachment($_attachment);
    }
    
    public function isHTML($_value){
        $this->_mail->isHTML($_value);   
    }
    
    public function setSubject($_subject){
        $this->_mail->Subject = $_subject;
    }
    
    public function setBody($_body){
        $this->_mail->Body = $_body;
    }
    
    public function setAltBody($_altbody){
        $this->_mail->AltBody = $_altbody;
    }
    
    public function sendMail(){
        try {
        $this->_mail->send();
        }
        catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    }
    
 
//<-End    

}