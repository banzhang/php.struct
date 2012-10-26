<?php
	namespace struct\sort;
	
	/**
	 *
	 * @author houweizong
	 *
	 */
	class sort{
		static public $seg;
		private $type='maoPao';
		private $types=array('maoPao','twoPass','shell');
		private function __construct(){
			
		}
		static public function getSort(){
			if(self::$seg instanceof self){
				return self::$seg;
			}else{
				self::$seg = new self();
				return self::$seg;
			}
		}
		public function setType($type){
			$this->type=$type;
		}
		public function doSort($array){
			$method=$this->type;
			$result=$this->$method($array);
			return $result;
		} 	
		/**
		 * @todo 插入排序_直接插入排序
		 **/
		private function straiSort(&$array){
			$len=count($array);
			for($i=1;$i<$len;$i++){
				$this->straiPass($array,$array[$i],$i);
			}
			return $array;
		}
		private function straiPass(&$array,$i,$length){
			$length-=1;
			while($length>-1&&$i<$array[$length]){
				$array[$length+1]=$array[$length];
				$length--;
			}
			$array[$length+1]=$i;
		}
		/**
		 * @todo 插入排序_折半插入排序
		 **/
		private function binaSort(&$array){
			$len=count($array);
			for($i=1;$i<$len;$i++){
				$this->binaPass($array,$array[$i],$i);
			}
			return $array;
		} 
		private function binaPass(&$array,$i,$len){
			$len-=1;
			$low=0;
			$hight=$len;
			while($low<=$hight&&$low>-1&&$hight>-1){
				$m=intval(($low+$hight)>>1);
				if($i<$array[$m]){$hight=$m-1;}else{$low=$m+1;}
			}
			for($j=$len;$j>$hight+1;$j--){
				$array[$j+1]=$array[$j];
			}
			$array[$hight+1]=$i;
		}
		/**
		 * @todo  插入排序_2路插入排序
		 **/
		private function twoPassSort($array){
			$size = count($array);
			$first = 0;
			$final = 0;
			$tmp = array();
			$tmp[$first]=$array[0];
			for($i=1;$i<$size;$i++){
				if($array[$i]<$tmp[$first]){
					$first = ($first-1+$size)%$size;
					$tmp[$first] = $array[$i];
				}elseif($array[$i]>=$tmp[$final]){
					$final +=1;
					$tmp[$final] = $array[$i];
				}else{
					$j = $final;
					$final++;
					while($array[$i]<$tmp[$j]){
						$tmp[($j+1)%$size]=$tmp[$j];
						$j = ($j-1+$size)%$size;
					}
					$tmp[$j+1]=$array[$i];
				}
			}
			for($i=0;$i<$size;$i++){
				$array[$i]=$tmp[($i+$first)%$size];
			}	
			unset($tmp);
			return $array;	
		}
		/**
		 * @todo 插入排序_希尔排序
		 * */
		private function shellSort($array){
			$inSeq = array(1,2,3,5,19,41,109);
			$seqLen=count($inSeq);
			$arrLen=count($array);
			for($i=$seqLen-1;$i>=0;$i--){
				$array=$this->shellPass($array, $inSeq[$i], $arrLen);	
			}
			return $array;
		}
		private function ShellPass($data, $d, $dataLen) {
			$temp;
			$k = 0;
			$i = 0;
			$j = 0;
			for($i = $d; $i < $dataLen; $i += $d) {
				if ($data [$i] < $data [$i - $d]) {
					$temp = $data [$i];
					$j = $i - $d;					
					do {
						$data [$j + $d] = $data [$j];
						$j = $j - $d;
						$k ++;
					} while ( $j > - 1 && $temp < $data [$j] );					
					$data [$j + $d] = $temp;
				}
				$k ++;
			}
			return $data;
		}
		
		/**
		 * @todo 交换排序_冒泡排序
		 * */
		private function maoPaoSort($array){
			$arrLen = count($array);
			for($i=$arrLen;$i>=1;$i--){
				$b = 0;
				for($j=1;$j<$i;$j++){
					if($array[$j]<$array[$j-1]){
						$b++;
						$array[$j]=$array[$j]+$array[$j-1];
						$array[$j-1]=$array[$j]-$array[$j-1];
						$array[$j]=$array[$j]-$array[$j-1];	
					}
				}
				if($b==0) break;
			}
			return $array;
		}
		/**
		 * @todo 交换排序_快速排序
		 * */
		private function  qSort(&$array,$low=false,$high=false)
		{
			$low = $low===false?0:$low;
			$high = $high === false?count($array)-1:$high;
			if( $low < $high){
				$i = $low;
				$j = $high;
				$temp = false;
				$temp = $array[$i];
				while($i < $j){

					while($array[$j] >= $temp && $i < $j)
					{
						$j--;
					}
					$array[$i] = $array[$j];
					while($array[$i] <= $temp && $i < $j)
					{
						$i++;
					}
					$array[$j]= $array[$i];
				}

				$array[$i] = $temp;
				$this->qSort($array,$low,$i-1);
				$this->qSort($array,$i+1,$high);
				return $array;
			}
		}
		/**
		 * @todo 选择排序_直接选择排序
		 * */
		private function selectSort($array){
			$num=count($array);
			for($i=$num-1;$i>=0;$i--){
				for($j=0;$j<$i;$j++){
					if($array[$j]>$array[$i]) {
						$array[$i]=$array[$j]+$array[$i];
						$array[$j]=$array[$i]-$array[$j];
						$array[$i]=$array[$i]-$array[$j];
					}
				}
			}
			return $array;
		}
		/**
		 * @todo 选择排序_堆排序
		 * */
		private function heapSort(&$seq) {
		$n = count ( $seq );
		array_unshift($seq,null);
		for($i = 2; $i <= $n; $i ++) {
			$this->siftup ( $seq, $i );
		}
		
		 for($i = $n; $i >= 2; $i --) {
			list ( $seq [1], $seq [$i] ) = array (
					$seq [$i],
					$seq [1] 
			);
			$this->siftdown ( $seq, $i - 1 );
		  }
		  array_shift($seq);
		  return $seq;
		}
		private function deleteMin(&$array,$i,$j){
			swap($array[$i],$array[$j]);
			$j--;
			for($h=$i;$h<$j>>2;){
				$lc=$array[2*$h]<$array[2*$h+1]?2*$h:2*$h+1;
				if($array[$h]<$array[$lc]){
					swap($array[$h],$array[$lc]);
					$h=$lc;	
				}else{
					return $array;
				}
			}
		}
		private function buildHeap(){}
		private function siftup(&$seq, $n) {
			$i = $n;		
			while ( $i > 1 ) {
				$p = floor ( $i / 2 );
				if ($seq [$p] <= $seq [$i]) {
					break;
				}
				list ( $seq [$p], $seq [$i] ) = array (
						$seq [$i],
						$seq [$p] 
				);
				
				$i = $p;
			}
		}
		private function siftdown(&$seq, $n) {
		$i = 1;
		
		while ( 1 ) {
			$c = $i * 2;
			
			if ($c > $n) {
				break;
			}
			
			/* $c 为左结点 $c + 1 为右结点 */
			if ($c + 1 <= $n) {
				if ($seq [$c + 1] < $seq [$c]) {
					$c ++;
				}
			}
			
			if ($seq [$i] <= $seq [$c]) {
				break;
			}
			
			/* 将$seq[$i]和它的两个孩子结点中关键字较大者进行交换 */
			list ( $seq [$c], $seq [$i] ) = array (
					$seq [$i],
					$seq [$c] 
			);
			
			$i = $c;
		}
	}
		private function swap(&$va,&$vb){
			$va=$vb+$va;
			$vb=$va-$vb;
			$va=$va-$vb;
		}
		private function mSort(&$array,$left,$right){
			if($left<$right){
				$center=floor(($left+$right)/2);
				$this->mSort($array,$left,$center);
				$this->mSort($array,$center+1,$right);
				$this->merge($array,$left,$center,$right);
				return $array;
			}else{
				return false;
			}
		}
		private function merge(&$array,$left,$center,$right){
			$i=$left;
			$j=$center+1;
			$tem=0;
			$temarray=array();
			for($tem;$i<=$center&&$j<=$right;++$tem){
				if($array[$i]<=$array[$j]){	
					$temarray[$tem]=$array[$i++];
				}else{
					$temarray[$tem]=$array[$j++];
				}
			}
			while($i<=$center){
				$temarray[$tem++]=$array[$i++];
			}
			while($j<=$right){
				$temarray[$tem++]=$array[$j++];
			}
			//print_r($temarray);
			$i=0;			
		  for($i;$i<($right-$left+1);$i++){
				$array[$left+$i]=$temarray[$i];
			}
		}
		/**
		 *@todo 归并排序_归并排序 
		 * 
		 */
		private function mergeSort(&$array){
			$array=$this->mSort($array,0,count($array)-1);
			return $array;
		}
		/**
		 * @todo 基数排序_基数排序
		 * @param array $array 待排序数组
		 */
		private function radixSort($array){
			$front=$rear=array();
			$i=$j=$digit=0;
			$maxDigit=strlen(max($array));
			for($i=$maxDigit-1;$i>=0;$i--){
				//重置桶
			    for($j=0;$j<10;$j++)
				$front[$j]=$rear[$j]=array();
				//分配
			    $j=0;
				while(isset($array[$j])){
					$array[$j]=sprintf("%0${maxDigit}d",$array[$j]);
					array_push($rear[$array[$j][$i]],$array[$j])&&$j++;
				}
				$j=0;
				//收集
				$array=array();
				while(isset($rear[$j])){
					foreach($rear[$j] as $num){
						array_push($array,trim($num,0));
					}
					$j++;
				}
			}
			return $array;
		} 
	}
	/*
	$sort = sort::getSort();
	$sort->setType('twoPass');
	$res=$sort->doSort(array(2,54,1,5,3,78,-1,9,4,76,56));
	var_dump($res);
	$sort->setType('shell');
	$res=$sort->doSort(array(2,54,1,5,3,78,-1,9,4,76,56,34,123,546456,12313,56,756,234,2,32,5345,12,42,35,235,2,4,27574,57,2,4,23,42,34,265,36,45,6,455,24,23,6,57,544,3,2,35,65,756,7,2,34,2,353,46,3,46,365,2,5,346,54,7,57,2,5,3,46,456,45,76796,79,678,6,85,7,3,6353,5));
	var_dump($res);
	$sort->setType('maoPao');
	$res=$sort->doSort(array(2,54,1,5,3,78,-1,9,4,76,56,34,123,546456,12313,56,756,234,2,32,5345,12,42,35,235,2,4,27574,57,2,4,23,42,34,265,36,45,6,455,24,23,6,57,544,3,2,35,65,756,7,2,34,2,353,46,3,46,365,2,5,346,54,7,57,2,5,3,46,456,45,76796,79,678,6,85,7,3,6353,5));
	var_dump($res);
	$sort->setType('binaSort');
	$res=$sort->doSort(array(5,3,4,2,1,6,9,8,7,23,43,123,65,46,123,12323,546,35345,1,231,5345,2,13,3453454));
	*/