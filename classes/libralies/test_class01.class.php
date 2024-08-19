<?php
namespace classes\libralies;
{
    class test_class01{
        
        public function getNameSpace()
        {   
            echo get_class($this).'<br>';
            return get_class($this);
        }
        
        public function test01()
        {
            echo 'The class is:'.__CLASS__.'<br>';
        }
    }
}