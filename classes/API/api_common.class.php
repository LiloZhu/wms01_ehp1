<?php
namespace classes\API
{
    class api_common{
        private $ado;
        
        public function __construct(){
            $this->ado = new \classes\DB\mysql_helper();
        }
        
        
        public function get_next_number($prefix,$where_use){
            $sql = "";
            $sql = "select get_next_id('{$prefix}','{$where_use}') as next_number ";
            
            $result = $this->ado->Retrieve($sql);
            if ($result != false) {
                return $result;
            }else{
                return null;
            }
            
        }
        

        
        //<--End
    }
}