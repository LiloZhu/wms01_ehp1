<?php
namespace classes\API
{
    class api_material{
        private $ado;
        
        public function __construct(){
            $this->ado = new \classes\DB\mysql_helper();
        }
        
        public function retrieve_for_sync(){
            $sql = "select * from v_mat_text_ext ";
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