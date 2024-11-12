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
<script src="../plugins/fontawesome-free/js/all.min.js"></script>

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

<!-- Current Page Script Action -->
<script>  
$(document).ready(function(){
//===> Begin
	$('title').text('重置密码');
//<=== End
});
</script>
</head>

<body ng-app="myapp" ng-controller="myctrl">
	
<div class="d-flex justify-content-center p-2 align-self-center">
<div class="card text-dark bg-light" style="width: 600px; ">
  <div class="card-header">重置密码</div>
  <div class="card-body">
    <h5 class="card-title">请输入你的新密码：</h5>
    <input type="password" id="password" class="form-control" placeholder='新密码'>
    <div class="d-flex justify-content-center">
    <button class="btn btn-primary" ng-click="checkRequest(event)"><i class="bi bi-key"></i>提交</button>
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
app.config(['$locationProvider', function($locationProvider) { 
    // $locationProvider.html5Mode(true); 
    $locationProvider.html5Mode({
    enabled: true,
    requireBase: false
   });
   }]);
   
app.controller("myctrl",function($scope,$location,$localStorage,$sessionStorage,$http){
$scope.$storage = $localStorage;
$scope.companydata = [];	
$scope.datas = [];
$scope.count=0;
//<-End		
//<-angularJS

console.log($location.search().reset_code);

$scope.handleRequest=function(){
	if ($('#password').val()){
		$http.defaults.headers.post["Content-Type"] = "application/x-www-form-urlencoded";
		$http({
            method: 'post', url: 'reset_password_action.php', 
              data: $.param({action:'request', 
				  arguments:{
					    email:	$location.search().email,
					  	reset_code:	$location.search().reset_code,
						password:   $('#password').val(),   	
					  }
					})
                      
        }).then(function(data){
            console.log(data)
            //$scope.datas = data.data.rows;
            //sendMail();
            
        	setTimeout(function () {
        		location.href = "../login.php";
        	}, 3000)
        	
        	layer.msg('密码已重置成功，就使用新密码登录！');
        }).catch(function(error){
            console.log('error'+ error)
        })
	}
else{
	layer.msg('新密码不能为空!',{ time: 3000, icon: 4 });
	return;			
}
}


$scope.checkRequest=function(){
	//->
	var request=new XMLHttpRequest;
           $.ajax({
            type:"POST",
	dataType:"json",
            //url:"test_ajax_action.php?number="+$("#keywords").val(),
	url:"reset_password_action.php",
	data:{action:'check_request', arguments:{
			reset_code:	$location.search().reset_code,
		  }
		},
            success: function(data){
               if(data.success){
                 $scope.handleRequest()
               }else{
                  $("#message").html("参数错误"+data.message); 
				  layer.msg('重置密码检查未通过，请检查重置码是否过期！',{ time: 3000, icon: 4 });
               }
			 
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