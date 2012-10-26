<?php
    $a=array();
    function test(&$a){
        $a['test']=10;
    }
    var_dump($a);
    test($a);
    var_dump($a);
    function testb(&$a){
    $a=10;
    }
    testb($a);
    var_dump($a);
    $a=new stdClass();
    function testc(&$a){
        $a->test=10;
    }
    testc($a);
    var_dump($a);

    class inc{
        private $_version;
        private $_inc=array(); 
        public static $one=null;
        public static function getInstance(){
            if(self::$one instanceof self) return self::$one;
            return self::$one=new self();
        }

        private function __construct(){
             
        }
        public function isValid($k){
            return array_key_exists($k,$this->_inc);
        }
        public function __set($k,$v){
            $this->_inc[$k]=$v;
        }
        public function set($k,&$v){
            $this->_inc[$k]=$v;
        }
        public function __get($k){
            return $this->_inc[$k];
        }
    }
    $b=10;
    $inc = inc::getInstance();
    $inc2 = &$inc;
    var_dump($inc,$inc2);
    $user=new stdClass();
    $inc->user=$user;
    $inc->set('user1',$b);
    $user->name='houweizong';
    var_dump($user);
    var_dump($inc);
    var_dump($inc->user);
    var_dump($inc->user1);
    $user->name='zhangyi';
    var_dump($user);
    var_dump($inc);
    var_dump($inc->user);
    var_dump($inc->user1);
    var_dump(strlen('http://www.baijob.com/promo/sina/jobtest/?utm_source=centerhttp://www.baijob.com/promo/sina/jobtest/?utm_source=centerhttp://www.baijob.com/promo/sina/jobtest/?utm_source=center'));
