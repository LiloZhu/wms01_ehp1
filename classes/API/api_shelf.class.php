<?php
namespace classes\API
{
    class api_shelf{
        private $ado;
        
        public function __construct(){
            $this->ado = new \classes\DB\mysql_helper();
        }
        
        public function get_shelf_data($uid){
            $sql = "";
            $sql = "select * from v_shelf_text where create_by = '{$uid}' and DATE_FORMAT(create_at,'%Y-%m-%d') = DATE_FORMAT(NOW(),'%Y-%m-%d') ";
                        
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