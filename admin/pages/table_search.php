<!-- Backend Admin Page -->
<!doctype html>
<html>
<head>
<title>Role Menu</title>
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

/*---Button Action---*/
//->New
 $('#btn_new_submit').click(function(){
  //var _storage_code = $("select[name='new_storage_code']").val();	
  var _search_code = $('#new_search_code').val();
  var _search_text = $('#new_search_text').val();
  var _where_use = $('#new_where_use').val();
  var _seq = $('#new_seq').val();

  var request=new XMLHttpRequest;
           $.ajax({
            type:"POST",
          dataType:"json",
            //url:"test_ajax_action.php?number="+$("#keywords").val(),
			url:"table_search_action.php",
		    data:{action:'add', 
  		      arguments:{      		      
  		    	search_code: _search_code,
  		    	search_text: _search_text,
			    where_use:   _where_use,    			      
			    seq: 		 _seq
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
                alert("MYSQL-0002:Ajax Create Error");
            }
		});
	});
   //<-New 
   
    	$('#btn_edit_submit').click(function(){
        var _id = $('#edit_id').val();
        var _search_code = $('#edit_search_code').val();
        var _search_text = $('#edit_search_text').val();
        var _where_use = $('#edit_where_use').val();
        var _seq = $('#edit_seq').val();
    
        var request=new XMLHttpRequest;
               $.ajax({
                type:"POST",
                dataType:"json",
                //url:"test_ajax_action.php?number="+$("#keywords").val(),
    			url:"table_search_action.php",
    		    data:{action:'edit', arguments:{
    			      id: 		  _id,
    	  		    	search_code: _search_code,
    	  		    	search_text: _search_text,
    				    where_use:   _where_use,    			      
    				    seq: 		 _seq
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
                alert("MYSQL-003:AJAX Update Error");
               }
			});
		});
	 //<-edit 

    
    //-->delete    
    $('#btn_delete').click(function(){
		var _condition = '';
		var _keys = getCheckboxValues('chk_row[]').toString();

		var _array_key = new Array();
		_array_key = _keys.split(",");

		for(var item in _array_key)
		{
			//alert(_array_role_menu[item]);
			var _key = _array_key[item];
			//->
	        var request=new XMLHttpRequest;
               $.ajax({
    	            type:"POST",
    	            dataType:"json",
    	            //url:"test_ajax_action.php?number="+$("#keywords").val(),
    				url:"table_search_action.php",
    			    data:{action:'delete', arguments:{
    			    	  key: _key
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
    				   //location.reload();
    				   if (data.page > 0){
        			     _condition = '?page='+data.page;
    				   }else{
        			     _condition = '';
        			   }
    				   window.location='table_search.php' + _condition;
    	           	 },
						error:function(data){
        	                alert("encounter error");
        	            }
        			});	
                    
					//<-			
				}
		
	    	});
		//<--Delete
		  
$('#btn_edit').click(function(){
	$('#edit_id').val(getSelectedRowFieldValue('#tab_01','id'));
	$('#edit_search_code').val(getSelectedRowFieldValue('#tab_01','search_code'));
	$('#edit_search_text').val(getSelectedRowFieldValue('#tab_01','search_text'));
	
	$('#btn_edit_submit').attr("disabled",($('#edit_id').val() == '' ? true : false ));		
});

$('.table_action_new').click(function(){
	var row = $(this).parent().parent().find("td");	
});

$('.table_action_edit').click(function(){
	var row = $(this).parent().parent().find("td");
	$('#edit_id').val(row.eq(1).text());
	$('#edit_search_code').val(row.eq(2).text());
	$('#edit_search_text').val(row.eq(3).text());
	$('#edit_where_use').val(row.eq(4).text());
	$('#edit_seq').val(row.eq(5).text());
	
	$('#btn_edit_submit').attr("disabled",($('#edit_id').val() == '' ? true : false ));		
});


$('.table_action_delete').click(function(){
	var row = $(this).parent().parent().find("td");	
	var _key = row.eq(1).text();
	//->
    var request=new XMLHttpRequest;
           $.ajax({
            type:"POST",
            dataType:"json",
            //url:"test_ajax_action.php?number="+$("#keywords").val(),
			url:"table_search_action.php",
		    data:{action:'delete', arguments:{
		    	  key: _key
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
			   //location.reload();
			   if (data.page > 0){
			     _condition = '?page='+data.page;
			   }else{
			     _condition = '';
			   }
			   window.location='table_search.php' + _condition;
           	 },
				error:function(data){
	                alert("encounter error");
	            }
			});		
});

$('#btn_table_search').click(function(){
	//$('#table_search_value').val('xxxx');
});
	
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
    $_array_toolbar = [
        "TITLE" =>"表查询设置",
        "BUTTON" => [
            "NEW" => ["ID" => "btn_new",
                "NAME" => "新增",
                "DATA-TARGET" =>"#modal_new",
                "CLASS" => "btn top btn-primary",
                "ICON" => "glyphicon glyphicon-plus",
            ],
            "EDIT" => ["ID" => "btn_edit",
                "NAME" => "编辑",
                "DATA-TARGET" =>"#modal_edit",
                "CLASS" => "btn btn-success",
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
    
    $_html =  $GLOBALS['tag']->build_html_page_toolbar($_array_toolbar,'');
    return $_html;
};
/* ---Build Toolbar--- */

//=====================================================================================================//
/* ---Button New Modal--- */
//->
function eventregister_button_new(){
    $_search_code = isset($_GET['new_search_code']) ? $_GET['new_search_code'] : "";
    $_search_text = isset($_GET['new_search_text']) ? $_GET['new_search_text'] : "";
    $_where_use = isset($_GET['new_where_use']) ? $_GET['new_where_use'] : "";
    $_seq = isset($_GET['new_seq']) ? $_GET['new_seq'] : "";
    
    $_body = "";
    $_body .= " <form class='form-horizontal'>";
    
    //->
    $_body .="<div class='form-row mb-1'> ";
    //--->
    $_body .= " <div class='form-inline'>";
    $_body .= " <label for='new_search_code' class='control-label mr-1'>代码</label>";
    $_body .= " <input type='text' class='form-control' style='width:120px' id='new_search_code' name='new_search_code' value='{$_search_code}' placeholder='请输入代码'>";
    $_body .= " </div>";
    //<---
    //--->
    $_body .= " <div class='form-inline'>";
    $_body .= " <label for='new_search_text' class='control-label mr-1'>名称</label>";
    $_body .= " <input type='text' class='form-control' style='width:300px' id='new_search_text' name='new_search_text' value='{$_search_text}' placeholder='请输入名称'>";
    $_body .= " </div>";
    //<---
    $_body .="</div>";
    //<-
    
     //->
     $_body .="<div class='form-row mb-1'> ";
     //--->
     $_body .= " <div class='form-inline'>";
     $_body .= " <label for='new_where_use' class='control-label mr-1'>用于</label>";
     $_body .= " <input type='text' class='form-control' style='width:200px' id='new_where_use' name='new_where_use' value='{$_where_use}' placeholder='请输入用于'>";
     $_body .= " </div>";
     //<---
     //--->
     $_body .= " <div class='form-inline'>";
     $_body .= " <label for='new_seq' class='control-label mr-1'>序号</label>";
     $_body .= " <input type='text' class='form-control' style='width:60px' id='new_seq' name='new_seq' value='{$_seq}' placeholder='序号'>";
     $_body .= " </div>";
     //<---
     $_body .="</div>";
     //<-
     /*
     */
    
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
                    "SUBMIT" => ["ID" => "btn_new_submit",
                        "NAME" => "提交更改",
                        "CLASS" => "btn btn-primary",
                        "ICON" => "glyphicon .glyphicon-ok",
                        "ENHANCEMENT" =>""
                    ],
                    "CLOSE" => ["ID" => "btn_new_close",
                        "NAME" => "关闭 [ESC]",
                        "CLASS" => "btn btn-default",
                        "ICON" => "glyphicon .glyphicon-remove",
                        "ENHANCEMENT" =>"data-dismiss='modal'"
                    ]
                    
                ]
            ]
            
            ];
    
    $_html = $GLOBALS['tag']->build_html_modal($_array_modal);
    return $_html;
}
/* ---Button New Modal--- */
//<-

//=====================================================================================================//
/* ---Button Edit Modal--- */
//->
function eventregister_button_edit(){
    $_id = isset($_GET['edit_id']) ? $_GET['edit_id'] : "";
    $_search_code = isset($_GET['edit_search_code']) ? $_GET['edit_search_code'] : "";
    $_search_text = isset($_GET['edit_search_text']) ? $_GET['edit_search_text'] : "";
    $_where_use = isset($_GET['edit_where_use']) ? $_GET['edit_where_use'] : "";
    $_seq = isset($_GET['edit_seq']) ? $_GET['edit_seq'] : "";
    
    $_body = "";
    $_body .= " <form class='form-horizontal'>";
    
    //->
    $_body .="<div class='form-row mb-1' hidden> ";
    //--->
    $_body .= " <div class='form-inline'>";
    $_body .= " <label for='edit_id' class='control-label mr-1'>ID</label>";
    $_body .= " <input type='text' class='form-control' id='edit_id' name='edit_id' value='{$_id}'>";
    $_body .= " </div>";
    //<---
    $_body .="</div>";
    //<-
    
    //->
    $_body .="<div class='form-row mb-1'> ";
    //--->
    $_body .= " <div class='form-inline'>";
    $_body .= " <label for='edit_search_code' class='control-label mr-1'>代码</label>";
    $_body .= " <input type='text' class='form-control' style='width:120px' id='edit_search_code' name='edit_search_code' value='{$_search_code}' placeholder='请输入代码'>";
    $_body .= " </div>";
    //<---
    //--->
    $_body .= " <div class='form-inline'>";
    $_body .= " <label for='edit_search_text' class='control-label mr-1'>名称</label>";
    $_body .= " <input type='text' class='form-control' style='width:300px' id='edit_search_text' name='edit_search_text' value='{$_search_text}' placeholder='请输入名称'>";
    $_body .= " </div>";
    //<---
    $_body .="</div>";
    //<-
    
    //->
    $_body .="<div class='form-row mb-1'> ";
    //--->
    $_body .= " <div class='form-inline'>";
    $_body .= " <label for='edit_where_use' class='control-label mr-1'>用于</label>";
    $_body .= " <input type='text' class='form-control' style='width:200px' id='edit_where_use' name='edit_where_use' value='{$_where_use}' placeholder='请输入用于'>";
    $_body .= " </div>";
    //<---
    //--->
    $_body .= " <div class='form-inline'>";
    $_body .= " <label for='edit_seq' class='control-label mr-1'>序号</label>";
    $_body .= " <input type='text' class='form-control' style='width:60px' id='edit_seq' name='edit_seq' value='{$_seq}' placeholder='序号'>";
    $_body .= " </div>";
    //<---
    $_body .="</div>";
    //<-
    /*
     */
    
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
                    "SUBMIT" => ["ID" => "btn_edit_submit",
                        "NAME" => "提交更改",
                        "CLASS" => "btn btn-primary",
                        "ICON" => "glyphicon .glyphicon-ok",
                        "ENHANCEMENT" =>""
                    ],
                    "CLOSE" => ["ID" => "btn_edit_close",
                        "NAME" => "关闭 [ESC]",
                        "CLASS" => "btn btn-default",
                        "ICON" => "glyphicon .glyphicon-remove",
                        "ENHANCEMENT" =>"data-dismiss='modal'"
                    ]
                    
                ]
            ]
            
            ];
    
    $_html = $GLOBALS['tag']->build_html_modal($_array_modal);
    return $_html;
}
/* ---Button Edit Modal--- */
//<-

//=====================================================================================================//
/* ---Build Table--- */
//->
function build_table(){
    $_array_tag =[
        "TABLE" => [
            "ID" => "tab_01",
            "CLASS" => "table table-sm table-bordered",
            "TITLE" => "表查询设置",
            "TITLE_ENABLE" =>false,
            "SEARCH_ENABLE" =>true,
            "TABLE_NAME" => "tb_search",
            "LIST_ROWS" => "9",
            "PAGE_NAME" => "",
            "SHOW_PAGES"=> "10",
            "PAGING_ENABLE" => true,
            "PAGING_FORMAT" => "2",
            "SQL" =>"select * from tb_search",
            "SQL_HAS_WHERE"=> false,
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
            "id"
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
                "WHERE_USE" =>"tb_search",
                //"SQL" => "select search_code as code, search_text as text from tb_search where where_use ='tb_type' order by seq",
                "ENHANCEMENT" =>"",
            ],
            "T_ENABLE" => TRUE,
            "T_CODE"  => "",
            "T_TEXT" => "--- 请选择 ---",
        ]
        
    ];
    
    $_html = $GLOBALS['tag']->build_html_table($_array_tag);
    return $_html;
}
/* ---Build Table--- */
//<-
echo build_toolbar();
echo eventregister_button_new();
echo eventregister_button_edit();
echo build_table();
?>

    