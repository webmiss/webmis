<?php

// 常量
defined('BASE_PATH') || define('BASE_PATH', getenv('BASE_PATH') ?: realpath(dirname(__FILE__) . '/../..'));
defined('APP_PATH') || define('APP_PATH', BASE_PATH . '/app');

// 开启session
session_start() or session_start();

return [
	'version' => '1.0.0',
	'charset' => 'UTF-8',
	'timeZone' => 'PRC',
	// 默认参数、模块、控制器、函数
	'url' => '_url',
	'module' => 'home',
	'controller' => 'Index',
	'action' => 'index',
	// 定义模块
	'modules' => [
		'home' => ['namespace'=>'App\Modules\Home'],
		'admin' => ['namespace'=>'App\Modules\Admin'],
	],
];