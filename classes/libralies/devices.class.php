<?php
namespace classes\libralies
{
    class devices{
        private $mysqldb; 
        private $res_device;
        
        public function __construct(){
            $this->mysqldb = new \classes\DB\mysql();
        }
        
        private function get_Devices($sql){
            $this->mysqldb->connect_db();
            $result = $this->mysqldb->db_getRows($sql);
            $this->mysqldb->close_db();
            return $result;
        }
        
        public function show_Devices(){
            $col_flag='';
            $str_html='';
            
            $sql = 'select * from tb_lcd1602';
            $res=$this->get_Devices($sql);
            $cols = array_keys($res);
            $str_html.='<div><table border="1"> <tr>';
            
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
               
                $str_html.=" <td><a href='devices.php?action=edit&id={$row['id']}'>编辑设备</a>";
                $str_html.=" | <a href='devices.php?action=add'>添加设备</a>";
                $str_html.=" | <a href='devices.php?action=del&id={$row['id']}'>删除设备</a>";
                $str_html.='</td>';
                $str_html.=' </tr>';
              }
            $str_html.='</table></div> ';
            return $str_html;
                
        }
        
        public function create(){           
            
            $str_device_code='';
            $str_hostname='';
            $str_localtion='';
            $str_bl_start_time='';
            $str_bl_end_time='';
            $str_bl_indicator='';
            $chk_bl_indicator='';
          
                
            if( isset($_POST['submit'])&&!empty($_POST['submit']))
            //if ($_SERVER["REQUEST_METHOD"] == "POST")
            {   
                if (!empty($_POST['str_device_code'])){
                $str_device_code = $_POST['str_device_code'];
                }
                else
                {   echo 'device code is required,please check!';
                    exit();
                }
                $str_hostname = $_POST['str_hostname'];
                $str_localtion = $_POST['str_localtion'];
                $str_bl_start_time = $_POST['str_bl_start_time'];
                $str_bl_end_time = $_POST['str_bl_end_time'];
                
                if(!empty($_POST['str_bl_indicator']))
                {
                    $str_bl_indicator = $_POST['str_bl_indicator'] ;
                }
                
                $chk_bl_indicator=empty($_POST['str_bl_indicator'] ) ? '' : 'checked="checked"';
                $this->mysqldb->connect_db();
                $sql= "call proc_lcd1602('{$str_device_code}', '{$str_hostname}', '{$str_localtion}', '{$str_bl_start_time}', '{$str_bl_end_time}', '{$str_bl_indicator}')";
                $this->mysqldb->db_storeProcedure_cud($sql);
                $this->mysqldb->close_db(); 
                unset($_POST['submit']);
                
                $chk_bl_indicator;

            }
        }

// echo <<<EOT
// <form method="post" action={$_SERVER["PHP_SELF"]}>
//     <div class="div_inline"><div>设备编号:</div><div><input type="text" name="str_device_code" id="device_code" value=get_device($this->res_device) ></div></div>
//     <div class="div_inline"><div>主机:</div><div><input type="text" name="str_hostname" value=$str_hostname></div></div>
//     <div class="div_inline"><div>地址:</div><div><input type="text" name="str_localtion" value=$str_localtion></div></div>
//     <div class="div_inline"><div>开始时间:</div><div><input type="time" name="str_bl_start_time" value=$str_bl_start_time></div></div>
//     <div class="div_inline"><div>结束时间:</div><div><input type="time" name="str_bl_end_time" value=$str_bl_end_time><div></div>
//     <div class="div_inline"><div>标识:</div><div><input type="checkbox" name="str_bl_indicator" value="1" $chk_bl_indicator'><div></div>
//     <input type="submit" name="submit" value="提交"> 
// </form>
// EOT;
//         }

        
    public function get_device($id){
        $this->mysqldb->connect_db();
        $sql="select * from tb_lcd1602 where id='{$id}';";
        $this->res_device = $this->mysqldb->db_getRow($sql);
        $this->mysqldb->close_db();
        //echo "$('#device_code').value('xxx');";
        return $this->res_device;
        
    }
     
    public function update($id){
        $str_device_code='';
        $str_hostname='';
        $str_localtion='';
        $str_bl_start_time='';
        $str_bl_end_time='';
        $str_bl_indicator='';
        $chk_bl_indicator='';
        
        if (!empty($_POST['str_device_code'])){
            $str_device_code = $_POST['str_device_code'];
        }
        else
        {   echo 'device code is required,please check!';
        exit();
        }
        $str_hostname = $_POST['str_hostname'];
        $str_localtion = $_POST['str_localtion'];
        $str_bl_start_time = $_POST['str_bl_start_time'];
        $str_bl_end_time = $_POST['str_bl_end_time'];
             
        $chk_bl_indicator = isset($_POST['str_bl_indicator'])?isset($_POST['str_bl_indicator']):'';
        
        if ($chk_bl_indicator<>'')
        {
            $chk_bl_indicator='1';
        }
        
        $this->mysqldb->connect_db();
        $sql="update tb_lcd1602 set 
                device_code ='{$str_device_code}',
                hostname = '{$str_hostname}', 
                localtion = '{$str_localtion}', 
                bl_start_time = '{$str_bl_start_time}', 
                bl_end_time = '{$str_bl_end_time}', 
                bl_indicator = '{$chk_bl_indicator}'
              where id = '{$id}'";
        
        echo $sql;
        $action_flag = $this->mysqldb->db_update($sql);
        $this->mysqldb->close_db();
        return $action_flag;
    }
    
    public function delete($id)
    {
        $this->mysqldb->connect_db();
        $sql = "delete from tb_lcd1602 where id = {$id}";
        $action_flag = $this->mysqldb->db_delete($sql);
        $this->mysqldb->close_db();
        return $action_flag;
    }
    
 
//<---End        
    }
}