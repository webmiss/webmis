<?php

namespace app\modules\admin\controller;

class  SysConfigController extends ControllerBase{
	private $file = APP.'config.php';
	// 首页
	function indexAction(){

		//配置文件
		$config = require $this->file;
		$this->setVar('Config',array(
			'title'=>array('默认模块','默认控制器','默认方法','是否水印','水印图片','水印位置','水印透明度'),
			'data'=>$config
		));

		// 获取菜单
		$menus = $this->getMenus();
		$this->setVar('Menus',$menus);

		// 传递参数
		$this->setVar('LoadJS', array('system/sys_config.js'));
		$this->setTemplate('main','system/config/index');
	}

	//处理数据
	function DataAction(){
		//是否提交修改
		if($_POST){
			//获取内容
			$ct = file_get_contents($this->file);
			foreach($_POST as $key=>$val){
				$ct = preg_replace("/\t'$key'=>(.*)/","\t'$key'=>'$val',",$ct);
			}
			//写入内容
			if(file_put_contents($this->file,$ct)){
				echo json_encode(array('status'=>'y','url'=>'SysConfig','msg'=>'保存成功！'));
			}else{
				echo json_encode(array('status'=>'n','msg'=>'保存失败！'));
			}
		}
	}
}