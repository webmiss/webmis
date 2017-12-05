<?php

namespace framework;

use \mysqli;

// 数据库类
class Model{

	// 属性
	static private $config;
	static private $conn;

	/* 构造函数 */
	function __construct(){
	}

	/* 查询多条 */
	static function find($data=''){
		$res = self::executeFind($data);
		// 数据
		$data = [];
		if(empty($res->num_rows)){return $data;}
		while($row = mysqli_fetch_object($res)){
			$data[] = $row;
		}
		// 结果
		return $data;
	}

	/* 查询一条 */
	static function findfirst($data=''){
		$res = self::executeFind($data);
		// 数据
		$data = [];
		if(empty($res->num_rows)){return $data;}
		// 结果
		return mysqli_fetch_object($res);
	}

	/* 返回条数 */
	static function getNumRows($where='',$field='*',$table=''){
		// 数据表
		$table = $table?$table:static::$table;
		// SQL语句
		$sql = $where?'SELECT '.$field.' FROM '.$table.' WHERE '.$where:'SELECT '.$field.' FROM '.$table;
		$res = self::execute($sql);

		return @mysqli_num_rows($res);
	}

	// 执行查询
	static private function executeFind($data){
		// 表和字段
		$table = isset($data['table'])?$data['table']:static::$table;
		$field = isset($data['field'])?$data['field']:'*';
		// SQL
		$sql = 'SELECT '.$field.' FROM `'.$table.'`';
		$sql .= isset($data['where'])&&!empty($data['where'])?' WHERE '.$data['where']:'';
		$sql .= isset($data['order'])&&!empty($data['order'])?' ORDER BY '.$data['order']:'';
		$sql .= isset($data['limit'])&&!empty($data['limit'])?' LIMIT '.$data['limit']:'';
		// 执行SQL
		return self::execute($sql);
	}

	/* 添加 */
	static function add($data=''){
		// 表
		$table = isset($data['table'])?$data['table']:static::$table;
		// 拼接
		$k = '`'.implode('`,`', array_keys($data)).'`';
		$v = '\''.implode('\',\'', $data).'\'';
		// SQL
		$sql = 'INSERT INTO `'.$table.'`('.$k.') VALUES ('.$v.')';
		// 执行SQL
		$res = self::execute($sql);
		return $res;
	}

	/* 更新 */
	static function update($data='',$where=''){
		// 表
		$table = isset($data['table'])?$data['table']:static::$table;
		// 拼接
		$str = '';
		foreach($data as $key=>$val){
			$str .= '`'.$key.'`=\''.$val.'\',';
		}
		$str = rtrim($str,',');
		// SQL
		$sql = 'UPDATE `'.$table.'` SET '.$str.' WHERE '.$where;
		// 执行SQL
		$res = self::execute($sql);
		return $res;
	}

	/* 删除 */
	static function del($where='',$table=''){
		// 表
		$table = !empty($table)?$table:static::$table;
		// 数组条件
		if(is_array($where)){
			$where = implode(' OR ',$where);
		}
		// SQL
		$sql = 'DELETE FROM `'.$table.'`';
		$sql .= isset($where)?' WHERE '.$where:'';
		// 执行SQL
		$res = self::execute($sql);
		return $res;
	}

	/* 执行QSL */
	static function execute($sql){
		// 配置文件
		self::$config = require APP.'database.php';
		// 链接并打开数据库(永久链接)
		self::$conn = new mysqli(self::$config['host'],self::$config['uname'],self::$config['passwd'],self::$config['db']);
		// 链接错误
		if(self::$conn->connect_error){ die('错误('.self::$conn->connect_errno.'):'.self::$conn->connect_error); }
		// 设置编码
		self::$conn->set_charset(self::$config['charset']);
		// 执行SQL
		$res = self::$conn->query($sql);
		// 结果
		return $res;
	}
}