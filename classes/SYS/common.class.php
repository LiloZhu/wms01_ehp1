<?php
namespace classes\SYS
{
    class common{
        
        public static function ConfigValue($key){
            switch($key){
                case "session_lifetime":
                    return "3600";
                    break;
                case "todo":
                    return "";
                    break;
                case "":
                    return "";
                    break;
            }
        }
        
       
        public static function getIP(){
            static $ip = '';
            $ip = $_SERVER['REMOTE_ADDR'];  
            if(isset($_SERVER['HTTP_CDN_SRC_IP'])) {
                $ip = $_SERVER['HTTP_CDN_SRC_IP'];
            } elseif (isset($_SERVER['HTTP_CLIENT_IP']) && preg_match('/^([0-9]{1,3}\.){3}[0-9]{1,3}$/', $_SERVER['HTTP_CLIENT_IP'])) {
                $ip = $_SERVER['HTTP_CLIENT_IP'];
            } elseif(isset($_SERVER['HTTP_X_FORWARDED_FOR']) AND preg_match_all('#\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3}#s', $_SERVER['HTTP_X_FORWARDED_FOR'], $matches)) {
                foreach ($matches[0] AS $xip) {
                    if (!preg_match('#^(10|172\.16|192\.168)\.#', $xip)) {
                        $ip = $xip;
                        break;
                    }
                }
            }
            return $ip;
        }
        
        /*
         ip定位
         @param string $ip
         @return array
         @throws Exception
         */
        public static function locationByIP($ip)
        {
            if ($ip == ''|| $ip == null){
                $res = file_get_contents('https://www.iplocate.io/api/lookup/'.$_SERVER['REMOTE_ADDR']);
            }else{
                $res = file_get_contents('https://www.iplocate.io/api/lookup/'.$ip);
            }
            
            $res = json_decode($res);
            return $res->city;
            
        }
        
  
        /**
         ** [http 调用接口函数]
         ** @param  string       $url     [接口地址]
         ** @param  array        $params  [数组]
         ** @param  string       $method  [GET\POST\DELETE\PUT]
         ** @param  array        $header  [HTTP头信息]
         ** @param  integer      $timeout [超时时间]
         ** @return [type]                [接口返回数据]
         */
        function httpCURL($url, $params, $method = 'GET', $header = array(), $timeout = 5)
        {
            // POST 提交方式的传入 $set_params 必须是字符串形式
            $opts = array(
                CURLOPT_TIMEOUT => $timeout,
                CURLOPT_RETURNTRANSFER => 1,
                CURLOPT_SSL_VERIFYPEER => false,
                CURLOPT_SSL_VERIFYHOST => false,
                CURLOPT_HTTPHEADER => $header
            );
            
            /* 根据请求类型设置特定参数 */
            switch (strtoupper($method)) {
                case 'GET':
                    $opts[CURLOPT_URL] = $url . '?' . http_build_query($params);
                    break;
                case 'POST':
                    $params = http_build_query($params);
                    $opts[CURLOPT_URL] = $url;
                    $opts[CURLOPT_POST] = 1;
                    $opts[CURLOPT_POSTFIELDS] = $params;
                    break;
                case 'DELETE':
                    $opts[CURLOPT_URL] = $url;
                    $opts[CURLOPT_HTTPHEADER] = array("X-HTTP-Method-Override: DELETE");
                    $opts[CURLOPT_CUSTOMREQUEST] = 'DELETE';
                    $opts[CURLOPT_POSTFIELDS] = $params;
                    break;
                case 'PUT':
                    $opts[CURLOPT_URL] = $url;
                    $opts[CURLOPT_POST] = 0;
                    $opts[CURLOPT_CUSTOMREQUEST] = 'PUT';
                    $opts[CURLOPT_POSTFIELDS] = $params;
                    break;
                default:
                    throw new \Exception('不支持的请求方式！');
            }
            
            /* 初始化并执行curl请求 */
            $ch = curl_init();
            curl_setopt_array($ch, $opts);
            $data = curl_exec($ch);
            $error = curl_error($ch);
            return $data;
        }
        
        
    //<---End    
    }  
}