<?php
namespace classes\libralies
{
    class page {
        private $total;       //List Count
        private $listRows;    //Page Display Lines
        private $limit;
        private $uri;
        
        public $pageNum;
        private $pageName; 
        
       private $paging_html;
       private $goto_page;
       private $show_pages_link;
       private $show_page_start;
       private $show_page_end;
       private $first_page;
       private $last_page;
       private $next_page;
       private $end_page;
       public $page;
        
        public $mysql_helper;
           
        public function __construct($pageName, $listRows) {
            $this->mysql_helper = new \classes\DB\mysql_helper();
            
                        
           // $this->total = $total;
            
            $sql = "select count(*) from tb_temperature";   
            $this->total  = $this->mysql_helper->Count($sql);
            $this->pageName = $pageName;
           
            
            $this->listRows = $listRows;
            $this->uri = $this->get_uri();
            $this->page=!empty($_GET["page"]) ? $_GET["page"] : 1;    
            $this->pageNum = ceil($this->total/$this->listRows);
           
            $this->limit = $this->set_limit();
            //var_dump($this);
        }
              
        public function __get($args) {
            if($args=="limit"){
                return $this->limit;
            }else
            {
                return null;
            }
        }
        
        private function get_uri(){
            $url = $_SERVER["REQUEST_URI"].(strpos($_SERVER["REQUEST_URI"],'?')?'':"?");
            $parse = parse_url($url);
            
            if(isset($parse["query"])){
                parse_str($parse["query"],$params);
                unset($params["page"]);
                $url=$parse["path"].'?'.http_build_query($params);
            }
            
            return $url;
            
        }
        
        private function set_limit() {
            return "Limit ".($this->page-1)*$this->listRows.",{$this->listRows}"; 
        }
        
        private  function get_current_page($curr_page){
            if ($curr_page < 1){
                $curr_page = 1;
            }
            
            if ($curr_page > $this->pageNum)
            {
                $curr_page  = $this->pageNum;
            }
            return $curr_page;
        }
        
        function fpage($show_pages=10){      
            $this->show_pages = $this->page + $show_pages;
            
            $this->first_page = "<a href=$this->pageName?page=1>首页</a>&nbsp";
            $this->end_page = "&nbsp<a href=$this->pageName?page=".$this->pageNum.">尾页</a>";
            $this->last_page = "&nbsp<a href=$this->pageName?page=".($this->get_current_page($this->page-1)).">上一页</a>&nbsp";
            $this->next_page = "&nbsp<a href=$this->pageName?page=".($this->get_current_page($this->page+1)).">下一页</a>&nbsp";
            
            if ($this->show_pages < $this->pageNum ){
                for($i=$this->page;$i<=$this->show_pages;$i++){
                    $this->show_pages_link.="&nbsp<a href=$this->pageName?page=".$i.">{$i}</a>&nbsp";
                }
            }else{
                for($i=$this->pageNum-10;$i<=$this->pageNum;$i++){
                    $this->show_pages_link.="&nbsp<a href=$this->pageName?page=".$i.">{$i}</a>&nbsp";
                }
            }
            
            $this->goto_page = "<input type=text id='input_goto_page' value={$this->page} size='4' />&nbsp<button onclick='onGoToPage({$this->pageNum})'>跳转</button>&nbsp";
            $this->paging_html= $this->goto_page.$this->first_page.$this->last_page.$this->show_pages_link.$this->next_page.$this->end_page;
            
            
            return $this->paging_html;
        }
        
        public function build_table($res){
            $col_flag='';
            $str_html='';
            $link_index = '';
            $cols = array_keys($res);
                  
            $str_html.='<div><table border="1"> <tr>';
            
            $col_count="";
            
            foreach($res as $row) {
                if ($col_flag <> 'X')
                {
                    $cols = array_keys($row);
                    $col_count = sizeof ( $cols );
                    for($i=0; $i < sizeof ( $cols ); $i++)
                    {
                        if ( $cols[$i] == "menu_name" ){
                            $link_index = $i;
                        }
                        
                        $str_html.=' <th>'.$cols[$i].'</th>';
                    }
                    //$str_html.=' <th>操作</th>';
                    
                    $col_flag = 'X';
                }
                
                $row_value = array_values($row);
                $str_html.=' <tr>';
                for($j=0; $j < sizeof ( $row_value ); $j++)
                {
                        $str_html.=' <td>'.$row_value[$j].'</td>';
                    
                }
//                 $str_html.=" <td><a href='menu_add.php?pid={$row['id']}&name={$row['menu_name']}&path={$row['path']}{$row['id']},'>添加子类</a>";
//                 $str_html.=" | <a href='menu_action.php?action=del&id={$row['id']}'>删除子类</a>";
//                 $str_html.='</td>';
                
                $str_html.=' </tr>';
            }
            $str_html.="<tr><td colspan='{$col_count}' align='center'>".$this->fpage()."</td></tr>";
            $str_html.='</table></div> ';
            return $str_html;
            
        }
         
        //<---End
    }
}