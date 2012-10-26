<?php
	require_once './dict/sequence.php';
	use \struct\dict as dict;
	$data=array(1,2,3,4,5,6,8,7);
	$dict = new Sequence($data,true);
	$dict -> setBinSearch(true);
	echo $dict->search(1); 
	var_export($dict->getDict());