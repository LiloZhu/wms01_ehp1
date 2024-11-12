<!-- Backend Admin Page -->
<!doctype html>
<html>
<head>
<title>User</title>
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
layui.use('layer', function(){ //独立版的layer无需执行这一句
	  var layer = layui.layer; //独立版的layer无需执行这一句
	 });

tableSelectAll("#tbody_01");

/*---Button Action---*/
//->New
 $('#btn_new_submit').click(function(){
  var action = '#new_';
  var user_code = $('' + action + 'user_code').val();
  var user_text = $('' + action + 'user_text').val();
  var password = $('' + action + 'new_password').val();  
  
  var company_code =$("select[name='"+ action.replace("#","") +"company_code']").val();
  var department_code = $("select[name='"+ action.replace("#","") +"department_code']").val();  
  var division_code = $("select[name='"+ action.replace("#","") +"division_code']").val();
  var title_code =$("select[name='"+ action.replace("#","") +"title_code']").val();  
  var job_code =$("select[name='"+ action.replace("#","") +"job_code']").val();  
  var cost_center_code =$("select[name='"+ action.replace("#","") +"cost_center_code']").val();  
  
  var email = $('' + action + 'email').val();
  var telphone = $('' + action + 'telphone').val();
  var mobile = $('' + action + 'mobile').val();
    
  var active = $('' + action + 'active').prop("checked")
  var delete_flag = $('' + action + 'delete_flag').prop("checked")

  var request=new XMLHttpRequest;
           $.ajax({
            type:"POST",
          dataType:"json",
            //url:"test_ajax_action.php?number="+$("#keywords").val(),
			url:"user_action.php",
		    data:{action:'add', 
  		      arguments:{      		      
  		    	user_code:     		user_code,
  		    	user_text:     		user_text,
  		    	password:      		password,
  		    	company_code:	    company_code,
  		    	department_code:    department_code,  		    	
  		    	division_code:      division_code,
  		    	title_code:	   	    title_code,
  		    	job_code:     	    job_code,
  		    	cost_center_code:   cost_center_code,
  		    	email:    		    email,
  		    	telphone:  		    telphone,	
  		    	mobile:  		    mobile,	    	  		    	
		    	
  		    	active:			    active,
  		    	delete_flag:	    delete_flag
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
        var user_code = $('' + action + 'user_code').val();
        var user_text = $('' + action + 'user_text').val();
        var password = $('' + action + 'password').val();
        var new_password = $('' + action + 'new_password').val();   
        
        var company_code =$("select[name='"+ action.replace("#","") +"company_code']").val();
        var department_code = $("select[name='"+ action.replace("#","") +"department_code']").val();  
        var division_code = $("select[name='"+ action.replace("#","") +"division_code']").val();
        var title_code =$("select[name='"+ action.replace("#","") +"title_code']").val();  
        var job_code =$("select[name='"+ action.replace("#","") +"job_code']").val();  
        var cost_center_code =$("select[name='"+ action.replace("#","") +"cost_center_code']").val();  
		
        var email = $('' + action + 'email').val();
        var telphone = $('' + action + 'telphone').val();
        var mobile = $('' + action + 'mobile').val();
          
        var active = $('' + action + 'active').prop("checked")
        var delete_flag = $('' + action + 'delete_flag').prop("checked")

    
        var request=new XMLHttpRequest;
               $.ajax({
                type:"POST",
                dataType:"json",
                //url:"test_ajax_action.php?number="+$("#keywords").val(),
    			url:"user_action.php",
    		    data:{action:'edit', arguments:{
    			        id: 		       id,
    	  		    	user_code:     		user_code,
    	  		    	user_text:     		user_text,
    	  		    	password:      		password,
    	  		    	new_password:		new_password,
    	  		    	company_code:	    company_code,
    	  		    	department_code:    department_code,  		    	
    	  		    	division_code:      division_code,
    	  		    	title_code:	   	    title_code,
    	  		    	job_code:     	    job_code,
    	  		    	cost_center_code:   cost_center_code,
    	  		    	email:    		    email,
    	  		    	telphone:  		    telphone,	
    	  		    	mobile:  		    mobile,	    	  		    	
    	  		    	active:			    active,
    	  		    	//delete_flag:	    delete_flag
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
    $('#btn_rfid').click(function(){
    	layer.confirm('您是否要对所选用户进行发卡，[ 已生成卡号不再重新发卡 ]？', {
    		btn: ['是', '否']
    		}, function() {
    			        
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
        				url:"user_action.php",
        			    data:{action:'rfid', arguments:{
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
        				   window.location='user.php' + condition;
        	           	 },
    						error:function(data){
            	                alert("encounter error - "+ data.responseText);
            	            }
            			});	
                        
    					//<-			
    				}


    				//
    			  });	       
	});

    $('#btn_print').click(function(){
    	layer.confirm('您是否要对所选用户进行打印制卡？', {
    		btn: ['是', '否']
    		}, function() {
    			        
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
        				url:"user_action.php",
        			    data:{action:'print_rfid', arguments:{
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
        				   window.location='user.php' + condition;
        	           	 },
    						error:function(data){
            	                alert("encounter error - "+ data.responseText);
            	            }
            			});	
                        
    					//<-			
    				}


    				//
    			  });	       
	});
	    
    //-->delete    
    $('#btn_delete').click(function(){
        
	layer.confirm('您是否要删除当前所选用户？', {
		btn: ['是', '否']
		}, function() {
			        
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
    				url:"user_action.php",
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
    				   window.location='user.php' + condition;
    	           	 },
						error:function(data){
        	                alert("encounter error - "+ data.responseText);
        	            }
        			});	
                    
					//<-			
				}


				//
			  });		
		
	    	});
		//<--Delete
  
$('#btn_edit').click(function(){
    var action = '#edit_';
    
    $('' + action + 'id').val(getSelectedRowFieldValue('#tab_01','id'));
    $('' + action + 'user_code').val(getSelectedRowFieldValue('#tab_01','user_code'));
    $('' + action + 'user_text').val(getSelectedRowFieldValue('#tab_01','user_text'));
    $('' + action + 'password').val(getSelectedRowFieldValue('#tab_01','password'));
    $('' + action + 'company_code').val(getSelectedRowFieldValue('#tab_01','company_code'));
    $('' + action + 'department_code').val(getSelectedRowFieldValue('#tab_01','department_code'));
    $('' + action + 'division_code').val(getSelectedRowFieldValue('#tab_01','division_code'));
    $('' + action + 'title_code').val(getSelectedRowFieldValue('#tab_01','title_code'));
    $('' + action + 'job_code').val(getSelectedRowFieldValue('#tab_01','job_code'));  
    $('' + action + 'cost_center_code').val(getSelectedRowFieldValue('#tab_01','cost_center_code'));    
    $('' + action + 'email').val(getSelectedRowFieldValue('#tab_01','email'));
    $('' + action + 'telphone').val(getSelectedRowFieldValue('#tab_01','telphone'));
    $('' + action + 'mobile').val(getSelectedRowFieldValue('#tab_01','mobile'));        
    
    $('' + action + 'active').attr("checked",(getSelectedRowFieldValue('#tab_01','active')== 1 ? true : false ));
    $('' + action + 'delete_flag').attr("checked",(getSelectedRowFieldValue('#tab_01','delete_flag') == 1 ? true : false ));
	$('#btn_edit_submit').attr("disabled",(getSelectedRowFieldValue('#tab_01','id') == '' ? true : false ));

	//->
	var action		= 'edit';
	var link_table  = 'tb_department';
	var field_value  = 'department_code';
	var field_text	 = 'department_text';
	var target_tag	 = 'department_code';
	var source_tag_1 = "company_code";
	var source_tag_2 = "";
	var source_tag_3 = "";

	var default_value = getSelectedRowFieldValue('#tab_01','department_code');
	onSetLinkToTagSelect(action,default_value,link_table,field_value,field_text,target_tag,source_tag_1,source_tag_2,source_tag_3);
	
	//$('' + action + 'department_code').val(getSelectedRowFieldValue('#tab_01','department_code'));
	//<-
		
});

$('.table_action_new').click(function(){
	var row = $(this).parent().parent().find("td");	
});

$('.table_action_edit').click(function(){
	var action = '#edit_';
	var row = $(this).parent().parent().find("td");
    $('' + action + 'id').val(row.eq(1).text());
    $('' + action + 'user_code').val(row.eq(2).text());
    $('' + action + 'user_text').val(row.eq(3).text());
    $('' + action + 'password').val(row.eq(4).text());  
    $('' + action + 'company_code').val(row.eq(5).text());
    $('' + action + 'department_code').val(row.eq(6).text());
    $('' + action + 'division_code').val(row.eq(7).text());
    $('' + action + 'title_code').val(row.eq(8).text());  
    $('' + action + 'job_code').val(row.eq(9).text());  
    $('' + action + 'cost_center_code').val(row.eq(10).text());      
    $('' + action + 'email').val(row.eq(11).text());
    $('' + action + 'telphone').val(row.eq(12).text());  
    $('' + action + 'mobile').val(row.eq(13).text());    
    //$('' + action + 'rfid').val(row.eq(14).text());         
    $('' + action + 'active').attr("checked",(row.eq(15).text())== 1 ? true : false );
    $('' + action + 'delete_flag').attr("checked",(row.eq(16).text()) == 1 ? true : false );
	
    $('#btn_edit_submit').attr("disabled",($('' + action + 'id').val() == '' ? true : false ));	

	//->
	var action		= 'edit';
	var link_table  = 'tb_department';
	var field_value  = 'department_code';
	var field_text	 = 'department_text';
	var target_tag	 = 'department_code';
	var source_tag_1 = "company_code";
	var source_tag_2 = "";
	var source_tag_3 = "";
	
	var default_value = row.eq(6).text();
	onSetLinkToTagSelect(action,default_value,link_table,field_value,field_text,target_tag,source_tag_1,source_tag_2,source_tag_3);

	var link_table  = 'tb_division';
	var field_value  = 'division_code';
	var field_text	 = 'division_text';
	var target_tag	 = 'division_code';
	var source_tag_1 = "company_code";
	var source_tag_2 = "department_code";
	var source_tag_3 = "";	
	var default_value = row.eq(7).text();
	onSetLinkToTagSelect(action,default_value,link_table,field_value,field_text,target_tag,source_tag_1,source_tag_2,source_tag_3);
	
	//$('' + action + 'department_code').val(getSelectedRowFieldValue('#tab_01','department_code'));
	//<-
	    		
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
			url:"division_action.php",
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
			   window.location='division.php' + condition;
           	 },
				error:function(data){
	                alert("encounter error");
	            }
			});		
});

//============Special Event Action============>
//-->Select Event
//->
$('#edit_company_code').change(function(){
	var action		= 'edit';
	var link_table  = 'tb_department';
	var field_value  = 'department_code';
	var field_text	 = 'department_text';
	var target_tag	 = 'department_code';
	var source_tag_1 = "company_code";
	var source_tag_2 = "";
	var source_tag_3 = "";

	var default_value = "";
	
	//-->
	onSetLinkToTagSelect(action,default_value,link_table,field_value,field_text,target_tag,source_tag_1,source_tag_2,source_tag_3)
	
	var action		= 'edit';
	var link_table  = 'tb_division';
	var field_value  = 'division_code';
	var field_text	 = 'division_text';
	var target_tag	 = 'division_code';
	var source_tag_1 = "company_code";
	var source_tag_2 = "department_code";
	var source_tag_3 = "";

	var default_value = getSelectedRowFieldValue('#tab_01','division_code');
	onSetLinkToTagSelect(action,default_value,link_table,field_value,field_text,target_tag,source_tag_1,source_tag_2,source_tag_3);
});
//<-
//->
$('#edit_department_code').change(function(){
	var action		= 'edit';
	var link_table  = 'tb_division';
	var field_value  = 'division_code';
	var field_text	 = 'division_text';
	var target_tag	 = 'division_code';
	var source_tag_1 = "company_code";
	var source_tag_2 = "department_code";
	var source_tag_3 = "";

	var default_value = getSelectedRowFieldValue('#tab_01','division_code');
	onSetLinkToTagSelect(action,default_value,link_table,field_value,field_text,target_tag,source_tag_1,source_tag_2,source_tag_3);

});
//<-
//->
$('#new_company_code').change(function(){
	var action		= 'new';
	var link_table  = 'tb_department';
	var field_value  = 'department_code';
	var field_text	 = 'department_text';
	var target_tag	 = 'department_code';
	var source_tag_1 = "company_code";
	var source_tag_2 = "";
	var source_tag_3 = "";

	var default_value = "";
	
	//-->
	onSetLinkToTagSelect(action,default_value,link_table,field_value,field_text,target_tag,source_tag_1,source_tag_2,source_tag_3)
	
	var action		= 'new';
	var link_table  = 'tb_division';
	var field_value  = 'division_code';
	var field_text	 = 'division_text';
	var target_tag	 = 'division_code';
	var source_tag_1 = "company_code";
	var source_tag_2 = "department_code";
	var source_tag_3 = "";

	var default_value = getSelectedRowFieldValue('#tab_01','division_code');
	onSetLinkToTagSelect(action,default_value,link_table,field_value,field_text,target_tag,source_tag_1,source_tag_2,source_tag_3);	

});
//<-
//->
$('#new_department_code').change(function(){
	var action		= 'new';
	var link_table  = 'tb_division';
	var field_value  = 'division_code';
	var field_text	 = 'division_text';
	var target_tag	 = 'division_code';
	var source_tag_1 = "company_code";
	var source_tag_2 = "department_code";
	var source_tag_3 = "";

	var default_value = getSelectedRowFieldValue('#tab_01','division_code');
	onSetLinkToTagSelect(action,default_value,link_table,field_value,field_text,target_tag,source_tag_1,source_tag_2,source_tag_3);

});
//<-
		
//<--Select Event
//<============Special Event Action============
	
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
        "TITLE" =>"用户",
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
            "RFID" => ["ID" => "btn_rfid",
                "NAME" => "发卡",
                "DATA-TARGET" =>"#modal_rfid",
                "CLASS" => "btn top btn-primary",
                "ICON" => "glyphicon glyphicon-plus",
            ],
            "PRINT" => ["ID" => "btn_print",
                "NAME" => "打印",
                "DATA-TARGET" =>"#modal_print",
                "CLASS" => "btn top btn-primary",
                "ICON" => "glyphicon glyphicon-plus",
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
    $_btn_action = $_action;
    $_action = $_action.'_';
    
    $id = isset($_GET['{$_action}id']) ? $_GET['{$_action}id'] : "";
    $user_code = isset($_GET['{$_action}user_code']) ? $_GET['{$action}user_code'] : "";
    $user_text = isset($_GET['{$_action}user_text']) ? $_GET['{$action}user_text'] : "";
    $password = isset($_GET['{$_action}password']) ? $_GET['{$_action}password'] : "";
    $company_code = isset($_GET['{$_action}company_code']) ? $_GET['{$action}company_code'] : "";
    $department_code = isset($_GET['{$_action}department_code']) ? $_GET['{$action}department_code'] : "";
    $division_code = isset($_GET['{$_action}division_code']) ? $_GET['{$action}division_code'] : "";
    $title_code = isset($_GET['{$_action}title_code']) ? $_GET['{$_action}title_code'] : "";
    $job_code = isset($_GET['{$_action}job_code']) ? $_GET['{$action}job_code'] : "";
    $cost_center_code = isset($_GET['{$_action}cost_center_code']) ? $_GET['{$action}cost_center_code'] : "";
    $email = isset($_GET['{$_action}email']) ? $_GET['{$_action}email'] : "";
    $telphone = isset($_GET['{$_action}telphone']) ? $_GET['{$action}telphone'] : "";
    $mobile = isset($_GET['{$_action}mobile']) ? $_GET['{$action}mobile'] : "";
    
    $active = isset($_GET['{$action}active']) ? $_GET['{$_action}active'] : "";
    $delete_flag = isset($_GET['{$action}delete_flag']) ? $_GET['{$_action}delete_flag'] : "";
    
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
    
    //->
    $_body .="<div class='form-row mb-1'> ";
    //--->
    $_body .= " <div class='form-inline'>";
    $_body .= " <label for='{$_action}user_code' class='control-label mr-1'>代码</label>";
    $_body .= " <input type='text' class='form-control' style='width:120px' id='{$_action}user_code' name='{$_action}user_code' value='{$user_code}' placeholder='请输入代码'>";
    $_body .= " </div>";
    //<---
    //--->
    $_body .= " <div class='form-inline'>";
    $_body .= " <label for='{$_action}user_text' class='control-label mr-1'>名称</label>";
    $_body .= " <input type='text' class='form-control' style='width:400px' id='{$_action}user_text' name='{$_action}user_text' value='{$user_text}' placeholder='请输入名称'>";
    $_body .= " </div>";
    //<---
    $_body .="</div>";
    //<-
    
    //->
    $_body .="<div class='form-row mb-1' hidden> ";
    //--->
    $_body .= " <div class='form-inline'>";
    $_body .= " <label for='{$_action}password' class='control-label mr-1'>密码</label>";
    $_body .= " <input type='password' class='form-control' id='{$_action}password' name='{$_action}password' value='{$password}'>";
    $_body .= " </div>";
    //<---
    $_body .="</div>";
    //<-
    
    //->
    $_body .="<div class='form-row mb-1'> ";
    //--->
    $_body .= " <div class='form-inline'>";
    $_body .= " <label for='{$_action}new_password' class='control-label mr-1'>密码</label>";
    $_body .= " <input type='password' class='form-control' style='width:300px' id='{$_action}new_password' name='{$_action}new_password' placeholder='请输入新密码'>";
    $_body .= " </div>";
    //<---
    $_body .="</div>";
    //<-
    
    //->
    $_body .="<div class='form-row mb-1'> ";
    //--->
    $sql = "select company_code as code, company_text as text from tb_company where active = true and delete_flag = false order by company_code;";
    $_body .=$GLOBALS['tag']->build_html_select(prepare_tag_select_special("company_code",$_btn_action,'公司',$sql));
    //<---

    //--->
    $sql = "select department_code as code, department_text as text from tb_department where active = true and delete_flag = false order by company_code,department_code;";
    $_body .=$GLOBALS['tag']->build_html_select(prepare_tag_select_special("department_code",$_btn_action,'部门',$sql));
    //<---
    
    //--->
    $sql = "select division_code as code, division_text as text from tb_division where active = true and delete_flag = false order by company_code,department_code,division_code;";
    $_body .=$GLOBALS['tag']->build_html_select(prepare_tag_select_special("division_code",$_btn_action,'项目组',$sql));
    //<---
    $_body .="</div>";
    //<-
    
    //->
    $_body .="<div class='form-row mb-1'> ";
    //--->
    $_body .=$GLOBALS['tag']->build_html_select(prepare_tag_select_common("title_code",$_btn_action,'称谓','tb_user-title_code'));
    //<---
    //--->
    $_body .=$GLOBALS['tag']->build_html_select(prepare_tag_select_common("job_code",$_btn_action,'职位','tb_user-job_code'));
    //<---
    //--->
    $sql = "select cost_center_code as code, cost_center_text as text from tb_cost_center where active = true and delete_flag = false order by cost_center_code;";
    $_body .=$GLOBALS['tag']->build_html_select(prepare_tag_select_special("cost_center_code",$_btn_action,'成本中心',$sql));
    //<---
    $_body .="</div>";
    //<-
    
    //->
    $_body .="<div class='form-row mb-1'> ";
    //--->
    $_body .= " <div class='form-inline'>";
    $_body .= " <label for='{$_action}email' class='control-label mr-1'>邮箱</label>";
    $_body .= " <input type='text' class='form-control' id='{$_action}email' name='{$_action}email' value='{$email}'>";
    $_body .= " </div>";
    //<---
    $_body .="</div>";
    //<-

    //->
    $_body .="<div class='form-row mb-1'> ";
    //--->
    $_body .= " <div class='form-inline'>";
    $_body .= " <label for='{$_action}telphone' class='control-label mr-1'>电话</label>";
    $_body .= " <input type='text' class='form-control' id='{$_action}telphone' name='{$_action}telphone' value='{$telphone}'>";
    $_body .= " </div>";
    //<---
    $_body .="</div>";
    //<-
    
    
    //->
    $_body .="<div class='form-row mb-1'> ";
    //--->
    $_body .= " <div class='form-inline'>";
    $_body .= " <label for='{$_action}mobile' class='control-label mr-1'>手机</label>";
    $_body .= " <input type='text' class='form-control' id='{$_action}mobile' name='{$_action}mobile' value='{$mobile}'>";
    $_body .= " </div>";
    //<---
    $_body .="</div>";
    //<-
    
    
    //->
    $_body .="<div class='form-row mb-1'> ";
    //--->
    $_body .= "<div class='form-check-inline'>";
    $_body .= "<label for='{$_action}active' class='form-check-label mr-1'>有效标识</label>";
    $_body .= "<input type='checkbox' class='form-check-input' id='{$_action}active' name='{$_action}active'>";
    $_body .= " </div>";
    //<---
    //--->
    $_body .= "<div class='form-check-inline' hidden>";
    $_body .= "<label for='{$_action}delete_flag' class='form-check-label mr-1'>删除标识</label>";
    $_body .= "<input type='checkbox' class='form-check-input' id='{$_action}delete_flag' name='{$_action}delete_flag'>";
    $_body .="</div>";
    //<-
    
    $_body .= " </div>";
    //<--- 
    
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

//=====================================================================================================//
/* ---Build Table--- */
//->
function build_table(){
    $_array_tag =[
        "TABLE" => [
            "ID" => "tab_01",
            "CLASS" => "table table-sm table-bordered",
            "TITLE" => "用户",
            "TITLE_ENABLE" =>false,
            "SEARCH_ENABLE" =>true,
            "TABLE_NAME" => "tb_division",
            "LIST_ROWS" => "25",
            "PAGE_NAME" => "",
            "SHOW_PAGES"=> "10",
            "PAGING_ENABLE" => true,
            "PAGING_FORMAT" => "2",
            "SQL" =>"select * from tb_user where delete_flag = false",
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

/* ---Build Dynamic Table--- */
//<-

//--- Prepare Tag array Data ---//
function prepare_tag_select_common($_field,$_action,$title,$where_use){
    $tag_name = $_action."_".$_field;
    $label_id = "lbl_".$_action."_".$_field;
    $label_name = "lbl_".$_action."_".$_field;
    
    
    $_array_tag = array();
    $_array_tag = [
        "TEST"  =>"Test Use...",
        "NAME"  =>  $tag_name,
        "DIV"   => [
            "CLASS" => "form-inline",
            "STYLE" => "",
            "ENHANCEMENT" =>"",
        ],
        "LABEL" => [
            "ID" => $label_id,
            "NAME" => $label_name,
            "FOR"  => $tag_name,
            "CLASS" => "control-label mr-1",
            "TEXT"  => $title,
            "ENHANCEMENT" =>"",
        ],
        "SELECT" => [
            "ID" => $tag_name,
            "NAME" => $tag_name,
            "CLASS" => "form-control",
            "SQL" => "select type_code as code, type_text as text from tb_type where where_use = '{$where_use}' order by seq",
            "ENHANCEMENT" =>"",
            ],
            "T_ENABLE" => TRUE,
            "T_CODE"  => "",
            "T_TEXT" => "--- 请选择 ---",
            ];
    
    return $_array_tag;
};

function prepare_tag_select_special($_field,$_action,$_title,$_sql){
    $tag_name = $_action."_".$_field;
    $label_id = "lbl_".$_action."_".$_field;
    $label_name = "lbl_".$_action."_".$_field;
    
    
    $_array_tag = array();
    $_array_tag = [
        "TEST"  =>"Test Use...",
        "NAME"  =>  $tag_name,
        "DIV"   => [
            "CLASS" => "form-inline",
            "STYLE" => "",
            "ENHANCEMENT" =>"",
        ],
        "LABEL" => [
            "ID" => $label_id,
            "NAME" => $label_name,
            "FOR"  => $tag_name,
            "CLASS" => "control-label mr-1",
            "TEXT"  => $_title,
            "ENHANCEMENT" =>"",
        ],
        "SELECT" => [
            "ID" => $tag_name,
            "NAME" => $tag_name,
            "CLASS" => "form-control",
            "SQL" => $_sql,
            "ENHANCEMENT" =>"",
        ],
        "T_ENABLE" => TRUE,
        "T_CODE"  => "",
        "T_TEXT" => "--- 请选择 ---",
    ];
    
    return $_array_tag;
};


//------javascript call php function------
function test($val_1,$val_2){
    return $val_1.'---'.$val_2;
}

//------ Get PangeName ------//
function getPageName(){
    return basename(__FILE__);
}

//============Build Page Start=========
//---Build Toolbar---
echo build_toolbar();
echo eventregister_button('new');
echo eventregister_button('edit');
//----Build Table----
echo build_table();

//============Build Page End=========

?>
