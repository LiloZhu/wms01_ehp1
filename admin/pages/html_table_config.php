<!-- Backend Admin Page -->
<!doctype html>
<html>
<head>
<title>User</title>
<!-- Import JQuery -->
<link rel="stylesheet" href="../../plugins/bootstrap/css/bootstrap.min.css" />
<link rel="stylesheet" href="../plugins/fontawesome-free/css/all.min.css">
<!-- Ionicons -->
<link rel="stylesheet" href="../plugins/ionicons/css/ionicons.min.css">
<link rel="stylesheet" href="../../css/global.css" />
<!--jquery-->
<script src="../../plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="../../plugins/bootstrap/js/bootstrap.min.js"></script>
<!-- AnjularJS -->
<script src="../../plugins/angularJS/angular.min.js"></script>
<script src="../../plugins/ngStorage/ngStorage.min.js"></script>

<!--bootstrap-table-->
<link rel="stylesheet" href="../../plugins/bootstrap-table/bootstrap-table.min.css" />
<link rel="stylesheet" href="../../plugins/bootstrap-editable/css/bootstrap-editable.css" />
<script src="../../plugins/bootstrap-table/bootstrap-table.min.js"></script>
<script src="../../plugins/bootstrap-editable/js/bootstrap-editable.min.js"></script>
<link rel="stylesheet" href="../../plugins/layui/css/layui.css" />
<script src="../../plugins/layui/layui.js"></script>
<script src="../../script/common.js"></script>

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
       	onSetModaltoCenter(); 
       	onTableSearchEnter(); 

/*---Button Action---*/
//->New


//<===End      	 	
});
</script>
</head>
<body>

<?php 
//=====================================================================================================//
/* ---Page Load--- */
//->
function autoload ($class_name){
    $class_file = '../../'.str_replace('\\','/',$class_name). '.class.php';
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
$tag = new classes\BASE\html();
/* ---Page Load--- */
//<-

//=====================================================================================================//
/* ---Build Toolbar--- */
//->
function build_toolbar(){
    $_html =  $GLOBALS['tag']->build_html_page_toolbar('','HTML表单配置');
    return $_html;
};
/* ---Build Toolbar--- */
//<-

//=====================================================================================================//
/* ---Build Table--- */
//->
function build_table(){
    $_array_tag =[
        "TABLE" => [
            "ID" => "tab_01",
            "CLASS" => "table table-sm table-bordered",
            "TITLE" => "标题",
            "TITLE_ENABLE" =>false,
            "SEARCH_ENABLE" =>true,
            "TABLE_NAME" => "tb_user",
            "LIST_ROWS" => "9",
            "PAGE_NAME" => "",
            "SHOW_PAGES"=> "10",
            "PAGING_ENABLE" => true,
            "PAGING_FORMAT" => "2",
            "SQL" =>"select * from tb_html_table_config",
        ],
        "THEAD" => [
            "CLASS" => ""
        ],
        "TBODY" => [
            "ID" => "tbody_01"
        ],
        "COLS" => [
            
        ],
        "ROWS" => [
            
        ],
        "HIDDEN_COLS" =>[
            "id",
            "password",
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
            "BUTTON_ENABLE" => TRUE,
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
                "SQL" => "select table_name as code, table_name as text  from information_schema.TABLES where table_schema like 'wms_db' order by table_name;",
                "ENHANCEMENT" =>"",
            ],
            "ONLY_SELECT_AS_VALUE" =>TRUE,
            "ONLY_SELECT_NAME" =>"table_name",
            "T_ENABLE" => TRUE,
            "T_CODE"  => "",
            "T_TEXT" => "--- 请选择 ---",
        ]
        
    ];
    
    $_html = $GLOBALS['tag']->build_html_table($_array_tag);
    return $_html;
}
/* ---Build Table--- */
//--------------------------------------------------------------------//

//============Build Page Start=========
//---Build Toolbar---
echo build_toolbar();
//echo eventregister_button('new');
//echo eventregister_button('edit');
//----Build Table----
echo build_table();

//============Build Page End=========

?>

<!-- End -->
</body>
</html>