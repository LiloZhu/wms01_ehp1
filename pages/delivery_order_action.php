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
            $sql = "select * from v_delivery_order_text_ext where company_code = '{$company_code}' order by id desc;";

            $res = $ado->Retrieve($sql);
            if (empty($res)){
                $res = [];
            }
            
            $arrResult['rows'] = $res;
            $arrResult['total'] = count($arrResult['rows']);
            $arrResult['totalNotFiltered'] = 100;
            break;
        case 'order_number':
            $sql = "";
            $sql = "select get_or_generate_delivery_order_number('{$data['order_number']}')";
            
            $arrResult['order_number'] = $ado->MaxValue($sql);
            break;
        case 'add':
            $sql = "";
            $sql .= "insert into tb_delivery_order
            (order_number,item_no,company_code,mat_code,cust_mat_code,location_code,export_number,label_qty,qty,base_unit,qc_flag,ref_order_number,ref_item_no,status_code,
            create_at,create_by,change_at,change_by)
            values('{$data['order_number']}',generate_delivery_order_item('{$data['order_number']}'),
            '{$company_code}','{$data['mat_code']}','{$data['cust_mat_code']}','{$data['location_code']}','{$data['export_number']}','{$data['label_qty']}',({$data['label_qty']} * {$data['min_packing_qty']}),
            '{$data['base_unit']}',{$data['qc_flag']},'{$data['ref_order_number']}','{$data['ref_item_no']}','{$data['status_code']}', 
             sysdate(),'{$uid}',sysdate(),'{$uid}');";
            
            $action_flag = $ado->Create($sql);
            
            if ($action_flag > 0){
                $arrResult['success']= true;
                $arrResult['message']= $data['mat_code'];
            }
            break;
        case 'update_qty':
            $sql = "";
            $sql = "update tb_delivery_order set status_code = '{$data['status_code']}',export_number = '{$data['export_number']}',label_qty = '{$data['label_qty']}',qty = ({$data['label_qty']} * {$data['min_packing_qty']}),
            change_at = sysdate() ,change_by = '{$uid}'
            where id = '{$data['id']}'; ";
            $action_flag = $ado->Update($sql);
            if ($action_flag > 0){
                $arrResult['success']= true;
                $arrResult['message']= $data['order_number'];
            }
            break;
        case 'edit':
            $sql = "";
            $sql = "update tb_delivery_order set mat_code = '{$data['mat_code']}',cust_mat_code = '{$data['cust_mat_code']}',label_qty = '{$data['label_qty']}',qty = ({$data['label_qty']} * {$data['min_packing_qty']}),
            location_code = '{$data['location_code']}',ref_order_number = '{$data['ref_order_number']}',ref_item_no = '{$data['ref_item_no']}',export_number = '{$data['export_number']}',
            base_unit = '{$data['base_unit']}',qc_flag = {$data['qc_flag']},status_code = '{$data['status_code']}',
            change_at = sysdate() ,change_by = '{$uid}'
            where id = '{$data['id']}'; ";
            $action_flag = $ado->Update($sql);
            if ($action_flag > 0){
                $arrResult['success']= true;
                $arrResult['message']= $data['order_number'];
            }
            break;
        case 'delete':
            $sql = "update tb_delivery_order set delete_flag = true,change_at = sysdate(), change_by = '{$uid}' where id = '{$data['key']}'; ";
            $action_flag = $ado->Delete($sql);
            
            if ($action_flag > 0){
                $arrResult['success']= true;
                $arrResult['message']= 'delete';
            }
            break;
        case 'approve':
            $sql = "";
            $sql = "update tb_delivery_order set status_code = '{$data['status_code']}',change_at = sysdate(), change_by = '{$uid}' where id = '{$data['key']}'; ";
            
            $action_flag = $ado->Create($sql);
            
            if ($action_flag > 0){
                $arrResult['success']= true;
                $arrResult['message']= $data['key'];
            }
            break;
        default:
            
    }
}

//<---

echo json_encode($arrResult);
//<---End
?>