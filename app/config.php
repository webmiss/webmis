<?php

// 编码
header('Content-type: text/html; charset=utf-8');

// 时区
@date_default_timezone_set('PRC');

// 开启session
@session_start();

// 配置信息
return [
	'default_module'=>'home',
	'default_controller'=>'Index',
	'default_action'=>'index',
];
