/*-----------------------------------------------------------------------------
 * Handlebars Script Function
 * Create By: Wei.Zhu
 * Create at: 2022.04.03 
 -----------------------------------------------------------------------------*/
//!-- Common Handlebars -->
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

/*-----------------------------------------------------------------------------
 * GET CHECKBOX LIST VALUE
 * Parameter:  checkbox name
 -----------------------------------------------------------------------------*/
function getCheckboxValues(_checkox_name)
{
  var vals = [];
  $.each($("input[name='"+_checkox_name +"']:checked"),function(){
      vals.push($(this).val());
  });
 
  return vals;
}

function getTableCheckboxValues(_table_name,_checkox_name)
{
	 var vals = [];
	  $(""+_table_name+"").find("input[name='"+_checkox_name +"']:checked").each(function() {
		  vals.push($(this).val());
	  });
	return vals;
}

function checkSelection(_tab_name){
	var result = false;
    $(""+ _tab_name +"").find("input[type='checkbox']").each(function(i,val){
        var flag =  $(val).prop("checked");
        if (flag == true){
        	result = true;
        	return result;
   		}        
     });  	
    
    return result;
}


function tableSelectAll(_tab_id){
	var tab_id = "#tbody_01";
	if (_tab_id != "undefined" && _tab_id != "undefined" )
	{
	 tab_id = _tab_id;
	} 
		
    $("#selectAll").change(function() {
        var checkboxs = $(tab_id).find("input[type='checkbox']");
        var isChecked = $(this).is(":checked");
        //严禁使用foreach，jq对象的遍历会使浏览器崩溃
        for(var i = 0; i < checkboxs.length; i++) {
            //临时变量，必须，否则只能选中最后一条记录
            var temp = i;
            $(checkboxs[temp]).prop("checked",isChecked);
        }
    });
}

function setTableSelectAll(_tab_id,_tbody_id){
	var tab_id = "#tbody_01";
	var checkboxAll = _tab_id+"_selectAll";
	
	if (_tab_id != "undefined" && _tab_id != "undefined" )
	{
	 tab_id = _tab_id;
	} 
		
    $(""+checkboxAll+"").change(function() {
        var checkboxs = $(_tbody_id).find("input[type='checkbox']");
        var isChecked = $(this).is(":checked");
        //严禁使用foreach，jq对象的遍历会使浏览器崩溃
        for(var i = 0; i < checkboxs.length; i++) {
            //临时变量，必须，否则只能选中最后一条记录
            var temp = i;
            $(checkboxs[temp]).prop("checked",isChecked);
        }
    });
}

function clearTableSelectAll(_tab_id,_tbody_id){
	var tab_id = "#tbody_01";
	var checkboxAll = _tab_id+"_selectAll";
	
	if (_tab_id != "undefined" && _tab_id != "undefined" )
	{
	 tab_id = _tab_id;
	} 
		
    var checkboxs = $(_tbody_id).find("input[type='checkbox']");
    var isChecked = false;
    //严禁使用foreach，jq对象的遍历会使浏览器崩溃
    for(var i = 0; i < checkboxs.length; i++) {
        //临时变量，必须，否则只能选中最后一条记录
        var temp = i;
        $(checkboxs[temp]).prop("checked",isChecked);
    }
}

function setTableSelectByValue(_tab_id,_tbody_id,_check_value){
	var tab_id = "#tbody_01";
	var checkboxAll = _tab_id+"_selectAll";
	
	if (_tab_id != "undefined")
	{
	 tab_id = _tab_id;
	} 
	
	//clearTableSelectAll(_tab_id,_tbody_id);
		
    var checkboxs = $(_tbody_id).find("input[type='checkbox']");
    var isChecked = true;
    //严禁使用foreach，jq对象的遍历会使浏览器崩溃
    for(var i = 0; i < checkboxs.length; i++) {
        //临时变量，必须，否则只能选中最后一条记录
        var temp = i;
        if(checkboxs[temp].value == _check_value){
     	   $(checkboxs[temp]).prop("checked",isChecked);
        }
    }

}

function getPageName(){
	var result=location.href;
	result=result.replace(/\?.*$/,'');  //Replace Parameter
	result=result.replace(/^.*\//,'');  //Replace http leading
	return result;
}

function setTableSearchNameValue(clause_name,clause_value){
	//alert(clause_name);
	$('#condition_code').val(clause_name);
	$('#table_search_value').val(clause_value);		
}


function getQueryString(name) {  
	location.href.replace("#","");  
	// 如果链接没有参数，或者链接中不存在我们要获取的参数，直接返回空       
	if(location.href.indexOf("?")==-1 || location.href.indexOf(name+'=')==-1)     {          
	   return '';      
	}        
	// 获取链接中参数部分       
	var queryString = location.href.substring(location.href.indexOf("?")+1);        
	// 分离参数对 ?key=value&key2=value2       
	var parameters = queryString.split("&");        
	  
	var pos, paraName, paraValue;       
	for(var i=0; i<=parameters.length; i++) {  
	   // 获取等号位置           
	   pos = parameters[i].split('=');           
	   if(pos == -1) { continue; }            
	   // 获取name 和 value           
	   paraName = pos[0];           
	   paraValue = pos[1];           
	   // 如果查询的name等于当前name，就返回当前值，同时，将链接中的+号还原成空格          
	   if(paraName == name) {       
	    return decodeURIComponent(paraValue.replace(/\+/g, " "));           
	   }       
	}       
	return '';   
	}   


function GetPaostString(name)
{
var reg = new RegExp("(^|&)"+ name +"=([^&]*)(&|$)");
var r = window.location.search.substr(1).match(reg);
if (r!=null) return unescape(r[2]); return null;
}


/*Set Copyright Year Range*/
function getCopyRightYear(id,strYear){
	  var copyright = this.$(id).text();
	  var date = new Date();
	  var year = date.getFullYear();
	  //var strYear = '2003';
	  if (strYear == year){
		  copyright_year = year;
	  }
	  else{
	  var copyright_year = strYear + "-" + year;
	  }
	  copyright = copyright.replace("[copyright]",copyright_year);
	  $("#copyright").text(copyright);	
}

function onCollapse(){
$("#l_collapse").click(function(){
    $("#leftmenu").toggle();
    var y = $('#Content').offset().left;
    var x = $("#Content").width();
    //alert(0);
    if (y > 0 ){
    //$("#mainBody").offset({ left: 0 });
    $("#Content").offset({ left: 0 });
    $("#Content").width(x + 200);
    $("#l_collapse_image").toggleClass("fas fa-angle-double-right");
    }else{
    	//$("#mainBody").offset({ left: 200 });
    	$("#Content").offset({ left: 200 });
    	var x = $("#Content").width(x - 200);
    	$("#l_collapse_image").toggleClass("fas fa-angle-double-left");
    }  
  });
}

function onMenuMouseHover(){
	  $(".menuHover").hover(function(){
		    $(this).css("background-color","#C8C8C8");
		    },function(){
		    $(this).css("background-color","white");
		  });
};

function onLoginInfo(userName){
	var loginInfo = 'Welcome:';
	if (userName != ''){
		loginInfo =  loginInfo + '['+ userName +']';
		$("#Register").hide(); 
		$("#login").hide(); 
		$("#LoginInfo").text(loginInfo); 
	}
	
	$("#LoginInfo").text(loginInfo); 
};

function SetFocusFieldById(flag,fieldId){
	if(flag==true){
		//'' + action + '
    	var oInput = $("#"+ fieldId);
    	oInput.focus();
    }    
};

function onSetModaltoCenter(){
	//->
    $(".btn_modal").click(function () {
        var _id = $(this).attr("data-target");
        //alert(_id);	 
	 //->
	
    var $modal = $(_id);
    // set bootstrap to center
    $modal.on('show.bs.modal', function(){
      var $this = $(this);
      var $modal_dialog = $this.find('.modal-dialog');
      // if modal set block，then $modala_dialog.height() eq 0
      $this.css('display', 'block');
      $modal_dialog.css({'margin-top': Math.max(0, ($(window).height() - $modal_dialog.height()) / 2) });
    });

    //<-
    });    
};

function onTableSearchEnter(){
$("#table_search_value").bind('keypress', function(event) {
	if (event.keyCode == "13") {
		$("#btn_table_search").click();
	}
});
};

function onEnterToClick(_input_id,_button_id){
$(_input_id).bind('keypress', function(event) {
	if (event.keyCode == "13") {
		$(_button_id).click();
	}
});
};

function onSetLinkToTagSelect(_action,_default_value,_db_table,_field_value,_field_text,_target_tag,_source_tag_1,_source_tag_2,_source_tag_3){
	var clause_1; 
	var clause_2;
	var clause_3;
	if(_action == "undefined"||_action == null||_action == ""){
		var target_tag = _target_tag;
		var source_tag_1 = _source_tag_1;
		var source_tag_2 = _source_tag_2;
		var source_tag_3 = _source_tag_3;
	}else{
		var target_tag = _action + '_' + _target_tag;
		var source_tag_1 = _action + '_' + _source_tag_1;
		var source_tag_2 = _action + '_' + _source_tag_2;
		var source_tag_3 = _action + '_' + _source_tag_3;				
	}
	
	if (_source_tag_1 != ''){
	  clause_1 = "and " + _source_tag_1 + " = '" + $("select[name='"+ source_tag_1 +"']").val() +"'";
	}
	
	if (_source_tag_2 != ''){
	  clause_2 = "and " + _source_tag_2 + " = '" + $("select[name='"+ source_tag_2 +"']").val() +"'";
	}	
	
	if (_source_tag_3 != ''){
	  clause_3 = "and " + _source_tag_3 + " = '" + $("select[name='"+ source_tag_3 +"']").val() +"'";
	}		
	
	
	//-->
    var request=new XMLHttpRequest;
           $.ajax({
            type:"POST",
            dataType:"json",
            //url:"test_ajax_action.php?number="+$("#keywords").val(),
			url:"common_action.php",
		    data:{action:'event_select', 
			      arguments:{
		    	    link_table:    _db_table,
		    	    default_value: _default_value,
		    	    field_value:   _field_value,
		    	    field_text:    _field_text,
		    	    clause_1: 	   clause_1,
		    	    clause_2:      clause_2,
		    	    clause_3:      clause_3
		    	  }
				},
            success: function(data){
               if(data.success){
	  				$("#"+ target_tag +"").empty();
                    var opt=$("<option value=''>--- 请选择 ---</option>")
                    $("#"+ target_tag +"").append(opt)
                    
				    $.each(data.result,function(index,item){
                      var opt=$("<option value="+item.value+">"+item.text+"</option>")
                      $("#"+ target_tag +"").append(opt)
                  });
				   //$("#""+ target_tag +""").change();
				   
				   if (_default_value != '')
				   {
				   	 $("#"+ target_tag +"").val(_default_value); 
				   }
                  			  
               }else{
                  $("#message").html("参数错误"+data.message); 
               }
           	 },
				error:function(data){
	                alert("encounter error");
	            }
	
			});
	//<--	

}


function testVaule(){
	return 'xxxx1';
};
