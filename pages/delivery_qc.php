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
<title>Delivery QC</title>
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
        "TITLE" => "抽样检查",
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
    $ref_order_number = isset($_GET['{$_action}ref_order_number']) ? $_GET['{$action}ref_order_number'] : "";
    $ref_item_no = isset($_GET['{$_action}ref_item_no']) ? $_GET['{$action}ref_item_no'] : "";
    $cust_mat_code = isset($_GET['{$_action}cust_mat_code']) ? $_GET['{$_action}cust_mat_code'] : "";
    $qty = isset($_GET['{$_action}cat_code']) ? $_GET['{$action}qty'] : "";
    $base_unit = isset($_GET['{$_action}base_unit']) ? $_GET['{$action}base_unit'] : "";
    $min_packing_qty = isset($_GET['{$_action}min_packing_qty']) ? $_GET['{$action}min_packing_qty'] : "";
    $status_code = isset($_GET['{$_action}mat_grp_code']) ? $_GET['{$action}status_code'] : "";
    
    $_hidden = "hidden";
    $_disabled = '';
    
    if ($_btn_action == 'edit') {
        $_hidden = '';
        $_disabled = "disabled='disabled'";
    }
    
    $_body = "";
    $_body .= " <div class='form-horizontal'>";
    
    //->
    $_body .= "<div class='row' hidden>";
    // --->
    $_body .= " <div class='col-sm-6 '>";
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
    $_body .= " <label for='{$_action}order_number' class='control-label mr-1'>交货单号</label>";
    $_body .= " <input type='text' class='form-control' id='{$_action}order_number' name='{$_action}order_number' disabled='disabled' value='{$order_number}' placeholder='请选择'>";
    $_body .= " </div>";
    // <---
    // --->
    $_body .= " <div class='col-sm-6'>";
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
    $_body .= " <label for='{$_action}ref_order_number' class='control-label mr-1'>订单编号";
    $_body .= " <button class='btn btn-outline-secondary btn-sm' data-toggle='modal' id='btn_more_order_mat_code' data-target='#modal_more_order_mat_code'><i class='fas fa-th'></i></button></label>";
    $_body .= " <input type='text' class='form-control' id='{$_action}ref_order_number' name='{$_action}ref_order_number' disabled='disabled' value='{$ref_order_numberr}' placeholder='请选择'>";
    $_body .= " </div>";
    // <---
    // --->
    $_body .= " <div class='col-sm-6'>";
    $_body .= " <label for='{$_action}ref_item_no' class='control-label'>订单行项目号</label>";
    $_body .= " <input type='text' class='form-control' id='{$_action}ref_item_no' name='{$_action}ref_item_no' disabled='disabled' value='{$ref_item_no}'>";
    $_body .= " </div>";
    // <---
    $_body .= "</div>";
    // <-
    
    // ->
    $_body .= "<div class='row'> ";
    // --->
    $_body .= " <div class='col-sm-6'>";
    $_body .= " <label for='{$_action}mat_code' class='control-label'>物料代码</label>";
    $_body .= " <input type='text' class='form-control' id='{$_action}mat_code' name='{$_action}mat_code' disabled='disabled' value='{$mat_code}'>";
    $_body .= " </div>";
    // <---
    // --->
    $_body .= " <div class='col-sm-6'>";
    $_body .= " <label for='{$_action}cust_mat_code' class='control-label'>客户物料代码</label>";
    $_body .= " <input type='text' class='form-control' id='{$_action}cust_mat_code' name='{$_action}cust_mat_code' disabled='disabled' value='{$cust_mat_code}'>";
    $_body .= " </div>";
    // <---
    $_body .= "</div>";
    // <-
    
    // ->
    $_body .= "<div class='row'> ";
    // --->
    $_body .= " <div class='col-sm-12'>";
    $_body .= " <label for='{$_action}mat_text' class='control-label'>物料描述</label>";
    $_body .= " <input type='text' class='form-control' id='{$_action}mat_text' name='{$_action}mat_text' disabled='disabled' value='{$mat_text}'>";
    $_body .= " </div>";
    // <---
    $_body .= "</div>";
    // <-
    
    // ->
    $_body .= "<div class='row'> ";
    // --->
    $_sql = "select location_code as code, location_text as text from tb_location;";
    $_body .=$GLOBALS['tag']->build_html_select(prepare_tag_select_special("location_code",$_btn_action,'仓位',$_sql,''));
    // <---
    // --->
    $_body .= " <div class='col-sm-6'>";
    $_body .= " <label for='{$_action}qc_flag' class='control-label'>标识</label>";
    $_body .= " <div class='form-check'>";
    $_body .= " <label for='{$_action}qc_flag' class='form-check-label'>";
    $_body .= " <input type='checkbox' class='form-check-input' id='{$_action}qc_flag' name='{$_action}qc_flag' >抽样检查</label>";
    $_body .= " </div>";
    // <---
    $_body .= "</div>";
    $_body .= "</div>";
    // <-
    
    // ->
    $_body .= "<div class='row'> ";
    // --->
    $_body .= " <div class='col-sm-6'>";
    $_body .= " <label for='{$_action}qty' class='control-label'>数量</label>";
    $_body .= " <input type='text' class='form-control' id='{$_action}qty' name='{$_action}qty' value='{$qty}'>";
    $_body .= " </div>";
    // <---
    // --->
    $_body .= $GLOBALS['tag']->build_html_select(prepare_tag_select_common("base_unit", $_btn_action, '基本单位', 'system-unit',"disabled='disabled'"));
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
    $_body .= " data-side-pagination='server' data-pagination='true' searchOnEnterKey='false' ";
    $_body .= " data-click-to-select='true' data-single-select='true'";
    $_body .= " data-page-size='10'>";
    
    $_body .= " <thead style='background: #efefef;'>";
    $_body .= " <tr>";
    $_body .= " <th data-checkbox='true'></th>";
    $_body .= " <th data-field='order_number'>订单编码</th>";
    $_body .= " <th data-field='item_no'>行项目</th>";
    $_body .= " <th data-field='mat_code'>物料编码</th>";
    $_body .= " <th data-field='cust_mat_code'>客户物料编码</th>";
    $_body .= " <th data-field='mat_text'>物料描述</th>";
    $_body .= " <th data-field='order_qty'>订单数量</th>";
    $_body .= " <th data-field='dn_qty'>已开交货单数量</th>";
    $_body .= " <th data-field='rem_qty'>剩余数量</th>";
    $_body .= " <th data-field='base_unit_text'>基本单位</th>";
    $_body .= " <th data-field='min_packing_qty'>最小包装数量</th>";
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
}
;

function setMail($_action,$_row){
    
}

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
echo eventregister_button_more_material('more_order_mat_code');
// ----Build Table----

// ============Build Page End=========

?>
<div id="toolbar" class="btn-group">
	<button class="btn btn-outline-primary" id="release"><i class="fas fa-user-check"></i>批准</button>
	<button class="btn btn-outline-danger" id="reject"><i class="fas fa-not-equal"></i>拒绝</button>
</div>
<div class="table-responsive">
	<table id="table" class="table-sm" data-toolbar="#toolbar"
		data-toggle="table" data-ajax="ajaxRequest" data-search="true"
		data-side-pagination="client" data-pagination="true" searchOnEnterKey="false"
		data-click-to-select="true" data-single-select="true"  data-row-style="rowStyle"
		data-page-size="10">

		<thead style="background: #efefef;">
			<tr>
				<th data-checkbox="true"></th>
				<th data-field="id">ID</th>
				<th data-field="order_number" data-width="140" data-sortable="true">交货单</th>
				<th data-field="item_no" data-width="10" data-sortable="true">行项目</th>
				<th data-field="mat_code" data-sortable="true">物料编码</th>
				<th data-field="cust_mat_code" data-sortable="true">客户物料编码</th>
				<th data-field="mat_text" >物料描述</th>
				<th data-field="location_text" >仓位</th>
				<th data-field="qty" >数量</th>
				<th data-field="order_qty">订单数量</th>
				<th data-field="dn_qty" >已开交货单数量</th>
				<th data-field="rem_qty" >剩余交货数量</th>
				<th data-field="ref_order_number">参考订单</th>
				<th data-field="ref_item_no">参考行项目</th>
				<th data-field="packing_unit_qty">包装规格</th>	
				<th data-field="base_unit_text" >基本单位</th>
				<!--  
				<th data-field="min_packing_qty" >最小包装数量</th>
				<th data-field="packing_unit_text" >包装单位</th>
				-->
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
    		url: "delivery_qc_action.php",
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
    //$release.css({ "display": "none" });
    $add.css({ "display": "none" });
    $edit.css({ "display": "none" });
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
        		if (row.status_code == "CHK"){
        			$release.prop('disabled', false);
        			$reject.prop('disabled', false);
        			$edit.prop('disabled', false);
        			$delete.prop('disabled', false);
        		}else{
        			 $release.prop('disabled', true);
        			 $reject.prop('disabled', true);
         			 $edit.prop('disabled', true);
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

	//编辑
	$edit.on('click', function(){
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
			releaseMail(row,'REL') 
			location.reload();
		});
	});

	$reject.on('click', function(){
		var row = getSelections();
		layer.confirm('您是否要拒绝当前抽检交货单 [' + row[0].order_number + '] 的检查？', {
		btn: ['是', '否']
		}, function() {
			reject(row);
			releaseMail(row,'REJ')
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
		url:"delivery_qc_action.php",
		data:{action:'approve', arguments:{
			  key		  :    row[0].id,
			  order_number:	   row[0].order_number,
			  item_no:	   	   row[0].item_no,
			  status_code:	   'CONFIRM',
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

	function releaseMail(row,status_code){
		//->
		var request=new XMLHttpRequest;
           $.ajax({
            type:"POST",
		dataType:"json",
            //url:"test_ajax_action.php?number="+$("#keywords").val(),
		url:"mail_action.php",
		data:{action:'delivery_order_qc_approve', arguments:{
			  order_number:	   row[0].order_number,
			  item_no:	   	   row[0].item_no,
			  status_code:	   status_code,
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
		}else if(value == "已确认"){
		var a = '<span style="color:green">'+value+'</span>';
		}else if(value == "已批准"){
			var a = '<span style="color:green">'+value+'</span>';	
		}else if(value == "已批准签收"){
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