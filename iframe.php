<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta
	content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no"
	name="viewport">

<title>My WMS</title>

<!-- Google Font: Source Sans Pro -->
<!--  
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  -->
<!-- Font Awesome -->
<link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
<!-- Ionicons -->
<link rel="stylesheet" href="plugins/ionicons/css/ionicons.min.css">
<!-- Tempusdominus Bootstrap 4 -->
<link rel="stylesheet"
	href="plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
<!-- iCheck -->
<link rel="stylesheet"
	href="plugins/icheck-bootstrap/icheck-bootstrap.min.css">
<!-- JQVMap -->
<link rel="stylesheet" href="plugins/jqvmap/jqvmap.min.css">
<!-- Theme style -->
<link rel="stylesheet" href="css/adminlte.min.css">
<!-- overlayScrollbars -->
<link rel="stylesheet"
	href="plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
<!-- Daterange picker -->
<link rel="stylesheet"
	href="plugins/daterangepicker/daterangepicker.css">
<!-- summernote -->
<link rel="stylesheet" href="plugins/summernote/summernote-bs4.min.css">
</head>
<?php

function autoload($class_name)
{
    $class_file = str_replace('\\', '/', $class_name) . '.class.php';
    if (file_exists($class_file)) {
        require_once ($class_file);

        if (class_exists($class_name, false)) {
            return true;
        }
        return false;
    }
    return false;
}

if (function_exists('spl_autoload_register')) {
    spl_autoload_register('autoload');
}

$ado = new classes\DB\mysql_helper();
$tag = new classes\BASE\html();
new classes\SYS\session_mysql();

?>
<body class="hold-transition" ng-app="myapp"
	ng-controller="myctrl">
	<div class="wrapper">

		<!-- Navbar -->
		<nav
			class="main-header navbar navbar-expand navbar-white navbar-light fixed">
			<!-- Left navbar links -->
			<ul class="navbar-nav">
				<li class="nav-item"><a class="nav-link" data-widget="pushmenu"
					href="#" role="button"><i class="fas fa-bars"></i></a></li>
				<li class="nav-item d-none d-sm-inline-block"><a href="pages/home.php"
					class="nav-link">主页</a></li>
				<li class="nav-item d-none d-sm-inline-block"><a href="#"
					class="nav-link">公告</a></li>
			</ul>

			<!-- Right navbar links -->
			<ul class="navbar-nav ml-auto">
				<!-- Navbar Search -->
				<li class="nav-item"><a class="nav-link" data-widget="navbar-search"
					href="#" role="button"> <i class="fas fa-search"></i>
				</a>
					<div class="navbar-search-block">
						<form class="form-inline">
							<div class="input-group input-group-sm">
								<input class="form-control form-control-navbar" type="search"
									placeholder="Search" aria-label="Search">
								<div class="input-group-append">
									<button class="btn btn-navbar" type="submit">
										<i class="fas fa-search"></i>
									</button>
									<button class="btn btn-navbar" type="button"
										data-widget="navbar-search">
										<i class="fas fa-times"></i>
									</button>
								</div>
							</div>
						</form>
					</div></li>

				<!-- Messages Dropdown Menu -->
				<li class="nav-item dropdown"><a class="nav-link"
					data-toggle="dropdown" href="#"> <i class="far fa-comments"></i> <span
						class="badge badge-danger navbar-badge">3</span>
				</a>
					<div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
						<a href="#" class="dropdown-item"> <!-- Message Start -->
							<div class="media">
								<img src="img/user1-128x128.jpg" alt="User Avatar"
									class="img-size-50 mr-3 img-circle">
								<div class="media-body">
									<h3 class="dropdown-item-title">
										测试0 <span class="float-right text-sm text-danger"><i
											class="fas fa-star"></i></span>
									</h3>
									<p class="text-sm">Call me whenever you can...</p>
									<p class="text-sm text-muted">
										<i class="far fa-clock mr-1"></i> 4 Hours Ago
									</p>
								</div>
							</div> <!-- Message End -->
						</a>
						<div class="dropdown-divider"></div>
						<a href="#" class="dropdown-item"> <!-- Message Start -->
							<div class="media">
								<img src="img/user8-128x128.jpg" alt="User Avatar"
									class="img-size-50 img-circle mr-3">
								<div class="media-body">
									<h3 class="dropdown-item-title">
										测试1 <span class="float-right text-sm text-muted"><i
											class="fas fa-star"></i></span>
									</h3>
									<p class="text-sm">I got your message bro</p>
									<p class="text-sm text-muted">
										<i class="far fa-clock mr-1"></i> 4 Hours Ago
									</p>
								</div>
							</div> <!-- Message End -->
						</a>
						<div class="dropdown-divider"></div>
						<a href="#" class="dropdown-item"> <!-- Message Start -->
							<div class="media">
								<img src="img/user3-128x128.jpg" alt="User Avatar"
									class="img-size-50 img-circle mr-3">
								<div class="media-body">
									<h3 class="dropdown-item-title">
										测试2 <span class="float-right text-sm text-warning"><i
											class="fas fa-star"></i></span>
									</h3>
									<p class="text-sm">The subject goes here</p>
									<p class="text-sm text-muted">
										<i class="far fa-clock mr-1"></i> 4 Hours Ago
									</p>
								</div>
							</div> <!-- Message End -->
						</a>
						<div class="dropdown-divider"></div>
						<a href="#" class="dropdown-item dropdown-footer">查看所有消息</a>
					</div></li>
				<!-- Notifications Dropdown Menu -->
				<li class="nav-item dropdown"><a class="nav-link"
					data-toggle="dropdown" href="#"> <i class="far fa-bell"></i> <span
						class="badge badge-warning navbar-badge">15</span>
				</a>
					<div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
						<span class="dropdown-item dropdown-header">15 Notifications</span>
						<div class="dropdown-divider"></div>
						<a href="#" class="dropdown-item"> <i class="fas fa-envelope mr-2"></i>
							4 条新消息 <span class="float-right text-muted text-sm">3 mins</span>
						</a>
						<div class="dropdown-divider"></div>
						<a href="#" class="dropdown-item"> <i class="fas fa-users mr-2"></i>
							8 个好友请求 <span class="float-right text-muted text-sm">12 hours</span>
						</a>
						<div class="dropdown-divider"></div>
						<a href="#" class="dropdown-item"> <i class="fas fa-file mr-2"></i>
							3 个新的报表 <span class="float-right text-muted text-sm">2 days</span>
						</a>
						<div class="dropdown-divider"></div>
						<a href="#" class="dropdown-item dropdown-footer">See All
							Notifications</a>
					</div></li>
				<li class="nav-item"><a class="nav-link" data-widget="fullscreen"
					href="#" role="button"> <i class="fas fa-expand-arrows-alt"></i>
				</a></li>
				<li class="nav-item"><a class="nav-link"
					data-widget="control-sidebar" data-slide="true" href="#"
					role="button"> <i class="fas fa-th-large"></i>
				</a></li>
				<!-- /logout -->
				<li class="nav-item"><a class="nav-link" data-slide="true"
					ng-click="logout()" role="button"> <i class="fas fa-sign-out-alt"></i>登出
				</a></li>
				<!-- \logout -->
			</ul>
		</nav>
		<!-- /.navbar -->

		<!-- Main Sidebar Container -->
		<aside class="main-sidebar sidebar-dark-primary elevation-4">
			<!-- Brand Logo -->
			<a href="#" class="brand-link"
				style="color: Orange; font-style: italic; font-weight: bold;"> <i
				class="fas fa-building" style="font-size: 32px; color: Orange;"></i>[
				{{$storage.company_code}} ]

			</a>

			<!-- Sidebar -->
			<div class="sidebar">
				<!-- Sidebar user panel (optional) -->
				<div class="user-panel mt-3 pb-3 mb-3 d-flex">
					<div class="image">
						<img src="img/user2-160x160.jpg" class="img-circle elevation-2"
							alt="User Image">
					</div>

					<div class="info">
						<a href="#" class="d-block"><B><?php echo isset($_SESSION['user_code'])?$_SESSION['user_code']:"";?></B>
							- <small><?php echo isset($_SESSION['user_text'])?$_SESSION['user_text']:"";?></small>
							- <small><?php echo isset($_SESSION['role_text'])?$_SESSION['role_text']:"";?></small></a>
					</div>

				</div>

				<!-- SidebarSearch Form -->
				<div class="form-inline">
					<div class="input-group" data-widget="sidebar-search">
						<input class="form-control form-control-sidebar" type="search"
							placeholder="Search" aria-label="Search">
						<div class="input-group-append">
							<button class="btn btn-sidebar">
								<i class="fas fa-search fa-fw"></i>
							</button>
						</div>
					</div>
				</div>

				<!-- Sidebar Menu -->
      
      <?php echo $tag->build_html_left_menu(isset($_SESSION['uid'])?$_SESSION['uid']:"","L","")?>
      	  
      <!-- /.sidebar-menu -->
			</div>
			<!-- /.sidebar -->
		</aside>

		<!-- Content Wrapper. Contains page content -->
		<div class="content-wrapper iframe-mode" data-widget="iframe"
			data-loading-screen="750">
			<div
				class="nav navbar navbar-expand-lg navbar-white navbar-light border-bottom p-0">
				<div class="nav-item dropdown">
					<a class="nav-link bg-danger dropdown-toggle"
						data-toggle="dropdown" href="#" role="button" aria-haspopup="true"
						aria-expanded="false">关闭</a>
					<div class="dropdown-menu mt-0">
						<a class="dropdown-item" href="#" data-widget="iframe-close"
							data-type="all">关闭所有</a> <a class="dropdown-item" href="#"
							data-widget="iframe-close" data-type="all-other">关闭其它所有</a>
					</div>
				</div>
				<a class="nav-link bg-light" href="#"
					data-widget="iframe-scrollleft"><i class="fas fa-angle-double-left"></i></a>
				<ul class="navbar-nav" role="tablist">
					<li class="nav-item active" role="presentation"><a
						class="nav-link active" data-toggle="row" id="tab-index"
						href="#panel-index" role="tab" aria-controls="panel-index"
						aria-selected="true">主页</a></li>
				</ul>
				<a class="nav-link bg-light" href="#"
					data-widget="iframe-scrollright"><i
					class="fas fa-angle-double-right"></i></a> <a
					class="nav-link bg-light" href="#" data-widget="iframe-fullscreen"><i
					class="fas fa-expand"></i></a>
			</div>
			<div class="tab-content">
				<div class="tab-pane fade active show" id="panel-index"
					role="tabpanel" aria-labelledby="tab-index">
					<iframe src="pages/home.php" style="height: 671px;"></iframe>
				</div>
				<div class="tab-empty">
					<h2 class="display-4">No tab selected!</h2>
				</div>
				<div class="tab-loading">
					<div>
						<h2 class="display-4">
							Tab is loading <i class="fa fa-sync fa-spin"></i>
						</h2>
					</div>
				</div>
			</div>
		</div>

		<!-- /.content-wrapper -->
		<footer class="main-footer">
			<strong>Copyright &copy; 2003-2021 <a href="https://www.ides01.com">www.myides.com</a>.
			</strong> All rights reserved.
			<div class="float-right d-none d-sm-inline-block">
				<b>Version</b> 3.1.0
			</div>
		</footer>

		<!-- Control Sidebar -->
		<aside class="control-sidebar control-sidebar-dark">
			<!-- Control sidebar content goes here -->
		</aside>
		<!-- /.control-sidebar -->
	</div>
	<!-- ./wrapper -->


	<!-- jQuery -->
	<script src="plugins/jquery/jquery.min.js"></script>
	<!-- jQuery UI 1.11.4 -->
	<script src="plugins/jquery-ui/jquery-ui.min.js"></script>
	<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
	<script>
  $.widget.bridge('uibutton', $.ui.button)
</script>
	<!-- Bootstrap 4 -->
	<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
	<!-- daterangepicker -->
	<script src="plugins/moment/moment.min.js"></script>
	<script src="plugins/daterangepicker/daterangepicker.js"></script>
	<!-- Tempusdominus Bootstrap 4 -->
	<script
		src="plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
	<!-- Summernote -->
	<script src="plugins/summernote/summernote-bs4.min.js"></script>
	<!-- overlayScrollbars -->
	<script
		src="plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>

	<script src="plugins/layui/layui.js"></script>

	<!-- AnjularJS -->
	<script src="plugins/angularJS/angular.min.js"></script>
	<script src="plugins/ngStorage/ngStorage.min.js"></script>

	<!-- AdminLTE App -->
	<script src="js/adminlte.js"></script>
	<!-- AdminLTE for demo purposes -->
	<script src="js/demo.js"></script>

	<!-- AngularJS -->
	<script type="text/javascript">
		
		layui.use('layer', function(){ //独立版的layer无需执行这一句
			  var layer = layui.layer; //独立版的layer无需执行这一句
			});
		
		var app = angular.module("myapp",['ngStorage']);
		app.controller("myctrl",function($scope,$localStorage,$sessionStorage,$http){

		$scope.datas = [];

		$scope.$storage = $localStorage;

			
		//---Function---
		//->
		$scope.logout=function(){
			var url = (window.location != window.parent.location)
            ? document.referrer
            : document.location.href;

			var url = 'login.php';
			window.location=url;     		
		}		
		
		//<-
		
	$scope.AlertMaterial=function(){		
		var x = document.documentElement.clientWidth/4;
		var y = document.documentElement.clientHeight/4;
		console.log($scope.$storage.company_code);	
			
		layer.open({
		type: 2,
		title: '库存提示',
		//shadeClose: false,
		//shade: 0.8,
		//offset:[10+"px",10+"px"],
		offset: ['20%', '20%'],
		area: ['70%', '70%'],
		//area:['auto','auto'],
		content: 'pages/alert_material.php?company_code=' + $scope.$storage.company_code + '&role_name='+ $scope.$storage.role_name ,
		end: function () { //最后执行reload
            //location.reload();
        	}
		});
		
	};		
		
		//->Material Safety Stock Alert
		$scope.AlterMaterialCheck=function(){
			$scope.params = {"action": "material_alert"};
			$http.defaults.headers.post["Content-Type"] = "application/x-www-form-urlencoded";
			$http({
                method: 'post', url: 'iframe_action.php', data: $scope.params,
                transformRequest:function(obj){
                    var str=[];
                    for(var p in obj){
                        str.push(encodeURIComponent(p)+"="+encodeURIComponent(obj[p]));
                    }
                    return str.join("&");
                }                      
            }).then(function(data){
            	console.log('----1')
                console.log(data)
                console.log(data.data.rows.length)
                $scope.datas = data.data.rows;
                $scope.count = data.data.rows.length;
                if (data.data.rows.length > 0){
                	$scope.AlertMaterial();
                }
            }).catch(function(){
                console.log('error')
            })
		}		
		//<-
		
		$scope.AlterMaterialCheck();		
				
		//<-End		
		});
	</script>

</body>
</html>
