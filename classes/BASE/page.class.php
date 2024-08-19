<?php
namespace classes\BASE
{
    class page{

        private $total;       //List Count
        private $listRows;    //Page Display Lines
        private $limit;
        private $uri;
        
        public $pageNum;
        private $pageName;
        
        private $totalRecoreds;
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
        
        private $ado;
        
        public function __construct(){
            $this->ado = new \classes\DB\mysql_helper();
        }
        
        public function setPage($pageName, $listRows, $sql) {
            
            // $this->total = $total;
            
            $this->total  = $this->ado->Count($sql);
            $this->pageName = $pageName;
            
            
            $this->listRows = $listRows;
            $this->uri = $this->get_uri();
            $this->page=!empty($_GET["page"]) ? $_GET["page"] : 1;
            $this->pageNum = ceil($this->total/$this->listRows);
            
            $this->limit = $this->set_limit();
            return $this->limit;
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
                for($i=($this->pageNum < 10 ? 1 : $this->pageNum - 10);$i<=$this->pageNum;$i++){
                    $this->show_pages_link.="&nbsp<a href=$this->pageName?page=".$i.">{$i}</a>&nbsp";
                }
            }
            
            $this->totalRecoreds = "总记录:[ {$this->total} ]&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp";
            $this->goto_page = "<input type='text' id='input_goto_page' value='{$this->page}' size='2'/>&nbsp<button class='btn btn-outline-secondary btn-sm' onclick='onGoToPage(\"{$this->pageName}\",{$this->pageNum})'>跳转</button>&nbsp";
            $this->paging_html= $this->totalRecoreds.$this->goto_page.$this->first_page.$this->last_page.$this->show_pages_link.$this->next_page.$this->end_page;
            
            
            return $this->paging_html;
        }
        
        
        
        /*
           Parameter Name: $_arrar_toolbar
           Parameter Type: Array()
           
            $_array_toolbar = [
                              "TITLE" =>"标题",
                "BUTTON" => [
                              "NEW" => ["ID" => "btn_new",
                                        "NAME" => "新增",
                                        "DATA-TARGET" =>"#xxxx",
                                        "CLASS" => "btn top btn-primary",
                                        "ICON" => "glyphicon glyphicon-plus",
                                        ],
                             "EDIT" => ["ID" => "btn_edit",
                                        "NAME" => "编辑",
                                        "DATA-TARGET" =>"#xxxx",
                                        "CLASS" => "btn btn-success",
                                        "ICON" => "glyphicon glyphicon-edit",
                                       ],
                            "DELETE" => ["ID" => "btn_delete",
                                         "NAME" => "删除",
                                         "DATA-TARGET" =>"#xxxx",
                                         "CLASS" => "btn btn-danger",
                                         "ICON" => "glyphicon glyphicon-remove",
                                        ],
                           "REFRESH" => ["ID" => "btn_refresh",
                                         "NAME" => "刷新",
                                         "DATA-TARGET" =>"#xxxx",
                                         "CLASS" => "btn btn-warning",
                                         "ICON" => "glyphicon glyphicon-refresh",
                                        ],
                            "EXPORT" => ["ID" => "btn_export",
                                         "NAME" => "导出",
                                         "DATA-TARGET" =>"#xxxx",
                                         "CLASS" => "btn btn-info",
                                         "ICON" => "glyphicon glyphicon-export"
                                        ]
                            ]
                        ];        
             
          
          */
        
        public function build_action_toolbar($_array_toolbar)
        {   
            $_html = "";
            $_button = $_array_toolbar["BUTTON"]; 
            
            $_html .= " <nav class='navbar navbar-default' role='navigation'>";
            $_html .= " <div class='container-fluid' style='height:36px'>";
            $_html .= " <div class='navbar-header'>";
            $_html .= " <a class='navbar-brand' href='#'>{$_array_toolbar['TITLE']}</a>";
            $_html .= " </div>";
            $_html .= " <form class='navbar-form navbar-right'>";
            
            foreach ( $_button  as & $value ) { 
                
                $_html .= " <button type='button' class='{$value['CLASS']}' data-toggle='modal' id='{$value['ID']}' data-target='{$value['DATA-TARGET']}'>";
                $_html .= " <span class='{$value['ICON']}'></span>{$value['NAME']}";
                $_html .= " </button>";
            }
            
            $_html .= " </form>";
            $_html .= " </div>";
            $_html .= " </nav>";  
          //  $_html .= " <br>";  
            return $_html;
        }

        
        /* 构造模态框 

            $_array_toolbar = [
                              "TITLE" =>"标题",
                "BUTTON" => [
                              "NEW" => ["ID" => "btn_new", 
                                        "NAME" => "新增",
                                        "DATA-TARGET" =>"#myModal",
                                        "CLASS" => "btn top btn-primary",
                                        "ICON" => "glyphicon glyphicon-plus",
                                        ],
                             "EDIT" => ["ID" => "btn_edit",
                                        "NAME" => "编辑",
                                        "DATA-TARGET" =>"#xxxx",
                                        "CLASS" => "btn btn-success",
                                        "ICON" => "glyphicon glyphicon-edit",
                                       ],
                            "DELETE" => ["ID" => "btn_delete",
                                         "NAME" => "删除",
                                         "DATA-TARGET" =>"#xxxx",
                                         "CLASS" => "btn btn-danger",
                                         "ICON" => "glyphicon glyphicon-remove",
                                        ],
                           "REFRESH" => ["ID" => "btn_refresh",
                                         "NAME" => "刷新",
                                         "DATA-TARGET" =>"#xxxx",
                                         "CLASS" => "btn btn-warning",
                                         "ICON" => "glyphicon glyphicon-refresh",
                                        ],
                            "EXPORT" => ["ID" => "btn_export",
                                         "NAME" => "导出",
                                         "DATA-TARGET" =>"#xxxx",
                                         "CLASS" => "btn btn-info",
                                         "ICON" => "glyphicon glyphicon-export"
                                        ]
                            ]
                        ];

 
        */
        
        
        public function build_modal($_array_modal){
            $_html = "";
            $_footer_buttton = $_array_modal["FOOTER"]["BUTTON"]; 
            
            $_html .= " <div class='modal fade' id='{$_array_modal['ID']}' tabindex='-1' role='dialog' aria-labelledby='{$_array_modal['ID']}Label' data-backdrop='static' aria-hidden='true'>";
            $_html .= " <div class='modal-dialog modal-lg'>";
            $_html .= " <div class='modal-content'>";
            /*header*/
            $_html .= " <div class='modal-header'>";
            $_html .= " <h4 class='modal-title' id='{$_array_modal['ID']}Label'>";
            $_html .= " {$_array_modal['HEADER']['TITLE']}";
            $_html .= " </h4>";
            $_html .= " <button type='button' class='close' data-dismiss='modal'>&times;";
            $_html .= " </button>";
            $_html .= " </div>";
            /*body*/
            $_html .= " <div class='modal-body'>";
            //print_r($_array_modal['BODY'][0]);
            $_html .= " {$_array_modal['BODY'][0]}";
            $_html .= " </div>";
            /*footter*/
            $_html .= " <div class='modal-footer'>";
            foreach ( $_footer_buttton  as & $value ) { 
                $_html .= " <button type='button' id='{$value['ID']}' class='{$value['CLASS']}' {$value['ENHANCEMENT']}>{$value['NAME']}";
                $_html .= "</button>";
            }
            
            $_html .= " </div>";
            $_html .= " </div>";
            $_html .= " </div>";
            $_html .= " </div>";
            return $_html;
        }

        //<-End
        
        
        /* Table   
        
        
        
        
        */
        public function build_table($_array_table){
            $_html = "";
            
            $_col_keys ="";
            $col_count="";
            $_cols = isset($_array_table["COLS"]) ? $_array_table["COLS"] :"" ;
            $_rows = isset($_array_table["ROWS"]) ? $_array_table["ROWS"][0] :"" ;
            $_hidden_cols = isset($_array_table["HIDDEN_COLS"]) ? $_array_table["HIDDEN_COLS"] :array() ;
            
            //print_r($_hidden_cols);
            if ($_rows == ""){
                
            }
            if ($_cols <> ""){     
                $_col_keys = array_keys($_cols[0]);
                $col_count = sizeof ( $_col_keys );
            }
            //print_r($_col_keys);
                
            
            $_html .= "<div class='table table-bordered table-sm' border='1' style='width:99.8%;'>";
            if ($_array_table['TABLE']['TITLE_ENABLE'] == true)
            {
                $_html .= "<head><caption>{$_array_table['TABLE']['TITLE']}</caption></head>";
            }
            $_html .= "<table id='{$_array_table['TABLE']['ID']}' class='{$_array_table['TABLE']['CLASS']}'>";
            
            //---Table Header---
            $_html .= "<thead style='height:10px'>";
            $_html .= "<tr>";
            if (isset($_array_table["ACTION"]["CHECKBOX"]) ? $_array_table["ACTION"]["CHECKBOX"] :"" == true)
            {
                $col_count = $col_count + 1;
                $_html.= "<th style='width:70px;'><input id='selectAll' type='checkbox' >{$_array_table["ACTION"]["CHECKBOX"]["NAME"]}</th>";
            }
            foreach ( $_col_keys as & $key ) {
                //print_r($_cols[0][$key]);
                $_array = "";
                
                $sql = "select * from tb_dict where type_code = 'TABLE' and where_use = '{$_array_table['TABLE']['TABLE_NAME']}' and field_name = '{$_cols[0][$key]}' and language_code = 'ZH'";
                $_array = $this->ado->Retrieve_OneRow($sql);
                
                //---Hidden Cols---
                if(in_array($_cols[0][$key],$_hidden_cols)){
                    $_html .="<th style='display:none;'>";
                }
                else{
                    $_html .="<th>";
                }

                
                if ($_array <> false)
                {
                    $_html .= "{$_array["field_text"]}"; 
                }
                else{
                    $_html .= "{$_cols[0][$key]}"; 
                }
                
                $_html .= "</th>";
            }
            $_html .= "</tr>";
            $_html .= "</thead>";
            
            //---Table Body---
            if (isset($_array_table["TBODY"]["ID"]) ? $_array_table["TBODY"]["ID"] :"" <> ""){
                $_html .= "<tbody id='{$_array_table["TBODY"]["ID"]}'>";
            }
            else{         
                $_html .= "<tbody>";
            }
            
            foreach ( $_rows as & $value ) {
                //print_r($_array_table["KEYS"][0]);
               
                $_html .= "<tr>";
                //Action -> Checkbox 名称
                if (isset($_array_table["ACTION"]["CHECKBOX"]) ? $_array_table["ACTION"]["CHECKBOX"] :"" == true)
                {   
                    //print_r($value[$_cols[0][1]]);
                    //$_html.="<td><input type='checkbox'  role='checkbox_row' name='chk_row[]' value='{$value[$_cols[0][0]]}^{$value[$_cols[0][1]]}'  class='cbox checkbox'></td>";
                    $_html .= "<td>";
                    $_html.="<input type='checkbox' name='chk_row[]' value='{$value[$_cols[0][0]]}'  class='cbox checkbox'>";
                    $_html .= "</td>";
                }
                
                foreach($_col_keys as & $key ) {
                    //---Hidden Cols---
                    //if(in_array($key,$_hidden_cols)){
                    if(in_array($_cols[0][$key],$_hidden_cols)){
                        $_html .="<td style='display:none;'>";
                    }
                    else{
                        $_html .= "<td>";
                    }
                    
                    $_html .= "{$value[$_cols[0][$key]]}";
                    $_html .= "</td>";
                }  
                $_html .= " </tr>";
            }
            $_html.="<tr><td class='footer' colspan='{$col_count}' >".$this->fpage()."</td></tr>";
            $_html.='</table></div> ';
            
            $_html .= " </tbody>";
            
            $_html .= " </table>";
            $_html .= " </div>";
            
            return $_html;
        }
        
        //<-End
        
        
        
        
        
        //<---Class End
    }
    
}