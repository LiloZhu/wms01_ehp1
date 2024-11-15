<?php
use classes\SYS\common;

//set html charset utf-8
//header("Content-Type: text/plain;charset=utf-8"); 
header('Access-Control-Allow-Origin:*');
header('Access-Control-Allow-Methods:POST,GET');
header('Access-Control-Allow-Credentials:true');
header("Content-Type: application/json;charset=utf-8");
//header("Content-Type: text/xml;charset=utf-8"); 
//header("Content-Type: text/html;charset=utf-8"); 
//header("Content-Type: application/javascript;charset=utf-8");


function autoload ($class_name){
    $class_file = str_replace('\\','/',$class_name). '.class.php';
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


/*
 define('DBHost', 'localhost');
 define('DBPort', 3306);
 define('DBName', 'wms_db');
 define('DBUser', 'admin');
 define('DBPassword', 'Osram9809');
 require( __DIR__ . "\classes\DB\PDO.class.php");
 $DB = new DB(DBHost, DBPort, DBName, DBUser, DBPassword);
 */

$arrResult = array();
$data=array();
$action_flag="";
$uid = isset($_SESSION['uid'])?$_SESSION['uid']:'';
$company_code = isset($_SESSION['company_code'])?$_SESSION['company_code']:'';
$company_code = isset($_SESSION['language_code'])?$_SESSION['language_code']:'';

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    
    
} elseif ($_SERVER["REQUEST_METHOD"] == "POST"){
    $input = json_decode(file_get_contents('php://input'), true);
    
    $data = $input['arguments']?$input['arguments']:[];
    $action = $input['action']?$input['action']:'';
    $_crrentPage = isset($data['currentPage'])?$data['currentPage']:0;
    $dt = date( "Y.m.d H:i:s" );  //PHP
    //$dt = "date_format(now(),'%Y.%m.%d %H:%i:%s')";  //MySQL
    
    switch($action) {
        case 'login':
            $sql = "";
            $user_pwd = md5($data['user_password']);
            
            $sql = "select * from v_user_text
                    where ( user_code = '{$data['user_code']}' or email= '{$data['user_code']}' )
                    and password = '{$user_pwd}';";
            
            $data=$ado->Retrieve($sql);
            
            $arrResult['rows'] = $data;
            $arrResult['isExist'] = false;
            if ($data != false){
                if (count($arrResult['rows']) > 0) {
                    $arrResult['isExist'] = true;
                    $_SESSION['uid'] = $data[0]['id'];
                    $_SESSION['user_code'] = $data[0]['user_code'];
                    $_SESSION['user_text'] =$data[0]['user_text'];
                    $_SESSION['company_code'] = $data[0]['company_code'];
                    $_SESSION['email'] = $data[0]['email'];
                    $_SESSION['role_code'] =$data[0]['role_code'];
                    $_SESSION['role_text'] = $data[0]['role_text'];
                }else{
                    $arrResult['isExist'] = false;
                }
            }
            break;
            
        case 'info':
            $sql = "";
            if($data['language_code'] == ""){
                $data['language_code'] = 'ZH';
            }
            $sql = "select * from tb_system_info where status_code = 'A' and system_code = 'wms01' and language_code = 'EN' order by version desc";
            $data=$ado->Retrieve($sql);
            
            $arrResult['rows'] = $data;
            $arrResult['isExist'] = false;
            if ($data != false){
                if (count($arrResult['rows']) > 0) {
                    $arrResult['isExist'] = true;
                    
                }else{
                    $arrResult['isExist'] = false;
                }
            }
            break;
            
        case 'language':
            $sql = "";
            if($data['language_code'] == ""){
                $data['language_code'] = 'ZH';
            }
            $sql = "select * from tb_language where status_code = 'A' order by seq ";
            $data=$ado->Retrieve($sql);
            
            $arrResult['rows'] = $data;
            $arrResult['isExist'] = false;
            if ($data != false){
                if (count($arrResult['rows']) > 0) {
                    $arrResult['isExist'] = true;
                    
                }else{
                    $arrResult['isExist'] = false;
                }
            }
            break;
            
        case 'edit':
            $sql = "";
            break;
        case 'delete':
            $sql = "";
            break;
        case 'log':
            $ip = common::getIP();
            $location = common::locationByIP($ip);
            $sql = "insert into tb_login_log(user_code,ip,location,where_use,status_code,create_at)values('{$data['user_code']}','{$ip}','{$location}','{$data['where_use']}','{$data['status_code']}',sysdate());";
            $action_flag = $ado->Create($sql);
            
            if ($action_flag > 0){
                $arrResult['success']= true;
                $arrResult['message']= $data['user_code'];
            }
            break;
        case 'test':
            $arrResult['success'] = 'OK';
            break;
            
        default:
            
    }
}

//<---

echo json_encode($arrResult);
//<---End
?>