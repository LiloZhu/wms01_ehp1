<?php
/*-----------------------------------------------------------------------------------
 Class Name    : sesssionMySQL.class.php
 Author        : Wei.Zhu
 Creation Date : 2020.06.09
 Description:   Process the PHP Session In MySQL
 ------------------------------------------------------------------------------------*/
namespace classes\SYS
{
    error_reporting(0);
    error_reporting(E_ERROR);
    //error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);
    class session_mysql{
        private $mysqldb;
        private $lifetime = 1800;
        
        static $_lifetime = "session_lifetime";
        
        public function __construct(){
            $this->mysqldb = new \classes\DB\mysql();
            $this->lifetime = common::ConfigValue(self::$_lifetime);
             
            //session_module_name('user');
            //ini_set('session.save_handler', 'user');  //session文件保存方式，这个是必须的！除非在Php.ini文件中设置了
            //ini_set('session.save_handler', 'user');
            session_set_save_handler(
                array($this, 'open'), //session_start()
                array($this, 'close'), //session_write_close() 或 session_destroy()时被执行,即在所有session操作完后被执行
                array($this, 'read'), //session_start()时执行,因为在session_start时,会去read当前session数据
                array($this, 'write'), //session_write_close()强制提交SESSION数据时执行
                array($this, 'destroy'), //session_destroy()时执行
                array($this, 'gc') //session.gc_probability 和 session.gc_divisor的值决定,时机是在open,read之后,session_start会相继执行open,read和gc
                );
            session_start();
            
        }
        
        public function open(){
            return true;
        }
        
        public function close(){
            return $this->gc($this->lifetime);
        }
        
        public function Read($session_id){  
                $sql ="select session_data as d from tb_session where session_id ='{$session_id}' ;";
                $this->mysqldb->connect_db();
                $result = $this->mysqldb->db_getRow($sql);
                $this->mysqldb->close_db();   
                if ($result) {
                    $data = $result['d'];
                    return $data;
                }
                return '';
                //return serialize($result);
                //return $result;
        }
        
        public function write($session_id, $data) {
            $uid = isset($_SESSION['uid']) ? $_SESSION['uid'] : 0;
            $expire = time();
            $ip = common::getIP();
            $action_flag = 0;
            $sql ="select * from tb_session where session_id = '{$session_id}' ;";
            $this->mysqldb->connect_db();
            $count = $this->mysqldb->db_getRowCount($sql);
            if ($count === 0){
                $sql ="insert into tb_session(session_id,session_data,expire,uid,ip,create_dt,update_dt)values('{$session_id}','{$data}','{$expire}','{$uid}','{$ip}',sysdate(),sysdate()) ;";
                $action_flag = $this->mysqldb->db_insert($sql);
            }
            else{
                $sql ="update tb_session set session_data = '{$data}',expire ='{$expire}',uid ='{$uid}',ip = '{$ip}',update_dt = sysdate() where session_id ='{$session_id}';";
                $action_flag = $this->mysqldb->db_insert($sql);
            }
            $this->mysqldb->close_db();
            //->Fix Session problem for PHP 8
            //return $action_flag;
            return $action_flag ? true: false;
            //<-
        }

        public function destroy($session_id) {
            $sql="delete from tb_session where session_id = '{$session_id}' ";
            $this->mysqldb->connect_db();
            $action_flag = $this->mysqldb->db_delete($sql);
            $this->mysqldb->close_db();
            return $action_flag;
        }
              
        public function gc($lifetime) {
            $expireTime = time() - $lifetime;
            $sql="delete from tb_session where expire < '{$expireTime}' ";
            $this->mysqldb->connect_db();
            $action_flag = $this->mysqldb->db_delete($sql);
            $this->mysqldb->close_db();
            return $action_flag;
        }

    
    //<---End
    }
}