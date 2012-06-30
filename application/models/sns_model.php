<?php

class Sns_Model extends CI_Model{
	static protected $apptypes = array('web','android','ios');
	static protected $allSns = array(
			'sina'=>'sina',
			'qq'=>'qq',
			//'163'=>'163',
			//'bouban'=>'douban',
			//'qzone'=>'qzone',
			//'renren'=>'renren'
			);
	
	static public function getAllSns() {
		return self::$allSns;
	}
	static public function getAppTypes() {
		return self::$apptypes;
	}
	
	static public function encodeAuthString($str) {
		$random = array();
		for($a = ord('A');$a<=ord('Z');++$a) {
			$random[chr($a)] = $a;
		}
		for($a = ord('a');$a<=ord('z');++$a) {
			$random[chr($a)] = $a;
		}
		return implode('',array_rand($random,11)).$str;
	}
	static public function decodeAuthString($str) {
		return substr($str, 11);
	}
}
