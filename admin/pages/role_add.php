<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>User Add</title>
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

<form action="role_action.php?action=add" class="form-horizontal" role="form" method="post">
  <div class="form-group">
    <label for="role_name" class="col-sm-2 control-label">角色名</label>
      <div class="col-sm-3">
    <input type="text" class="form-control" name="role_name">
    </div>
  </div>
  
  <div class="form-group">
    <label for="description" class="col-sm-2 control-label">描述</label>
      <div class="col-sm-4">
      <textarea  class="form-control" rows="3" name="description"></textarea>
    </div>
  </div>

   <div class="form-group">
    <div class="col-sm-offset-2 col-sm-10">
      <button type="submit" class="btn btn-default">提交</button>
    </div>
  </div>     
  
 </form>