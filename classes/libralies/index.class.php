<?php
namespace classes\libralies
{
    class index{
        private $mysqldb;
        
        public function __construct(){
            $this->mysqldb = new \classes\DB\mysql();
        }
        
        public function get_menu($user_id,$type_code,$admin_flag){
            $sql ="select * from tb_menu where type_code = '{$type_code}' and admin_flag = '' order by concat(path,id);";
            $sql ="call proc_get_user_type_menu('{$user_id}', '{$type_code}', '{$admin_flag}');";
            $this->mysqldb->connect_db();
            $result = $this->mysqldb->db_getRows($sql);
            $this->mysqldb->close_db();
            return $result;
        }
        
        public function build_menu($user_id,$type_code,$admin_flag){
            $str_html='';
            $str_hd_id='';
            $str_sub_id='';
            $str_tag='';
            $idx='0';
            
            $res = $this->get_menu($user_id,$type_code,$admin_flag);
            if($res==false){
                echo $res;
                return;
            }
            
            $cols = array_keys($res);
            
            foreach($res as $row) {
                if ($row['pid']=='0'){
                    if ($idx !== '0'){
                        //$str_html .='</ul>';
                        //$str_html .='</div>';
                        $str_html .='</div>';
                        $str_html .='</div>';
                    }
                    
                    $idx = $idx + 1;
                    $str_hd_id = 'header'.$idx;
                    $str_sub_id = 'sub'.$idx;
                    $str_tag ='#'.$str_sub_id;
                    $str_html .="<div id='{$str_hd_id}' class='card-header' style='height:32px;' data-toggle='collapse' data-target='{$str_tag}' data-parent='#panelContainer_h'>";
                    $str_html .="<div class='divH-align-middle'>";
                    $str_html .="<i class='glyphicon {$row['icon']}'></i>";
                    $str_html .="<a>{$row['menu_name']}</a>";
                    $str_html .='<span class="glyphicon glyphicon-triangle-right pull-right"></span>';
                    
                    // $str_html .="<a class='list-group-item active'><span class='glyphicon {$row['icon']}'></span>{$row['menu_name']}<a/>";
                    $str_html .="</div>";
                    $str_html .='</div>';
                    
                    $str_html .="<div id='{$str_sub_id}' class='collapse panel-collapse'>";
                    $str_html .="<div class='card-body absCardBodyBlock'>";
                    //$str_html .='<ul class="nav">';
                    
                }else{
                    $str_html .="<div class='menuHover noAutoBR'>";
                    //$str_html .="<a href='{$row['url']}' class='list-group-item' target='mainFrame'><span></span>{$row['menu_name']}</a>";
                    $str_html .="<div style='margin-left:10%'><a class='menuLink' style='text-decoration:none;' href='{$row['url']}' target='mainFrame'>{$row['menu_name']}</a></div>";
                    $str_html .='</div>';
                }
                
                
            }
            if ($idx >0){
                //$str_html .='</ul>';
                //$str_html .='</div>';
                $str_html .='</div>';
                $str_html .='</div>';
            }
            
            return $str_html;
            
        }
        
        public function build_menu_x($user_id,$type_code,$admin_flag){
            $_html='';
            $_hd_id='';
            $_sub_id='';
            $_tag='';
            $idx='0';
            $lvl = 0;
            
            $res = $this->get_menu($user_id,$type_code,$admin_flag);
            if($res==false){
                echo $res;
                return;
            }
            
            $cols = array_keys($res);
            
            foreach($res as $row) {
                if ($row['pid']=='0'){
                    if (strlen($row['path']) < $lvl ){
                        $_html .='</div>';
                        $_html .='</div>';
                    }
                    
                    $idx = $idx + 1;
                    $_hd_id = 'header'.$idx;
                    $_sub_id = 'sub'.$idx;
                    $_tag ='#'.$_sub_id;
                    $_html .="<div id='{$_hd_id}' class='card-header' style='height:32px;' data-toggle='collapse' data-target='{$_tag}' data-parent='#panelContainer_h'>";
                    $_html .="<div class='divH-align-middle'>";
                    $_html .="<i class='glyphicon {$row['icon']}'></i>";
                    $_html .="<a>{$row['menu_name']}</a>";
                    $_html .='<span class="glyphicon glyphicon-triangle-right pull-right"></span>';
                    

                    $_html .="</div>";
                    $_html .='</div>';
                    
                    $_html .="<div id='{$_sub_id}' class='collapse panel-collapse'>";
                    $_html .="<div class='card-body absCardBodyBlock'>";

                    
                }else{
                             
                    $_html .="<div class='menuHover noAutoBR'>";
                    $_html .="<div style='margin-left:10%'><a class='menuLink' style='text-decoration:none;' href='{$row['url']}' target='mainFrame'>{$row['menu_name']}</a></div>";
                    $_html .='</div>';
                }
                
                
                $lvl = strlen($row['path']);    
            }
            if ($idx >0){
                //$_html .='</ul>';
                //$_html .='</div>';
                $_html .='</div>';
                $_html .='</div>';
            }
            
            return $_html;
            
        } 
        
        
        //<--End
    }
}