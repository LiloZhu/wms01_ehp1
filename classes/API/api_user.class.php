<?php
namespace classes\API
{
    class api_user{
        private $ado;
        
        public function __construct(){
            $this->ado = new \classes\DB\mysql_helper();
        }
        
        public function retrieve_for_sync(){
            $sql = "select * from v_user_text ";
            $result = $this->ado->Retrieve($sql);
            if ($result != false) {
                return $result;
            }else{
                return null;
            }
        }
        
        
        //<---End
    }
}