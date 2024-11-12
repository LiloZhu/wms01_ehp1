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
        case 'more_ref_order_number':
            $sql = "";
            $sql = "call proc_get_iqc_more_purchase_order('{$uid}');";
            
            $res = $ado->Retrieve($sql);
            if (empty($res)){
                $res = [];
            }
            
            $arrResult['rows'] = $res;
            $arrResult['total'] = count($arrResult['rows']);
            $arrResult['totalNotFiltered'] = 100;
            break;
        case 'more_cust_mat_code':
            $sql = "";
            $sql = "select * from v_cust_mat_text_ext where company_code = '{$company_code}' ;";
            
            $res = $ado->Retrieve($sql);
            if (empty($res)){
                $res = [];
            }
            
            $arrResult['rows'] = $res;
            $arrResult['total'] = count($arrResult['rows']);
            $arrResult['totalNotFiltered'] = 100;
            break;
        case 'more_order_mat_code':
            $sql = "";
            $sql = "select * from v_more_order_mat_code where company_code = '{$company_code}' and rem_qty > 0 ;";
            
            $res = $ado->Retrieve($sql);
            if (empty($res)){
                $res = [];
            }
            
            $arrResult['rows'] = $res;
            $arrResult['total'] = count($arrResult['rows']);
            $arrResult['totalNotFiltered'] = 100;
            break;
        case 'more_outbound_req_mat_code':
                $sql = "";
                $sql = "select * from v_more_outbound_req_mat_code_ext where rem_label_qty > 0; ";
                
                $res = $ado->Retrieve($sql);
                if (empty($res)){
                    $res = [];
                }
                
                $arrResult['rows'] = $res;
                $arrResult['total'] = count($arrResult['rows']);
                $arrResult['totalNotFiltered'] = 100;
                break;
        case 'passed':
            $sql = "";
            $sql = "call proc_iqc_release('{$data['iqc_number']}', '{$uid}');";
            
            $action_flag = $ado->Update($sql);
            
            if ($action_flag > 0){
                $arrResult['success']= true;
                $arrResult['message']= $data['iqc_number'];
            }
            break;
        case 'reject':
            $sql = "";
            $sql = "update tb_material_iqc set status_code ='REJECTED',change_at = sysdate(), change_by = '{$uid}' where iqc_number = '{$data['iqc_number']}';";
            
            $action_flag = $ado->Update($sql);
            
            if ($action_flag > 0){
                $arrResult['success']= true;
                $arrResult['message']= $data['iqc_number'];
            }
            break;
        case 'company_get':
            $sql = "";
            $sql = "SELECT * FROM tb_company where delete_flag = false and active = true ";
            
            
            $res = $ado->Retrieve($sql);
            if (empty($res)){
                $res = [];
            }
            
            $arrResult['rows'] = $res;
            $arrResult['total'] = count($arrResult['rows']);
            $arrResult['totalNotFiltered'] = 100;

            
            break;            
        default:
            
    }
}

//<---

echo json_encode($arrResult);
//<---End
?>