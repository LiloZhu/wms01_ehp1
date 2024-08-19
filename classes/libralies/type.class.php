<?php
namespace classes\libralies
{
    class type{
        private $ado;
        
        public function __construct(){
            $this->ado = new \classes\DB\mysql_helper();
        }
        
        
        public function get_type($cat_code,$where_use){
           $condition = "";
           if ($cat_code != "" && $where_use !=""){
               $condition = "where cat_code = '{$cat_code}' and where_use = '{$where_use}' ";
           }elseif($cat_code != ""){
               $condition = "where cat_code = '{$cat_code}'";
           }elseif($where_use !=""){
               $condition = "where where_use = '{$where_use}' ";
           }
           
           $sql = "select * from tb_type ";
           $sql .= $condition;
           $res = $this->ado->Retrieve($sql);
           return $res;
        }
        
        //Section: user for "new / edit" modal html area
        //e.g: new_type_code, edit_type_code 
        public function build_html_type($section,$cat_code,$where_use){
            $_html = "";
            $res = $this->get_type($cat_code,$where_use);
            //$cols = array_keys($res);
            
            $_html .= "<div class='form-inline'>";
            
            $_html .= "<label for='{$section}' class='control-label mr-1'>类型</label>";
            $_html .= "<select name='{$section}' class='form-control'>";
            
            if ($res != false){
                foreach($res as $row) {
                    $_html .= "<option value='{$row['type_code']}'>{$row['type_text']}</option>";
                }
            }
            
		   $_html .= "</select>";
           $_html .= "</div>";  
            
           return $_html;
        }
      
        
  //<---      
    }
}