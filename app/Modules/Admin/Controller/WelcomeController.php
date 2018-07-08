<?php

namespace App\Modules\Admin\Controller;

class WelcomeController extends ControllerBase{
	// 首页
	function indexAction(){
		self::redirect('Desktop');
	}
}