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
<title>outbound request</title>
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
	var
    $add = $("#btn_new"),
    $edit = $("#btn_edit"),
    $delete = $("#btn_delete"),
    $refresh = $("#btn_refresh"),
    $table = $("#table"),
	$table_more_cust_mat_code = $("#table_more_cust_mat_code");
	
  /*---Button Action---*/
    $edit.on('click', function(){
    var action = '#edit_';
    var row = getSelections()[0];
     	    
    var action = '#edit_';
    
    $('' + action + 'id').val(row.id);
    $('' + action + 'req_number').val(row.req_number);
    $('' + action + 'item_no').val(row.item_no);
    $('' + action + 'delivery_order_number').val(row.ref_delivery_order);
    $('' + action + 'delivery_item_no').val(row.ref_delivery_item);    
    $('' + action + 'order_number').val(row.ref_order_number);
    $('' + action + 'mat_code').val(row.mat_code);
    $('' + action + 'cust_mat_code').val(row.cust_mat_code);
    $('' + action + 'mat_text').val(row.mat_text);
    $('' + action + 'qty').val(row.qty);
    $('' + action + 'base_unit').val(row.base_unit);
    $('' + action + 'min_packing_qty').val(row.min_packing_qty);    
    $('' + action + 'packing_unit_qty').val(row.packing_unit_qty);
    $('' + action + 'label_qty').val(row.label_qty);
    $('' + action + 'qty').val(row.qty);
    $('' + action + 'company_code').val(row.company_code);
    
	//$('#btn_edit_submit').attr("disabled",false);
  });	   
    
    
    
//------------Ajax CRUD------------	
//->More cust mat code
$('#btn_more_cust_mat_code_submit').click(function(){
	var action = '#new_';
	//var req_number = $('' + action + 'order_number').val();
	var req_number = '$0000000001';
	var item_no = '1';
	
	var rows = getSelectionsMore();
		
	if (rows.length  > 1){
		$("#modal_new").modal('hide');
		for(var index in rows)
		{
			
		status_code = 'NEW';
		
		var request=new XMLHttpRequest;
		           $.ajax({
			            type:"POST",
            			cache: false,
            			async: false,
            		dataType:"json",
		            //url:"test_ajax_action.php?number="+$("#keywords").val(),
				url:"outbound_req_action.php",
				data:{action:'add', 
					  arguments:{
						req_number:     	req_number,
						item_no:			item_no,
						company_code:		rows[index].company_code,	
						mat_code: 			rows[index].mat_code,
						cust_mat_code: 		rows[index].cust_mat_code,
						mat_text:			rows[index].mat_text,
						label_qty:	   	   	0,
						qty:	   	   		0,
						base_unit:    		rows[index].base_unit,
						min_packing_qty:	rows[index].min_packing_qty,
						packing_unit:		rows[index].packing_unit,
						ref_delivery_order: rows[index].delivery_order_number,
						ref_delivery_item: 	rows[index].delivery_item_no,
						ref_order_number: 	rows[index].order_number,
						ref_item_no: 		rows[index].item_no,  
						export_number:		rows[index].export_number,		    	
						status_code:        status_code,		    	
					  }
					},
		            
		            success: function(data){
					//alert(data.message);
					
		               if(data.success){
		                  $("#message").html("["+data.message+"]");
		               }else{
		                  $("#message").html("MYSQL-0001:Parameter Error "+data.message); 
		               }
					//$("modal_new").modal('hide')
					
					//$("modal_new").css("display","none");
					//$table.bootstrapTable('refresh');
		            },
				error:function(data){
		                alert("MYSQL-0002:Ajax Create Error - "+ data.responseText);
		            }
			});
		}
		location.reload();
		//$table.bootstrapTable('refresh');
	}
	else{
	row = rows[0];
	$('#new_company_code').val(row.company_code);
	$('#edit_company_code').val(row.company_code);	
	$('#new_cust_mat_code').val(row.cust_mat_code);
	$('#edit_cust_mat_code').val(row.cust_mat_code);
	$('#new_mat_code').val(row.mat_code);
	$('#edit_mat_code').val(row.mat_code);
	$('#new_mat_text').val(row.mat_text);
	$('#edit_mat_text').val(row.mat_text);
	$('#new_label_qty').val(row.rem_label_qty);
	$('#edit_label_qty').val(row.rem_label_qty);	
	$('#new_qty').val(row.rem_qty);
	$('#edit_qty').val(row.rem_qty);
	$('#new_base_unit').val(row.base_unit);
	$('#edit_base_unit').val(row.base_unit);
	$('#new_min_packing_qty').val(row.min_packing_qty);
	$('#edit_min_packing_qty').val(row.min_packing_qty);	
	$('#new_packing_unit').val(row.packing_unit);
	$('#edit_packing_unit').val(row.packing_unit);	
	$('#new_packing_unit_qty').val(row.packing_unit_qty);
	$('#edit_packing_unit_qty').val(row.packing_unit_qty);
	$('#new_delivery_order_number').val(row.delivery_order_number);
	$('#edit_delivery_order_number').val(row.delivery_order_number);
	$('#new_delivery_item_no').val(row.delivery_item_no);	
	$('#edit_delivery_item_no').val(row.delivery_item_no);	
	$('#new_order_number').val(row.order_number);
	$('#edit_order_number').val(row.order_number);
	$('#new_item_no').val(row.item_no);	
	$('#edit_item_no').val(row.item_no);						
	}
		
});  

//->New
$('#btn_new_submit').click(function(){
var action = '#new_';
var req_number = '$0000000001';
var item_no = '1';
var mat_code = $('' + action + 'mat_code').val();  
var cust_mat_code = $('' + action + 'cust_mat_code').val();  
var mat_text = $('' + action + 'mat_text').val();  

var label_qty = $('' + action + 'label_qty').val(); 
var min_packing_qty = $('' + action + 'min_packing_qty').val(); 

var base_unit =$("select[name='"+ action.replace("#","") +"base_unit']").val();
var packing_unit =$("select[name='"+ action.replace("#","") +"packing_unit']").val();

var company_code =$("select[name='"+ action.replace("#","") +"company_code']").val();
var qty = Number(label_qty) * Number(min_packing_qty); 

var status_code = 'NEW';  

var row = getSelectionsMore()[0];

if ((Number(label_qty) > Number(row.rem_label_qty)) && (Number(label_qty) + Number(row.rem_label_qty) > 0 )){
	var rem_label_qty = Number(row.rem_label_qty);
	var rem_qty = Number(row.rem_label_qty) * Number(oldValue.min_packing_qty);
	layer.msg('更改数量失败,超出当前订单剩余数量：['+ rem_qty +'],剩余最大标签数:['+ rem_label_qty +']！');
	$table.bootstrapTable('refresh');
	$table_more_cust_mat_code.bootstrapTable('refresh');
	return;
}

var request=new XMLHttpRequest;
           $.ajax({
            type:"POST",
		dataType:"json",
            //url:"test_ajax_action.php?number="+$("#keywords").val(),
		url:"outbound_req_action.php",
		data:{action:'add', 
			  arguments:{      		      
					req_number:     	req_number,
					item_no:			item_no,
					company_code:		company_code,	
					mat_code: 			mat_code,
					cust_mat_code: 		cust_mat_code,
					mat_text:			mat_text,
					label_qty:	   	   	0,
					qty:	   	   		0,
					base_unit:    		base_unit,
					min_packing_qty:	min_packing_qty,
					packing_unit:		packing_unit,
					ref_delivery_order: row.delivery_order_number,
					ref_delivery_item: 	row.delivery_item_no,
					ref_order_number: 	row.order_number,
					ref_item_no: 		row.item_no,  
					export_number:		row.export_number,							  		    	
					status_code:        status_code,
							    	
			  }
			},
            
            success: function(data){
			//alert(data.message);
			
               if(data.success){
                  $("#message").html("["+data.message+"]");
               }else{
                  $("#message").html("MYSQL-0001:Parameter Error "+data.message); 
               }
			//$("modal_new").modal('hide')
			
			//$("modal_new").css("display","none");
			$table.bootstrapTable('refresh');
			$table_more_cust_mat_code.bootstrapTable('refresh');
            },
		error:function(data){
                alert("MYSQL-0002:Ajax Create Error - "+ data.responseText);
            }
	});
});
//<-New 

//->Edit
$('#btn_edit_submit').click(function(){
var action = '#edit_';

var id = $('' + action + 'id').val();
var label_qty = $('' + action + 'label_qty').val();  
var min_packing_qty = $('' + action + 'min_packing_qty').val(); 

var qty = Number(label_qty) * Number(min_packing_qty);

var row = getSelections()[0];

if (Number(label_qty)  > (Number(row.rem_label_qty) + Number(row.label_qty)) && (Number(row.rem_label_qty) +  Number(row.label_qty)) > 0 ){
	var rem_label_qty = Number(row.rem_label_qty) + Number(row.label_qty);
	var rem_qty = Number(rem_label_qty) * Number(row.min_packing_qty);
	
	layer.msg('更改数量失败,超出当前订单剩余数量：['+ rem_qty +'],剩余最大标签数:['+ rem_label_qty +']！');
	$table.bootstrapTable('refresh');
	return;
	 }


var request=new XMLHttpRequest;
           $.ajax({
            type:"POST",
		dataType:"json",
            //url:"test_ajax_action.php?number="+$("#keywords").val(),
		url:"outbound_req_action.php",
		data:{action:'edit', arguments:{
				id: 		        id,
				label_qty:	   	   	label_qty,
				qty:	   	   		qty,
				status_code:		'NEW',	    			    	
				  }
				},
            
            success: function(data){
		//alert(data.message);
	
               if(data.success){
                  $("#message").html("["+data.message+"]");
               }else{
                  $("#message").html("MYSQL-001:Parameter Error "+data.message); 
               }
			$table.bootstrapTable('refresh');
			$table_more_cust_mat_code.bootstrapTable('refresh');
               },
	   error:function(data){
                alert("MYSQL-003:AJAX Update Error - "+ data.responseText);
               }
	});
});
//<-edit 


$('#btn_more_cust_mat_code').click(function(){
	//$table_more_cust_mat_code.bootstrapTable('refresh');
});
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
        "TITLE" => "出库申请单",
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
    
    $id = isset($_GET['{$_action}id']) ? $_GET['{$_action}id'] : "";
    $order_number = isset($_GET['{$_action}order_number']) ? $_GET['{$action}order_number'] : "";
    $item_no = isset($_GET['{$_action}item_no']) ? $_GET['{$action}item_no'] : "";
    $cust_mat_code = isset($_GET['{$_action}cust_mat_code']) ? $_GET['{$_action}cust_mat_code'] : "";
    $qty = isset($_GET['{$_action}cat_code']) ? $_GET['{$action}qty'] : "";
    $base_unit = isset($_GET['{$_action}base_unit']) ? $_GET['{$action}base_unit'] : "";
    $min_packing_qty = isset($_GET['{$_action}min_packing_qty']) ? $_GET['{$action}min_packing_qty'] : "";
    $status_code = isset($_GET['{$_action}mat_grp_code']) ? $_GET['{$action}status_code'] : "";
    
    $_hidden = '';
    $_disabled = '';
    if ($_btn_action == 'new') {
        
        $_hidden = "hidden";
        $_disabled = "disabled='disabled'";
    }
    
    if ($_btn_action == 'edit') {
        
        $_hidden = "hidden";
        $_disabled = "disabled='disabled'";
    }
    
    $_body = "";
    $_body .= " <div class='form-horizontal'>";
    
    //->
    $_body .= "<div class='row' hidden>";
    // --->
    $_body .= " <div class='col-sm-6'>";
    $_body .= " <label for='{$_action}id' class='control-label'>ID</label>";
    $_body .= " <input type='text' class='form-control' id='{$_action}id' name='{$_action}id' value='{$id}'>";
    $_body .= " </div>";
    // <---
    $_body .= "</div>";
    // <-
    
    // ->
    $_body .= "<div class='row' $_hidden> ";
    // --->
    $_body .= " <div class='col-sm-6'>";
    $_body .= " <label for='{$_action}req_number' class='control-label mr-1'>申请单编号</label>";
    $_body .= " <input type='text' class='form-control' id='{$_action}req_number' name='{$_action}req_number' {$_disabled} value='{$req_number}'>";
    $_body .= " </div>";
    // <---
    // --->
    $_body .= " <div class='col-sm-6' hidden>";
    $_body .= " <label for='{$_action}item_no' class='control-label'>行项目号</label>";
    $_body .= " <input type='text' class='form-control' id='{$_action}item_no' name='{$_action}item_no' disabled='disabled' value='{$item_no}'>";
    $_body .= " </div>";
    // <---
    $_body .= "</div>";
    // <-
    
    // ->
    $_body .= "<div class='row'> ";
    // --->
    $_body .= " <div class='col-sm-6'>";
    $_body .= " <label for='{$_action}cust_mat_code' class='control-label'>客户物料代码";
    $_body .= " <button class='btn btn-outline-secondary btn-sm' data-toggle='modal' id='btn_more_cust_mat_code' data-target='#modal_more_cust_mat_code'><i class='fas fa-th'></i></button></label>";
    $_body .= " <input type='text' class='form-control' id='{$_action}cust_mat_code' name='{$_action}cust_mat_code' disabled='disabled' value='{$cust_mat_code}'placeholder='请选择'>";
    $_body .= " </div>";
    // <---
 
    // --->
    $_body .= " <div class='col-sm-6'>";
    $_body .= " <label for='{$_action}label_qty' class='control-label'>标签数</label>";
    $_body .= " <input type='text' class='form-control' id='{$_action}label_qty' name='{$_action}label_qty' value='{$label_qty}'>";
    $_body .= " </div>";
    // <---
    $_body .= "</div>";
    // <-
    
    // ->
    $_body .= "<div class='row'> ";
    // --->
    $_body .= " <div class='col-sm-6'>";
    $_body .= " <label for='{$_action}mat_code' class='control-label'>物料编号</label>";
    $_body .= " <input type='text' class='form-control' id='{$_action}mat_code' name='{$_action}mat_code' {$_disabled}  value='{$mat_code}'>";
    $_body .= " </div>";
    // <---
    
    // --->
    $_body .= " <div class='col-sm-6'>";
    $_body .= " <label for='{$_action}qty' class='control-label'>数量</label>";
    $_body .= " <input type='text' class='form-control' id='{$_action}qty' name='{$_action}qty' {$_disabled} value='{$qty}'>";
    $_body .= " </div>";
    // <---
    
    $_body .= "</div>";
    // <-
    
    //->
    $_body .= "<div class='row'>";
    // --->
    $_body .= " <div class='col-sm-12 '>";
    $_body .= " <label for='{$_action}mat_text' class='control-label'>物料描述</label>";
    $_body .= " <input type='text' class='form-control' id='{$_action}mat_text' name='{$_action}mat_text' value='{$mat_text}' {$_disabled} >";
    $_body .= " </div>";
    // <---
    $_body .= "</div>";
    // <-
        
    //->
    $_body .= "<div class='row'>";
    // --->
    $_body .= $GLOBALS['tag']->build_html_select(prepare_tag_select_common("base_unit", $_btn_action, '基本单位', 'system-unit',"disabled='disabled'"));
    // <---
    // --->
    $_body .= " <div class='col-sm-6'>";
    $_body .= " <label for='{$_action}packing_unit_qty' class='control-label'>包装规格</label>";
    $_body .= " <input type='text' class='form-control' id='{$_action}packing_unit_qty' name='{$_action}packing_unit_qty' disabled='disabled' value='{$packing_unit_qty}'>";
    $_body .= " </div>";
    // <---
    $_body .= "</div>";
    // <-
    // ->
    $_body .= "<div class='row'> ";
    // --->
    $_body .= " <div class='col-sm-6'>";
    $_body .= " <label for='{$_action}min_packing_qty' class='control-label'>最小包装数量</label>";
    $_body .= " <input type='text' class='form-control' id='{$_action}min_packing_qty' name='{$_action}min_packing_qty' disabled='disabled' value='{$min_packing_qty}'>";
    $_body .= " </div>";
    // <---
    // --->
    $_body .= $GLOBALS['tag']->build_html_select(prepare_tag_select_common("packing_unit", $_btn_action, '包装单位', 'system-unit',"disabled='disabled'"));
    // <---
    $_body .= "</div>";
    // <-
    
    // ->
    $_body .= "<div class='row'> ";
    // --->
    $_body .= " <div class='col-sm-6'>";
    $_body .= " <label for='{$_action}delivery_order_number' class='control-label'>交货单</label>";
    $_body .= " <input type='text' class='form-control' id='{$_action}delivery_order_number' name='{$_action}delivery_order_number' disabled='disabled' value='{$delivery_order_number}'>";
    $_body .= " </div>";
    // <---
    // --->
    $_body .= " <div class='col-sm-6'>";
    $_body .= " <label for='{$_action}delivery_item_no' class='control-label'>交货单行项目</label>";
    $_body .= " <input type='text' class='form-control' id='{$_action}delivery_item_no' name='{$_action}delivery_item_no' disabled='disabled' value='{$delivery_item_no}'>";
    $_body .= " </div>";
    // <---
    $_body .= "</div>";
    // <-

    // ->
    $_body .= "<div class='row'> ";
    // --->
    $_body .= " <div class='col-sm-6'>";
    $_body .= " <label for='{$_action}order_number' class='control-label'>订单号</label>";
    $_body .= " <input type='text' class='form-control' id='{$_action}order_number' name='{$_action}order_number' disabled='disabled' value='{$order_number}'>";
    $_body .= " </div>";
    // <---
    //--->
    $sql = "select company_code as code, company_text as text from tb_company where delete_flag = false and active = true  order by company_code ";
    $_body .=$GLOBALS['tag']->build_html_select(prepare_tag_select_special("company_code",$_btn_action,'公司',$sql,"disabled='disabled'"));
    //<---
    $_body .= "</div>";
    // <-
   
    /*
     */
    
    $_body .= "<p id='message'></p>";
    $_body .= "";
    $_body .= " </div>";
    
    $modal_id = "modal_" . $_btn_action;
    $btn_sibmit_id = "btn_" . $_btn_action . "_submit";
    $btn_close_id = "btn_" . $_btn_action . "_close";
    $_array_modal = [
        "ID" => "{$modal_id}",
        "HEADER" => [
            "TITLE" => ($_btn_action == "new") ? "新增":"编辑",
        ],
        "BODY" => [
            "{$_body}"
            ],
            "FOOTER" => [
                "BUTTON" => [
                    "CLOSE" => [
                        "ID" => "{$btn_close_id}",
                        "NAME" => "关闭 [ESC]",
                        "CLASS" => "btn btn-default",
                        "ICON" => "glyphicon .glyphicon-remove",
                        "ENHANCEMENT" => "data-dismiss='modal'"
                    ],
                    "SUBMIT" => [
                        "ID" => "{$btn_sibmit_id}",
                        "NAME" => "提交更改",
                        "CLASS" => "btn btn-primary",
                        "ICON" => "glyphicon .glyphicon-ok",
                        "ENHANCEMENT" => "data-dismiss='modal'"
                    ]
                    ]
                    ]
                    ];
    
    $_html = $GLOBALS['tag']->build_html_modal($_array_modal);
    return $_html;
    
}

/* ---Button New/Edit Modal--- */
// <-
//=====================================================================================================//
/* ---Button More Mat Cust Code Modal--- */
//->
function eventregister_button_more_material($_more){
    $_body = "";
    $_body .= " <div class='form-horizontal'>";
    
    $_body .= " <div class='table-responsive text-sm'>";
    $_body .= " <table id='table_{$_more}' class='table-sm' ";
    $_body .= " data-toggle='table' data-ajax='ajax_{$_more}_request' data-search='true' ";
    $_body .= " data-side-pagination='client' data-pagination='true' searchOnEnterKey='false' ";
    $_body .= " data-click-to-select='true' data-single-select='false' " ;
    $_body .= " data-page-size='10'>";
    
    $_body .= " <thead style='background: #efefef;'>";
    $_body .= " <tr>";
    $_body .= " <th data-checkbox='true'></th>";
    $_body .= " <th data-field='mat_code'>物料编码</th>";
    $_body .= " <th data-field='cust_mat_code'>客户物料编码</th>";
    $_body .= " <th data-field='mat_text'>物料描述</th>";
    $_body .= " <th data-field='rem_label_qty'>标签数</th>";
    $_body .= " <th data-field='rem_qty'>数量</th>";
    $_body .= " <th data-field='base_unit_text'>基本单位</th>";
    $_body .= " <th data-field='packing_unit_qty'>包装规格</th>";
    //$_body .= " <th data-field='min_packing_qty'>最小包装数量</th>";
    $_body .= " </tr>";
    $_body .= " </thead>";
    $_body .= " </table>";
    $_body .= " </div>";
    
    /*
     */
    
    $_body .= "<p id='message'></p>";
    $_body .= "";
    $_body .= " </div>";
    
    $modal_id = "modal_".$_more;
    $btn_sibmit_id = "btn_".$_more."_submit";
    $btn_close_id = "btn_".$_more."_close";
    $_array_modal = [
        "ID"  => "{$modal_id}",
        "HEADER" => [
            "TITLE" =>"物料选择",
        ],
        "BODY"  => [
            "{$_body}"
            ],
            "FOOTER" => [
                "BUTTON" => [
                    "CLOSE" => ["ID" => "{$btn_close_id}",
                    "NAME" => "关闭 [ESC]",
                    "CLASS" => "btn btn-default",
                    "ICON" => "glyphicon .glyphicon-remove",
                    "ENHANCEMENT" =>"data-dismiss='modal'"
    ],
    "SUBMIT" => ["ID" => "{$btn_sibmit_id}",
    "NAME" => "确认选择",
    "CLASS" => "btn btn-primary",
    "ICON" => "glyphicon .glyphicon-ok",
    "ENHANCEMENT" =>"data-dismiss='modal'"
        ]
        
        ]
        ]
        
        ];
    
    $_html = $GLOBALS['tag']->build_html_modal($_array_modal);
    return $_html;
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
};

// ------ Get PangeName ------//
function getPageName()
{
    return basename(__FILE__);
}

// ============Build Page Start=========
// ---Build Toolbar---
echo build_toolbar();
echo eventregister_button('new');
echo eventregister_button('edit');
echo eventregister_button_more_material('more_cust_mat_code');
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
		data-click-to-select="true" data-single-select="false"
		data-page-size="10">

		<thead style="background: #efefef;">
			<tr>
				<th data-checkbox="true"></th>
				<th data-field="id">ID</th>
				<th data-field="req_number" data-width="140" data-sortable="true">出库申请单</th>
				<th data-field="item_no" data-width="10" data-sortable="true">行项目</th>
				<th data-field="company_text" data-sortable="true">公司</th>
				<th data-field="cust_mat_code" data-sortable="true">客户物料编码</th>
				<th data-field="mat_code" data-sortable="true">物料编码</th>
				<th data-field="mat_text" >物料描述</th>
				<th data-field="label_qty" data-editable="true">标签数</th>
				<th data-field="qty">数量</th>
				<th data-field="base_unit_text" >基本单位</th>
				<th data-field="packing_unit_qty" >包装规格</th>				
				<th data-field="status_text" data-formatter="displaycolor" >状态</th>
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
 layui.use('layer', function(){ //独立版的layer无需执行这一句
  var layer = layui.layer; //独立版的layer无需执行这一句
 });
 
	//->Main Table Source
    function ajaxRequest(params){
    	//debugger;
    	$.ajax({
    		url: "outbound_req_action.php",
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
    function ajax_more_cust_mat_code_request(params){
    	var action = '#new_';
        var company_code;
        company_code = $('' + action + 'company_code').val();
        //alert(company_code);
    	//debugger;
    	$.ajax({
    		url: "common_action.php",
    		type: "POST",
    		dataType: "json",
    	    data:{action:'more_outbound_req_mat_code', 
      		      arguments:{
          		      //company_code: company_code,      		      
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
   		$table_more_cust_mat_code = $("#table_more_cust_mat_code"),
    	$release = $("#release");

    //set Visiable
    //$refresh.css({ "display": "none" });

	$add = $("#btn_new"),
	$edit = $("#btn_edit"),
	$delete = $("#btn_delete"),
	$refresh = $("#btn_refresh");	    
    
	
    //按钮可用与否
    $edit.prop('disabled', true);
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
        		if (row.status_code == "NEW" || row.status_code == "TEMP"){
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

	function getSelectionsMore() {
		return $.map($table_more_cust_mat_code.bootstrapTable('getSelections'), function(row) {
			return row; 
		});
	};

	//刷新
	$refresh.on('click', function(){
		$table.bootstrapTable('refresh');
	});
	//添加
	$add.on('click', function(){
		if (checkExist() == true){
			$add.attr('data-target','');
			 layer.msg('当前已存在一单出库申请还未结算，请先完成结算后再申请!',{ time: 3000, icon: 4 });
		}else{
			$add.attr('data-target','#modal_new');
		}
	});	

	$('#modal_new').on('show.bs.modal', function (e) {
		//alert('xxxx');
		//$('#modal_new').hide();

		//or
		//e.preventDefault();

	});


	function checkExist(){
		var isExist = false;
		$.ajax({
			url: "outbound_req_action.php",
		    type:"POST",
		    cache: false,
		    async: false,
		    dataType:"json",
		    data:{action:'check', 
	  		      arguments:{      		      
				      }
					},				
			success: function(data){
					isExist = data.isExist;
				//debugger;
			},
			error: function(data){
			}
	   });
	   return isExist;
	};
	
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
	/*$edit.on('click', function(){
			
			var row = getSelections()[0]; 
		var id = row.id; 
		var name = row.name;
		var price = row.price;

	
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
		
	});*/
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
	function delServer(rows){
		//->
		for(var idx in rows)
		{
	var request=new XMLHttpRequest;
	           $.ajax({
	            type:"POST",
			dataType:"json",
	            //url:"test_ajax_action.php?number="+$("#keywords").val(),
			url:"outbound_req_action.php",
			data:{action:'delete', arguments:{
				  key: rows[idx].id,
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
		}      
		//<-			
	};

	
	$release.on('click', function(){
		var row = getSelections();
		layer.confirm('您是否要批准当前所选的物料的出库请求？', {
		btn: ['是', '否']
		}, function() {
			release(row);
		});
	});


	function getReqNumber(){
		var req_number;
		$.ajax({
			url: "outbound_req_action.php",
		    type:"POST",
		    cache: false,
		    async: false,
		    dataType:"json",
		    data:{action:'req_number', 
	  		      arguments:{      		      
				      }
					},				
			success: function(data){
					req_number = data.req_number;
				//debugger;
			},
			error: function(data){
			}
	   });
	   return req_number;
	};
		

	function release(rows){	
		//check label_qty > 0
		for(var idx in rows){
			if (Number(rows[idx].label_qty) < 1){
				 layer.msg('所选物料中有数量（小于1）为不符批准要求,批准执行失败!');
				 return;
			}
		}

		
		var req_number = getReqNumber();		
		var status_code;	
		for(var idx in rows)
		{
		 
		status_code = 'REL';
		//->
		var request=new XMLHttpRequest;
           $.ajax({
            type:"POST",
            cache: false,
            async: false,
		dataType:"json",
            //url:"test_ajax_action.php?number="+$("#keywords").val(),
		url:"outbound_req_action.php",
		data:{action:'approve', arguments:{
			  key: 		   rows[idx].id,
			  item_no:     Number(idx) + 1,
			  req_number:  req_number,
			  status_code: status_code,
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
			
	};

    $('#table').on( 'click', 'td:has(.editable)', function(e){
        /*
    	var TableData = new Array();
    	 $('#table tr').each(function(row, tr){
    	        TableData[row]={
    	            "taskNo" : $(tr).find('td:eq(0)').text()
    	            , "date" :$(tr).find('td:eq(1)').text()
    	            , "description" : $(tr).find('td:eq(2)').text()
    	            , "status_text" : $(tr).find('td:eq(6)').text()
    	        }    
    	    }); 

		 */
		 

     	/*
        var value = e.key;
        var i = 0;
        var col = $(this).parent().children().index($(this));
        var row = $(this).parent().parent().children().index($(this).parent());
        col++;
       // alert('Row: ' + row + ', Column: ' + col + ' value:' + value);
        var vals = new Array();

        // This gets all rows for the specified column, excluding a "hidden"row at position 1
        $("#table tr:gt(1) td:nth-child(" + col + ")").each(function (item, element) {
            var t = $(this).value;
            var inputs = element.firstChild;
            var cellValue = $(inputs)[0].value;

            if ($.inArray(cellValue, vals) < 0) {
                vals[i] = cellValue;
                i++;
            }
        });

        console.log(vals);

        */
        
       // $(this).find('.editable').editable('toggleDisabled');

        
    });     


    $('#table').on('editable-save.bs.table', function(field, row, oldValue, $el){
        if (oldValue.status_code != 'TEMP' && oldValue.status_code != 'NEW'){
        	$table.bootstrapTable('refresh');
        	layer.msg('出库申请单已批准，更改数量失败！');
        }
        else{
        	if ((Number(oldValue.label_qty) * Number(oldValue.min_packing_qty)) > (Number(oldValue.rem_label_qty) * Number(oldValue.min_packing_qty) + Number(oldValue.qty)) && (Number(oldValue.rem_label_qty) * Number(oldValue.min_packing_qty) + Number(oldValue.qty)) > 0 ){
        		var rem_label_qty = (Number(oldValue.rem_label_qty) * Number(oldValue.min_packing_qty) + Number(oldValue.qty)) / Number(oldValue.min_packing_qty);
        		var rem_qty = Number(oldValue.rem_label_qty) * Number(oldValue.min_packing_qty) + Number(oldValue.qty) ;
        		layer.msg('更改数量失败,超出当前订单剩余数量：['+ rem_qty +'],剩余最大标签数:['+ rem_label_qty +']！');
        		$table.bootstrapTable('refresh');
        		return;
        	}
        

        var qty = Number(oldValue.label_qty) * Number(oldValue.min_packing_qty)
    			
    	var request=new XMLHttpRequest;
    	           $.ajax({
    	            type:"POST",
    			dataType:"json",
    	            //url:"test_ajax_action.php?number="+$("#keywords").val(),
    			url:"outbound_req_action.php",
    			data:{action:'edit', arguments:{
    					id: 		        oldValue.id,
    					label_qty:	   	   	oldValue.label_qty,
    					qty:	   	   		qty,
    					status_code:		oldValue.status_code,			    			    	
    					  }
    					},
    	            
    	            success: function(data){
    			//alert(data.message);
    		
    	               if(data.success){
    	                  $("#message").html("["+data.message+"]");
    	               }else{
    	                  $("#message").html("MYSQL-001:Parameter Error "+data.message); 
    	               }
    				$table.bootstrapTable('refresh');
    				$table_more_cust_mat_code.bootstrapTable('refresh');
    	               },
    		   error:function(data){
    	                alert("MYSQL-003:AJAX Update Error - "+ data.responseText);
    	               }
    		});

        }
        
    }); 
    
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
		

	/*
	function changeQty(value,row,index) {
		var strHtml ='<a class="editable editable-click">'+ value +'</a>';  
        return strHtml;  
	}

    $('#table').on( 'click', 'td:has(.editable)', function (e) {

        e.stopPropagation(); // 阻止事件的冒泡行为

        $(this).find('.editable').editable('show'); // 打开被点击单元格的编辑状态
        
    } );

    */
    	    	
    $(function () {
       // $('#tableOrderRealItems').bootstrapTable('showColumn', 'ShopName');
        $('#table').bootstrapTable('hideColumn', 'id');
      });

    
//<===End      	 	
//}); 	 	
</script>

</html>