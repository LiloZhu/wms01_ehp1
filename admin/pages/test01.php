<!-- Backend Admin Page -->
<!doctype html>
<html>
<head>
<title>User</title>
<!-- Import JQuery -->
<script src="../script/jquery-3.5.1.min.js"></script>
<script src="../script/bootstrap.min.js" ></script>
<script src="../script/jquery.treeview.js" ></script>
<script src="../fontawesome-free-5.14.0-web/js/all.js" ></script>
<script src="../script/common.js"></script>

<!-- Import CSS -->
<link rel="stylesheet" href="../css/bootstrap.min.css" />
<link rel="stylesheet" href="../css/jquery.treeview.css" />
<link rel="stylesheet" href="../css/global.css" />
<link rel="stylesheet" href="../fontawesome-free-5.14.0-web/css/all.css" />

<!-- Current Page CSS Style -->
<style>
caption {
text-align: left;
caption-side: top;
}
</style>

<!-- Current Page Script Action -->
<script>  
$(document).ready(function(){
//===> Begin
tableSelectAll("#tbody_01");
tableSelectAll("#xx1");
//<===End   

$('#btn_more_user_submit').click(function(){
/*
	  var vals = [];

	  $("#tab_01").find("input[name='chk_row[]']:checked").each(function() {
		  vals.push($(this).val());
	  });

	  alert(vals);
	 
	  return vals;
	  var keys = getCheckboxValues('chk_row[]').toString();
	  */
	  var keys = getTableCheckboxValues('#tab_01','chk_row[]').toString();
	  alert(keys);
});



});

</script>
</head>

<button class="btn btn-primary btn-lg" data-toggle="modal" data-target="#modal_more_user">
	开始演示模态框
</button>
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
$obj_cat = new classes\libralies\category();
$obj_type = new classes\libralies\type();
$tag = new classes\BASE\html();
/* ---Page Load--- */
//<-

//=====================================================================================================//

function eventregister_button($_action){
    $_btn_action = $_action;
    $_action = $_action.'_';
    
    $id = isset($_GET['{$_action}id']) ? $_GET['{$_action}id'] : "";
    
    $_hidden = '';
    
    if ($_action == 'edit'){
        if ($active = 'true'){
            $active = 'checked';
        }else{
            $active = '';
        }
        
        if ($delete_flag = 'true'){
            $delete_flag = 'checked';
        }else{
            $delete_flag = '';
        }
        
        $_hidden = "hidden";
    }
    
    
    $_body = "";
    $_body .= " <div class='form-horizontal'>";
    
    //->
    $_body .="<div class='form-row mb-1' hidden> ";
    //--->
    $_body .= " <div class='form-inline'>";
    $_body .= " <label for='{$_action}id' class='control-label mr-1'>ID</label>";
    $_body .= " <input type='text' class='form-control' id='{$_action}id' name='{$_action}id' value='{$id}'>";
    $_body .= " </div>";
    //<---
    $_body .="</div>";
    //<-
    
    $_body .= build_table("","xx1");
  
     /*
     */
   
    $_body .= "<p id='message'></p>";
    $_body .= "";
    $_body .= " </div>";
    
    $modal_id = "modal_".$_btn_action;
    $btn_sibmit_id = "btn_".$_btn_action."_submit";
    $btn_close_id = "btn_".$_btn_action."_close";
    $_array_modal = [
        "ID"  => "{$modal_id}",
        "HEADER" => [
            "TITLE" =>"新增",
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
                    "NAME" => "提交更改",
                    "CLASS" => "btn btn-primary",
                    "ICON" => "glyphicon .glyphicon-ok",
                    "ENHANCEMENT" =>""
                    ]
                    
                    ]
                    ]
                    
                    ];
    
    $_html = $GLOBALS['tag']->build_html_modal($_array_modal);
    return $_html;
}

/* ---Button New/Edit Modal--- */
//<-


function build_table($_tab_id,$_tbody_id){
    if ($_tab_id == "")
    {
        $_tab_id = "tab_01";
    }
    
    if ($_tbody_id == "")
    {
        $_tbody_id = "tbody_01";
    }
    
    $_array_tag =[
        "TABLE" => [
            "ID" => "{$_tab_id}",
            "CLASS" => "table table-sm table-bordered",
            "TITLE" => "用户",
            "TITLE_ENABLE" =>false,
            "SEARCH_ENABLE" =>false,
            "TABLE_NAME" => "tb_division",
            "LIST_ROWS" => "999",
            "PAGE_NAME" => "",
            "SHOW_PAGES"=> "10",
            "PAGING_ENABLE" => false,
            "PAGING_FORMAT" => "2",
            "QUERY_TYPE" => "SQL",
            "SQL" =>"select type_code, type_text from tb_type",
            "SQL_HAS_WHERE"=> false,
        ],
        "THEAD" => [
            "CLASS" => ""
        ],
        "TBODY" => [
            "ID" => "{$_tbody_id}"
        ],
        "COLS" => [
            
        ],
        "ROWS" => [
            
        ],
        "HIDDEN_COLS" =>[
            "id",
            "password",
            "delete_flag",
            "create_at",
            "create_by",
            "change_at",
            "change_by",
            
        ],
        "KEYS" => [
            "id",
        ],
        "ACTION" => [
            "CHECKBOX_ENABLE" => TRUE,
            "BUTTON_ENABLE" => false,
            "BUTTON_COLUMN_NAME" => "操作",
            "CHECKBOX" => [
                "ID" => "selectAll",
                "NAME" =>"选择",
                "CLASS" => "cbox checkbox",
                "ENHANCEMENT" =>""
            ],
            "BUTTON" => [
                "NEW" => ["ID" => "btn_table_new",
                    "NAME" => "新增",
                    "CLASS" => "btn btn-link btn-sm table_action_new",
                    "ICON" => "glyphicon glyphicon-plus",
                    "DATA-TARGET" =>"#modal_new",
                    "ENHANCEMENT" =>""
                ],
                "EDIT" => ["ID" => "btn_table_edit",
                    "NAME" => "编辑",
                    "CLASS" => "btn btn-link btn-sm table_action_edit",
                    "ICON" => "glyphicon glyphicon-edit",
                    "DATA-TARGET" =>"#modal_edit",
                    "ENHANCEMENT" =>""
                ],
                "DELETE" => ["ID" => "btn_table_delete",
                    "NAME" => "删除",
                    "CLASS" => "btn btn-link  btn-sm table_action_delete",
                    "ICON" => "glyphicon glyphicon-edit",
                    "DATA-TARGET" =>"#modal_delete",
                    "ENHANCEMENT" =>""
                ]
            ]
        ],
        "TABLE_SEARCH" => [
            "TEST"  =>"Test Use...",
            "NAME"  => "condition_code",
            "DIV"   => [
                "CLASS" => "form-inline",
                "STYLE" => "",
                "ENHANCEMENT" =>"",
            ],
            "LABEL" => [
                "ID" => "lbl_condition_code",
                "NAME" => "lbl_condition_code",
                "FOR"  => "condition_code",
                "CLASS" => "control-label mr-1",
                "TEXT"  => "选择条件" ,
                "ENHANCEMENT" =>"",
            ],
            "SELECT" => [
                "ID" => "condition_code",
                "NAME" => "condition_code",
                "CLASS" => "form-control",
                "WHERE_USE" =>"tb_user",
                //"SQL" => "select search_code as code, search_text as text from tb_search where where_use ='tb_type' order by seq",
                "ENHANCEMENT" =>"",
            ],
            "T_ENABLE" => true,
            "T_CODE"  => "",
            "T_TEXT" => "--- 请选择 ---",
        ]
        
    ];
    
    $_html = $GLOBALS['tag']->build_html_table($_array_tag);
    return $_html;
}

echo eventregister_button('more_user');
?>

