<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>User</title>
<!-- CSS -->
<link rel="stylesheet" href="../plugins/bootstrap-icons/font/bootstrap-icons.css">
<link rel="stylesheet" href="../plugins/bootstrap/css/bootstrap.min.css" />
<link rel="stylesheet" href="../plugins/layui/css/layui.css" />

<!--jquery-->
<script src="../plugins/jquery/jquery.min.js"></script>
<script src="../plugins/popper/umd/popper.min.js"></script>

<!-- Bootstrap 4 -->
<script src="../plugins/bootstrap/js/bootstrap.min.js"></script>

<!--bootstrap-table-->
<script src="../plugins/bootstrap-table/bootstrap-table.min.js"></script>
<script src="../plugins/bootstrap-table/locale/bootstrap-table-zh-CN.min.js"></script>

<script src="../plugins/layui/layui.js"></script>

<!-- Template -->
<script src="../plugins/handlebars.js/handlebars.min.js"></script>
<script src="../plugins/underscore/underscore-min.js"></script>
<script src="../plugins/backbone/backbone.js"></script>
<script src="../plugins/backbone/backbone.localStorage.min.js"></script>

<!-- AnjularJS -->
<script src="../plugins/angularJS/angular.min.js"></script>
<script src="../plugins/ngStorage/ngStorage.min.js"></script>
<script src="../js/common.js"></script>

<!-- Current Page Script Action -->
<script>  
$(document).ready(function(){
//===> Begin
	$('title').text('忘记密码');
//<=== End
});
</script>
</head>

<body ng-app="myapp" ng-controller="myctrl">
	
<div class="d-flex justify-content-center p-2 align-self-center">
<div class="card text-dark bg-light" style="width: 600px; ">
  <div class="card-header">找回密码</div>
  <div class="card-body">
    <h5 class="card-title">请输入你注册时的用户或密码：</h5>
    <input type="text" id="email" class="form-control" placeholder='注册邮箱'>
    <div class="d-flex justify-content-center">
    <button class="btn btn-primary" ng-click="handleRequest(event)"><i class="bi bi-key"></i>提交</button>
    </div>
  </div>
</div>
</div>


<script type="text/javascript">
 layui.use('layer', function(){ //独立版的layer无需执行这一句
	  var layer = layui.layer; //独立版的layer无需执行这一句
	 });

//->AngularJS
var app = angular.module("myapp",['ngStorage']);
app.controller("myctrl",function($scope,$localStorage,$sessionStorage,$http){
$scope.$storage = $localStorage;
$scope.companydata = [];	
$scope.datas = [];
$scope.count=0;
//<-End		
//<-angularJS

$scope.handleRequest=function(){
	if ($('#email').val()){
		$http.defaults.headers.post["Content-Type"] = "application/x-www-form-urlencoded";
		$http({
            method: 'post', url: 'forget_password_action.php', 
              data: $.param({action:'request', 
				  arguments:{
						email:		$('#email').val()    	
					  }
					})
                      
        }).then(function(data){
            console.log(data)
            //$scope.datas = data.data.rows;
            //sendMail();
            if (data.data.success){
            layer.msg('邮件已发送成功,请查看邮箱重置密码！');
            }else{
            	layer.msg('请正确填入注册时的邮件箱!',{ time: 3000, icon: 4 });
            }

        }).catch(function(error){
            console.log('error'+ error)
        })
	}
else{
	layer.msg('请认真填入注册时的邮件箱!',{ time: 3000, icon: 4 });
	return;			
}
}


function sendMail(){
	//->
	var request=new XMLHttpRequest;
           $.ajax({
            type:"POST",
	dataType:"json",
            //url:"test_ajax_action.php?number="+$("#keywords").val(),
	url:"forget_password_action.php",
	data:{action:'send_mail', arguments:{
		email:		$('#email').val()
		  }
		},
            success: function(data){
		//alert(data.message);
	   //alert(data.page);
               if(data.success){
                  $("#message").html("["+data.message+"]");
               }else{
                  $("#message").html("参数错误"+data.message); 
               }
			 layer.msg('邮件已发送成功,请查看邮箱重置密码！');
           	 },
		error:function(data){
                alert("encounter error - "+ data.responseText);
            }
	});	     
//<-
		
}	





//<-End		
});
</script>



</body>
</html>