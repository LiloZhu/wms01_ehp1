<?php
namespace classes\libralies
{
    class admin{
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
        
       
        public function get_user($user,$password){
            $user_pwd = md5($password);
            $sql ="select * from tb_user where ( user_code = '{$user}' or email= '{$user}' )  and password ='{$user_pwd}' ;";
            $this->mysqldb->connect_db();
            $result = $this->mysqldb->db_getRow($sql);
            $this->mysqldb->close_db();
            return $result;
            
        }
        
        public function get_user_by_rfid($_rfid){
            $sql = "";
            $sql ="SELECT id,
                    user_code,
                    user_text,
                    company_code,
                    department_code,
                    division_code,
                    title_code,
                    job_code,
                    cost_center_code,
                    email,
                    telphone,
                    mobile,
                    rfid
                FROM tb_user
                where rfid = '{$_rfid}' and active = true and delete_flag = false;";
            $this->mysqldb->connect_db();
            $result = $this->mysqldb->db_getRow($sql);
            $this->mysqldb->close_db();
            return $result;
        }
        
        //<--End
    }
}