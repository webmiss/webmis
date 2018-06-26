<?php
namespace framework;

/* 数据库类 */
class Model {
	// 属性
	static private $config;
	static private $conn;

	/* 查询多条 */
	static function find($data=''){
		$res = self::executeFind($data);
		// 返回结果
		$data = [];
		while($row=$res->fetchObject()) $data[] = $row;
		return $data;
	}

	/* 查询一条 */
	static function findfirst($data=''){
		$res = self::executeFind($data);
		// 结果
		return $res?$res->fetchObject():'';
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
		return $res->rowCount();
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
		// 拼接SQL
		$k = '`'.implode('`,`', array_keys($data)).'`';
		$v = '';
		foreach($data as $val){
			$v .= '\''.$val.'\',';
		}
		$v = rtrim($v,',');
		$sql = 'INSERT INTO `'.$table.'`('.$k.') VALUES ('.$v.')';
		// 执行SQL
		return self::execute($sql)?true:false;
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
		return self::execute($sql)?true:false;
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
		return self::execute($sql)?true:false;
	}

	/* 执行SQL */
	static function execute($sql=''){
		if(!$sql) die ('执行：SQL不能为空！');
		try{
			// 连接
			self::conn();
			// 执行
			$res = self::$conn->prepare($sql);
			$res->execute();
			return $res ;
		} catch (\PDOException $e) {
			die('执行失败：'.$e->getMessage());
		}
	}

	/* 事务 */
	static function commit($sql=[]){
		if(!$sql) die ('事务：SQL不能为空！');
		// 连接
		self::conn();
		try{
			// 开始事务
			self::$conn->beginTransaction();
			foreach($sql as $val){
				self::$conn->exec($val);
			}
			// 执行
			self::$conn->commit();
		} catch (\PDOException $e) {
			self::$conn->rollBack();
			die('执行失败：'.$e->getMessage());
		}
	}

	// 连接数据库
	static private function conn(){
		try {
			// 配置文件
			self::$config = require APP.'database.php';
			$option = [
				// 长链接
				\PDO::ATTR_PERSISTENT=>self::$config['persistent'],
				// 异常设置
				\PDO::ATTR_ERRMODE=>2
			];
			// 链接
			self::$conn = new \PDO(self::$config['type'].':host='.self::$config['host'].';dbname='.self::$config['db'],self::$config['uname'],self::$config['passwd'],$option);
		} catch (\PDOException $e) {
			die('数据库：'.$e->getMessage());
		}
	}
}