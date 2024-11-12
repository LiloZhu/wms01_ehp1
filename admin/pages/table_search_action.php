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

$arrResult = array();
$data=array();
$action_flag="";


if ($_SERVER["REQUEST_METHOD"] == "POST"){
    $data = $_POST['arguments'];
    $_crrentPage = isset($data['currentPage'])?$data['currentPage']:0;
    
    switch($_POST['action']) {
        case 'retrieve':
            $sql = "select * from tb_menu where id = '{$data['id']}' ";
            $arrResult = $ado->Retrieve($sql);
            break;
            
        case 'add':
            $sql ="";
            $sql .= "insert into tb_search values(null,'{$data['search_code']}','{$data['search_text']}','{$data['where_use']}','{$data['seq']}'); ";
            $action_flag = $ado->Create($sql);
            
            if ($action_flag > 0){
                $arrResult['success']= true;
                $arrResult['message']= $data['search_code'];
            }
            break;
        case 'edit':
            $sql ="";
            $sql .= "update tb_search set search_code = '{$data['search_code']}',search_text = '{$data['search_text']}', where_use = '{$data['where_use']}',seq = '{$data['seq']}' where id = '{$data['id']}'; ";
            $action_flag = $ado->Create($sql);
            if ($action_flag > 0){
                $arrResult['success']= true;
                $arrResult['message']= $data['id'];
            }
            break;
        case 'delete':
            $sql = "delete from tb_search where id = '{$data['key']}'; ";
            $action_flag = $ado->Delete($sql);

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