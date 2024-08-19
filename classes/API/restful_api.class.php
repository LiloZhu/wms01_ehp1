<?php
namespace classes\API
{
   class restful_api
   {
       private $mysqldb;
       
       public function __construct() {
           $this->mysqldb = new \classes\DB\mysql(); 
       }
       
       public function get_JSONData($sql){
           //$jsoncallback = htmlspecialchars($_REQUEST ['jsoncallback']);
           
           $col_flag='';
           $data = array();
           $this->mysqldb->connect_db();
           $result = $this->mysqldb->db_getRows($sql);          
           $this->mysqldb->close_db();
           if (sizeof($result) > 0)
           {
               $data=array("result"=>$result);
               
               echo json_encode($data);
               
           }
       }
       
   //<---Class End    
   }



//<End

}
   