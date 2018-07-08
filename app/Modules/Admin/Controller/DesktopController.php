<?php

namespace App\Modules\Admin\Controller;

class DesktopController extends ControllerBase{
	// 首页
	function indexAction(){
		// 获取菜单
		self::setVar('Menus',self::getMenus());
		// 传递参数
		return self::setTemplate('main','desktop/index');
	}
}