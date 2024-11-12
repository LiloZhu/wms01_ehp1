<?php

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


$obj = new classes\libralies\menu_action();

switch ($_GET["action"]){
    case "add":
        //获取界面输入信息
        $str_menu_name = $_POST["name"];
        $str_pid = $_POST["pid"];
        $str_path = $_POST["path"];
        $str_description = $_POST["desc"];
        $type_code = $_POST["type_code"];
        $admin_flag = isset($_POST["admin_flag"])?"X":"";
        $url = $_POST["url"];
        $icon = $_POST["icon"];
        
        //print_r($_POST);
       
        $action_flag = $obj->create($str_menu_name, $str_pid, $str_path, $str_description,$type_code,$url,$icon,$admin_flag);
        if($action_flag > 0)
        {
         echo "添加成功";
         
         //echo "<meta http-equiv='Refresh' content='0;url=menu_disp.php'/>";
         //header("refresh:3;url=menu_disp.php");
         //header("location:menu_disp.php");
        }
        else{
            echo "添加失败";
        }
        echo "<br/><a href='menu_add.php'>继续添加</a>";
        header("refresh:3;url=menu_disp.php");
        echo '<br/>3s 后跳转...';
        
        break;
    case "edit":
        $id = $_GET["id"];
        $str_menu_name = $_POST["name"];
        $str_description = $_POST["desc"];
        $type_code = $_POST["type_code"];
        $admin_flag = isset($_POST["admin_flag"])?"X":"";
        $url = $_POST["url"];
        $icon = $_POST["icon"];
        
        $action_flag = $obj->update($id, $str_menu_name,$str_description,$type_code,$url,$icon,$admin_flag);
        if($action_flag > 0)
        {
            echo "更新成功";
        }
        else{
            echo "更新失败";
        }
        echo "<br/><a href='menu_edit.php?id={$id}'>继续添加</a>";
        header("refresh:3;url=menu_disp.php");
        echo '<br/>3s 后跳转...';
        
        break;
        
    case "del":
        $id = $_GET["id"];
        $action_flag = $obj->delete($id);
        if($action_flag > 0)
        {
            echo "{$action_flag}行删除成功";
        }
        else{
            echo "删除失败";
        }
        
        header("location:menu_disp.php");
        
        break;
}

?>

