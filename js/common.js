/*-----------------------------------------------------------------------------
 * Global Script Function
 * Create By: Wei.Zhu
 * Create at: 2022.04.03
 -----------------------------------------------------------------------------*/

function enableFocusInputField(flag,field_name){
	if(flag==true){
		var oInput = $("input[name="+ field_name +"]");
		oInput.focus();
	}
};

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
			$("#l_collapse_image").toggleClass("bi bi-chevron-double-right",true);
			$("#l_collapse_image").toggleClass("bi bi-chevron-double-left",false);
		}else{
			//$("#mainBody").offset({ left: 200 });
			$("#Content").offset({ left: 200 });
			var x = $("#Content").width(x - 200);
			$("#l_collapse_image").toggleClass("bi bi-chevron-double-right",false);
			$("#l_collapse_image").toggleClass("bi bi-chevron-double-left",true);
		}
	});
};

function onLogout(){
	$("#logout").click(function(){
		window.location.href='/web/login';
		layer.msg('xxxxx');

	});
}

$(".menuHover").hover(function(){
	$(this).css("background-color","#C8C8C8");
},function(){
	$(this).css("background-color","white");
});

function buildLayUI_Select(id,data,placeholder) {
	if (data != "" && data.length > 0) {
		$("#" + id).append(new Option(placeholder, ''));
		$.each(data, function (index, row) {
			$("#" + id).append(new Option(row.cat_text, row.cat_code));
		})
		form.render('select');
	}
}

	function buildLayUI_Select_Ext(id,data,placeholder,code,text){
		if (data != "" && data.length >0){
			$("#"+id).append(new Option(placeholder,''));
			$.each(data,function(index,row){
				$("#"+id).append(new Option(row[text],row[code]));

			})
			form.render('select');
		}



}
