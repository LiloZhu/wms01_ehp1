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

require("../../classes/DB/pdo_helper.class.php");
require("../../components/mail/PHPMailer/mail.class.php");

function autoload ($class_name){
    $class_file = '../../'.str_replace('\\','/',$class_name). '.class.php';
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
$ado_base = new classes\DB\mysql();
new classes\SYS\session_mysql();
$mail = new mail();

$arrResult = array();
$data=array();
$action_flag="";
$uid = isset($_SESSION['uid'])?$_SESSION['uid']:'';
$company_code = isset($_SESSION['company_code'])?$_SESSION['company_code']:'';
$role = isset($_SESSION['role_code'])?$_SESSION['role_code']:'';

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    
    
} elseif ($_SERVER["REQUEST_METHOD"] == "POST"){
    $data = $_POST['arguments'];
    $dt = date( "Y.m.d H:i:s" );  //PHP
    //$dt = "date_format(now(),'%Y.%m.%d %H:%i:%s')";  //MySQL
    
    switch($_POST['action']) {
        case 'retrieve':
            $sql = "";
            $sql .= "select *,status_code as status_text from tb_user_req where delete_flag = true and expired_date >= sysdate() ";
            $sql .= "order by id";
            $res = $ado->Retrieve($sql);
            if (empty($res)){
                $res = [];
            }
            
            $arrResult['rows'] = $res;
            $arrResult['total'] = count($arrResult['rows']);
            $arrResult['totalNotFiltered'] = 100;
            break;
        case 'release':
            $pwd = '';
            $sql .= "call proc_user_req_release('{$data['key']}','{$uid}', @pwd); ";
            //for mysql procedure output parameter
            $sql_ext .= "select user_code,user_text,email, @pwd as pwd from tb_user_req where id = '{$data['key']}'; ";
            $res = $ado->Retrieve($sql);
            
            $ado_base->connect_db();
            $result = $ado_base->db_getRows($sql);
            $result_ext = $ado_base->db_getRows($sql_ext);
            $ado_base->close_db();
            $res = $result_ext;
          
            $arrResult['data'] = $res;
            
            if (!empty($res)){
                $arrResult['success']= true;
                $arrResult['message']= 'release';
                
                $link = "http://dev.idx01.com:90/wms/login.php";
                $link_url = $link;
                
                $subject = "用户申请批准通过";
                $body = "<B>Hi {$res[0]['email']} <B>";
                $body .= "<br><br>你的用户申请已 <font color='green'>拒绝</font> !";
                $body .= "<br><br>";
                $body .= "<br><br>用户ID：{$res[0]['user_code']} ";
                $body .= "<br><br>用户名：{$res[0]['user_text']} ";
                $body .= "<br><br>密码：{$res[0]['pwd']} ";
                $body .= "<br><br>";
                $body .= "请点击如下链接登录系统: <a href=".$link_url.">".$link_url."</a>";
                $body .= "<br><br>";
                //$body .= "过期时间：".$dt;
                
                
                $mail->setMailFrom('admin@ides01.com', 'admin');
                $mail->addMailTo("{$res[0]['email']}",'requestor');
                $mail->isHTML(true);
                $mail->setSubject($subject);
                $mail->setBody($body);
                $mail->sendMail();
                
                
            }
            break;
        case 'reject':
            $sql .= "update tb_user_req set status_code = 'REJ',change_at = sysdate(),change_by = '{$uid}' where id = '{$data['key']}'; ";
            $action_flag = $ado->Update($sql);
            
            //$_crrentPage = parseInt($_crrentPage);
            
            if ($action_flag != false){
                $arrResult['success']= true;
                $arrResult['message']= 'reject';
                
                $sql = "select user_code,user_text,email from tb_user_req where id = '{$data['key']}';  ";
                $res = $ado->Retrieve($sql);
                
                $link = "http://dev.idx01.com:90/wms/login.php";
                $link_url = $link;
                
                $subject = "用户申请已拒绝";
                $body = "<B>Hi {$res[0]['email']} <B>";
                $body .= "<br><br>你的用户申请已 <font color='red'>拒绝</font> !";
                $body .= "<br><br>";
                $body .= "<br><br>用户ID：{$res[0]['user_code']} ";
                $body .= "<br><br>用户名：{$res[0]['user_text']} ";
                $body .= "<br><br>";
                $body .= "请点击如下链接登录系统: <a href=".$link_url.">".$link_url."</a>";
                $body .= "<br><br>";
                //$body .= "过期时间：".$dt;
                
                
                $mail->setMailFrom('admin@ides01.com', 'admin');
                $mail->addMailTo("{$res[0]['email']}",'requestor');
                $mail->isHTML(true);
                $mail->setSubject($subject);
                $mail->setBody($body);
                $mail->sendMail();
                
            }
            break;
            
        default:
            
    }
}

//<---

echo json_encode($arrResult);
//<---End
?>