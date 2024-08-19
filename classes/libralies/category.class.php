<?php
namespace classes\libralies
{
    class category{
        private $ado;
        
        public function __construct(){
            $this->ado = new \classes\DB\mysql_helper();
        }
        
        
        public function get_category($where_use){
           $condition = "";
           if($where_use !=""){
             $condition = "where where_use = '{$where_use}' ";
           }
           
           $sql = "select * from tb_category ";
           $sql .= $condition;
           $res = $this->ado->Retrieve($sql);
           return $res;
        }
        
        public function build_html_category($section,$where_use){
            $_html = "";
            $res = $this->get_category($where_use);
            //$cols = array_keys($res);
            
            $_html .= "<div class='form-inline'>";
            
            $_html .= "<label for='{$section}' class='control-label mr-1'>类别</label>";
            $_html .= "<select name='{$section}' class='form-control'>";
            if($res != FALSE){
            foreach($res as $row) {
                $_html .= "<option value='{$row['cat_code']}'>{$row['cat_text']}</option>";
             }
            }
		   $_html .= "</select>";
           $_html .= "</div>";  
            
           return $_html;
        }
      
        
  //<---      
    }
}