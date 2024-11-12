<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>注册帐号</title>
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
	$('title').text('注册帐号');
//<=== End
});
</script>
</head>

<body ng-app="myapp" ng-controller="myctrl">
<form id="registration_form" name="registration_form" class="form-horizontal" method="post" enctype="multipart/form-data">
	
<div class="d-flex justify-content-center p-2 align-self-center">
<div class="card text-dark bg-light" style="width: 800px; ">
  <div class="card-header">注册帐号</div>

<!-- Body->// -->   
  <div class="card-body">
    
<!-- Custom Block->\\ -->
<div class='form-horizontal'>

<!-- row->\\ -->
<div class='row'>
<div class='col-sm-6 '>
<label for='title_code' class='control-label mr-1'>称谓<span style="color: red;"> * </span></label>
<select id='title_code' class='form-control'>
    <option value='MR'>先生</option>
    <option value='MRS'>女士</option>
</select>
</div>
</div>
<!-- row<-// -->

<!-- row->\\ -->
<div class='row'>
<div class='col-sm-6'>
<label for='user_code' class='control-label'>用户代码<span style="color: red;"> * </span></label>
<input type='text' class='form-control' id='user_code' required  ng-blur="checkRequest($event,'用户代码')">
</div>
<div class='col-sm-6 '>
<label for='user_text' class='control-label'>用户名称<span style="color: red;"> * </span></label>
<input type='text' class='form-control' id='user_text'  required >
</div>
</div>
<!-- row<-// -->
 

<!-- row->\\ -->
<div class='row'>
<div class='col-sm-12 '>
<label for='email' class='control-label'>Email<span style="color: red;"> * </span></label>
<input type='text' class='form-control' id='email' required ng-blur="checkRequest($event,'Email')">
</div>
</div>
<!-- row<-// -->

<!-- row->\\ -->
<div class='row'>
<div class='col-sm-6 '>
<label for='company_code' class='control-label'>公司代码<span style="color: red;"> * </span></label>
<input type='text' class='form-control' id='company_code' required>
</div>
</div>
<!-- row<-// -->

<!-- row->\\ -->
<div class='row'>
<div class='col-sm-12 '>
<label for='company_text' class='control-label'>公司名称<span style="color: red;"> * </span></label>
<input type='text' class='form-control' id='company_text' required>
</div>
</div>
<!-- row<-// -->

<!-- row->\\ -->
<div class='row'>
<div class='col-sm-6 '>
<label for='department_code' class='control-label'>部门代码<span style="color: red;"> * </span></label>
<input type='text' class='form-control' id='department_code' required>
</div>
<div class='col-sm-6 '>
<label for='department_text' class='control-label'>部门名称<span style="color: red;"> * </span></label>
<input type='text' class='form-control' id='department_text' required>
</div>
</div>
<!-- row<-// -->

<!-- row->\\ -->
<div class='row'>
<div class='col-sm-6 '>
<label for='division_code' class='control-label'>项目组代码<span style="color: red;"> * </span></label>
<input type='text' class='form-control' id='division_code' required>
</div>
<div class='col-sm-6 '>
<label for='division_text' class='control-label'>项目组名称<span style="color: red;"> * </span></label>
<input type='text' class='form-control' id='division_text'  required>
</div>
</div>
<!-- row<-// -->

<!-- row->\\ -->
<div class='row'>
<div class='col-sm-6 '>
<label for='mobile' class='control-label'>手机<span style="color: red;"> * </span></label>
<input type='text' class='form-control' id='mobile' required ng-blur="checkRequest($event,'手机')">
</div>
<div class='col-sm-6 '>
<label for='telphone' class='control-label'>电话</label>
<input type='text' class='form-control' id='telphone'>
</div>
</div>
<!-- row<-// -->



</div>
<!-- Custom Block->// -->   
    
<!-- Button->\\ -->    
<div class="d-flex justify-content-center">
<button class="btn btn-primary" ng-click="checkRequest($event,'')"><i class="bi bi-key"></i>提交</button>
</div>
<!-- Button<-\\ -->      
   
  </div>
<!-- Body<-// --> 
  
</div>
</div>
</form>

<script type="text/javascript">
 layui.use('layer', function(){ //独立版的layer无需执行这一句
	  var layer = layui.layer; //独立版的layer无需执行这一句
	 });

//->AngularJS
var app = angular.module("myapp",['ngStorage']);

//->用来获取URL上的参数
app.config(['$locationProvider', function($locationProvider) { 
    // $locationProvider.html5Mode(true); 
    $locationProvider.html5Mode({
    enabled: true,
    requireBase: false
   });
   }]);
//<-用来获取URL上的参数

app.controller("myctrl",function($scope,$location,$localStorage,$sessionStorage,$http){
$scope.$storage = $localStorage;
$scope.datas = [];
$scope.count=0;
//<-End		
//<-angularJS

$scope.handleRequest=function(){
	if ($('#email').val() && $('#user_code').val()){
		$http.defaults.headers.post["Content-Type"] = "application/x-www-form-urlencoded";
		$http({
            method: 'post', url: 'registration_action.php', 
              data: $.param({action:'request', 
				  arguments:{
					  	user_code:    $('#user_code').val(),
					    user_text:    $('#user_text').val(),
					    email:  	  $('#email').val(),
					  	company_code: $('#company_code').val(),
					  	company_text: $('#company_text').val(),
					  	department_code: $('#department_code').val(),
					  	department_text: $('#department_text').val(),
					  	division_code: $('#division_code').val(),
					  	division_text: $('#division_text').val(),
					  	title_code: $('#title_code').val(),
					  	mobile: $('#mobile').val(),
					  	telphone: $('#telphone').val(),					  						  	
					  }
					})
                      
        }).then(function(data){
           if(data.data.success){            
        	setTimeout(function () {
        		location.href = "../login.php";
        	}, 3000)
        	
        	layer.msg('帐号申请成功，请耐心等待审批！');
           }
           
        }).catch(function(error){
            console.log('error'+ error)
        })
	}
else{
	layer.msg('必输项不能为空!',{ time: 3000, icon: 4 });
	return;			
}
}


$scope.checkRequest=function(event,label){

	if (event.type == 'blur'){
	if (!$('#'+ event.currentTarget.id +'').val()){
		layer.msg( label + '不能为空！',{ time: 3000, icon: 4 });
	}
		return;
	}
	
	//->
	var request=new XMLHttpRequest;
    $.ajax({
    type:"POST",
	dataType:"json",
	url:"registration_action.php",
	data:{action:'check_request',
		  arguments:{
			  	user_code: $('#user_code').val(),
			    email:     $('#email').val(),
			  	mobile:    $('#mobile').val(),			  						  	
			  }
		},
            success: function(data){
               if(data.success){
					var lv_msg = '';
                	$.each(data.rows, function(i, item){     
                		   lv_msg += item.check_isexist + '已存在！<br>'; 
                		}); 
                	layer.msg(lv_msg,{ time: 3000, icon: 4 });
                 //$scope.handleRequest()
               }else{
                 $scope.handleRequest()
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