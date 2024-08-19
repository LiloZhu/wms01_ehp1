<?php
namespace classes\API
{
    class api_smart_device{
        private $ado;
        
        public function __construct(){
            $this->ado = new \classes\DB\mysql_helper();
        }
        
        public function process_smart_device($device_code,$device_text,$where_use,$trigger_code,$status_code,$uid){
            $sql = "";
            $sql = "insert into tb_smart_device
                    (device_code,device_text,where_use,trigger_code,status_code,delete_flag,create_at,create_by)
                    values('{$device_code}','{$device_text}','{$where_use}','{$trigger_code}','{$status_code}',false,sysdate(),'{$uid}');";
            
            $action_flag = $this->ado->Create($sql);
            
            if ($action_flag > 0){
                return true;
            }else{
                return false;
            }
            
        }
        
        //<--End
    }
}