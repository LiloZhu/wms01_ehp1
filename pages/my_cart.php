<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>My Cart</title>
<!-- CSS -->
<link rel="stylesheet" href="../plugins/bootstrap/css/bootstrap.min.css" />
<link rel="stylesheet" href="../plugins/bootstrap-table/bootstrap-table.min.css" />
<link rel="stylesheet" href="../plugins/bootstrap-editable/css/bootstrap-editable.css" />
<link rel="stylesheet" href="../plugins/TableExport/css/tableexport.min.css" />
<link rel="stylesheet" href="../plugins/layui/css/layui.css" />

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

<script src="../plugins/layui/layui.js"></script>

<!-- Template -->
<script src="../plugins/handlebars.js/handlebars.min.js"></script>
<script src="../plugins/underscore/underscore-min.js"></script>
<script src="../plugins/backbone/backbone.js"></script>
<script src="../plugins/backbone/backbone.localStorage.min.js"></script>

<!-- AnjularJS -->
<script src="../plugins/angularJS/angular.min.js"></script>
<script src="../plugins/ngStorage/ngStorage.min.js"></script>


</head>
	<body ng-app="myapp" ng-controller="myctrl">
		<div id="Box">
			<h3>我的购物车</h3>
				<button type="button" class="btn btn-primary myCart" ng-click="backToCart()">返回在线购物 <span class="badge badge-danger" style="font-size: 16px;"></span></button>
				<button type="button" class="btn btn-warning CartTransport" hidden ng-click="CartTransport()">转=>出库申请<span style="font-size: 16px;"></span></button>
				<table id="dataTable" class="table-sm text-sm" ng-show="istableShow" border="1px" cellpadding="0" cellspacing="0" style="width: 100%;">
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
							<td >已选购数量</td>
							<td>库存状态</td>
						</tr>
					</thead>
					<tbody ng-repeat="x in datas">
						<tr>
							<td>{{x.mat_code}}</td>
							<td>{{x.cust_mat_code}}</td>
							<td>{{x.mat_text}}</td>
							<td>{{x.rem_label_qty}}</td>
							<td>{{x.packing_unit_text}}</td>
							<td>{{x.rem_label_qty * x.min_packing_qty}}</td>
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
							<button type="button" class="btn btn-danger btn-sm" ng-click="deleteItem(x.id)" class="deleteCart">删除</button></td>
							<td>{{x.qty}}</td>
							<td>{{x.check_status_text}}</td>
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

			   //CartTransportButton
			   $scope.setCartTransportButton=function(){
					if ($scope.datas.length > 0){
						$(".CartTransport").prop("hidden",false);
					}else{
					$(".CartTransport").prop("hidden",true);
					}
				}  	
							
				//My Cart Data
				$scope.myCartData=function(){
					$scope.params = {"action": "retrieve"};
					$http.defaults.headers.post["Content-Type"] = "application/x-www-form-urlencoded";
					$http({
	                    method: 'post', url: 'my_cart_action.php', data: $scope.params,
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
                        $scope.count = data.data.rows.length;
                        $scope.setCartTransportButton();
                    }).catch(function(){
                        console.log('error')
                    })

					
				}                

				$scope.myCartData();
										

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
				
				$scope.deleteItem=function(Id){
					layer.confirm('您是否要删除当前行项目？', {
						btn: ['是', '否']
						}, function(index) {
							 layer.close(index);
    				$http.defaults.headers.post["Content-Type"] = "application/x-www-form-urlencoded";
    				$http({
                        method: 'post', url: 'my_cart_action.php', 
                          data: $.param({action:'delete', 
    						  arguments:{
    										key:   Id   		    	
    							  		}
    								   })
                                  
                    }).then(function(data1){
                        console.log(data1)
                        //$scope.datas = data.data.rows;
                        $scope.myCartData();
                    }).catch(function(error){
                        console.log('error'+ error)
                    })
					

					/*
					for (var i = 0; i < $scope.datas.length; i++) {
						if($scope.datas[i].id==Id)
						{
							$scope.datas.splice(i,1);
							break;
						}
					}
					*/
				});

				 $scope.myCartData();	
			  }


				$scope.backToCart=function(){
					//$location.path("/my_cart.php");
					var url = 'cart.php';
					window.location=url;
				}


				$scope.getOutboundReqNumber=function(callback){
					var req_number;
					$http.defaults.headers.post["Content-Type"] = "application/x-www-form-urlencoded";
					$http({
	                    method: 'post', url: 'my_cart_action.php', 
	                      cache: false,
	                      data: $.param({action:'req_number', 
							  arguments:{  
								  order_number: Date.now(), 	
								  }
								})
                                  
	                }).then(function(data1){
	                    console.log(data1)
	                    req_number = data1.data.req_number;

	                    callback(req_number);
	                }).catch(function(error){
	                    console.log('error'+ error)
	                    return req_number;
	                });

				}					


				$scope.CheckHasInCompleteReq=function(callback){
					var checkResult;
					$http.defaults.headers.post["Content-Type"] = "application/x-www-form-urlencoded";
					$http({
	                    method: 'post', url: 'my_cart_action.php', 
	                      cache: false,
	                      data: $.param({action:'check',
							  arguments:{  
								  }		                      
								})
                                  
	                }).then(function(data1){
	                    console.log(data1)
	                    checkResult = data1.data.isExist;
	                    callback(checkResult);
	                }).catch(function(error){
	                    console.log('error'+ error)
	                    return checkResult;
	                });					
				}

				$scope.CheckRealTimeShelf=function(callback){
					var checkResult;
					$http.defaults.headers.post["Content-Type"] = "application/x-www-form-urlencoded";
					$http({
	                    method: 'post', url: 'my_cart_action.php', 
	                      cache: false,
	                      data: $.param({action:'realtime_check',
							  arguments:{  
								  }		                      
								})
                                  
	                }).then(function(data1){
	                    console.log(data1)
	                    checkResult = data1.data.noShelf;
	                    callback(checkResult);
	                }).catch(function(error){
	                    console.log('error'+ error)
	                    return checkResult;
	                });					
				}

				$scope.UpdateRealTimeMyCart=function(callback){
				}
				
				$scope.myCartData();
				
				$scope.CartTransport=function(){
					
					$scope.CheckRealTimeShelf(function(isNoShelf){
						if (isNoShelf){
							layer.msg('当前在线库存已发生变更，请重新更新购物车!',{ time: 3000, icon: 4 });	
							$scope.myCartData();					
							return;							
						}
					
					
					$scope.CheckHasInCompleteReq(function(isHasReqInprocess){
						if (isHasReqInprocess){
							layer.msg('请先完成出库申请单的出库操作后，再创建新的出库申请!',{ time: 3000, icon: 4 });	
							$scope.myCartData();					
							return;
						}
						
					$scope.getOutboundReqNumber(function(req_number){
                    //->
					for(var idx = 0; idx < $scope.datas.length; idx++){
						$http.defaults.headers.post["Content-Type"] = "application/x-www-form-urlencoded";
						$http({
		                    method: 'post', url: 'my_cart_action.php', 
		                      data: $.param({action:'cart_transport', 
								  arguments:{
										req_number:     	req_number,
										item_no:			idx + 1,
										id:					$scope.datas[idx].id,	
										company_code:		$scope.datas[idx].company_code,	
										mat_code: 			$scope.datas[idx].mat_code,
										cust_mat_code: 		$scope.datas[idx].cust_mat_code,
										mat_text: 			$scope.datas[idx].mat_text,
										label_qty:	   	   	$scope.datas[idx].label_qty,
										qty:	   	   		$scope.datas[idx].qty,
										base_unit:    		$scope.datas[idx].base_unit,
										min_packing_qty:	$scope.datas[idx].min_packing_qty,
										packing_unit:		$scope.datas[idx].packing_unit,
										ref_delivery_order: $scope.datas[idx].ref_delivery_order,
										ref_delivery_item: 	$scope.datas[idx].ref_delivery_item,
										ref_order_number: 	$scope.datas[idx].ref_order_number,
										ref_item_no: 		$scope.datas[idx].ref_item_no,  
										export_number:		$scope.datas[idx].export_number,
										status_code:        'REL',												    	
									  }
									})
	                                  
		                }).then(function(data1){
		                    console.log(data1)
		                    //$scope.datas = data.data.rows;
		                    $scope.myCartData();
		                }).catch(function(error){
		                    console.log('error'+ error)
		                });						

					}
                    //<-
					
					})
 
					//<-
					})


					//<-
					});
					
				}	


				$scope.editCart=function(idx){
					if ($scope.datas[idx].label_qty < 1){
					layer.msg('请选择包装数量后再添加购物车!',{ time: 3000, icon: 4 });
					return;
					}
					$http.defaults.headers.post["Content-Type"] = "application/x-www-form-urlencoded";
					$http({
	                    method: 'post', url: 'my_cart_action.php', 
	                      data: $.param({action:'edit', 
							  arguments:{
								  	id:					$scope.datas[idx].id,
									label_qty:	   	   	$scope.datas[idx].label_qty,
									qty:	   	   		$scope.datas[idx].qty,	    		    	
								  }
								})
                                  
	                }).then(function(data1){
	                    console.log(data1)
	                    //$scope.datas = data.data.rows;
	                    $scope.myCartData();
	                }).catch(function(error){
	                    console.log('error'+ error)
	                });

				}					

	
				
				//判断数量,用ID作为参数
				$scope.reduce=function(idx,e){
					if ($scope.datas[idx].label_qty > 0){
					$scope.datas[idx].label_qty--;
					$scope.datas[idx].qty = $scope.datas[idx].label_qty * $scope.datas[idx].min_packing_qty;
					}
					
					if ($scope.datas[idx].label_qty < 1){
						$scope.deleteItem($scope.datas[idx].id);
						return;
						}else{
							$scope.editCart(idx);
				    }
							
				

				}
				
				$scope.increase=function(idx,e){
					if ($scope.datas[idx].label_qty < $scope.datas[idx].rem_label_qty){
					$scope.datas[idx].label_qty++;
					$scope.datas[idx].qty = $scope.datas[idx].label_qty * $scope.datas[idx].min_packing_qty;

					$scope.editCart(idx);	
					}

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
