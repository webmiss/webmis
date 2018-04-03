<?php

namespace app\modules\admin\controller;

class SystemController extends ControllerBase{
	// 首页
	function indexAction(){
		// 获取菜单
		$menus = self::getMenus();
		self::setVar('Menus',$menus);
		// 视图
		return self::setTemplate('main','system/index');
	}
}