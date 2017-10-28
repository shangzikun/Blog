<?php

    function __autoload($class) {

		if (strpos($class,"Controller") !== false) {
			$str = 'controller';
		}else if (strpos($class,"Model") !== false) {
			$str = 'model';
		}else {
			die($class . "not exist");
		}

		include "./{$str}/{$class}.class.php";
}
	function L($name) {
		include "./library/{$name}.class.php";
		$obj = new $name();
		return $obj;
	}
	//验证码生成随机数
	function getRandom($len) {
		$base="0123456789abcdefgh";
		$max=strlen($base);
		mt_rand();
		$res='';
		for ($i=0; $i<$len ; $i++) { 
		$res .=$base[mt_rand(0,$max-1)];
		}
		return $res;
	}
	// public function back() {
	// 		echo "<script>alert('返回上一页');history.go(-2);</script>";  
	// 	}
