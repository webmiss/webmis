<?php

/**
  * FrameWork
  * ==================
  * Author：WebMIS
  * Version:1.0
  */

// 测速
// $start = microtime(true);
// echo (microtime(true) - $start)*1000;

// 框架: 命名空间和自动加载类
require APP.'../framework/Loader.php';
spl_autoload_register('Loader::autoload');

// 配置文件
$config = require APP.'config.php';

// 拆分参数
if(isset($_GET['_url'])){
	$arr = array_values(array_filter(explode('/',$_GET['_url'])));
	unset($_GET['_url']);
}
// 模块、控制器、函数
$m = isset($arr[0])?$arr[0]:$config['default_module'];
$c = isset($arr[1])?$arr[1]:$config['default_controller'];
$a = isset($arr[2])?$arr[2]:$config['default_action'];

// 常量
define('MODULE',$m);
define('CONTROLLER',$c);
define('ACTION',$a);

// 安全防范
$c .= 'Controller';
$a .= 'Action';

// 控制器
$c = '\\app\\modules\\'.$m.'\\controller\\'.ucwords($c);

// 是否存在类
if(!class_exists($c)){die('类不存在！');}

// 实例化
$C = new $c();

// 是否存在函数
if(!method_exists($C,$a)){die('函数不存在！');}

// 调用
return $C->$a();

?>