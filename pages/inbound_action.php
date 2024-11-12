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

$arrResult = array();
$data=array();
$action_flag="";
$uid = isset($_SESSION['uid'])?$_SESSION['uid']:'';
$company_code = isset($_SESSION['company_code'])?$_SESSION['company_code']:'';


if ($_SERVER["REQUEST_METHOD"] == "GET") {
    
    
} elseif ($_SERVER["REQUEST_METHOD"] == "POST"){
    $data = $_POST['arguments'];
    $dt = date( "Y.m.d H:i:s" );  //PHP
    //$dt = "date_format(now(),'%Y.%m.%d %H:%i:%s')";  //MySQL
    
    switch($_POST['action']) {
        case 'retrieve':
            $sql = "";
            //$sql = "select * from v_delivery_order_text_ext where status_code = 'CHK' and qc_indicator = true  order by id;";
            $sql = "select *, (case status_code when 'CONFIRM' then '待入库' else '已入库' end) as inbound_status_text  from v_delivery_order_text_ext where status_code = 'CONFIRM' or status_code = 'REL' order by id desc;";
            
            $res = $ado->Retrieve($sql);
            if (empty($res)){
                $res = [];
            }
            
            $arrResult['rows'] = $res;
            $arrResult['total'] = count($arrResult['rows']);
            $arrResult['totalNotFiltered'] = 100;
            break;
        case 'add':
            $sql = "";
            
            $action_flag = $ado->Create($sql);
            
            if ($action_flag > 0){
                $arrResult['success']= true;
                $arrResult['message']= $data['order_number'];
            }
            break;
        case 'edit':
            $sql = "";
            $action_flag = $ado->Delete($sql);
            if ($action_flag > 0){
                $arrResult['success']= true;
                $arrResult['message']= $data['order_number'];
            }
            break;
        case 'delete':
            $sql = "";
            $action_flag = $ado->Update($sql);
            if ($action_flag > 0){
                $arrResult['success']= true;
                $arrResult['message']= $data['order_number'];
            }
            break;
        case 'approve':
        case 'reject':
            $sql = "";
            //$sql = "call proc_delivery_order_release('{$data['order_number']}','{$data['status_code']}','{$uid}');";
            $sql = "update tb_delivery_order set status_code = '{$data['status_code']}',inbound_approver = '{$uid}',change_at = sysdate(), change_by = '{$uid}' where id = '{$data['key']}'; ";
            
            
            $action_flag = $ado->update($sql);
            
            if ($action_flag > 0){
                $arrResult['success']= true;
                $arrResult['message']= $data['$order_number'];
            }
            break;
        default:
            
    }
}

//<---

echo json_encode($arrResult);
//<---End
?>