<?php
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
new classes\SYS\session_mysql();

$arrResult = array();
$data=array();
$action_flag="";
$uid = isset($_SESSION['uid'])?$_SESSION['uid']:'';


if ($_SERVER["REQUEST_METHOD"] == "POST"){
    $data = $_POST['arguments'];
    switch($_POST['action']) {
        case 'retrieve':
            $sql = "select * from tb_user where id = '{$data['id']}' ";
            $arrResult = $ado->Retrieve($sql);
            break;
            
        case 'add':
            $password = md5($data['password']);
            
            $sql ="";
            $sql .= "insert into tb_user (user_code,user_text,password,company_code,department_code,division_code,title_code,job_code,cost_center_code,email,telphone,mobile,active,delete_flag,create_at,create_by,change_at,change_by)";
            $sql .= "values('{$data['user_code']}','{$data['user_text']}','{$password}',
                    '{$data['company_code']}', '{$data['department_code']}','{$data['division_code']}', '{$data['title_code']}',
                    '{$data['job_code']}','{$data['cost_center_code']}','{$data['email']}','{$data['telphone']}','{$data['mobile']}',
                    ";

            $sql .= "{$data['active']},{$data['delete_flag']},sysdate(),'{$uid}',sysdate(),'{$uid}'); ";
            
            $action_flag = $ado->Create($sql);
            
            if ($action_flag != FALSE){
                $arrResult['success']= true;
                $arrResult['message']= $data['user_code'];
            }
            break;
        case 'edit':
            $new_password = "";
            if ($data['new_password'] !=""){
                
                $new_password = md5($data['new_password']);
                
            }
            
            $sql ="";
            $sql .= "update tb_user set user_code = '{$data['user_code']}',user_text = '{$data['user_text']}',";
                if (($new_password != '') && ($new_password != $data['password']))
                {
                    $sql .= "password = '{$new_password}',";
                }
                
            $sql .= "company_code = '{$data['company_code']}',department_code = '{$data['department_code']}',department_code = '{$data['department_code']}',
                     division_code = '{$data['division_code']}',title_code = '{$data['title_code']}',job_code = '{$data['job_code']}',cost_center_code = '{$data['cost_center_code']}',
                     email = '{$data['email']}',telphone = '{$data['telphone']}',mobile = '{$data['mobile']}',     
                     active = {$data['active']},
                     change_at = sysdate(), change_by = '{$uid}'
                     where id = '{$data['id']}'; ";
            
            $action_flag = $ado->Update($sql);
            if ($action_flag > 0){
                $arrResult['success']= true;
                $arrResult['message']= $data['user_code'];
            }
            break;
        case 'delete':
            $sql = "update tb_user set delete_flag = true,change_at = sysdate(), change_by = '{$uid}' where id = '{$data['key']}'; ";
            $action_flag = $ado->Update($sql);
            
            //$_crrentPage = parseInt($_crrentPage);
            
            if ($action_flag != false){
                $arrResult['success']= true;
                $arrResult['message']= 'delete';
            }
            break;
        case 'rfid':
            $sql = "call proc_generate_user_card('{$data['key']}');";
            $action_flag = $ado->Update($sql);
            
            //$_crrentPage = parseInt($_crrentPage);
            
            if ($action_flag != false){
                $arrResult['success']= true;
                $arrResult['message']= 'delete';
            }
            break;
        case 'print_rfid':
            $sql = "";
            
            $sql = "call proc_user_print_pool_add('{$data['key']}');";
            $action_flag = $ado->Update($sql);
            if ($action_flag > 0){
                $arrResult['success']= true;
                $arrResult['message']= $data['rfid'];
            }
            break;
            
        default:
            
    }
}

//<---

echo json_encode($arrResult);
//<---End
?>