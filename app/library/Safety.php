<?php

/**
* 安全验证类
*/

namespace app\library;

class Safety{
	function isRight($name='',$val=''){
		// 正则
		$data['uname'] = "/^[a-zA-Z][a-zA-Z0-9\_\@\-\*\&]{3,15}$/";
		$data['passwd'] = "/^[a-zA-Z][a-zA-Z0-9\_\@\-\*\&]{5,15}$/";
		$data['tel'] = "/^(((13[0-9]{1})|(15[0-9]{1})|(18[0-9]{1}))+\d{8})$/";
		$data['email'] = "/^([a-zA-Z0-9_-])+@([a-zA-Z0-9_-])+(\.[a-zA-Z0-9_-])+/";
		return preg_match($data[$name],$val);
	}
}