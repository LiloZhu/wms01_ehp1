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
            $sql = "select * from v_mat_text where company_code = '{$company_code}';";
            
            $arrResult['rows'] = $ado->Retrieve($sql);
            $arrResult['total'] = is_array($arrResult['rows']) ? count($arrResult['rows']):0;
            $arrResult['totalNotFiltered'] = 100;
            break;
        case 'add':
            $sql = "";
            $sql .= "insert into tb_material
            (mat_code,mat_text,cust_mat_code,base_unit,min_packing_qty,packing_unit,company_code,
             cat_code,qc_flag,safety_stock,
             create_at,create_by,change_at,change_by)
            values('{$data['mat_code']}','{$data['mat_text']}','{$data['cust_mat_code']}',
                   '{$data['base_unit']}','{$data['min_packing_qty']}','{$data['packing_unit']}','{$company_code}',
                   '{$data['cat_code']}', {$data['qc_flag']}, '{$data['safety_stock']}',
                   sysdate(),'{$uid}',sysdate(),'{$uid}');";
            
            $action_flag = $ado->Create($sql);
            
            if ($action_flag > 0){
                $arrResult['success']= true;
                $arrResult['message']= $data['mat_text'];
            }
            break;
        case 'edit':
            $sql = "";
            $sql = "update tb_material set mat_code = '{$data['mat_code']}', mat_text = '{$data['mat_text']}',cust_mat_code = '{$data['cust_mat_code']}',
            base_unit = '{$data['base_unit']}',min_packing_qty = '{$data['min_packing_qty']}', packing_unit = '{$data['packing_unit']}',
            company_code = '{$company_code}',cat_code = '{$data['cat_code']}',qc_flag = {$data['qc_flag']}, safety_stock = '{$data['safety_stock']}',
            change_at = sysdate() ,change_by = '{$uid}'
            where id = '{$data['id']}'; ";
            $action_flag = $ado->Update($sql);
            if ($action_flag > 0){
                $arrResult['success']= true;
                $arrResult['message']= $data['mat_code'];
            }
            break;
        case 'delete':
            $sql = "update tb_material set delete_flag = true,change_at = sysdate(), change_by = '{$uid}' where id = '{$data['key']}'; ";
            $action_flag = $ado->Delete($sql);
            if ($action_flag > 0){
                $arrResult['success']= true;
                $arrResult['message']= $data['key'];
            }
            break;
        case 'approve':
            $sql = "";

        case 'check_exists':
            $sql = "";
            if ($data['action'] == 'new'){
                $sql = "select count(*) as count from tb_material 
                    where mat_code = '{$data['mat_code']}'
                      and cust_mat_code = '{$data['cust_mat_code']}'
                      and company_code = '{$company_code}' ";
            }else
            {
                $sql =   "select count(*) as count from tb_material
                    where mat_code = '{$data['mat_code']}'
                      and cust_mat_code = '{$data['cust_mat_code']}'
                      and company_code = '{$company_code}'
                      and id <> '{$data['key']}' ";
            }
            
            $arrResult['count'] = $ado->Count($sql);
            
            break;
        default:
            
    }
}

//<---

echo json_encode($arrResult);
//<---End
?>