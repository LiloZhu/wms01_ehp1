<?php
//=====================================================================================================//
require("../components/mail/PHPMailer/mail.class.php");
/* ---Page Load--- */
//->
function autoload ($class_name){
    $class_file = '../'.str_replace('\\','/',$class_name). '.class.php';
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

$ado = new classes\DB\mysql_helper();
new classes\SYS\session_mysql();
$tag = new classes\BASE\html();

$uid = isset($_SESSION['uid'])?$_SESSION['uid']:'';
$company_code = isset($_SESSION['company_code'])?$_SESSION['company_code']:'';

/* ---Page Load--- */
//<-
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Sales Order</title>
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
<script src="../plugins/TableExport/tableExport.min.js"></script>>

<script src="../plugins/layui/layui.js"></script>

<!-- Template -->
<script src="../plugins/handlebars.js/handlebars.min.js"></script>
<script src="../plugins/underscore/underscore-min.js"></script>
<script src="../plugins/backbone/backbone.js"></script>
<script src="../plugins/backbone/backbone.localStorage.min.js"></script>

<!-- AnjularJS -->
<script src="../plugins/angularJS/angular.min.js"></script>
<script src="../plugins/ngStorage/ngStorage.min.js"></script>


<!-- Current Page CSS Style -->
<style>
caption {
	text-align: left;
	caption-side: top;
}

.select, #locale {
	width: 100%;
}

.like {
	margin-right: 10px;
}
</style>

<!-- Current Page Script Action -->
<script>  
$(document).ready(function(){
//===> Begin
	
  /*---Button Action---*/
   
    
//------------Ajax CRUD------------	

//<=== End
})
</script>

</head>
<body>

<?php

// =====================================================================================================//
/* ---Build Toolbar--- */
// ->
function build_toolbar()
{
    $_array_toolbar = [
        "TITLE" => "上架信息",
        "BUTTON" => [
            "NEW" => [
                "ID" => "btn_new",
                "NAME" => "新增",
                "DATA-TARGET" => "#modal_new",
                "CLASS" => "btn top btn-primary",
                "ICON" => "glyphicon glyphicon-plus"
            ],
            "EDIT" => [
                "ID" => "btn_edit",
                "NAME" => "查阅",
                "DATA-TARGET" => "#modal_edit",
                "CLASS" => "btn btn-success",
                "ICON" => "glyphicon glyphicon-edit"
            ],
            "DELETE" => [
                "ID" => "btn_delete",
                "NAME" => "删除",
                "DATA-TARGET" => "#modal_delete",
                "CLASS" => "btn btn-danger",
                "ICON" => "glyphicon glyphicon-remove"
            ],
            "REFRESH" => [
                "ID" => "btn_refresh",
                "NAME" => "刷新",
                "DATA-TARGET" => "#modal_refresh",
                "CLASS" => "btn btn-warning",
                "ICON" => "glyphicon glyphicon-refresh"
            ],
            "EXPORT" => [
                "ID" => "btn_export",
                "NAME" => "导出",
                "DATA-TARGET" => "#modal_export",
                "CLASS" => "btn btn-info",
                "ICON" => "glyphicon glyphicon-export"
            ]
        ]
    ];

    $_html = $GLOBALS['tag']->build_html_page_toolbar($_array_toolbar, '');
    return $_html;
}

/* ---Build Toolbar--- */

// ============Build Page Start=========
// ---Build Toolbar---
echo build_toolbar();
// ----Build Table----

// ============Build Page End=========

?>
<div id="toolbar" class="btn-group">
	<button class="btn btn-outline-primary" id="release"><i class="fas fa-user-check"></i>批准</button>
	<button class="btn btn-outline-danger" id="reject"><i class="fas fa-not-equal"></i>拒绝</button>
</div>
<div class="table-responsive text-sm">
	<table id="table" class="table-sm" data-toolbar="#toolbar"
		data-toggle="table" data-ajax="ajaxRequest" data-search="true"
		data-side-pagination="client" data-pagination="true" searchOnEnterKey="false"
		data-click-to-select="true" data-single-select="true"  data-row-style="rowStyle"
		data-page-size="10">

		<thead style="background: #efefef;">
			<tr>
				<th data-checkbox="true"></th>
				<th data-field="id">ID</th>
				<th data-field="company_text" data-sortable="true">公司</th>
				<th data-field="mat_code" data-sortable="true">物料编码</th>
				<th data-field="cust_mat_code" data-sortable="true">客户物料编码</th>
				<th data-field="mat_text" >物料描述</th>
				<th data-field="label_qty" >标签数量</th>
				<th data-field="shelf_qty" >上架数量</th>
				<th data-field="packing_unit_qty" >包装规格</th>
				<th data-field="order_number" data-width="140">订单</th>
				<th data-field="item_no" data-width="10" >行项目</th>
				<th data-field="delivery_order_number" data-width="140">交货单</th>
				<th data-field="delivery_item_no" data-width="10" >行项目</th>				
			</tr>
		</thead>

	</table>
</div>
	<!-- Current Page Script Action -->
	<script>  
//$(document).ready(function(){
//===>
 layui.use('layer', function(){ //独立版的layer无需执行这一句
  var layer = layui.layer; //独立版的layer无需执行这一句
 });
 
	//->Main Table Source
    function ajaxRequest(params){
    	//debugger;
    	$.ajax({
    		url: "shelf_action.php",
    		type: "POST",
    		dataType: "json",
    	    data:{action:'retrieve', 
      		      arguments:{      		      
    			      }
    				},				
    		success: function(rs){
    			console.log(rs)
    			var rows = rs.rows;
    			
                  params.success({ //注意，必须返回参数 params
    	            total: rs.total,
    	            rows: rows
    	        });
    
    			//debugger;
    		},
    		error: function(rs){
    			console.log(rs)
    		}
       });
    };
    //

    //->More button cust_mat_code
    function ajax_more_order_mat_code_request(params){
    	//debugger;
    	$.ajax({
    		url: "common_action.php",
    		type: "POST",
    		dataType: "json",
    	    data:{action:'more_order_mat_code', 
      		      arguments:{      		      
    			      }
    				},				
    		success: function(rs){
    			console.log(rs)
    			var rows = rs.rows;
    			
                  params.success({ //注意，必须返回参数 params
    	            total: rs.total,
    	            rows: rows
    	        });
    
    			//debugger;
    		},
    		error: function(rs){
    			console.log(rs)
    		}
       });
    };     
    //
        
    
    var $table = $("#table"),
    	$release = $("#release");

	$add = $("#btn_new"),
	$edit = $("#btn_edit"),
	$delete = $("#btn_delete"),
	$refresh = $("#btn_refresh");

    $release = $("#release");	  
    $reject = $("#reject");  

    //set Visiable
    $release.css({ "display": "none" });
    $reject.css({ "display": "none" });
    $add.css({ "display": "none" });
    //$edit.css({ "display": "none" });
    $delete.css({ "display": "none" });	    
    
	
    //按钮可用与否
    $edit.prop('disabled', true);
    //$look.prop('disabled', true);
    $delete.prop('disabled', true);
    $release.prop('disabled', true);
    $reject.prop('disabled', true);
    
    $table.on('check.bs.table uncheck.bs.table ' +
        	'check-all.bs.table uncheck-all.bs.table',
        	function() {
    			var bool = !($table.bootstrapTable('getSelections').length && $table.bootstrapTable('getSelections').length == 1);
    			var row = getSelections()[0]; 

        		$edit.prop('disabled', bool);
        		$delete.prop('disabled', bool);

    			if (row != undefined){
            		if (row.has_rfid == false){
            			$release.prop('disabled', false);
            			$reject.prop('disabled', false);
            			$edit.prop('disabled', true);
            			$delete.prop('disabled', false);
            		}else{
            			 $release.prop('disabled', true);
            			 $reject.prop('disabled', true);
             			 $edit.prop('disabled', false);
            			 $delete.prop('disabled', true);        			 	
                		}
    			}else{
    				$release.prop('disabled', bool);
    				$reject.prop('disabled', bool);
        		}

        		
        });
      
    
    //
    /**
     * 获得选中的数据，为一个对象数组
     */
	function getSelections() {
		return $.map($table.bootstrapTable('getSelections'), function(row) {
			return row; 
		});
	};
	
	//刷新
	$refresh.on('click', function(){
		$table.bootstrapTable('refresh');
	});

	//查看
	/*
	$look.on('click', function(){
		var row = getSelections()[0]; 
		var id = row.id; 
		var name = row.name;
		var price = row.price; //debugger;

		/*
		layer.open({
		type: 2,
		title: '查看商品',
		shadeClose: false,
		shade: 0.8,
		area: ['50%', '60%'],
		content: 'edit.html?id=' + id + '&name=' + name + '&price='+ price +'&type=look'
		});
		*/
	//});

	//编辑
	$edit.on('click', function(){
		var row = getSelections()[0]; 
		var order_number = row.delivery_order_number;
		var item_no = row.delivery_item_no;
		
		layer.open({
		type: 2,
		title: '上架详细信息',
		shadeClose: false,
		shade: 0.8,
		offset:[10+"px",10+"px"],
		area: ['98.5%', '96%'],
		content: 'shelf_details.php?order_number=' + order_number + '&item_no='+ item_no ,
		end: function () { //最后执行reload
            //location.reload();
        	}
		});
		
	});
	//删除
	$delete.on('click', function(){
		var ids = getSelections();
		layer.confirm('您是否要删除当前 ' + ids.length + '条数据？', {
		btn: ['是', '否']
		}, function() {
			delServer(ids);
		});
	});
	//删除
	function delServer(ids){
		//->
	var request=new XMLHttpRequest;
	           $.ajax({
	            type:"POST",
			dataType:"json",
	            //url:"test_ajax_action.php?number="+$("#keywords").val(),
			url:"delivery_qc_action.php",
			data:{action:'delete', arguments:{
				  key: ids[0].id
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

					 $table.bootstrapTable('refresh');
					 layer.msg('删除成功');
	           	 },
				error:function(data){
	                alert("encounter error - "+ data.responseText);
	            }
			});	       
		//<-			
	};

	function reject(row){
		//->
		var request=new XMLHttpRequest;
           $.ajax({
            type:"POST",
		dataType:"json",
            //url:"test_ajax_action.php?number="+$("#keywords").val(),
		url:"delivery_qc_action.php",
		data:{action:'reject', arguments:{
			  key		  :    row[0].id,
			  order_number:	   row[0].order_number,
			  item_no:	   	   row[0].item_no,
			  status_code:	   'REJ',
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

				 $table.bootstrapTable('refresh');
				 layer.msg('拒绝成功执行');
           	 },
			error:function(data){
                alert("encounter error - "+ data.responseText);
            }
		});	   
	//<-		
	}	
	
	function rowStyle(row, index) {
		/*
	    if (row.rem_qty == "0" ) {
            var style = {};             
                 //style={css:{'background-color':'green','font-weight':'bold'}};  
                 if (row.status_code == 'REL') { 
               		  style={css:{'color':'green'}};
                 }else if (row.status_code == 'NEW'){
                	  style={css:{'color':'orange'}};
                 }
                             
             return style;
	    }
	    */
	    return {};
	    
	}
	

	function displaycolor(value,row,index) {
		var a = "";
		if(value == "新建") {
		var a = '<span style="color:blue">'+value+'</span>';
		}else if(value == "已批准"){
		var a = '<span style="color:green">'+value+'</span>';
		}else if(value == "处理中") {
		var a = '<span style="color:Orange">'+value+'</span>';
		}else if(value == "已完成") {
			var a = '<span style="color:red">'+value+'</span>';		
		}else{
		var a = '<span>'+value+'</span>';
		}
		return a;
		};		
	
    $(function () {
       // $('#tableOrderRealItems').bootstrapTable('showColumn', 'ShopName');
        $('#table').bootstrapTable('hideColumn', 'id');
      });

    
//<===End      	 	
//}); 	 	
</script>

</html>