<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Cart</title>
<!-- CSS -->
<link rel="stylesheet" href="../plugins/fontawesome-free/css/all.min.css">
<link rel="stylesheet" href="../plugins/ionicons/css/ionicons.min.css">
<link rel="stylesheet" href="../plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
<link rel="stylesheet" href="../plugins/bootstrap/css/bootstrap.min.css" />
<link rel="stylesheet" href="../plugins/bootstrap-table/bootstrap-table.min.css" />
<link rel="stylesheet" href="../plugins/bootstrap-editable/css/bootstrap-editable.css" />
<link rel="stylesheet" href="../plugins/TableExport/css/tableexport.min.css" />
<link rel="stylesheet" href="../plugins/layui/css/layui.css" />
<link rel="stylesheet" href="../css/global.css" />
<link rel="stylesheet" href="../css/cart.css" />

<!--jquery-->
<script src="../plugins/jquery/jquery.min.js"></script>
<script src="../plugins/popper/umd/popper.min.js"></script>
<script src="../plugins/fontawesome-free/js/all.min.js"></script>

<!-- Bootstrap 4 -->
<script src="../plugins/bootstrap/js/bootstrap.min.js"></script>
<!-- overlayScrollbars -->
<script src="../plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>

<!--bootstrap-table-->
<script src="../plugins/bootstrap-table/bootstrap-table.min.js"></script>
<script src="../plugins/bootstrap-table/locale/bootstrap-table-zh-CN.min.js"></script>
<script src="../plugins/bootstrap-table/extensions/editable/bootstrap-table-editable.min.js"></script>
<script src="../plugins/bootstrap-editable/js/bootstrap-editable.min.js"></script>
<script src="../plugins/bootstrap-table/extensions/export/bootstrap-table-export.min.js"></script>
<script src="../plugins/TableExport/tableExport.min.js"></script>
<script src="../plugins/sheetjs/xlsx.core.min.js"></script>
<script src="../plugins/FileSaver/FileSaver.min.js"></script>

<script src="../plugins/moment/moment.min.js"></script>
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



</head>
	<body ng-app="myapp" ng-controller="myctrl">
		<div id="Box">
			<h3>在线购物</h3>
				<button type="button" class="btn btn-primary myCart" class="myCart" ng-click="myCart()">我的购物车 <span class="badge badge-danger" style="font-size: 16px;">{{count}}</span></button>
				<table id="dataTable" class="table-sm text-sm" ng-show="istableShow" border="1px" cellpadding="0" cellspacing="0">
					<thead style="background: #efefef;">
						<tr>
							<td style='width:200px'>物料编码</td>
							<td style='width:160px'>客户物编码</td>
							<td style='width:260px'>物料名称</td>
							<td style='width:120px'>库存包装数量</td>
							<td >包装单位</td>
							<td >库存数量</td>
							<td >基本单位</td>
							<td >规格</td>
							<td style='width:200px'>选购数量(按包装单位)</td>
							<td style='width:100px'>操作</td>
							<td>已选购数量</td>
						</tr>
					</thead>
					<tbody ng-repeat="x in datas">
						<tr>
							<td>{{x.mat_code}}</td>
							<td>{{x.cust_mat_code}}</td>
							<td>{{x.mat_text}}</td>
							<td>{{x.rem_label_qty}}</td>
							<td>{{x.packing_unit_text}}</td>
							<td>{{x.rem_qty}}</td>
							<td>{{x.base_unit_text}}</td>
							<td>{{x.packing_unit_qty}}</td>
							<td align="center">
							<div class='row col-sm-12'>
							<button type="button" class="btn btn-primary btn-sm" style='width:30px' ng-click="reduce($index,$event)">-</button>&nbsp
							<input type='text' id = "input_cart{{$index}}" class="form-control" ng-blur="oblur($index,$event)" ng-keyup="keyup($index,$event)" style='width:80px' 
							ng-model="x.label_qty"
							oninput="this.value=this.value.replace(/[^\d.]/g,'')"
							/>
							&nbsp<button type="button" class="btn btn-primary btn-sm" ng-click="increase($index)">+</button></td>
							</div>
							<td align="center">
							<button type="button" class="btn btn-primary btn-sm" ng-click="addCart($index,$event)" class="addCart">加入购物车</button></td>
							<td>{{x.qty}}</td>
						</tr>
					</tbody>
				</table>
			<div ng-show="ismessageShow"><p>您的购物车为空,<p style="color: #1E90FF;">去逛商场</p></p></div>
		</div>
		
		<script type="text/javascript">
		 layui.use('layer', function(){ //独立版的layer无需执行这一句
			  var layer = layui.layer; //独立版的layer无需执行这一句
			 });
		 		
			var app = angular.module("myapp",[]);
			app.controller("myctrl",function($scope,$http){
				
				$scope.isdataShow=true;
				$scope.istableShow=true;
				$scope.ismessageShow=false;
				$scope.datas = [];
				$scope.count=0;

				
				$scope.params = {"action": "retrieve"};
				
				
				$http.defaults.headers.post["Content-Type"] = "application/x-www-form-urlencoded";
				$http({
                    method: 'post', url: 'cart_action.php', data: $scope.params,
                    transformRequest:function(obj){
                        var str=[];
                        for(var p in obj){
                            str.push(encodeURIComponent(p)+"="+encodeURIComponent(obj[p]));
                        }
                        return str.join("&");
                    }                    
                }).then(function(data){
                    console.log(data)
                    $scope.datas = data.data.rows;
                }).catch(function(){
                    console.log('error')
                });

				
				//My Cart Item Count
				$scope.myCartCount=function(){
    				$http.defaults.headers.post["Content-Type"] = "application/x-www-form-urlencoded";
    				$http({
                        method: 'post', url: 'cart_action.php', data:{action:'my_cart'} ,
                        transformRequest:function(obj){
                            var str=[];
                            for(var p in obj){
                                str.push(encodeURIComponent(p)+"="+encodeURIComponent(obj[p]));
                            }
                            return str.join("&");
                        }                    
                    }).then(function(data){
                        console.log(data)
                        $scope.count = data.data.rows.length;
                    }).catch(function(){
                        console.log('error')
                    })
				}
				
				$scope.myCartCount();
				
				
				/*
				$scope.datas=[
				{id:10001,name:"茉莉花茶",price:45.9,gnumber:2}, 
				{id:10032,name:"南京雨花茶",price:75.8,gnumber:1}, 
				{id:10319,name:"安吉白茶",price:105.0,gnumber:2}, 
				{id:10033,name:"一级龙井茶",price:456.9,gnumber:5}];
				*/
				

				$scope.deleteall=function(){
					$scope.datas=[];
					$scope.isdataShow=false;
					$scope.ismessageShow=true;
				}
				
				$scope.checkedall=function(){
					var ischeckbox=$("input[type='checkbox']");
					ischeckbox.each(function(){
						$(this).prop("checked",true);
					});
				}
				
				$scope.deleteone=function(Id){
					for (var i = 0; i < $scope.datas.length; i++) {
						if($scope.datas[i].id==Id)
						{
							$scope.datas.splice(i,1);
							break;
						}
					}
				}

				$scope.myCart=function(){
					//$location.path("/my_cart.php");
					var url = 'my_cart.php';
					window.location=url;
				}

				$scope.addCart=function(idx){
					if ($scope.datas[idx].label_qty < 1){
					layer.msg('请选择包装数量后再添加购物车!',{ time: 3000, icon: 4 });
					return;
					}
					$http.defaults.headers.post["Content-Type"] = "application/x-www-form-urlencoded";
					$http({
	                    method: 'post', url: 'cart_action.php', 
	                      data: $.param({action:'add', 
							  arguments:{
									company_code:		$scope.datas[idx].company_code,	
									mat_code: 			$scope.datas[idx].mat_code,
									cust_mat_code: 		$scope.datas[idx].cust_mat_code,
									mat_text:			$scope.datas[idx].mat_text,
									label_qty:	   	   	$scope.datas[idx].label_qty,
									qty:	   	   		$scope.datas[idx].qty,
									base_unit:    		$scope.datas[idx].base_unit,
									min_packing_qty:	$scope.datas[idx].min_packing_qty,
									packing_unit:		$scope.datas[idx].packing_unit,
									ref_delivery_order: $scope.datas[idx].delivery_order_number,
									ref_delivery_item: 	$scope.datas[idx].delivery_item_no,
									ref_order_number: 	$scope.datas[idx].order_number,
									ref_item_no: 		$scope.datas[idx].item_no,  
									export_number:		$scope.datas[idx].export_number,	    	
									status_code:        'NEW',		    	
								  }
								})
                                  
	                }).then(function(data1){
	                    console.log(data1)
	                    //$scope.datas = data.data.rows;
	                    $scope.myCartCount();
	                }).catch(function(error){
	                    console.log('error'+ error)
	                })

				}				
				
				//判断数量,用ID作为参数
				$scope.reduce=function(idx,e){
					if ($scope.datas[idx].label_qty > 0){
					$scope.datas[idx].label_qty--;
					$scope.datas[idx].qty = $scope.datas[idx].label_qty * $scope.datas[idx].min_packing_qty;
					}
					
					//var el = '#input_cart'+idx;
					//$(el).value = $scope.datas[idx].label_cart_qty;
					//$(el).trigger('input'); 
				}
				
				$scope.increase=function(idx,e){
							if ($scope.datas[idx].label_qty < $scope.datas[idx].rem_label_qty){
							$scope.datas[idx].label_qty++;
							$scope.datas[idx].qty = $scope.datas[idx].label_qty * $scope.datas[idx].min_packing_qty;
							}
							
							//var el = '#input_cart'+idx;
							//$(el).value = $scope.datas[idx].label_cart_qty;
				}

				$scope.oblur=function(idx,e){
					var v
					if (e.target.value <= 0)
					{
						v = 0;
					}else{
						v = e.target.value.replace(/\b(0+)/gi,"");
					}

					if (v == "")
					{
						v = 0;
					}
					
					if (v > $scope.datas[idx].rem_label_qty){
						layer.msg('注意：选购包装数量超出库存数量,选购数量将自动按最大库存量填充！',{ time: 3000, icon: 4 });
						$scope.datas[idx].label_qty = $scope.datas[idx].rem_label_qty;
					}else{
						$scope.datas[idx].label_qty = v;
					}
					 
					//e.target.value = $scope.datas[idx].label_cart_qty;
					
					$scope.datas[idx].qty = $scope.datas[idx].label_qty * $scope.datas[idx].min_packing_qty;
				}

		        $scope.keyup = function(idx,e){
		            var keycode = window.event?e.keyCode:e.which;
		            if(keycode==13){
		            	if ($scope.datas[idx].label_qty > $scope.datas[idx].rem_label_qty){
							layer.msg('注意：选购包装数量超出库存数量,选购数量将自动按最大库存量填充！',{ time: 3000, icon: 4 });
							$scope.datas[idx].label_qty = $scope.datas[idx].rem_label_qty;			            	
		            	}
		            }
		        }			


				
			//<-End		
			});
		</script>
	</body>
</html>
