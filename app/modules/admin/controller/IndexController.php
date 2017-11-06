<?php

namespace app\modules\admin\controller;

use framework\Controller;
use app\library\Images;

use app\modules\admin\model\SysAdmin;

class IndexController extends Controller{

	/* 首页 */
	function indexAction(){
		$this->view('layouts/login');
	}

	/* 登录 */
	public function loginAction(){
		// 是否有提交
		if(!empty($_POST)){
			$uname = trim($_POST['uname']);
			$password = md5($_POST['passwd']);
			$vcode = strtolower($_POST['vcode']);
			$remember = $_POST['remember'];

			// 判断验证码
			if($vcode != $_SESSION['V_CODE']){
				echo json_encode(array('status'=>'v','msg'=>'验证码错误！'));
				return false;
			}else{
				$_SESSION['V_CODE'] = rand(1000,9999);
			}

			// 查询用户
			$info = [
				'where'=>'(uname="'.$uname.'" or tel="'.$uname.'" or email="'.$uname.'") and password="'.$password.'"',
				'field'=>'id,name,department,position,state,perm'
			];
			$data = SysAdmin::findfirst($info);
			// 判断结果
			if(!empty($data)){
				// 是否禁用
				if($data->state=='1'){
					// 记住用户名
					if($remember=='true'){
						setcookie("uname", $uname);
					}
					// 保存用户信息到Session
					$this->_registerSession($data,$uname);
					// 返回跳转URL
					echo json_encode(array('status'=>'y','url'=>'welcome'));
				}else{
					echo json_encode(array('status'=>'n','msg'=>'该用户已被禁用！'));
				}
			}else{
				echo json_encode(array('status'=>'n','msg'=>'用户名或密码错误！'));
			}
		}
	}
	// 保存Session
	private function _registerSession($data,$uname){
		// 保存用户信息
		$_SESSION['Admin'] = array(
			'id'=>$data->id,
			'uname'=>$uname,
			'name'=>$data->name,
			'department'=>$data->department,
			'position'=>$data->position,
			'ltime' => time()+1800,
			'logged_in' => TRUE,
		);
	}

	/* 退出 */
	public function loginOutAction(){
		unset($_SESSION['Admin']);
		$this->redirect('Index');
	}

	/* 验证码 */
	function vcodeAction(){
		// 验证码
		Images::getCode(80,25);
	}

}