<!-- Backend Admin Page -->
<!doctype html>
<html>
<head>
<title>Company</title>
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
<script src="../js/common.js"></script>

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
  var action = '#new_';
  
  var company_code = $('' + action + 'company_code').val();
  var company_text = $('' + action + 'company_text').val();
  //var country_code = $('' + action + 'country_code').val();
  //var currency_code = $('' + action + 'currency_code').val();
  //var language_code = $('' + action + 'language_code').val();
  var address = $('' + action + 'address').val();
  var tel_number = $('' + action + 'tel_number').val();
  var tel_extens = $('' + action + 'tel_extens').val();
  var mobile = $('' + action + 'mobile').val();  
  var fax = $('' + action + 'fax').val(); 
  var active = $('' + action + 'active').prop("checked")
  var delete_flag = $('' + action + 'delete_flag').prop("checked")

  var request=new XMLHttpRequest;
           $.ajax({
            type:"POST",
          dataType:"json",
            //url:"test_ajax_action.php?number="+$("#keywords").val(),
			url:"company_action.php",
		    data:{action:'add', 
  		      arguments:{      		      
  		    	company_code:   company_code,
  		    	company_text:   company_text,
  		    	country_code:   'CN',    			      
  		    	currency_code: 	'CNY',
  		    	language_code:  'ZH',
  		    	address: 		address,
  		    	tel_number:	    tel_number,
  		    	tel_extens:		tel_extens,
  		    	mobile:			mobile,
  		    	fax:			fax,
  		    	active:			active,
  		    	delete_flag:			delete_flag
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
        var company_code = $('' + action + 'company_code').val();
        var company_text = $('' + action + 'company_text').val();
        //var country_code = $('' + action + 'country_code').val();
        //var currency_code = $('' + action + 'currency_code').val();
        //var language_code = $('' + action + 'language_code').val();
        var address = $('' + action + 'address').val();
        var tel_number = $('' + action + 'tel_number').val();
        var tel_extens = $('' + action + 'tel_extens').val();
        var mobile = $('' + action + 'mobile').val();  
        var fax = $('' + action + 'fax').val(); 
        var active = $('' + action + 'active').prop("checked")
        var delete_flag = $('' + action + 'delete_flag').prop("checked")
    
        var request=new XMLHttpRequest;
               $.ajax({
                type:"POST",
                dataType:"json",
                //url:"test_ajax_action.php?number="+$("#keywords").val(),
    			url:"company_action.php",
    		    data:{action:'edit', arguments:{
    			        id: 		    id,
    	  		    	company_code:   company_code,
    	  		    	company_text:   company_text,
    	  		    	country_code:   'CN',    			      
    	  		    	currency_code: 	'CNY',
    	  		    	language_code:  'ZH',
    	  		    	address: 		address,
    	  		    	tel_number:	    tel_number,
    	  		    	tel_extens:		tel_extens,
    	  		    	mobile:			mobile,
    	  		    	fax:			fax,
    	  		    	active:			active,
    	  		    	delete_flag:			delete_flag
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

    
    //-->delete    
    $('#btn_delete').click(function(){
		var condition = '';
		var keys = getCheckboxValues('chk_row[]').toString();

		var array_key = new Array();
		array_key = keys.split(",");

		for(var item in array_key)
		{
			//alert(_array_role_menu[item]);
			var key = array_key[item];
			//->
	        var request=new XMLHttpRequest;
               $.ajax({
    	            type:"POST",
    	            dataType:"json",
    	            //url:"test_ajax_action.php?number="+$("#keywords").val(),
    				url:"company_action.php",
    			    data:{action:'delete', arguments:{
    			    	  key: key
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
        			     condition = '?page='+data.page;
    				   }else{
        			     _condition = '';
        			   }
    				   window.location='company.php' + condition;
    	           	 },
						error:function(data){
        	                alert("encounter error - "+ data.responseText);
        	            }
        			});	
                    
					//<-			
				}
		
	    	});
		//<--Delete
		  
$('#btn_edit').click(function(){
    var action = '#edit_';
    
    $('' + action + 'id').val(getSelectedRowFieldValue('#tab_01','id'));
    $('' + action + 'company_code').val(getSelectedRowFieldValue('#tab_01','company_code'));
    $('' + action + 'company_text').val(getSelectedRowFieldValue('#tab_01','company_text'));
    $('' + action + 'address').val(getSelectedRowFieldValue('#tab_01','address'));
    $('' + action + 'tel_number').val(getSelectedRowFieldValue('#tab_01','tel_number'));
    $('' + action + 'tel_extens').val(getSelectedRowFieldValue('#tab_01','tel_extens'));
    $('' + action + 'mobile').val(getSelectedRowFieldValue('#tab_01','mobile'));
    $('' + action + 'fax').val(getSelectedRowFieldValue('#tab_01','fax'));
    $('' + action + 'active').attr("checked",(getSelectedRowFieldValue('#tab_01','active')== 1 ? true : false ));
    $('' + action + 'delete_flag').attr("checked",(getSelectedRowFieldValue('#tab_01','delete_flag') == 1 ? true : false ));
	$('#btn_edit_submit').attr("disabled",(getSelectedRowFieldValue('#tab_01','id') == '' ? true : false ));	
});

$('.table_action_new').click(function(){
	var row = $(this).parent().parent().find("td");	
});

$('.table_action_edit').click(function(){
	var action = '#edit_';
	var row = $(this).parent().parent().find("td");
    $('' + action + 'id').val(row.eq(1).text());
    $('' + action + 'company_code').val(row.eq(2).text());
    $('' + action + 'company_text').val(row.eq(3).text());
    $('' + action + 'country_code').val(row.eq(4).text());
    $('' + action + 'currency_code').val(row.eq(5).text());
    $('' + action + 'language_code').val(row.eq(6).text());
    $('' + action + 'address').val(row.eq(7).text());
    $('' + action + 'tel_number').val(row.eq(8).text());
    $('' + action + 'tel_extens').val(row.eq(9).text());
    $('' + action + 'mobile').val(row.eq(10).text());
    $('' + action + 'fax').val(row.eq(11).text());
    $('' + action + 'active').attr("checked",(row.eq(12).text())== 1 ? true : false );
    $('' + action + 'delete_flag').attr("checked",(row.eq(13).text()) == 1 ? true : false );
	
    $('#btn_edit_submit').attr("disabled",($('' + action + 'id').val() == '' ? true : false ));			
});


$('.table_action_delete').click(function(){
	var row = $(this).parent().parent().find("td");	
	var key = row.eq(1).text();
	//->
    var request=new XMLHttpRequest;
           $.ajax({
            type:"POST",
            dataType:"json",
            //url:"test_ajax_action.php?number="+$("#keywords").val(),
			url:"company_action.php",
		    data:{action:'delete', arguments:{
		    	  key: key
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
			     condition = '?page='+data.page;
			   }else{
			     condition = '';
			   }
			   window.location='company.php' + condition;
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
$obj_cat = new classes\libralies\category();
$obj_type = new classes\libralies\type();
$tag = new classes\BASE\html();
/* ---Page Load--- */
//<-

//=====================================================================================================//
/* ---Build Toolbar--- */
//->
function build_toolbar(){
    $_array_toolbar = [
        "TITLE" =>"公司",
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
/* ---Button New/Edit Modal--- */
//->
function eventregister_button($_action){
    $id = isset($_GET['{$_action}_id']) ? $_GET['{$_action}_id'] : "";
    $conpany_code = isset($_GET['{$_action}_conpany_code']) ? $_GET['{$_action}_conpany_code'] : "";
    $conpany_text = isset($_GET['{$_action}_company_text']) ? $_GET['{$_action}_company_text'] : "";
    $country_code = isset($_GET['{$_action}_country_code']) ? $_GET['{$_action}_country_code'] : "";
    $currency_code = isset($_GET['{$_action}_currency_code']) ? $_GET['{$_action}_currency_code'] : "";
    $language_code = isset($_GET['{$_action}_language_code']) ? $_GET['{$_action}_language_code'] : "";
    $address = isset($_GET['{$_action}_address']) ? $_GET['{$_action}_address'] : "";
    $tel_number = isset($_GET['{$_action}_tel_number']) ? $_GET['{$_action}_tel_number'] : "";
    $tel_extens = isset($_GET['{$_action}_tel_extens']) ? $_GET['{$_action}_tel_extens'] : "";
    $mobile = isset($_GET['{$_action}_mobile']) ? $_GET['{$_action}_mobile'] : "";
    $fax = isset($_GET['{$_action}_fax']) ? $_GET['{$_action}_fax'] : "";
    $active = isset($_GET['{$_action}_active']) ? $_GET['{$_action}_active'] : "";
    $delete_flag = isset($_GET['{$_action}_delete_flag']) ? $_GET['{$_action}_delete_flag'] : "";
    
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
    $_body .= " <label for='{$_action}_id' class='control-label mr-1'>ID</label>";
    $_body .= " <input type='text' class='form-control' id='{$_action}_id' name='{$_action}_id' value='{$id}'>";
    $_body .= " </div>";
    //<---
    $_body .="</div>";
    //<-
    
    //->
    $_body .="<div class='form-row mb-1'> ";
    //--->
    $_body .= " <div class='form-inline'>";
    $_body .= " <label for='{$_action}_company_code' class='control-label mr-1'>代码</label>";
    $_body .= " <input type='text' class='form-control' style='width:120px' id='{$_action}_company_code' name='{$_action}_company_code' value='{$conpany_code}' placeholder='请输入代码'>";
    $_body .= " </div>";
    //<---
    //--->
    $_body .= " <div class='form-inline'>";
    $_body .= " <label for='{$_action}_company_text' class='control-label mr-1'>名称</label>";
    $_body .= " <input type='text' class='form-control' style='width:400px' id='{$_action}_company_text' name='{$_action}_company_text' value='{$conpany_text}' placeholder='请输入名称'>";
    $_body .= " </div>";
    //<---
    $_body .="</div>";
    //<-
           
    //->
    $_body .="<div class='form-row mb-1'> ";
    //--->
    $_body .= " <div class='form-inline'>";
    $_body .= " <label for='{$_action}_address' class='control-label mr-1'>地址</label>";
    $_body .= " <input type='text' class='form-control' style='width:700px' id='{$_action}_address' name='{$_action}_address' value='{$address}' placeholder='请输入地址'>";
    $_body .= " </div>";
    //<---
    $_body .="</div>";
    //<-
    
    //->
    $_body .="<div class='form-row mb-1'> ";
    //--->
    $_body .= " <div class='form-inline'>";
    $_body .= " <label for='{$_action}_tel_number' class='control-label mr-1'>电话</label>";
    $_body .= " <input type='text' class='form-control' style='width:200px' id='{$_action}_tel_number' name='{$_action}_tel_number' value='{$tel_number}' placeholder='请输入电话'>";
    $_body .= " </div>";
    //<---
    //--->
    $_body .= " <div class='form-inline'>";
    $_body .= " <label for='{$_action}_tel_extens' class='control-label mr-1'>分机</label>";
    $_body .= " <input type='text' class='form-control' style='width:120px' id='{$_action}_tel_extens' name='{$_action}_tel_extens' value='{$tel_extens}' placeholder='请输入分机'>";
    $_body .= " </div>";
    //<---
    
    $_body .="</div>";
    //<-
    
    //->
    $_body .="<div class='form-row mb-1'> ";
    //--->
    $_body .= " <div class='form-inline'>";
    $_body .= " <label for='{$_action}_mobile' class='control-label mr-1'>手机</label>";
    $_body .= " <input type='text' class='form-control' style='width:200px' id='{$_action}_mobile' name='{$_action}_mobile' value='{$mobile}' placeholder='请输入手机'>";
    $_body .= " </div>";
    //<---
    $_body .="</div>";
    //<-
 
    //->
    $_body .="<div class='form-row mb-1'> ";
    //--->
    $_body .= " <div class='form-inline'>";
    $_body .= " <label for='{$_action}_fax' class='control-label mr-1'>传真</label>";
    $_body .= " <input type='text' class='form-control' style='width:200px' id='{$_action}_fax' name='{$_action}_fax' value='{$fax}' placeholder='请输入传真'>";
    $_body .= " </div>";
    //<---
    $_body .="</div>";
    //<-
    
    //->
    $_body .="<div class='form-row mb-1'> ";
    //--->
    $_body .= "<div class='form-check-inline'>";
    $_body .= "<label for='{$_action}_active' class='form-check-label mr-1'>有效标识</label>";
    $_body .= "<input type='checkbox' class='form-check-input' id='{$_action}_active' name='{$_action}_active'>";
    $_body .= " </div>";
    //<---
    //--->
    $_body .= "<div class='form-check-inline' hidden>";
    $_body .= "<label for='{$_action}_delete_flag' class='form-check-label mr-1'>删除标识</label>";
    $_body .= "<input type='checkbox' class='form-check-input' id='{$_action}_delete_flag' name='{$_action}_delete_flag'>";
    $_body .="</div>";
    //<-
    
    $_body .= " </div>";
    //<--- 
    
     /*
     */
   
    $_body .= "<p id='message'></p>";
    $_body .= "";
    $_body .= " </div>";
    
    $modal_id = "modal_".$_action;
    $btn_sibmit_id = "btn_".$_action."_submit";
    $btn_close_id = "btn_".$_action."_close";
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

//=====================================================================================================//
/* ---Build Table--- */
//->
function build_table(){
    $_array_tag =[
        "TABLE" => [
            "ID" => "tab_01",
            "CLASS" => "table table-sm table-bordered",
            "TITLE" => "公司",
            "TITLE_ENABLE" =>false,
            "SEARCH_ENABLE" =>true,
            "TABLE_NAME" => "tb_company",
            "LIST_ROWS" => "9",
            "PAGE_NAME" => "",
            "SHOW_PAGES"=> "10",
            "PAGING_ENABLE" => true,
            "PAGING_FORMAT" => "2",
            "SQL" =>"select * from tb_company where delete_flag = false",
            "SQL_HAS_WHERE"=> true,
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
            "country_code",
            "currency_code",
            "language_code",
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
                "WHERE_USE" =>"tb_company",
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
echo eventregister_button('new');
echo eventregister_button('edit');
echo build_table();
?>
