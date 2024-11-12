

<html>
<head>
	<title>菜单分层显示</title>
</head>
<center>
<body>
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

include ("menu.php");
?>

<h3>浏览分类信息</h3>
<?php 
$pid = empty($_GET['pid']) ? 0 : $_GET['pid'];
  $sql = "select * from tb_menu where pid = {$pid} order by concat(path,id);";
  $res = $obj->retrieve($sql);
  
  if (!empty($res))
  {
  $str_html = $obj->build_table($res);
  echo $str_html;  
  }
   
?>
</body>
</center>
</html>