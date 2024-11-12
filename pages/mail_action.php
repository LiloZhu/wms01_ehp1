<?php
/* ------ 使用时注意所有局域网内是否有防火墙和端品关闭的问题 ------  */

//set html charset utf-8
//header("Content-Type: text/plain;charset=utf-8"); 
header('Access-Control-Allow-Origin:*');
header('Access-Control-Allow-Methods:POST,GET');
header('Access-Control-Allow-Credentials:true');
header("Content-Type: application/json;charset=utf-8");
//header("Content-Type: text/xml;charset=utf-8"); 
//header("Content-Type: text/html;charset=utf-8"); 
//header("Content-Type: application/javascript;charset=utf-8");


require("../classes/DB/pdo_helper.class.php");
require("../components/mail/PHPMailer/mail.class.php");

$mail = new mail();
$DB = new pdo_helper();


function autoload ($class_name){
    $class_file = '../'.str_replace('\\','/',$class_name). '.class.php';
    if (file_exists($class_file))
    {
        require_once($class_file);
        
        if(class_exists($class_name,false))
        {
            return true;
        }
        return false;
    }
    return false;
    
}

if(function_exists('spl_autoload_register')) {
    spl_autoload_register('autoload');
}


new classes\SYS\session_mysql();

$arrResult = array();
$data=array();
$action_flag="";
$uid = isset($_SESSION['uid'])?$_SESSION['uid']:'';
$user_code = isset($_SESSION['user_code'])?$_SESSION['user_code']:'';
$user_text = isset($_SESSION['user_text'])?$_SESSION['user_text']:'';
$company_code = isset($_SESSION['company_code'])?$_SESSION['company_code']:'';


if ($_SERVER["REQUEST_METHOD"] == "GET") {
    
    
} elseif ($_SERVER["REQUEST_METHOD"] == "POST"){
    $data = $_POST['arguments'];
    $_crrentPage = isset($data['currentPage'])?$data['currentPage']:0;
    $dt = date( "Y.m.d H:i:s" );  //PHP
    //$dt = "date_format(now(),'%Y.%m.%d %H:%i:%s')";  //MySQL
    
    switch($_POST['action']) {
        case 'retrieve':
            $sql = "";
            $sql = "";
            
            $arrResult['rows'] = $ado->Retrieve($sql);
            $arrResult['total'] = count($arrResult['rows']);
            $arrResult['totalNotFiltered'] = 100;
            break;
        case 'add':
            $sql = "";
            
            $action_flag = $ado->Create($sql);
            
            if ($action_flag > 0){
                $arrResult['success']= true;
                $arrResult['message']= $data['order_number'];
            }
            break;
        case 'edit':
            $sql = "";
            $action_flag = $ado->Delete($sql);
            if ($action_flag > 0){
                $arrResult['success']= true;
                $arrResult['message']= $data['order_number'];
            }
            break;
        case 'delete':
            $sql = "";
            $action_flag = $ado->Update($sql);
            if ($action_flag > 0){
                $arrResult['success']= true;
                $arrResult['message']= $data['order_number'];
            }
            break;
        case 'delivery_order_qc_approve':
            $sql = "select * from tb_html_css";
            
            $css = array();
            $css = $DB->retrieve($sql);
            $body = "";
            $body_ext="";
            
            foreach ($css as $css_value) {
                $body .= $css_value['css_text'] ;
            }
            
            $status_text = '';
            if ($data['status_code'] == 'REL'){
                $status_text = "<div style='color: green;'>批准</div>";
            }else{
                $status_text = "<div style='color: red;'>拒绝</div>";
            }
            
            $subject_text = 'QC质检-交货单号:[ '.$data['order_number'].' ] - 审批人：[ '.$user_text.' ]';
            
            
            $sql = "select * from v_delivery_order_text_ext where order_number = '{$data['order_number']}' and item_no = '{$data['item_no']}' ";
            $data = array();
            $data = $DB->retrieve($sql);
            
            
            
            $body_ext .="<table class='gridtable'>";
            //$body_ext .="<table border='1'>";
            $body_ext .="<th>交货单号</th>
                         <th>行项目</th>
                         <th>公司</th>
                         <th>仓库</th>
                         <th>物料编号</th>
                         <th>客户物料编号</th>
                         <th>物料名称</th>
                         <th>标签数量</th>
                         <th>数量</th>
                         <th>包装规格</th>
                         <th>状态</th><tr>                                                    
                         ";
            foreach ($data as $value) {
                $body_ext .= "<td>".$value['order_number']."</td>";
                $body_ext .= "<td>".$value['item_no']."</td>";
                $body_ext .= "<td>".$value['company_text']."</td>";
                $body_ext .= "<td>".$value['location_text']."</td>";
                $body_ext .= "<td>".$value['mat_code']."</td>";
                $body_ext .= "<td>".$value['cust_mat_code']."</td>";
                $body_ext .= "<td>".$value['mat_text']."</td>";
                $body_ext .= "<td>".$value['label_qty']."</td>";
                $body_ext .= "<td>".$value['qty']."</td>";
                $body_ext .= "<td>".$value['packing_unit_qty']."</td>";
                $body_ext .= "<td>".$status_text."</td>";
                $body_ext .='<tr>';
            }
            
            
            $body_ext .="</table>";
            
            
            $body .= $body_ext;
            
            $mail->setMailFrom('lilo.zhu@msn.com', 'admin');
            $mail->addMailTo('linf_ao@126.com', 'QC');
            $mail->isHTML(true);
            $mail->setSubject($subject_text);
            $mail->setBody($body);
            $mail->sendMail();
            
            
        case 'reject':
            $sql = "";
            $sql = "call proc_delivery_order_release('{$data['order_number']}','{$data['status_code']}','{$uid}');";
            
            $action_flag = $ado->update($sql);
            
            if ($action_flag > 0){
                $arrResult['success']= true;
                $arrResult['message']= $data['$order_number'];
            }
            break;
        default:
            
    }
}

//<---

echo json_encode($arrResult);
//<---End
?>