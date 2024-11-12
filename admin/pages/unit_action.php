<?php
//设置页面内容是html编码格式是utf-8
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


if ($_SERVER["REQUEST_METHOD"] == "GET") {
    
    
} elseif ($_SERVER["REQUEST_METHOD"] == "POST"){
    $data = $_POST['arguments'];
    $_crrentPage = isset($data['currentPage'])?$data['currentPage']:0;
    
    switch($_POST['action']) {
        case 'add':
            $sql = "insert into tb_unit values('{$data['code']}','{$data['name']}','{$data['descripton']}'); ";
            $action_flag = $ado->Create($sql);
//             $sql = "select count(*) from tb_unit ";
//             $_count = $ado->Count($sql);   
//             $_pageNum = ceil($_count/$data['listRows']);
            
            if ($action_flag > 0){
                $arrResult['success']= true;
                $arrResult['message']= $data['code'];
                
/*                 if ($_crrentPage < $_pageNum){
                    $arrResult['page'] = $_pageNum;
                }else{
                    $arrResult['page'] = $_crrentPage;
                } */
            }
            break;
        case 'edit':
            $sql = "update tb_unit set name = '{$data['name']}', description = '{$data['descripton']}' where code = '{$data['code']}'; ";
            $action_flag = $ado->Create($sql);
            if ($action_flag > 0){
                $arrResult['success']= true;
                $arrResult['message']= $data['code'];
            }
            break;
         case 'delete':
             $sql = "delete from tb_unit where code = '{$data['code']}'; ";
             $action_flag = $ado->Delete($sql);
             $sql = "select count(*) from tb_unit ";
             $_count = $ado->Count($sql);
             
             $_pageNum = ceil($_count/$data['listRows']);
             //$_crrentPage = parseInt($_crrentPage);
             
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
        default:
            
    }
}

//<---

echo json_encode($arrResult);
//<---End
?>