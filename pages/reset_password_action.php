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
    $link = "http://localhost:90/mydc/login.php";
    //->
    
    switch($_POST['action']) {
        case 'request':
            $password = md5($data['password']);
            
            $sql = "update tb_user set password = '{$password}',change_at = sysdate() where email = '{$data['email']}' ";
            
            $action_flag = $ado->Update($sql);
            if ($action_flag != FALSE){
                $sql ="update tb_forget_password set active_flag = false where reset_code = '{$data['reset_code']}' ";
                $action_flag = $ado->Update($sql);
                
                $subject = "重置密码成功";
                $body = "<B>Hi {$data['email']} <B>";
                $body .= "<br><br>";
                $body .= "你的密码已更新,请用新密码登录系统: <a href=".$link.">".$link."</a>";
                $body .= "<br><br>";
                $body .= "新密码：".$data['password'];
                
                
                $mail->setMailFrom('admin@ides01.com', 'admin');
                $mail->addMailTo("{$data['email']}",'');
                $mail->isHTML(true);
                $mail->setSubject($subject);
                $mail->setBody($body);
                $mail->sendMail();
                
                
                $arrResult['success']= true;
                $arrResult['message']= 'OK';
            }
            break;
        case 'check_request':
            $sql = "select * from tb_forget_password 
                    where reset_code = '{$data['reset_code']}' 
                    and active_flag = true and expired_date > sysdate() order by id desc limit 1";
            
            $res = $ado->Retrieve($sql);
            
            if (!empty($res)){
                $arrResult['success']= true;
                $arrResult['message']= 'check ok!';  
            }else{
                $arrResult['success']= false;
                $arrResult['message']= 'check no data!';  
            }
            
            break;
            
        default:
            
    }
}

//<---

echo json_encode($arrResult);
//<---End
?>