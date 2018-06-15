<?php
namespace framework;

/* 数据库类 */
class Model {
	// 属性
	static private $config;
	static private $conn;
	
	/* 构造函数 */
	function __construct(){
		echo '构造函数';
	}

	/* 查询多条 */
	static function find($data=''){
		self::conn();
	}

	// 连接数据库
	static private function conn(){

	}
}