<?php
namespace classes\libralies
{
    class user_role_action{
        private $mysqldb;
        
        public function __construct(){
            $this->mysqldb = new \classes\DB\mysql();
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
        
        public function create($user_id,$role_id){
            $this->mysqldb->connect_db();
            $sql="insert into tb_user_role
                    values(
                       '{$user_id}',
                       '{$role_id}'
                        )";
            
            $action_flag = $this->mysqldb->db_insert($sql);
            //print_r($_POST);
            $this->mysqldb->close_db();
            return $action_flag;
            
        }
        
        public function delete($id)
        {
            $this->mysqldb->connect_db();
            $sql = "delete from tb_user_role where user_id = {$id} ";
            $action_flag = $this->mysqldb->db_delete($sql);
            $this->mysqldb->close_db();
            return $action_flag;
        }
        
        public function build_table($res){
            $col_flag='';
            $str_html='';
            $link_index = '';
            $skip_index = '';
            $cols = array_keys($res);
            $str_html.='<div><table class="table table-bordered"><tr><caption>用户角色信息</caption>';
            
            foreach($res as $row) {
                if ($col_flag <> 'X')
                {
                    $cols = array_keys($row);
                    //$str_html.= "<th><input  id='selectAll' role='checkbox' type='checkbox'  class='cbox checkbox' /></th>";      
                    for($i=0; $i < sizeof ( $cols ); $i++)
                    {
                        $str_html.=' <th>'.$cols[$i].'</th>';
                    }
                    $str_html.=' <th>action</th>';
                    $str_html.= "<tbody id='tbody1'>";
                    $col_flag = 'X';
                }
                
                $row_value = array_values($row);
                $str_html.=' <tr>';
                //$str_html.="<td><input role='checkbox' type='checkbox' name='chk_menu[{$row['id']}]' {$this->get_active_flag($row['id'])} class='cbox checkbox'></td>";
                for($j=0; $j < sizeof ( $row_value ); $j++)
                {
                    $str_html.=' <td>'.$row_value[$j].'</td>';
                    
                }
                
                $str_html.=" <td><a href='user_role_edit.php?id={$row['id']}'>编辑用户角色</a>";
//                 $str_html.=" | <a href='user_add.php?id={$row['id']}'>添加用户</a>";
//                 $str_html.=" | <a href='user_role.php?id={$row['id']}'>用户角色</a>";
//                 $str_html.=" | <a href='user_action.php?action=del&id={$row['id']}'>删除用户</a>";  
                $str_html.='</td>';
                $str_html.=' </tr>';
            
            }
            $str_html.= "</tbody>";
            $str_html.='</table>';
            $str_html.='</div>';
            return $str_html;
        }        
        
        
        public function build_user_role($res){
            $col_flag='';
            $str_html='';
            $link_index = '';
            $skip_index = '';
            $cols = array_keys($res);
            foreach($res as $row) {
                if ($col_flag <> 'X')
                {
                    
                    $col_flag = 'X';
                    
                    $str_html.="<div><table class='table table-bordered'><tr><caption>用户名: {$row['user_name']}</caption>";
                    $str_html.= "<th><input  id='selectAll' role='checkbox' type='checkbox'  class='cbox checkbox' /></th>";
                    $str_html.=' <th>角色ID</th>';
                    $str_html.=' <th>action</th>';
                    $str_html.= "<tbody id='tbody1'>";
                    $str_html.=' <tr>';
                    
                }
                $str_html.="<td><input role='checkbox' type='checkbox' name='chk_role[{$row['role_id']}]' {$this->get_active_flag($row['active'])} class='cbox checkbox'></td>";
                $str_html.="<td>{$row['role_id']}</td>";
                $str_html.="<td>{$row['role_name']}</td>";
                $str_html.=' <tr>';
                
            }
            
            $str_html.= "</tbody>";
            $str_html.='</table>';
            $str_html.='</div>';
            return $str_html;
        }

        public function update_user_role($user_id,$role_ids){
            //Step 1, Delete Exist Role menus
            $this->delete($user_id);
            //Build New Role Menus
            if ($role_ids <> ""){
            foreach($role_ids as $role_id) {
                $this->create($user_id,$role_id);
            }
            }
        }
        
        public function get_active_flag($active){
            if ($active=="X"){
                return 'checked="checked"';
            }else{
                return '';
            }
        }
        
        
        
        //<--End
    }
}