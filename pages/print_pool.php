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
<title>Print Pool</title>
<!-- CSS -->
<link rel="stylesheet" href="../plugins/bootstrap/css/bootstrap.min.css" />
<link rel="stylesheet" href="../plugins/bootstrap-table/bootstrap-table.min.css" />

<!--jquery-->
<script src="../plugins/jquery/jquery.min.js"></script>
<script src="../plugins/popper/umd/popper.min.js"></script>
<script src="../plugins/fontawesome-free/js/all.min.js"></script>

<!-- Bootstrap 4 -->
<script src="../plugins/bootstrap/js/bootstrap.min.js"></script>


<!--bootstrap-table-->
<script src="../plugins/bootstrap-table/bootstrap-table.min.js"></script>
<script src="../plugins/bootstrap-table/locale/bootstrap-table-zh-CN.min.js"></script>


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
    $add = $("#btn_add"),
    $edit = $("#btn_edit"),
    $delete = $("#btn_delete"),
    $refresh = $("#btn_refresh");
    
    var $table = $("#table");
  /*---Button Action---*/
    $edit.on('click', function(){
    var action = '#edit_';
    var row = getSelections()[0];	  
  });	   
    
    
  //------------Ajax CRUD------------		
  //->New
   $('#btn_new_submit').click(function(){
    var action = '#new_';

   });
    //<-New 

//->Edit
	$('#btn_edit_submit').click(function(){
	var action = '#edit_';

	});
 //<-edit 

	    
   //------------Ajax CRUD------------	
//<=== End
});
</script>

</head>
<body>

<?php

/* ---Build Toolbar--- */
// ->
function build_toolbar()
{
    $_array_toolbar = [
        "TITLE" => "打印池信息状况",
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
                "NAME" => "编辑",
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
    $_btn_action = $_action;
    $_action = $_action . '_';

    return $_html;
}

/* ---Button New/Edit Modal--- */
// <-

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
            "CLASS" => "form-inline",
            "STYLE" => "",
            "ENHANCEMENT" => ""
        ],
        "LABEL" => [
            "ID" => $label_id,
            "NAME" => $label_name,
            "FOR" => $tag_name,
            "CLASS" => "control-label mr-1",
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

function prepare_tag_select_special($_field, $_action, $_title, $_sql)
{
    $tag_name = $_action . "_" . $_field;
    $label_id = "lbl_" . $_action . "_" . $_field;
    $label_name = "lbl_" . $_action . "_" . $_field;

    $_array_tag = array();
    $_array_tag = [
        "TEST" => "Test Use...",
        "NAME" => $tag_name,
        "DIV" => [
            "CLASS" => "form-inline",
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
            "ENHANCEMENT" => ""
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
// ----Build Table----

// ============Build Page End=========

?>

<div id="toolbar" class="btn-group">
	<button class="btn btn-primary" id="release"><i class="fas fa-user-check"></i>批准</button>
</div>
<div class="table-responsive text-sm">
	<table id="table" class="table-sm" data-toolbar="#toolbar"
		data-toggle="table" data-ajax="ajaxRequest" data-search="true"
		data-side-pagination="client" data-pagination="true" searchOnEnterKey="false"
		data-click-to-select="true" data-single-select="true" 
		data-page-size="10">

		<thead style="background: #efefef;">
			<tr>
				<th data-checkbox="true"></th>
				<th data-field="id">ID</th>
				<th data-field="rfid" data-width="110">RFID</th>
				<!--  
				<th data-field="printer_name" data-width="10" >打印机</th>
				<th data-field="location_code"  >位置</th>
				-->
				<th data-field="company_text" data-width="220" data-sortable="true">公司</th>
				<th data-field="status_text" data-formatter="displaycolor" data-sortable="true">打印状态</th>
				<th data-field="min_packing_qty" >最小包装</th>
				<th data-field="base_unit_text" >基本单位</th>
				<th data-field="packing_unit_text" >包装单位</th>
				<th data-field="packing_unit_qty" >规格</th>
				<th data-field="create_at" data-width="160" >创建日期</th>
				<th data-field="user_code" data-width="100" >创建者</th>
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
    	$.ajax({
    		url: "print_pool_action.php",
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


    var $table = $("#table"),
    	
    	//$add = $("#add"),
    	//$edit = $("#edit"),
    	//$look = $("#look"),
    	//$delete = $("#delete"),
    	//$refresh = $("#refresh");
    	 $release = $("#release");

	$add = $("#btn_new"),
	$edit = $("#btn_edit"),
	$delete = $("#btn_delete"),
	$refresh = $("#btn_refresh");
	
    //set Visiable
    $add.css({ "display": "none" });
    $edit.css({ "display": "none" });
    $release.css({ "display": "none" });
    $delete.css({ "display": "none" });
    $refresh.css({ "display": "none" });
    
    
	
    //按钮可用与否
    $delete.prop('disabled', true);
    $release.prop('disabled', true);
    
    $table.on('check.bs.table uncheck.bs.table ' +
    	'check-all.bs.table uncheck-all.bs.table',
    	function() {
    		var bool = !($table.bootstrapTable('getSelections').length && $table.bootstrapTable('getSelections').length == 1);
    		var row = getSelections()[0]; 

    		$edit.prop('disabled', bool);
    		$delete.prop('disabled', bool);

			if (row != undefined){
        		if (row.status_code == "READY"){
        			$release.prop('disabled', false);
        			$edit.prop('disabled', false);
        			$delete.prop('disabled', false);
        		}else{
        			 $release.prop('disabled', true);
         			 $edit.prop('disabled', true);
        			 $delete.prop('disabled', true);        			 	
            		}
			}else{
				$release.prop('disabled', true);
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

	//编辑
	$edit.on('click', function(){
		var row = getSelections()[0]; 
		var id = row.id; 
		var name = row.name;
		var price = row.price;

		/*
		layer.open({
		type: 2,
		title: '编辑商品',
		shadeClose: false,
		shade: 0.8,
		area: ['50%', '60%'],
		content: 'edit.html?id=' + id + '&name=' + name + '&price='+ price ,
		end: function () { //最后执行reload
            location.reload();
        	}
		});
		*/
	});

	function displaycolor(value,row,index) {
		var a = "";
		if(value == "准备打印") {
		var a = '<span style="color:blue">'+value+'</span>';
		}else if(value == "已批准"){
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