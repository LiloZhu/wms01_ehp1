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
    $dt = date( "Y.m.d H:i:s" );  //PHP
    //$dt = "date_format(now(),'%Y.%m.%d %H:%i:%s')";  //MySQL
    
    switch($_POST['action']) {
        case 'check':
            $sql = "";
            $sql = "select * from tb_outbound_req
                    where create_by = '{$uid}' and delete_flag = false and status_code <> 'COMP';";
            
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
        case 'retrieve':
            $sql = "";
            $sql = "select *,0 as qty,0 as label_qty from v_more_outbound_req_mat_code_ext where rem_label_qty > 0; ";
            
            $res = $ado->Retrieve($sql);
            if (empty($res)){
                $res = [];
            }
            
            $arrResult['rows'] = $res;
            $arrResult['total'] = count($arrResult['rows']);
            $arrResult['totalNotFiltered'] = 100;
            break;
        case 'my_cart':
            $sql = "";
            $sql = "select * from tb_cart where delete_flag = false and create_by = '{$uid}' and status_code = 'NEW' ";
            
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
            $sql .= "insert into tb_cart
            (company_code,mat_code,cust_mat_code,label_qty,qty,base_unit,min_packing_qty,packing_unit,
            ref_delivery_order,ref_delivery_item,ref_order_number,ref_item_no,export_number,status_code,delete_flag,
            create_at,create_by,change_at,change_by)
            values(
            '{$data['company_code']}','{$data['mat_code']}','{$data['cust_mat_code']}','{$data['label_qty']}','{$data['qty']}','{$data['base_unit']}','{$data['min_packing_qty']}','{$data['packing_unit']}',
             '{$data['ref_delivery_order']}','{$data['ref_delivery_item']}','{$data['ref_order_number']}','{$data['ref_item_no']}','{$data['export_number']}','{$data['status_code']}',false,
             sysdate(),'{$uid}',sysdate(),'{$uid}');";
            
            $sql = "call proc_cart_add('{$data['company_code']}','{$data['mat_code']}','{$data['cust_mat_code']}','{$data['label_qty']}','{$data['qty']}','{$data['base_unit']}','{$data['min_packing_qty']}','{$data['packing_unit']}',
                                       '{$data['ref_delivery_order']}','{$data['ref_delivery_item']}','{$data['ref_order_number']}','{$data['ref_item_no']}','{$data['export_number']}','{$data['status_code']}',
                                        '{$uid}'
                    );";
            
            $action_flag = $ado->Create($sql);
            
            if ($action_flag > 0){
                $arrResult['success']= true;
                $arrResult['message']= $data['mat_code'];
            }
            break;
        case 'edit':
            $sql = "";
            $sql = "update tb_outbound_req set label_qty = '{$data['label_qty']}',qty = '{$data['qty']}',
            change_at = sysdate() ,change_by = '{$uid}'
            where id = '{$data['id']}'; ";
            $action_flag = $ado->Update($sql);
            if ($action_flag > 0){
                $arrResult['success']= true;
                $arrResult['message']= $data['order_number'];
            }
            break;
        case 'delete':
            $sql = "update tb_outbound_req set delete_flag = true,change_at = sysdate(), change_by = '{$uid}' where id = '{$data['key']}'; ";
            $action_flag = $ado->Delete($sql);
            if ($action_flag > 0){
                $arrResult['success']= true;
                $arrResult['message']= $data['key'];
            }
            break;
        case 'approve':
            $sql = "";
            $sql = "update tb_outbound_req set req_number = '{$data['req_number']}', item_no ='{$data['item_no']}', status_code = 'REL',change_at = sysdate(), change_by = '{$uid}' where id = '{$data['key']}'; ";
            
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