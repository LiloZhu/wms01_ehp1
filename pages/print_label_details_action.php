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
    $_crrentPage = isset($data['currentPage'])?$data['currentPage']:0;
    $dt = date( "Y.m.d H:i:s" );  //PHP
    //$dt = "date_format(now(),'%Y.%m.%d %H:%i:%s')";  //MySQL
    
    switch($_POST['action']) {
        case 'retrieve':
            $sql = "";
            $sql = "SELECT * FROM v_delivery_order_label_details_text where ref_order_number = '{$data['order_number']}' and ref_item_no = '{$data['item_no']}' ";
            
            $arrResult['rows'] = $ado->Retrieve($sql);
            $arrResult['total'] = count($arrResult['rows']);
            $arrResult['totalNotFiltered'] = 100;
            break;
        case 'print_label':
            $sql = "";
            $sql = "insert into tb_print_pool(company_code,rfid,printer_name,location_code,status_code,create_at,create_by,change_at,change_by)
                    value('{$data['company_code']}','{$data['rfid']}','{$data['printer_name']}','{$data['location_code']}','{$data['status_code']}',sysdate(),'{$uid}',sysdate(),'{$uid}');";
            
            $sql = "call proc_print_pool_add('{$data['company_code']}','{$data['rfid']}','{$data['printer_name']}','{$data['location_code']}','{$data['transaction_code']}','{$data['status_code']}','{$uid}');";
            $action_flag = $ado->Update($sql);
            if ($action_flag > 0){
                $arrResult['success']= true;
                $arrResult['message']= $data['rfid'];
            }
            break;
        case 'delete':

        case 'more_cust_mat_code':
            $sql = "";
            $sql = "call proc_common_get_more_material('{$uid}');";
            
            $arrResult['rows'] = $ado->Retrieve($sql);
            $arrResult['total'] = count($arrResult['rows']);
            $arrResult['totalNotFiltered'] = 100;
            break;
        case 'passed':
            $sql = "";
            
            $action_flag = $ado->Update($sql);
            
            if ($action_flag > 0){
                $arrResult['success']= true;
                $arrResult['message']= $data['iqc_number'];
            }
            break;
        case 'reject':
            $sql = "";
            
            $action_flag = $ado->Update($sql);
            
            if ($action_flag > 0){
                $arrResult['success']= true;
                $arrResult['message']= $data['iqc_number'];
            }
            break;
        default:
            
    }
}

//<---

echo json_encode($arrResult);
//<---End
?>