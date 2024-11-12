<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>User</title>
<!-- CSS -->
<link rel="stylesheet" href="../../plugins/bootstrap/css/bootstrap.min.css" />
<link rel="stylesheet" href="../../plugins/bootstrap-select/css/bootstrap-select.min.css">
<link rel="stylesheet" href="../../plugins/bootstrap-table/bootstrap-table.min.css" />
<link rel="stylesheet" href="../../plugins/bootstrap-editable/css/bootstrap-editable.css" />
<link rel="stylesheet" href="../../plugins/TableExport/css/tableexport.min.css" />
<link rel="stylesheet" href="../../plugins/layui/css/layui.css" />

<!--jquery-->
<script src="../../plugins/jquery/jquery.min.js"></script>
<script src="../../plugins/popper/umd/popper.min.js"></script>
<script src="../../plugins/fontawesome-free/js/all.min.js"></script>

<!-- Bootstrap 4 -->
<script src="../../plugins/bootstrap/js/bootstrap.min.js"></script>
<!-- overlayScrollbars -->
<script src="../../plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>

<!--bootstrap-table-->
<script src="../../plugins/bootstrap-table/bootstrap-table.min.js"></script>
<script src="../../plugins/bootstrap-table/locale/bootstrap-table-zh-CN.min.js"></script>
<script src="../../plugins/bootstrap-table/extensions/editable/bootstrap-table-editable.min.js"></script>
<script src="../../plugins/bootstrap-editable/js/bootstrap-editable.min.js"></script>
<script src="../../plugins/bootstrap-table/extensions/export/bootstrap-table-export.min.js"></script>
<script src="../../plugins/bootstrap-select/js/bootstrap-select.min.js"></script>

<script src="../../plugins/moment/moment.min.js"></script>
<script src="../../plugins/layui/layui.js"></script>

<!-- Template -->
<script src="../../plugins/handlebars.js/handlebars.min.js"></script>
<script src="../../plugins/underscore/underscore-min.js"></script>
<script src="../../plugins/backbone/backbone.js"></script>
<script src="../../plugins/backbone/backbone.localStorage.min.js"></script>

<!-- AnjularJS -->
<script src="../../plugins/angularJS/angular.min.js"></script>
<script src="../../plugins/ngStorage/ngStorage.min.js"></script>


<!-- Current Page Script Action -->
<script>  
$(document).ready(function(){
//===> Begin
	$('title').text('用户管理');
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

<script type="text/template" id="table_template">
<div class="table-responsive text-sm" style="min-height:730px">
	<table id="table" class="table-sm" data-toolbar="#toolbar"
		data-toggle="table" data-search="true"
		data-side-pagination="client" data-pagination="true" searchOnEnterKey="false"
		data-click-to-select="true" data-single-select="true"  data-row-style="rowStyle"
		data-page-size="25">
        <!--
		<thead style="background: #efefef;">
			<tr>
                {{#each this}}
                 {{#if checkbox}}
                    <th data-checkbox="true"></th>
                 {{^}}  
                <th data-field="{{text}}" >{{text}}</th>
                 {{/if}}
                {{/each}}
			</tr>
		</thead>
        -->

	</table>
</div>
</script>

<script type="text/template" id="search_template">
<div id="search" class="btn-group">
	<p>
	 <a class="btn btn-secondary" data-toggle="collapse" href="#searchCollapse" role="button" ng-click="searchCollapse()" id="searchCollapseButton" aria-expanded="false" aria-controls="searchCollapse">>></a>
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
<div class="modal" tabindex="-1" role='dialog' style="display: none">
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
    <label for='{{this.attributes.id}}user_code' class='control-label mr-1'>代码</label>
    <input type='text' class='form-control' style='width:120px' id='{{this.attributes.id}}user_code' name='{{this.attributes.id}}user_code' placeholder='请输入代码'>
    </div>
    
    
    <div class='form-inline'>
    <label for='{{this.attributes.id}}user_text' class='control-label mr-1'>名称</label>
    <input type='text' class='form-control' style='width:400px' id='{{this.attributes.id}}user_text' name='{{this.attributes.id}}user_text' placeholder='请输入名称'>
    </div>
    
    </div>
    <!-- Row End -->
    
    <!-- Row Start -->
    <div class='form-row mb-1' hidden>
    
    <div class='form-inline'>
    <label for='{{this.attributes.id}}password' class='control-label mr-1'>密码</label>
    <input type='password' class='form-control' id='{{this.attributes.id}}password' name='{{this.attributes.id}}password'>
    </div>
    
    </div>
    <!-- Row End -->
    
    <!-- Row Start -->
    <div class='form-row mb-1'>
    
    <div class='form-inline'>
    <label for='{{this.attributes.id}}new_password' class='control-label mr-1'>密码</label>
    <input type='password' class='form-control' style='width:300px' id='{{this.attributes.id}}new_password' name='{{this.attributes.id}}new_password' placeholder='请输入新密码'>
    </div>
    
    </div>
    <!-- Row End -->

    
    <!-- Row Start -->
    <div class='form-row mb-1'>
    <div class='form-inline'id="{{this.attributes.id}}companyContainer"></div>
    <div class='form-inline'id="{{this.attributes.id}}departmentContainer"></div>
    <div class='form-inline'id="{{this.attributes.id}}divisionContainer"></div>
    </div>
    <!-- Row End -->

    <!-- Row Start -->
    <div class='form-row mb-1'>
    <div class='form-inline'id="{{this.attributes.id}}titleContainer"></div>
    <div class='form-inline'id="{{this.attributes.id}}jobContainer"></div>
    <div class='form-inline'id="{{this.attributes.id}}cost_centerContainer"></div>
    </div>
    <!-- Row End -->

    <!-- Row Start -->
    <div class='form-row mb-1'>
  
    <div class='form-inline'>
    <label for='{{this.attributes.id}}email' class='control-label mr-1'>邮箱</label>
    <input type='text' class='form-control' id='{{this.attributes.id}}email' name='{{this.attributes.id}}email'>
    </div>
    
    </div>
    <!-- Row End -->

    <!-- Row Start -->
    <div class='form-row mb-1'>
  
    <div class='form-inline'>
    <label for='{{this.attributes.id}}telphone' class='control-label mr-1'>电话</label>
    <input type='text' class='form-control' id='{{this.attributes.id}}telphone' name='{{this.attributes.id}}telphone'>
    </div>
    
    </div>
    <!-- Row End -->

    <!-- Row Start -->
    <div class='form-row mb-1'>
  
    <div class='form-inline'>
    <label for='{{this.attributes.id}}mobile' class='control-label mr-1'>手机</label>
    <input type='text' class='form-control' id='{{this.attributes.id}}mobile' name='{{this.attributes.id}}mobile'>
    </div>
    
    </div>
    <!-- Row End -->

    <!-- Row Start -->
    <div class='form-row mb-1'>
  
    <div class='form-inline'>
    <label for='{{this.attributes.id}}active' class='form-check-label mr-1'>有效标识</label>
    <input type='checkbox' class='form-check-input' id='{{this.attributes.id}}active' name='{{this.attributes.id}}active'>
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

<script type="text/template" id="company_template">

<label for='{{this.id}}company_code' class='control-label mr-1'>公司</label>
<select id='{{this.id}}company_code' class='form-control'>
    {{#each this.company}}
    <option value='{{code}}'>{{text}}</option>
    {{/each}}
</select>
</script>

<script type="text/template" id="department_template">
<label for='{{this.id}}department_code' class='control-label mr-1'>部门</label>
<select id='{{this.id}}department_code' class='form-control'>
    {{#each this.department}}
    <option value='{{code}}'>{{text}}</option>
    {{/each}}
</select>
</script>

<script type="text/template" id="division_template">
<label for='{{this.id}}division_code' class='control-label mr-1'>项目组</label>
<select id='{{this.id}}division_code' class='form-control'>
    {{#each this.division}}
    <option value='{{code}}'>{{text}}</option>
    {{/each}}
</select>
</script>

<script type="text/template" id="title_template">
<label for='{{this.id}}title_code' class='control-label mr-1'>称谓</label>
<select id='{{this.id}}title_code' class='form-control'>
    {{#each this.title}}
    <option value='{{code}}'>{{text}}</option>
    {{/each}}
</select>
</script>

<script type="text/template" id="job_template">
<label for='{{this.id}}job_code' class='control-label mr-1'>职位</label>
<select id='{{this.id}}job_code' class='form-control'>
    {{#each this.job}}
    <option value='{{code}}'>{{text}}</option>
    {{/each}}
</select>
</script>

<script type="text/template" id="cost_center_template">
<label for='{{this.id}}cost_center_code' class='control-label mr-1'>成本中心</label>
<select id='{{this.id}}cost_center_code' class='form-control'>
    {{#each this.cost_center}}
    <option value='{{code}}'>{{text}}</option>
    {{/each}}
</select>
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
        		title: '用户',
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
                	id: 'btn_rfid',
   				 	text: '发卡',
   				    data_target: '#modal_rfid',
   				 	class:'btn btn-primary btn_modal toolbar_action',
                },
                {
                	id: 'btn_print',
   				 	text: '打印',
   				    data_target: '#modal_print',
   				 	class:'btn btn-primary btn_modal toolbar_action',
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
    initialize: function(){
        this.render();
    },
    template: Handlebars.compile($('#table_template').html()),
    render: function(){        
    	//this.$el.html(this.template(this.model));
    	this.$el.html(this.template(this.collection));	
    }	
});
//---> Ajax Request ---
//->Company
var companyModel = Backbone.Model.extend({
	urlRoot: 'common_action.php',		
  sync: function(method, model, options) {
      options || (options = {});
      if (model)
         // return Backbone.sync(method, model, options);
      	var success = options.success;
      	 return Backbone.ajax({
       		url: _.result(model, 'url')?_.result(model, 'url'):model.get('data').url,
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
});
var company = new companyModel({data:{url: 'user_ext_action.php', 
	action:'special_select', 
		arguments:{ 
			field_code: 'company_code',
			field_text: 'company_text',
			link_table: 'tb_company'	      
	    },  
 }
});
CompanyView = Backbone.View.extend({
	collection: toolbarModalCollectionData,
    initialize: function(){
        this.render();
    },
    template: Handlebars.compile($('#company_template').html()),
    render: function(){        
    	//this.$el.html(this.template(this.collection.get('modal_new').get('company')));
    	//this.$el.html(this.template(this.collection.company));
    	this.$el.html(this.template(this.collection));
    	//this.$el.html(this.template());	
    }	
});
company.fetch().then(function (resp) {
	  console.log(company.get('rows'));
	  //toolbarModalNew.company = company.get('rows');
	  //---Modal New---
	  toolbarModalCollectionData.company = company.get('rows').rows;
	  toolbarModalCollectionData.id = 'modal_new';
	  var company_view_new = new CompanyView({ el: $("#modal_newcompanyContainer") });
	  //---Modal Edit---
	  toolbarModalCollectionData.company = company.get('rows').rows;
	  toolbarModalCollectionData.id = 'modal_edit';	  
	  var company_view_edit = new CompanyView({ el: $("#modal_editcompanyContainer") });
     /*		
	 $("#searchCompanyCode").empty();
	 if (company.get('rows').rows > 0){
		$("#searchCompanyCode").append('<option  value="">---ALL---</option>');
	 }
	
	 $.each(company.get('rows').rows, function (i, item) {
		$("#searchCompanyCode").append('<option  value="' + item.code + '">' + item.text + '</option>');
	 });
	$('#searchCompanyCode').selectpicker('refresh');
	*/
	//<---Searc Company			
  
	
});
//<-Company
//<--- Ajax Request ---
//---> Ajax Request ---
//->department
var departmentModel = Backbone.Model.extend({
	urlRoot: 'common_action.php',		
  sync: function(method, model, options) {
      options || (options = {});
      if (model)
         // return Backbone.sync(method, model, options);
      	var success = options.success;
      	 return Backbone.ajax({
       		url: _.result(model, 'url')?_.result(model, 'url'):model.get('data').url,
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
});
var department = new departmentModel({data:{url: 'user_ext_action.php', 
	action:'special_select', 
		arguments:{ 
			field_code: 'department_code',
			field_text: 'department_text',
			link_table: 'tb_department'	      
	    },  
 }
});
departmentView = Backbone.View.extend({
	collection: toolbarModalCollectionData,
    initialize: function(){
        this.render();
    },
    template: Handlebars.compile($('#department_template').html()),
    render: function(){        
    	//this.$el.html(this.template(this.collection.get('modal_new').get('department')));
    	this.$el.html(this.template(this.collection));
    	//this.$el.html(this.template());	
    }	
});
department.fetch().then(function (resp) {
	  console.log(department.get('rows'));
	  //toolbarModalNew.department = department.get('rows');
	  toolbarModalCollectionData.id = 'modal_new';	 
	  toolbarModalCollectionData.department = department.get('rows').rows;
	  var department_view_new = new departmentView({ el: $("#modal_newdepartmentContainer") });
	  toolbarModalCollectionData.id = 'modal_edit';	
	  toolbarModalCollectionData.department = department.get('rows').rows; 	  
	  var department_view_edit = new departmentView({ el: $("#modal_editdepartmentContainer") });
});
//<-department
//<--- Ajax Request ---
//---> Ajax Request ---
//->division
var divisionModel = Backbone.Model.extend({
	urlRoot: 'common_action.php',		
  sync: function(method, model, options) {
      options || (options = {});
      if (model)
         // return Backbone.sync(method, model, options);
      	var success = options.success;
      	 return Backbone.ajax({
       		url: _.result(model, 'url')?_.result(model, 'url'):model.get('data').url,
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
});
var division = new divisionModel({data:{url: 'user_ext_action.php', 
	action:'special_select', 
		arguments:{ 
			field_code: 'division_code',
			field_text: 'division_text',
			link_table: 'tb_division'	      
	    },  
 }
});
divisionView = Backbone.View.extend({
	collection: toolbarModalCollectionData,
    initialize: function(){
        this.render();
    },
    template: Handlebars.compile($('#division_template').html()),
    render: function(){        
    	//this.$el.html(this.template(this.collection.get('modal_new').get('division')));
    	this.$el.html(this.template(this.collection));
    	//this.$el.html(this.template());	
    }	
});
division.fetch().then(function (resp) {
	  console.log(division.get('rows'));
	  //toolbarModalNew.division = division.get('rows');
	  toolbarModalCollectionData.id = 'modal_new';	
	  toolbarModalCollectionData.division = division.get('rows').rows;
	  var division_view_new = new divisionView({ el: $("#modal_newdivisionContainer") });
	  toolbarModalCollectionData.id = 'modal_edit';	
	  var division_view_edit = new divisionView({ el: $("#modal_editdivisionContainer") });
});
//<-division
//<--- Ajax Request ---
//---> Ajax Request ---
//->title
var titleModel = Backbone.Model.extend({
	urlRoot: 'common_action.php',		
  sync: function(method, model, options) {
      options || (options = {});
      if (model)
         // return Backbone.sync(method, model, options);
      	var success = options.success;
      	 return Backbone.ajax({
       		url: _.result(model, 'url')?_.result(model, 'url'):model.get('data').url,
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
});
var title = new titleModel({data:{url: 'user_ext_action.php', 
	action:'common_select', 
		arguments:{ 
			where_use: 'tb_user-title_code'	      
	    },  
 }
});
titleView = Backbone.View.extend({
	collection: toolbarModalCollectionData,
    initialize: function(){
        this.render();
    },
    template: Handlebars.compile($('#title_template').html()),
    render: function(){        
    	//this.$el.html(this.template(this.collection.get('modal_new').get('title')));
    	this.$el.html(this.template(this.collection));
    	//this.$el.html(this.template());	
    }	
});
title.fetch().then(function (resp) {
	  console.log(title.get('rows'));
	  //toolbarModalNew.title = title.get('rows');
	  toolbarModalCollectionData.id = 'modal_new';	
	  toolbarModalCollectionData.title = title.get('rows').rows;
	  var title_view_new = new titleView({ el: $("#modal_newtitleContainer") });
	  toolbarModalCollectionData.id = 'modal_edit';	
	  var title_view_edit = new titleView({ el: $("#modal_edittitleContainer") });
});
//<-title
//<--- Ajax Request ---
//---> Ajax Request ---
//->job
var jobModel = Backbone.Model.extend({
	urlRoot: 'common_action.php',		
  sync: function(method, model, options) {
      options || (options = {});
      if (model)
         // return Backbone.sync(method, model, options);
      	var success = options.success;
      	 return Backbone.ajax({
       		url: _.result(model, 'url')?_.result(model, 'url'):model.get('data').url,
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
});
var job = new jobModel({data:{url: 'user_ext_action.php', 
	action:'common_select', 
		arguments:{ 
			where_use: 'tb_user-job_code'	      
	    },  
 }
});
jobView = Backbone.View.extend({
	collection: toolbarModalCollectionData,
    initialize: function(){
        this.render();
    },
    template: Handlebars.compile($('#job_template').html()),
    render: function(){        
    	//this.$el.html(this.template(this.collection.get('modal_new').get('job')));
    	this.$el.html(this.template(this.collection));
    	//this.$el.html(this.template());	
    }	
});
job.fetch().then(function (resp) {
	  console.log(job.get('rows'));
	  //toolbarModalNew.job = job.get('rows');
	  toolbarModalCollectionData.id = 'modal_new';	
	  toolbarModalCollectionData.job = job.get('rows').rows;
	  var job_view_new = new jobView({ el: $("#modal_newjobContainer") });
	  toolbarModalCollectionData.id = 'modal_edit';	
	  var job_view_edit = new jobView({ el: $("#modal_editjobContainer") });
});
//<-job
//<--- Ajax Request ---
//---> Ajax Request ---
//->cost_center
var cost_centerModel = Backbone.Model.extend({
	urlRoot: 'common_action.php',		
  sync: function(method, model, options) {
      options || (options = {});
      if (model)
         // return Backbone.sync(method, model, options);
      	var success = options.success;
      	 return Backbone.ajax({
       		url: _.result(model, 'url')?_.result(model, 'url'):model.get('data').url,
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
});
var cost_center = new cost_centerModel({data:{url: '', 
	action:'special_select', 
		arguments:{ 
			field_code: 'cost_center_code',
			field_text: 'cost_center_text',
			link_table: 'tb_cost_center'      
	    },  
 }
});
cost_centerView = Backbone.View.extend({
	collection: toolbarModalCollectionData,
    initialize: function(){
        this.render();
    },
    template: Handlebars.compile($('#cost_center_template').html()),
    render: function(){        
    	//this.$el.html(this.template(this.collection.get('modal_new').get('cost_center')));
    	this.$el.html(this.template(this.collection));
    	//this.$el.html(this.template());	
    }	
});
cost_center.fetch().then(function (resp) {
	  console.log(cost_center.get('rows'));
	  //toolbarModalNew.cost_center = cost_center.get('rows');
	  toolbarModalCollectionData.id = 'modal_new';	
	  toolbarModalCollectionData.cost_center = cost_center.get('rows').rows;
	  var cost_center_view_new = new cost_centerView({ el: $("#modal_newcost_centerContainer") });
	  toolbarModalCollectionData.id = 'modal_edit';	
	  var cost_center_view_edit = new cost_centerView({ el: $("#modal_editcost_centerContainer") });
});
//<-cost_center
//<--- Ajax Request ---
//---> Ajax Request ---
//->User
var userModel = Backbone.Model.extend({
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
});
var user_retrieve = new userModel({data:{url: 'user_ext_action.php', 
	action:'retrieve', 
		arguments:{ 	
				      
	    },
	    columns: [
		//->    
	    {		
	    	title: '选择',
            checkbox: true
        },		    
		{
	        field: 'id',
	        title: 'ID'
	    }, {
	        field: 'user_code',
	        title: '用户代码',  
	    }, 
	    {
	        field: 'user_text',
	        title: '用户名',
	        formatter: 'displaycolor'
	    },
	    {
	        field: 'role_text',
	        title: '系统权限',
	    },	    
	    {
	        field: 'company_text',
	        title: '公司',
		    editable: false,    
	    }, 
	    {
	        field: 'department_text',
	        title: '部门',
	    },	    
	    {
	        field: 'division_text',
	        title: '项目组',
	    },
	    {
	        field: 'title_text',
	        title: '称谓',
	    },
	    {
	        field: 'job_text',
	        title: '职位',
	    },
	    {
	        field: 'cost_center_text',
	        title: '成本中心',
	    },	    
	    {
	        field: 'telphone',
	        title: '电话',
	    },	 
	    {
	        field: 'mobile',
	        title: '手机',
	    },	 
	    {
	        field: 'email',
	        title: '邮箱',
	    },	 
	    {
	        field: 'rfid',
	        title: '卡号',
	    },		    	    
	    //<-
	    ]
   }
});
//var $table = $('#table')
//$table.bootstrapTable({data: _data})
//c.save();
//c.destroy();
  
//->Populate to View
var spinner_view = new spinnerView({ el: $("#spinnerContainer") });
var toolbar_view = new toolbarView({ el: $("#toolbarContainer") });
var search_view = new searchView({ el: $("#searchContainer") });
var toolbarModal_view = new toolbarModalView({ el: $("#toolbarModalContainer") });
//var table_view = new tableView({ el: $("#tableContainer") });
//<-Populate to View
user_retrieve.fetch().then(function (resp) {
  console.log(user_retrieve.get('rows'));
  var table_view = new tableView({ el: $("#tableContainer") });
  var $table = $('#table')
  $table.bootstrapTable({data: user_retrieve.get('rows'),  columns: user_retrieve.get('data').columns})
  $('#table').bootstrapTable('hideColumn', 'id');
});
function displaycolor(value,row,index) {
	var a = "";
	if(value == "张飞") {
	var a = '<span style="color:blue">'+value+'</span>';
	}else if(value == "已批准"){
	var a = '<span style="color:green">'+value+'</span>';
	}else if(value == "处理中") {
	var a = '<span style="color:Orange">'+value+'</span>';
	}else if(value == "已完成") {
		var a = '<span style="color:red">'+value+'</span>';		
	}else{
	var a = '<span>'+value+'</span>';
	}
	return a;
	};
</script>

<script type="text/javascript">
//->loading
//$(".modal").show();
//setTimeout("$('.modal').hide()", 3000 );
//<-loading
var $table = $('#table')
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
		$('' + action + 'user_code').val( rows[0].user_code);
		$('' + action + 'user_text').val( rows[0].user_text);
		$('' + action + 'password').val( rows[0].password);
		$('' + action + 'company_code').val(rows[0].company_code);
		$('' + action + 'department_code').val(rows[0].department_code);
		$('' + action + 'division_code').val(rows[0].division_code);
		$('' + action + 'title_code').val(rows[0].title_code);
		$('' + action + 'job_code').val(rows[0].job_code);	
		$('' + action + 'cost_center_code').val(rows[0].cost_center_code);
		$('' + action + 'email').val(rows[0].email);
		$('' + action + 'telphone').val(rows[0].telphone);
		$('' + action + 'mobile').val(rows[0].mobile);
		$('' + action + 'active').attr("checked", (rows[0].active == 1 ? true : false));
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
/*----------------------------Modal Button Action---------------------------------
 *  
 * Name: modal_new_submit, modal_edit_submit, modal_delete_submit
 *       modal_new_close, modal_edit_close, modal_delete_close,
 *
 *----------------------------Modal Button Action--------------------------------*/  
//->Modal New
 $('#modal_new_submit').click(function(){
  var action = '#modal_new';
  var user_code = $('' + action + 'user_code').val();
  var user_text = $('' + action + 'user_text').val();
  var password = $('' + action + 'new_password').val();  
  
  //var company_code =$("select[name='"+ action.replace("#","") +"company_code']").val();
  //var department_code = $("select[name='"+ action.replace("#","") +"department_code']").val();  
  //var division_code = $("select[name='"+ action.replace("#","") +"division_code']").val();
  //var title_code =$("select[name='"+ action.replace("#","") +"title_code']").val();  
  //var job_code =$("select[name='"+ action.replace("#","") +"job_code']").val();  
  //var cost_center_code =$("select[name='"+ action.replace("#","") +"cost_center_code']").val();  
  var company_code = $('' + action + 'company_code').val();
  var department_code = $('' + action + 'department_code').val();  
  var division_code = $('' + action + 'division_code').val();
  var title_code = $('' + action + 'title_code').val();  
  var job_code = $('' + action + 'job_code').val();  
  var cost_center_code = $('' + action + 'cost_center_code').val();    
  
  var email = $('' + action + 'email').val();
  var telphone = $('' + action + 'telphone').val();
  var mobile = $('' + action + 'mobile').val();
    
  var active = $('' + action + 'active').prop("checked");
  var delete_flag = false;
  var request=new XMLHttpRequest;
           $.ajax({
            type:"POST",
          dataType:"json",
            //url:"test_ajax_action.php?number="+$("#keywords").val(),
			url:"user_ext_action.php",
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
				//location.reload();
                user_retrieve.fetch().then(function (resp) {
                  var table_view = new tableView({ el: $("#tableContainer") });
                  $('#table').bootstrapTable({data: user_retrieve.get('rows'),  columns: user_retrieve.get('data').columns})
                  $('#table').bootstrapTable('hideColumn', 'id');
                });
                
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
  var user_code = $('' + action + 'user_code').val();
  var user_text = $('' + action + 'user_text').val();
  var password = $('' + action + 'new_password').val();   
  var company_code = $('' + action + 'company_code').val();
  var department_code = $('' + action + 'department_code').val();  
  var division_code = $('' + action + 'division_code').val();
  var title_code = $('' + action + 'title_code').val();  
  var job_code =$('' + action + 'job_code').val();  
  var cost_center_code =$('' + action + 'cost_center_code').val();    
  
  var email = $('' + action + 'email').val();
  var telphone = $('' + action + 'telphone').val();
  var mobile = $('' + action + 'mobile').val();
    
  var active = $('' + action + 'active').prop("checked");
  var delete_flag = false;
  var request=new XMLHttpRequest;
           $.ajax({
            type:"POST",
          dataType:"json",
            //url:"test_ajax_action.php?number="+$("#keywords").val(),
			url:"user_ext_action.php",
		    data:{action:'edit', 
  		      arguments:{  
  		    	id: 		        id,				    		      
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
                user_retrieve.fetch().then(function (resp) {
                  var table_view = new tableView({ el: $("#tableContainer") });
                  $('#table').bootstrapTable({data: user_retrieve.get('rows'),  columns: user_retrieve.get('data').columns})
                  $('#table').bootstrapTable('hideColumn', 'id');
                });
                
				$("modal_new").modal('hide');
            },
			error:function(data){
                alert("MYSQL-0002:Ajax Create Error - "+ data.responseText);
            }
		});
	});
   //<-Edit  
   
    //->rfid    
    $('#btn_rfid').click(function(){
		var rows = getSelections();
    	if (rows == 'undefined' || rows == null || rows.length != 1)
    	{	
    		layer.alert('请选择一条记录进行操作!');
    		return;
    	}
        
    	layer.confirm('您是否要对所选用户进行发卡，[ 已生成卡号不再重新发卡 ]？', {
    		btn: ['是', '否']
    		}, function() {
    			        
			//->
	        var request=new XMLHttpRequest;
               $.ajax({
    	            type:"POST",
    	            dataType:"json",
    	            //url:"test_ajax_action.php?number="+$("#keywords").val(),
    				url:"user_ext_action.php",
    			    data:{action:'rfid', arguments:{
    			    	  key: rows[0].id
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
    	
                        user_retrieve.fetch().then(function (resp) {
                            var table_view = new tableView({ el: $("#tableContainer") });
                            $('#table').bootstrapTable({data: user_retrieve.get('rows'),  columns: user_retrieve.get('data').columns})
                            $('#table').bootstrapTable('hideColumn', 'id');
                          });					 
                		 layer.msg('发卡成功');
                		 
    	           	 },
						error:function(data){
        	                alert("encounter error - "+ data.responseText);
        	            }
        			});	
                    
					//<-			
			  });	       
	});     
  	//<-rfid
  	
  	//->print
    $('#btn_print').click(function(){
		var rows = getSelections();
    	if (rows == 'undefined' || rows == null || rows.length != 1||rows[0].rfid == '' ||rows[0].rfid == null)
    	{	
    		layer.alert('请选择一条已发卡用户进行操作!');
    		return;
    	}
	
        
    	layer.confirm('您是否要对所选用户进行打印制卡？', {
    		btn: ['是', '否']
    		}, function() {
    			        
	        var request=new XMLHttpRequest;
               $.ajax({
    	            type:"POST",
    	            dataType:"json",
    	            //url:"test_ajax_action.php?number="+$("#keywords").val(),
    				url:"user_ext_action.php",
    			    data:{action:'print_rfid', arguments:{
    			    	 key: rows[0].id
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
    				 
                	   layer.msg('制卡打印成功');
    	           	 },
						error:function(data){
        	                alert("encounter error - "+ data.responseText);
        	            }
        			});	
                    
					//<-			
				//
			  });	       
	});
	//<-print      	
  	
  
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
			url:"user_ext_action.php",
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
					 //$('#table').bootstrapTable('refresh');
                        user_retrieve.fetch().then(function (resp) {
                          var table_view = new tableView({ el: $("#tableContainer") });
                          $('#table').bootstrapTable({data: user_retrieve.get('rows'),  columns: user_retrieve.get('data').columns})
                          $('#table').bootstrapTable('hideColumn', 'id');
                        });					 
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
			  
   
</script>

<script type="text/javascript">
 layui.use('layer', function(){ //独立版的layer无需执行这一句
	  var layer = layui.layer; //独立版的layer无需执行这一句
	 });
 		
var app = angular.module("myapp",['ngStorage']);
app.controller("myctrl",function($scope,$localStorage,$sessionStorage,$http){
$scope.$storage = $localStorage;
$scope.companydata = [];	
$scope.datas = [];
$scope.count=0;
	
initData();	
$scope.searchCollapse=function(){
	if ($("#searchCollapseButton").text() == '>>'){
		$("#searchCollapseButton").text('<<');
	}else{
		$("#searchCollapseButton").text('>>');
	}
};
$scope.initSearchData=function(){
	
	if(sessionStorage.getItem("companylist") == null || sessionStorage.getItem("companylist") == '') {
	//$scope.params = {"action": "company_get"};
	$http.defaults.headers.post["Content-Type"] = "application/x-www-form-urlencoded";
	$http({
		method: 'post', url: 'common_action.php',data: $.param({action:'special_select', 
				arguments:{ 
					field_code: 'company_code',
					field_text: 'company_text',
					link_table: 'tb_company'	      
			    },  
				}),
        transformRequest:function(obj){
            var str=[];
            for(var p in obj){
                str.push(encodeURIComponent(p)+"="+encodeURIComponent(obj[p]));
            }
            return str.join("&");
        }                      
    }).then(function(data){
        console.log(data)
        $scope.companydata = data.data.rows;
        //$localStorage.companydata = JSON.stringify(data.data.rows);
        $scope.initCompanyData();
        sessionStorage.setItem("companylist",JSON.stringify(data.data.rows));
        
        
    }).catch(function(error){
        console.log('error')
    })
	}else{
        $scope.companydata = JSON.parse(sessionStorage.getItem("companylist"));
        $scope.initCompanyData();
        //sessionStorage.setItem("companylist",$scope.companydata);
	}
	
};
$scope.initCompanyData=function(){
	
	 $("#searchCompanyCode").empty();
	/*
	for (var i = 0; i < $scope.companydata.length; i++) {
		 $("#searchCompanyCode").append('<option  value="' + item + '">' + item + '</option>');
	}	
	*/
	
	if ($scope.companydata.length > 0){
		$("#searchCompanyCode").append('<option  value="">---ALL---</option>');
	}
	
	$.each($scope.companydata, function (i, item) {
		$("#searchCompanyCode").append('<option  value="' + item.company_code + '">' + item.company_text + '</option>');
	});
	$('#searchCompanyCode').selectpicker('refresh');
		
};
 
$scope.submitSearch=function(){
	SearchRequest();
};
$scope.initSearchData();
$("#searchCompanyCode").on('changed.bs.select',
        function (e) {
        //alert($('#searchCompanyCode').val());
        //$table.bootstrapTable('refresh');
        	SearchRequest();
        });
	
//<-End		
//angularJS<-
  
function initData(){
	//---Set Default Date To Value ---
	if ($('#dateTo').val() == null || $('#dateTo').val() == ''){
		$('#dateTo').val(moment().format("YYYY-MM-DD"));
	}
	
};
//->Main Table Source
function SearchRequest(){
    
	initData();
	var dtFrom;
	var dtTo;
	var vCompanyCode;
	if ($('#dateFrom').val() == null || $('#dateFrom').val() == ''){
		dtFrom = '1900.01.01';
	}else{
		dtFrom = moment($('#dateFrom').val()).format("YYYY.MM.DD"); 		  
	}
	if ($('#dateTo').val() == null || $('#dateTo').val() == ''){
		dtTo = '2099.12.31';
	}else{
		dtTo = moment($('#dateTo').val()).format("YYYY.MM.DD"); 		  
	}
	vCompanyCode = $('#searchCompanyCode').val()
	
var user_retrieve = new userModel({data:{url: 'user_ext_action.php', 
	action:'retrieve', 
		arguments:{ 	
		      	datefrom: dtFrom,
  		      	dateto: dtTo, 
  		      	company_code: vCompanyCode,						      
	    },
	    columns: [
		//->    
	    {		
	    	title: '选择',
            checkbox: true
        },		    
		{
	        field: 'id',
	        title: 'ID'
	    }, {
	        field: 'user_code',
	        title: '用户代码',  
	    }, 
	    {
	        field: 'user_text',
	        title: '用户名',
	    },
	    {
	        field: 'role_text',
	        title: '系统权限',
	    },	    
	    {
	        field: 'company_text',
	        title: '公司',
		    editable: true,    
	    }, 
	    {
	        field: 'department_text',
	        title: '部门',
	    },	    
	    {
	        field: 'division_text',
	        title: '项目组',
	    },
	    {
	        field: 'title_text',
	        title: '称谓',
	    },
	    {
	        field: 'job_text',
	        title: '职位',
	    },
	    {
	        field: 'cost_center_text',
	        title: '成本中心',
	    },	    
	    {
	        field: 'telphone',
	        title: '电话',
	    },	 
	    {
	        field: 'mobile',
	        title: '手机',
	    },	 
	    {
	        field: 'email',
	        title: '邮箱',
	    },	 
	    {
	        field: 'rfid',
	        title: '卡号',
	    },		    	    
	    //<-
	    ]
   }
});			
			
	user_retrieve.fetch().then(function (resp) {
		  console.log(user_retrieve.get('rows'));
		  var table_view = new tableView({ el: $("#tableContainer") });
		  var $table = $('#table')
		  $table.bootstrapTable({data: user_retrieve.get('rows'),  columns: user_retrieve.get('data').columns})
		  $('#table').bootstrapTable('hideColumn', 'id');
		});	
	      
};
//
	
//<-End		
});
</script>


</body>
</html>