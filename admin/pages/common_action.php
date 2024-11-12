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
            $sql = "";
            $arrResult = $ado->Retrieve($sql);
            break;
            
        case 'add':
            $sql ="";
            $action_flag = $ado->Create($sql);
            
            if ($action_flag != FALSE){
                $arrResult['success']= true;
                $arrResult['message']= $data['department_code'];
            }
            break;
        case 'edit':
            $sql ="";
            $action_flag = $ado->Update($sql);
            if ($action_flag > 0){
                $arrResult['success']= true;
                $arrResult['message']= $data['id'];
            }
            break;
        case 'delete':
            $sql = "";
            $action_flag = $ado->Update($sql);
            
            //$_crrentPage = parseInt($_crrentPage);
            
            if ($action_flag != false){
                $arrResult['success']= true;
                $arrResult['message']= 'delete';
            }
            break;
        case 'event_select':
            $sql = "";
            $sql = "select {$data['field_value']} as value, {$data['field_text']} as text from {$data['link_table']} where active = true and delete_flag = false {$data['clause_1']} {$data['clause_2']} {$data['clause_3']}";
            $arrResult['success']= true;
            //$arrResult['sql'] = $sql;
            $arrResult['result'] = $ado->Retrieve($sql);
            break;
        case 'dropdownlist_select':
            $sql = "";
            $sql = "select {$data['field_value']} as value, {$data['field_text']} as text from {$data['link_table']} where active = true and delete_flag = false {$data['clause_1']} {$data['clause_2']} {$data['clause_3']}";
            $arrResult['success']= true;
            //$arrResult['sql'] = $sql;
            $arrResult['result'] = $ado->Retrieve($sql);
            break;
        case 'checkbox_select':
            $sql = "";
            $sql = "{$data['sql']}";
            $arrResult['success']= true;
            //$arrResult['sql'] = $sql;
            $arrResult['result'] = $ado->Retrieve($sql);
            break;
        case 'special_select':
            $sql = "";
            $sql .= "select {$data['field_code']} as code, {$data['field_text']} as text from {$data['link_table']} where active = true and delete_flag = false {$data['clause_1']} {$data['clause_2']} {$data['clause_3']}";
            
            
            $res = $ado->Retrieve($sql);
            if (empty($res)){
                $res = [];
            }
            
            $arrResult['rows'] = $res;
            $arrResult['total'] = count($arrResult['rows']);
            $arrResult['totalNotFiltered'] = 100;
            break;
        case 'common_select':
            $sql = "";
            $sql .= "select type_code as code, type_text as text from tb_type where where_use = '{$data['where_use']}' order by seq";
            
            
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