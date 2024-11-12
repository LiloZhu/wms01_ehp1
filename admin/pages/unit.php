<!doctype html>
<head>
	<script src="script/common.js"></script>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Unit</title>
<!-- Import JQuery -->
<link rel="stylesheet" href="../../plugins/bootstrap/css/bootstrap.min.css" />
<link rel="stylesheet" href="../../plugins/fontawesome-free/css/all.min.css">
<!-- Ionicons -->
<link rel="stylesheet" href="../../plugins/ionicons/css/ionicons.min.css">
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
<script src="../../js/common.js"></script>
  <script>  
  $(document).ready(function(){
      //===> Begin
  	tableSelectAll("#tbody_01");
     	onSetModaltoCenter();  
		
 	/*---Button Action---*/
    //->New
	$('#btn_new_submit').click(function(){
    var input_code = $('#new_code').val();
    var input_name = $('#new_name').val();
    var input_description = $('#new_description').val();

    var request=new XMLHttpRequest;
           $.ajax({
            type:"POST",
            dataType:"json",
            //url:"test_ajax_action.php?number="+$("#keywords").val(),
			url:"unit_action.php",
		    data:{action:'add', arguments:{
			      code: input_code,
			      name: input_name,
			      descripton: input_description}},
            
            success: function(data){
		
                   if(data.success){
                      $("#message").html("["+data.message+"]");
                   }else{
                      $("#message").html("parameter error "+data.message); 
                   }
    				location.reload();
    				$("modal_new").modal('hide')
                },
    			error:function(data){
                    alert("encounter error");
                }
    		});
	   });
	 //<-New 

    //->edit
		$('#btn_edit').click(function(){
			$('#edit_code').val(getSelectedRowFieldValue('#tab_01','代码'));
			$('#edit_name').val(getSelectedRowFieldValue('#tab_01','单位名称'));
			$('#edit_description').val(getSelectedRowFieldValue('#tab_01','描述'));
		});
		
    	$('#btn_edit_submit').click(function(){
        var edit_code = $('#edit_code').val();
        var edit_name = $('#edit_name').val();
        var edit_description = $('#edit_description').val();
    
        var request=new XMLHttpRequest;
               $.ajax({
                type:"POST",
                dataType:"json",
                //url:"test_ajax_action.php?number="+$("#keywords").val(),
    			url:"unit_action.php",
    		    data:{action:'edit', arguments:{
    			      code: edit_code,
    			      name: edit_name,
    			      descripton: edit_description,
				      currentPage: getQueryString("page"),
				      listRows: 10}},
                
                success: function(data){
    				//alert(data.message);
    	   			
                   if(data.success){
                      $("#message").html("["+data.message+"]");
                   }else{
                      $("#message").html("参数错误"+data.message); 
                   }
    				location.reload();
    				$("#modal_edit").modal('hide')
                },
    			error:function(data){
                    alert("出现错误");
                }

    		});
    	});
// 	   //<-edit

    
    //-->    
    $('#btn_delete').click(function(){

			var _role_menu = getCheckboxValues('chk_row[]').toString();

			var _array_role_menu = new Array();
			_array_role_menu = _role_menu.split(",");

			for(var item in _array_role_menu)
			{
				//alert(_array_role_menu[item]);
				var _code = _array_role_menu[item];
				//->
		        var request=new XMLHttpRequest;
                   $.ajax({
        	            type:"POST",
        	            dataType:"json",
        	            //url:"test_ajax_action.php?number="+$("#keywords").val(),
        				url:"unit_action.php",
        			    data:{action:'delete', arguments:{
        				      code: _code,
        				      currentPage: getQueryString("page"),
        				      listRows: 10}},
        	            success: function(data){
        					//alert(data.message);
        		   		   //alert(data.page);
        	               if(data.success){
        	                  $("#message").html("["+data.message+"]");
        	               }else{
        	                  $("#message").html("参数错误"+data.message); 
        	               }
        				   //location.reload();
        				   window.location='unit.php?page='+data.page;
        	            },
        				error:function(data){
        	                alert("出现错误");
        	            }
        			});	
   
                    
					//<-			
			}
	
    	});
	//<--
         
  });
</script>    
</head>
<body>

<?php 
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

$obj = new classes\BASE\page();
$ado = new classes\DB\mysql_helper();

//---------------Build Toolbar-------------------- 
$_array_toolbar = [
    "TITLE" =>"单位",
    "BUTTON" => [
        "NEW" => ["ID" => "btn_new",
            "NAME" => "新增",
            "DATA-TARGET" =>"#modal_new",
            "CLASS" => "btn top btn-primary btn_modal",
            "ICON" => "glyphicon glyphicon-plus",
        ],
        "EDIT" => ["ID" => "btn_edit",
            "NAME" => "编辑",
            "DATA-TARGET" =>"#modal_edit",
            "CLASS" => "btn btn-success btn_modal",
            "ICON" => "glyphicon glyphicon-edit",
        ],
        "DELETE" => ["ID" => "btn_delete",
            "NAME" => "删除",
            "DATA-TARGET" =>"#modal_delete",
            "CLASS" => "btn btn-danger",
            "ICON" => "glyphicon glyphicon-remove",
        ],
        "REFRESH" => ["ID" => "btn_refresh",
            "NAME" => "刷新",
            "DATA-TARGET" =>"#modal_refresh",
            "CLASS" => "btn btn-warning",
            "ICON" => "glyphicon glyphicon-refresh",
        ],
        "EXPORT" => ["ID" => "btn_export",
            "NAME" => "导出",
            "DATA-TARGET" =>"#modal_export",
            "CLASS" => "btn btn-info",
            "ICON" => "glyphicon glyphicon-export"
        ]
    ]
];

$_html = $obj->build_action_toolbar($_array_toolbar);
echo $_html;

//---------------Build Table-------------------- 
echo " <div id='dynamic_tab'>";
echo build_table();
echo " </div>";

//=====================================================================================================//
/* ---Button New Modal--- */
//->
function eventregister_button_new(){

$_code = isset($_GET['new_code']) ? $_GET['new_code'] : "";
$_name = isset($_GET['new_name']) ? $_GET['new_name'] : "";
$_description = isset($_GET['description']) ? $_GET['description'] : "";

$_body = "";
$_body .= " <form class='form-horizontal' role='form'>";
//--->
$_body .= " <div class='form-group'>";
$_body .= " <label for='code' class='col-sm-3 control-label'>代码</label>";
$_body .= " <div class='col-sm-9'>";
$_body .= " <input type='text' class='form-control' id='new_code' name='new_code' value='{$_code}' placeholder='请输入代码'>";
$_body .= " </div>";
$_body .= " </div>";
//<---
//--->
$_body .= " <div class='form-group'>";
$_body .= " <label for='name' class='col-sm-3 control-label'>单位名称</label>";
$_body .= " <div class='col-sm-9'>";
$_body .= " <input type='text' class='form-control' id='new_name' name='new_name' value='{$_name}' placeholder='请输入单位名称'>"; 
$_body .= " </div>";
$_body .= " </div>";
//<---
//--->
$_body .= " <div class='form-group'>";
$_body .= " <label for='description' class='col-sm-3 control-label'>描述</label>";
$_body .= " <div class='col-sm-9'>";
$_body .= " <input type='text' class='form-control' id='new_description' name='new_description' value='{$_description}' placeholder='请输入描述'>";
$_body .= " </div>";
$_body .= " </div>";
//<---
$_body .= "<p id='message'></p>";
$_body .= "";
$_body .= " </form>";

$_array_modal = [
    "ID"  => "modal_new",
    "HEADER" => [
        "TITLE" =>"新增",
    ],
    "BODY"  => [
        "{$_body}"
        ],
        "FOOTER" => [
            "BUTTON" => [
                "CLOSE" => ["ID" => "btn_new_close",
                    "NAME" => "关闭 [ESC]",
                    "CLASS" => "btn btn-default",
                    "ICON" => "glyphicon .glyphicon-remove",
                    "ENHANCEMENT" =>"data-dismiss='modal'"
                ],
                "SUBMIT" => ["ID" => "btn_new_submit",
                    "NAME" => "提交更改",
                    "CLASS" => "btn btn-primary",
                    "ICON" => "glyphicon .glyphicon-ok",
                    "ENHANCEMENT" =>""
                ]
                
            ]
        ]
        
        ];

$_html = $GLOBALS['obj']->build_modal($_array_modal);
return $_html;
}
/* ---Button New Modal--- */
//<-


//=====================================================================================================//
/* Edit */

$edit_code = isset($_GET['edit_code']) ? $_GET['edit_code'] : "";
$edit_name = isset($_GET['edit_name']) ? $_GET['edit_name'] : "";
$edit_description = isset($_GET['edit_description']) ? $_GET['edit_description'] : "";

$_body = "";
$_body .= " <form class='form-horizontal' role='form'>";
//--->
$_body .= " <div class='form-group'>";
$_body .= " <label for='code' class='col-sm-3 control-label'>代码</label>";
$_body .= " <div class='col-sm-9'>";
$_body .= " <input type='text' disabled='disabled' class='form-control' id='edit_code' name='edit_code' value='{$edit_code}' placeholder='请输入代码'>";
$_body .= " </div>";
$_body .= " </div>";
//<---
//--->
$_body .= " <div class='form-group'>";
$_body .= " <label for='name' class='col-sm-3 control-label'>单位名称</label>";
$_body .= " <div class='col-sm-9'>";
$_body .= " <input type='text' class='form-control' id='edit_name' name='edit_name' value='{$edit_name}' placeholder='请输入单位名称'>";
$_body .= " </div>";
$_body .= " </div>";
//<---
//--->
$_body .= " <div class='form-group'>";
$_body .= " <label for='description' class='col-sm-3 control-label'>描述</label>";
$_body .= " <div class='col-sm-9'>";
$_body .= " <input type='text' class='form-control' id='edit_description' name='edit_description' value='{$edit_description}' placeholder='请输入描述'>";
$_body .= " </div>";
$_body .= " </div>";
//<---
$_body .= "<p id='message'></p>";
$_body .= "";
$_body .= " </form>";

$_array_modal = [
    "ID"  => "modal_edit",
    "HEADER" => [
        "TITLE" =>"编辑",
    ],
    "BODY"  => [
        "{$_body}"
        ],
        "FOOTER" => [
            "BUTTON" => [
                "CLOSE" => ["ID" => "btn_edit_close",
                    "NAME" => "关闭 [ESC]",
                    "CLASS" => "btn btn-default",
                    "ICON" => "glyphicon .glyphicon-remove",
                    "ENHANCEMENT" =>"data-dismiss='modal'"
                ],
                "SUBMIT" => ["ID" => "btn_edit_submit",
                    "NAME" => "提交更改",
                    "CLASS" => "btn btn-primary",
                    "ICON" => "glyphicon .glyphicon-ok",
                    "ENHANCEMENT" =>""
                ]
                
            ]
        ]
        
        ];

$_html = $obj->build_modal($_array_modal);
echo $_html;


?>

<?php 
//=====================================================================================================//
/* Build Table */
function build_table(){
    $_array_table =[
        "TABLE" => [
            "ID" => "tab_01",
            "CLASS" => "table",
            "TITLE" => "标题",
            "TITLE_ENABLE" =>false,
            "TABLE_NAME" => "tb_unit"
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
        "KEYS" => [
            "role_id",
            "menu_id",
        ],
        "ACTION" => [
            "CHECKBOX" => [
                "ENABLE" => true,
                "ID" => "selectAll",
                "NAME" =>"选择",
                "CLASS" => "cbox checkbox",
                "ENHANCEMENT" =>""
            ],
            "BUTTON" => [
                "NEW" => ["ID" => "btn_new",
                    "NAME" => "新增",
                    "CLASS" => "btn top btn-primary",
                    "ICON" => "glyphicon glyphicon-plus",
                    "ENHANCEMENT" =>""
                ],
                "EDIT" => ["ID" => "btn_edit",
                    "NAME" => "编辑",
                    "CLASS" => "btn btn-success",
                    "ICON" => "glyphicon glyphicon-edit",
                    "ENHANCEMENT" =>""
                ],
                "DELETE" => ["ID" => "btn_delete",
                    "NAME" => "删除",
                    "CLASS" => "btn btn-danger",
                    "ICON" => "glyphicon glyphicon-remove",
                    "ENHANCEMENT" =>""
                ]
            ]
        ]
        
    ];
    
    
    
    $sql = "select count(*) from tb_unit";
    $listRows = 9;
    $page_name = basename(__FILE__);
    $page_limit = $GLOBALS['obj']->setPage($page_name,$listRows,$sql);
    
    $sql = "select * from tb_unit {$page_limit};";
    $_data =$GLOBALS['ado']->Retrieve($sql);
    if ((isset($_data[0])?isset($_data[0]):'') != ''){
    //loading Columns
    array_push($_array_table['COLS'],array_keys($_data[0]));
    //loading Rows
    array_push($_array_table['ROWS'], $_data);
    
    $_html = $GLOBALS['obj']->build_table($_array_table);
    
    
    return $_html;
    }
}
?>

</body>
</html>
