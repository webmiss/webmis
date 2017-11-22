<?php

/**
* 安全验证类
*/

namespace app\library;

class Safety{
	static function isRight($name='',$val=''){
		// 正则
		$data = [
			'uname'=>['/^[a-zA-Z][a-zA-Z0-9\_\@\-\*\&]{3,15}$/','英文开头4~16位字符'],
			'passwd'=>['/^[a-zA-Z][a-zA-Z0-9\_\@\-\*\&]{5,15}$/','英文开头6~16位字符'],
			'tel'=>['/^(((13[0-9]{1})|(15[0-9]{1})|(18[0-9]{1}))+\d{8})$/','请输入手机号码'],
			'email'=>['/^([a-zA-Z0-9_-])+@([a-zA-Z0-9_-])+(\.[a-zA-Z0-9_-])+/','请输入邮箱']
		];
		return preg_match($data[$name][0],$val)?true:$data[$name][1];
	}
}