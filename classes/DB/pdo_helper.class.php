<?php
require( __DIR__ . '/PDO.class.php');
define('DBHost', 'localhost');
define('DBPort', 3306);
define('DBName', 'wms_db');
define('DBUser', 'admin');
define('DBPassword', 'password');

class pdo_helper{
   private $pdodb;

   
   public function __construct(){
       $this->pdodb = new DB(DBHost, DBPort, DBName, DBUser, DBPassword);  
   }
   
   //Create
   public function create($sql){
       $action_flag = $this->pdodb->Query($sql);
       return $action_flag;
   }

   //Retrieve
   public function retrieve($sql)
   {
       $result = $this->pdodb->query($sql);
       return $result;
   }
   
   
   
   //<---
}
    
    
    
