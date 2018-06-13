<?php

/**
  * FrameWork
  * ==================
  * Author：WebMIS
  * Version：1.0.2
  */

// 测速
// $start = microtime(true);
// echo (microtime(true) - $start)*1000;

// 框架: 命名空间和自动加载类
spl_autoload_register(function($class){
	$file = strtr(__DIR__.'/../'.$class.'.php','\\','/');
	if(!is_file($file))die('警告：该文件不存在！');
	require $file;
});

// 拆分参数
if(isset($_GET['_url'])){
	$arr = array_values(array_filter(explode('/',$_GET['_url'])));
	unset($_GET['_url']);
}

// 配置文件
$config = require APP.'config.php';

// 模块、控制器、函数
$m = isset($arr[0])?$arr[0]:$config['default_module'];
$c = isset($arr[1])?ucwords($arr[1]):$config['default_controller'];
$a = isset($arr[2])?$arr[2]:$config['default_action'];
// 参数
$p1 = isset($arr[3])?$arr[3]:'';
$p2 = isset($arr[4])?$arr[4]:'';
$p3 = isset($arr[5])?$arr[5]:'';

// 常量
define('MODULE',$m);
define('CONTROLLER',$c);
define('ACTION',$a);

// 安全防范
$c .= 'Controller';
$a .= 'Action';

// 控制器
$c = '\\app\\modules\\'.$m.'\\controller\\'.$c;
// 是否存在类
if(!class_exists($c))die(CONTROLLER.'：该类不存在！');
// 实例化
$C = new $c();
// 是否存在函数
if(!method_exists($C,$a))die(ACTION.'：该函数不存在！');
// 调用
echo $C->$a($p1,$p2,$p3);
