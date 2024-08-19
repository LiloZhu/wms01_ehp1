<?php
namespace classes\API
{
    class api_inventory{
        private $ado;
        
        public function __construct(){
            $this->ado = new \classes\DB\mysql_helper();
        }
        
        public function get_inventory_data($uid){
            $sql = "";
            $sql = "call proc_get_inventory_ext(); ";
            
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