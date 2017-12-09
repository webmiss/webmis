<?php

namespace app\modules\admin\controller;

class WelcomeController extends ControllerBase{
	// 首页
	function indexAction(){
		self::redirect('Desktop');
	}
}