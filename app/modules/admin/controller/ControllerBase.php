<?php

namespace app\modules\admin\controller;

use framework\Controller;

use app\modules\admin\model\SysAdmin;
use app\modules\admin\model\SysMenu;
use app\modules\admin\model\SysMenuAction;

class ControllerBase extends Controller{

	static private $perm = '';
	static private $cid=[];

	/* 构造函数 */
	function __construct(){
		// 是否登录
		$admin = @$_SESSION['Admin'];
		$ltime = $admin['ltime'];
		$ntime = time();
		if(!$admin['logged_in'] || $ltime<$ntime){
			$this->redirect('index/loginOut');
		}else{
			$_SESSION['Admin']['ltime'] = time()+1800;
		}
		// 获取权限
		$perm = SysAdmin::findfirst(['where'=>'id='.$admin['id'],'field'=>'perm']);
		$data = [];
		$arr = explode(' ',$perm->perm);
		foreach($arr as $val){
			$a = explode(':',$val);
			$data[$a[0]] = $a[1];
		}
		// 判断权限
		$mid = SysMenu::findfirst(['where'=>'url="'.CONTROLLER.'"','field'=>'id']);
		if(!isset($data[$mid->id])){
			$this->redirect('index/loginOut');
		}
		// 赋值权限
		self::$perm = $data;
		// 用户信息
		$this->setVar('Uinfo',@$_SESSION['Admin']);
	}

	/* 获取菜单 */
	static function getMenus(){
		// CID
		$C = SysMenu::findfirst(['where'=>'url="'.CONTROLLER.'"','field'=>'id,fid,title']);
		self::$cid[] = $C->id;
		self::getCid($C->fid);
		krsort(self::$cid);
		self::$cid = array_values(self::$cid);
		// 数据
		return [
			'Ctitle'=>$C->title,
			'CID'=>self::$cid,
			// 获取菜单动作
			'action'=>self::actionMenus(self::$perm[end(self::$cid)]),
			'Data'=>self::getMenu()
		];
	}
	// 递归菜单
	static private function getMenu($fid=0){
		$data=[];
		$M = SysMenu::find(['where'=>'fid='.$fid,'field'=>'id,fid,title,url,ico']);
		foreach($M as $val){
			if(isset(self::$perm[$val->id])){
				$val->menus = self::getMenu($val->id);
				$data[] = $val;
			}
		}
		return $data;
	}
	// 动作菜单
	static private function actionMenus($perm=''){
		$data = array();
		// 全部动作菜单
		$aMenus = SysMenuAction::find(['field'=>'name,ico,perm']);
		foreach($aMenus as $val){
			// 匹配权限值
			if(intval($perm)&intval($val->perm)){
				$data[] = array('name'=>$val->name,'ico'=>$val->ico);
			}
		}
		return $data;
	}
	// 递归CID
	static private function getCid($fid){
		if($fid!=0){
			$m = SysMenu::findfirst(['where'=>'id='.$fid,'field'=>'id,fid']);
			self::$cid[] = $m->id;
			self::getCid($m->fid);
		}
	}

}