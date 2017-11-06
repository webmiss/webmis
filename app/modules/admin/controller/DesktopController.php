<?php

namespace app\modules\admin\controller;

class DesktopController extends ControllerBase{
	// 首页
	function indexAction(){
		// 获取菜单
		$menus = $this->getMenus();
		$this->setVar('Menus',$menus);
		// 传递参数
		$this->setTemplate('main','desktop/index');
	}
}