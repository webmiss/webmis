<?php

namespace app\modules\admin\controller;

use framework\Controller;
use app\library\Images;

use app\modules\admin\model\SysAdmin;

class IndexController extends Controller{

	/* 首页 */
	function indexAction(){
		return self::view('layouts/login');
	}

	/* 登录 */
	public function loginAction(){
		// 是否有提交
		if(empty($_POST)) return false;
		// 用户信息
		$uname = trim($_POST['uname']);
		$password = md5($_POST['passwd']);
		$vcode = strtolower($_POST['vcode']);
		$remember = $_POST['remember'];
		// 判断验证码
		if($vcode != $_SESSION['V_CODE']) return json_encode(['status'=>'v','msg'=>'验证码错误！']);
		$_SESSION['V_CODE'] = rand(1000,9999);
		// 查询用户
		$info = [
			'where'=>'(uname="'.$uname.'" or tel="'.$uname.'" or email="'.$uname.'") and password="'.$password.'"',
			'field'=>'id,name,department,position,state,perm'
		];
		$data = SysAdmin::findfirst($info);
		// 判断结果
		if(empty($data)) return json_encode(['status'=>'n','msg'=>'用户名或密码错误！']);
		// 是否禁用
		if($data->state!='1') return json_encode(['status'=>'n','msg'=>'该用户已被禁用！']);
		// 记住用户名
		if($remember=='true') setcookie("uname", $uname);
		// 保存SESSION
		$_SESSION['Admin'] = [
			'id'=>$data->id,
			'uname'=>$uname,
			'name'=>$data->name,
			'department'=>$data->department,
			'position'=>$data->position,
			'ltime'=>time()+1800,
			'login'=>TRUE
		];
		// 返回跳转URL
		return json_encode(['status'=>'y','url'=>'welcome']);
	}

	/* 退出 */
	function logoutAction(){
		unset($_SESSION['Admin']);
		self::redirect('Index');
	}

	/* 验证码 */
	function vcodeAction(){
		Images::getCode(90,36);
	}

}