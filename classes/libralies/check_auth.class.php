<?php
namespace classes\libralies
{
    class check_auth{
        
        public function check_login_session(){
            session_start();
            if (isset($_SESSION["uid"]) == "")
            {   
                header("location:login.php");
            }
            
        }
 
    
    //<---End
    }
}