<!DOCTYPE html>
<html>
<head>
    <!-- CSS -->
    <link rel="stylesheet" href="plugins/bootstrap/css/bootstrap.min.css" />
    <link rel="stylesheet" href="plugins/bootstrap-icons/font/bootstrap-icons.css">
    <link rel="stylesheet" href="plugins/layui/css/layui.css" />
    <link rel="stylesheet" href="css/global.css" />

    <!--jquery-->
    <script src="plugins/jquery/jquery.min.js"></script>

    <!-- Bootstrap 5 -->
    <script src="plugins/popper/popper.min.js"></script>
    <script src="plugins/bootstrap/js/bootstrap.min.js"></script>


    <!-- AnjularJS -->
    <script src="plugins/angularJS/angular.min.js"></script>
    <!--  
    <script src="plugins/ngStorage/ngStorage.min.js"></script>
    -->

    <!-- Global -->
    <script src="plugins/layui/layui.js"></script>
    <script src="js/core.util.js"></script>
    <script src="js/common.js"></script>
    <style>
        .layui-tab-title li {
            border-bottom: 1px solid #e6e6e6;
        }
        .leftmenu-content{
            overflow: auto;
            height: calc(100% - 142px);
        }
    </style>

    <!-- Custom JavaScript -->
    <script>

    </script>
</head>
<body ng-app="myapp" ng-controller="myctrl">

<!--\ Left Menu iframe-menu-pre-scrollable-->
<div class="iframe-leftmenu " id="leftmenu">

    <div class="company-info">
        <a href="#" class="brand-link ng-binding" style="color: Orange; font-weight: bold;">
            <i class="bi bi-building" style="font-size: 52px; color: Orange;"></i>[IDES01]</a>
    </div>
    <div class="user-panel">
        <div class="image user-image">
            <img src="images/user/ides01.gif" class="img-circle" alt="User Image">
        </div>
        <div class="user-info">
            <div class="user-info" id="user_info1">
                .
            </div>
            <div class="user-info" id="user_info2">
                .
            </div>
            <div class="user-info" id="user_info3">
                .
            </div>
        </div>
    </div>

    <!--Left Menu Contect-->
    <div id="leftmenu_content" class="leftmenu-content">
    </div>

<!--/ Left Menu -->

</div>


<!-- Content -->
<div class="iframe-desktop" id="Content">
    <div style=" display: flex;justify-content: space-between;align-items: center;">
        <div style="height: 60px; width: min-content;display: flex; align-items: center;">
            <div> <span id="l_collapse" class="nav-link me-2"><i id="l_collapse_image" class="bi bi-list" style="font-size: 24px;width:min-content;"></i></span></div>
        </div>
        <div style="height: 60px; display: flex; align-items: center;">
        <div> <span id="logout" class="nav-link me-2"><i class="bi bi-box-arrow-right" style="font-size: 16px;width:min-content;font-style: normal;">退出</i></span></div>
    </div>
    </div>
    <div class="container-default" id="mainBody" >
        <!--\Content Head-->
        <div class="panel-group iframe-desktop_header" id="panelContainer_h" >

            <div class="panel panel-default" style="display:flex;position:relative">
                <div class="dropdown">
                    <a class="btn btn-danger dropdown-toggle btn-no-border-radius" href="#" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">
                        关闭
                    </a>

                    <ul class="dropdown-menu btn-no-border-radius" aria-labelledby="dropdownMenuLink">
                        <li><a class="dropdown-item" href="#">当前关闭</a></li>
                        <li><a class="dropdown-item" href="#">所有关闭</a></li>
                    </ul>
                </div>

                <a class="nav-link bg-light top-menu-scrollleft" href="#" ><i class="bi bi-chevron-double-left"></i></a>
                <!-- Nav tabs -->
                <ul class="nav navbar navbar-expand-lg navbar-white navbar-light p-0 top-menu-content" id="myTab" role="tablist" style="display: flex;flex-flow: row nowrap;width: 100%;align-items: center;">

                    <li class='nav-item' role='presentation'>
                        <a class='nav-link active p-0 me-2' data-bs-toggle='tab' data-name='pages_home' href='#home'>
                            <i class="bi bi-house-door">
                            </i>主页
                        </a>
                    </li>
                </ul>
                <a class="nav-link bg-light top-menu-scrollright" href="#"><i class="bi bi-chevron-double-right"></i></a>
            </div>
        </div>
        <!--/Content Head-->

        <!--\Contnet Body-->
        <!-- Tab panes -->
        <div class="tab-content" id="myTabPane">
            <div id='pages_home' class='tab-pane iframe-contnet active'><iframe src='/web/home' style="width:100%;height:100% ;frameborder:0"></iframe></div>
        </div>
        <!--/Contnet Body-->

    </div>
</div>

</div>

<footer class="footer navbar-fixed-bottom iframe-copyright">
    <div class="panel-footer">
        <p class="text-center iframe-copyright-text" id="copyright">
            &copy;[copyright] www.ides01.com
        </p>
    </div>
</footer>

</body>
</html>

<script>
    //->document ready run only
    $(document).ready(function(){
        onCollapse();
        onLogout();
        //->core

        /* */
        var param= {};
        param = { action:'login', 
		  arguments:{  
			  user_code: 'wei.zhu',
			  user_password: 'password'	
			  }
        }
            
        //param.user_id = '1';
        //param.type_code = 'L'
        //param.admin_flag = '';

        
       $.ajax({
   		url: "iframe_action.php",
		type: "POST",
		dataType: "json",
	    data:{action:'left_menu', 
  		      arguments:{
  		    	  user_id: localStorage.getItem("uid"),
  		    	  type_code: 'L',
  		    	 admin_flag: ''
			      }
				},	
          success: function(res){
            //alert(res);
        
            
        
        //CoreUtil.sendAjax("login_action.php",param,function (res) {
            if(res !=null){
                //alert(res.result.length);
                //layer.msg('xxxx');
                //->building left menu

                var str_html = "<div class='accordion' id='accordionMenuPanel'>";
                var data = res.rows;
                if (data != "" && data.length >0){
                    $.each(data,function(index,row){
                        if(row.pid == '0'){
                            if(index != 0){
                                str_html +="</div>";
                                str_html +="</div>";
                                str_html +="</div>";
                                str_html +="</div>";
                            }

                            str_html +="<div class='accordion-item'>";
                            str_html +="<h2 class='accordion-header' id='panelsStayOpen-heading-"+row.id+"'>";
                            str_html +="<button class='accordion-button collapsed menu-header' type='button' data-bs-toggle='collapse' data-bs-target='#panelsStayOpen-collapse-"+row.id+"' aria-expanded='false' aria-controls='panelsStayOpen-collapse-"+row.id+"'>";
                            str_html += row.menu_name;
                            str_html +="</button>";
                            str_html +="</h2>";

                            str_html +="<div id='panelsStayOpen-collapse-"+row.id+"' class='accordion-collapse collapse' aria-labelledby='panelsStayOpen-heading-"+row.id+"'>";
                            str_html +="<div class='accordion-body p-0'>";
                            str_html +="<div class='list-group'>";
                        }else{
                            str_html +="<a data-bs-toggle='tab' data-url='"+row.id+"' data-name='"+row.uuid+"' href='#"+row.uuid+"' class='list-group-item list-group-item-action menu-item'>"+row.menu_name+"</a>";
                        }

                    })

                    if (data.length >0){
                        str_html +="</div>";
                        str_html +="</div>";
                        str_html +="</div>";
                        str_html +="</div>";
                    }


                }
                str_html +="</div>";

                $("#leftmenu_content").html(str_html);
            }
        }
       }); 


        menuExtList = localStorage.getItem('menuExtList');

        if (menuExtList == null || menuExtList == 'null' ){
            menuExtList = {};
        }else{
            menuExtList = JSON.parse(menuExtList);
        }

        $.each(menuExtList,function(i,item){

            var newTab = "<li class='nav-item' role='presentation'> <a class='nav-link p-0 ' data-bs-toggle='tab' data-name='"+ i +"' href='#"+ i +"'>"+ item.name +"<i class='bi bi-x-lg ms-2 text-end'></i></a></li>";
            var newTabPane = "<div id='"+ i +"' class='tab-pane iframe-contnet '><iframe src='mywms?guid="+ item.url +"' style='float:top' width='100%' height='100%' frameborder='0'></iframe></div>";

            $("#myTab").append(newTab);
            $("#myTabPane").append(newTabPane);

            // $('.nav-link').removeClass('active');
            //  $('.iframe-contnet').removeClass('active');
            // $('.menu-item').removeClass('active');

            //$("[data-name='"+ i +"']").addClass('active');
            //$('#' + i).addClass('active');
        });

        //set default active page - home.php => pages_home_php
        //$("[data-name='pages_home_php']").addClass('active');
        // $("#pages_home_php").addClass('active');

        //$("[data-name='pages_home_php']").addClass('active');
        //$("#pages_home_php").addClass('active');

    });


    $('.bi-x-lg').on('click', function(ev) {
        var ev=window.event||ev;
        ev.stopPropagation();
        //先判断当前要关闭的tab选项卡有没有active类，再判断当前选项卡是否最后一个，如果是则给前一个选项卡以及内容添加active，否则给下一个添加active类
        var gParent=$(this).parent().parent();
        parent=$(this).parent();
        if(gParent.hasClass('active')){
            if(gParent.index()==gParent.length){
                gParent.prev().addClass('active');
                $(parent.attr('href')).prev().addClass('active');
            }else{
                gParent.next().addClass('active');
                $(parent.attr('href')).next().addClass('active');
            }
        }
        gParent.remove();
    });

    var menuExtList = {};
    $(document).on("click",".menu-item",function(ev){
    //$('.menu-item').on('click', function(ev) {
        var flag = false;
        var menu_name = this.dataset.name;

        menuExtList = localStorage.getItem('menuExtList');

        if (menuExtList == null || menuExtList == 'null' ){
            menuExtList = {};
        }else{
            menuExtList = JSON.parse(menuExtList);
        }

        $.each(menuExtList,function(i,item){
            if(i == menu_name){
                flag = true;
                $('.nav-link').removeClass('active');
                $('.iframe-contnet').removeClass('active');
                $('.menu-item').removeClass('active');

                $("[data-name='"+ i +"']").addClass('active');
                $('#' + i).addClass('active');
                $(this).addClass("active")

                return;
            }
        });

        if (flag == true){
            return;
        }

        $('.menu-item').removeClass('active');
        $(this).addClass("active")

        $('.nav-link').removeClass('active');
        $('.iframe-contnet').removeClass('active');
        var newTab = "<li class='nav-item' role='presentation'> <a class='nav-link active p-0 ' data-bs-toggle='tab' data-name='"+ this.dataset.name +"' href='#"+ this.dataset.name +"'>"+ this.text +"<i class='bi bi-x-lg ms-2 text-end'></i></a></li>";
        var newTabPane = "<div id='"+ this.dataset.name +"' class='tab-pane iframe-contnet active'><iframe src='mywms?guid="+ this.dataset.url +"' style='float:top' width='100%' height='100%' frameborder='0'></iframe></div>";

        if (flag == false){
            menuExtList[this.dataset.name] = { name: this.text, url: this.dataset.url } ;
            $("#myTab").append(newTab);
            $("#myTabPane").append(newTabPane);

            localStorage.setItem('menuExtList',JSON.stringify(menuExtList));
        }

    });



    $(document).on("click",".nav-link",function(ev){
        if (this.dataset.name !=undefined){
        //->1Left menu responsble
        $('.menu-item').removeClass('active');
        $("[data-name='"+ this.dataset.name +"']").addClass('active');
        $("[data-name='"+ this.dataset.name +"']").parent().parent().parent().toggleClass("show",true);
        //<-

        //->tab content
        $('.iframe-contnet').removeClass('active');
        $("#"+ this.dataset.name).addClass('active');
        $("#"+ this.dataset.name).toggleClass("show",true);
        //<-
        }

        //->not user collapsed
        /*
        var vID = $("[data-name='"+ this.dataset.name +"']").parent().parent().parent()[0].id
        $("[aria-controls='"+ vID +"']").attr("aria-expanded",true);
        $("[aria-controls='"+ vID +"']").toggleClass("collapsed",false);
        */
        //<-not user collapsed


    });

    $(document).on("click",".bi-x-lg",function(ev){
        var ev=window.event||ev;
        ev.stopPropagation();

        var vActiveName="";
        var gParent=$(this).parent().parent();
        parent=$(this).parent();

        if(parent.hasClass('active')){
            if(gParent.index() == gParent.parent().children().length - 1){
                gParent.prev().children().addClass('active');
                if (gParent.parent().children().length != 2)
                {
                    $('#' +  gParent.prev().children()[0].dataset.name).addClass('active');

                    $("[data-name='"+ gParent.prev().children()[0].dataset.name +"']").addClass('active');
                    vActiveName = gParent.prev().children()[0].dataset.name;
                }
            }else{
                gParent.next().children().addClass('active');
                $('#' +  gParent.next().children()[0].dataset.name).addClass('active');

                $("[data-name='"+ gParent.next().children()[0].dataset.name +"']").addClass('active');

                vActiveName = gParent.next().children()[0].dataset.name;
            }

            parent.removeClass('active');
            parent.addClass('visually-hidden');

            $('#' + parent[0].dataset.name).removeClass('active');
            $('#' + parent[0].dataset.name).remove();

            setTimeout(function() {
                if ( vActiveName == undefined || vActiveName == null ||vActiveName == '' ){
                    vActiveName = 'pages_home';     //Set to default home page
                }
                $(".menu-item ").removeClass('active');
                $("[data-name='"+ vActiveName +"']").addClass('active');
                $("[data-name='"+ vActiveName +"']").click();
            }, 10);

        }

        gParent.remove();

        menuExtList = localStorage.getItem('menuExtList');
        if (menuExtList != null && menuExtList != 'null' && menuExtList != {} ){
            menuExtList = JSON.parse(menuExtList);
            delete menuExtList[parent[0].dataset.name];
        }

        localStorage.setItem('menuExtList',JSON.stringify(menuExtList));



        /*
        $('.nav-link').removeClass('active');
        gParent.prev().children().addClass('active')

        //prepare remove get the active tabpage
        var url = "pages/home.php"

        if (gParent.next().children().length > 0 )
        {
            url = gParent.next().children()[0].pathname;
        }else if(gParent.prev().children().length > 0 )
        {
            url = gParent.prev().children()[0].pathname;
        }



     gParent.remove();

      menuExtList = localStorage.getItem('menuExtList');
    if (menuExtList != null && menuExtList != 'null' ){
     menuExtList = JSON.parse(menuExtList);
    var keys = Object.keys(menuExtList);

    $.each(menuExtList,function(i,item){
    if (item == parent.text()){
        delete menuExtList[i];
    }

    });

    /*


    }

    localStorage.setItem('menuExtList',JSON.stringify(menuExtList));

    //let iframe = document.getElementById("mainFrame");

    /*
     setTimeout(function() {
         //iframe.src = url;
         $("#mainFrame").attr("src",url);
        }, 10);

        */
    });


    //->Top menu left button click
    $(document).on("click",".top-menu-scrollleft",function(ev){
       let maxScrollLeft = $(".top-menu-content")[0].scrollWidth;
       if ($(".top-menu-content")[0].scrollLeft < 0) {
           $(".top-menu-content")[0].scrollLeft = 0;
       }
       else if ($(".top-menu-content")[0].scrollLeft > maxScrollLeft){
           $(".top-menu-content")[0].scrollLeft = maxScrollLeft;
       }else{
           $(".top-menu-content")[0].scrollLeft += 30;
       }

    });


    $(document).on("click",".top-menu-scrollright",function(ev){
        let maxScrollLeft = $(".top-menu-content")[0].scrollWidth;
        if ($(".top-menu-content")[0].scrollLeft < 0) {
            $(".top-menu-content")[0].scrollLeft = 0;
        }
        else if ($(".top-menu-content")[0].scrollLeft > maxScrollLeft){
            $(".top-menu-content")[0].scrollLeft = maxScrollLeft;
        }else{
            $(".top-menu-content")[0].scrollLeft -= 30;
        }

    })



    //angular js controller
    var app = angular.module("myapp",['ngStorage']);
    app.controller("myctrl",function($scope,$localStorage,$sessionStorage,$http) {
        if ($localStorage['user_code'] != undefined && $localStorage['user_code'] != null){
            $('#user_info1').text('用户： '+ $localStorage['user_code']);
        }
        if ($localStorage['role_text'] != undefined && $localStorage['role_text'] != null){
            $('#user_info2').text('角色： '+ $localStorage['role_text']);
        }
        if ($localStorage['company_code'] != undefined && $localStorage['company_code'] != null){
            $('#user_info3').text('公司： '+ $localStorage['company_code']);
        }

        return true;
     //<-End
    });

    //<-End
</script> 