<?php

namespace app\modules\admin\controller;

class WebController extends ControllerBase{
	// 首页
	function indexAction(){
		// 获取菜单
		$menus = self::getMenus();
		self::setVar('Menus',$menus);
		// 视图
		self::setTemplate('main','web/index');
	}
}