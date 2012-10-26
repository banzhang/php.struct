<?php	
	use struct\string;
	
	/**
	 *
	 * @author houweizong
	 *
	 */
	/**
	 * @todo �Ľ���KMP�㷨��ģʽ�����ƶ��ַ�����
	 * @param $pattern ģʽ��
	 * @param $next ����ģʽ��������
	 * **/
	function findNextVal($pattern,&$next){
		$next[0] = -1;
		$j = 0;
		$k = -1;
		$length = strlen( $pattern );
		while( $j < $length ){
			if( $k==-1 || $pattern[$j] == $pattern[$k] ){
				$j++;
				if( $pattern[$j] == $pattern[$k] ){
					$k++;
					$next[$j] = $k;
				}else{
					$k<0 && $k++;	
					$next[$j] = $next[$k]+1;					
				} 
			}else{	
				$k = $next[$k];
			}
		}
	}
	/**
	 * @todo KMP�㷨��ģʽ�����ƶ��ַ�����
	 * @param $pattern ģʽ��
	 * @param $next ����ģʽ��������
	 * **/
	function findNext($pattern,&$next){
		$next[0] = -1;
		$j = 0;
		$k = -1;
		$length = strlen( $pattern );
		while( $j < $length ){
			while( $k > -1 && $pattern[$j] == $pattern[$k] ){
				$j++;
				$k++;
				$next[$j]=$k;
			}
				if($k<=0 && $j<$length){
					$k = 0;
					$j+=1;
					$j !=0 && $next[$j] = 0;
				}else{
					$k = $next[$k];
				}
		}
	}
	$test='abssssssssabssssssssss';
	$next=array();
	findNext($test,$next);
	var_dump($next);