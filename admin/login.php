<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>my wms</title>
  <!-- Font Awesome -->
  <link rel="stylesheet" href="../plugins/fontawesome-free/css/all.min.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="../plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../css/adminlte.min.css">
  
  <!-- jQuery -->
  <script src="../plugins/jquery/jquery.min.js"></script>
  <!-- Bootstrap 4 -->
  <script src="../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
  <!-- AnjularJS -->
  <script src="../plugins/angularJS/angular.min.js"></script>
  <script src="../plugins/ngStorage/ngStorage.min.js"></script>
  <!-- AdminLTE App -->
  <script src="../js/adminlte.min.js"></script>  
  <!-- Custom JS -->  
  <script src="../js/common.js"></script>  
  
  <!-- Custom JavaScript -->
  <script>
    $(document).ready(function(){
    	EnableLoginFocusField(true,'user_name');
    });
  </script>
</head>
<body class="hold-transition login-page" ng-app="myapp" ng-controller="myctrl">>
<div class="login-box" style="margin-top: -10%;">
  <!-- /.login-logo -->
  <div class="card card-outline card-primary">
    <div class="card-header text-center">
      <a href="#"><b>MyWMS - Adminstrator</b><span style="font-size:.52em"class="badge bg-primary">(v3.1.0)</span></a>
    </div>
    <div class="card-body">
      <p class="login-box-msg"></p>

        <div class="input-group mb-3">
          <input type="text" class="form-control" name="user_name" ng-model="user_name" placeholder="User or Email">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-user"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="password" class="form-control" name="password" ng-model="password" ng-keyup="keyup($event)" placeholder="Password">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
          <!-- /.col -->
          <div class="col-4">
            <button type="submit" class="btn btn-primary btn-block" ng-click="login()">登录</button>
          </div>
          <!-- /.col -->
        </div>

    </div>
    <!-- /.login-card-body -->
  </div>
</div>
<!-- /.login-box -->

<!-- AngularJS -->
		<script type="text/javascript">
		var app = angular.module("myapp",['ngStorage']);
		app.controller("myctrl",function($scope,$localStorage,$sessionStorage,$http){

		$scope.datas = [];
			
		//---Function---
		//->
		
		$scope.login=function(){
			$http.defaults.headers.post["Content-Type"] = "application/x-www-form-urlencoded";
			$http({
                method: 'post', url: 'login_action.php', 
                  cache: false,
                  data: $.param({action:'login', 
					  arguments:{  
						  user_code: $scope.user_name,
						  user_password: $scope.password, 	
						  }
						})
                          
            }).then(function(data){
                if (data.data.isExist == true){
					$localStorage.uid = data.data.rows[0]["id"];
					$localStorage.user_code = data.data.rows[0]["user_code"];
					$localStorage.user_text = data.data.rows[0]["user_text"];
					$localStorage.company_code = data.data.rows[0]["company_code"];
					$localStorage.role_code = data.data.rows[0]["role_code"];
					$localStorage.role_text = data.data.rows[0]["role_text"];
					$localStorage.email = data.data.rows[0]["email"];

					$scope.log('Y');		
					
					var url = 'iframe.php';
					window.location=url;     
            
                }else{
                	$scope.log('N');
                }
            }).catch(function(error){
            	$scope.log('N');
                console.log('error'+ error)
            });
			
		}		
		

		$scope.log=function($status_code){
			$http.defaults.headers.post["Content-Type"] = "application/x-www-form-urlencoded";
			$http({
                method: 'post', url: 'login_action.php', 
                  cache: false,
                  data: $.param({action:'log', 
					  arguments:{  
						  user_code: $scope.user_name,
						  where_use: 'admin',
						  status_code: $status_code
						  }
						})
                          
            }).then(function(data){
            	console.log('success')
            }).catch(function(error){
                console.log('error'+ error)
            });
			
		}	
		

        $scope.keyup = function(e){
            var keycode = window.event?e.keyCode:e.which;
            if(keycode==13){
            	$scope.login();    	
            }
       }			
			
		//<-

					
				
		//<-End		
		});
	</script>
</body>
</html>
