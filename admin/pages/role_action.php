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


$obj = new classes\libralies\role_action();

switch ($_GET["action"]){
    case "add":
        //获取界面输入信息
        $role_name = $_POST["role_name"];
        $description = $_POST["description"];
        
        //print_r($_POST);
        
        $action_flag = $obj->create($role_name, $description);
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
        echo "<br/><a href='role_add.php'>继续添加</a>";
        header("refresh:3;url=role_disp.php");
        echo '<br/>3s 后跳转...';
        
        break;
    case "edit":
        $id = $_GET["id"];
        $role_name = $_POST["role_name"];
        $description = $_POST["description"];
        
        $action_flag = $obj->update($id, $role_name, $description);
        if($action_flag > 0)
        {
            echo "更新成功";
        }
        else{
            echo "更新失败";
        }
        echo "<br/><a href='role_edit.php?id={$id}'>继续添加</a>";
        header("refresh:3;url=role_disp.php");
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
        
        header("location:role_disp.php");
        
        break;
}
