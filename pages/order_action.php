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


if ($_SERVER["REQUEST_METHOD"] == "GET") {
    
    
} elseif ($_SERVER["REQUEST_METHOD"] == "POST"){
    $data = $_POST['arguments'];
    $_crrentPage = isset($data['currentPage'])?$data['currentPage']:0;
    $dt = date( "Y.m.d H:i:s" );  //PHP
    //$dt = "date_format(now(),'%Y.%m.%d %H:%i:%s')";  //MySQL
    
    switch($_POST['action']) {
        case 'retrieve':
            $sql = "";
            $sql = "select * from v_order_text where company_code = '{$company_code}' order by id desc;";
            
            $res = $ado->Retrieve($sql);
            if (empty($res)){
                $res = [];
            }
            
            $arrResult['rows'] = $res;
            $arrResult['total'] = count($arrResult['rows']);
            $arrResult['totalNotFiltered'] = 100;
            break;
        case 'max_value':
            $maxValue = 0;
            $sql = "";
            $sql = "select generate_order_item('{$data['order_number']}')";
            
            $maxValue = $ado->MaxValue($sql);
                $arrResult['success']= true;
                $arrResult['maxvalue']= $maxValue;
            break;
        case 'add':

            $sql = "";
            $sql .= "insert into tb_order
            (order_number,item_no,company_code,cust_mat_code,qty,base_unit,status_code,
            create_at,create_by,change_at,change_by)
            values('{$data['order_number']}',generate_order_item('{$data['order_number']}'),
            '{$company_code}','{$data['cust_mat_code']}','{$data['qty']}','{$data['base_unit']}','{$data['status_code']}',
             sysdate(),'{$uid}',sysdate(),'{$uid}');";
            
            $action_flag = $ado->Create($sql);
            
               if ($action_flag > 0){
                   $arrResult['success']= true;
                   $arrResult['message']= $data['order_number'];
               }
               break;
        case 'edit':
            $sql = "";
            $sql = "update tb_order set cust_mat_code = '{$data['cust_mat_code']}',qty = '{$data['qty']}',
            base_unit = '{$data['base_unit']}',status_code = '{$data['status_code']}',
            change_at = sysdate() ,change_by = '{$uid}'
            where id = '{$data['id']}'; ";
            $action_flag = $ado->Update($sql);
            if ($action_flag > 0){
                $arrResult['success']= true;
                $arrResult['message']= $data['order_number'];
            }
            break;
        case 'update_qty':
            $sql = "";
            $sql = "update tb_order set status_code = '{$data['status_code']}',qty = '{$data['qty']}',
            change_at = sysdate() ,change_by = '{$uid}'
            where id = '{$data['id']}'; ";
            $action_flag = $ado->Update($sql);
            if ($action_flag > 0){
                $arrResult['success']= true;
                $arrResult['message']= $data['order_number'];
            }
            break;
        case 'delete':
            $sql = "update tb_order set delete_flag = true,change_at = sysdate(), change_by = '{$uid}' where id = '{$data['key']}'; ";
            $action_flag = $ado->Delete($sql);
            $sql = "select count(*) from tb_material ";
            $_count = $ado->Count($sql);
            
            $_pageNum = ceil($_count/$data['listRows']);
            
            if ($action_flag > 0){
                $arrResult['success']= true;
                $arrResult['message']= 'delete';
                
                if ($_crrentPage > $_pageNum){
                    $arrResult['page'] = $_pageNum;
                }else{
                    $arrResult['page'] = $_crrentPage;
                }
            }
            break;
        case 'approve':
            $sql = "";
            $sql = "update tb_order set status_code = 'REL',change_at = sysdate(), change_by = '{$uid}' where id = '{$data['key']}'; ";
            
            $action_flag = $ado->Create($sql);
            
            if ($action_flag > 0){
                $arrResult['success']= true;
                $arrResult['message']= $data['order_number'];
            }
            break;
        default:
            
    }
}

//<---

echo json_encode($arrResult);
//<---End
?>