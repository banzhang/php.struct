<?php
namespace struct\dict;

/**
 *
 * @author houweizong
 *        
 */
abstract class dict {
	// TODO - Insert your code here
	public $_dictObj;
	protected $_dictData; 
	protected $_type;
	/**
	 */
	function __construct($data,$init=false) {
		$this->_dictData=$data;
		if($init){
			$this->_init();
		}
		// TODO - Insert your code here
	}
	
	/**
	 */
	function __destruct() {
		
		// TODO - Insert your code here
	}
	
	/**
	 * 
	 */
	public abstract  function search($s);
	protected abstract	function _init();
	public function getType(){return $this->_type;}
	public function getDict(){return $this->_dictData;}
}

?>