<?php
namespace classes\DB
{
    class mysql_helper{
        private $mysqldb;
        
        public function __construct(){
            $this->mysqldb = new \classes\DB\mysql();
        }
        
        //Create
        public function Create($sql){
            $this->mysqldb->connect_db();
            $action_flag = $this->mysqldb->db_insert($sql);
            $this->mysqldb->close_db();
            return $action_flag;
        }
        //Create&Return Inster ID
        public function CreateAndReturnID($sql){
            $this->mysqldb->connect_db();
            $this->mysqldb->db_insert($sql);
            $action_flag = $this->mysqldb->db_generated_id();
            $this->mysqldb->close_db();
            return $action_flag;
        }
        //Retrieve
        
        public function MaxValue($sql)
        {
            $this->mysqldb->connect_db();
            $result = $this->mysqldb->db_getMaxValue($sql);
            $this->mysqldb->close_db();
            return $result;
        }
        
        public function Retrieve($sql)
        {
            $this->mysqldb->connect_db();
            $result = $this->mysqldb->db_getRows($sql);
            $this->mysqldb->close_db();
            return $result;
        }
        
        public function Retrieve_OneRow($sql)
        {
            $this->mysqldb->connect_db();
            $result = $this->mysqldb->db_getRow($sql);
            $this->mysqldb->close_db();
            return $result;
            
        }
                
        //Update
        public function  Update($sql)
        {
            $this->mysqldb->connect_db();
            $action_flag = $this->mysqldb->db_update($sql);
            $this->mysqldb->close_db();
            return $action_flag;
        }
        //Delete
        public function Delete($sql)
        {
            $this->mysqldb->connect_db();
            $action_flag = $this->mysqldb->db_delete($sql);
            $this->mysqldb->close_db();
            return $action_flag;
        }
        
        //Get Rows Count
        public function Count($sql)
        {
            $this->mysqldb->connect_db();
            $result = $this->mysqldb->db_getRowCount($sql);
            $this->mysqldb->close_db();
            return $result;
        }
        
        //<---End
    }
}