<?php
namespace classes\libralies
{
    class user_action{
        private $mysqldb;
        
        public function __construct(){
            $this->mysqldb = new \classes\DB\mysql();
        }
        
     
        public function create($user_name, $user_pwd, $email,$safe_question,$safe_answer,$sex){
            $this->mysqldb->connect_db();
            $reg_time = date( "Y-m-d H:i:s" ); 
            $user_pwd = md5($user_pwd);
            
            $sql ="insert into tb_user
                    values(
                        null,
                       '{$user_name}',
                       '{$user_pwd}',
                       '{$email}',
                       '{$safe_question}',
                       '{$safe_answer}',
                       '{$reg_time}',
                       '{$sex}'
                        )";
            $action_flag = $this->mysqldb->db_insert($sql);
            //print_r($_POST);
            $this->mysqldb->close_db();
            return $action_flag;
        }
        
        public function update($id, $user_name, $user_pwd, $email,$safe_question,$safe_answer,$sex){
            $sql = "select * from tb_user where id = '{$id}'";
            $res = $this->retrieve_row($sql);
            
            $this->mysqldb->connect_db();
            //$reg_time = date( "Y-m-d H:i:s" );
            
            if ($user_pwd<>$res['user_pwd']){
                $user_pwd = md5($user_pwd);
            }
 
            $sql ="update tb_user set
                       user_name = '{$user_name}',
                       user_pwd = '{$user_pwd}',
                       email = '{$email}',
                       safe_question = '{$safe_question}',
                       safe_answer = '{$safe_answer}',
                       sex = '{$sex}'
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
            $sql = "delete from tb_user where id = {$id} ";
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
            $str_html.='<div><table class="table table-bordered"><tr><caption>浏览用户信息</caption>';
            
            foreach($res as $row) {
                if ($col_flag <> 'X')
                {
                    $cols = array_keys($row);
                    for($i=0; $i < sizeof ( $cols ); $i++)
                    {
                        if ( $cols[$i] == "user_name" ){
                            $link_index = $i;
                        }
                        
                        if ( $cols[$i] <> "user_pwd" ){
                          $str_html.=' <th>'.$cols[$i].'</th>';
                        }else{
                            $skip_index = $i;
                        }
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
                        $str_html.=" <td><a href='user_disp.php?id={$row['id']}'>{$row_value[$j]}</a></td>";
                    }else{
                        if ( $skip_index <> $j){
                        $str_html.=' <td>'.$row_value[$j].'</td>';
                        }
                    }
                    
                }
                $str_html.=" <td><a href='user_edit.php?id={$row['id']}'>编辑用户</a>";
                $str_html.=" | <a href='user_add.php?id={$row['id']}'>添加用户</a>";
                $str_html.=" | <a href='user_role.php?id={$row['id']}'>用户角色</a>";
                $str_html.=" | <a href='user_action.php?action=del&id={$row['id']}'>删除用户</a>";
                $str_html.='</td>';
                $str_html.=' </tr>';
            }
            $str_html.='</table></div> ';
            return $str_html;
            
        }
        
        
        //End <---
    }
}

        