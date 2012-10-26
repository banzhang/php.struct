<?php 
    namespace c;
        function __c(){
            echo __FUNCTION__."\r\n";
        }

    include('./nospace.php');
    $f = '__c';
    __c();
    $f();
