<?php
namespace classes\libralies
{
    class role_menu_action{
        private $mysqldb;
        
        public function __construct(){
            $this->mysqldb = new \classes\DB\mysql();
        }
        
        
        public function create($role_id,$menu_id){
            $this->mysqldb->connect_db();
            $sql="insert into tb_role_menu
                    values(
                       '{$role_id}',
                       '{$menu_id}'
                        )";
            
            $action_flag = $this->mysqldb->db_insert($sql);
            //print_r($_POST);
            $this->mysqldb->close_db();
            return $action_flag;
            
        }
        
        public function update($id, $role_name, $description){
            $this->mysqldb->connect_db();
            
            $sql ="update tb_role set
                       role_name = '{$role_name}',
                       description = '{$description}'
                   where id = '{$id}'";
            
            $action_flag = $this->mysqldb->db_update($sql);
            //print_r($_POST);
            $this->mysqldb->close_db();
            return $action_flag;
        }
        
        public function retrieve($sql)
        {
            $this->mysqldb->connect_db();
            $result = $this->mysqldb->db_getRows($sql);
            $this->mysqldb->close_db();
            return $result;
        }
        
        public function retrieve_row($sql)
        {
            $this->mysqldb->connect_db();
            $result = $this->mysqldb->db_getRow($sql);
            $this->mysqldb->close_db();
            return $result;
        }
        
        public function delete($id)
        {
            $this->mysqldb->connect_db();
            $sql = "delete from tb_role_menu where role_id = {$id} ";
            $action_flag = $this->mysqldb->db_delete($sql);
            $this->mysqldb->close_db();
            return $action_flag;
        }
        
        public function build_table($res){
            $col_flag='';
            $str_html='';
            $link_index = '';
            $cols = array_keys($res);
            $str_html.='<div><table class="table table-bordered"><tr><caption>浏览角色菜单信息</caption>';
            
            foreach($res as $row) {
                if ($col_flag <> 'X')
                {
                    $cols = array_keys($row);
//                     $str_html.=' <th>action</th>';
                    for($i=0; $i < sizeof ( $cols ); $i++)
                    {
                        if ( $cols[$i] == "role_name" ){
                            $link_index = $i;
                        }
                        
                        $str_html.=' <th>'.$cols[$i].'</th>';
                    }
                    //$str_html.=' <th>action</th>';
                    
                    $col_flag = 'X';
                }
                
                $row_value = array_values($row);
                $str_html.=' <tr>';
                for($j=0; $j < sizeof ( $row_value ); $j++)
                {
                    if ($j == $link_index)
                    {
                        $str_html.=" <td><a href='role_menu_disp.php?id={$row['id']}'>{$row_value[$j]}</a></td>";
                    }else{
                        $str_html.=' <td>'.$row_value[$j].'</td>';
                    }
                    
                }
                // $str_html.=" <td><a href='role_edit.php?id={$row['id']}'>编辑角色</a>";
                $str_html.='</td>';
                $str_html.=' </tr>';
            }
            $str_html.='</table></div> ';
            return $str_html;
            
        }
        
        public function build_table_role_menu($res){
            $col_flag='';
            $str_html='';
            $link_index = '';
            $cols = array_keys($res);
            $str_html.='<div><table class="table table-bordered"><tr><caption>浏览角色菜单信息</caption>';
            
            foreach($res as $row) {
                if ($col_flag <> 'X')
                {
                    $cols = array_keys($row);
                    $str_html.= "<th><input  id='selectAll' role='checkbox' type='checkbox'  class='cbox checkbox' /></th>";
                    for($i=0; $i < sizeof ( $cols ); $i++)
                    {
//                         if ( $cols[$i] == "role_name" ){
//                             $link_index = $i;
//                         }
                        
                        $str_html.=' <th>'.$cols[$i].'</th>';
                    }
                    //$str_html.=' <th>action</th>';
                    $str_html.= "<tbody id='tbody1'>";
                    $col_flag = 'X';
                }
                
                $row_value = array_values($row);
                
                $str_html.=' <tr>';
                $str_html.="<td><input role='checkbox' type='checkbox' name='chk_menu[{$row['id']}]' {$this->get_active_flag($row['active'])} class='cbox checkbox'></td>";
                for($j=0; $j < sizeof ( $row_value ); $j++)
                {
//                     if ($j == $link_index)
//                     {
//                         $str_html.=" <td><a href='role_menu_disp.php?id={$row['id']}'>{$row_value[$j]}</a></td>";
//                     }else{
                        $str_html.=' <td>'.$row_value[$j].'</td>';
//                     }
                    
                }
                // $str_html.=" <td><a href='role_edit.php?id={$row['id']}'>编辑角色</a>";
                $str_html.='</td>';
                $str_html.=' </tr>';
                
            }
            $str_html.= "</tbody>";
            $str_html.='</table>';
            $str_html.='</div>';
            return $str_html;
            
        }
        
        public function get_active_flag($active){
            if ($active=="X"){
                return 'checked="checked"';
            }else{
                return '';
            }
        }
        
        
        public function update_role_menu($role_id,$menu_ids){
         //Step 1, Delete Exist Role menus
            $this->delete($role_id);
         //Build New Role Menus
            if ($menu_ids <> ""){
            foreach($menu_ids as $menu_id) {
                $this->create($role_id,$menu_id);
            }
            }
        }
        
        //<---End
    }
}