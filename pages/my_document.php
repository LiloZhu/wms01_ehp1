<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Company</title>
<!-- CSS -->
<link rel="stylesheet" href="../plugins/fontawesome-free/css/all.min.css">
<link rel="stylesheet" href="../plugins/ionicons/css/ionicons.min.css">
<link rel="stylesheet" href="../plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
<link rel="stylesheet" href="../plugins/bootstrap/css/bootstrap.min.css" />
<link rel="stylesheet" href="../plugins/bootstrap-select/css/bootstrap-select.min.css">
<link rel="stylesheet" href="../plugins/bootstrap-table/bootstrap-table.min.css" />
<link rel="stylesheet" href="../plugins/bootstrap-editable/css/bootstrap-editable.css" />
<link rel="stylesheet" href="../plugins/TableExport/css/tableexport.min.css" />
<link rel="stylesheet" href="../plugins/layui/css/layui.css" />
<link rel="stylesheet" href="../css/global.css" />

<!--jquery-->
<script src="../plugins/jquery/jquery.min.js"></script>
<script src="../plugins/popper/umd/popper.min.js"></script>
<script src="../plugins/fontawesome-free/js/all.min.js"></script>

<!-- Bootstrap 4 -->
<script src="../plugins/bootstrap/js/bootstrap.min.js"></script>
<!-- overlayScrollbars -->
<script src="../plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>

<!--bootstrap-table-->
<script src="../plugins/bs-custom-file-input/bs-custom-file-input.min.js"></script>
<script src="../plugins/bootstrap-table/bootstrap-table.min.js"></script>
<script src="../plugins/bootstrap-table/locale/bootstrap-table-zh-CN.min.js"></script>
<script src="../plugins/bootstrap-table/extensions/editable/bootstrap-table-editable.min.js"></script>
<script src="../plugins/bootstrap-editable/js/bootstrap-editable.min.js"></script>
<script src="../plugins/bootstrap-table/extensions/export/bootstrap-table-export.min.js"></script>
<script src="../plugins/bootstrap-select/js/bootstrap-select.min.js"></script>
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


<!-- Current Page Script Action -->
<script>  
$(document).ready(function(){
//===> Begin
	$('title').text('文件管理');
//<=== End
});
</script>
</head>

<body ng-app="myapp" ng-controller="myctrl">
<!-- Toolbar Container -->
<div id="spinnerContainer"></div>
<div id="toolbarContainer"></div>
<div id="searchContainer"></div>
<div id="tableContainer"></div>
<div id="toolbarModalContainer"></div>

<!-- handbar toolbar Template -->
<script type="text/template" id="toolbar_template">
<div class="d-flex mb-2 bd-highlight">
  <div class="p-2 align-self-center">
  {{#with this}}
    <a class="navbar-brand align-self-center" href="#">
      <!-- <img src="" alt="" width="30" height="24" class="d-inline-block align-text-top"> -->
      {{this.attributes.title}}
    </a>
  </div>
 <div class="p-2 align-self-center">
    {{this.attributes.path}}
 </div>
  {{/with}}

 <div class="p-2 ml-auto" role="toolbar">
{{#each this.attributes.button}}
<!--{{@index}} -->
  <div class="btn-group mr-1" role="group">
    <button type="button" id="{{id}}" class="{{class}}"
     data-toggle='modal' data-target='{{data_target}}'>{{text}}</button>
  </div>
{{/each}}
</div>
</div>
</script>

<script type="text/template" id="spinner_template">
<div class="modal" tabindex="-1" role='dialog' style="display: {{#ifCond this.attributes.display '==' true}}  block {{else}} none {{/ifCond}}">
    <div class="modal-dialog modal-lg modal-dialog-centered  d-flex justify-content-center">
         <div class="spinner-border" role="status">
             <span class="sr-only">Loading...</span>
         </div>
    </div>
</div>
</script>

<script type="text/template" id="toolbar_modal_template">
{{#each this}}
{{#checkIf this.attributes.id '==' 'modal_new' '||' this.attributes.id '==' 'modal_edit' }}
<!--{{this.attributes.id}} -->
<div class="modal fade" id="{{this.attributes.id}}"  tabindex="-1" role='dialog' aria-labelledby="{{this.attributes.id}}Label">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="{{this.attributes.id}}Label">{{this.attributes.title}}</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        </div>
      
      <!-- Start -->    
      <div class="modal-body">
        <div class='form-horizontal'>
       
    <!-- Row Start -->
    <div class='form-row mb-1' hidden>
    
    <div class='form-inline'>
    <label for='{{this.attributes.id}}id' class='control-label mr-1'>ID</label>
    <input type='text' class='form-control' id='{{this.attributes.id}}id' name='{{this.attributes.id}}id'>
    </div>
    
    </div>
    <!-- Row End -->

    <!-- Row Start -->
    <div class='form-row mb-1'>
    
    <div class='form-inline'>
    <label for='{{this.attributes.id}}document_code' class='control-label mr-1'>代码</label>
    <input type='text' class='form-control' style='width:120px' id='{{this.attributes.id}}document_code' name='{{this.attributes.id}}document_code'>
    </div>
    
    
    <div class='form-inline'>
    <label for='{{this.attributes.id}}document_text' class='control-label mr-1'>名称</label>
    <input type='text' class='form-control' style='width:400px' id='{{this.attributes.id}}document_text' name='{{this.attributes.id}}document_text'>
    </div>
    
    </div>
    <!-- Row End -->

    <!-- Row Start -->
    <div class='form-row mb-1'>
    
    <div class='form-inline'>
    <label for='{{this.attributes.id}}description' class='control-label mr-1'>描术</label>
    <input type='text' class='form-control' style='width:550px' id='{{this.attributes.id}}description' name='{{this.attributes.id}}description'>
    </div>
    
    </div>
    <!-- Row End -->

    <!-- Row Start -->
    <div class='form-row mb-1'>    
    <div class='input-group form-inline' style="width: 584px;">
    <label for='{{this.attributes.id}}file_upload' class='control-label mr-1'>上传</label>
    <div class="custom-file">
         <input type="file" class="custom-file-input" style='width:550px' id='{{this.attributes.id}}file_upload'>
         <label class="custom-file-label" for='{{this.attributes.id}}file_upload'>选择文件</label>
    </div>
    </div>
    </div>
    <!-- Row End -->

    
       
        <!--End-->
        </div>
      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-primary" id="{{this.attributes.id}}_submit" data-dismiss="modal"> 确认提交</button>
        <button type="button" class="btn btn-secondary" id="{{this.attributes.id}}_close"  data-dismiss="modal">关闭[Esc]</button>
      </div>
    </div>
  </div>
</div> 
{{/checkIf}}

{{/each}}    
</script>

<script type="text/template" id="table_template">
{{#with this}}
<div class="table-responsive text-sm" style="min-height:730px">
	<table id="table" class="table-sm" data-toolbar="#toolbar"
		data-toggle="table" data-search="true"  data-ajax="{{ajax_request}}"
		data-side-pagination="client" data-pagination="true" searchOnEnterKey="false"
		data-click-to-select="true" data-single-select="true"  data-row-style="rowStyle"
		data-page-size="25">

		<thead style="background: #efefef;">
			<tr>
                {{#each this.columns}}
                 {{#if checkbox}}
                    <th data-field="{{field}}" data-checkbox="true"></th>
                 {{^}}
                  {{#if formatter}} 
                     <th data-field="{{field}}" data-formatter="{{formatter}}">{{title}}</th>
                  {{^}}
                     <th data-field="{{field}}"  >{{title}}</th>
                  {{/if}}
                 {{/if}}
                {{/each}}
			</tr>
		</thead>

	</table>
</div>
{{/with}}
</script>


<script>
//---spinnner---
spinnerModel = Backbone.Model.extend({});
spinnerModelData = new spinnerModel({
	display : false
});
spinnerView = Backbone.View.extend({
	model: spinnerModelData,
    initialize: function(){
        this.render();
    },
    template: Handlebars.compile($('#spinner_template').html()),
    render: function(){
    	//this.$el.html(this.template());
    	this.$el.html(this.template(this.model));
    },	
});


//---toolbar---
toolbarModel = Backbone.Model.extend({
    default: function(){
    	return {
        		title: 'MyIDES',
                logo: '',
    			button:[{
        				 text: '',
        				 target_target: '',
        			   }]
    		   }
    },
    initialize: function(){
            this.set({
        		title: '文档管理',
        		//path: 'home>system>user',
                logo: '',
                button: [{
                    id: 'btn_new',
				    text: '新增',
				    data_target: '#modal_new',
				    class:'btn top btn-primary btn_modal toolbar_action',
                },
                {
                	id: 'btn_edit',
   				 	text: '编辑',
   				    //data_target: '#modal_edit',
   				 	class:'btn btn-success btn_modal toolbar_action',
                },              
                {
                	id: 'btn_delete',
      				text: '删除',
      				data_target: '#modal_delete',
      			 	class:'btn btn-danger btn_modal toolbar_action',
                }, 
                {
                	id: 'btn_refresh',
         			text: '刷新',
         			data_target: '#modal_refresh',
         			class:'btn btn-warning btn_modal toolbar_action',
                }, 
                {
                	id: 'btn_export',
        			text: '导出',
        			data_target: '#modal_export',
        			class:'btn btn-info toolbar btn_modal toolbar_action',
                }]                                                              
           })
    }
    	
});
toolbarCollection = Backbone.Collection.extend({
	model: toolbarModel,
	initialize: function(){
		console.log('toolbarCollection initialize success!');
	}
});
toolbarData = new toolbarModel();
toolbarCollectionData = new toolbarCollection(toolbarData);
toolbarView = Backbone.View.extend({
	//model: vtoolbarCollection.get('button_text'),
	collection: toolbarCollectionData,
    initialize: function(){
        this.render();
    },
    events: {
        'click .toolbar_action': 'btn_handle'      
    }, 
    template: Handlebars.compile($('#toolbar_template').html()),
    render: function(){
    	//this.$el.html(this.template(this.model));
    	//this.$el.html(this.template(this.collection.get('c1').get('button_text')));
    	this.$el.html(this.template(this.collection.models[0]));
    },
    btn_handle: function(event){
        
        switch(event.currentTarget.id){
          case 'btn_new':
        	  //alert('新增');
        	  var action = '#modal_new'
        	  //$('#company_code').val('IBM');
            	//alert('backbone view -> button new function')
              break;
          case 'btn_edit':
        	  //alert('编辑');
              break;
          case 'btn_delete':
        	  //alert('删除');
              break;   
          case 'btn_refresh':
        	  //alert('刷新');
              break;                   
          case 'btn_export':
        	  //alert('导出');
              break;                            
        }
        
    } 
         
});

//---Toolbar modal---
toolbarModalModel = Backbone.Model.extend({
  default: function(){
  	return {
  			id:'',
  			title: ''
      	   }
  },
  initialize: function(){
  }
  	
});
toolbarModalCollection = Backbone.Collection.extend({
	model: toolbarModalModel,
	initialize: function(){
		console.log('toolbarModalModel initialize success!');
	}
	
});
toolbarModalCollectionData = new toolbarModalCollection();
toolbarModalNew = new toolbarModalModel({id:'modal_new',
										 title:'新增',
										 company:[
											 	{code:'SAP',text:'SAP公司'},
											 	{code:'IBM',text:'IBM公司'},
											 	{code:'ORACLE',text:'ORACLE公司'},
											     ]
										});
toolbarModalEdit = new toolbarModalModel({id:'modal_edit',title:'编辑'});
toolbarModalDelete = new toolbarModalModel({id:'modal_delete',title:'删除'});
toolbarModalRefresh = new toolbarModalModel({id:'modal_refresh',title:'刷新'});
toolbarModalExport = new toolbarModalModel({id:'modal_export',title:'导出'});
toolbarModalCollectionData.add([toolbarModalNew,
								toolbarModalEdit,
								toolbarModalDelete,
								toolbarModalRefresh,
								toolbarModalExport
							  ]);							  
toolbarModalView = Backbone.View.extend({
  collection: toolbarModalCollectionData,
  initialize: function(){
      this.render();
  },
  template: Handlebars.compile($('#toolbar_modal_template').html()),
  render: function(){  
  	this.$el.html(this.template(this.collection.models));
  },
  events: {
      'click #modal_new_submit': 'modal_new_submit_handle'      
  }, 
  modal_new_submit_handle: function(event){
  	   //alert('modal submit')
  }  
  	
});

//---Table---
tableModel = Backbone.Model.extend();
tableModelData = new tableModel({data:{url: 'my_document_action.php', 
	action:'retrieve', 
	arguments:{ 	
		      
    },
    ajax_request: "ajaxRequest",
    columns: [
	//->    
    {		
    	title: '选择',
      checkbox: true
    },		    
	{
        field: 'id',
        title: 'Id'
    }, 
    {
        field: 'document_code',
        title: '文档代码',  
    }, 
    {
        field: 'document_text',
        title: '文档名称',  
    }, 	    
    {
        field: 'description',
        title: '描述',
    }, 
    {
        field: 'file_name',
        title: '文件名',
    },       
    {
        field: 'file_type',
        title: '文件类型',
    },     
    {
        field: 'file_size',
        title: '文件大小（kb)',
    },    
    {
        field: 'path',
        title: '下载',
        formatter: 'displayDownload'
    },            
    {
        field: 'create_at',
        title: '创建时间',  
    }, 
    {
        field: 'create_by_text',
        title: '创建者',
    },  
    {
        field: 'change_at',
        title: '修改时间',
    },  	    	       
    {
        field: 'change_by_text',
        title: '修改者',
    },  	    	    
    //<-
    ]
}
});

tableView = Backbone.View.extend({
	//model: vtoolbarCollection.get('button_text'),
	model: tableModelData,
    initialize: function(){
        this.render();
    },
    events: {
        'click .toolbar_action': 'btn_handle'      
    }, 
    template: Handlebars.compile($('#table_template').html()),
    render: function(){
    	this.$el.html(this.template(this.model.get('data')));
    }
});


//->Populate to View
var spinner_view = new spinnerView({ el: $("#spinnerContainer") });
var toolbar_view = new toolbarView({ el: $("#toolbarContainer") });
var toolbarModal_view = new toolbarModalView({ el: $("#toolbarModalContainer") });
var main_table_view = new tableView({ el: $("#tableContainer") });
bsCustomFileInput.init();

//->Main Table Source
function ajaxRequest(params){
	var vCompanyCode;
	//vCompanyCode = $('#searchCompanyCode').val()	
	
	//debugger;
	$.ajax({
		url: "my_document_action.php",
		type: "POST",
		dataType: "json",
	    data:{action:'retrieve', 
  		      arguments:{   
  		    	//company_code: vCompanyCode,    
			      }
				},				
		success: function(rs){
			console.log(rs)
			var rows = rs.rows;
			//$('#table').bootstrapTable('refresh');
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
</script>

<script type="text/javascript">
/*----------------------------Modal Button Action---------------------------------
 *  
 * Name: modal_new_submit, modal_edit_submit, modal_delete_submit
 *       modal_new_close, modal_edit_close, modal_delete_close,
 *
 *----------------------------Modal Button Action--------------------------------*/  
//->Modal New
 $('#modal_new_submit').click(function(){
  var action = '#modal_new';
  var document_code = $('' + action + 'document_code').val();
  var document_text = $('' + action + 'document_text').val();
  var description = $('' + action + 'description').val();
  
  var file_data = $('' + action + 'file_upload').prop('files')[0];   
  var form_data = new FormData();                  
      form_data.append('file', file_data);
      form_data.append('action','add');
      form_data.append('document_code',document_code);
      form_data.append('document_text',document_text);
      form_data.append('description',description);

     
  var request=new XMLHttpRequest;
      $.ajax({
          type:"POST",
          dataType:"json",          
          url: 'my_document_action.php', // <-- point to server-side PHP script 
          cache: false,
          contentType: false,
          processData: false,
		  data: form_data, 
		  /*
		  data:{action:'add', 
  		      arguments:{  
  		    	file_data: 	form_data,
			      }
				},	
		*/
          success: function(data){
				//alert(data.action); 
				//location.reload();
        	  $('#table').bootstrapTable('refresh');
          },
			error:function(data){
              alert("MYSQL-0002:Ajax Create Error - "+ data.responseText);
          }
          
       });
	});
   //<-New 
   
//->Edit
 $('#modal_edit_submit').click(function(){
  var action = '#modal_edit';
  
  var id = $('' + action + 'id').val();
  var company_code = $('' + action + 'company_code').val();
  var company_text = $('' + action + 'company_text').val();
  var address = $('' + action + 'address').val();
  var tel_number = $('' + action + 'tel_number').val();
  var tel_extens = $('' + action + 'tel_extens').val();  
  var mobile = $('' + action + 'mobile').val();  
  var fax = $('' + action + 'fax').val();  
  var request=new XMLHttpRequest;
           $.ajax({
            type:"POST",
          dataType:"json",
            //url:"test_ajax_action.php?number="+$("#keywords").val(),
			url:"company_ext_action.php",
		    data:{action:'edit', 
  		      arguments:{  
  		    	id: 		       id,				    		      
  		    	company_code:      company_code,
  		    	company_text:      company_text,
  		    	address:		   address,
  		    	tel_number:		   tel_number,
  		    	tel_extens:        tel_extens,	
  		    	mobile:			   mobile,
  		    	fax:			   fax	
			      }
				},
            
            success: function(data){
				//alert(data.message);
	   			
               if(data.success){
                  $("#message").html("["+data.message+"]");
               }else{
                  $("#message").html("MYSQL-0001:Parameter Error "+data.message); 
               }
				//location.reload();
				$('#table').bootstrapTable('refresh');
				$("modal_new").modal('hide');
            },
			error:function(data){
                alert("MYSQL-0002:Ajax Create Error - "+ data.responseText);
            }
		});
});
//<-Edit  
   
    //->delete    
    $('#btn_delete').click(function(){
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
			url:"my_document_action.php",
			data:{action:'delete', arguments:{
				  key: ids[0].id,
				  path: ids[0].path
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
					 $('#table').bootstrapTable('refresh');
       		 
					 layer.msg('删除成功');
	           	 },
				error:function(data){
	                alert("encounter error - "+ data.responseText);
	            }
			});	       
		//<-			
	};
	//<-Delete 
//获得选中的数据，为一个对象数组
function getSelections() {
	return $.map($('#table').bootstrapTable('getSelections'), function(row) {
		return row; 
	});
};
function getSelectionRows(tableId) {
	return $.map($(tableId).bootstrapTable('getSelections'), function(row) {
		return row; 
	});
};
function chkFormatter(value, row, index) {
    if (row.active == 'X')
        return {
            //disabled : true,//设置是否可用
            checked : true//设置选中
        };
    return value;
}
</script>

<script type="text/javascript">
layui.use('layer', function(){ //独立版的layer无需执行这一句
	  var layer = layui.layer; //独立版的layer无需执行这一句
	 });
		
	var app = angular.module("myapp",[]);
	app.controller("myctrl",function($scope,$http){
		
		$scope.isdataShow=true;
		$scope.istableShow=true;
		$scope.ismessageShow=false;
		$scope.datas = [];
		$scope.count=0;

//<-End		
//angularJS<-

var $table = $('#table')
$('#table').bootstrapTable('hideColumn', 'id');

//<-End		
});	

function displayDownload(value,row,index) {
	var a = "<span><a href='"+value+"'>下载</span>";
	return a;
	};		

</script>



</body>
</html>