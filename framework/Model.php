<?php

namespace framework;

use \mysqli;

// 数据库类
class Model{

	// 属性
	static private $config;
	static private $conn;

	/* 查询多条 */
	static function find($data=''){
		$res = self::executeFind($data);
		// 数据
		$data = [];
		if(empty($res->num_rows)){return $data;}
		while($row = $res->fetch_object()) $data[] = $row;
		// 结果
		return $data;
	}

	/* 查询一条 */
	static function findfirst($data=''){
		$res = self::executeFind($data);
		// 结果
		return $res?$res->fetch_object():'';
	}

	/* 返回条数 */
	static function getNumRows($where='',$table=''){
		// 数据表
		$table = $table?$table:static::$table;
		// SQL语句
		$sql = 'SELECT * FROM `'.$table.'`';
		$sql .= !empty($where)?' WHERE '.$where:'';
		// 连接数据库
		self::conn();
		// SQL
		$res = self::execute($sql);
		return isset($res->num_rows)?$res->num_rows:0;
	}

	// 执行查询
	static private function executeFind($data){
		// 表和字段
		$table = isset($data['table'])?$data['table']:static::$table;
		$field = isset($data['field'])?$data['field']:'*';
		// SQL
		$sql = 'SELECT '.$field.' FROM `'.$table.'`';
		$sql .= isset($data['where'])&&!empty($data['where'])?' WHERE '.$data['where']:'';
		$sql .= isset($data['group'])&&!empty($data['group'])?' GROUP BY '.$data['group']:'';
		$sql .= isset($data['order'])&&!empty($data['order'])?' ORDER BY '.$data['order']:'';
		$sql .= isset($data['limit'])&&!empty($data['limit'])?' LIMIT '.$data['limit']:'';
		// 连接数据库
		self::conn();
		// 执行SQL
		return self::execute($sql);
	}

	/* 添加 */
	static function add($data=''){
		// 表
		$table = isset($data['table'])?$data['table']:static::$table;
		// 连接数据库
		self::conn();
		// 拼接SQL
		$k = '`'.implode('`,`', array_keys($data)).'`';
		$v = '';
		foreach($data as $val){
			$v .= '\''.self::$conn->real_escape_string($val).'\',';
		}
		$v = rtrim($v,',');
		$sql = 'INSERT INTO `'.$table.'`('.$k.') VALUES ('.$v.')';
		// 执行SQL
		return self::execute($sql);
	}

	/* 更新 */
	static function update($data='',$where=''){
		// 表
		$table = isset($data['table'])?$data['table']:static::$table;
		// 连接数据库
		self::conn();
		// 拼接
		$str = '';
		foreach($data as $key=>$val){
			$str .= '`'.$key.'`=\''.self::$conn->real_escape_string($val).'\',';
		}
		$str = rtrim($str,',');
		// SQL
		$sql = 'UPDATE `'.$table.'` SET '.$str.' WHERE '.$where;
		// 执行SQL
		return self::execute($sql);
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
		// 连接数据库
		self::conn();
		// 执行SQL
		return self::execute($sql);
	}

	/* 执行QSL */
	static function execute($sql){
		// 结果
		return self::$conn->query($sql);
	}

	// 连接数据库
	static private function conn(){
		// 配置文件
		self::$config = require APP.'database.php';
		// 链接并打开数据库(永久链接)
		self::$conn = new mysqli(self::$config['host'],self::$config['uname'],self::$config['passwd'],self::$config['db']);
		// 链接错误
		if(self::$conn->connect_error)die('错误('.self::$conn->connect_errno.'):'.self::$conn->connect_error);
		// 设置编码
		if(!self::$conn->set_charset(self::$config['charset']))die('设置编码：'.self::$conn->error);
	}
}