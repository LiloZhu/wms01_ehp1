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
            $sql = "select * from tb_department where id = '{$data['id']}' ";
            $arrResult = $ado->Retrieve($sql);
            break;
            
        case 'add':
            $sql ="";
            $sql .= "insert into tb_division ";
            $sql .= "values(null,'{$data['division_code']}','{$data['division_text']}','{$data['department_code']}','{$data['company_code']}',";
            $sql .= "{$data['active']},";
            $sql .= "{$data['delete_flag']},";
            $sql .= "sysdate(),'{$uid}',sysdate(),'{$uid}'); ";
            
            $action_flag = $ado->Create($sql);
            
            if ($action_flag != FALSE){
                $arrResult['success']= true;
                $arrResult['message']= $data['division_code'];
            }
            break;
        case 'edit':
            $sql ="";
            $sql .= "update tb_division set division_code = '{$data['division_code']}',division_text = '{$data['division_text']}', department_code = '{$data['department_code']}',
                     company_code = '{$data['company_code']}',active = {$data['active']},delete_flag = {$data['delete_flag']},
                     change_at = sysdate(), change_by = '{$uid}'
                     where id = '{$data['id']}'; ";
            $action_flag = $ado->Update($sql);
            if ($action_flag > 0){
                $arrResult['success']= true;
                $arrResult['message']= $data['id'];
            }
            break;
        case 'delete':
            $sql = "update tb_division set delete_flag = true,change_at = sysdate(), change_by = '{$uid}' where id = '{$data['key']}'; ";
            $action_flag = $ado->Update($sql);
            
            //$_crrentPage = parseInt($_crrentPage);
            
            if ($action_flag != false){
                $arrResult['success']= true;
                $arrResult['message']= 'delete';
            }
            break;
            
        default:
            
    }
}

//<---

echo json_encode($arrResult);
//<---End
?>