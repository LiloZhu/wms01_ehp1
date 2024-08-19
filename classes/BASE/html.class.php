<?php
/*---
-------------------------------------------------------------
Author:        Wei.Zhu
Creation Date: 2020.08.03
Description:   Build Custom Html Tag Block
-------------------------------------------------------------
Log: (Change Records)
-------------------------------------------------------------
1. build html select
2. build html checkbox
3. 
-------------------------------------------------------------
*/

namespace classes\BASE
{
    class html{
        private $ado;
        
        public function __construct(){
            $this->ado = new \classes\DB\mysql_helper();
        }
        
        private function get_data($sql){    
            $res = $this->ado->Retrieve($sql);
            return $res;
        }
        
        //---> Select        
        public function build_html_select($_array_tag){
          
/*
// ------Sample Code ------            
            $_array_tag = [
                "TEST"  =>"Test Use...",
                "NAME"  => "",
                "DIV"   => [
                    "CLASS" => "form-inline",
                    "STYLE" => "",
                    "ENHANCEMENT" =>"",
                ],
                "LABEL" => [
                    "ID" => "lbl_sel",
                    "NAME" => "lbl_sel",
                    "FOR"  => "sel_01",
                    "CLASS" => "control-label mr-1",
                    "TEXT"  => "选择" ,
                    "ENHANCEMENT" =>"",
                ],
                "SELECT" => [
                    "ID" => "sel_01",
                    "NAME" => "sel_01",
                    "CLASS" => "form-control",
                    "SQL" => "select type_code as code, type_text as text from tb_type",
                    "ENHANCEMENT" =>"",
                ],
                "T_ENABLE" => TRUE,        //TOP Enable
                "T_CODE"  => "",
                "T_TEXT" => "--- 请选择 ---",
            ];   
            
//------Sample Code ------ 
           
*/          
            $array_tag = isset($_array_tag) ? $_array_tag :array() ;
            if (sizeof($array_tag) === 0) {
                return;
            }
            
            $res = $this->get_data($array_tag['SELECT']['SQL']);
            
            $_html = "";
            $_html .= "<div class='{$array_tag['DIV']['CLASS']}'>";
            
            $_html .= "<label for='{$array_tag['LABEL']['NAME']}' class='{$array_tag['LABEL']['CLASS']}' {$array_tag['LABEL']['ENHANCEMENT']}>{$array_tag['LABEL']['TEXT']}</label>";
            $_html .= "<select id='{$array_tag['SELECT']['ID']}' name='{$array_tag['SELECT']['NAME']}' class='{$array_tag['SELECT']['CLASS']}' {$array_tag['SELECT']['ENHANCEMENT']}>";
            
            IF ($array_tag['T_ENABLE'] == TRUE){
                $_html .= "<option value='{$array_tag['T_CODE']}'>{$array_tag['T_TEXT']}</option>";
            }
            if ($res != false){
                foreach($res as $row) {
                    $_html .= "<option value='{$row['code']}'>{$row['text']}</option>";
                }
            }
            
            $_html .= "</select>";
            $_html .= "</div>"; 
            
            return $_html;
        }
        //<--- Select 
        
        //---> Select
        public function build_html_table_search_select($_array_tag){
            
            /*
             // ------Sample Code ------
             $_array_tag = [
             "TEST"  =>"Test Use...",
             "NAME"  => "",
             "DIV"   => [
             "CLASS" => "form-inline",
             "STYLE" => "",
             "ENHANCEMENT" =>"",
             ],
             "LABEL" => [
             "ID" => "lbl_sel",
             "NAME" => "lbl_sel",
             "FOR"  => "sel_01",
             "CLASS" => "control-label mr-1",
             "TEXT"  => "选择" ,
             "ENHANCEMENT" =>"",
             ],
             "SELECT" => [
             "ID" => "sel_01",
             "NAME" => "sel_01",
             "CLASS" => "form-control",
             "SQL" => "select type_code as code, type_text as text from tb_type",
             "ENHANCEMENT" =>"",
             ],
             "T_ENABLE" => TRUE,        //TOP Enable
             "T_CODE"  => "",
             "T_TEXT" => "--- 请选择 ---",
             ];
             
             //------Sample Code ------
             
             */
            $array_tag = isset($_array_tag) ? $_array_tag :array() ;
            if (sizeof($array_tag) === 0) {
                return;
            }
            
            $res = "";
            $sql = "";
            $sql = isset($array_tag['SELECT']['SQL']) ? $array_tag['SELECT']['SQL'] : '';
            $where_use = isset($array_tag['SELECT']['WHERE_USE']) ? $array_tag['SELECT']['WHERE_USE'] : '';
            if ($sql != ""){
                $res = $this->get_data($sql);
            }
            else{
                $sql = "select search_code as code, search_text as text from tb_search where where_use = '{$where_use}' order by seq";
                $res = $this->get_data($sql);
            }
            
            $_html = "";
            $_html .= "<div class='{$array_tag['DIV']['CLASS']}'>";
            
            $_html .= "<label for='{$array_tag['LABEL']['NAME']}' class='{$array_tag['LABEL']['CLASS']}' {$array_tag['LABEL']['ENHANCEMENT']}>{$array_tag['LABEL']['TEXT']}</label>";
            $_html .= "<select id='{$array_tag['SELECT']['ID']}' name='{$array_tag['SELECT']['NAME']}' class='{$array_tag['SELECT']['CLASS']}' {$array_tag['LABEL']['ENHANCEMENT']}>";
            
            IF ($array_tag['T_ENABLE'] == TRUE){
                $_html .= "<option value='{$array_tag['T_CODE']}'>{$array_tag['T_TEXT']}</option>";
            }
            if ($res != false){
                foreach($res as $row) {
                    $_html .= "<option value='{$row['code']}'>{$row['text']}</option>";
                }
            }
            
            $_html .= "</select>";
            $_html .= "</div>";
            
            return $_html;
        }
        //<--- Select 

        //---> Checkbox
        public function build_html_checkbox($_array_tag){
// ------Sample Code ------
/*
            $_array_tag = [
                "TEST"  =>"Test Use...",
                "NAME"  => "",
                "DIV"   => [
                    "CLASS" => "form-check-inline",
                    "STYLE" => "",
                    "ENHANCEMENT" =>"",
                ],
                "LABEL" => [
                    "ID" => "chk_lbl_01",
                    "NAME" => "chk_lbl_01",
                    "FOR"  => "chk_01",
                    "CLASS" => "control-label mr-1",
                    "TEXT"  => "标识",
                    "ENHANCEMENT" =>"",
                ],
                "CHECKBOX" => [
                    "ID" => "chk_01",
                    "NAME" => "chk_01",
                    "CLASS" => "form-check-input",
                    "CHECKED" =>"checked",
                    "ENHANCEMENT" =>"",
                ]
            ];
 
*/            
//------Sample Code ------
            $array_tag = isset($_array_tag) ? $_array_tag :array() ;
            if (sizeof($array_tag) === 0) {
                return;
            }
            
            $_html = "";
            $_html .= "<div class='{$array_tag['DIV']['CLASS']}'>";
            $_html .= "<label for='{$array_tag['LABEL']['FOR']}' class='{$array_tag['LABEL']['CLASS']}' {$array_tag['LABEL']['ENHANCEMENT']}>{$array_tag['LABEL']['TEXT']}</label>";
            $_html .= "<input type='checkbox' class='{$array_tag['CHECKBOX']['CLASS']}' id='{$array_tag['CHECKBOX']['ID']}' name='{$array_tag['CHECKBOX']['NAME']}' ";
            $_html .= "{$array_tag['CHECKBOX']['CHECKED']} {$array_tag['CHECKBOX']['ENHANCEMENT']}>";
            $_html .= "</div>"; 
            
            return $_html;
        }
        
        //<--- Checkbox
        
        
        //---> Treeview
        public function build_html_treeview_checkbox($_array_tag){
// ------Sample Code ------
/*
            $_array_tag = [
                "TEST"  =>"Test Use...",
                "NAME"  => "",
                "DIV"   => [
                    "CLASS" => "form-check-inline",
                    "STYLE" => "",
                    "ENHANCEMENT" =>"",
                ],
                "CHECKBOX" => [
                    "ID" => "cb",
                    "NAME" => "cb",
                    "CLASS" => "form-check-input",
                    "CHECKED" =>"checked",
                    "ENHANCEMENT" =>"",
                ],
                "SELECT" => [
                    "ID" => "sel_01",
                    "NAME" => "sel_01",
                    "CLASS" => "form-control",
                    "SQL" => "select * from tb_menu where type_code = 'L' and admin_flag = '' order by concat(path,id);",
                    "ENHANCEMENT" =>"",
                ],
            ];
*/            
//------Sample Code ------
            $_html='';
            $lvl = 0;
            $lvl_count = 0;    //lvl count
    
            $array_tag = isset($_array_tag) ? $_array_tag :array() ;
            if (sizeof($array_tag) === 0) {
                return;
            }
            
            $res = $this->get_data($array_tag['SELECT']['SQL']);
            if($res==false){
                return;
            }
            $_html .="<ul id='tree' class='filetree' {$array_tag['ENHANCEMENT']}>";
            
            foreach($res as $row) {
                $_checkbox='';
                $_admin='';
                $_type="({$row['type_code']})";
                
                if ($array_tag["CHECKBOX_ENABLE"] == TRUE){
                  $_checkbox .= "<input type='checkbox' class='{$array_tag['CHECKBOX']['CLASS']}' id='cb{$row['id']}' name='cb{$row['id']}' ";
                  $_checkbox .= "{$array_tag['CHECKBOX']['CHECKED']} ";
                  $_checkbox .= "{$array_tag['CHECKBOX']['ENHANCEMENT']}>";
                }
                
                if ($row['admin_flag'] == TRUE || $row['admin_flag'] == 'X'){
                    $_admin="(ADM)";
                }
                
                
                if ($row['pid'] == 0){
                    if (substr_count($row['path'],",") < $lvl )
                    {
                      $lvl_count =  $lvl - substr_count($row['path'],",");
                      while($lvl_count > 0){
                            
                            $_html .= "</li>";
                            $_html .= "</ul>";
                            $lvl_count = $lvl_count - 1;
                        }
                    }
                    
                    $_html .= "<li>";
                    $_html .= $_checkbox;
                    $_html .= $row['menu_name'];
                    $_html .= $_type;
                    $_html .= $_admin;
                }else{
                    if (substr_count($row['path'],",") > $lvl ){
                        $_html .= "<ul>";
                        $_html .= "<li>";       
                        $_html .= $_checkbox;
                        $_html .= $row['menu_name'];
                        $_html .= $_type;
                        $_html .= $_admin;
                    }
                    elseif(substr_count($row['path'],",") == $lvl){
                        $_html .= "</li>";
                        $_html .= "<li>";
                        $_html .= $_checkbox;
                        $_html .= $row['menu_name'];
                        $_html .= $_type;
                        $_html .= $_admin;
                    }else{ 
                        $lvl_count =  $lvl - substr_count($row['path'],",");
                        while($lvl_count > 0){
                            
                            $_html .= "</li>";
                            $_html .= "</ul>";
                            $lvl_count = $lvl_count - 1;
                        }
                        
                        $_html .= "<li>";
                        $_html .= $_checkbox;
                        $_html .= $row['menu_name'];
                        $_html .= $_type;
                        $_html .= $_admin;
                        
                    }
                    
                }
                  
                $lvl = substr_count($row['path'],",");

            }
            
            if ($lvl = 1){
                $_html .= "</li>";
            }else{
                $lvl_count =  $lvl - 1;
                while($lvl_count > 0){
                    
                    $_html .= "</li>";
                    $_html .= "</ul>";
                    $lvl_count = $lvl_count - 1;
                }
                
            }
            
            $_html .= "</ul>";
            
            return $_html;
        }
        
        

        
        //--->Toolbar(Page)
        public function build_html_page_toolbar($_array_tag,$_title){
            
        // ------Sample Code ------
        /*
        $_array_toolbar = [
        "TITLE" => "标题",
        "BUTTON" => [
        "NEW" => ["ID" => "btn_new",
        "NAME" => "新增",
        "DATA-TARGET" =>"#modal_new",
        "CLASS" => "btn top btn-primary btn_modal",
        "ICON" => "glyphicon glyphicon-plus",
        ],
        "EDIT" => ["ID" => "btn_edit",
        "NAME" => "编辑",
        "DATA-TARGET" =>"#modal_edit",
        "CLASS" => "btn btn-success btn_modal",
        "ICON" => "glyphicon glyphicon-edit",
        ],
        "DELETE" => ["ID" => "btn_delete",
        "NAME" => "删除",
        "DATA-TARGET" =>"#modal_delete",
        "CLASS" => "btn btn-danger",
        "ICON" => "glyphicon glyphicon-remove",
        ],
        "REFRESH" => ["ID" => "btn_refresh",
        "NAME" => "刷新",
        "DATA-TARGET" =>"#modal_refresh",
        "CLASS" => "btn btn-warning",
        "ICON" => "glyphicon glyphicon-refresh",
        ],
        "EXPORT" => ["ID" => "btn_export",
        "NAME" => "导出",
        "DATA-TARGET" =>"#modal_export",
        "CLASS" => "btn btn-info toolbar",
        "ICON" => "glyphicon glyphicon-export"
            ]
            ]
            ];
        */ 
        //------Sample Code ------
        $array_tag = isset($_array_tag) ? $_array_tag :array() ;
        if ($array_tag == '') {
            $_array_tag = [
                "TITLE" =>"{$_title}",
                "BUTTON" => [
                    "NEW" => ["ID" => "btn_new",
                        "NAME" => "新增",
                        "DATA-TARGET" =>"#modal_new",
                        "CLASS" => "btn top btn-primary btn_modal",
                        "ICON" => "glyphicon glyphicon-plus",
                    ],
                    "EDIT" => ["ID" => "btn_edit",
                        "NAME" => "编辑",
                        "DATA-TARGET" =>"#modal_edit",
                        "CLASS" => "btn btn-success btn_modal",
                        "ICON" => "glyphicon glyphicon-edit",
                    ],
                    "DELETE" => ["ID" => "btn_delete",
                        "NAME" => "删除",
                        "DATA-TARGET" =>"#modal_delete",
                        "CLASS" => "btn btn-danger",
                        "ICON" => "glyphicon glyphicon-remove",
                    ],
                    "REFRESH" => ["ID" => "btn_refresh",
                        "NAME" => "刷新",
                        "DATA-TARGET" =>"#modal_refresh",
                        "CLASS" => "btn btn-warning",
                        "ICON" => "glyphicon glyphicon-refresh",
                    ],
                    "EXPORT" => ["ID" => "btn_export",
                        "NAME" => "导出",
                        "DATA-TARGET" =>"#modal_export",
                        "CLASS" => "btn btn-info toolbar",
                        "ICON" => "glyphicon glyphicon-export"
                    ]
                ]
            ];
        }

            $_html = "";
            $_button = $_array_tag["BUTTON"];
            
            $_html .= " <nav class='navbar navbar-default' role='navigation'>";
            $_html .= " <div class='container-fluid' style='height:36px'>";
            $_html .= " <div class='navbar-header'>";
            $_html .= " <a class='navbar-brand' href='#'>{$_array_tag['TITLE']}</a>";
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
            return $_html;
        }

     //<---Toolbar(Page)   
    
        
    //--->Modal(Page)
    public function build_html_modal($_array_tag){
    // ------Sample Code ------
    /*
        $_body = '';
        $_body .= "<p id='message'></p>";
        $_body .= "";
        $_body .= " </form>";
        
        $_array_tag = [
            "ID"  => "modal_new",
            "HEADER" => [
                "TITLE" =>"TITLEXXX",
            ],
            "BODY"  => [
                "{$_body}"
                ],
                "FOOTER" => [
                    "BUTTON" => [
                        "SUBMIT" => ["ID" => "btn_new_submit",
                            "NAME" => "提交更改",
                            "CLASS" => "btn btn-primary",
                            "ICON" => "glyphicon .glyphicon-ok",
                            "ENHANCEMENT" =>""
                        ],
                        "CLOSE" => ["ID" => "btn_new_close",
                            "NAME" => "关闭 [ESC]",
                            "CLASS" => "btn btn-default",
                            "ICON" => "glyphicon .glyphicon-remove",
                            "ENHANCEMENT" =>"data-dismiss='modal'"
                        ]    
                    ]
                ]
                
                ];
     */   
     //------Sample Code ------
        
        $_html = "";
        $_footer_buttton = $_array_tag["FOOTER"]["BUTTON"];
        
        $_html .= " <div class='modal fade' id='{$_array_tag['ID']}' tabindex='-1' role='dialog' aria-labelledby='{$_array_tag['ID']}Label' data-backdrop='static' aria-hidden='true'>";
        $_html .= " <div class='modal-dialog modal-lg'>";
        $_html .= " <div class='modal-content'>";
        /*header*/
        $_html .= " <div class='modal-header'>";
        $_html .= " <h4 class='modal-title' id='{$_array_tag['ID']}Label'>";
        $_html .= " {$_array_tag['HEADER']['TITLE']}";
        $_html .= " </h4>";
        $_html .= " <button type='button' class='close' data-dismiss='modal'>&times;";
        $_html .= " </button>";
        $_html .= " </div>";
        /*body*/
        $_html .= " <div class='modal-body'>";
        //print_r($_array_modal['BODY'][0]);
        $_html .= " {$_array_tag['BODY'][0]}";
        $_html .= " </div>";
        /*footter*/
        $_html .= " <div class='modal-footer'>";
        foreach ( $_footer_buttton as & $value ) {
            $_html .= " <button type='button' id='{$value['ID']}' class='{$value['CLASS']}' {$value['ENHANCEMENT']}>{$value['NAME']}";
            $_html .= "</button>";
        }
        
        $_html .= " </div>";
        $_html .= " </div>";
        $_html .= " </div>";
        $_html .= " </div>";
        return $_html;
        
    }
        
    //<--Modal(Page)     
        
    //--->Table(Page)
    public function build_html_table($_array_tag){
    // ------Sample Code ------
    /* 
        $_array_tag =[
            "TABLE" => [
                "ID" => "tab_01",
                "CLASS" => "table table-sm table-bordered",
                "TITLE" => "标题",
                "TITLE_ENABLE" =>false,
                "SEARCH_ENABLE" =>true,
                "TABLE_NAME" => "tb_bin",
                "LIST_ROWS" => "9",
                "PAGE_NAME" => "",
                "SHOW_PAGES"=> "10",
                "PAGING_ENABLE" => true,
                "PAGING_FORMAT" => "2",
                "QUERY_TYPE" =>"STORE_PROCEDURE",
                "SQL" =>"select * from tb_type",
            ],
            "THEAD" => [
                "CLASS" => ""
            ],
            "TBODY" => [
                "ID" => "tbody_01"
            ],
            "COLS" => [
                
            ],
            "ROWS" => [
                
            ],
            "HIDDEN_COLS" =>[
                "id"
            ],
            "KEYS" => [
                "id",
            ],
            "ACTION" => [
                "CHECKBOX_ENABLE" => TRUE,
                "BUTTON_ENABLE" => TRUE,
                "BUTTON_COLUMN_NAME" => "操作",
                "CHECKBOX" => [
                    "ID" => "selectAll",
                    "NAME" =>"选择",
                    "CLASS" => "cbox checkbox",
                    "ENHANCEMENT" =>""
                ],
                "BUTTON" => [
                    "NEW" => ["ID" => "btn_table_new",
                        "NAME" => "新增",
                        "CLASS" => "btn btn-link  btn-sm",
                        "ICON" => "glyphicon glyphicon-plus",
                        "DATA-TARGET" =>"#modal_new",
                        "ENHANCEMENT" =>""
                    ],
                    "EDIT" => ["ID" => "btn_table_edit",
                        "NAME" => "编辑",
                        "CLASS" => "btn btn-link btn-sm",
                        "ICON" => "glyphicon glyphicon-edit",
                        "DATA-TARGET" =>"#modal_edit",
                        "ENHANCEMENT" =>""
                    ],
                    "DELETE" => ["ID" => "btn_table_delete",
                        "NAME" => "删除",
                        "CLASS" => "btn btn-link  btn-sm",
                        "ICON" => "glyphicon glyphicon-edit",
                        "DATA-TARGET" =>"#modal_delete",
                        "ENHANCEMENT" =>""
                    ]
                ]
            ],   
           "TABLE_SEARCH" => [
                "TEST"  =>"Test Use...",
                "NAME"  => "condition_code",
                "DIV"   => [
                    "CLASS" => "form-inline",
                    "STYLE" => "",
                    "ENHANCEMENT" =>"",
                ],
                "LABEL" => [
                    "ID" => "lbl_condition_code",
                    "NAME" => "lbl_condition_code",
                    "FOR"  => "condition_code",
                    "CLASS" => "control-label mr-1",
                    "TEXT"  => "选择条件" ,
                    "ENHANCEMENT" =>"",
                ],
                "SELECT" => [
                    "ID" => "condition_code",
                    "NAME" => "condition_code",
                    "CLASS" => "form-control",
                    "WHERE_USE" =>"TB_TYPE",
                    //"SQL" => "select search_code as code, search_text as text from tb_search where where_use ='tb_type' order by seq",
                    "ENHANCEMENT" =>"",
                ],
                "T_ENABLE" => TRUE,
                "T_CODE"  => "",
                "T_TEXT" => "--- 请选择 ---",
            ]
              
        ];
        
*/        
    //------Sample Code ------
        $_html = "";
        $res = "";
        $_col_keys = "";
        $rows = "";
        $cols = "";
        $button = "";
        $col_count ="";
        $row_count = "";
        $button_count = "";
        $listRows = "";
        $page = "";
        $pageName="";
        $pageNum = "";
        $current_page="";
        $last_page ="";
        $next_page ="";
        $goto_page ="";
        $show_pages_link="";
        $paging_html ="";
        $clause_name = "";
        $clause_value ="";
        $where = "";
        $table_title = "";
        $query_type = "";
        
       
        $page = !empty($_GET["page"]) ? $_GET["page"] : 1;
        $clause_name = !empty($_GET["condition_name"]) ? $_GET["condition_name"] : "";
        $clause_value = !empty($_GET["condition_value"]) ? $_GET["condition_value"] : "";
               
        
        $tab_title = isset($_array_tag['TABLE']['TITLE']) ? $_array_tag['TABLE']['TITLE'] : "";
        $listRows = isset($_array_tag['TABLE']['LIST_ROWS']) ? $_array_tag['TABLE']['LIST_ROWS'] : "9";
        $show_pages = isset($_array_tag['TABLE']['SHOW_PAGES']) ? $_array_tag['TABLE']['SHOW_PAGES'] : "10";
        $query_type = isset($_array_tag['TABLE']['QUERY_TYPE']) ? $_array_tag['TABLE']['QUERY_TYPE'] :'SQL';
        
        
        $array_tag = isset($_array_tag) ? $_array_tag :array() ;
        if (sizeof($array_tag) === 0) {
            return;
        }
        
        $limit = " Limit ".($page - 1)*$listRows.",{$listRows}";
        
        //---SQL---
        if ($query_type == 'SQL'){
        $sql = $array_tag['TABLE']['SQL'];
        if($clause_name !="" && $clause_value !=""){
            $where = $clause_name ." like "."'%".$clause_value."%'";
            if (isset($_array_tag['TABLE']['SQL_HAS_WHERE']) ? $_array_tag['TABLE']['SQL_HAS_WHERE'] : flase == true){
                $sql .= " and ". $where;
            }else{
                 $sql .= " where ". $where;
            }
        }
        //echo $sql;
        
        $res = $this->get_data($sql);
        if ($res==false)
        {   
            $sql = $array_tag['TABLE']['SQL'];
            $res = $this->get_data($sql);
            if ($res != false){
             $total = sizeof( $res );
            }
        }else{
            $total = sizeof( $res );
        }
        
        $sql = $sql. $limit;
        }
        
        if ($query_type == 'STORE_PROCEDURE'){
            $sql = $array_tag['TABLE']['SQL'];
            //$sql = $sql."('','','');";
            
            $res = $this->get_data($sql);
            if ($res != false){
                $total = sizeof( $res );
            }
            
            //$sql = $array_tag['TABLE']['SQL'];
            //$sql = $sql."("."'".$clause_name."'".",'".$clause_value."','".$limit."');";
            
        }
        
        //echo $sql;
        $res = $this->get_data($sql);
        
        if ($res==false)
        {   
            return;
        }
        
        if ((isset($res[0])?isset($res[0]):'') != ''){
            //loading Columns
            array_push($_array_tag['COLS'],array_keys($res[0]));
            //loading Rows
            array_push($_array_tag['ROWS'], $res);
        }
        
        
        $_cols = isset($_array_tag['COLS'][0]) ? $_array_tag['COLS'][0] :"" ;
        $_rows = isset($_array_tag['ROWS'][0]) ? $_array_tag['ROWS'][0] :"" ;
        $_hidden_cols = isset($_array_tag["HIDDEN_COLS"]) ? $_array_tag["HIDDEN_COLS"] :array() ;
        $_button = isset($_array_tag["ACTION"]["BUTTON"]) ? $_array_tag["ACTION"]["BUTTON"] :array() ;     
        
        if (sizeof($_rows) <> ""){
            $row_count = sizeof( $_rows );
        }
        if ($_cols <> ""){
            $_col_keys = array_keys($_cols);
            $col_count = sizeof( $_col_keys );
        }       
        
        if ($_button <>""){
            $button_count = sizeof( $_button );
        } 
        
        //--->Search
        $table_title = "";
        //$table_title .="<div class='form-row mb-1 flex-nowrap'> ";
        $table_title .= "<div class='form-group mb-2'>";
        $table_title .= "<label for='table_title' class='sr-only'>table Title</label>";
        //$table_title .= "<input type='text' disabled class='control-label' id='table_title' ";
        $table_title .= "<a class='nav-link active' href='#'>";
        $table_title .= $tab_title;
        $table_title .= "<span class='sr-only'>(current)</span></a>";
        //$table_title .= "value='标题'>";
        //$table_title .= " <input type='text' class='form-control d-none' style='width:0px'>";
        //$table_title .= "</div>";
        $table_title .="</div>";
        
        $table_search = "";
        //->
        $table_search .="<div class='form-row mb-1'> ";
        //--->
        $table_search .= $this->build_html_table_search_select($_array_tag['TABLE_SEARCH']);
        //<---
        
        //--->
        $table_search .= " <div class='form-inline'>";
        
        $table_search .= " <input type='text' class='form-control' style='width:200px' id='table_search_value' name='table_search_value' value='{$clause_value}' placeholder='请输入查询内容'>";
        
        $table_search .= " </div>";
        //<---
       
        //--->
        $table_search .= " <div class='form-inline'>";
        $table_search .= " <button class='btn btn-outline-secondary' id='btn_table_search' onclick='onTableSearch()'>查询</button>";
        $table_search .= " </div>";
        //<---
        $table_search .="</div>";
        //<-
        
        $search_html = "";
        $search_html .= "<div class='d-flex align-content-between'>";
        $search_html .= "<div class='col-6 span6'>";
        if (isset($_array_tag['TABLE']['TITLE_ENABLE']) ? $_array_tag['TABLE']['TITLE_ENABLE'] : flase == true){
        $search_html .= $table_title;
        }
        $search_html .= "</div>";
        
        $search_html .= "<div class='col span6'>";
        if (isset($_array_tag['TABLE']['SEARCH_ENABLE']) ? $_array_tag['TABLE']['SEARCH_ENABLE'] : flase == true){
        $search_html .= $table_search;
        }
        $search_html .= "</div>";
        $search_html .= "</div>";
        
        echo $search_html;
        echo  "<script type=text/javascript>setTableSearchNameValue('{$clause_name}','{$clause_value}')</script>"; 
        //<---Search
        
        //--------------------------------------------------//
        
        //--->Paging
        
        $pageNum = ceil($total/$listRows);
        
        $last_page_num = (($page - 1) < 1) ? 1 : ($page - 1);
        $next_page_num = (($page + 1) > $pageNum) ? $pageNum : ($page + 1);
        
        $show_pages = $page + $show_pages;
        
        IF ($_array_tag['TABLE']['PAGING_ENABLE'] == TRUE){
            IF ($_array_tag['TABLE']['PAGING_FORMAT'] == "1"){
        //--->Style - 01
        $first_page = "<a href=$pageName?page=1>首页</a>&nbsp";
        $end_page = "&nbsp<a href=$pageName?page=".$pageNum.">尾页</a>";
        $last_page = "&nbsp<a href=$pageName?page=".$last_page_num.">上一页</a>&nbsp";
        $next_page = "&nbsp<a href=$pageName?page=".$next_page_num.">下一页</a>&nbsp";
              
        if ($show_pages < $pageNum ){
            for($i=$page;$i<=$show_pages;$i++){
                $show_pages_link.="&nbsp<a href=$pageName?page=".$i.">{$i}</a>&nbsp";
            }
        }else{
            for($i=($pageNum < $show_pages ? 1 : $pageNum - $show_pages);$i<=$pageNum;$i++){
                $show_pages_link.="&nbsp<a href=$pageName?page=".$i.">{$i}</a>&nbsp";
            }
        }
        
        $totalRecoreds = "总记录:[ {$total} ]&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp";
        $goto_page = "<input type='text' id='input_goto_page' value='{$page}' size='2'/>&nbsp<button class='btn btn-outline-secondary btn-sm' onclick='onGoToPage(\"{$pageName}\",{$pageNum})'>跳转</button>&nbsp";
        $paging_html= $totalRecoreds.$goto_page.$first_page.$last_page.$show_pages_link.$next_page.$end_page;
        //<---Style - 01
            }
            
            IF ($_array_tag['TABLE']['PAGING_FORMAT'] == "2"){
        //--->Style - 02
        $paging_html = "";
        $paging_html .="<div>";
        $paging_html .="<nav aria-label='table_Paging'>";
        $paging_html .="<ul class='pagination'>";
        $paging_html .="<li class='page-item'><div class='page-link disabled sm'>总记录:[ {$total} ]&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</div></li>";
        $paging_html .="<li class='page-item'>";
        $paging_html .="<a class='page-link' href=$pageName?page=1 aria-label='Previous'>";
        $paging_html .="<span aria-hidden='true'>⇤</span>";
        $paging_html .="</a>";
        $paging_html .="</li>";
        $paging_html .="<li class='page-item'>";
        $paging_html .="<a class='page-link' href=$pageName?page=".$last_page_num." aria-label='Previous'>";
        $paging_html .="<span aria-hidden='true'>«</span>";
        $paging_html .="</a>";
        $paging_html .="</li>";
        $paging_html .="<li class='page-item'><input type='text' id='input_goto_page' class='form-control sm' style='width:60px' value='{$page}' /></li>";    
        $paging_html .="<li class='page-item'><button class='page-link' onclick='onGoToPage(\"{$pageName}\",{$pageNum})'>跳转</button>";

        if ($show_pages < $pageNum ){
            for($i=$page;$i<=$show_pages;$i++){
                $paging_html .="<li class='page-item'>";
                $paging_html .="<a class='page-link' href=$pageName?page=".$i.">{$i}</a>";
                $paging_html .="</li>";
            }
        }else{
            for($i=($pageNum < $show_pages ? 1 : $pageNum - $show_pages);$i<=$pageNum;$i++){
                $paging_html .="<li class='page-item'>";
                $paging_html .="<a class='page-link' href=$pageName?page=".$i.">{$i}</a>";
                $paging_html .="</li>";
            }
        }
        
        $paging_html .="<li class='page-item'>";
        $paging_html .="<a class='page-link' href=$pageName?page=".$next_page_num." aria-label='Next'>";
        $paging_html .="<span aria-hidden='true'>»</span>";
        $paging_html .="</a>";
        $paging_html .="</li>";
        $paging_html .="<li class='page-item'>";
        $paging_html .="<a class='page-link' href=$pageName?page=".$pageNum." aria-label='Previous'>";
        $paging_html .="<span aria-hidden='true'>⇥</span>";
        $paging_html .="</a>";
        $paging_html .="</li>";
        $paging_html .="</ul>";
        $paging_html .="</nav>";
        //<---Style - 02
            }
        //<---Paging  
        
        }
        
        $_html = "<div>";
        $_html .= "<table id='{$_array_tag['TABLE']['ID']}' class='{$_array_tag['TABLE']['CLASS']}'>";
        if ($_array_tag['TABLE']['TITLE_ENABLE'] == true)
        {
            //$_html .= "<caption>{$_array_tag['TABLE']['TITLE']}</caption>";
        }
        //$_html .="<caption>";
        //$_html .= "</caption>";
        
        //---Table Header---
        //->Table Column
        $_html .= "<thead>";
        $_html .= "<tr>";
        
        if (isset($_array_tag["ACTION"]["CHECKBOX_ENABLE"]) ? $_array_tag["ACTION"]["CHECKBOX_ENABLE"]:FALSE == TRUE){
            if (isset($_array_tag["ACTION"]["CHECKBOX"]) ? $_array_tag["ACTION"]["CHECKBOX"] :"" == true)
            {
                $col_count = $col_count + 1;
                $_html.= "<th style='width:70px;'>{$_array_tag["ACTION"]["CHECKBOX"]["NAME"]}<input id='{$_array_tag["ACTION"]["CHECKBOX"]["ID"]}' type='checkbox' ></th>";
            }
        }
        
        foreach ( $_col_keys as  $key ) {
            //print_r($_cols[0][$key]);
            $_array = "";
            
            $sql = "select * from tb_dict where type_code = 'TABLE' and where_use = '{$_array_tag['TABLE']['TABLE_NAME']}' and field_name = '{$_cols[$key]}' and language_code = 'ZH'";
            $_array = $this->ado->Retrieve_OneRow($sql);
            
            //---Hidden Cols---
            if(in_array($_cols[$key],$_hidden_cols)){
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
                $_html .= "{$_cols[$key]}";
            }
            
            $_html .= "</th>";
        }
        
        if (isset($_array_tag["ACTION"]["BUTTON_ENABLE"]) ? $_array_tag["ACTION"]["BUTTON_ENABLE"] :FALSE == true){
            if (isset($_array_tag["ACTION"]["BUTTON"]) ? $_array_tag["ACTION"]["BUTTON"] :"" == true){
                $_html .= "<th>{$_array_tag["ACTION"]["BUTTON_COLUMN_NAME"]}</th>";    
            }
        }
        
        $_html .= "</tr>";
        $_html .= "</thead>";
        
        //<-Table Column
        
        //---Table Body---
        if (isset($_array_tag["TBODY"]["ID"]) ? $_array_tag["TBODY"]["ID"] :"" <> ""){
            $_html .= "<tbody id='{$_array_tag["TBODY"]["ID"]}'>";
        }
        else{
            $_html .= "<tbody>";
        }
        
        foreach ( $_rows as $value ) {
            //print_r($_array_tag["KEYS"][0]);
            
            
            $_html .= "<tr>";
            //Action -> Checkbox 名称
            if (isset($_array_tag["ACTION"]["CHECKBOX_ENABLE"]) ? $_array_tag["ACTION"]["CHECKBOX_ENABLE"]:FALSE == TRUE){
                if (isset($_array_tag["ACTION"]["CHECKBOX"]) ? $_array_tag["ACTION"]["CHECKBOX"] :"" == true)
                {
                    //$_html.="<td><input type='checkbox'  role='checkbox_row' name='chk_row[]' value='{$value[$_cols[0][0]]}^{$value[$_cols[0][1]]}'  class='cbox checkbox'></td>";
                    $_html .= "<td style='text-align: center;'>";
                    $_html.="<input type='checkbox' name='chk_row[]' value='{$value[$_cols[0]]}'  class='cbox checkbox'>";
                    $_html .= "</td>";
                }
            }
            
            foreach($_col_keys as $key ) {
                //---Hidden Cols---
                //if(in_array($key,$_hidden_cols)){
                if(in_array($_cols[$key],$_hidden_cols)){
                    $_html .="<td style='display:none;'>";
                }
                else{
                    $_html .= "<td>";
                }
                
                $_html .= "{$value[$_cols[$key]]}";
               // print_r($value[$_cols[seq]]);
                $_html .= "</td>";
            }
            
            if (isset($_array_tag["ACTION"]["BUTTON_ENABLE"]) ? $_array_tag["ACTION"]["BUTTON_ENABLE"] :FALSE == true){
            $_html .= "<td>";
            if ($button_count > 0){
                foreach($_button as $btn){
                    //print_r($btn);
                    $_html .= "<button type='button' class='{$btn["CLASS"]}' ";
                    $_html .="data-toggle='modal' id='{$btn['ID']}' data-target='{$btn['DATA-TARGET']}'";
                    $_html .= ">";
                    $_html .= "{$btn["NAME"]}";
                    $_html .= "</button>";
                }
            }
            
            
            $_html .= "</td>";
            
            }
            
            $_html .= " </tr>";
        }
        //$_html .="<tr><td class='footer' colspan='{$col_count}' >";
        
        $_html .= " </table>";
        $_html .= "<div class='d-flex bd-highlight justify-content-center'>";
        $_html .= $paging_html;
        $_html .= "</div>";
        
        //$_html .= "</td></tr>";
        
        //$_html .= " </table>";
        $_html .="</div>";
        return $_html;
        
    }
        
    //<---Table(Page)
    
    //--->Table Search
    public function build_html_table_search(){
        //--->Search
        $table_title = "";
        $table_title .= "<div class='form-group mb-2'>";
        $table_title .= "<label for='table_title' class='sr-only'>table Title</label>";
        $table_title .= "<a class='nav-link active' href='#'>";
        $table_title .= $tab_title;
        $table_title .= "<span class='sr-only'>(current)</span></a>";
        $table_title .="</div>";
        
        $table_search = "";
        //->
        $table_search .="<div class='form-row mb-1'> ";
        //--->
        $table_search .= $this->build_html_table_search_select($_array_tag['TABLE_SEARCH']);
        //<---
        
        //--->
        $table_search .= " <div class='form-inline'>";
        
        $table_search .= " <input type='text' class='form-control' style='width:200px' id='table_search_value' name='table_search_value' value='{$clause_value}' placeholder='请输入查询内容'>";
        
        $table_search .= " </div>";
        
        //--->
        $table_search .= " <div class='form-inline'>";
        $table_search .= " <button class='btn btn-outline-secondary' id='btn_table_search' onclick='onTableSearch()'>查询</button>";
        $table_search .= " </div>";
        //<---
        $table_search .="</div>";
        //<-
        
        $search_html = "";
        $search_html .= "<div class='d-flex align-content-between'>";
        $search_html .= "<div class='col-6 span6'>";
        if (isset($_array_tag['TABLE']['TITLE_ENABLE']) ? $_array_tag['TABLE']['TITLE_ENABLE'] : flase == true){
            $search_html .= $table_title;
        }
        $search_html .= "</div>";
        
        $search_html .= "<div class='col span6'>";
        if (isset($_array_tag['TABLE']['SEARCH_ENABLE']) ? $_array_tag['TABLE']['SEARCH_ENABLE'] : flase == true){
            $search_html .= $table_search;
        }
        $search_html .= "</div>";
        $search_html .= "</div>";
        
        echo $search_html;
        echo  "<script type=text/javascript>setTableSearchNameValue('{$clause_name}','{$clause_value}')</script>"; 
    }
    
    
    //------ Build menu tml ------
    public function get_menu($user_id,$type_code,$admin_flag){
        $sql ="select * from tb_menu_x where type_code = '{$type_code}' and admin_flag = '' order by concat(path,id);";
        $sql ="call proc_get_user_type_menu('{$user_id}', '{$type_code}', '{$admin_flag}');";
        $res = $this->get_data($sql);
        return $res;
    }
    
    public function build_html_left_menu($user_id,$type_code,$admin_flag){
        $str_html='';
        $idx='0';
        
        $res = $this->get_menu($user_id,$type_code,$admin_flag);
        if($res==false){
            echo $res;
            return;
        }
        
        $cols = array_keys($res);
        
        $str_html .= "<nav class='mt-2'>";
        $str_html .= "<ul class='nav nav-pills nav-sidebar flex-column' data-widget='treeview' role='menu' data-accordion='false'>";
        
        foreach($res as $row) {
            if ($row['pid']=='0'){
                if ($idx !== '0'){
                    $str_html .='</ul>';
                    $str_html .='</li>';
                }
                
                $idx = $idx + 1;
                              
                $str_html .="<li class='nav-item'>";
                $str_html .="<a href='#' class='nav-link'>";
                $str_html .="<i class='{$row['icon']}'></i>";
                $str_html .="<p>";
                $str_html .="{$row['menu_name']}";
                $str_html .="<i class='right fas fa-angle-left'></i>";
                $str_html .="</p>";
                $str_html .="</a>";
                
                $str_html .="<ul class='nav nav-treeview'>";
                
                
            }else{
                $str_html .="<li class='nav-item'>";
                $str_html .="<a href='{$row['url']}' class='nav-link'>";
                
                if ((isset($row['icon']) ? $row['icon'] : '') == ''){
                    $str_html .="<i class='far fa-circle nav-icon'></i>";
                }else{
                    $str_html .="<i class='{$row['icon']}'></i>";
                }
                $str_html .="<p>{$row['menu_name']}</p>";
                $str_html .="</a>";
                $str_html .="</li>";
            }
            
            
        }
        if ($idx >0){
            $str_html .='</ul>';
            $str_html .='</li>';
        }
        
        $str_html .='</ul>';
        $str_html .= "</nav>";
        return $str_html;
        
    }
    
    //<---END
    }
}