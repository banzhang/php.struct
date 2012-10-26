<?php
    /**
     * @todo 取得字符串中的数字
     *
     * */
    function getNum($num){	
		$tmp=false;
		$len=strlen($num);
		for($i=0;$i<$len;$i++){
			$tmp.=is_numeric($num[$i])?$num[$i]:',';
		}
		$resa=array_unique(explode(',',$tmp));
		$res=array();
		foreach($resa as $v){
			!empty($v)&&array_push($res,$v);
		}
		return $res;
	}
