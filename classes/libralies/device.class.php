<?php
namespace classes\libralies
{
    class device{
        private $mysqldb;
        
        public function __construct(){
            $this->mysqldb = new \classes\DB\mysql();
        }
        
        
        public function get_devices($sql){
            $this->mysqldb->connect_db();
            $result = $this->mysqldb->db_getRows($sql);
            $this->mysqldb->close_db();
            return $result;
        }
        
        public function get_device($id){
            $this->mysqldb->connect_db();
            $sql="select * from tb_device where id='{$id}';";
            $this->res = $this->mysqldb->db_getRow($sql);
            $this->mysqldb->close_db();
            //echo "$('#device_code').value('xxx');";
            return $this->res;
            
        }
        
        public function get_device_params($id){
            $this->mysqldb->connect_db();
            $sql="select * from tb_device_params where id='{$id}';";
            $this->res = $this->mysqldb->db_getRow($sql);
            $this->mysqldb->close_db();
            //echo "$('#device_code').value('xxx');";
            return $this->res;
            
        }
        
        public function create(){
            $device_code = '';
            $device_text = '';
            
            if (!empty($_POST['device_code'])){
                $device_code = $_POST['device_code'];
            }else{
                echo 'device code is required,please check!';
                exit();
            }
            
            $device_text = $_POST['device_text'];
            
            $this->mysqldb->connect_db();
            $sql = "insert into tb_device values(null,'{$device_code}','{$device_text}');";
            $action_flag = $this->mysqldb->db_insert($sql);
            $this->mysqldb->close_db();
            return $action_flag;   
        }
        
        public function update($id){
            $device_code='';
            $device_text='';
            
            if (!empty($_POST['device_code'])){
                $device_code = $_POST['device_code'];
            }
            else
            {   echo 'device code is required,please check!';
            exit();
            }
            $device_text = $_POST['device_text'];
            
            $this->mysqldb->connect_db();
            $sql="update tb_device set
                device_code = '{$device_code}',
                device_text = '{$device_text}'
              where id = '{$id}'";
            
            $action_flag = $this->mysqldb->db_update($sql);
            $this->mysqldb->close_db();
        }
        
        public function delete($id)
        {
            $this->mysqldb->connect_db();
            $sql = "delete from tb_device where id = {$id}";
            $action_flag = $this->mysqldb->db_delete($sql);
            $this->mysqldb->close_db();
            return $action_flag;
        }
        
        public function get_url($id){
            $url="| <a href='device_params_edit.php?action=add&id={$id}'>控制参数</a>";
            $res_device = $this->get_device_params($id);
            if ($res_device){
                $url = "| <a href='device_params.php?action=display&id={$id}'>控制参数</a>";
            }
            return $url;
        }
        
        public function build_table($res){
            $col_flag = '';
            $str_html = '';
            $url = '';
            $id = '';
            $res_device;
            
            $clos = array_keys($res);
            $str_html.='<div><table class="table table-bordered"><tr><caption>传感器信息</caption>';
            
            foreach($res as $row) {
                if ($col_flag <> 'X')
                {
                    $cols = array_keys($row);
                    for($i=0; $i < sizeof ( $cols ); $i++)
                    {
                        $str_html.=' <th>'.$cols[$i].'</th>';
                    }
                    $str_html.=' <th>action</th>';
                    $col_flag = 'X';
                }
                
                $row_value = array_values($row);
                $str_html.=' <tr>';
                for($j=0; $j < sizeof ( $row_value ); $j++)
                {
                    $str_html.=' <td>'.$row_value[$j].'</td>';
                }
                
                $id = $row['id'];
                $str_html.=" <td><a href='device_edit.php?action=edit&id={$row['id']}'>编辑设备</a>";
                $str_html.=" | <a href='device_edit.php?action=add'>添加设备</a>";
                $str_html.= $this->get_url($id);
                $str_html.=" | <a href='device_edit.php?action=del&id={$row['id']}'>删除设备</a>";
                $str_html.='</td>';
                $str_html.=' </tr>';
            }
            $str_html.='</table></div> ';
            return $str_html;
            
        }

    //<---End
    }
}