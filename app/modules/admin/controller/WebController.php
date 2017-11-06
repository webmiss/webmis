<?php

namespace app\modules\admin\controller;

class WebController extends ControllerBase{
	// 首页
	function indexAction(){
		// 获取菜单
		$menus = $this->getMenus();
		$this->setVar('Menus',$menus);
		// 视图
		$this->setTemplate('main','web/index');
	}
}