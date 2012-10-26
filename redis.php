<?php
    include('./redis/autoload.php');
    $redis = new Predis\Client();
    $redis -> connect('127.0.0.1',6379);
    $k='d';
    $redis -> incr($k);
    var_dump($redis -> get($k));
    $d='e';
    $redis -> set($d,1);
    var_dump($redis -> get($d));
    $r=fsockopen('127.0.0.1',6379);
    $cmd="*2\r\n$3\r\nget\r\n$1\r\ne";
    fwrite($r,$cmd,strlen($cmd));
    echo fgets($r,2048);
