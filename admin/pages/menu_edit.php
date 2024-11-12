<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>User Add</title>
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
<!-- treeview -->
<script src="../../plugins/jquery-treeview/jquery.treeview.js"></script>
<link rel="stylesheet" href="../../plugins/jquery-treeview/jquery.treeview.css"></script>
<!--bootstrap-table-->
<link rel="stylesheet" href="../../plugins/bootstrap-table/bootstrap-table.min.css" />
<link rel="stylesheet" href="../../plugins/bootstrap-editable/css/bootstrap-editable.css" />
<script src="../../plugins/bootstrap-table/bootstrap-table.min.js"></script>
<script src="../../plugins/bootstrap-editable/js/bootstrap-editable.min.js"></script>
<link rel="stylesheet" href="../../plugins/layui/css/layui.css" />
<script src="../../plugins/layui/layui.js"></script>
<script src="../../script/common.js"></script>
</head>
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

  $sql = "select * from tb_menu where id = {$_GET['id']};";
  $res = $obj->retrieve_row($sql);
  
?>  

<body>
<form action="menu_action.php?id=<?php echo $_GET['id']?>&action=edit" class="form-horizontal" role="form" method="post">
   <div class="form-group">
    <label for="type_code" class="col-sm-2 control-label">类别</label>
    <div class="col-sm-2">
			<select name="type_code" class="form-control">
			   <option value="T" <?php echo get_type_code("T", $res['type_code']) ?>>顶部菜单</option>
			   <option value="H" <?php echo get_type_code("H", $res['type_code']) ?>>头部菜单</option> 
			   <option value="L" <?php echo get_type_code("L", $res['type_code']) ?>>左侧菜单</option> 
			   <option value="R" <?php echo get_type_code("R", $res['type_code']) ?>>右侧菜单</option> 
			   <option value="B" <?php echo get_type_code("B", $res['type_code']) ?>>底部菜单</option> 
		   </select>
    </div>
  </div>    

   <div class="form-group">
    <label for="admin_flag" class="col-sm-2 control-label">后台管理</label>
    <div class="col-sm-1">    
		<div class="checkbox">
			<label>
			<input type="checkbox" name="admin_flag" <?php echo get_admin_flag($res['admin_flag'])?> "/>
			</label>
		</div>    
      </div>
  </div>   
  
  <div class="form-group">
    <label for="name" class="col-sm-2 control-label">菜单名称</label>
    <div class="col-sm-3">
      <input type="text" class="form-control" name="name" value="<?php echo $res['menu_name']?>" />
    </div>
  </div>  
  
  <div class="form-group">
    <label for="url" class="col-sm-2 control-label">URL</label>
    <div class="col-sm-4">
      <input type="text" class="form-control" name="url" value="<?php echo $res['url']?>" />
    </div>
  </div>   
  
  <div class="form-group">
    <label for="icon" class="col-sm-2 control-label">图标</label>
    <div class="col-sm-4">
      <input type="text" class="form-control" name="icon" value="<?php echo $res['icon']?>" />
    </div>
  </div>  
  
    <div class="form-group">
    <label for="desc" class="col-sm-2 control-label">描述</label>
    <div class="col-sm-4">
      <textarea class="form-control" name="desc" rows="3"><?php echo $res['description']?></textarea>
    </div>
  </div>  
    
  
   <div class="form-group">
    <div class="col-sm-offset-2 col-sm-10">
      <button type="submit" class="btn btn-default">提交</button>
    </div>
  </div> 
 
	</form>
	
	</body>

</html>

<?php 
 function get_type_code($var_type_code,$type_code){
     if ($type_code==$var_type_code){
         return 'selected="selected"';
     }else{
         return "";
     }
}

function get_admin_flag($admin_flag){
    if ($admin_flag=="X"){
        return 'checked="checked"';
    }else{
        return '';
    }
}


?>
