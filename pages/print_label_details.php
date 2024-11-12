<?php
//=====================================================================================================//
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
<title>Print Label Details</title>
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

<script src="../plugins/moment/moment.min.js"></script>
<script src="../plugins/layui/layui.js"></script>
<script src="../js/common.js"></script>

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
        "TITLE" => "打印标签",
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
                "NAME" => "打印标签",
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

// =====================================================================================================//
/* ---Button New/Edit Modal--- */
// ->
function eventregister_button($_action)
{

}

/* ---Button New/Edit Modal--- */
// <-
//=====================================================================================================//
/* ---Button More Mat Cust Code Modal--- */
//->
function eventregister_button_more_material($_more){

};
/* ---Button More Mat Cust Code Modal--- */
//<-

// --- Prepare Tag array Data ---//
function prepare_tag_select_common($_field, $_action, $title, $where_use,$_enhancement)
{
    $tag_name = $_action . "_" . $_field;
    $label_id = "lbl_" . $_action . "_" . $_field;
    $label_name = "lbl_" . $_action . "_" . $_field;

    $_array_tag = array();
    $_array_tag = [
        "TEST" => "Test Use...",
        "NAME" => $tag_name,
        "DIV" => [
            "CLASS" => "col-sm-6",
            "STYLE" => "",
            "ENHANCEMENT" => ""
        ],
        "LABEL" => [
            "ID" => $label_id,
            "NAME" => $label_name,
            "FOR" => $tag_name,
            "CLASS" => "control-label",
            "TEXT" => $title,
            "ENHANCEMENT" => ""
        ],
        "SELECT" => [
            "ID" => $tag_name,
            "NAME" => $tag_name,
            "CLASS" => "form-control",
            "SQL" => "select type_code as code, type_text as text from tb_type where where_use = '{$where_use}' order by seq",
            "ENHANCEMENT" => $_enhancement
        ],
        "T_ENABLE" => TRUE,
        "T_CODE" => "",
        "T_TEXT" => "--- 请选择 ---"
    ];

    return $_array_tag;
}
;

function prepare_tag_select_special($_field, $_action, $_title, $_sql,$_enhancement)
{
    $tag_name = $_action . "_" . $_field;
    $label_id = "lbl_" . $_action . "_" . $_field;
    $label_name = "lbl_" . $_action . "_" . $_field;

    $_array_tag = array();
    $_array_tag = [
        "TEST" => "Test Use...",
        "NAME" => $tag_name,
        "DIV" => [
            "CLASS" => "col-sm-6",
            "STYLE" => "",
            "ENHANCEMENT" => ""
        ],
        "LABEL" => [
            "ID" => $label_id,
            "NAME" => $label_name,
            "FOR" => $tag_name,
            "CLASS" => "control-label mr-1",
            "TEXT" => $_title,
            "ENHANCEMENT" => ""
        ],
        "SELECT" => [
            "ID" => $tag_name,
            "NAME" => $tag_name,
            "CLASS" => "form-control",
            "SQL" => $_sql,
            "ENHANCEMENT" => $_enhancement
        ],
        "T_ENABLE" => TRUE,
        "T_CODE" => "",
        "T_TEXT" => "--- 请选择 ---"
    ];

    return $_array_tag;
}
;

// ------ Get PangeName ------//
function getPageName()
{
    return basename(__FILE__);
}

// ============Build Page Start=========
// ---Build Toolbar---
echo build_toolbar();
//echo eventregister_button('new');
//echo eventregister_button('edit');
//echo eventregister_button_more_material('more_order_mat_code');
// ----Build Table----

// ============Build Page End=========

?>
<div id="toolbar" class="btn-group">
	<button class="btn btn-primary" id="release"><i class="fas fa-user-check"></i>打印标签</button>
</div>
<div class="table-responsive text-sm">
	<table id="table" class="table-sm" data-toolbar="#toolbar"
		data-toggle="table" data-ajax="ajaxRequest" data-search="false"
		data-side-pagination="client" data-pagination="true" searchOnEnterKey="false"
		data-click-to-select="true" data-single-select="false"  data-row-style="rowStyle"
		data-page-size="10">

		<thead style="background: #efefef;">
			<tr>
				<th data-checkbox="true"></th>
				<th data-field="id">ID</th>
				<th data-field="company_text" data-sortable="true">公司</th>
				<th data-field="rfid" data-width="320" data-sortable="true">RFID</th>
				<th data-field="ref_order_number" data-width="140" data-sortable="true">交货单</th>
				<th data-field="ref_item_no" data-width="10" data-sortable="true" >行项目</th>
				<th data-field="mat_code" data-sortable="true" >物料编码</th>
				<th data-field="cust_mat_code" data-sortable="true">客户物料编码</th>
				<th data-field="mat_text" >物料描述</th>
				<th data-field="packing_unit_qty" >包装规格</th>
				<th data-field="print_status_text" data-formatter="displaycolor">当前打印状态</th>
				<th data-field="print_count" >打印次数</th>
				<th data-field="create_at" data-width="160" >创建日期</th>
				<th data-field="create_by_code" data-width="100" >创建者</th>
				<!--  
				<th data-field="change_at" data-width="100" >创建者</th>
				<th data-field="change_by_code" data-width="100" >打印者</th>
				-->
			</tr>
		</thead>

	</table>
</div>
	<!-- Current Page Script Action -->
	<script>  
//$(document).ready(function(){
//===> 	
	//->Main Table Source
    function ajaxRequest(params){
    	//debugger;
    	var order_number = getQueryString('order_number');
    	var item_no = getQueryString('item_no');
    	//alert(order_number);
    	
    	$.ajax({
    		url: "print_label_details_action.php",
    		type: "POST",
    		dataType: "json",
    	    data:{action:'retrieve', 
      		      arguments:{  
          		      order_number:  order_number,
          		      item_no:		 item_no,    		      
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
	//添加
	$add.on('click', function(){

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

	//编辑->print打印
	$edit.on('click', function(){
		printLabel();
	});

	function printLabel(){
		var rows = getSelections();
		
		if (rows.length  > 0){
			for(var index in rows)
			{
		//->
    		var request=new XMLHttpRequest;
               $.ajax({
                type:"POST",
    		dataType:"json",
                //url:"test_ajax_action.php?number="+$("#keywords").val(),
    		url:"print_label_details_action.php",
    		data:{action:'print_label', arguments:{
        		  company_code:  rows[index].company_code,
    			  rfid:	         rows[index].rfid,
    			  printer_name:  'GC-RFID',
    			  location_code: 'WX',
    			  status_code:	 'READY',
    			  transaction_code: 'DN01',
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
    				 layer.msg('打印数据设置成功');
               	 },
    			error:function(data){
                    alert("encounter error - "+ data.responseText);
                }
    		});	     
		//<-
			}
		}
			
	}

	
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

	
	$release.on('click', function(){
		var row = getSelections();
		layer.confirm('您是否要通过当前抽检交货单 [' + row[0].order_number + '] 的检查？', {
		btn: ['是', '否']
		}, function() {
			release(row);
			location.reload();
		});
	});


	function release(row){
		//->
		var request=new XMLHttpRequest;
           $.ajax({
            type:"POST",
		dataType:"json",
            //url:"test_ajax_action.php?number="+$("#keywords").val(),
		url:"print_label_action.php",
		data:{action:'generate_label', arguments:{
			  order_number:	   row[0].order_number,
			  item_no:	   	   row[0].item_no,
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
				 layer.msg('批准成功执行');
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
		if(value == "未设置打印") {
		var a = '<span style="color:blue">'+value+'</span>';
		}else if(value == "准备打印"){
		var a = '<span style="color:green">'+value+'</span>';
		}else if(value == "处理中") {
		var a = '<span style="color:Orange">'+value+'</span>';
		}else if(value == "打印完成") {
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