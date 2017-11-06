<?php

namespace app\modules\admin\controller;

class SystemController extends ControllerBase{
	// 首页
	function indexAction(){
		// 获取菜单
		$menus = $this->getMenus();
		$this->setVar('Menus',$menus);
		// 视图
		$this->setTemplate('main','system/index');
	}
}