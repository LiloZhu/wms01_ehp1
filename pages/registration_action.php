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
    $dt = date( "Y-m-d H:i:s",strtotime("+7 day") );  //PHP
    //$dt = "date_format(now(),'%Y.%m.%d %H:%i:%s')";  //MySQL
    $link = "http://localhost:90/mydc/login.php";
    //->
    
    switch($_POST['action']) {
        case 'request':
            
            $sql = "insert into tb_user_req
                                (user_code,user_text,company_code, company_text,department_code,department_text,
                                 division_code,division_text,title_code,
                                 mobile,telphone,email,expired_date,status_code,delete_flag,create_at)values
                                 ('{$data['user_code']}','{$data['user_text']}','{$data['company_code']}',
                                  '{$data['company_text']}','{$data['department_code']}','{$data['department_text']}',
                                  '{$data['division_code']}','{$data['division_text']}', 
                                  '{$data['title_code']}', '{$data['mobile']}',  
                                  '{$data['telphone']}','{$data['email']}','{$dt}','NEW',true,sysdate());";
                                                                        
            
            $action_flag = $ado->Create($sql);
            if ($action_flag != FALSE){                              
                $arrResult['success']= true;
                $arrResult['message']= 'OK';
            }
            break;
        case 'check_request':
            $sql = "select '用户代码：【{$data['user_code']}】' as check_isexist
                    from tb_user 
                    where lower(user_code) = lower('{$data['user_code']}')
                    union
                    select 'Email：【{$data['email']}】' as check_exist
                    from tb_user 
                    where lower(email) = lower('{$data['email']}')
                    union
                    select '手机：【{$data['mobile']}】' as check_exist
                    from tb_user 
                    where lower(mobile) = lower('{$data['mobile']}')
                    ";
            
            $res = $ado->Retrieve($sql);
            $arrResult['rows'] = $res;
            
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