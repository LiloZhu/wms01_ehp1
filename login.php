<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>mywms</title>
  <!-- Font Awesome -->
  <link rel="stylesheet" href="plugins/fontawesome-free-6.6.0-web/css/all.min.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="plugins/bootstrap/css/bootstrap.min.css">
  <!-- layui -->
  <link rel="stylesheet" href="plugins/layui/css/layui.css">  
  <!-- Theme style -->
  <link rel="stylesheet" href="css/login.css">
  
  <!-- jQuery -->
  <script src="plugins/jquery/jquery.min.js"></script>
    
  <!-- Template -->
  <script src="plugins/handlebars.js/handlebars.min.js"></script>
  <script src="plugins/underscore/underscore-min.js"></script>
    

  <!-- AdminLTE App 
  <script src="js/adminlte.min.js"></script>  
 --> 
 
  <!-- layui -->
  <script src="plugins/layui/layui.js"></script>
  <!-- Custom JS -->
  <script src="js/common.js"></script>    
  
  <!-- Custom JavaScript -->
  <script>
  $(document).ready(function(){
	  //SetFocusFieldById(true,"user_name");
	  
  });
  </script>
</head>

<body class="hold-transition login-page">>

<div class="login-box" style="margin-top: -10%;">
  <!-- /.login-logo -->
  <div class="card card-outline card-primary">
    <div class="card-header text-center">
    	<div class="system-version-top-right"><span class="badge bg-primary system-version">{{version}}</span></div>
      	<div class="login-box-title"><a href="#"><b class="login-box-title system-title">{{system_name}}</b></a></div>
    </div>
    <div class="card-body">
      <p class="login-box-msg"></p>
      
      <div class="input-group mb-3">
      <select class="form-select form-select-sm" id="system_language" aria-label="Large select example">
      <option selected>Please Select Login Language</option>
   	  </select>
   	  <div class="input-group-append">
        <div class="input-group-text">
          <span class="fa-solid fa-globe login-icon"></span>
        </div>
      </div>
      </div>
        
        
        <div class="input-group mb-3">
          <input type="text" class="form-control" id="user_name" name="user_name"  keyup="keyup($event)" placeholder="User or Email">          
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-user login-icon"></span>
            </div>
          </div>
        </div>
        
        
        <div class="input-group mb-3">
          <input type="password" class="form-control" id="password" name="password" keyup="keyup($event)" placeholder="Password">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock login-icon"></span>
            </div>
          </div>
        </div>
        <!--  
        <div class="row">
          <div class="col-8">
            <div class="icheck-primary">
              <input type="checkbox" id="remember">
              <label for="remember">
                记住我
              </label>
            </div>
          </div>
          -->
          <!-- /.col -->
          <div>
            <button type="submit" style="width: 100%" class="btn btn-primary btn-block" onclick="login()">登录</button>
            <div style="display: flex;
                justify-content: flex-end;
                align-items: flex-end;">
            <a class="small mt-3 pointer" href="./pages/registration.php">帐号申请...</a><span style="color:#C0C0C0"> | </span>
            <a class="small mt-3" href="./pages/forget_password.php">忘记密码...</a>
            </div>
          </div>
          <!-- /.col -->
        </div>
        

    </div>
    <!-- /.login-card-body -->
  </div>
</div>
<!-- /.login-box -->
</body>

<!--JS -->
	<script type="text/javascript">
		 layui.use('layer', function(){ //独立版的layer无需执行这一句
			  var layer = layui.layer; //独立版的layer无需执行这一句
			 });



		async function sysInfo(){
            const response = await fetch('login_action.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({ action: 'language' })
            });

            if (response.ok) {
                const data = await response.json();

                if(data.isExist){
                    for (let i = 0; i < data.rows.length; i++) {
                        console.log(data.rows[i]); // Prints each fruit

                        var vOption = document.createElement('option');
						vOption.value = data.rows[i].language_code;
						vOption.text = data.rows[i].language_text;

					    var selectElement = document.getElementById('system_language');
					    selectElement.appendChild(vOption);						
                        
                    }

                    if(localStorage.getItem("language_code") != null || localStorage.getItem("language_code") != undefined || localStorage.getItem("language_code") != '')
                    {
                    	document.getElementById("system_language").value = localStorage.getItem("language_code");
                    }


                    
                }
				
                console.log(data);
            } else {
                console.error('Network response was not ok', response.status);
            }		
		}



	   async function systemInfo(){
		  var lang_code =  $("#language_code").val();
		  if (lang_code == null || lang_code == undefine || lang_code == '')
			 {
		       lang_code = 'ZH';
			 }  
		  
          const response = await fetch('login_action.php', {
              method: 'POST',
              headers: {
                  'Content-Type': 'application/json',
              },
              body: JSON.stringify({ action: 'info',
 				 arguments: {
					 language_code: lang_code
		    		}
	    		 })
          });


          if (response.ok) {
              const data = await response.json();
              if(data.isExist){
                  $(".system-title").text(data.rows[0]["system_text"]);
                  $(".system-version").text(data.rows[0]["version"]);				                  
              }	
			  	
              console.log(data);
          } else {
              console.error('Network response was not ok', response.status);
          }	
          	      
		    
	   }	


	  async function login(){
		  var lang_code =  $("#language_code").val();
		  if (lang_code == null || lang_code == undefine || lang_code == '')
			 {
		       lang_code = 'ZH';
			 }  
		  
          const response = await fetch('login_action.php', {
              method: 'POST',
              headers: {
                  'Content-Type': 'application/json',
              },
              body: JSON.stringify({ action: 'login',
 				 arguments: {
 					user_code:     $("#user_name").val(),
 					user_password: $("#password").val(), 
		    		}
	    		 }) 
          });


          if (response.ok) {
              const data = await response.json();
              if(data.isExist){
              	localStorage.setItem("uid", data.rows[0]["id"]);
            	localStorage.setItem("user_code", data.rows[0]["user_code"]);
            	localStorage.setItem("user_text", data.rows[0]["user_text"]);
            	localStorage.setItem("company_code", data.rows[0]["company_code"]);
            	localStorage.setItem("role_code", data.rows[0]["role_code"]);
            	localStorage.setItem("role_text", data.rows[0]["role_text"]);
            	localStorage.setItem("email", data.rows[0]["email"]);
            	localStorage.setItem("language_code", $('#system_language').val());		


				var url = 'iframe_2.html';
				window.location=url;     
            		                  
              }	
			  	
              console.log(data);
          } else {
              console.error('Network response was not ok', response.status);
          }	
          	  
	  }

		
		sysInfo();
		systemInfo();
				
				
		//<-End		

	</script>
</html>
