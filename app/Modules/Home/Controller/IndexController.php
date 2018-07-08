<?php

namespace App\Modules\Home\Controller;

class IndexController extends ControllerBase{
	/* 首页 */
	function indexAction(){
		/* 加载视图 */
		return $this->setTemplate('main','index/index');
	}
}
