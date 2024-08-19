<?php
//---Treeview Realization for Menu
namespace classes\libralies
{
    class menu{
        private $mysqldb;
        
        public function __construct(){
            $this->mysqldb = new \classes\DB\mysql();
        }
   
        public function get_test() {
            $sql = "select * from tb_menu where type_code = 'L' and admin_flag = '' order by concat(path,id);";
            $this->mysqldb->connect_db();
            $result = $this->mysqldb->db_getRows($sql);
            $this->mysqldb->close_db();
            return $result;
        }
        
        public function build_menu_tree(){
            $_html='';
            $lvl = 0;
            
            $res = $this->get_test();
            if($res==false){
                return;
            }
            
            foreach($res as $row) {                
                if ($row['pid'] == 0){
                    if (strlen($row['path']) < $lvl ){
                        $_html .= "</li>";
                        $_html .= "</ul>";
                    }
                    $_html .= "<li><input type='checkbox' id='cb{$row['id']}' name='cb{$row['id']}'>{$row['menu_name']}";
                }else{
                    if (strlen($row['path']) > $lvl ){
                            $_html .= "<ul>";
                            $_html .= "<li><input type='checkbox' id='cb{$row['id']}' name='cb{$row['id']}'>{$row['menu_name']}";
                        }
                        elseif(strlen($row['path']) == $lvl){
                            $_html .= "</li>";
                            $_html .= "<li><input type='checkbox' id='cb{$row['id']}' name='cb{$row['id']}'>{$row['menu_name']}";
                        }else{
                            $_html .= "</li>";
                            $_html .= "</ul>";
                            $_html .= "<li><input type='checkbox' id='cb{$row['id']}' name='cb{$row['id']}'>{$row['menu_name']}";
                        }

                    }
                    
                
                $lvl = strlen($row['path']);    
            }
            
            if ($lvl = 2){
                $_html .= "</li>";
            }else{
                $_html .= "</li>";
                $_html .= "</ul>";
            }
            
            return $_html;
                
        }
        
        
    //<---End
    }
}