<!doctype html>
<head>
<meta charset="uft-8">
<title>Menu</title>
<!-- Import JQuery -->
<link rel="stylesheet" href="../../plugins/bootstrap/css/bootstrap.min.css" />
<link rel="stylesheet" href="../../plugins/fontawesome-free/css/all.min.css">
<!-- Ionicons -->
<link rel="stylesheet" href="../../plugins/ionicons/css/ionicons.min.css">
<link rel="stylesheet" href="../../css/global.css" />
<!--jquery-->
<script src="../../plugins/jquery/jquery.min.js"></script>
<script src="../../plugins/jquery-treeview/jquery.treeview.js"></script>
<link rel="stylesheet" href="../../plugins/jquery-treeview/jquery.treeview.css" />
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


<script type="text/javascript">

  $(document).ready(function(){
      //===> Begin
        $("#tree").treeview({
            //persist: "location",
            collapsed: true,
            unique: true
         });
      	//tableSelectAll("#tbody_01");
        onSetModaltoCenter();  

        $(".check_menu").click(function(){
            var _checked = this.checked;
            if(this.checked == true){
                var _id = (this.id).replace("cb",'');   
                 $('#edit_id').val(''+ _id +'');  
                 get_menu(_id);
            }else{
            	$('#new_lvl_menu_code').val('0');  
            	$('#edit_lvl_menu_code').val('0');      	
            }
            
            $(".check_menu").prop('checked',false);
            $(this).prop('checked',_checked);
            
            //alert('xxx');
          });        

       function get_menu(_id){
           var request=new XMLHttpRequest;
                      $.ajax({
                       type:"POST",
                       dataType:"json",
                       //url:"test_ajax_action.php?number="+$("#keywords").val(),
           				url:"menu_action_x.php",
           		    	data:{
               		    	action:'retrieve', 
               		    	arguments:{
           			      	 id:  		_id,
           			      //where_use:  _where_use,    			      
           			      //seq: 		_seq, 
       				      	currentPage: getQueryString("page"),
       				      	listRows: 10
       				      }
		      			},
                       
                       success: function(data){
               			var _lvl_new;
               			var _lvl_edit;
               			var _path_new;
               			var _path_edit;

               			_lvl_new = data[0].id + '|' + data[0].path + data[0].id + ',';
               			_path_new = data[0].path + data[0].id + ',';
               			
          				if (data[0].pid !='0'){
               				_lvl_edit = data[0].pid + '|' + data[0].path;
          				}else{
          					_lvl_edit = '0';	
          				}
               			_path_edit = data[0].path;
               			
        	   			$("select[name='new_type_code']").val(data[0].type_code);
        	   			$('#new_lvl_menu_code').val(_lvl_new);
        	   			$('#new_path').val(_path_new);
        	   			$('#new_admin_flag').prop("checked",data[0].admin_flag == 'X' ? true : false );

        	   			$('#edit_id').val(data[0].id);
        	   			$('#edit_path').val(_path_edit);
        	   			$("select[name='edit_type_code']").val(data[0].type_code);
        	   			$('#edit_lvl_menu_code').val(_lvl_edit);
        	   			$('#edit_menu_name').val(data[0].menu_name);
        	   			$('#edit_description').val(data[0].description);
        	   			$('#edit_url').val(data[0].url);
        	   			$('#edit_icon').val(data[0].icon);
        	   			$('#edit_admin_flag').prop("checked",data[0].admin_flag == 'X' ? true : false );
       					return data;
                      },
       			   error:function(data){
                       alert("MYSQL-003:AJAX Update Error");
                      }
       			});
           
       }  
		
     /*---Button Action---*/
      //->New
    	$('#btn_new_submit').click(function(){
            var lvl = $("select[name='new_lvl_menu_code']").val().split("|");
            var _pid;
            var _path;
            
            if (lvl != '0'){
                var _pid = lvl[0];
                var _path = lvl[1];
            }else{
            	var _pid = '0';
            	var _path = '0,';
            }
                     	
    	var _type_code = $("select[name='new_type_code']").val();	
        var _menu_name = $('#new_menu_name').val();
        var _description = $('#new_description').val();
        var _url = $('#new_url').val();
        var _icon = $('#new_icon').val();
        var _admin_flag = $('#new_admin_flag').prop('checked');
        //var _where_use = $('#new_where_use').val();
        //var _seq = $('#new_seq').val();
        
        if (_admin_flag == true){
        	_admin_flag = 'X'; 
        }else{
            _admin_flag = '';
        }       
    
        var request=new XMLHttpRequest;
               $.ajax({
                type:"POST",
                dataType:"json",
                //url:"test_ajax_action.php?number="+$("#keywords").val(),
    			url:"menu_action_x.php",
    		    data:{action:'add', 
        		      arguments:{ 
        		      menu_name:   	  _menu_name,      
        		      type_code:   	  _type_code,           		      
        		      pid:  	  	  _pid,
        		      path:			  _path,        		      
        		      description:    _description,
        		      url:    		  _url,
        		      icon:			  _icon,
        		      admin_flag:	  _admin_flag,
    			      //where_use:  _where_use,    			      
    			      //seq: 		  _seq
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

       //->edit
		$('#btn_edit').click(function(){
			
// 			var obj_menu = $('#tree').find("input");
// 			var chk_menu;
// 			for(var i=0;i<obj_menu.length;i++){
// 				if (obj_menu[i].checked == true){
// 					chk_menu = obj_menu[i];	
// 					alert(chk_menu.id);
// 					break;
// 				}
				
// 			}
					
			//$('#edit_id').val(getSelectedRowFieldValue('#tab_01','id'));
			//$('#edit_storage_code').val(getSelectedRowFieldValue('#tab_01','storage_code'));
			//$('#edit_menu_code').val(getSelectedRowFieldValue('#tab_01','bin_code'));
			//$('#edit_description').val(getSelectedRowFieldValue('#tab_01','bin_text'));
			//$('#edit_where_use').val(getSelectedRowFieldValue('#tab_01','where_use'));	
			//$('#edit_seq').val(getSelectedRowFieldValue('#tab_01','seq'));		
			$('#btn_edit_submit').attr("disabled",($('#edit_id').val() == '' ? true : false ));	
		});
		
    	$('#btn_edit_submit').click(function(){
        var lvl = $("select[name='edit_lvl_menu_code']").val().split("|");
        var _pid;
        var _path;
                
        if (lvl != '0'){
            var _pid = lvl[0];
            var _path = lvl[1];
        }else{
        	var _pid = '0';
        	var _path = '0,';
        }
                	
        var _id = $('#edit_id').val();
        var _menu_name = $('#edit_menu_name').val();
        var _description = $('#edit_description').val();
        var _type_code = $("select[name='edit_type_code']").val();
        var _url = $('#edit_url').val();
        var _icon = $('#edit_icon').val();
        var _admin_flag = $('#edit_admin_flag').prop('checked');
        //var _seq = $('#edit_seq').val();
        //var _where_use = $('#edit_where_use').val();  
        
        if (_admin_flag == true){
        	_admin_flag = 'X'; 
        }else{
            _admin_flag = '';
        }            
    
        var request=new XMLHttpRequest;
               $.ajax({
                type:"POST",
                dataType:"json",
                //url:"test_ajax_action.php?number="+$("#keywords").val(),
    			url:"menu_action_x.php",
    		    data:{action:'edit', arguments:{
    			      id: 		 	_id,
    			      menu_name: 	_menu_name, 
    			      pid:   		_pid,
    			      path:   		_path,
    			      description:  _description,
    			      type_code:	_type_code,
    			      url:			_url,
    			      icon:			_icon,
    			      admin_flag:	_admin_flag,
    			      //where_use:  _where_use,    			      
    			      //seq: 		  _seq, 
				      currentPage: getQueryString("page"),
				      listRows: 10}},
                
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
//         var vals = [];
//         $.each($("input[name='chk_row[]']:checked"),function(){
//             vals.push($(this).val());
//         });

		//alert(getCheckboxValues('chk_row[]'));

		var _condition = '';
		var _keys = $('#edit_id').val();  

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
    				url:"menu_action_x.php",
    			    data:{action:'delete', arguments:{
    			    	  key: _key,
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
    				   if (data.page > 0){
        			     _condition = '?page='+data.page;
    				   }else{
        			     _condition = '';
        			   }
    				   window.location='menu_x.php' + _condition;
    	           	 },
						error:function(data){
        	                alert("encounter error");
        	            }
        			});	
                    
					//<-			
				}
		
	    	});
		//<--Delete 	   
	 	   

	    	
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

$obj = new classes\BASE\page();
$ado = new classes\DB\mysql_helper();
$tag = new classes\BASE\html();
/* ---Page Load--- */
//<-

//=====================================================================================================//
/* ---Build Toolbar--- */
//->
function build_toolbar(){
$_array_toolbar = [
    "TITLE" =>"菜单",
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

$_html =  $GLOBALS['obj']->build_action_toolbar($_array_toolbar);
return $_html;
};
/* ---Build Toolbar--- */
//<-

//=====================================================================================================//
/* ---Button New Modal--- */
//->
function eventregister_button_new(){
    $_menu_name = isset($_GET['new_menu_name']) ? $_GET['new_menu_name'] : "";
    $_description = isset($_GET['new_description']) ? $_GET['new_description'] : "";
    $_url = isset($_GET['new_url']) ? $_GET['new_url'] : "";
    $_icon = isset($_GET['new_icon']) ? $_GET['new_icon'] : "";
    $_path = isset($_GET['new_path']) ? $_GET['new_path'] : "";
    //$_where_use = isset($_GET['new_where_use']) ? $_GET['new_where_use'] : "";
    //$_seq = isset($_GET['new_seq']) ? $_GET['new_seq'] : "";
    
    $_body = "";
    $_body .= " <form class='form-horizontal'>";
    
    //->
    $_body .="<div class='form-row mb-1'> ";
    //--->
    $_body .=$GLOBALS['tag']->build_html_select(prepare_tag_type_new());
    $_body .=$GLOBALS['tag']->build_html_select(prepare_tag_lvl_menu_new());
    //<---
    $_body .="</div>";
    //<-
    
    //->
    $_body .="<div class='form-row mb-1'> ";
    //--->
    $_body .= " <div class='form-inline'>";
    $_body .= " <label for='new_menu_name' class='control-label mr-1'>名称</label>";
    $_body .= " <input type='text' class='form-control' style='width:120px' id='new_menu_name' name='new_menu_name' value='{$_menu_name}' placeholder='请输入菜单'>";
    $_body .= " </div>";
    //<---
    //--->
    $_body .= " <div class='form-inline'>";
    $_body .= " <label for='new_description' class='control-label mr-1'>描述</label>";
    $_body .= " <input type='text' class='form-control' style='width:300px' id='new_description' name='new_description' value='{$_description}' placeholder='请输入名称'>";
    $_body .= " </div>";
    //<---
    $_body .="</div>";
    //<-

    //->
    $_body .="<div class='form-row mb-1'> ";
    //--->
    $_body .= " <div class='form-inline'>";
    $_body .= " <label for='new_url' class='control-label mr-1'>地址</label>";
    $_body .= " <input type='text' class='form-control' style='width:600px' id='new_url' name='new_url' value='{$_url}' placeholder='请输入URL'>";
    $_body .= " </div>";
    //<---
    $_body .="</div>";
    //<-

    //->
    $_body .="<div class='form-row mb-1'> ";
    //--->
    $_body .= " <div class='form-inline'>";
    $_body .= " <label for='new_icon' class='control-label mr-1'>图标</label>";
    $_body .= " <input type='text' class='form-control' style='width:300px' id='new_icon' name='new_icon' value='{$_icon}' placeholder='请输入icon'>";
    $_body .= " </div>";
    //<---
    //--->
    $_body .=$GLOBALS['tag']->build_html_checkbox(prepare_tag_admin_new());
    //<---
    $_body .="</div>";
    //<-

    //->
    $_body .="<div class='form-row mb-1' hidden> ";
    //--->
    $_body .= " <div class='form-inline'>";
    $_body .= " <label for='new_path' class='control-label mr-1'>路径</label>";
    $_body .= " <input type='text' class='form-control' id='new_path' name='new_path' value='{$_path}'>";
    $_body .= " </div>";
    //<---
    $_body .="</div>";
    //<-
    
    /*
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


/* ---Button Edit Modal--- */
//->
function eventregister_button_edit(){
    $_id = isset($_GET['edit_id']) ? $_GET['edit_id'] : "";
    $_menu_name = isset($_GET['edit_menu_name']) ? $_GET['edit_menu_name'] : "";
    $_description = isset($_GET['edit_description']) ? $_GET['edit_description'] : "";
    $_url = isset($_GET['edit_url']) ? $_GET['edit_url'] : "";
    $_icon = isset($_GET['edit_icon']) ? $_GET['edit_icon'] : "";
    $_path = isset($_GET['edit_path']) ? $_GET['edit_path'] : "";
    //$_where_use = isset($_GET['edit_where_use']) ? $_GET['edit_where_use'] : "";
    //$_seq = isset($_GET['edit_seq']) ? $_GET['edit_seq'] : "";
    
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
    $_body .=$GLOBALS['tag']->build_html_select(prepare_tag_type_edit());
    $_body .=$GLOBALS['tag']->build_html_select(prepare_tag_lvl_menu_edit());
    //<---
    $_body .="</div>";
    //<-
    
    //->
    $_body .="<div class='form-row mb-1'> ";
    //--->
    $_body .= " <div class='form-inline'>";
    $_body .= " <label for='edit_menu_name' class='control-label mr-1'>名称</label>";
    $_body .= " <input type='text' class='form-control' style='width:120px' id='edit_menu_name' name='edit_menu_name' value='{$_menu_name}' placeholder='请输入菜单'>";
    $_body .= " </div>";
    //<---
    //--->
    $_body .= " <div class='form-inline'>";
    $_body .= " <label for='edit_description' class='control-label mr-1'>描述</label>";
    $_body .= " <input type='text' class='form-control' style='width:300px' id='edit_description' name='edit_description' value='{$_description}' placeholder='请输入名称'>";
    $_body .= " </div>";
    //<---
    $_body .="</div>";
    //<-
    
    //->
    $_body .="<div class='form-row mb-1'> ";
    //--->
    $_body .= " <div class='form-inline'>";
    $_body .= " <label for='edit_url' class='control-label mr-1'>地址</label>";
    $_body .= " <input type='text' class='form-control' style='width:600px' id='edit_url' name='edit_url' value='{$_url}' placeholder='请输入URL'>";
    $_body .= " </div>";
    //<---
    $_body .="</div>";
    //<-
    
    //->
    $_body .="<div class='form-row mb-1'> ";
    //--->
    $_body .= " <div class='form-inline'>";
    $_body .= " <label for='edit_icon' class='control-label mr-1'>图标</label>";
    $_body .= " <input type='text' class='form-control' style='width:300px' id='edit_icon' name='edit_icon' value='{$_icon}' placeholder='请输入icon'>";
    $_body .= " </div>";
    //<---
    //--->
    $_body .=$GLOBALS['tag']->build_html_checkbox(prepare_tag_admin_edit());
    //<---
    $_body .="</div>";
    //<-
    
    //->
    $_body .="<div class='form-row mb-1' hidden> ";
    //--->
    $_body .= " <div class='form-inline'>";
    $_body .= " <label for='edit_path' class='control-label mr-1'>路径</label>";
    $_body .= " <input type='text' class='form-control' id='edit_path' name='edit_path' value='{$_path}'>";
    $_body .= " </div>";
    //<---
    $_body .="</div>";
    //<-
    
    /*
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
    
    $_html = $GLOBALS['obj']->build_modal($_array_modal);
    return $_html;
}
/* ---Button Edit Modal--- */
//<-

/* ---Prepare Menu Treeview--- */
//->
function prepare_tag_menu_treeview(){
    $_array_tag = array();
    $_array_tag = [
        "TEST"  =>"Test Use...",
        "NAME"  => "",
        "DIV"   => [
            "CLASS" => "form-check-inline",
            "STYLE" => "",
            "ENHANCEMENT" =>"",
        ],
        "CHECKBOX" => [
            "ID" => "cb",
            "NAME" => "cb",
            "CLASS" => "check_menu",
            "CHECKED" =>"",
            "ENHANCEMENT" =>"",
        ],
        "SELECT" => [
            "ID" => "sel_01",
            "NAME" => "sel_01",
            "CLASS" => "form-control",
            "SQL" => "select * from tb_menu order by concat(path,id);",
            "ENHANCEMENT" =>"",
        ],
        "CHECKBOX_ENABLE" =>TRUE,
        "ENHANCEMENT" =>"",
    ];
    
    return $_array_tag;
};

/* ---Prepare Menu Treeview--- */
//<-

/* ---Build Menu Treeview--- */
//->
function build_treeview_menu(){
    $_html = "";
    $_html .= $GLOBALS['tag']->build_html_treeview_checkbox(prepare_tag_menu_treeview());
    return $_html;
}
/* ---Build Menu Treeview--- */
//<-

//--- Prepare Tag array Data ---//
function prepare_tag_type_new(){
    $_array_tag = array();
    $_array_tag = [
        "TEST"  =>"Test Use...",
        "NAME"  => "new_type_code",
        "DIV"   => [
            "CLASS" => "form-inline",
            "STYLE" => "",
            "ENHANCEMENT" =>"",
        ],
        "LABEL" => [
            "ID" => "lbl_new_type_code",
            "NAME" => "lbl_new_type_code",
            "FOR"  => "new_type_code",
            "CLASS" => "control-label mr-1",
            "TEXT"  => "类型" ,
            "ENHANCEMENT" =>"",
        ],
        "SELECT" => [
            "ID" => "new_type_code",
            "NAME" => "new_type_code",
            "CLASS" => "form-control",
            "SQL" => "select type_code as code, type_text as text from tb_type where where_use = 'tb_menu-type' group by type_code order by type_code",
            "ENHANCEMENT" =>"",
        ],
        "T_ENABLE" => TRUE,
        "T_CODE"  => "",
        "T_TEXT" => "--- 请选择 ---",
    ];
    
    return $_array_tag;
};

function prepare_tag_lvl_menu_new(){
    $_array_tag = array();
    $_array_tag = [
        "TEST"  =>"Test Use...",
        "NAME"  => "new_lvl_menu_code",
        "DIV"   => [
            "CLASS" => "form-inline",
            "STYLE" => "",
            "ENHANCEMENT" =>"",
        ],
        "LABEL" => [
            "ID" => "lbl_new_lvl_menu_code",
            "NAME" => "lbl_new_lvl_menu_code",
            "FOR"  => "new_lvl_menu_code",
            "CLASS" => "control-label mr-1",
            "TEXT"  => "上级菜单" ,
            "ENHANCEMENT" =>"",
        ],
        "SELECT" => [
            "ID" => "new_lvl_menu_code",
            "NAME" => "new_lvl_menu_code",
            "CLASS" => "form-control",
            "SQL" => "select concat(id ,'|',path,id,',') as code, menu_name as text from tb_menu order by concat(path,id);",
            "ENHANCEMENT" =>"",
        ],
        "T_ENABLE" => TRUE,
        "T_CODE"  => "0",
        "T_TEXT" => "顶层菜单",
    ];
    
    return $_array_tag;
};

function prepare_tag_admin_new(){
    $_array_tag = array();
    $_array_tag = [
        "TEST"  =>"Test Use...",
        "NAME"  => "",
        "DIV"   => [
            "CLASS" => "form-check-inline",
            "STYLE" => "",
            "ENHANCEMENT" =>"",
        ],
        "LABEL" => [
            "ID" => "lbl_admin_flag",
            "NAME" => "lbl_admin_flag",
            "FOR"  => "new_admin_flag",
            "CLASS" => "control-label mr-1",
            "TEXT"  => "后台标识",
            "ENHANCEMENT" =>"",
        ],
        "CHECKBOX" => [
            "ID" => "new_admin_flag",
            "NAME" => "new_admin_flag",
            "CLASS" => "form-check-input",
            "CHECKED" =>"",
            "ENHANCEMENT" =>"",
        ]
    ];
    
    return $_array_tag;
};

function prepare_tag_type_edit(){
    $_array_tag = array();
    $_array_tag = [
        "TEST"  =>"Test Use...",
        "NAME"  => "edit_type_code",
        "DIV"   => [
            "CLASS" => "form-inline",
            "STYLE" => "",
            "ENHANCEMENT" =>"",
        ],
        "LABEL" => [
            "ID" => "lbl_edit_type_code",
            "NAME" => "lbl_edit_type_code",
            "FOR"  => "edit_type_code",
            "CLASS" => "control-label mr-1",
            "TEXT"  => "类型" ,
            "ENHANCEMENT" =>"",
        ],
        "SELECT" => [
            "ID" => "edit_type_code",
            "NAME" => "edit_type_code",
            "CLASS" => "form-control",
            "SQL" => "select type_code as code, type_text as text from tb_type where where_use = 'tb_menu-type' group by type_code order by type_code",
            "ENHANCEMENT" =>"",
        ],
        "T_ENABLE" => TRUE,
        "T_CODE"  => "",
        "T_TEXT" => "--- 请选择 ---",
    ];
    
    return $_array_tag;
};

function prepare_tag_lvl_menu_edit(){
    $_array_tag = array();
    $_array_tag = [
        "TEST"  =>"Test Use...",
        "NAME"  => "edit_lvl_menu_code",
        "DIV"   => [
            "CLASS" => "form-inline",
            "STYLE" => "",
            "ENHANCEMENT" =>"",
        ],
        "LABEL" => [
            "ID" => "lbl_edit_lvl_menu_code",
            "NAME" => "lbl_edit_lvl_menu_code",
            "FOR"  => "edit_lvl_menu_code",
            "CLASS" => "control-label mr-1",
            "TEXT"  => "上级菜单" ,
            "ENHANCEMENT" =>"",
        ],
        "SELECT" => [
            "ID" => "edit_lvl_menu_code",
            "NAME" => "edit_lvl_menu_code",
            "CLASS" => "form-control",
            "SQL" => "select concat(id ,'|',path,id,',') as code, menu_name as text from tb_menu order by concat(path,id);",
            "ENHANCEMENT" =>"",
        ],
        "T_ENABLE" => TRUE,
        "T_CODE"  => "0",
        "T_TEXT" => "顶层菜单",
    ];
    
    return $_array_tag;
};

function prepare_tag_admin_edit(){
    $_array_tag = array();
    $_array_tag = [
        "TEST"  =>"Test Use...",
        "NAME"  => "",
        "DIV"   => [
            "CLASS" => "form-check-inline",
            "STYLE" => "",
            "ENHANCEMENT" =>"",
        ],
        "LABEL" => [
            "ID" => "lbl_admin_flag",
            "NAME" => "lbl_admin_flag",
            "FOR"  => "edit_admin_flag",
            "CLASS" => "control-label mr-1",
            "TEXT"  => "后台标识",
            "ENHANCEMENT" =>"",
        ],
        "CHECKBOX" => [
            "ID" => "edit_admin_flag",
            "NAME" => "edit_admin_flag",
            "CLASS" => "form-check-input",
            "CHECKED" =>"",
            "ENHANCEMENT" =>"",
        ]
    ];
    
    return $_array_tag;
};


//============Build Page Start=========
//---Build Toolbar---
echo build_toolbar();
echo build_treeview_menu();
echo eventregister_button_new();
echo eventregister_button_edit();
//----Build Table----
//echo build_table();
//============Build Page End=========

?>

<!-- End -->
</body>
</html>