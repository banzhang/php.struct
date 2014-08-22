<?php

/**
 * buildMaxHeapify 
 * @todo 构建最大堆
 *
 * @param array $ar 无序列表 
 * @access public
 * @return void
 */
function buildMaxHeapify(&$ar) {
	$maxIndex = count($ar)-1;
	$start  = $maxIndex>>1;
	for($i=$start;$i>=0;$i--) {
		maxHeapify($ar, $i, $maxIndex+1);
	}
}

/**
 * maxHeapify 
 * @todo 调整父子节点 
 *
 * @param array $ar 无序列表 
 * @param int $cItemIndex  当前元素索引
 * @param int $arLength  列表长度
 * @access public
 * @return void
 */
function maxHeapify(&$ar, $cItemIndex, $arLength) {
	$l = $cItemIndex<<1;
	$r = $l+1;
	$largest = $cItemIndex;

	//找出当前二叉树的最大值索引
	if($l<$arLength&&$ar[$cItemIndex]<$ar[$l]) {
		$largest = $l;
	}
	if($r<$arLength&&$ar[$largest]<$ar[$r]) {
		$largest = $r;
	}

	//调整最大值为当前二叉树的父节点
	if($largest != $cItemIndex){
		$tmp = $ar[$cItemIndex];
		$ar[$cItemIndex] = $ar[$largest];
		$ar[$largest] = $tmp;
		maxHeapify($ar, $largest, $arLength);
	}
}

/**
 * heapSort 
 * @todo  排序 
 *
 * @param array $ar 无序列表 
 * @access public
 * @return void
 */
function heapSort(&$ar){
	$maxIndex = count($ar)-1;
	buildMaxHeapify($ar);	
	for($i=$maxIndex;$i>0;$i--){
		$tmp = $ar[0];
		$ar[0] = $ar[$i];
		$ar[$i] = $tmp;
		maxHeapify($ar, 0, $i);
	}
}

$ar = array(1,4,2,8,3,8,23,8,3,89,2,76,5,2,34,867,83,45,756,7,234);

heapSort($ar);
print_r($ar);
