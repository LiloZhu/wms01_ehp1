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


$obj = new classes\libralies\role_menu_action();
$role_id = isset($_GET['id'])?$_GET['id']: "";
switch ($_GET["action"]){
    case'update':
        print_r( array_keys( $_POST['chk_menu']));
        if ($role_id <> ""){
            if (isset($_POST['chk_menu'])?$_POST['chk_menu']: ""  <> "")
            {
               $action_flag = $obj->update_role_menu($role_id,array_keys($_POST['chk_menu']));
               echo "更新成功";
            }
            else {
               $action_flag = $obj->update_role_menu($role_id,"");
               echo "更新成功";
            }
        }
        else{
            echo "添加失败";
        }

        header("refresh:3;url=role_menu_disp.php?id={$role_id}");
        echo '<br/>3s 后跳转...';
}
?>