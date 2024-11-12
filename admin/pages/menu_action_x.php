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
            $sql .= "insert into tb_menu values(null,'{$data['menu_name']}','{$data['pid']}','{$data['path']}',";
            $sql .= "'{$data['description']}','{$data['type_code']}','{$data['url']}','{$data['icon']}','{$data['admin_flag']}'); ";
            $action_flag = $ado->Create($sql);
            
            if ($action_flag > 0){
                $arrResult['success']= true;
                $arrResult['message']= $data['menu_name'];
            }
            break;
        case 'edit':
            $sql ="";
            $sql .= "update tb_menu set menu_name = '{$data['menu_name']}',pid = '{$data['pid']}', path = '{$data['path']}',description = '{$data['description']}',";
            $sql .= "type_code = '{$data['type_code']}',url = '{$data['url']}',icon = '{$data['icon']}',admin_flag = '{$data['admin_flag']}' where id = '{$data['id']}'; ";
            $action_flag = $ado->Create($sql);
            if ($action_flag > 0){
                $arrResult['success']= true;
                $arrResult['message']= $data['id'];
            }
            break;
        case 'delete':
            $sql = "delete from tb_menu where path like '%{$data['key']}%'; ";
            $action_flag = $ado->Delete($sql);
            
            $sql = "delete from tb_menu where id = '{$data['key']}'; ";
            $action_flag = $ado->Delete($sql);
            
            $sql = "select count(*) from tb_menu ";
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