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
            $sql .= "select * from tb_cost_center where delete_flag = false and active = true ";
            $sql .= "order by id";
            $res = $ado->Retrieve($sql);
            if (empty($res)){
                $res = [];
            }
            
            $arrResult['rows'] = $res;
            $arrResult['total'] = count($arrResult['rows']);
            $arrResult['totalNotFiltered'] = 100;
            break;
        case 'add':
            
            $sql ="";
            $sql .= "insert into tb_cost_center (cost_center_code,
                                             cost_center_text,
                                             active,
                                             delete_flag,
                     create_at,create_by,change_at,change_by)
                     values('{$data['cost_center_code']}',
                            '{$data['cost_center_text']}',
                             true,false,
                     sysdate(),'{$uid}',sysdate(),'{$uid}');";
            
            $action_flag = $ado->Create($sql);
            $arrResult['message']= $sql;
            if ($action_flag != FALSE){
                $arrResult['success']= true;
                $arrResult['message']= $sql;
            }
            break;
        case 'edit':
            
            
            $sql ="";
            $sql .= "update tb_cost_center set cost_center_code = '{$data['cost_center_code']}',
                                           cost_center_text = '{$data['cost_center_text']}',
                                           change_at = sysdate() ,change_by = '{$uid}'
                     where id = '{$data['id']}'; ";
            
            $action_flag = $ado->Update($sql);
            if ($action_flag > 0){
                $arrResult['success']= true;
                $arrResult['message']= $data['role_code'];
            }
            break;
        case 'delete':
            //$sql = "update tb_user set delete_flag = true,change_at = sysdate(), change_by = '{$uid}' where id = '{$data['key']}'; ";
            $sql = "update tb_cost_center set delete_flag = true,change_at = sysdate(),change_by = '{$uid}' where id = '{$data['key']}'; ";
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