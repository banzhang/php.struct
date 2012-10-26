<?php

require_once ('struct/dict/dict.php');
require_once ('struct/sort/sort.php');

use struct\dict\dict;
use struct\sort\sort;

/**
 *
 * @author houweizong
 *        
 */
class sequence extends dict {
	// TODO - Insert your code here
	private $_binSearch = false;
	/**
	 */
	function __construct($data,$init) {
		$this->_type=__CLASS__;
		parent::__construct($data,$init);
		// TODO - Insert your code here
	}
	/**
	 * 
	 * 
	 */
	public function setBinSearch($v){$this->_binSearch=$v;}
	/**
	 * @默认不需要初始化，因为数据是有序的
	 * */
	protected function _init(){
		$sort = sort::getSort();
		$sort->setType('twoPassSort');
		$this->_dictData = $sort->doSort($this->_dictData);
	}
	/**
	 *
	 * @see dict::search()
	 *
	 */
	public function search($s) {
		$f=$this->_binSearch?'binSearch':'seqSearch';
		return $this->$f($s);
		// TODO - Insert your code here
	}
	private function binSearch($s,$l=false,$r=false){
		$l=$l===false?0:$l;
		$r=$r===false?count($this->_dictData)-1:$r;
		$tp=$r==1?0:ceil(($r+$l)/2);
		do{
			if($s<$this->_dictData[$tp]){
				if($tp<0) return false;
				return $this->binSearch($s,$l,$tp);	
			}else if($s>$this->_dictData[$tp]){
				if($tp>$r) return false;
				return $this->binSearch($s,$tp,$r);
			}else if($s==$this->_dictData[$tp]){
				return $tp;
			}
		}while(isset($this->_dictData[$tp]));
		return false;
	}
	private function seqSearch($s){
		foreach($this->_dictData as $k=>$v){
			if($v===$s) return $k;
		}
		return false;
	}
	/**
	 */
	function __destruct() {
		$this->_dictData = null;
		// TODO - Insert your code here
	}
}

?>