<?php
namespace classes\libralies
{
    class role_action{
        private $mysqldb;
        
        public function __construct(){
            $this->mysqldb = new \classes\DB\mysql();
        }
        
        
        public function create($role_name,$description){
            $this->mysqldb->connect_db();
            $sql="insert into tb_role
                    values(
                        null,
                       '{$role_name}',
                       '{$description}'
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
            $sql = "delete from tb_role where id = {$id} ";
            $action_flag = $this->mysqldb->db_delete($sql);
            $this->mysqldb->close_db();
            return $action_flag;
        }
 
        public function build_table($res){
            $col_flag='';
            $str_html='';
            $link_index = '';
            $cols = array_keys($res);
            $str_html.='<div><table class="table table-bordered"><tr><caption>浏览角色信息</caption>';
            
            foreach($res as $row) {
                if ($col_flag <> 'X')
                {
                    $cols = array_keys($row);
                    for($i=0; $i < sizeof ( $cols ); $i++)
                    {
                        if ( $cols[$i] == "role_name" ){
                            $link_index = $i;
                        }
                        
                        $str_html.=' <th>'.$cols[$i].'</th>';
                    }
                    $str_html.=' <th>action</th>';
                    
                    $col_flag = 'X';
                }
                
                $row_value = array_values($row);
                $str_html.=' <tr>';
                for($j=0; $j < sizeof ( $row_value ); $j++)
                {
                    if ($j == $link_index)
                    {
                        $str_html.=" <td><a href='role_disp.php?id={$row['id']}'>{$row_value[$j]}</a></td>";
                    }else{
                        $str_html.=' <td>'.$row_value[$j].'</td>';
                    }
                    
                }
                $str_html.=" <td><a href='role_edit.php?id={$row['id']}'>编辑角色</a>";
                $str_html.=" | <a href='role_add.php?id={$row['id']}&name={$row['role_name']}'>添加角色</a>";
                $str_html.=" | <a href='role_action.php?action=del&id={$row['id']}'>删除角色</a>";
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
                        $str_html.=" <td><a href='role_menu.php?id={$row['id']}'>{$row_value[$j]}</a></td>";
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
        
        
        //<---End
    }
}