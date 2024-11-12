<?php
//set html charset utf-8
header('Access-Control-Allow-Origin:*');
header('Access-Control-Allow-Methods:POST,GET');
header('Access-Control-Allow-Credentials:true');
header("Content-Type: application/json;charset=utf-8");
//header("Content-Type: text/plain;charset=utf-8"); 
//header("Content-Type: text/xml;charset=utf-8"); 
//header("Content-Type: text/html;charset=utf-8"); 
//header("Content-Type: application/javascript;charset=utf-8");

require("../classes/DB/pdo_helper.class.php");
require("../components/mail/PHPMailer/mail.class.php");


function autoload ($class_name){
    $class_file = '../'.str_replace('\\','/',$class_name). '.class.php';
    if (file_exists($class_file))
    {
        require_once($class_file);
        
        if(class_exists($class_name,false))
        {
            return true;
        }
        return false;
    }
    return false;
    
}

if(function_exists('spl_autoload_register')) {
    spl_autoload_register('autoload');
}

$ado = new classes\DB\mysql_helper();
new classes\SYS\session_mysql();
$mail = new mail();

$arrResult = array();
$data=array();
$action_flag="";

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    
    
} elseif ($_SERVER["REQUEST_METHOD"] == "POST"){
    $data = $_POST['arguments'];
    $dt = date( "Y-m-d H:i:s",strtotime("+1 day") );  //PHP
    //$dt = "date_format(now(),'%Y.%m.%d %H:%i:%s')";  //MySQL
    $encode = md5(date("Y-m-d H:i:s").rand(100,999));
    $link = "http://dev.idx01.com:90/wms/pages/reset_password.php?reset_code=";
    //->
    
    switch($_POST['action']) {
        case 'request':
            $sql ="select email from tb_user where email = '{$data['email']}' and delete_flag = false;";
            
            $res = $ado->Retrieve($sql);
            if (!empty($res)){  
            
            $sql ="insert into tb_forget_password(email,reset_code,expired_date,active_flag,create_at)
                   values('{$data['email']}','{$encode}','{$dt}',true,sysdate())";
            
            $action_flag = $ado->Create($sql);
            if ($action_flag != FALSE){
                
                $link_url = $link.$encode."&email=".$data['email'];
                
                $subject = "重置密码申请";
                $body = "<B>Hi {$data['email']} <B>";
                $body .= "<br><br>";
                $body .= "请点击如下链接找回密码: <a href=".$link_url.">".$link_url."</a>";
                $body .= "<br><br>";
                $body .= "过期时间：".$dt;
                
                
                $mail->setMailFrom('admin@ides01.com', 'admin');
                $mail->addMailTo("{$data['email']}",'');
                $mail->isHTML(true);
                $mail->setSubject($subject);
                $mail->setBody($body);
                $mail->sendMail();
                
                
                $arrResult['success']= true;
                $arrResult['message']= 'OK';
                
               }
            }else{
                $arrResult['success']= false;
                $arrResult['message']= 'error';
            }
            break;
        case 'send_mail':
            $sql = "select * from tb_forget_password where email = '{$data['email']}' order by id desc limit 1";
            
            $res = $ado->Retrieve($sql);
               
            if (!empty($res)){         
                $subject = "重置密码申请";
                $body = "<B>Hi {$res[0]['email']} <B>";
                $body .= "<br><br>";
                $body .= "请点击如下链接找回密码: <a href=".$link.$res[0][reset_code].">".$link.$res[0][reset_code]."</a>";
                $body .= "<br><br>";
                $body .= "过期时间：{$res[0][expired_date]}";
                
                
                $mail->setMailFrom('admin@ides01.com', 'admin');
                $mail->addMailTo("{$data['email']}",'WMS');
                $mail->isHTML(true);
                $mail->setSubject($subject);
                $mail->setBody($body);
                $mail->sendMail();
                
                $arrResult['success']= true;
                $arrResult['message']= 'send ok';
                
            }
            
            break;
            
        default:
            
    }
}

//<---

echo json_encode($arrResult);
//<---End
?>