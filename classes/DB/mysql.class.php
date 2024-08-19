<?php
namespace classes\DB{
    
    class mysql {
        private $db_host = 'localhost' ;    //Database Host
        //private $db_host = '192.168.31.189' ;    //Database Host
        private $db_user = 'admin';         //Database User
        private $db_pwd  = 'password';     //Database User Password
        private $db_database = 'wms01_db';     //Database
        protected $charset = 'utf8'; 
        
        private $mysqli; 
        public $db_link; 
        public $result;
        public $rows;
        
        public function __construct($arr=array()) {
            $this->db_host = isset($arr['db_host'])? $arr['db_host']:$this->db_host;
            $this->db_user = isset($arr['db_user'])? $arr['db_user']:$this->db_user;
            $this->db_pwd = isset($arr['db_pwd'])? $arr['db_pwd']:$this->db_pwd;
            $this->db_database = isset($arr['db_database'])? $arr['db_database']:$this->db_database;
            $this->charset = isset($arr['charset'])?$arr['charset']:$this->charset;
            
            //$this->connect();
            //$this->setCharacter();
            
        }
        
         public function connect_db(){
             $this->mysqli = @new \mysqli($this->db_host,$this->db_user,$this->db_pwd,$this->db_database);
             if(!$this->mysqli){
                 echo '数据库连接错误.<br/>';
                 echo '错误编号'.$this->mysqli->connect_errno,'<br/>';
                 echo '错误内容'.$this->mysqli->connect_error,'<br/>';
                 exit;
             }
             $this->setCharacter();
         }
         
         private function setCharacter(){
             $this->db_query("set names {$this->charset}");
         }
         
         
         public function mysql_commit(){
             $this->mysqli->commit();

         }
          
         public function db_generated_id(){
             return $this->mysqli->affected_rows ? $this->mysqli->insert_id : false;
         }
         
         public function db_insert($sql){
             $this->db_query($sql);
             return $this->mysqli->affected_rows ? $this->mysqli->affected_rows : false;
         }
         
         
         public function db_delete($sql){
             $this->db_query($sql);
             return $this->mysqli->affected_rows ? $this->mysqli->affected_rows : false;
             
         }
         
         public function db_update($sql){
             $this->db_query($sql);
             return $this->mysqli->affected_rows ? $this->mysqli->affected_rows : false;
             
         }
         
         
         public function db_getRow($sql){
             $res=$this->db_query($sql);
             
             return $res->num_rows ? $res->fetch_assoc() : false;
             
         }
         
         public function db_getRowCount($sql){
             $count=0;
             $res=$this->db_query($sql);
             if(mysqli_num_rows($res)){
                 $rs = mysqli_fetch_array($res);
                 $count = $rs[0];
             }
             
             return $count;
         }
         
         public function db_getMaxValue($sql){
             $maxValue=0;
             $res=$this->db_query($sql);
             if(mysqli_num_rows($res)){
                 $rs = mysqli_fetch_array($res);
                 $maxValue = $rs[0];
             }
             
             return $maxValue;
         }
         

         public function db_getRows($sql){
             $res=$this->db_query($sql);
             if($res->num_rows){
                 $list=array();
                 while($row=$res->fetch_assoc()){
                     $list[]=$row;
                 }
                 return $list;
             }
             
             return false;
             
         }
         
         public function db_storeProcedure_cud($sql){
             $this->db_query($sql);
             return $this->mysqli->affected_rows ? $this->mysqli->affected_rows : false;
         }
         
         private function db_query($sql){
             $res=$this->mysqli->query($sql);
             if(!$res){
                 echo '语句出现错误<br/>';
                 echo '错误编号'.$this->mysqli->errno,'<br/>';
                 echo '错误内容'.$this->mysqli->error,'<br/>';
                 exit;
                 
             }
             return $res;
         }
        
         public function close_db(){
             if(is_object($this->mysqli))
             {
                 $this->mysqli->close();
                 $this->mysqli = null;
             }
         }
        
       //<---End Class
    }
}