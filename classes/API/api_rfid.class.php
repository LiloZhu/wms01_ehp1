<?php
namespace classes\API
{
    class api_rfid{
        private $ado;
        
        public function __construct(){
            $this->ado = new \classes\DB\mysql_helper();
        }
        
        public function process_rfid($uid,$company_code,$type_code,$epc){
            $sql = "";
            $sql = "call proc_process_rfid('{$uid}','{$company_code}','{$type_code}','{$epc}');";
            
            $action_flag = $this->ado->Create($sql);
            
            if ($action_flag > 0){
               return true;
            }else{
                return false;
            }
            
        }
        
        public function process_inventory($uid,$company_code,$type_code,$epc){
            $sql = "";
            $sql = "call proc_process_inventory('{$uid}','{$company_code}','{$type_code}','{$epc}');";
            
            $action_flag = $this->ado->Create($sql);
            
            if ($action_flag > 0){
                return true;
            }else{
                return false;
            }
            
        }
        
        
        public function process_outbound($uid,$outbound_number,$rfid){
            $sql = "";
            $sql = "call proc_outbound_process('{$uid}','{$outbound_number}','{$rfid}');";
            
            $action_flag = $this->ado->Create($sql);
            
            if ($action_flag > 0){
                return true;
            }else{
                return false;
            }
            
        }
        
        public function get_outbound_req($rfid){
            $sql = "";
            $sql = "select * from v_outbound_req_text where status_code = 'REL' and delete_flag = false and rfid = '{$rfid}' ";
            
            $result = $this->ado->Retrieve($sql);
            if ($result != false) {
                return $result;
            }else{
                return null;
            }
            
        }
        
        public function get_label($rfid){
            $sql = "";
            $sql = "SELECT * FROM v_label_text where delete_flag = false and rfid = '{$rfid}' ";
            
            $result = $this->ado->Retrieve($sql);
            if ($result != false) {
                return $result;
            }else{
                return null;
            }
            
        }
        
        public function get_shelf_label($rfid){
            $sql = "";
            $sql = "SELECT * FROM v_shelf_text where status_code = 'ON' and rfid = '{$rfid}' ";
            
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