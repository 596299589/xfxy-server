<?php
class RandomString {
	function __construct() {
	}
	/**
	 * 
	 * @param 生成字符串的长度  $stringLength
	 */
	public function createString($stringLength) {
		$randstr = '';
		for($i = 0; $i < $stringLength; $i ++) {
// 			$randstr .= chr ( mt_rand ( 65, 90 ) ); // 大写字母
			$randstr .= chr ( mt_rand ( 97, 122 ) ); // 小写字母
		}
		return $randstr;
	}
}

