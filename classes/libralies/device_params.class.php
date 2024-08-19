<?php
namespace classes\libralies
{
    class device_params{
        private $mysql_helper;
        private $html_helper;
        
        public function __construct(){
            $this->mysql_helper = new \classes\DB\mysql_helper();
        }
        
        public function create($id){
            $key='';
            $value='';
            
            if (!empty($_POST['key'])){
                $key = $_POST['key'];
            }else{
                echo 'device attribute name is required,please check!';
                exit();
            }
            
            $value = $_POST['value'];
            $sql = "insert into tb_device_params values('{$id}','{$key}','{$value}');";
            $action_flag = $this->mysql_helper->Create($sql);
            echo $sql;
            return $action_flag;   
        }
        
        
        public function update($id){
            $key='';
            $value='';
            
            if (!empty($_POST['key'])){
                $key = $_POST['key'];
            }else{
                echo 'device attribute name is required,please check!';
                exit();
            }
            
            $value = $_POST['value'];
            $sql = "update tb_device_params set `value` = '{$value}' where `id` = '{$id}' and `key` = '{$key}' "; 
            $action_flag = $this->mysql_helper->Update($sql);
            echo $sql;
            return $action_flag;   
        }
        
        public function get_device_params($id){
            $sql = "select * from tb_device_params where id = '{$id}';";
            $res = $this->mysql_helper->Retrieve($sql);
            return $res;
        }
        
        public function get_device($id){
            $sql = "select * from tb_device where id = '{$id}';";
            $res = $this->mysql_helper->Retrieve_OneRow($sql);
            return $res;
        }
        
        public function get_device_param_value($id,$key){
            //$sql = "select * from tb_device_params where `id` = '{$id}' and `key` = '{$key}';";
            $sql = '';
            $sql = " SELECT a.id, a.device_code, a.device_text,b.key,b.value ";
            $sql .= "FROM tb_device a ";
            $sql .= "left join tb_device_params b ";
            $sql .= "on a.id = b.id ";
            $sql .= "where a.id = '{$id}' ";
            $sql .= "and b.key = '{$key}' ";
            
            $res = $this->mysql_helper->Retrieve_OneRow($sql);
            return $res;
        }
        
        public function delete_device_param($id,$key){
            $sql = "delete from tb_device_params where id = '{$id}' and `key` = '{$key}' ;";
            $res = $this->mysql_helper->Delete($sql);
            return $res;
        }
        
        public function build_table($res){
            $title = '设备参数定义';
            $html = $this->html_helper->build_table($res, $title);
            return $html;
        }
        
        public function build_table_with_action($res){
            $title = '设备参数定义';
            $action_html ='';
            
            $action_html.=" <td><a href='device_params_edit.php?action=edit&id=@id&key=@key'>编辑参数</a>";
            $action_html.=" | <a href='device_params_edit.php?action=add&id=@id'>添加参数</a>";
            $action_html.=" | <a href='device_params_edit.php?action=del&id=@id&key=@key'>删除参数</a>";
            $action_html.=" | <a href='device.php'>返回</a>";
            $action_html.='</td>';
            $html = $this->html_helper->build_table_with_action($res, $title, $action_html);
            return $html;
        }
        
        //<---End
    }
}
