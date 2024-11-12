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
<title>Material</title>
<!-- CSS -->
<link rel="stylesheet" href="../plugins/bootstrap/css/bootstrap.min.css" />
<link rel="stylesheet" href="../plugins/layui/css/layui.css" />

<!--jquery-->
<script src="../plugins/jquery/jquery.min.js"></script>
<script src="../plugins/fontawesome-free/js/all.min.js"></script>

<!-- Bootstrap 4 -->
<script src="../plugins/bootstrap/js/bootstrap.min.js"></script>
<!-- overlayScrollbars -->
<script src="../plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>

<link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>

<script src="../plugins/moment/moment.min.js"></script>
<script src="../plugins/layui/layui.js"></script>


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
    $add = $("#btn_add"),
    $edit = $("#btn_edit"),
    $delete = $("#btn_delete"),
    $refresh = $("#btn_refresh"),
    $table = $("#table");
	
  /*---Button Action---*/
    $edit.on('click', function(){
    var action = '#edit_';
    var row = getSelections()[0];
     	    
    var action = '#edit_';
    
    $('' + action + 'id').val(row.id);
    $('' + action + 'mat_code').val(row.mat_code);
    $('' + action + 'mat_text').val(row.mat_text);
    $('' + action + 'cust_mat_code').val(row.cust_mat_code);
    $('' + action + 'base_unit').val(row.base_unit);
    $('' + action + 'min_packing_qty').val(row.min_packing_qty);    
    $('' + action + 'packing_unit').val(row.packing_unit);
    $('' + action + 'cat_code').val(row.cat_code);
    $('' + action + 'qc_flag').prop("checked",(row.qc_flag == 1 ? true : false ));
    $('' + action + 'safety_stock').val(row.safety_stock);
    
	//$('#btn_edit_submit').attr("disabled",false);

      
  });	   
    
    
//------------Ajax CRUD------------		
//->New
$('#btn_new_submit').click(function(){
var action = '#new_';
var mat_code = $('' + action + 'mat_code').val();
var mat_text = $('' + action + 'mat_text').val();
var cust_mat_code = $('' + action + 'cust_mat_code').val();  
var base_unit = $("select[name='"+ action.replace("#","") +"base_unit']").val();
var min_packing_qty = $('' + action + 'min_packing_qty').val();
var packing_unit =$("select[name='"+ action.replace("#","") +"packing_unit']").val();
var cat_code =  $("select[name='"+ action.replace("#","") +"cat_code']").val();
var qc_flag = $('' + action + 'qc_flag').prop("checked");
var safety_stock = $('' + action + 'safety_stock').val();  

//防静电 -> QC
if (cat_code == 'B'){
	qc_flag = true;	
}


var isExist = checkMatExists('new');
if (isExist == true){
	layer.msg('物料编号:['+ mat_code +']在当前公司已存，保存失败，请检查！');
	return;
}


var request=new XMLHttpRequest;
           $.ajax({
            type:"POST",
	  dataType:"json",
            //url:"test_ajax_action.php?number="+$("#keywords").val(),
		url:"material_action.php",
		data:{action:'add', 
		  arguments:{      		      
			mat_code:     		mat_code,
			mat_text:     		mat_text,
			cust_mat_code:      cust_mat_code,
			base_unit:			base_unit,
			min_packing_qty:	min_packing_qty,
			packing_unit:     	packing_unit,	
			cat_code:			cat_code,
			qc_flag:			qc_flag,
			safety_stock:		safety_stock,  		    	
			  }
			},
            
            success: function(data){
			//alert(data.message);
			
               if(data.success){
                  $("#message").html("["+data.message+"]");
               }else{
                  $("#message").html("MYSQL-0001:Parameter Error "+data.message); 
               }
			location.reload();
			$("modal_new").modal('hide')
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
var mat_code = $('' + action + 'mat_code').val();
var mat_text = $('' + action + 'mat_text').val();
var cust_mat_code = $('' + action + 'cust_mat_code').val();  
var base_unit = $("select[name='"+ action.replace("#","") +"base_unit']").val();
var min_packing_qty = $('' + action + 'min_packing_qty').val();
var packing_unit =$("select[name='"+ action.replace("#","") +"packing_unit']").val();
var cat_code =  $("select[name='"+ action.replace("#","") +"cat_code']").val();
var qc_flag = $('' + action + 'qc_flag').prop("checked");
var safety_stock = $('' + action + 'safety_stock').val();

//防静电 -> QC
if (cat_code == 'B'){
	qc_flag = true;	
}

var isExist = checkMatExists('edit');

if (isExist == true){
	layer.msg('物料编号:['+ mat_code +']在当前公司已存，保存失败，请检查！');
	return;
}

var request=new XMLHttpRequest;
           $.ajax({
            type:"POST",
		dataType:"json",
            //url:"test_ajax_action.php?number="+$("#keywords").val(),
		url:"material_action.php",
		data:{action:'edit', arguments:{
				id: 		       id,
				mat_code:     		mat_code,
				mat_text:     		mat_text,
				cust_mat_code:      cust_mat_code,
				base_unit:			base_unit,
				min_packing_qty:	min_packing_qty,
				packing_unit:     	packing_unit,
				cat_code:			cat_code,
				qc_flag:			qc_flag, 
				safety_stock:		safety_stock,  	 						
				  }
				},
            
            success: function(data){
		//alert(data.message);
	
               if(data.success){
                  $("#message").html("["+data.message+"]");
               }else{
                  $("#message").html("MYSQL-001:Parameter Error "+data.message); 
               }
		location.reload();
		$("#modal_edit").modal('hide')
               },
	   error:function(data){
                alert("MYSQL-003:AJAX Update Error - "+ data.responseText);
               }
	});
});
//<-edit 

    
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
        "TITLE" => "物料",
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
    $mat_code = isset($_GET['{$_action}mat_code']) ? $_GET['{$action}mat_code'] : "";
    $cust_mat_code = isset($_GET['{$_action}cust_mat_code']) ? $_GET['{$action}cust_mat_code'] : "";
    $mat_text = isset($_GET['{$_action}mat_text']) ? $_GET['{$_action}mat_text'] : "";
    $min_packing_qty = isset($_GET['{$_action}min_packing_qty']) ? $_GET['{$action}min_packing_qty'] : "";
    $base_unit = isset($_GET['{$_action}base_unit']) ? $_GET['{$action}base_unit'] : "";
    $status_code = isset($_GET['{$_action}status_code']) ? $_GET['{$action}status_code'] : "";
    $qc_flag = isset($_GET['{$_action}qc_flag']) ? $_GET['{$action}qc_flag'] : "";
    $safety_stock = isset($_GET['{$_action}safety_stock']) ? $_GET['{$action}safety_stock'] : "";
    $delete_flag = isset($_GET['{$action}delete_flag']) ? $_GET['{$_action}delete_flag'] : "";

    $_hidden = '';

    if ($_action == 'edit') {

        if ($delete_flag = 'true') {
            $delete_flag = 'checked';
        } else {
            $delete_flag = '';
        }

        $_hidden = "hidden";
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
    
    //->
    $_body .= "<div class='row'>";
    // --->
    $_body .= " <div class='col-sm-6 '>";
    $_body .= " <label for='{$_action}mat_code' class='control-label'>物料编号</label>";
    $_body .= " <input type='text' class='form-control' id='{$_action}mat_code' name='{$_action}mat_code' value='{$mat_code}' placeholder='请输入物料编号'>";
    $_body .= " </div>";
    // <---

    // --->
    $_body .= " <div class='col-sm-6 '>";
    $_body .= " <label for='{$_action}cust_mat_code' class='control-label'>客户物料编号</label>";
    $_body .= " <input type='text' class='form-control' id='{$_action}cust_mat_code' name='{$_action}cust_mat_code' value='{$cust_mat_code}' placeholder='请输入客户物料编号'>";
    $_body .= " </div>";
    // <---
    $_body .= "</div>";
    // <-
    
    //->
    $_body .= "<div class='row'>";   
    // --->
    $_body .= " <div class='col-sm-12 '>";
    $_body .= " <label for='{$_action}mat_text' class='control-label'>物料描述</label>";
    $_body .= " <input type='text' class='form-control' id='{$_action}mat_text' name='{$_action}mat_text' value='{$mat_text}' placeholder='请输入物料描述'>";
    $_body .= " </div>";
    // <---
    $_body .= "</div>";
    // <-
    
    //->
    $_body .= "<div class='row'>";
    // --->
    $_body .=$GLOBALS['tag']->build_html_select(prepare_tag_select_common("base_unit",$_btn_action,'基本单位','system-unit',''));
    // <---
    // --->
    $_body .= " <div class='col-sm-6'>";
    $_body .= " <label for='{$_action}safety_stock' class='control-label'>安全库存</label>";
    $_body .= " <input type='text' class='form-control' id='{$_action}safety_stock' name='{$_action}safety_stock' value='{$safety_stock}'>";
    $_body .= " </div>";
    // <---
    // --->
    $_body .= " <div class='col-sm-6'hidden>";
    $_body .= " <label for='{$_action}qc_flag' class='control-label'>标识</label>";
    $_body .= " <div class='form-check'>";
    $_body .= " <label for='{$_action}qc_flag' class='form-check-label'>";
    $_body .= " <input type='checkbox' class='form-check-input' id='{$_action}qc_flag' name='{$_action}qc_flag' >抽样检查</label>";
    $_body .= " </div>";
    $_body .= "</div>";
    // <---
    $_body .= "</div>";
    // <-
    
    //->
    $_body .= "<div class='row'>";
    // --->
    $_body .= " <div class='col-sm-6'>";
    $_body .= " <label for='{$_action}min_packing_qty' class='control-label'>最小包装数量</label>";
    $_body .= " <input type='text' class='form-control' id='{$_action}min_packing_qty' name='{$_action}min_order_qty' value='{$min_packing_qty}'>";
    $_body .= " </div>";
    // <---
    // --->
    $_body .=$GLOBALS['tag']->build_html_select(prepare_tag_select_common("packing_unit",$_btn_action,'包装单位','system-unit',''));
    // <---
    $_body .= "</div>";
    // <-
    
    //->
    $_body .= "<div class='row'>";
    // --->
    $_body .=$GLOBALS['tag']->build_html_select(prepare_tag_select_common("cat_code",$_btn_action,'类别','tb_material-cat_code',''));
    // <---
    // --->
    $_body .= " <div class='col-sm-6'>";
    $_body .= " <label for='{$_action}company_code' class='control-label'>公司代码</label>";
    $_body .= " <input type='text' class='form-control' disabled='disabled' id='{$_action}company_code' name='{$_action}company_code' value='{$GLOBALS['company_code']}'>";
    $_body .= " </div>";
    // <---
    $_body .= "</div>";
    // <-
    
    
    $_body .= "<p id='message'></p>";
    $_body .= "";
    $_body .= " </div>";

    $modal_id = "modal_" . $_btn_action;
    $btn_sibmit_id = "btn_" . $_btn_action . "_submit";
    $btn_close_id = "btn_" . $_btn_action . "_close";
    $_array_modal = [
        "ID" => "{$modal_id}",
        "HEADER" => [
            "TITLE" => "新增"
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
            "CLASS" => "control-label",
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
echo eventregister_button('new');
echo eventregister_button('edit');
// ----Build Table----

// ============Build Page End=========

?>


<table id="example" class="display">
    <thead>
        <tr>
            <th>Name</th>
            <th>Age</th>
            <th>Country</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td contenteditable="true">John</td>
            <td contenteditable="true">28</td>
            <td contenteditable="true">USA</td>
        </tr>
        <tr>
            <td contenteditable="true">Marie</td>
            <td contenteditable="true">22</td>
            <td contenteditable="true">Canada</td>
        </tr>
        <tr>
            <td contenteditable="true">Alex</td>
            <td contenteditable="true">30</td>
            <td contenteditable="true">UK</td>
        </tr>
    </tbody>
</table>

<script>
$(document).ready(function() {
    $('#example').DataTable();

    // Listen for cell editing
    $('#example').on('blur', 'td[contenteditable="true"]', function () {
        var updatedContent = $(this).text();
        console.log('Cell content updated:', updatedContent);

        // Optional: Send the updated content to a server
    });
});
</script>

   
</body>
</html>