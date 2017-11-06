<?php

namespace app\modules\home\controller;

class IndexController extends ControllerBase{
	/* 首页 */
	function indexAction(){
		/* 加载视图 */
		$this->setTemplate('main','index/index');
	}
}
?>