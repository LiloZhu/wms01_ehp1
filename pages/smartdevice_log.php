<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>User</title>
<!-- CSS -->
<link rel="stylesheet" href="../plugins/bootstrap/css/bootstrap.min.css" />
<link rel="stylesheet" href="../plugins/bootstrap-table/bootstrap-table.min.css" />


<!--jquery-->
<script src="../plugins/jquery/jquery.min.js"></script>
<script src="../plugins/popper/umd/popper.min.js"></script>

<!-- Bootstrap 4 -->
<script src="../plugins/bootstrap/js/bootstrap.min.js"></script>
<!-- overlayScrollbars -->

<!--bootstrap-table-->
<script src="../plugins/bootstrap-table/bootstrap-table.min.js"></script>
<script src="../plugins/bootstrap-table/locale/bootstrap-table-zh-CN.min.js"></script>

<!-- Template -->
<script src="../plugins/handlebars.js/handlebars.min.js"></script>
<script src="../plugins/underscore/underscore-min.js"></script>
<script src="../plugins/backbone/backbone.js"></script>
<script src="../plugins/backbone/backbone.localStorage.min.js"></script>

<!-- AnjularJS -->
<script src="../plugins/angularJS/angular.min.js"></script>
<script src="../plugins/ngStorage/ngStorage.min.js"></script>

<!-- Current Page Script Action -->
<script>  
$(document).ready(function(){
//===> Begin
	$('title').text('智能设备记录');
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
<div id="smartdeviceMenuModalContainer"></div>

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

 <div class="p-2 ml-auto" smartdevice="toolbar">
{{#each this.attributes.button}}
<!--{{@index}} -->
  <div class="btn-group mr-1" smartdevice="group">
    <button type="button" id="{{id}}" class="{{class}}"
     data-toggle='modal' data-target='{{data_target}}'>{{text}}</button>
  </div>
{{/each}}
</div>

</div>
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
                <th data-field="{{field}}" data-formatter="{{formatter}}">{{title}}</th>
                 {{/if}}
                {{/each}}
			</tr>
		</thead>

	</table>
</div>
{{/with}}
</script>

<script type="text/template" id="search_template">
<div id="search" class="btn-group">
	<p>
	 <a class="btn btn-secondary" data-toggle="collapse" href="#searchCollapse" smartdevice="button" ng-click="searchCollapse()" id="searchCollapseButton" aria-expanded="false" aria-controls="searchCollapse">>></a>
	</p>

    <div class="collapse multi-collapse" id="searchCollapse">
      <div class="card card-body">
      	<!-- Body // -->
      <form class="form-inline">
      <div class="form-group" id="searchCompanyBlock">
      	<label for="searchCompanyCode">公司</label>
        <select class="selectpicker" id="searchCompanyCode" data-live-search="true" title="请选择" data-live-search-placeholder="搜索" >
        <option data-tokens="---ALL---"></option>
        </select>
 	   </div>
	 
      <div class="form-group">    
        <label for="dateFrom">日期</label>
        <input type="date" id="dateFrom" class="form-control mx-sm-3" placeholder='开始日期'>
       <label for="dateFrom">至</label>
        <input type="date" id="dateTo" class="form-control mx-sm-3" placeholder='结束日期'> 
      </div>

		<div align="right">
		 <button class="btn btn-primary" style="margin-right:10px;" ng-click="submitSearch()"><i class="fas fa-search fa-fw"></i>查询</button>
		</div> 
	  </form>
		<!-- Body \\ -->
      </div>
    </div>
</div>
</script>

<script type="text/template" id="spinner_template">
<div class="modal" tabindex="-1" smartdevice='dialog' style="display: none">
    <div class="modal-dialog modal-lg modal-dialog-centered  d-flex justify-content-center">
         <div class="spinner-border" smartdevice="status">
             <span class="sr-only">Loading...</span>
         </div>
    </div>
</div>
</script>

<script type="text/template" id="toolbar_modal_template"> 
</script>


<script type="text/template" id="smartdevice_menu_modal_template">
{{#with this}}
<div class="modal fade" id="{{this.id}}"  tabindex="-1" smartdevice='dialog' aria-labelledby="{{this.id}}Label">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="{{this.id}}Label">{{this.title}}</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        </div>
      
      <!-- Start -->    
      <div class="modal-body">
      <div class='form-horizontal'>
        
    <div class="table-responsive text-sm" style="min-height:630px">
	<table id="table_1" class="table-sm" data-toolbar="#toolbar" data-height="540"
		data-toggle="table" data-search="true"  data-ajax="{{ajax_request}}"
        data-show-columns="true"   data-minimum-count-columns="1"
        data-show-columns-toggle-all="true"
		data-side-pagination="client" data-pagination="false" searchOnEnterKey="false"
		data-click-to-select="true" data-single-select="false"  data-row-style="rowStyle_1"
		data-page-size="25">

		<thead style="background: #efefef;">
			<tr>
                {{#each this.columns}}
                 {{#if checkbox}}
                    <th data-field="{{field}}" data-checkbox="true" data-formatter="{{formatter}}"></th>
                 {{^}}  
                <th data-field="{{field}}">{{title}}</th>
                 {{/if}}
                {{/each}}
			</tr>
		</thead>

	</table>
    </div>

      </div>
      </div>
    <!--End-->

      <div class="modal-footer">
        <button type="button" class="btn btn-primary" id="{{this.id}}_submit" data-dismiss="modal"> 确认提交</button>
        <button type="button" class="btn btn-secondary" id="{{this.id}}_close"  data-dismiss="modal">关闭[Esc]</button>
      </div>
    </div>
  </div>
</div> 
{{/with}}
</script>


<script type="text/javascript">
Handlebars.registerHelper('ifCond', function (v1, operator, v2, options) {
    switch (operator) {
        case '==':
            return (v1 == v2) ? options.fn(this) : options.inverse(this);
        case '===':
            return (v1 === v2) ? options.fn(this) : options.inverse(this);
        case '!=':
            return (v1 != v2) ? options.fn(this) : options.inverse(this);
        case '!==':
            return (v1 !== v2) ? options.fn(this) : options.inverse(this);
        case '<':
            return (v1 < v2) ? options.fn(this) : options.inverse(this);
        case '<=':
            return (v1 <= v2) ? options.fn(this) : options.inverse(this);
        case '>':
            return (v1 > v2) ? options.fn(this) : options.inverse(this);
        case '>=':
            return (v1 >= v2) ? options.fn(this) : options.inverse(this);
        case '&&':
            return (v1 && v2) ? options.fn(this) : options.inverse(this);
        case '||':
            return (v1 || v2) ? options.fn(this) : options.inverse(this);
        default:
            return options.inverse(this);
    }
});
Handlebars.registerHelper('checkIf', function (v1,o1,v2,mainOperator,v3,o2,v4,options) {
    var operators = {
         '==': function(a, b){ return a==b},
         '===': function(a, b){ return a===b},
         '!=': function(a, b){ return a!=b},
         '!==': function(a, b){ return a!==b},
         '<': function(a, b){ return a<b},
         '<=': function(a, b){ return a<=b},
         '>': function(a, b){ return a>b},
         '>=': function(a, b){ return a>=b},
         '&&': function(a, b){ return a&&b},
         '||': function(a, b){ return a||b},
      }
    var a1 = operators[o1](v1,v2);
    var a2 = operators[o2](v3,v4);
    var isTrue = operators[mainOperator](a1, a2);
    return isTrue ? options.fn(this) : options.inverse(this);
});
</script>


<script  type = "text/javascript">
spinnerView = Backbone.View.extend({
    initialize: function(){
        this.render();
    },
    template: Handlebars.compile($('#spinner_template').html()),
    render: function(){
    	this.$el.html(this.template());
    },	
});
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
        		title: '智能设备记录',
        		//path: 'home>system>user',
                logo: '',
                button: [
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
//Toolbar modal
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
/*
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
*/
toolbarModalRefresh = new toolbarModalModel({id:'modal_refresh',title:'刷新'});
toolbarModalExport = new toolbarModalModel({id:'modal_export',title:'导出'});
toolbarModalCollectionData.add([
								/*
								toolbarModalNew,
								toolbarModalEdit,
								toolbarModalDelete,
								*/
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
  	   
  }  
  	
});

//->search
searchView = Backbone.View.extend({
    initialize: function(){
        this.render();
    },	
    template: Handlebars.compile($('#search_template').html()),
    render: function(){
    	this.$el.html(this.template());
    },    
});
//<-search
//->Table 
tableView = Backbone.View.extend({
	model: smartdeviceModel,
    initialize: function(){
        this.render();
    },
    template: Handlebars.compile($('#table_template').html()),
    render: function(){        
    	//this.$el.html(this.template(this.model));
    	this.$el.html(this.template(this.model));	
    }	
});
//<-Table 
//---> Ajax Request ---
//->smartdevice
var smartdeviceModel = Backbone.Model.extend({
	model: {}
  /*	
  urlRoot: 'user_ext_action.php',		
  sync: function(method, model, options) {
      options || (options = {});
      if (model)
         // return Backbone.sync(method, model, options);
      	var success = options.success;
      	 return Backbone.ajax({
       		url: _.result(model, 'url'),
      		type: "POST",
      		dataType: "json",
      	    data: model.get('data')
         }).then(function(oResp) {
             // sets the data you need from the response
             var resp = _.extend({}, {}, {
                rows: oResp
             });
             // fills the model and triggers the sync event
             success(resp);
             // transformed value returned by the promise
             return resp;
         });
  }
*/
});
var smartdeviceData = new smartdeviceModel({data:{url: 'smartdevice_ext_action.php', 
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
	    }, {
	        field: 'device_code',
	        title: '设备代码',  
	    }, 
	    {
	        field: 'device_text',
	        title: '设备名称',
	    },    
	    {
	        field: 'where_use',
	        title: '位置',
	    },
	    {
	        field: 'trigger_code',
	        title: '触发代码',
	    },	
	    {
	        field: 'status_text',
	        title: '状态',
	        formatter: 'displaycolor'
	    },	
	    {
	        field: 'create_at',
	        title: '日期',
	    },		
	    {
	        field: 'create_by_text',
	        title: '操作者',
	    },		        	        	    	    
	    //<-
	    ]
 }
});
tableView = Backbone.View.extend({
	//model: vtoolbarCollection.get('button_text'),
	model: smartdeviceData,
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
//var search_view = new searchView({ el: $("#searchContainer") });
var toolbarModal_view = new toolbarModalView({ el: $("#toolbarModalContainer") });
var table_view = new tableView({ el: $("#tableContainer") });
//->Main Table Source
function ajaxRequest(params){
	//debugger;
	$.ajax({
		url: "smartdevice_log_action.php",
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
</script>

<script type="text/javascript">
/*----------------------------Button Action----------------------------------
 *  
 * Name: btn_new, btn_edit, btn_delete, btn_refresh, btn_export 
 *
 *----------------------------Button Action---------------------------------*/
//->New
//<-New
//->Edit
$("#btn_edit").click(function(){
	var id;
	var action = '#modal_edit';
	var rows = getSelections();	
	if (rows == 'undefined' || rows == null || rows.length != 1)
	{	
		layer.alert('请仅只选择一条记录进行修改!');
		return;
	}else{
		$('' + action + 'id').val(rows[0].id);
		$('' + action + 'smartdevice_code').val( rows[0].smartdevice_code);
		$('' + action + 'smartdevice_text').val( rows[0].smartdevice_text);
		$(action).modal('toggle');
		
		/*
		var action		= '';
		var link_table  = 'tb_department';
		var field_value  = 'department_code';
		var field_text	 = 'department_text';
		var target_tag	 = 'department_code';
		var source_tag_1 = "company_code";
		var source_tag_2 = "";
		var source_tag_3 = "";
		
		var default_value = rows[0].department_code;
		onSetLinkToTagSelect(action,default_value,link_table,field_value,field_text,target_tag,source_tag_1,source_tag_2,source_tag_3);
		*/		
		
	}
});
//<-Edit
//->smartdevice Menu
$("#btn_smartdevice_menu").click(function(){
	var id;
	var action = '#modal_smartdevice_menu';
	var rows = getSelections();	
	if (rows == 'undefined' || rows == null || rows.length != 1)
	{	
		layer.alert('请仅只选择一条记录进行修改!');
		return;
	}else{
		$('#table_1').bootstrapTable('refresh');
		$(action).modal('toggle');
		
		/*
		var action		= '';
		var link_table  = 'tb_department';
		var field_value  = 'department_code';
		var field_text	 = 'department_text';
		var target_tag	 = 'department_code';
		var source_tag_1 = "company_code";
		var source_tag_2 = "";
		var source_tag_3 = "";
		
		var default_value = rows[0].department_code;
		onSetLinkToTagSelect(action,default_value,link_table,field_value,field_text,target_tag,source_tag_1,source_tag_2,source_tag_3);
		*/		
		
	}
});
//<-smartdevice Menu
/*----------------------------Modal Button Action---------------------------------
 *  
 * Name: modal_new_submit, modal_edit_submit, modal_delete_submit
 *       modal_new_close, modal_edit_close, modal_delete_close,
 *
 *----------------------------Modal Button Action--------------------------------*/  
//->Modal New
 $('#modal_new_submit').click(function(){
  var action = '#modal_new';
  var smartdevice_code = $('' + action + 'smartdevice_code').val();
  var smartdevice_text = $('' + action + 'smartdevice_text').val();
  var request=new XMLHttpRequest;
           $.ajax({
            type:"POST",
          dataType:"json",
            //url:"test_ajax_action.php?number="+$("#keywords").val(),
			url:"smartdevice_ext_action.php",
		    data:{action:'add', 
  		      arguments:{      		      
  		    	smartdevice_code:      smartdevice_code,
  		    	smartdevice_text:     	smartdevice_text,
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
   //<-New 
   
//->Edit
 $('#modal_edit_submit').click(function(){
  var action = '#modal_edit';
  
  var id = $('' + action + 'id').val();
  var smartdevice_code = $('' + action + 'smartdevice_code').val();
  var smartdevice_text = $('' + action + 'smartdevice_text').val();
  var request=new XMLHttpRequest;
           $.ajax({
            type:"POST",
          dataType:"json",
            //url:"test_ajax_action.php?number="+$("#keywords").val(),
			url:"smartdevice_ext_action.php",
		    data:{action:'edit', 
  		      arguments:{  
  		    	id: 		        id,				    		      
  		    	smartdevice_code:     		smartdevice_code,
  		    	smartdevice_text:     	    smartdevice_text,
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
			url:"smartdevice_log_action.php",
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
var app = angular.module("myapp",['ngStorage']);
app.controller("myctrl",function($scope,$localStorage,$sessionStorage,$http){
$scope.$storage = $localStorage;
$scope.companydata = [];	
$scope.datas = [];
$scope.count=0;
//<-End		
//angularJS<-
var $table = $('#table')
$('#table').bootstrapTable('hideColumn', 'id');
//<-End		
});

function displaycolor(value,row,index) {
	var a = "";
	if(value == "开"||value == "已通过") {
	var a = '<span style="color:green">'+value+'</span>';
	}else if(value == "关") {
		var a = '<span style="color:red">'+value+'</span>';		
	}else{
	var a = '<span>'+value+'</span>';
	}
	return a;
	};
</script>



</body>
</html>