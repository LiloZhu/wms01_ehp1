<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>mywms</title>
  <!-- Font Awesome -->
  <link rel="stylesheet" href="plugins/fontawesome-free-6.6.0-web/css/all.min.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="plugins/bootstrap/css/bootstrap.min.css">
  <!-- layui -->
  <link rel="stylesheet" href="plugins/layui/css/layui.css">  
  <!-- Theme style -->
  <link rel="stylesheet" href="css/login.css">
  
  <!-- jQuery -->
  <script src="plugins/jquery/jquery.min.js"></script>
    
  <!-- Template -->
  <script src="plugins/handlebars.js/handlebars.min.js"></script>
  <script src="plugins/underscore/underscore-min.js"></script>
    
  <!-- AnjularJS -->
  <script src="plugins/angularJS/angular.min.js"></script>
  
  <!--  
  <script src="plugins/ngStorage/ngStorage.min.js"></script>
  -->
  
  <!-- AdminLTE App 
  <script src="js/adminlte.min.js"></script>  
  -->
  <!-- layui -->
  <script src="plugins/layui/layui.js"></script>
  <!-- Custom JS -->
  <script src="js/common.js"></script>    
  
  <!-- Custom JavaScript -->
  <script>
  $(document).ready(function(){
	  SetFocusFieldById(true,"user_name");
	  
  });
  </script>
</head>

<body class="hold-transition login-page" ng-app="myapp" ng-controller="myctrl">>
<div class="login-box" style="margin-top: -10%;">
  <!-- /.login-logo -->
  <div class="card card-outline card-primary">
    <div class="card-header text-center">
    	<div class="system-version-top-right"><span class="badge bg-primary system-version">(v0.0.0)</span></div>
      	<div class="login-box-title"><a href="#"><b class="login-box-title system-title">system name</b></a></div>
    </div>
    <div class="card-body">
      <p class="login-box-msg"></p>
       
        <div class="input-group mb-3">
         <select class="custom-select" id="language_code" name="language_code" ng-model="language_code"  ng-change="selectLanguage(language_code);" placeholder="Language">
            <option ng-repeat="x in languages" value="{{x.language_code}}">{{x.language_text}}</option>
             <option value="" disabled selected style="display: none;">Select Languaget</option>
          </select>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fa-solid fa-globe"></span>
            </div>
          </div>
        </div>        
        
        <div class="input-group mb-3">
          <input type="text" class="form-control" id="user_name" name="user_name" ng-model="user_name" ng-keyup="keyup($event)" placeholder="User or Email">          
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-user"></span>
            </div>
          </div>
        </div>
        
        
        <div class="input-group mb-3">
          <input type="password" class="form-control" id="password" name="password" ng-model="password" ng-keyup="keyup($event)" placeholder="Password">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <!--  
        <div class="row">
          <div class="col-8">
            <div class="icheck-primary">
              <input type="checkbox" id="remember">
              <label for="remember">
                记住我
              </label>
            </div>
          </div>
          -->
          <!-- /.col -->
          <div class=" text-right">
            <button type="submit" class="btn btn-primary btn-block" ng-click="login()">登录</button>
            <div>
            <a class="small mt-3 pointer" href="./pages/registration.php">帐号申请...</a><span style="color:#C0C0C0"> | </span>
            <a class="small mt-3" href="./pages/forget_password.php">忘记密码...</a>
            </div>
          </div>
          <!-- /.col -->
        </div>
        

    </div>
    <!-- /.login-card-body -->
  </div>
</div>
<!-- /.login-box -->
</body>
<!-- AngularJS -->
		<script type="text/javascript">
		 layui.use('layer', function(){ //独立版的layer无需执行这一句
			  var layer = layui.layer; //独立版的layer无需执行这一句
			 });

	 				
		//var app = angular.module("myapp",['ngStorage']);
		var app = angular.module("myapp",[]);
		app.controller("myctrl",function($scope,$http){

		$scope.datas = [];

		$scope.languages = [];
			
		//---Function---
		//->
		
		$scope.login=function(){
			//$localStorage.language_code = $("#language_code");
			
			$http.defaults.headers.post["Content-Type"] = "application/x-www-form-urlencoded";
			$http({
                method: 'post', url: 'login_action.php', 
                  cache: false,
                  data: $.param({action:'login', 
					  arguments:{  
						  user_code: $("#user_name").val(),
						  user_password: $scope.password, 	
						  }
						})
                          
            }).then(function(data){
                if (data.data.isExist == true){

                	localStorage.setItem("uid", data.data.rows[0]["id"]);
                	localStorage.setItem("user_code", data.data.rows[0]["user_code"]);
                	localStorage.setItem("user_text", data.data.rows[0]["user_text"]);
                	localStorage.setItem("company_code", data.data.rows[0]["company_code"]);
                	localStorage.setItem("role_code", data.data.rows[0]["role_code"]);
                	localStorage.setItem("role_text", data.data.rows[0]["role_text"]);
                	localStorage.setItem("email", data.data.rows[0]["email"]);
                	localStorage.setItem("language_code", $('#language_code').val());
                    /*
					$localStorage.uid = data.data.rows[0]["id"];
					$localStorage.user_code = data.data.rows[0]["user_code"];
					$localStorage.user_text = data.data.rows[0]["user_text"];
					$localStorage.company_code = data.data.rows[0]["company_code"];
					$localStorage.role_code = data.data.rows[0]["role_code"];
					$localStorage.role_text = data.data.rows[0]["role_text"];
					$localStorage.email = data.data.rows[0]["email"];
*/
					
					$scope.log('Y');		
					
					var url = 'iframe_1.php';
					window.location=url;     
            
                }else{
                	$scope.log('N');
                	$scope.loginFail();
                }
            }).catch(function(error){
            	$scope.log('N');
            	$scope.loginFail();
                console.log('error'+ error)
            });
			
			/*
	    	$.ajax({
	    		url: "login_action.php",
	    		type: "POST",
	    		dataType: "json",
	    	    data:{action:'login', 
	      		      arguments:{
						  user_code: $scope.user_name,
						  user_password: $scope.password, 
	    			      }
	    				},				
	    		success: function(rs){
	    			console.log(rs)
	    			var rows = rs.rows;
	    			
	                  params.success({ //注意，必须返回参数 params
	    	            total: rs.total,
	    	            rows: rows
	    	        });

	                  if (data.data.isExist == true){
	  					$localStorage.uid = data.data.rows[0]["id"];
	  					$localStorage.user_code = data.data.rows[0]["user_code"];
	  					$localStorage.user_text = data.data.rows[0]["user_text"];
	  					$localStorage.company_code = data.data.rows[0]["company_code"];
	  					$localStorage.role_code = data.data.rows[0]["role_code"];
	  					$localStorage.role_text = data.data.rows[0]["role_text"];
	  					$localStorage.email = data.data.rows[0]["email"];

						var url = 'iframe.php';
						window.location=url;
	                  }
								    	        
	    
	    			//debugger;
	    		},
	    		error: function(rs){
	    			console.log(rs)
	    		}
	       });
			*/
			
		}


		$scope.info=function(){
			
			$http.defaults.headers.post["Content-Type"] = "application/x-www-form-urlencoded";
			$http({
                method: 'post', url: 'login_action.php', 
                  cache: false,
                  data: $.param({action:'info', 
					  arguments:{  
						  language_code: 'ZH'
						  }
						})
                          
            }).then(function(data){
                if (data.data.isExist == true){
                    $(".system-title").text(data.data.rows[0]["system_text"]);
                    $(".system-version").text(data.data.rows[0]["version"]);
					//$scope.log('Y');
                }
            }).catch(function(error){
            	//$scope.log('N');
            	//$scope.loginFail();
                console.log('error'+ error)
            });	
            
		}


		$scope.language=function(){
			
			$http.defaults.headers.post["Content-Type"] = "application/x-www-form-urlencoded";
			$http({
                method: 'post', url: 'login_action.php', 
                  cache: false,
                  data: $.param({action:'language', 
					  arguments:{  
						  language_code: 'ZH'
						  }
						})
                          
            }).then(function(data){
                if (data.data.isExist == true){
                  $scope.languages = data.data.rows;

                  /*
                  if($localStorage.language_code !="" || $localStorage.language_code != null || $localStorage.language_code != undefined){
					//$("#language_code").val($localStorage.language_code);
					if (object.prototype.toString.call($localStorage.language_code) != '[object Object]'){
					$scope.language_code = $localStorage.language_code;
					}
                  }
                  */

                  if(localStorage.getItem("language_code") !=""){
                	  $scope.language_code = localStorage.getItem("language_code");
                  }
                      
                }
            }).catch(function(error){
            	//$scope.log('N');
            	//$scope.loginFail();
                console.log('error'+ error)
            });	
            
		}		

		$scope.log=function($status_code){
			$http.defaults.headers.post["Content-Type"] = "application/json";
			$http({
                method: 'post', url: 'login_action.php', 
                  cache: false,
                  data: $.param({action:'log', 
					  arguments:{  
						  user_code: $scope.user_name,
						  where_use: 'web',
						  status_code: $status_code
						  }
						})
                          
            }).then(function(data){
            	console.log('success')
            }).catch(function(error){
                console.log('error'+ error)
            });
			
		}	


		$scope.selectLanguage = function(v){
			if (v != undefined || v != null){
		      layer.msg('<div style="padding: 15px;text-align:left;">登录失败：<br>'+ v +'</div>'
		    	      , {
		    	        time: 3000, //3s后自动关闭
		    	        btn: [ '知道了']
		    	      });
		      
		      localStorage.setItem("language_code", v);
			}
		}

		$scope.keyup = function(e){
            var keycode = window.event?e.keyCode:e.which;
            var fileName = e.currentTarget.name;
            if(keycode==13){
            	switch(fileName){
            	case 'password':
            		$scope.login(); 
            	default:
            		SetFocusFieldById(true,'password'); 	

            	}
            }
       }

	  $scope.loginFail = function(e){
	      //配置一个透明的询问框
	      layer.msg('<div style="padding: 15px;text-align:left;">登录失败：<br>用户名或密码输入错误，请得新输入!</div>'
	      , {
	        time: 3000, //3s后自动关闭
	        btn: [ '知道了']
	      });
	    }			
			
		//<-

	  $scope.info();
	  $scope.language();

							
				
		//<-End		
		});
	</script>
</html>
