<?php
class Loader{

	/* 路径映射 */
	public static $vendorMap = [
		'framework'=>__DIR__,
		'app'=>'../app'
	];

	/* 自动加载器 */
	public static function autoload($class){
		$file = self::findFile($class);
		// echo $file.'<br>';
		if (file_exists($file)) {
			self::includeFile($file);
		}
	}

	/* 解析文件路径 */
	private static function findFile($class){
		// 顶级命名空间
		$vendor = substr($class,0,strpos($class,'\\'));
		// 文件基目录
		$vendorDir = self::$vendorMap[$vendor];
		// 文件相对路径
		$filePath = substr($class, strlen($vendor)).'.php';
		// 文件标准路径
		return strtr($vendorDir.$filePath,'\\',DIRECTORY_SEPARATOR);
	}

	/* 引入文件 */
	private static function includeFile($file){
		if(is_file($file)){include $file;}
	}
}
?>