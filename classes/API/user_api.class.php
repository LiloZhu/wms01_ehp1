<?php
namespace classes\API
{
    class user_api{
        private $mysqldb;
        
        public $id;
        public $user_name;
        public $user_pwd;
        public $email;
        public $safe_question;
        public $safe_answer;
        public $reg_time;
        public $sex;
        
        public function __construct() {
            $this->mysqldb = new \classes\DB\mysql();
        }
        
        public function create(){
            $this->reg_time = date( "Y-m-d H:i:s" );                    
            $sql= "insert into tb_user values(
                   null,
                   '{$this->user_name}',
                   '{$this->user_pwd}',
                   '{$this->email}',
                   '{$this->safe_question}',
                   '{$this->safe_answer}',
                   '{$this->reg_time}',
                   '{$this->sex}'
            )";
            
            $this->mysqldb->connect_db();
            $action_flag = $this->mysqldb->db_insert($sql);
            $this->mysqldb->close_db();
            return $action_flag;
        }           
        
        public function retrieve_by_id($action_id){
            $sql = "select * from tb_user where id = '{$action_id}' ";
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
        
        public function update(){
            $sql= "update tb_user set
                       user_name = '{$this->user_name}',
                       user_pwd = '{$this->user_pwd}',
                       email = '{$this->email}',
                       safe_question = '{$this->safe_question}',
                       safe_answer = '{$this->safe_answer}',
                       sex = '{$this->sex}'
                   where id = '{$this->id}'";
            
            $this->mysqldb->connect_db();
            $action_flag = $this->mysqldb->db_update($sql);
            $this->mysqldb->close_db();
            return $action_flag;
        }
        
        public function delete(){
            $sql= "delete from tb_user 
                   where id = '{$this->id}'";
            
            $this->mysqldb->connect_db();
            $action_flag = $this->mysqldb->db_delete($sql);
            $this->mysqldb->close_db();
            return $action_flag;
        }
        
        //<---End
    }
}