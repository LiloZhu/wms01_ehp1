<!-- Backend Admin Page -->
<!doctype html>
<html>
<head>
<title>Role Menu</title>
<!-- Import JQuery -->
<link rel="stylesheet" href="../../plugins/bootstrap/css/bootstrap.min.css" />
<link rel="stylesheet" href="../../plugins/fontawesome-free/css/all.min.css">
<!-- Ionicons -->
<link rel="stylesheet" href="../../plugins/ionicons/css/ionicons.min.css">
<link rel="stylesheet" href="../../css/global.css" />
<!--jquery-->
<script src="../../plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="../../plugins/bootstrap/js/bootstrap.min.js"></script>
<!-- AnjularJS -->
<script src="../../plugins/angularJS/angular.min.js"></script>
<script src="../../plugins/ngStorage/ngStorage.min.js"></script>

<!--bootstrap-table-->
<link rel="stylesheet" href="../../plugins/bootstrap-table/bootstrap-table.min.css" />
<link rel="stylesheet" href="../../plugins/bootstrap-editable/css/bootstrap-editable.css" />
<script src="../../plugins/bootstrap-table/bootstrap-table.min.js"></script>
<script src="../../plugins/bootstrap-editable/js/bootstrap-editable.min.js"></script>
<link rel="stylesheet" href="../../plugins/layui/css/layui.css" />
<script src="../../plugins/layui/layui.js"></script>
<script src="../../js/common.js"></script>

<!-- Current Page CSS Style -->
<style>
caption {
text-align: left;
caption-side: top;
}
</style>
	
<!-- Current Page Script Action -->
<script>  
$(document).ready(function(){
//===> Begin
tableSelectAll("#tbody_01");

//<===End      	 	
});

function back()
{
  window.location.href='role_menu.php'
}
</script>
</head>
<body>

<form action="role_menu_action.php?id=<?php echo isset($_GET['id'])?$_GET['id']: ""?>&action=update" class="form-horizontal" role="form" method="post">
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
$role_id = isset($_GET['id'])?$_GET['id']: '';

  $sql = "call proc_get_role_menu({$role_id});";
  $res = $obj->retrieve($sql);
  
  if (!empty($res))
  {
  $str_html = $obj->build_table_role_menu($res);
  echo $str_html;  
  }
   
?>
 <div class="form-group">
    <div class="col-sm-offset-0 col-sm-10">
      <button type="submit" class="btn btn-default">提交</button>
      <button type="button" class="btn btn-default" onclick="back()">返回</button>
    </div>
  </div> 
 
</form>
</body>
</html>