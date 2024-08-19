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
    $class_file = str_replace('\\','/',$class_name). '.class.php';
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
        case 'material_alert':
            $sql = "";
            
            $sql = "SELECT company_code,company_text,mat_code,cust_mat_code,mat_text,base_unit_text,packing_unit_text,safety_stock,packing_unit_qty,ifnull(shelf_qty,0) as shelf_qty 
                    FROM wms_db.v_mat_qty
                    where safety_stock > ifnull(shelf_qty,0)
                    and company_code = '{$company_code}'";
            
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
            
        case 'left_menu':
            $sql = "";
            $sql ="select * from tb_menu_x where type_code = '{$data['type_code']}' and admin_flag = '' order by concat(path,id);";
            $sql ="call proc_get_user_type_menu('{$data['user_id']}', '{$data['type_code']}', '{$data['$admin_flag']}');";
            
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
            
            break;
        case 'retrieve':
            $sql = "";
            break;
            
        case 'edit':
            $sql = "";
            break;
        case 'delete':
            $sql = "";
            break;
            
        default:
            
    }
}

//<---

echo json_encode($arrResult);
//<---End
?>