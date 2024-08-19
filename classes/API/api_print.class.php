<?php
namespace classes\API
{
    class api_print{
        private $ado;
        
        public function __construct(){
            $this->ado = new \classes\DB\mysql_helper();
        }
        
        public function get_print_data($company_code,$location_code){
            $sql = "";
            //$sql = "select * from v_print_pool_text where status_code = 'READY'  ";
            if($company_code == 'ALL'){
                $sql = "select * from v_print_pool_text where status_code = 'READY' and user_flag = false ";
            }else
            {
                $sql = "select * from v_print_pool_text where status_code = 'READY' and user_flag = false and company_code = '{$company_code}' and location_code ='{$location_code}' ";
            }
            
            $result = $this->ado->Retrieve($sql);
            if ($result != false) {
             return $result;
            }else{
                return null;
            }
            
        }
        
        public function get_user_print_data($company_code,$location_code){
            $sql = "";
            //$sql = "select * from v_print_pool_text where status_code = 'READY'  ";
            if($company_code == 'ALL'){
                $sql = "select * from v_user_print_pool_text where status_code = 'READY' and user_flag = true ";
            }else
            {
                $sql = "select * from v_user_print_pool_text where status_code = 'READY' and user_flag = true and company_code = '{$company_code}' and location_code ='{$location_code}' ";
            }
            
            $result = $this->ado->Retrieve($sql);
            if ($result != false) {
                return $result;
            }else{
                return null;
            }
            
        }
        
        public function update_print_data($company_code,$id,$rfid,$status_code,$uid){
            $sql = "";
            $sql = "call proc_print_pool_update('{$company_code}', '{$id}','{$rfid}','{$status_code}','{$uid}');";
            
            $action_flag =  $this->ado->Create($sql);
            
            if ($action_flag = true){
                $arrResult['success']= true;
                $arrResult['message']= $rfid;
            }else{
                $arrResult['success']= false;
                $arrResult['message']= $rfid;
            }
            return $arrResult;

        }
        
        //<--End
    }
}