<?php
namespace classes\libralies
{
    class menu_action{
        private $mysqldb;
        
        public function __construct(){
            $this->mysqldb = new \classes\DB\mysql();
        }
        
        
        public function create($str_menu_name, $str_pid, $str_path,$str_description,$type_code,$url,$icon,$admin_flag){
            $this->mysqldb->connect_db();
/*             $sql ="insert into tb_menu (
                        `menu_name`,
                        `pid`,
                        `path`,
                        `description`)
                    values(
                       '{$str_menu_name}',
                       '{$str_pid}',
                       '{$str_path}',
                       '{$str_description}' )";*/
            
            $sql ="insert into tb_menu
                    values(
                        null,
                       '{$str_menu_name}',
                       '{$str_pid}',
                       '{$str_path}',
                       '{$str_description}',
                       '{$type_code}',
                       '{$url}',
                       '{$icon}',
                       '{$admin_flag}'
                        )";
            $action_flag = $this->mysqldb->db_insert($sql); 
            //print_r($_POST);
            $this->mysqldb->close_db();
            return $action_flag;
        }
        
        public function update($id, $menu_name,$description,$type_code,$url,$icon,$admin_flag){
            $this->mysqldb->connect_db();
            
            $sql ="update tb_menu set
                       menu_name = '{$menu_name}',
                       description = '{$description}',
                       type_code = '{$type_code}',
                       url = '{$url}',
                       icon = '{$icon}',
                       admin_flag = '{$admin_flag}'
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
            $sql = "delete from tb_menu where id = {$id} or path like '%{$id}%' ";
            $action_flag = $this->mysqldb->db_delete($sql);
            $this->mysqldb->close_db();
            return $action_flag;
        }
        
        public function build_table($res){
            $col_flag='';
            $str_html='';
            $link_index = '';
            $cols = array_keys($res);
            $str_html.='<div><table class="table table-bordered"><tr><caption>浏览菜单分类信息</caption>';
            
            foreach($res as $row) {
                if ($col_flag <> 'X')
                {
                    $cols = array_keys($row);
                    for($i=0; $i < sizeof ( $cols ); $i++)
                    {
                        if ( $cols[$i] == "menu_name" ){
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
                        $str_html.=" <td><a href='menu_level.php?pid={$row['id']}'>{$row_value[$j]}</a></td>";
                    }else{
                        $str_html.=' <td>'.$row_value[$j].'</td>';
                    }
                    
                }
                $str_html.=" <td><a href='menu_edit.php?id={$row['id']}'>编辑菜单</a>";   
                $str_html.=" | <a href='menu_add.php?pid={$row['id']}&name={$row['menu_name']}&type_code={$row['type_code']}&admin_flag={$row['admin_flag']}&path={$row['path']}{$row['id']},'>添加子类</a>";
                $str_html.=" | <a href='menu_action.php?action=del&id={$row['id']}'>删除子类</a>";
                $str_html.='</td>';
                $str_html.=' </tr>';
            }
            $str_html.='</table></div> ';
            return $str_html;
            
        }
        
        public function build_select($res){
            $col_flag='';
            $str_html='';
            $cols = array_keys($res);
            $str_html.='<div><select name="typeid"> <tr>';
            
            foreach($res as $row) {
/*                if ($col_flag <> 'X')
                {
                    $cols = array_keys($row);
                    for($i=0; $i < sizeof ( $cols ); $i++)
                    {
                        $str_html.=' <th>'.$cols[$i].'</th>';
                    }
                    $str_html.=' <th>操作</th>';
                    
                    $col_flag = 'X';
                }
*/                
                $row_value = array_values($row);
                //$str_html.=' <tr>';
                //for($j=0; $j < sizeof ( $row_value ); $j++)
                //{
                    //$str_html.=' <td>'.$row_value[$j].'</td>';
                //$str_html.='<option>'.$row_value[1].'</option>';
                $m = substr_count($row['path'], ',') - 1;
                $strpad = str_pad("",$m*3,"-");
                //$strpad = str_pad("",$m*3,"&nbsp;");
                if($row['pid'] == 0)
                {
                    $dis = "disabled";
                }
                else{
                    $dis = "";
                }
                $str_html.="<option {$dis} value='{$row['id']}'>{$strpad}{$row['menu_name']}</option>";
                //}
                //$str_html.=" <td><a href='menu_add.php?pid={$row_value[0]}&name={$row_value[1]}&path={$row_value[3]}{$row_value[0]},'>添加子类</a></td>";
                
               // $str_html.=' </tr>';
            }
            $str_html.='</select></div> ';
            return $str_html;
            
        }
        
        
        
  //<---End      
    }
}