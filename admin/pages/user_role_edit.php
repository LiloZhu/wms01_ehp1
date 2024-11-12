<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>User roel edit</title>
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

    <script>
    $(function() {
        $("#selectAll").change(function() {
            var checkboxs = $("#tbody1").find("input[type='checkbox']");
            var isChecked = $(this).is(":checked");
            //严禁使用foreach，jq对象的遍历会使浏览器崩溃
            for(var i = 0; i < checkboxs.length; i++) {
                //临时变量，必须，否则只能选中最后一条记录
                var temp = i;
                $(checkboxs[temp]).prop("checked",isChecked);
            }
        });
    });

    function back()
    {
      window.location.href='user_role.php'
    }
    </script>		
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


$obj = new classes\libralies\user_role_action();

$sql = "select * from tb_user where id = {$_GET['id']};";
$sql = "call myiot.proc_get_user_role('{$_GET['id']}');";
$res = $obj->retrieve($sql);
?>
<body>
<form action="user_role_action.php?id=<?php echo $_GET['id']?>&action=update" class="form-horizontal" role="form" method="post">
<?php echo $obj->build_user_role($res)?>
	
 <div class="form-group">
    <div class="col-sm-offset-0 col-sm-10">
      <button type="submit" class="btn btn-default">提交</button>
      <button type="button" class="btn btn-default" onclick="back()">返回</button>
    </div>
  </div> 
  	
</form>
</body>
</html>