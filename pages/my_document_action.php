<?php
//set html charset utf-8
header('Access-Control-Allow-Origin:*');
header('Access-Control-Allow-Methods:POST,GET');
header('Access-Control-Allow-Credentials:true');
header("Content-Type: application/json;charset=utf-8");
//header("Content-Type: text/plain;charset=utf-8"); 
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
$role = isset($_SESSION['role_code'])?$_SESSION['role_code']:'';

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    
} elseif ($_SERVER["REQUEST_METHOD"] == "POST"){
    //$data = $_POST['arguments'];

    $data = isset($_POST['arguments'])? $_POST['arguments']: '';
    $document_code = isset($_POST['document_code']) ? $_POST['document_code']:  '';
    $document_text = isset($_POST['document_text']) ? $_POST['document_text']:  '';
    $description= isset($_POST['description']) ? $_POST['description']:  '';

switch($_POST['action']) {
    
    case 'retrieve':
        $sql = "";
        $sql .= "select * from v_document_text";

        
        $res = $ado->Retrieve($sql);
        if (empty($res)){
            $res = [];
        }
        
        $arrResult['rows'] = $res;
        $arrResult['total'] = count($arrResult['rows']);
        $arrResult['totalNotFiltered'] = 100;
        break;
    case 'add':
            if ( 0 < $_FILES['file']['error'] ) {
                $arrResult['error'] = $_FILES['file']['error'];
            }
            else {
                if(!file_exists("../dms/")){
                    mkdir("../dms/");
                }
                
                if (file_exists("../dms/" . $_FILES["file"]["name"]))
                {
                    $arrResult['message_01'] = '文件已存在';
                }
                else
                {
                    $file_name = $_FILES['file']['name'];
                    $file_size = $_FILES['file']['size'];
                    $file_tmp = $_FILES['file']['tmp_name'];
                    $file_type = $_FILES['file']['type'];
                    
                    
                    $parser = fopen($file_tmp, 'r');
                    $content = fread($parser, filesize($file_tmp));
                    $content = addslashes($content);
                    fclose($parser);
                    
                    move_uploaded_file($_FILES["file"]["tmp_name"], "../dms/" . $_FILES["file"]["name"]);
                    //echo "文件存储在: " . "upload/" . $_FILES["file"]["name"];
                    
                    $path ="../dms/" . $_FILES["file"]["name"];
                    $sql ="";
                    $sql .= "insert into tb_document (document_code,
                                             document_text,
                                             description,
                                             path,
                                             file_name,
                                             file_type,
                                             file_size,   
                                             delete_flag,
                     create_at,create_by,change_at,change_by)
                     values('{$document_code}',
                            '{$document_text}',
                            '{$description}',
                            '{$path}',
                            '{$file_name}',
                            '{$file_type}',
                            '{$file_size}',
                             false,
                     sysdate(),'{$uid}',sysdate(),'{$uid}');";
                    
                    $action_flag = $ado->Create($sql);
                    $arrResult['message']= $sql;
                    if ($action_flag != FALSE){
                        $arrResult['success']= true;
                        $arrResult['message']= $sql;
                    }
                }
            }
    
            break;
    case 'delete':
        $file_delete = $data['path'];
        $sql = "delete from tb_document  where id = '{$data['key']}'; ";
        $action_flag = $ado->Delete($sql);
        
        //$_crrentPage = parseInt($_crrentPage);
        
        if ($action_flag != false){
            
            unlink($file_delete);
            $arrResult['success']= true;
            $arrResult['message']= 'delete';
        }
        break;
    default:
        
}
}

 echo json_encode($arrResult);