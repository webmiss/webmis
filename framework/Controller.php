<?php

namespace framework;

class Controller{

	//模板变量
	private static $var = [];
	private static $getContent = '';

	/* 获取网址 */
	static function getUrl($url=''){
		$base_url = $_SERVER['SERVER_PORT']=='443'?'https://':'http://';
		$base_url .= $_SERVER['HTTP_HOST'].'/'.MODULE.'/'.$url;
		return $base_url;
	}

	/* 跳转页面 */
	static function redirect($url=''){
		header("Location: ".self::getUrl($url));
	}

	/* 设置参数 */
	static function setVar($name,$value=''){
		self::$var[$name] = $value;
	}

	/* 获取参数 */
	static function getVar($name){
		return self::$var[$name];
	}

	/* 加载视图 */
	static protected function view($file=''){
		$file = APP.'modules/'.MODULE.'/view/'.$file.'.php';
		if(!is_file($file)){die('该视图不存在！');}
		// 参数
		foreach(self::$var as $key=>$val){$$key = $val;}
		// 加载视图
		ob_start();
		include $file;
		$ct=ob_get_contents();
		ob_end_clean();
		// 结果
		return $ct;
	}

	/* 加载模板视图 */
	static protected function setTemplate($template='',$file=''){
		// 模板文件
		$template = APP.'modules/'.MODULE.'/view/layouts/'.$template.'.php';
		// 视图文件
		$file = $file?$file:strtolower(CONTROLLER).'/'.ACTION;
		$file = APP.'modules/'.MODULE.'/view/'.$file.'.php';
		// 视图是否存在
		if(!is_file($file)){die('该模板视图不存在！');}
		// 参数
		foreach(self::$var as $key=>$val){$$key = $val;}
		// 加载视图
		self::$getContent = $file;
		ob_start();
		include $template;
		$ct=ob_get_contents();
		ob_end_clean();
		// 结果
		return $ct;
	}

}