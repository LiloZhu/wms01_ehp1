<html>
	<head>
	<title>菜单管理</title>
<!-- Import JQuery -->
<link rel="stylesheet" href="../../plugins/bootstrap/css/bootstrap.min.css" />
<link rel="stylesheet" href="../plugins/fontawesome-free/css/all.min.css">
<!-- Ionicons -->
<link rel="stylesheet" href="../plugins/ionicons/css/ionicons.min.css">
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
<script src="../../script/common.js"></script>
	</head>
	<body>
	<form action="menu_action.php?action=add" class="form-horizontal" role="form" method="post">
	<input type="hidden" name="pid" value="<?php echo isset($_GET['pid'])?$_GET['pid']: 0 ?>" />
    <input type="hidden" name="path" value="<?php echo isset($_GET['path'])?$_GET['path']: "0," ?>" />	
 
  <div class="form-group">
    <label for="pid" class="col-sm-2 control-label">父类别</label>
    <div class="col-sm-2">
      <input type="text" class="form-control" name="pid" value="<?php echo isset($_GET['name'])?$_GET['name']: "根类别" ?>" disabled>
    </div>
  </div>

   <div class="form-group">
    <label for="type_code" class="col-sm-2 control-label">类别</label>
    <div class="col-sm-2">
			<select name="type_code" class="form-control">
			   <option value="T" <?php echo get_type_code("T") ?>>顶部菜单</option>
			   <option value="H" <?php echo get_type_code("H") ?>>头部菜单</option> 
			   <option value="L" <?php echo get_type_code("L") ?>>左侧菜单</option> 
			   <option value="R" <?php echo get_type_code("R") ?>>右侧菜单</option> 
			   <option value="B" <?php echo get_type_code("B") ?>>底部菜单</option> 
		   </select>
    </div>
  </div>    

   <div class="form-group">
    <label for="admin_flag" class="col-sm-2 control-label">后台管理</label>
    <div class="col-sm-1">    
		<div class="checkbox">
			<label>
			<input type="checkbox" name="admin_flag" <?php echo get_admin_flag()?>/>
			</label>
		</div>    
      </div>
  </div>   
  
  <div class="form-group">
    <label for="name" class="col-sm-2 control-label">菜单名称</label>
    <div class="col-sm-3">
      <input type="text" class="form-control" name="name"">
    </div>
  </div>  
  
  <div class="form-group">
    <label for="url" class="col-sm-2 control-label">URL</label>
    <div class="col-sm-4">
      <input type="text" class="form-control" name="url"">
    </div>
  </div>   
  
  <div class="form-group">
    <label for="icon" class="col-sm-2 control-label">图标</label>
    <div class="col-sm-4">
      <input type="text" class="form-control" name="icon"">
    </div>
  </div>  
  
    <div class="form-group">
    <label for="desc" class="col-sm-2 control-label">描述</label>
    <div class="col-sm-4">
      <textarea class="form-control" name="desc" rows="3"></textarea>
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
 function get_type_code($var_type_code){
     $type_code = isset($_GET['type_code'])?$_GET['type_code']: "";
     
     if ($type_code==$var_type_code){
         return 'selected="selected"';
     }else{
         return "";
     }
}

function get_admin_flag(){
    $admin_flag = isset($_GET['admin_flag'])?$_GET['admin_flag']: "";
    
    if ($admin_flag=="X"){
        return 'checked="checked"';
    }else{
        return '';
    }
}


?>